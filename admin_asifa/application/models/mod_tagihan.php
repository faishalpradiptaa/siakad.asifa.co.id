<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_tagihan extends MY_Model
{
	public function createTagihanFromPOST()
	{
		$data = (object)array();
		foreach($_POST as $key=>$val) if(substr($key,0,3)=='in_') $data->$key = $val;
		
		$siswa = array();
		$siswa_skip_nominal = array();
		$siswa_skip_exists = array();
		$siswa_proses = array();
		
		$tahun = false;
		$kode_jenis_bayar = $data->in_jenis_bayar;
		$jenis_bayar = $this->db->where('kode_jenis', $kode_jenis_bayar)->get('tb_keu_rf_jenis_pembayaran')->row();
		if($data->in_bulan) $data->in_bulan = dateInd2dateMySQL('01/'.$data->in_bulan);
		
		//get data siswa & nominal
		$on = 't.no_induk=s.no_induk AND t.kode_jenis="'.$kode_jenis_bayar.'" ';
		switch($jenis_bayar->tipe_jenis)
		{
			case 'per_bulan':
				$on .= 'AND t.bulan_tagih="'.$data->in_bulan.'" ';
			break;
			case 'per_semester':
				$on .= 'AND t.thn_ajaran_tagih="'.$data->in_semester.'" ';
			break;
			case 'per_thn_ajaran':
				$on .= '';
			break;
		}
		
		// join untuk cari data yg sama
		if(isset($data->in_skip_exists) && $data->in_skip_exists) 
		{
			if($jenis_bayar->tipe_jenis == 'per_thn_ajaran') 
			{
				$tahun = $this->db
					->where('kode_thn_ajaran', $data->in_thn_ajaran)
					->get('tb_akd_rf_thn_ajaran')
					->row();
				
				$this->db->_protect_identifiers = false;
				$this->db
					->select('s.no_induk, s.nama, s.angkatan, n.nominal, SUM(COALESCE(t.nominal)) AS tagihan')
					->join('tb_akd_rf_thn_ajaran ta', 'ta.thn_ajaran = "'.$tahun->thn_ajaran.'"', 'left', false)
					->join('tb_keu_tr_tagihan t', $on.' AND ta.kode_thn_ajaran=t.thn_ajaran_tagih', 'left');
			}
			else
			{
				$this->db
					->select('s.no_induk, s.nama, s.angkatan, n.nominal, t.nominal as tagihan')
					->join('tb_keu_tr_tagihan t', $on, 'left');
			}
		}
		else
		{
			$this->db->select('s.no_induk, s.nama, s.angkatan, n.nominal');
		}
			
		switch($data->in_source)
		{
			case 'semua':
				$siswa = $this->db
					->join('tb_keu_rf_nominal n', 'n.no_induk=s.no_induk AND n.kode_jenis="'.$kode_jenis_bayar.'"', 'left')
					->where('s.status_akademis','valid')
					->group_by('s.no_induk')
					->get('tb_akd_rf_siswa s')
					->result();
			break;
			case 'kelas':
				$siswa = $this->db
					->join('tb_akd_tr_ambil_kelas ak', 'ak.no_induk=s.no_induk AND ak.kode_kelas="'.$data->in_kelas.'"')
					->join('tb_keu_rf_nominal n', 'n.no_induk=s.no_induk AND n.kode_jenis="'.$kode_jenis_bayar.'"', 'left')
					->where('s.status_akademis','valid')
					->group_by('s.no_induk')
					->get('tb_akd_rf_siswa s')
					->result();
			break;
			case 'angkatan':
				$siswa = $this->db
					->join('tb_keu_rf_nominal n', 'n.no_induk=s.no_induk AND n.kode_jenis="'.$kode_jenis_bayar.'"', 'left')
					->where('s.angkatan', $data->in_angkatan)
					->where('s.status_akademis','valid')
					->group_by('s.no_induk')
					->get('tb_akd_rf_siswa s')
					->result();
			break;
			case 'siswa':
				$siswa = $this->db
					->join('tb_keu_rf_nominal n', 'n.no_induk=s.no_induk AND n.kode_jenis="'.$kode_jenis_bayar.'"', 'left')
					->where('s.no_induk', $data->in_siswa)
					->where('s.status_akademis','valid')
					->group_by('s.no_induk')
					->get('tb_akd_rf_siswa s')
					->result();
			break;
		}
		$this->db->_protect_identifiers = true;
		
		foreach($siswa as $i => $row)
		{
			//check for data tagihan already exists & skip it
			if(isset($data->in_skip_exists) && $data->in_skip_exists && $row->tagihan) 
			{
				$siswa_skip_exists[] = $row;
				continue;
			}
			
			// jika nominal kosong maka lewati
			$nominal = $data->in_nominal ? $data->in_nominal : $row->nominal;
			if(!$nominal)
			{
				$siswa_skip_nominal[] = $row;
				continue;
			}
			
			$siswa_proses[] = array(
				'kode_tagihan' => 'TG-'.date('ymdHis').$i,
				'no_induk' => $row->no_induk,
				'bulan_tagih' => $jenis_bayar->tipe_jenis == 'per_bulan' ? $data->in_bulan : null,
				'thn_ajaran_tagih' => $jenis_bayar->tipe_jenis == 'per_semester' ? $data->in_semester : ($jenis_bayar->tipe_jenis == 'per_thn_ajaran' ? $data->in_thn_ajaran : null),
				'kode_jenis' => $kode_jenis_bayar,
				'nominal' => $nominal,
				'status_tagihan' => 'Belum Lunas',
				'keterangan' => $data->in_keterangan ? $data->in_keterangan : null,
			);
		}
		
		//insert data
		$res = $siswa_proses ? $this->db->insert_batch('tb_keu_tr_tagihan', $siswa_proses) : true;
		
		if($res)
		{
			return json_encode(array('status' => true, 'text' => count($siswa_proses).' Data berhasil dismpan,<br> '.count($siswa_skip_exists).' Data dilewati karena sudah ada,<br> '.count($siswa_skip_nominal).' Data dilewati karena nominal belum di set.'));
		}
		else
		{
			return json_encode(array('status' => false, 'text' => 'Data gagal disimpan'));
		}
		
		
		
	}
	
	public function getMainQuery($where='')
	{
		if($where) $where = "WHERE $where";
		$query = "SELECT
			tagih.*, s.nama as nama_siswa
		FROM
		(
			SELECT
				t.kode_tagihan, 
				t.no_induk, 
				t.kode_jenis, 
				j.nama_jenis,
				j.tipe_jenis,
				t.nominal as tagih, 
				sum(COALESCE(p.nominal,0)) as bayar, 
				t.nominal - sum(COALESCE(p.nominal,0)) as tanggungan,
				t.status_tagihan,
				CASE tipe_jenis
					WHEN 'per_bulan' THEN t.bulan_tagih
					WHEN 'per_thn_ajaran' THEN ta.thn_ajaran
					WHEN 'per_semester' THEN CONCAT(ta.thn_ajaran,' ',ta.sem_ajaran)
					ELSE ''
				END as periode,
				t.keterangan,
				DATE_FORMAT(t.tgl_tagih, '%d/%m/%Y') as tgl_tagih,
				CONCAT_WS(', ', DATE_FORMAT(p.tgl_bayar, '%d/%m/%Y')) as tgl_bayar
			FROM
				tb_keu_tr_tagihan t
			LEFT JOIN
				tb_keu_rf_jenis_pembayaran j ON j.kode_jenis=t.kode_jenis
			LEFT JOIN
				tb_akd_rf_thn_ajaran ta ON ta.kode_thn_ajaran=t.thn_ajaran_tagih
			LEFT JOIN
				tb_keu_tr_pembayaran p ON t.kode_tagihan=p.kode_tagihan
			$where
			GROUP BY
				t.kode_tagihan
			ORDER BY
				t.tgl_tagih ASC
		) as tagih
		LEFT JOIN
			tb_akd_rf_siswa s ON s.no_induk=tagih.no_induk";
		return $query;
	}
	
	public function getSingleData($id)
	{
		$query = $this->getMainQuery("t.kode_tagihan = '$id'");	
		return $this->db->query($query)->row();		
	}
	
	public function getDataByNoInduk($no_induk)
	{
		$query = $this->getMainQuery("t.no_induk = '$no_induk'");	
		return $this->db->query($query)->result();		
	}

	public function ubahNominalTagihan($id, $nominal)
	{
		$detail = $this->getSingleData($id);
		if(!$detail) return false;
		
		$nominal = (int)$nominal;
		if($nominal < $detail->bayar) return false;
		
		$data = array(
			'nominal' => $nominal,
			'status_tagihan' => $nominal == $detail->bayar ? 'Lunas' : 'Belum Lunas',
		);
		
		return $this->db->where('kode_tagihan', $id)->update('tb_keu_tr_tagihan', $data);
	}
	
	public function deleteTagihan($id)
	{
		$detail = $this->getSingleData($id);
		if(!$detail) return false;
		if($detail->bayar) return false;
		return $this->db->where('kode_tagihan', $id)->delete('tb_keu_tr_tagihan');
	}
}