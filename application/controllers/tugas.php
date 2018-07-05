<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tugas extends admin_controller {
	
	public $title = 'Tugas';

	public function index()
	{
		$this->load->model('mod_tugas');
		$pack = array(
			'tugas' => $this->mod_tugas->getAllMyTugas(),
		);
		$this->load->template('tugas/v_view', $pack);
	}
	
	public function view($raw_kode_mp, $id_tugas=false)
	{
		$this->load->model('mod_tugas');
		$kode_mp = $raw_kode_mp == 'all' ? false : base64_decode($raw_kode_mp);
		
		if ($this->input->server('REQUEST_METHOD') == 'POST' && $id_tugas) 
		{
			$this->mod_tugas->submitTugas($kode_mp, $id_tugas, 'upload');
			redirect($_SERVER['HTTP_REFERER']);
		}
		$pack = array(
			'raw_kode_mp' => $raw_kode_mp,
			'kode_mp' => $kode_mp,
			'id_tugas' => $id_tugas,
			'tugas' => $this->mod_tugas->getAllMyTugas($kode_mp),
		);
		$this->load->template('tugas/v_by_mapel', $pack);
	}
	
	public function download($id_submit)
	{
		$id_submit = base64_decode($id_submit);
		$this->load->model('mod_tugas');
		$data = $this->mod_tugas->getMySubmit($id_submit);
		if($data && file_exists($data->alamat_file))
		{
			header('Content-Type: application/octet-stream');
			header("Content-Transfer-Encoding: Binary"); 
			header("Content-disposition: attachment; filename=\"" . $data->nama_file . "\""); 
			readfile($data->alamat_file); 
		}
		else
		{
			redirect(site_url(PAGE_ID));
		}
		
	}
	
}