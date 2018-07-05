<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class st_jenis_riwayat extends crud_controller {

	public $title = 'Jenis Riwayat';
	public $column = array
	(
		'kode_jenis' => array(
			'title' => 'Kode Absensi',
			'width' => '25%',
			'filter' => 'text',
		), 
		'nama_jenis' => array(
			'title' => 'Nama Riwayat',
			'width' => '30%',
			'filter' => 'text',
		), 
		'keterangan' => array(
			'title' => 'Keterangan',
			'filter' => 'text',
		), 
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $table = 'tb_akd_rf_jenis_riwayat';
	public $primary_key = 'kode_jenis';
	public $form_data = array
	(
		'kode_jenis' => array(
			'title' => 'Kode Absensi',
			'type' => 'text',
			'validate' => 'required;code',
		),
		'nama_jenis' => array(
			'title' => 'Nama Riwayat',
			'type' => 'text',
			'validate' => 'required',
		),
		'keterangan' => array(
			'title' => 'Keterangan',
			'type' => 'text',
		),
	);
	
	
}