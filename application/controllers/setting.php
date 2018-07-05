<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class setting extends admin_controller {
	
	public $title = 'Setting & Ubah Profil';

	public function index()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') 
		{
			$args = array(
				'alamat' => $_POST['alamat'],
				'telp' => $_POST['telp'],
				'email' => $_POST['email'],
				'nama_ayah' => $_POST['nama_ayah'],
				'telp_ayah' => $_POST['telp_ayah'],
				'nama_ibu' => $_POST['nama_ibu'],
				'telp_ibu' => $_POST['telp_ibu'],
				'pass_lama' => $_POST['pass_lama'],
				'pass_baru' => $_POST['pass_baru'],
				'pass_confirm' =>$_POST['pass_confirm'],
			);
			$this->load->model('mod_siswa');
			$this->mod_siswa->updateProfile($args);
			redirect(site_url(PAGE_ID));
		}
		$pack = array(
			'tahun_ajaran' => $this->db->where('kode_thn_ajaran', THN_AJARAN)->get('tb_akd_rf_thn_ajaran')->row(),
		);
		$this->load->template('setting/v_form', $pack);
	}
	

	
}