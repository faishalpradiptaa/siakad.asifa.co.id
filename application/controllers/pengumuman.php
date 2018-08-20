<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pengumuman extends MY_Controller {

	public function index($id)
	{
		$this->load->model('mod_pengumuman');
		$pack = array(
			'data' => $this->mod_pengumuman->getSingleData($id),
		);
		$this->load->view('pengumuman/v_detail', $pack);
		
	}
	
	
}