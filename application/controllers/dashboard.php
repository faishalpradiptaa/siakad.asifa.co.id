<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends admin_controller {

	var $title = 'Dashboard';
	
	public function index()
	{
		$this->load->model('mod_pengumuman');
		$pack = array(
			'kat_pengumuman' => $this->mod_pengumuman->getAllKategori(),
			'pengumuman' => $this->mod_pengumuman->getLimitedData(25),
		);
		$this->load->template('dashboard', $pack);
	}
}
