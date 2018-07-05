<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$is_login = $this->session->userdata('logged_in');
		if ($is_login) redirect(site_url('dashboard'));
		if ($this->input->server('REQUEST_METHOD') == 'POST') 
		{
			$u = trim($this->input->post('user_username'));
			$p = trim($this->input->post('user_password'));
			if($u == '' || $p == '') redirect(site_url());
			if($this->system_model->login($u,$p)) redirect(site_url('dashboard'));
			else redirect(site_url());
		}
		
		$this->load->model('mod_pengumuman');
		$pack = array(
			'pengumuman' => $this->mod_pengumuman->getLimitedData(15),
		);
		$this->load->view('login',$pack);   
	}
	
	
	public function logout()
	{
		if(!$this->session->userdata('logged_in')) redirect(site_url());
		$this->session->sess_destroy();
		redirect(site_url());
	}
}