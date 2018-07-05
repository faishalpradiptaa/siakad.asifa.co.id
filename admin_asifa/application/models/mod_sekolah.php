<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_sekolah extends MY_Model
{
	public function getAllData()
	{
		return $this->db->get('tb_akd_rf_sekolah')->result();
	}
	
	public function getDataByJenjang($jenjang=JENJANG)
	{
		return $this->db->where('jenjang', $jenjang)->get('tb_akd_rf_sekolah')->result();
	}
	
	public function getSiswaBySekolah($sekolah, $jurusan=false, $kode_thn_ajaran = false)
	{
		if(!$kode_thn_ajaran) $kode_thn_ajaran = THN_AJARAN;
		if(!$sekolah)
		{
			return $this->db
				->select('s.no_induk, s.nama')
				->join('tb_akd_tr_ambil_kelas ak', 'ak.no_induk=s.no_induk AND ak.kode_thn_ajaran = "'.$kode_thn_ajaran.'"', 'left')
				->where('ak.kode_sekolah is null')
				->where('(ak.kode_jenjang = "'.JENJANG.'" or ak.kode_jenjang is null)')
				->order_by('s.no_induk', 'ASC')
				->get('tb_akd_rf_siswa s')
				->result();
		}
		if($jurusan) $this->db->where('kode_jurusan', $jurusan);
		return $this->db
			->select('s.no_induk, s.nama')
			->join('tb_akd_rf_siswa s', 'ak.no_induk=s.no_induk')
			->where('ak.kode_thn_ajaran', $kode_thn_ajaran)
			->where('ak.kode_sekolah', $sekolah)
			->where('ak.kode_jenjang = "'.JENJANG.'"')
			->order_by('s.no_induk', 'ASC')
			->get('tb_akd_tr_ambil_kelas ak')
			->result();
	}
	
	
	public function assignSiswa($sekolah, $jurusan, $siswa)
	{
		if(!$sekolah || !$siswa) return false;
		if($sekolah == '-reset-')
		{
			$sekolah = null;
			$jurusan = null;
		}
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
				'kode_sekolah' => $sekolah,
				'kode_jurusan' => $jurusan ? $jurusan : null,
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
				'kode_thn_ajaran' => THN_AJARAN,
				'kode_sekolah' => $sekolah,
				'kode_jenjang' => JENJANG,
				'kode_jurusan' => $jurusan ? $jurusan : null,
			);			
		}
		if($data) $this->db->insert_batch('tb_akd_tr_ambil_kelas', $data);
		$this->db->trans_complete();
		return $this->db->trans_status();
		
	}

	public function resetSekolahSiswa($id)
	{
		$data = array(
			'kode_sekolah' => null,
			'kode_jurusan' => null,			
		);
		return $this->db
			->where('id_ambil_kelas', $id)
			->update('tb_akd_tr_ambil_kelas', $data);
	}
}