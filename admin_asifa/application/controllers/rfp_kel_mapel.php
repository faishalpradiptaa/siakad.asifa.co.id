<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rfp_kel_mapel extends crud_periodik_controller {

	public $title = 'Kelompok MaPel';
	public $column = array
	(
		'kode_kelompok' => array(
			'title' => 'Kode',
			'filter' => 'text',
			'width' => '15%'
		), 
		'nama_kelompok' => array(
			'title' => 'Nama',
			'filter' => 'text',
		), 
		'jenis_kelompok' => array(
			'title' => 'Jenis',
			'filter' => 'text',
			'width' => '12%',
			'attribut' => array('data-class' => 'text-center'),
		), 
		'nama_jenis_rapor' => array(
			'title' => 'Rapor',
			'filter' => 'text',
			'width' => '17%',
		), 
		'urutan' => array(
			'title' => 'Urutan',
			'attribut' => array('data-class' => 'text-center', 'data-visible' => 'false'),
		), 
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $table = 'tb_akd_rf_kelompok_mp';
	public $primary_key = 'kode_kelompok';
	public $form_data = array();
	
	function __construct()
	{
		parent::__construct();
		
		$this->form_data = array(
			'kode_kelompok' => array(
				'title' => 'Kode',
				'type' => 'text',
				'col_width' => 'col-sm-5',
				'validate' => 'required;code',
			), 
			'nama_kelompok' => array(
				'title' => 'Nama',
				'type' => 'text',
				'col_width' => 'col-sm-7',
				'validate' => 'required',
			), 			
			'jenis_kelompok' => array(
				'title' => 'Jenis Kelompok',
				'type' => 'select',
				'data' => array( array('value'=>'umum', 'text'=>'Umum'), array('value'=>'peminatan', 'text'=>'Peminatan') ),
				'col_width' => 'col-sm-5',
			), 
			'kode_jenis_rapor' => array(
				'title' => 'Jenis Rapor',
				'type' => 'select',
				'data' => $this->db->select('kode_jenis as value, nama_jenis as text')->order_by('nama_jenis','ASC')->get('tb_akd_rf_jenis_rapor')->result(),
				'col_width' => 'col-sm-6',
				'validate' => 'required',
			), 
			'urutan' => array(
				'title' => 'Urutan',
				'type' => 'number',
				'col_width' => 'col-sm-3',
				'default' => '0',
			), 
				
		);
	}
	
	// protected CRUD function 
	protected function renderTable($kolom, $table, $primary_key)
	{
		$table = $this->db
			->select('kl.*, jr.nama_jenis as nama_jenis_rapor')
			->from($table.' kl')
			->join('tb_akd_rf_jenis_rapor jr', 'jr.kode_jenis=kl.kode_jenis_rapor', 'left')
			->where('kode_thn_ajaran', THN_AJARAN)
			->where('kode_jenjang', JENJANG);
		$data = $this->datatable->render($kolom, $table, $primary_key);
		foreach($data->data as $key=>$row) $data->data[$key][2] = ucwords($row[2]);
		return $data;
	}
	
	
}