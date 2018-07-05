<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class err_404 extends admin_controller {

	public function index()
	{
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')  $this->load->view('404');
		else $this->load->template('404');
	}
	
}
