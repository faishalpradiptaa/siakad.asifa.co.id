<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_rapor extends MY_Model
{
	
	public function getPropertyRapor($kode_template, $thn_ajaran, $id_ambil_kelas)
	{
		$where = array(
			'id_ambil_kelas' => $id_ambil_kelas,
			'kode_thn_ajaran' => $thn_ajaran,
			'kode_jenjang' => JENJANG,
			'kode_temp_rapor' => $kode_template,
			'status' => 'valid',
		);
		return $this->db->where($where)->get('tb_akd_tr_rapor')->row();
	}
	
	public function getExistingTahunAjaranByRapor($kode_template)
	{
		$where = array(
			'r.no_induk' => NO_INDUK,
			'r.kode_jenjang' => JENJANG,
			'r.kode_temp_rapor' => $kode_template,
			'r.status' => 'valid',
		);
		/* 	
		return $this->db
			->select('t.kode_thn_ajaran, t.thn_ajaran, t.sem_ajaran')			
			->order_by('t.thn_ajaran', 'ASC')
			->order_by('t.sem_ajaran', 'ASC')
			->group_by('t.kode_thn_ajaran')
			->get('tb_akd_rf_thn_ajaran t')
			->result(); 
			*/
			
		return $this->db
			->select('r.kode_thn_ajaran, t.thn_ajaran, t.sem_ajaran')			
			->where($where)
			->join('tb_akd_rf_thn_ajaran t', 't.kode_thn_ajaran=r.kode_thn_ajaran')
			->order_by('t.thn_ajaran', 'ASC')
			->order_by('t.sem_ajaran', 'ASC')
			->group_by('r.kode_thn_ajaran')
			->get('tb_akd_tr_rapor r')
			->result();
		
	}
	
}