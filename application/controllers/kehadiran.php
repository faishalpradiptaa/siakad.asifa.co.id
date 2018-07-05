<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class kehadiran extends admin_controller {
	
	public $title = 'Kehadiran';

	public function view($thn_ajaran=false)
	{
		$this->load->model('mod_kehadiran');
		$list_thn_ajaran = $this->mod_siswa->getThnAjaranByPengambilan();
		$thn_ajaran = !$thn_ajaran ? $list_thn_ajaran[count($list_thn_ajaran)-1]->kode_thn_ajaran : $thn_ajaran;		
		$thn_ajaran = !$thn_ajaran ? THN_AJARAN : $thn_ajaran;
		
		$pack = array(
			'curr_thn_ajaran' => $thn_ajaran,
			'list_thn_ajaran' => $list_thn_ajaran,
			'siswa' => $this->detail_siswa,
			'kehadiran' => $this->mod_kehadiran->getDataByThnAjaran($thn_ajaran),
		);
		$this->load->template('kehadiran/v_view', $pack);
	}
	

	
}