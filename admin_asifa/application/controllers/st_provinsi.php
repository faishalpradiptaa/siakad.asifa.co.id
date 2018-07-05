<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class st_provinsi extends crud_controller {

	public $title = 'Provinsi';
	public $column = array
	(
		'nama_provinsi' => array(
			'title' => 'Nama Provinsi',
			'filter' => 'text',
		), 
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $table = 'tb_app_rf_provinsi';
	public $primary_key = 'id_provinsi';
	public $form_data = array
	(
		'nama_provinsi' => array(
			'title' => 'Nama Provinsi',
			'col_width' => 'col-sm-7',
			'type' => 'text',
			'validate' => 'required',
		),
	);
	
	
}