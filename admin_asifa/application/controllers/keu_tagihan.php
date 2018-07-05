<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class keu_tagihan extends tr_periodik_controller {

	public $title = 'Tagihan';
	
	public function index()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') 
		{
			$this->load->model('mod_tagihan');
			die($this->mod_tagihan->createTagihanFromPOST());
		}
		$pack = array(
			'kelas' => $this->db->where('kode_thn_ajaran', THN_AJARAN)->get('tb_akd_rf_kelas')->result(),
			'angkatan' => $this->db->select('angkatan')->group_by('angkatan')->get('tb_akd_rf_siswa')->result(),
			'jenis_pembayaran' => $this->db->get('tb_keu_rf_jenis_pembayaran')->result(),
		);
		$this->load->template('keu_tagihan/v_main', $pack);
		
	}
}