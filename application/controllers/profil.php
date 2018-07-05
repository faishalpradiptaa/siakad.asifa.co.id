<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class profil extends admin_controller {
	
	public $title = 'Profil';

	public function index()
	{
		$pack = array(
			'tahun_ajaran' => $this->db->where('kode_thn_ajaran', THN_AJARAN)->get('tb_akd_rf_thn_ajaran')->row(),
		);
		$this->load->template('profil/v_view', $pack);
	}
	

	
}