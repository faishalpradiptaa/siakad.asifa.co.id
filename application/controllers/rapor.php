<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rapor extends admin_controller {

	public function view($kode_template, $thn_ajaran=false)
	{
		
		$this->load->model('mod_template_rapor');
		$this->load->model('mod_rapor');
		$list_thn_ajaran = $this->mod_siswa->getThnAjaranByPengambilan();
		$thn_ajaran = !$thn_ajaran ? THN_AJARAN : $thn_ajaran;
		$thn_ajaran = !$thn_ajaran ? $list_thn_ajaran[count($list_thn_ajaran)-1]->kode_thn_ajaran : $thn_ajaran;		
		$siswa = $this->mod_siswa->getDetail($thn_ajaran);
		
		$pack = array(
			'kode_template' => $kode_template,
			'curr_thn_ajaran' => $thn_ajaran,
			'list_thn_ajaran' => $list_thn_ajaran,
			'template' => $this->mod_template_rapor->getDetail($kode_template, $thn_ajaran),
			'siswa' => $siswa,
			'rapor' => $this->mod_rapor->getPropertyRapor($kode_template, $thn_ajaran, $siswa->id_ambil_kelas),
			'view' => $this->mod_template_rapor->getTemplateView($kode_template, $thn_ajaran, $siswa),
		);
		$this->title = $pack['template'] ? $pack['template']->nama_template : 'Rapor';
		$this->load->template('rapor/v_view', $pack);
	}
	

	
}