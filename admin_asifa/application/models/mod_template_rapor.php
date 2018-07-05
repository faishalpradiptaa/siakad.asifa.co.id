<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_template_rapor extends MY_Model
{
	
	private $template_dir = 'form';
	
	public function getDetail($kode)
	{
		return $this->db
			->where('kode_template', $kode)
			->where('kode_thn_ajaran', THN_AJARAN)
			->where('kode_jenjang', JENJANG)
			->get('tb_akd_rf_template_rapor')
			->row();
	}
	
	function checkIfDataExists($kode_thn_ajaran=false)
	{
		$kode_thn_ajaran = !$kode_thn_ajaran ? THN_AJARAN : $kode_thn_ajaran;
		return ($this->db->select('kode_thn_ajaran')->where('kode_thn_ajaran', $kode_thn_ajaran)->where('kode_jenjang', JENJANG)->get('tb_akd_rf_template_rapor')->num_rows() > 0);
	}
	
	function import($kode_thn_ajaran)
	{
		// cek jika tahun ajaran ada
		$cek = $this->db->where('kode_thn_ajaran', $kode_thn_ajaran)->get('tb_akd_rf_thn_ajaran')->row();
		if(!$cek)
		{
			$this->session->set_flashdata('error', 'Tahun ajaran asal tidak ditemukan');
			return false;
		}
		
		// cek jika data di tahun ajaran tujuan masih ada
		if($this->checkIfDataExists())
		{
			$this->session->set_flashdata('error', 'Data pada tahun ajaran sekarang masih ada, harap kosongkan data terlebih dahulu');
			return false;
		}
		
		// get data di tahun ajaran asal
		$data = $this->db->where('kode_thn_ajaran', $kode_thn_ajaran)->where('kode_jenjang', JENJANG)->get('tb_akd_rf_template_rapor')->result_array();
		$data_point = $this->db->where('kode_thn_ajaran', $kode_thn_ajaran)->where('kode_jenjang', JENJANG)->get('tb_akd_rf_point_rapor')->result_array();
		$data_aspek = $this->db->where('kode_thn_ajaran', $kode_thn_ajaran)->where('kode_jenjang', JENJANG)->get('tb_akd_rf_aspek_rapor')->result_array();
		if(!$data)
		{
			$this->session->set_flashdata('error', 'Data di tahun ajaran asal yang akan anda impor tidak ditemukan');
			return false;
		}
		
		
		// ganti thn ajaran & insert
		foreach($data as $key => $row) $data[$key]['kode_thn_ajaran'] = THN_AJARAN;
		foreach($data_point as $key => $row) $data_point[$key]['kode_thn_ajaran'] = THN_AJARAN;
		foreach($data_aspek as $key => $row) $data_aspek[$key]['kode_thn_ajaran'] = THN_AJARAN;
		
		$this->db->trans_start();
		$this->db->insert_batch('tb_akd_rf_template_rapor', $data);
		$this->db->insert_batch('tb_akd_rf_point_rapor', $data_point);
		$this->db->insert_batch('tb_akd_rf_aspek_rapor', $data_aspek);
		$this->db->trans_complete();
		
		if($this->db->trans_status())
		{
			$this->session->set_flashdata('success', count($data).' data berhasil diimport dari tahun ajaran '.$cek->thn_ajaran.' '.$cek->sem_ajaran);
			return true;
		}
		else
		{
			$this->session->set_flashdata('error', 'Data gagal diimport');
			return false;
		}
		
		
		
	}
	
	/**============== POINT ============== **/
	
	public function getDetailPoint($kode_template, $id)
	{
		$where = array(
			'kode_temp_rapor' => $kode_template,
			'kode_thn_ajaran' => THN_AJARAN,
			'kode_jenjang' => JENJANG,
			'kode_point' => $id,
		);
		return $this->db->where($where)->get('tb_akd_rf_point_rapor')->row();
	}
	
	public function deletePoint($kode_template, $id)
	{
		$where = array(
			'kode_temp_rapor' => $kode_template,
			'kode_thn_ajaran' => THN_AJARAN,
			'kode_jenjang' => JENJANG,
			'kode_point' => $id,
		);
		$res = $this->db->where($where)->delete('tb_akd_rf_point_rapor');
		if(!$res) $this->session->set_flashdata('error','Data gagal dihapus : Error 500');
		return $res;
	}
	
	public function savePoint($kode_template, $id, $data)
	{
		$data['kode_temp_rapor'] = $kode_template;
		$data['kode_thn_ajaran'] = THN_AJARAN;
		$data['kode_jenjang'] = JENJANG;
		if(!$id)
		{
			$data['urutan_point'] = 1000;
			return $this->db->insert('tb_akd_rf_point_rapor', $data);
		}
		else
		{
			$where = array(
				'kode_temp_rapor' => $kode_template,
				'kode_thn_ajaran' => THN_AJARAN,
				'kode_jenjang' => JENJANG,
				'kode_point' => $id,
			);
			return $this->db->where($where)->update('tb_akd_rf_point_rapor', $data);
		}
	}

	public function getTreePoint($kode_template, $is_data=false)
	{
		$where = array(
			'pr.kode_temp_rapor' => $kode_template,
			'pr.kode_thn_ajaran' => THN_AJARAN,
			'pr.kode_jenjang' => JENJANG,
		);
		$data_raw = $this->db
			->select('pr.*, tr.kode_jenis, tr.rumus_ip')
			->join('tb_akd_rf_template_rapor tr', 'tr.kode_template=pr.kode_temp_rapor AND tr.kode_thn_ajaran=pr.kode_thn_ajaran AND tr.kode_jenjang=pr.kode_jenjang')
			->where($where)
			->order_by('pr.urutan_point', 'ASC')
			->get('tb_akd_rf_point_rapor pr')
			->result();
		$data_asal = array();
		$data = array();
		$data_organized = array();
		$exception = array('', '#', 'javascript:;');
		foreach($data_raw as $i => $row) 
		{
			$data_asal[$row->kode_point] = $row;
			if (!$row->induk_point) 
			{
				$data[$row->kode_point] = $row;
				$data_raw[$i] = false;
				unset($data_raw[$i]);
			}
		}
		$html = '<ol class="dd-list">';
		$special = array('mapel','ringkasan_mapel','custom');
		foreach($data as $row) 
		{
			if($is_data)
			{
				$row->child = $this->getChildTreePoint($row, $data_raw, $is_data);
				$data_organized[$row->kode_point] = $row;
			}
			else
			{
				$my_child = trim($this->getChildTreePoint($row, $data_raw, $is_data));
				$opsi = in_array($row->tipe_point, $special) ? '<a href="'.site_url('rfp_aspek_rapor/index/'.my_base64_encode($row->kode_temp_rapor).'/'.my_base64_encode($row->kode_point)).'" data-toggle="modal" data-target="#main-modal-lg" class="btn btn-xs btn-success"><i class="fa fa-wrench"></i> Aspek</a>' : '';
				$html .= '<li class="dd-item" data-id="'.$row->kode_point.'">
					<div class="dd-handle">
						<h4>'.$row->nama_point.'</h4>
						<div class="margin-l-15"><i>'.ucwords($row->tipe_point).'</i></div>
					</div>
					<div class="dd-option">
						'.$opsi.'
						<a href="'.site_url(PAGE_ID.'/form_point/'.my_base64_encode($row->kode_temp_rapor).'/'.my_base64_encode($row->kode_point)).'" data-toggle="modal" data-target="#main-modal-md" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Ubah</a>
						<a href="'.site_url(PAGE_ID.'/delete_point/'.my_base64_encode($row->kode_temp_rapor).'/'.my_base64_encode($row->kode_point)).'" data-toggle="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Hapus</a>
					</div>
					'.$my_child.'
				</li>';
			}
		}
		$html .= '</ol>';
		return $is_data ? $data_organized : $html;
	}
	
	private function getChildTreePoint($induk, &$raw, $is_data=false)
	{
		$data_organized = array();
		$child = '';
		$z = $raw;
		$special = array('mapel','custom');
		if($z) foreach($z as $i => $row) if ($row->induk_point == $induk->kode_point) 
		{
			if($is_data)
			{
				$row->child = $this->getChildTreePoint($row, $raw, $is_data);
				$data_organized[$row->kode_point] = $row;
			}
			else
			{
				$opsi = in_array($row->tipe_point, $special) ? '<a href="'.site_url('rfp_aspek_rapor/index/'.my_base64_encode($row->kode_temp_rapor).'/'.my_base64_encode($row->kode_point)).'" data-toggle="modal" data-target="#main-modal-lg" class="btn btn-xs btn-success"><i class="fa fa-wrench"></i> Aspek</a>' : '';
				$child .= '<li class="dd-item" data-id="'.$row->kode_point.'">
					<div class="dd-handle">
						<h4>'.$row->nama_point.'</h4>
						<div class="margin-l-15"><i>'.ucwords($row->tipe_point).'</i></div>
					</div>
					<div class="dd-option">
						'.$opsi.'
						<a href="'.site_url(PAGE_ID.'/form_point/'.my_base64_encode($row->kode_temp_rapor).'/'.my_base64_encode($row->kode_point)).'" data-toggle="modal" data-target="#main-modal-md" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Ubah</a>
						<a href="'.site_url(PAGE_ID.'/delete_point/'.my_base64_encode($row->kode_temp_rapor).'/'.my_base64_encode($row->kode_point)).'" data-toggle="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Hapus</a>
					</div>';
				unset($raw[$i]);
				$mychild = trim($this->getChildTreePoint($row, $raw));
				$child .= $mychild;
				$child .= '</li>';
			}
		}
		$child = $child ? '<ol class="dd-list">'.$child.'</ol>' : '';
		
		return $is_data ? $data_organized : $child;
	}

	public function sortPoint($kode_template, $data)
	{
		if(!$data) return false;
		
		$fix = array();
		$i = 0;
		// sort data
		foreach($data as $val)
		{
			$fix[$val->id]['urutan_point'] = $i;
			$fix[$val->id]['induk_point'] = null;
			if(isset($val->children)) $this->sortChildPoint($val->id, $val->children, $fix);
			$i++;
		}
		
		// update data
		$where = array(
			'kode_temp_rapor' => $kode_template,
			'kode_thn_ajaran' => THN_AJARAN,
			'kode_jenjang' => JENJANG,
			'kode_point' => false,
		);
		foreach($fix as $key => $val)
		{
			$where['kode_point'] = $key;
			$this->db->where($where)->update('tb_akd_rf_point_rapor', $val);
		}
	}
	
	private function sortChildPoint($induk, $data, &$fix)
	{
		$i = 0;
		foreach($data as $val)
		{
			$fix[$val->id]['induk_point'] = $induk;
			$fix[$val->id]['urutan_point'] = $i;
			if(isset($val->children)) $this->sortChildPoint($val->id, $val->children, $fix);
			$i++;
		}
	}

	
	/**============== GENERATE TEMPLATE FORM ============== **/
	
	public function getTemplateForm($kode_template, $siswa)
	{
		$html = '';
		$points = $this->getTreePoint($kode_template, true);
		$this->template_dir = 'form';
		foreach($points as $point) $html .= $this->generatAllSinglePoint($point, $siswa);
		return $html;
	}
	
	public function getTemplateView($kode_template, $siswa, $view = 'view')
	{
		$html = '';
		$this->template_dir = $view;
		$points = $this->getTreePoint($kode_template, true);
		foreach($points as $point)  $html .= $this->generatAllSinglePoint($point, $siswa);
		return $html;
	}
	
	private function generatAllSinglePoint($point, $siswa)
	{
		$html = '';
		$html .= '<div class="row rapor-point"><div class="col-md-12">';
		$html .= '<h4>'.$point->nama_point.'</h4>';
		switch($point->tipe_point)
		{
			case 'custom' :
				$html .= $this->generatPointCustom($point, $siswa);
			break;
			case 'mapel' :
				$html .= $this->generatPointMapel($point, $siswa);
			break;
			case 'grafik_by_aspek' :
				$html .= $this->generatPointGrafikByAspek($point, $siswa);
			break;
			case 'ringkasan_mapel' :
				$html .= $this->generatPointRingkasanMapel($point, $siswa);
			break;
			case 'ekskul' :
				$html .= $this->generatPointEkskul($point, $siswa);
			break;
			case 'prestasi' :
				$html .= $this->generatPointPrestasi($point, $siswa);
			break;
			case 'ringkasan_riwayat' :
				$html .= $this->generatPointRingkasanRiwayat($point, $siswa);
			break;
			case 'riwayat' :
				$html .= $this->generatPointRiwayat($point, $siswa);
			break;
			case 'deskripsi' :
				$html .= $this->generatPointDeskripsi($point, $siswa);
			break;
		}
		$html .= '</div></div>';
		
		if($point->child) 
		{
			$html .= '<div class="margin-l-20">';
			foreach($point->child as $child) $html .= $this->generatAllSinglePoint($child, $siswa);
			$html .= '</div>';
		}
		return $html;
	}
	
	private function generatPointCustom($point, $siswa)
	{
		$where = array(
			'kode_thn_ajaran' => THN_AJARAN,
			'kode_jenjang' => JENJANG,
			'kode_temp_rapor' => $point->kode_temp_rapor,
			'kode_point' => $point->kode_point,
		);
		$aspek = $this->db->where($where)->get('tb_akd_rf_aspek_rapor')->result();
		
		$where['no_induk'] = $siswa->no_induk;
		$data = array();
		$data_raw = $this->db->where($where)->get('tb_akd_tr_nilai_custom')->result();
		foreach($data_raw as $row) $data[$row->kode_aspek] = $row;
		
		$pack = array(
			'point' => $point,
			'aspek' => $aspek,
			'data' => $data,
		);
		return $this->load->view('template/rapor/'.$this->template_dir.'/form-custom', $pack, true);
		
	}

	private function generatPointMapel($point, $siswa)
	{
		$query = "SELECT
			mp.*,	
			km.nama_kelompok,
			km.jenis_kelompok
		FROM
			tb_akd_tr_ambil_mp am
		JOIN
			tb_akd_rf_mp mp ON am.kode_mp=mp.kode_mp AND am.kode_thn_ajaran=mp.kode_thn_ajaran AND am.kode_jenjang=mp.kode_jenjang
		JOIN
			tb_akd_rf_kelompok_mp km ON mp.kode_kelompok=km.kode_kelompok AND km.kode_thn_ajaran=mp.kode_thn_ajaran AND km.kode_jenjang=mp.kode_jenjang
		WHERE
			am.id_ambil_kelas = '".$siswa->id_ambil_kelas."'
			AND km.kode_jenis_rapor = '".$point->kode_jenis."'
			AND am.kode_thn_ajaran = '".THN_AJARAN."'
			AND am.kode_jenjang = '".JENJANG."'
		ORDER BY
			km.urutan ASC, mp.urutan ASC";
		$mapel_raw = $this->db->query($query)->result();
		$mapel_org = array();
		foreach($mapel_raw as $row)
		{
			if(!isset($mapel_org[$row->kode_kelompok]))
			{
				$mapel_org[$row->kode_kelompok] = (object)array(
					'kode' => $row->kode_kelompok,
					'nama' => $row->nama_kelompok,
					'jenis' => $row->jenis_kelompok,
					'mapel' => array(),
				);
			}
			if ($mapel_org[$row->kode_kelompok]->jenis == 'umum' || $row->kode_jurusan == $siswa->kode_jurusan) 
			{
				$mapel_org[$row->kode_kelompok]->mapel[] = $row;
			}
			else
			{
				$kode_lintas_minat = 'KLM';
				if(!isset($mapel_org[$kode_lintas_minat]))
				{
					$mapel_org[$kode_lintas_minat] = (object)array(
						'kode' => $kode_lintas_minat,
						'nama' => 'Lintas Minat',
						'jenis' => 'lintas minat',
						'mapel' => array(),
					);
				}
				$mapel_org[$kode_lintas_minat]->mapel[] = $row;
			}
		}
		
		$query = "SELECT
			n.*, ar.tipe, p.grade, p.deskriptif, d.deskripsi
		FROM
			tb_akd_tr_nilai_mp n
		LEFT JOIN
			tb_akd_rf_aspek_rapor ar ON ar.kode_thn_ajaran=n.kode_thn_ajaran AND ar.kode_jenjang=n.kode_jenjang AND ar.kode_temp_rapor=n.kode_temp_rapor AND ar.kode_aspek=n.kode_aspek
		LEFT JOIN
			tb_akd_rf_deskripsi_mp d ON n.kode_thn_ajaran=d.kode_thn_ajaran AND n.kode_jenjang=d.kode_jenjang AND n.kode_mp=d.kode_mp
		LEFT JOIN
			tb_akd_rf_predikat_detail p ON ar.id_predikat=p.id_predikat AND n.nilai >= p.minimal AND n.nilai < p.maksimal
		WHERE
			n.kode_thn_ajaran = '".THN_AJARAN."'
			AND n.kode_jenjang = '".JENJANG."'
			AND n.kode_temp_rapor = '".$point->kode_temp_rapor."'
			AND n.kode_point = '". $point->kode_point."'
			AND n.no_induk = '".$siswa->no_induk."'
		GROUP BY
			n.kode_thn_ajaran, n.kode_jenjang, n.kode_temp_rapor, n.kode_point, n.no_induk, n.kode_aspek, n.kode_mp";

		$data = array();
		$data_raw = $this->db->query($query)->result();
		foreach($data_raw as $row) $data[$row->kode_mp][$row->kode_aspek] = $row;
		
		
		$query = "SELECT
			ar.*, MIN(pd.minimal) as minimal, MAX(pd.maksimal) maksimal
		FROM
			tb_akd_rf_aspek_rapor ar
		LEFT JOIN
			tb_akd_rf_predikat_detail pd ON pd.id_predikat=ar.id_predikat
		WHERE
			kode_thn_ajaran = '".THN_AJARAN."'
			AND kode_jenjang = '".JENJANG."'
			AND kode_point = '".$point->kode_point."'
			AND kode_temp_rapor = '".$point->kode_temp_rapor."'
		GROUP BY
			ar.kode_aspek
		ORDER BY
			ar.urutan ASC";
	
		$pack = array(
			'point' => $point,
			'aspek' => $this->db->query($query)->result(),
			'mapel' => $mapel_org,
			'data' => $data,
		);
		return $this->load->view('template/rapor/'.$this->template_dir.'/form-mapel', $pack, true);
	}

	private function generatPointRingkasanMapel($point, $siswa)
	{
		// get kelompok
		$query = "SELECT
			km.*
		FROM
			tb_akd_tr_ambil_mp am
		JOIN
			tb_akd_rf_mp mp ON am.kode_mp=mp.kode_mp AND am.kode_thn_ajaran=mp.kode_thn_ajaran AND am.kode_jenjang=mp.kode_jenjang
		JOIN
			tb_akd_rf_kelompok_mp km ON mp.kode_kelompok=km.kode_kelompok AND km.kode_thn_ajaran=mp.kode_thn_ajaran AND km.kode_jenjang=mp.kode_jenjang
		WHERE
			am.id_ambil_kelas = '".$siswa->id_ambil_kelas."'
			AND km.kode_jenis_rapor = '".$point->kode_jenis."'
			AND am.kode_thn_ajaran = '".THN_AJARAN."'
			AND am.kode_jenjang = '".JENJANG."'
		GROUP BY
			km.kode_kelompok
		ORDER BY
			km.urutan ASC, mp.urutan ASC";
		$mapel_raw = $this->db->query($query)->result();
		$mapel_org = array();
		foreach($mapel_raw as $row)
		{
			if(!isset($mapel_org[$row->kode_kelompok]))
			{
				$mapel_org[$row->kode_kelompok] = (object)array(
					'kode' => $row->kode_kelompok,
					'nama' => $row->nama_kelompok,
					'jenis' => $row->jenis_kelompok,
				);
			}
			else
			{
				$kode_lintas_minat = 'KLM';
				if(!isset($mapel_org[$kode_lintas_minat]))
				{
					$mapel_org[$kode_lintas_minat] = (object)array(
						'kode' => $kode_lintas_minat,
						'nama' => 'Lintas Minat',
						'jenis' => 'lintas minat',
					);
				}
			}
		}
		
		// get rata2 nilai
		$query = "SELECT
			n.*, ar.tipe, m.kode_kelompok, AVG(n.nilai) as rata2
		FROM
			tb_akd_tr_nilai_mp n
		LEFT JOIN
			tb_akd_rf_aspek_rapor ar ON ar.kode_thn_ajaran=n.kode_thn_ajaran AND ar.kode_jenjang=n.kode_jenjang AND ar.kode_temp_rapor=n.kode_temp_rapor AND ar.kode_aspek=n.kode_aspek
		LEFT JOIN
			tb_akd_rf_mp m ON  m.kode_thn_ajaran=n.kode_thn_ajaran AND m.kode_jenjang=n.kode_jenjang AND m.kode_mp=n.kode_mp
		WHERE
			n.kode_thn_ajaran = '".THN_AJARAN."'
			AND n.kode_jenjang = '".JENJANG."'
			AND n.kode_temp_rapor = '".$point->kode_temp_rapor."'
			AND n.no_induk = '".$siswa->no_induk."'
		GROUP BY
			m.kode_kelompok";
		$rata = array();
		$data_raw = $this->db->query($query)->result();
		foreach($data_raw as $row) $rata[$row->kode_kelompok] = $row;
		
		// get nilai aspek
		$query = "SELECT
			n.*, ar.tipe, p.grade, p.deskriptif
		FROM
			tb_akd_tr_nilai_ringkasan_mp n
		LEFT JOIN
			tb_akd_rf_aspek_rapor ar ON ar.kode_thn_ajaran=n.kode_thn_ajaran AND ar.kode_jenjang=n.kode_jenjang AND ar.kode_temp_rapor=n.kode_temp_rapor AND ar.kode_aspek=n.kode_aspek
		LEFT JOIN
			tb_akd_rf_predikat_detail p ON ar.id_predikat=p.id_predikat AND n.nilai >= p.minimal AND n.nilai < p.maksimal
		WHERE
			n.kode_thn_ajaran = '".THN_AJARAN."'
			AND n.kode_jenjang = '".JENJANG."'
			AND n.kode_temp_rapor = '".$point->kode_temp_rapor."'
			AND n.kode_point = '". $point->kode_point."'
			AND n.no_induk = '".$siswa->no_induk."'
		GROUP BY
			n.kode_thn_ajaran, n.kode_jenjang, n.kode_temp_rapor, n.kode_point, n.no_induk, n.kode_aspek, n.kode_kel_mp";
		$data = array();
		$data_raw = $this->db->query($query)->result();
		foreach($data_raw as $row) $data[$row->kode_kel_mp][$row->kode_aspek] = $row;
		
		// get aspek
		$query = "SELECT
			ar.*, MIN(pd.minimal) as minimal, MAX(pd.maksimal) maksimal
		FROM
			tb_akd_rf_aspek_rapor ar
		LEFT JOIN
			tb_akd_rf_predikat_detail pd ON pd.id_predikat=ar.id_predikat
		WHERE
			kode_thn_ajaran = '".THN_AJARAN."'
			AND kode_jenjang = '".JENJANG."'
			AND kode_point = '".$point->kode_point."'
			AND kode_temp_rapor = '".$point->kode_temp_rapor."'
		GROUP BY
			ar.kode_aspek
		ORDER BY
			ar.urutan ASC";
		
		$pack = array(
			'point' => $point,
			'aspek' => $this->db->query($query)->result(),
			'mapel' => $mapel_org,
			'rata' => $rata,
			'data' => $data,
		);
		return $this->load->view('template/rapor/'.$this->template_dir.'/form-ringkasan_mapel', $pack, true);
	}

	private function generatPointRiwayat($point, $siswa)
	{
		$param = $point->param_point ? json_decode($point->param_point) : false;
		if($param  && isset($param->riwayat))
		{
			$param = array_values((array)$param->riwayat);
			if($param) $this->db->where_in('ja.kode_jenis', $param);
		}
		$riwayat = array();
		$data = $this->db
			->select('a.*, ja.nama_jenis, ja.kode_jenis')
			->join('tb_akd_tr_riwayat a', 'ja.kode_jenis=a.kode_jenis_riwayat AND no_induk="'.$siswa->no_induk.'" AND kode_thn_ajaran="'.THN_AJARAN.'" AND kode_jenjang="'.JENJANG.'" ', 'left')
			->order_by('ja.kode_jenis', 'ASC')
			->order_by('a.tgl', 'ASC')
			->get('tb_akd_rf_jenis_riwayat ja')
			->result();
		foreach($data as $row)
		{
			if(!isset($riwayat[$row->kode_jenis]))
			{
				$riwayat[$row->kode_jenis] = (object)array(
					'kode_jenis' => $row->kode_jenis,
					'nama_jenis' => $row->nama_jenis,
					'data' => array(),					
				);
			}
			$riwayat[$row->kode_jenis]->data[] = $row;
		}
		
		$pack = array(
			'point' => $point,
			'riwayat' => $riwayat,
		);
		return $this->load->view('template/rapor/'.$this->template_dir.'/form-riwayat', $pack, true);
	}
	
	private function generatPointRingkasanRiwayat($point, $siswa)
	{
		$param = $point->param_point ? json_decode($point->param_point) : false;
		if($param  && isset($param->riwayat))
		{
			$param = array_values((array)$param->riwayat);
			if($param) $this->db->where_in('ja.kode_jenis', $param);
		}
		$riwayat = $this->db
			->select('a.*, ja.nama_jenis, COUNT(a.tgl) as jumlah')
			->join('tb_akd_tr_riwayat a', 'ja.kode_jenis=a.kode_jenis_riwayat AND no_induk="'.$siswa->no_induk.'" AND kode_thn_ajaran="'.THN_AJARAN.'" AND kode_jenjang="'.JENJANG.'" ', 'left')
			->group_by('ja.kode_jenis')
			->get('tb_akd_rf_jenis_riwayat ja')
			->result();
		
		$pack = array(
			'point' => $point,
			'riwayat' => $riwayat,
		);
		return $this->load->view('template/rapor/'.$this->template_dir.'/form-ringkasan_riwayat', $pack, true);
	}

	private function generatPointEkskul($point, $siswa)
	{
		$where = array(
			'kode_thn_ajaran' => THN_AJARAN,
			'kode_jenjang' => JENJANG,
			'no_induk' => $siswa->no_induk,
		);
		
		$pack = array(
			'point' => $point,
			'ekskul' => $this->db->get('tb_akd_rf_ekskul')->result(),
			'data_ekskul' => $this->db->where($where)->get('tb_akd_tr_nilai_ekskul')->result(),
		);
		return $this->load->view('template/rapor/'.$this->template_dir.'/form-ekskul', $pack, true);
	}
	
	private function generatPointPrestasi($point, $siswa)
	{
		$where = array(
			'kode_thn_ajaran' => THN_AJARAN,
			'kode_jenjang' => JENJANG,
			'no_induk' => $siswa->no_induk,
		);
		
		$pack = array(
			'point' => $point,
			'prestasi' => $this->db->where($where)->get('tb_akd_tr_nilai_prestasi')->result(),
		);
		return $this->load->view('template/rapor/'.$this->template_dir.'/form-prestasi', $pack, true);
	}

	private function generatPointDeskripsi($point, $siswa)
	{
		$enc_kode_point = my_base64_encode($point->kode_point);
		$where = array(
			'kode_thn_ajaran' => THN_AJARAN,
			'kode_jenjang' => JENJANG,
			'no_induk' => $siswa->no_induk,
			'kode_temp_rapor' => $point->kode_temp_rapor,
			'kode_point' => $point->kode_point,
		);
		$data = $this->db->where($where)->get('tb_akd_tr_nilai_deskripsi')->row();
		return '<textarea class="form-control" rows="5" name="deskripsi['.$enc_kode_point.']">'.$data->deskripsi.'</textarea>';
	}

	private function generatPointGrafikByAspek($point, $siswa)
	{
		
		// get param 
		$where = array();
		$param = $point->param_point ? json_decode($point->param_point) : false;
		if($param  && isset($param->grafik_by_aspek))
		{
			$param = array_values((array)$param->grafik_by_aspek);
			$where[] = $param;
		}
		if(!$where) return false;
		$where = '(\''.implode('\',\'',$param).'\')';
		
		// get nama mapel
		$query = "SELECT
			mp.*,	
			km.nama_kelompok,
			km.jenis_kelompok
		FROM
			tb_akd_rf_mp mp
		JOIN
			tb_akd_rf_kelompok_mp km ON mp.kode_kelompok=km.kode_kelompok AND km.kode_thn_ajaran=mp.kode_thn_ajaran AND km.kode_jenjang=mp.kode_jenjang
		WHERE
			mp.kode_mp IN $where
			AND mp.kode_thn_ajaran = '".THN_AJARAN."'
			AND mp.kode_jenjang = '".JENJANG."'
		ORDER BY
			km.urutan ASC, mp.urutan ASC";
		$mapel = array();
		$mapel_raw = $this->db->query($query)->result();
		foreach($mapel_raw as $row)
		{
			$mapel[$row->kode_mp] = $row;
		}
		
		
		// get aspek beserta nilai nya
		$query = "SELECT
			n.*, a.nama_aspek, a.nama_alternatif
		FROM
			tb_akd_tr_nilai_mp n
		LEFT JOIN
			tb_akd_rf_aspek_rapor a 
			ON 
				n.kode_thn_ajaran=a.kode_thn_ajaran 
				AND n.kode_jenjang=a.kode_jenjang 
				AND n.kode_temp_rapor=a.kode_temp_rapor 
				AND n.kode_point=a.kode_point
				AND n.kode_aspek=a.kode_aspek
		WHERE
			n.kode_mp IN $where
			AND n.no_induk = '".$siswa->no_induk."'
		ORDER BY
			n.kode_mp, n.kode_aspek ASC";
		$data = array();
		$data_graph = array();
		$data_raw = $this->db->query($query)->result();
		foreach($data_raw as $row)
		{
			$nama_aspek = $row->nama_alternatif ? $row->nama_alternatif : $row->nama_aspek;
			$data_graph[my_base64_encode($row->kode_mp)][] = array($nama_aspek, $row->nilai);
			$data[$row->kode_mp][$row->kode_aspek] = $row;
		}
		
		$pack = array(
			'point' => $point,
			'mapel' => $mapel,
			'data' => $data,
			'data_graph' => $data_graph,
		);
		
		return $this->load->view('template/rapor/'.$this->template_dir.'/form-grafik_by_aspek', $pack, true); 
	}

	
}