<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_absensi extends MY_Model
{
	public function getAllJenis()
	{
		return $this->db->order_by('kode_jenis','ASC')->get('tb_akd_rf_jenis_absensi')->result();
	}
	
	public function saveSingleAbsensi($no_induk, $data)
	{
		$this->db->trans_start();
		$send = array(
			'no_induk' => $no_induk,
			'kode_thn_ajaran' => THN_AJARAN,
			'kode_jenjang' => JENJANG,			
		);
		$this->db->where($send)->delete('tb_akd_tr_nilai_absensi');
		foreach($data as $row) if ($row && $row['jml'] > 0)
		{
			$send['kode_jenis_absensi'] = $row['kode_jenis'];
			$send['jumlah'] = $row['jml'];
			$this->db->insert('tb_akd_tr_nilai_absensi', $send);
		}
		$this->db->trans_complete();
		
		return $this->db->trans_status();
	}
	
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
			unset($send['kode_jenis_absensi']);
			unset($send['jumlah']);
			$send['no_induk'] = $part['no_induk'];
			$this->db->where($send)->delete('tb_akd_tr_nilai_absensi');
			foreach($part['data'] as $row) if ($row && $row['jml'] > 0)
			{
				$send['kode_jenis_absensi'] = $row['kode_jenis'];
				$send['jumlah'] = $row['jml'];
				$data_baru[] = $send;
			}
		}
		if($data_baru) $this->db->insert_batch('tb_akd_tr_nilai_absensi', $data_baru);
		$this->db->trans_complete();
		
		return $this->db->trans_status();
	}
}