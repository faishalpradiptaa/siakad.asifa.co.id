<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_riwayat extends MY_Model
{
	public function getAllJenis()
	{
		return $this->db->order_by('kode_jenis','ASC')->get('tb_akd_rf_jenis_riwayat')->result();
	}
	
	public function getDataByNoInduk($no_induk, $kode_thn_ajaran=false)
	{
		$kode_thn_ajaran = !$kode_thn_ajaran ? THN_AJARAN : $kode_thn_ajaran;
		
		$jenis = $this->db
			->order_by('kode_jenis','ASC')
			->get('tb_akd_rf_jenis_riwayat')
			->result();
		
		$data = $this->db
			->where('kode_jenjang', JENJANG)
			->where('no_induk', $no_induk)
			->where('kode_thn_ajaran', $kode_thn_ajaran)
			->order_by('tgl', 'ASC')
			->get('tb_akd_tr_riwayat')
			->result();
			
		return (object)array(
			'jenis' => $jenis,
			'data' => $data,
		);
	}
	
	// unused
	public function saveSingleAbsensi($no_induk, $data)
	{
		$this->db->trans_start();
		$send = array(
			'no_induk' => $no_induk,
			'kode_thn_ajaran' => THN_AJARAN,
			'kode_jenjang' => JENJANG,			
		);
		$this->db->where($send)->delete('tb_akd_tr_nilai_riwayat');
		foreach($data as $row) if ($row && $row['jml'] > 0)
		{
			$send['kode_jenis_riwayat'] = $row['kode_jenis'];
			$send['jumlah'] = $row['jml'];
			$this->db->insert('tb_akd_tr_nilai_riwayat', $send);
		}
		$this->db->trans_complete();
		
		return $this->db->trans_status();
	}
	
	// unused
	public function saveBatchAbsensi($data)
	{
		$this->db->trans_start();
		$send = array(
			'kode_thn_ajaran' => THN_AJARAN,
			'kode_jenjang' => JENJANG,			
		);
		$data_baru = array();
		foreach($data as $part)
		{
			unset($send['kode_jenis_riwayat']);
			unset($send['jumlah']);
			$send['no_induk'] = $part['no_induk'];
			$this->db->where($send)->delete('tb_akd_tr_nilai_riwayat');
			foreach($part['data'] as $row) if ($row && $row['jml'] > 0)
			{
				$send['kode_jenis_riwayat'] = $row['kode_jenis'];
				$send['jumlah'] = $row['jml'];
				$data_baru[] = $send;
			}
		}
		if($data_baru) $this->db->insert_batch('tb_akd_tr_nilai_riwayat', $data_baru);
		$this->db->trans_complete();
		
		return $this->db->trans_status();
	}
}