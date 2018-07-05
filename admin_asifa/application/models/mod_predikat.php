<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_predikat extends MY_Model
{
	public function saveGrade($id, $data)
	{
		if(!$id) $id = $this->db->insert_id();
		$this->db->trans_start();
		$this->db->where('id_predikat', $id)->delete('tb_akd_rf_predikat_detail');
		$detail_baru = array();
		if(is_array($data)) foreach($data as $row) if($row['grade'])
		{
			$detail_baru[] = array(
				'id_predikat' => $id,
				'grade' => $row['grade'],
				'deskriptif' => $row['deskriptif'],
				'minimal' => $row['minimal'],
				'maksimal' => $row['maksimal'],
			);
		}
		if ($detail_baru) $this->db->insert_batch('tb_akd_rf_predikat_detail', $detail_baru);
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	public function getDetail($id)
	{
		return $this->db->where('id_predikat', $id)->order_by('minimal', 'ASC')->get('tb_akd_rf_predikat_detail')->result();
	}
	
}