<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends admin_controller {

	var $title = 'Dashboard';
	
	public function index()
	{
		$this->load->model('mod_statistik');
		$pack = array(
			'siswa_all' => $this->mod_statistik->getJmlAllSiswa(),
			'siswa_valid' => $this->mod_statistik->getJmlSiswaValid(),
			'siswa_menunggak' => $this->mod_statistik->getJmlSiswaMenunggak(),
			'siswa_per_angkatan' => $this->mod_statistik->getJmlSiswaPerAngkatan(),
			'siswa_per_umur' => $this->mod_statistik->getJmlSiswaPerUmur(),
			'siswa_per_jenjang' => $this->mod_statistik->getJmlSiswaPerJenjang(),
			'pemasukan_bln_ini' => $this->mod_statistik->getPemasukanBulanIni(),
			'pemasukan_12_bln' => $this->mod_statistik->getPemasukan12BulanTerakhir(),
			'thn_ajaran' => $this->db->where('kode_thn_ajaran', THN_AJARAN)->get('tb_akd_rf_thn_ajaran')->row(),
			'piutang' => $this->mod_statistik->getPiutang(),
		);
		//dump($pack);
		$this->load->template('dashboard', $pack);
	}
}
