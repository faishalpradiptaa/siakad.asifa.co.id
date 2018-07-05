<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rf_jurusan extends crud_controller {

	public $title = 'Jurusan';
	public $column = array
	(
		'kode_jurusan' => array(
			'title' => 'Kode Jurusan',
			'width' => '25%',
			'filter' => 'text',
		), 
		'nama_jurusan' => array(
			'title' => 'Nama Jurusan',
			'width' => '30%',
			'filter' => 'text',
		), 
		'deskripsi' => array(
			'title' => 'Deskripsi',
			'filter' => 'text',
		), 
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $table = 'tb_akd_rf_jurusan';
	public $primary_key = 'kode_jurusan';
	public $form_data = array
	(
		'kode_jurusan' => array(
			'title' => 'Kode Jurusan',
			'type' => 'text',
			'validate' => 'required;code',
		),
		'nama_jurusan' => array(
			'title' => 'Nama Jurusan',
			'type' => 'text',
			'validate' => 'required',
		),
		'deskripsi' => array(
			'title' => 'Deskripsi',
			'type' => 'text',
		),
	);
	
	
}