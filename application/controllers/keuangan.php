<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class keuangan extends admin_controller {
	
	public $title = 'Keuangan';

	public function index()
	{
		$this->load->model('mod_keuangan');
		$pack = array(
			'tagihan' => $this->mod_keuangan->getMyTagihan(),
			'pembayaran' => $this->mod_keuangan->getMyPembayaran(),
		);
		$this->load->template('keuangan/v_view', $pack);
	}
	

	
}