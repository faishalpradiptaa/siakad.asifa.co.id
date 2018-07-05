<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_thn_ajaran extends MY_Model
{
	public function changeStatus($kode, $status)
	{
		$this->db->trans_start();
		if ($status == 'active') $this->db->update('tb_akd_rf_thn_ajaran', array('status_ajaran' => 'not_active'));
		$this->db->where('kode_thn_ajaran',$kode)->update('tb_akd_rf_thn_ajaran', array('status_ajaran' => $status));
		$this->db->trans_complete();
		return $this->db->trans_status();
		
	}
}