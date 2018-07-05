<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tr_riwayat_detail extends crud_periodik_controller {

	public $title = 'Detail Riwayat';
	public $table = 'tb_akd_tr_riwayat';
	public $primary_key = 'id_riwayat';
	#public $additional_script_form = 'rfp_template_rapor/aspek-aditional_form';
	public $form_data = array(
		'kode_jenis_riwayat' => array(
			'title' => 'Jenis Riwayat',
			'type' => 'select',
			'col_width' => 'col-sm-5',
			'validate' => 'required',
		),
		'tgl' => array(
			'title' => 'Tanggal',
			'type' => 'date',
			'col_width' => 'col-sm-5',
			'validate' => 'required',
		), 
		'keterangan' => array(
			'title' => 'Keterangan',
			'type' => 'text',
			'col_width' => 'col-sm-9',
		),
		'no_induk' => array(
			'type' => 'hidden',
		),
	);
		
	public function index($raw_no_induk)
	{
		$this->load->model('mod_siswa');
		$no_induk = base64_decode($raw_no_induk);
		$pack = array(
			'raw_no_induk' => $raw_no_induk,
			'no_induk' => $no_induk,
			'detail_siswa' => $this->mod_siswa->getDetailByNoInduk($no_induk),
		);
		$this->load->view('tr_riwayat/detail_main', $pack);
	}
	
	// protected CRUD function 
	protected function renderTable($kolom, $table, $primary_key)
	{
		$kolom = array( 'tgl_new', 'nama_jenis','keterangan', 'options-no-db');
		$table = $this->db
			->select('a.*, DATE_FORMAT(tgl,"%d/%m/%Y") as tgl_new, j.nama_jenis', false)
			->from($table.' a')
			->join('tb_akd_rf_jenis_riwayat j','a.kode_jenis_riwayat=j.kode_jenis')
			->where('kode_thn_ajaran', THN_AJARAN)
			->where('kode_jenjang', JENJANG)
			->where('no_induk', base64_decode($_GET['no_induk']));
		
		$data = $this->datatable->render($kolom, $table, $primary_key);		
		return $data;
	}
	
	protected function beforeForm($pack, $id)
	{
		$this->form_data['tgl']['default'] = date('Y-m-d');
		
		$this->form_data['kode_jenis_riwayat']['data'] = $this->db
			->select('kode_jenis as value, nama_jenis as text')
			->order_by('kode_jenis','ASC')
			->get('tb_akd_rf_jenis_riwayat')
			->result();
		
		$this->form_data['no_induk']['default'] = $this->uri->segment(4);
		return $pack;		
	}

	
}