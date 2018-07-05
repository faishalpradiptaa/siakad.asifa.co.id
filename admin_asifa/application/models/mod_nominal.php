<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_nominal extends MY_Model
{
	public function getAllJenis()
	{
		return $this->db->order_by('kode_jenis','ASC')->get('tb_keu_rf_jenis_pembayaran')->result();
	}
	
	public function setNominal($arr_nominal, $arr_siswa)
	{
		$arr_siswa = array_unique($arr_siswa);
		foreach($arr_nominal as $key => $val)
		{
			$val = trim(str_replace('.','',$val));
			if($val == '') 
				unset($arr_nominal[$key]);
			else
				$arr_nominal[$key] = $val;
		}
		
		$this->db->trans_start();
		
		//delete prev_data
		$this->db
			->where_in('kode_jenis', array_keys($arr_nominal))
			->where_in('no_induk', $arr_siswa)
			->delete('tb_keu_rf_nominal');
			
		//olah data
		$data = array();
		foreach($arr_nominal as $kode => $nom)
		{
			foreach($arr_siswa as $siswa)
			{
				$data[] = array(
					'no_induk' => $siswa,
					'kode_jenis' => $kode,
					'nominal' => $nom,
				);
			}
		}
		$this->db->insert_batch('tb_keu_rf_nominal', $data);
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	public function getSinglePerSiswaAllJenis($no_induk)
	{
		$data_org = array();
		$data = $this->db
		 ->where('no_induk', $no_induk)
		 ->get('tb_keu_rf_nominal')
		 ->result();
		foreach($data as $row) $data_org[$row->kode_jenis] = $row;
		return $data_org;
	}
	
}