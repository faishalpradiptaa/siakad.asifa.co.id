<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_controller extends MY_Controller{

	function __construct() 
	{
		parent::__construct();		
		define('USERNAME', $this->session->userdata('username'));
		define('NAMA_LENGKAP', $this->session->userdata('nama'));
		define('ROLE', $this->session->userdata('role'));
		define('PAGE_ID', $this->uri->segment(1));
		define('THN_AJARAN', $this->session->userdata('current_thn_ajaran'));
		define('JENJANG', $this->session->userdata('current_jenjang'));
	
		
		if(!$this->session->userdata('logged_in')) 
		{
			$this->session->sess_destroy();
			$referrer = str_replace('=','',base64_encode($_SERVER[REQUEST_URI]));
			redirect(base_url('?ref='.$referrer));
		}

	}
	
}
?>