<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_rapor extends MY_Model
{
	public function getPropertyRapor($kode_template, $id_ambil_kelas)
	{
		$where = array(
			'id_ambil_kelas' => $id_ambil_kelas,
			'kode_thn_ajaran' => THN_AJARAN,
			'kode_jenjang' => JENJANG,
			'kode_temp_rapor' => $kode_template,
		);
		return $this->db->where($where)->get('tb_akd_tr_rapor')->row();
	}
	
	public function save($kode_template, $id_ambil_kelas, $data)
	{
		$data = (object)$data;
		//dump($data);
		$siswa = $this->db
			->select('ak.*, sw.no_induk, sk.nama_sekolah, kl.nama_kelas, kl.no_induk_guru, sk.kepsek, sk.nip_kepsek')
			->join('tb_akd_rf_siswa sw', 'sw.no_induk=ak.no_induk')
			->join('tb_akd_rf_sekolah sk', 'sk.kode_sekolah = ak.kode_sekolah AND sk.jenjang=ak.kode_jenjang', 'left')
			->join('tb_akd_rf_kelas kl', 'kl.kode_kelas = ak.kode_kelas AND kl.kode_thn_ajaran=ak.kode_thn_ajaran AND kl.kode_jenjang=ak.kode_jenjang')
			->where('ak.kode_thn_ajaran', THN_AJARAN)
			->where('ak.kode_jenjang', JENJANG)
			->where('ak.id_ambil_kelas', $id_ambil_kelas)
			->get('tb_akd_tr_ambil_kelas ak')
			->row();	
		$template = $this->db->where('kode_template', $kode_template)->get('tb_akd_rf_template_rapor')->row();
		
		$this->db->trans_start();
		$main_where = array(
			'no_induk' => $siswa->no_induk,
			'kode_thn_ajaran' => THN_AJARAN,
			'kode_jenjang' => JENJANG,
		);
		$submain_where = $main_where;
		$submain_where['kode_temp_rapor'] = $kode_template;
		
		/**============== SIMPAN NILAI DESKRIPSI  ============== **/
		$send = array();
		$this->db->where($submain_where)->delete('tb_akd_tr_nilai_deskripsi');
		if(is_array($data->deskripsi)) foreach($data->deskripsi as $enc_kode_point => $val)
		{
			$temp = $submain_where;
			$temp['kode_point'] = base64_decode($enc_kode_point);
			$temp['deskripsi'] = $val;
			$send[] = $temp;
		}
		if($send) $this->db->insert_batch('tb_akd_tr_nilai_deskripsi', $send);
		
		
		/**============== SIMPAN NILAI PRESTASI  ============== **/
		$send = array();
		$this->db->where($main_where)->delete('tb_akd_tr_nilai_prestasi');
		if(is_array($data->prestasi)) foreach($data->prestasi as $val)
		{
			$temp = $main_where;
			$temp['jenis'] = $val['jenis'];
			$temp['keterangan'] = $val['keterangan'];
			$send[] = $temp;
		}
		if($send) $this->db->insert_batch('tb_akd_tr_nilai_prestasi', $send);
		
		
		/**============== SIMPAN NILAI EKSKUL  ============== **/
		$send = array();
		$this->db->where($main_where)->delete('tb_akd_tr_nilai_ekskul');
		if(is_array($data->ekskul)) foreach($data->ekskul as $val)
		{
			$temp = $main_where;
			$temp['kode_ekskul'] = $val['kode_ekskul'];
			$temp['keterangan'] = $val['keterangan'];
			$send[] = $temp;
		}
		if($send) $this->db->insert_batch('tb_akd_tr_nilai_ekskul', $send);
		
		
		/**============== SIMPAN NILAI CUSTOM  ============== **/
		$send = array();
		$this->db->where($submain_where)->delete('tb_akd_tr_nilai_custom');
		if(is_array($data->custom)) foreach($data->custom as $enc_kode_point => $row)
		{
			$temp = $submain_where;
			$temp['kode_point'] = base64_decode($enc_kode_point);
			foreach($row as $enc_kode_aspek => $val) if ($val)
			{
				$temp['kode_aspek'] = base64_decode($enc_kode_aspek);
				$temp['nilai'] = $val;
				$send[] = $temp;
			}
		}
		if($send) $this->db->insert_batch('tb_akd_tr_nilai_custom', $send);
		
		
		/**============== SIMPAN NILAI MAPEL  ============== **/
		$send = array();
		$this->db->where($submain_where)->delete('tb_akd_tr_nilai_mp');
		if(is_array($data->mapel)) foreach($data->mapel as $enc_kode_mapel => $point)
		{
			$temp = $submain_where;
			$temp['kode_mp'] = base64_decode($enc_kode_mapel);
			if(is_array($point)) foreach($point as $enc_kode_point => $row)
			{
				$temp['kode_point'] = base64_decode($enc_kode_point);
				foreach($row as $enc_kode_aspek => $val) if ($val != '' && $val != null)
				{
					$temp['kode_aspek'] = base64_decode($enc_kode_aspek);
					$temp['nilai'] = $val;
					$send[] = $temp;
				}
			}
		}
		if($send) $this->db->insert_batch('tb_akd_tr_nilai_mp', $send);

		/**============== SIMPAN NILAI RINGKASAN MAPEL  ============== **/
		$send = array();
		$this->db->where($submain_where)->delete('tb_akd_tr_nilai_ringkasan_mp');
		if(is_array($data->ringkasan_mapel)) foreach($data->ringkasan_mapel as $enc_kode_kel_mapel => $point)
		{
			$temp = $submain_where;
			$temp['kode_kel_mp'] = base64_decode($enc_kode_kel_mapel);
			if(is_array($point)) foreach($point as $enc_kode_point => $row)
			{
				$temp['kode_point'] = base64_decode($enc_kode_point);
				foreach($row as $enc_kode_aspek => $val) if ($val != '' && $val != null)
				{
					$temp['kode_aspek'] = base64_decode($enc_kode_aspek);
					$temp['nilai'] = $val;
					$send[] = $temp;
				}
			}
		}
		if($send) $this->db->insert_batch('tb_akd_tr_nilai_ringkasan_mp', $send);
		
		
		/**============== SIMPAN DATA RAPOR  ============== **/
		$cek = $this->db->where($submain_where)->get('tb_akd_tr_rapor')->row();
		$send = array(
			'id_ambil_kelas' => $siswa->id_ambil_kelas,
			'tempat_publish' => 'Malang',
			'tgl_publish' => dateInd2dateMySQL($data->data['tgl_publish']),
			'kode_guru_pembimbing' => $siswa->no_induk_guru,
			'nama_kepsek' => $siswa->kepsek,
			'nip_kepsek' => $siswa->nip_kepsek,
			'status' => isset($data->data['status']) ? $data->data['status'] : 'invalid',
			'modified_date' => date('Y-m-d H:i:s'),
		);
		if(isset($data->data['nama_ttd_1'])) $send['nama_ttd_1'] = $data->data['nama_ttd_1'];
		if(isset($data->data['nama_ttd_2'])) $send['nama_ttd_2'] = $data->data['nama_ttd_2'];
		
		$send = array_merge($submain_where, $send);
		if($cek)
		{
			$send['created_date'] = date('Y-m-d H:i:s');
			$this->db->where($submain_where)->update('tb_akd_tr_rapor', $send);
		}
		else
		{
			$this->db->insert('tb_akd_tr_rapor', $send);
		}
		
		$this->db->trans_complete();
		$res = $this->db->trans_status();
		
		if ($res) $this->calculateSingleIPSmt($kode_template, $siswa->no_induk);
		if ($res) $this->session->set_flashdata('success', 'Data rapor berhasil disimpan');
		else $this->session->set_flashdata('error', 'Data rapor gagal disimpan');
		return $res;
		
	}
	
	public function calculateSingleIPSmt($kode_template, $no_induk)
	{
		$main_where = array(
			'm.kode_thn_ajaran' => THN_AJARAN,
			'm.kode_jenjang' => JENJANG,
		);
		
		// get rumus IP
		$template = $this->db
			->where($main_where)
			->where('kode_template', $kode_template)
			->get('tb_akd_rf_template_rapor m')
			->row();
		if(!$template || !$template->rumus_ip) return true;
		
		// get aspek
		$aspek = $this->db
			->select('m.*')
			->where($main_where)
			->where('m.kode_temp_rapor', $kode_template)
			->where('p.tipe_point', 'mapel')
			->join('tb_akd_rf_point_rapor p', 'm.kode_thn_ajaran=p.kode_thn_ajaran AND m.kode_jenjang=p.kode_jenjang AND m.kode_temp_rapor=p.kode_temp_rapor AND m.kode_point=p.kode_point')
			->order_by('urutan', 'ASC')
			->get('tb_akd_rf_aspek_rapor m')
			->result();
		if(!$aspek) return false;
		
		// get nilai
		$where = array();
		$where_mapel = array();
		$nilai_org = array();
		foreach ($aspek as $row) $where[] = $row->kode_aspek;
		$nilai = $this->db
			->where('no_induk', $no_induk)
			->where($main_where)
			->where('kode_temp_rapor', $kode_template)
			->where_in('kode_aspek', $where)
			->get('tb_akd_tr_nilai_mp m')
			->result();		
		foreach($nilai as $row)
		{
			$where_mapel[$row->kode_mp] = $row->kode_mp;
			$nilai_org[$row->kode_mp][$row->kode_aspek] = $row->nilai;
		}
		
		//get SKS & KKM		
		$mapel = $this->db
			->select('kode_mp, sks, kkm')
			->where($main_where)
			->where_in('kode_mp', $where_mapel)
			->get('tb_akd_rf_mp m')
			->result();
			
		// calculate nilai & total
		$SUM = array();
		$AVG = array();
		foreach($mapel as $row)
		{
			$nilai_org[$row->kode_mp]['SKS'] = $row->sks;
			$nilai_org[$row->kode_mp]['KKM'] = $row->kkm;
			foreach($aspek as $asp) if(!isset($nilai_org[$row->kode_mp][$asp->kode_aspek]) && $asp->tipe == 'rumus')
			{
				$rumus = str_replace(array_keys($nilai_org[$row->kode_mp]), array_values($nilai_org[$row->kode_mp]), $asp->rumus);
				$rumus = '$hasil = '.$rumus.';';
				eval($rumus);
				$nilai_org[$row->kode_mp][$asp->kode_aspek] = $hasil;
			}
			
			foreach($nilai_org[$row->kode_mp] as $key=>$val)
			{
				$SUM[$key] = !isset($SUM[$key]) ? $val : $SUM[$key] + $val;				
			}
		}
		foreach($SUM as $key=>$val) $AVG[$key] = $val / count($mapel);
		
		// calculate rumus IP
		$rumus = $template->rumus_ip;
		$find = array('/SUM\(([^)]*)\)/', '/AVG\(([^)]*)\)/');
		$replace = array('$SUM[\'$1\']', '$AVG[\'$1\']');
		$rumus = preg_replace($find, $replace, $rumus);
		$rumus = '$hasil = '.$rumus.';';
		eval($rumus);
		
		// update rapor
		$res = false;
		if($hasil)
		{
			$send['ips'] = $hasil;
			$res = $this->db
				->where($main_where)
				->where('no_induk', $no_induk)
				->where('kode_temp_rapor', $kode_template)
				->update('tb_akd_tr_rapor m', array('ips' => $hasil));
		}
		return $res;
		
	}
}