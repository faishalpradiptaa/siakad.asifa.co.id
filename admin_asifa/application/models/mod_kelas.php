<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_kelas extends MY_Model
{
	public function getAllData()
	{
		return $this->db->where('kode_jenjang', JENJANG)->get('tb_akd_rf_kelas')->result();
	}
	
	public function getSiswaByKelas($kode_thn_ajaran, $kelas)
	{
		if(!$kelas)
		{
			return $this->db
				->select('s.no_induk, s.nama')
				->join('tb_akd_tr_ambil_kelas ak', 'ak.no_induk=s.no_induk AND ak.kode_thn_ajaran="'.$kode_thn_ajaran.'"', 'left')
				->where('ak.kode_kelas is null')
				->order_by('s.no_induk', 'ASC')
				->get('tb_akd_rf_siswa s')
				->result();
		}

		return $this->db
			->select('s.no_induk, s.nama')
			->join('tb_akd_rf_siswa s', 'ak.no_induk=s.no_induk')
			->where('ak.kode_thn_ajaran', $kode_thn_ajaran)
			->where('ak.kode_jenjang', JENJANG)
			->where('ak.kode_kelas', $kelas)
			->order_by('s.no_induk', 'ASC')
			->get('tb_akd_tr_ambil_kelas ak')
			->result();
	}
	
	public function getSiswaByAngkatan($angkatan)
	{
		return $this->db
			->select('no_induk, nama')
			->where('angkatan', $angkatan)
			->order_by('no_induk', 'ASC')
			->get('tb_akd_rf_siswa')
			->result();
	}
	
	public function assignSiswa($kelas, $siswa)
	{
		if(!$kelas || !$siswa) return false;
		if($kelas == '-reset-') $kelas = null;
		$this->db->trans_start();
		
		//cek siswa yang sudah ditempatkan
		$exists = array();
		$no_induk = '"'.implode('","', $siswa).'"';
		$ada = $this->db
			->where('kode_jenjang', JENJANG)
			->where('kode_thn_ajaran', THN_AJARAN)
			->where('no_induk in ('.$no_induk.')')
			->get('tb_akd_tr_ambil_kelas')
			->result();

		if(is_array($ada)) foreach($ada as $row)
		{
			$send = array(
				'no_induk' => $row->no_induk,
				'kode_thn_ajaran' => THN_AJARAN,
				'kode_jenjang' => JENJANG,
				'kode_kelas' => $kelas,
				'tgl_kenaikan' => date('Y-m-d')
			);
			$this->db
				->where('kode_thn_ajaran', THN_AJARAN)
				->where('no_induk', $row->no_induk)
				->update('tb_akd_tr_ambil_kelas', $send);
			$exists[] = $row->no_induk;
		}

		$data = array();
		foreach($siswa as $row) if(!in_array($row, $exists))
		{
			$data[] = array(
				'no_induk' => $row,
				'kode_jenjang' => JENJANG,
				'kode_thn_ajaran' => THN_AJARAN,
				'kode_kelas' => $kelas,
				'tgl_kenaikan' => date('Y-m-d')
			);			
		}
		if($data) $this->db->insert_batch('tb_akd_tr_ambil_kelas', $data);
		$this->db->trans_complete();
		return $this->db->trans_status();
		
	}
}