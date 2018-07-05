<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class st_kota extends crud_controller {

	public $title = 'Kota';
	public $column = array
	(
		'nama_kota' => array(
			'title' => 'Kota',
			'filter' => 'text',
		), 
		'nama_provinsi' => array(
			'title' => 'Provinsi',
			'filter' => 'text',
		), 
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $table = 'tb_app_rf_kota';
	public $primary_key = 'id_kota';
	public $form_data = array();
	
	function __construct()
	{
		parent::__construct();
		
		$this->form_data = array(
			'nama_kota' => array(
				'title' => 'Nama Kota',
				'col_width' => 'col-sm-7',
				'type' => 'text',
				'validate' => 'required',
			),
			'id_provinsi' => array(
				'title' => 'Provinsi',
				'col_width' => 'col-sm-7',
				'type' => 'select',
				'data' => $this->db->select('id_provinsi as value, nama_provinsi as text')->order_by('nama_provinsi','ASC')->get('tb_app_rf_provinsi')->result(),
				'validate' => 'required',
			),
		);
	}
	
	// protected CRUD function 
	protected function renderTable($kolom, $table, $primary_key)
	{
		$table = $this->db->select('kt.*, pr.nama_provinsi')->from($table.' kt')->join('tb_app_rf_provinsi pr', 'pr.id_provinsi=kt.id_provinsi');
		$data = $this->datatable->render($kolom, $table, $primary_key);
		return $data;
	}
	
	
}