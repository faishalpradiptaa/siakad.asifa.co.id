<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class st_ekskul extends crud_controller {

	public $title = 'Ekstrakurikuler';
	public $column = array
	(
		'kode_ekskul' => array(
			'title' => 'Kode Ekskul',
			'width' => '25%',
			'filter' => 'text',
		), 
		'nama_ekskul' => array(
			'title' => 'Nama Ekskul',
			'filter' => 'text',
		), 
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $table = 'tb_akd_rf_ekskul';
	public $primary_key = 'kode_ekskul';
	public $form_data = array
	(
		'kode_ekskul' => array(
			'title' => 'Kode Ekskul',
			'type' => 'text',
			'validate' => 'required;code',
		),
		'nama_ekskul' => array(
			'title' => 'Nama Ekskul',
			'type' => 'text',
			'validate' => 'required',
		),
	);
	
	
}