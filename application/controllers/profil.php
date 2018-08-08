<<<<<<< HEAD
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class profil extends admin_controller {

	public $title = 'Profil';

	public function index()
	{
		$this->load->model('mod_siswa');
		$pack = array(
			'tahun_ajaran' => $this->mod_siswa->getTahunAjaran(),
			'detail_siswa' => $this->detail_siswa
		);
		$this->load->template('profil/v_view', $pack);
	}



}
=======
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class profil extends admin_controller {

	public $title = 'Profil';

	public function index()
	{
		$this->load->model('mod_siswa');
		$pack = array(
			'tahun_ajaran' => $this->mod_siswa->getTahunAjaran(),
			'detail_siswa' => $this->detail_siswa
		);
		$this->load->template('profil/v_view', $pack);
	}



}
>>>>>>> 2c4a65a97f892b1ddefd99f5917efa022830a485
