<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class st_jenis_rapor extends crud_controller {

	public $title = 'Jenis Rapor';
	public $column = array
	(
		'kode_jenis' => array(
			'title' => 'Kode Rapor',
			'width' => '25%',
			'filter' => 'text',
		), 
		'nama_jenis' => array(
			'title' => 'Nama Rapor',
			'filter' => 'text',
		), 
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $table = 'tb_akd_rf_jenis_rapor';
	public $primary_key = 'kode_jenis';
	public $form_data = array
	(
		'kode_jenis' => array(
			'title' => 'Kode Rapor',
			'type' => 'text',
			'validate' => 'required;code',
		),
		'nama_jenis' => array(
			'title' => 'Nama Rapor',
			'type' => 'text',
			'validate' => 'required',
		),
	);
	
	
}