<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_controller extends MY_Controller{
	
	public $detail_siswa = array();

	function __construct() 
	{
		parent::__construct();		
		
		if(!$this->session->userdata('logged_in')) 
		{
			$this->session->sess_destroy();
			$referrer = str_replace('=','',base64_encode($_SERVER[REQUEST_URI]));
			redirect(base_url('?ref='.$referrer));
		}
		
		define('USERNAME', $this->session->userdata('username'));
		define('NO_INDUK', $this->session->userdata('no_induk'));
		define('NAMA_LENGKAP', $this->session->userdata('nama'));
		define('ROLE', $this->session->userdata('role'));
		define('PAGE_ID', $this->uri->segment(1));
		define('THN_AJARAN', $this->session->userdata('current_thn_ajaran'));
		
		$this->detail_siswa = $this->mod_siswa->getDetail();
		define('JENJANG', $this->detail_siswa->kode_jenjang);
	
		

	}
	
}
?>