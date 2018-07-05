<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rfp_kelas extends crud_periodik_controller {

	public $title = 'Kelas';
	public $column = array
	(
		'kode_kelas' => array(
			'title' => 'Kode',
			'filter' => 'text',
			'width' => '15%',
		), 
		'nama_kelas' => array(
			'title' => 'Nama',
			'filter' => 'text',
			'width' => '25%',
		),
		'tingkatan' => array(
			'title' => 'Tingkatan',
			'filter' => 'text',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center'),
		), 
		'nama_guru' => array(
			'title' => 'Wali Kelas',
			'filter' => 'text',
		), 
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $table = 'tb_akd_rf_kelas';
	public $primary_key = 'kode_kelas';
	public $form_data = array();
	
	function __construct()
	{
		parent::__construct();
			
		$this->form_data = array(
			'kode_kelas' => array(
				'title' => 'Kode',
				'type' => 'text',
				'col_width' => 'col-sm-5',
				'validate' => 'required;code',
			), 
			'nama_kelas' => array(
				'title' => 'Nama',
				'filter' => 'text',
				'col_width' => 'col-sm-7',
				'validate' => 'required',
			), 
			'tingkatan' => array(
				'title' => 'Tingkatan',
				'type' => 'text',
				'col_width' => 'col-sm-3',
				'validate' => 'required',
			), 
			'no_induk_guru' => array(
				'title' => 'Wali Kelas',
				'type' => 'select',
				'data' => $this->db->select('no_induk as value, CONCAT(no_induk," - ",nama) as text', false)->order_by('nama','ASC')->get('tb_akd_rf_guru')->result(),				
				'col_width' => 'col-sm-8',
			), 
		);
	}
	
	// protected CRUD function 
	protected function renderTable($kolom, $table, $primary_key)
	{
		$table = $this->db
			->select('kl.*, gr.nama as nama_guru')
			->from($table.' kl')
			->join('tb_akd_rf_guru gr', 'gr.no_induk=kl.no_induk_guru', 'left')
			->where('kode_thn_ajaran', THN_AJARAN)
			->where('kode_jenjang', JENJANG);
		$data = $this->datatable->render($kolom, $table, $primary_key);
		return $data;
	}
	
	
}