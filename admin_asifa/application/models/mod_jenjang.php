<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_jenjang extends MY_Model
{
	public function changeStatus($kode, $status)
	{
		$this->db->trans_start();
		if ($status == 'active') $this->db->update('tb_akd_rf_jenjang', array('status_jenjang' => 'not_active'));
		$this->db->where('kode_jenjang',$kode)->update('tb_akd_rf_jenjang', array('status_jenjang' => $status));
		$this->db->trans_complete();
		return $this->db->trans_status();
		
	}
}