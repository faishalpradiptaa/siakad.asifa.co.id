<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class st_agama extends crud_controller {

	public $title = 'Agama';
	public $column = array
	(
		'kode_agama' => array(
			'title' => 'Kode Agama',
			'width' => '25%',
			'filter' => 'text',
		), 
		'nama_agama' => array(
			'title' => 'Nama Agama',
			'filter' => 'text',
		), 
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $table = 'tb_akd_rf_agama';
	public $primary_key = 'kode_agama';
	public $form_data = array
	(
		'kode_agama' => array(
			'title' => 'Kode Agama',
			'type' => 'text',
			'validate' => 'required;code',
		),
		'nama_agama' => array(
			'title' => 'Nama Agama',
			'type' => 'text',
			'validate' => 'required',
		),
	);
	
	
}