<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function index()
	{
		$is_login = $this->session->userdata('logged_in');
		if ($is_login) redirect(site_url('dashboard'));
		if ($this->input->server('REQUEST_METHOD') == 'POST') 
		{
			$this->load->model('mod_user');
			$u = trim($this->input->post('user_username'));
			$p = trim($this->input->post('user_password'));
			if($u == '' || $p == '') redirect(site_url());
			if($this->mod_user->login($u,$p))
			{
				//for tinymce
				session_start();
				$_SESSION['hasasu'] = true;
				redirect(site_url('dashboard'));
			}
			else redirect(site_url());
		}
		$this->load->view('login',$d);   
	}
	
	
	public function logout()
	{
		if(!$this->session->userdata('logged_in')) redirect(site_url());
		$this->session->sess_destroy();
		session_start();
		session_destroy();
		redirect(site_url());
	}
}