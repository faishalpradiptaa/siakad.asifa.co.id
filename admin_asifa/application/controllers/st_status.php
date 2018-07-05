<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class st_status extends crud_controller {

	public $title = 'Status';
	public $column = array
	(
		'kode_status' => array(
			'title' => 'Kode Status',
			'width' => '25%',
			'filter' => 'text',
		), 
		'nama_status' => array(
			'title' => 'Nama Status',
			'width' => '30%',
			'filter' => 'text',
		), 
		'tags' => array(
			'title' => 'Tags',
			'filter' => 'text',
		), 
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $table = 'tb_app_rf_status';
	public $primary_key = 'kode_status';
	public $form_data = array
	(
		'kode_status' => array(
			'title' => 'Kode Status',
			'type' => 'text',
			'validate' => 'required;code',
		),
		'nama_status' => array(
			'title' => 'Nama Status',
			'type' => 'text',
			'validate' => 'required',
		),
		'tags' => array(
			'title' => 'Tags',
			'type' => 'text',
		),
	);
	
	
}