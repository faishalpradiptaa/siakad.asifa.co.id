<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tr_periodik_controller extends admin_controller{

	public $thn_ajaran = array();
	public $curr_thn_ajaran = array();
	
	function __construct()
	{
		parent::__construct();
		$this->thn_ajaran = $this->db->order_by('thn_ajaran DESC, sem_ajaran DESC')->get('tb_akd_rf_thn_ajaran')->result();		
		$this->curr_thn_ajaran = $this->db->where('kode_thn_ajaran', THN_AJARAN)->get('tb_akd_rf_thn_ajaran')->row();
		if(!$this->curr_thn_ajaran) 
		{
			show_404();
			die;
		}
	}
	
	function change_thn_ajaran($thn)
	{
		$this->session->set_userdata('current_thn_ajaran', $thn);
		redirect($_SERVER['HTTP_REFERER']);
	}

}
?>