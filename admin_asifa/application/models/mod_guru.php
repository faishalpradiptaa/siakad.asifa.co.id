<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_guru extends MY_Model
{
	
	public function changeStatus($kode, $status)
	{
		$this->db->trans_start();
		$this->db->where('no_induk',$kode)->update('tb_akd_rf_guru', array('status_guru' => $status));
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	function getDataAutoComplete($limit=10)
	{
		$txt = isset($_GET['q']) ? $_GET['q'] : '';
		$query = "SELECT
			no_induk AS id,
			nama AS text
		FROM
			tb_akd_rf_guru
		WHERE
			no_induk LIKE '%$txt%'
			OR nama LIKE '%$txt%'
		LIMIT $limit";
		$data = $this->db->query($query)->result();
		return $data;
	}
}