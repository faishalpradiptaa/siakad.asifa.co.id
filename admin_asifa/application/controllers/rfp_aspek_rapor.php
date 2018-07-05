<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rfp_aspek_rapor extends crud_periodik_controller {

	public $title = 'Aspek Rapor';
	public $table = 'tb_akd_rf_aspek_rapor';
	public $primary_key = 'kode_aspek';
	public $additional_script_form = 'rfp_template_rapor/aspek-aditional_form';
	public $form_data = array(
		'kode_aspek' => array(
			'title' => 'Kode',
			'type' => 'text',
			'col_width' => 'col-sm-5',
			'validate' => 'required;code',
		), 
		'nama_aspek' => array(
			'title' => 'Nama',
			'type' => 'text',
			'col_width' => 'col-sm-7',
			'validate' => 'required',
		),
		'nama_alternatif' => array(
			'title' => 'Nama Alternatif',
			'type' => 'text',
			'col_width' => 'col-sm-7',
		),
		'urutan' => array(
			'title' => 'Urutan',
			'type' => 'number',
			'col_width' => 'col-sm-3',
			'validate' => 'required;number',
			'default' => 0,
		),
		'tipe' => array(
			'title' => 'Tipe',
			'type' => 'select',
			'col_width' => 'col-sm-5',
			'data'=> array(
				array('text'=>'Nilai Angka', 'value'=>'nilai_nominal'),
				array('text'=>'Nilai dengan Predikat', 'value'=>'nilai_predikat'),
				array('text'=>'Deskripsi', 'value'=>'deskripsi'),
				array('text'=>'Rumus', 'value'=>'rumus'),
			),
			'validate' => 'required',
		),
		'rumus' => array(
			'title' => 'Rumus',
			'type' => 'text',
			'col_width' => 'col-sm-8',
		),
		'id_predikat' => array(
			'title' => 'Predikat',
			'type' => 'select',
			'data' => array(),
			'col_width' => 'col-sm-5',
		),
		'width' => array(
			'title' => 'Panjang',
			'type' => 'text',
			'col_width' => 'col-sm-4',
		),
		'kode_temp_rapor' => array(
			'type' => 'hidden',
		),
		'kode_point' => array(
			'type' => 'hidden',
		),
	);
	
	public function index($raw_template, $raw_point)
	{
		$this->load->model('mod_template_rapor');
		$kode_template = base64_decode($raw_template);
		$kode_point = base64_decode($raw_point);
		$pack = array(
			'raw_template' => $raw_template,
			'raw_point' => $raw_point,
			'kode_template' => $kode_template,
			'kode_point' => $kode_point,
			'detail_point' => $this->mod_template_rapor->getDetailPoint($kode_template, $kode_point),
		);
		$this->load->view('rfp_template_rapor/aspek-main', $pack);
	}
	
	// protected CRUD function 
	protected function renderTable($kolom, $table, $primary_key)
	{
		$kolom = array( 'urutan', 'kode_aspek','nama_aspek', 'tipe', 'width', 'options-no-db');
		$table = $this->db
			->from($table)
			->where('kode_thn_ajaran', THN_AJARAN)
			->where('kode_jenjang', JENJANG)
			->where('kode_temp_rapor', $_GET['kode_template'])
			->where('kode_point', $_GET['kode_point']);
		
		$data = $this->datatable->render($kolom, $table, $primary_key);		
		return $data;
	}
	
	protected function beforeForm($pack, $id)
	{
		$this->form_data['id_predikat']['data'] = $this->db
			->select('id_predikat as value, nama_predikat as text')
			->order_by('nama_predikat','ASC')
			->get('tb_akd_rf_predikat')
			->result();
		
		$this->form_data['kode_temp_rapor']['default'] = $this->uri->segment(4);
		$this->form_data['kode_point']['default'] = $this->uri->segment(5);
		return $pack;		
	}

	
}