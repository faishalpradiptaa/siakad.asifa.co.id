<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rf_kat_pengumuman extends crud_controller {

	public $title = 'Kategori Pengumuman';
	public $column = array
	(
		'nama_kategori' => array(
			'title' => 'Nama',
			'filter' => 'text',
		),
		'icon' => array(
			'title' => 'Icon',
			'filter' => 'text',
			'width' => '20%',
			'attribut' => array('data-class' => 'text-center'),
		),
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $table = 'tb_app_rf_kat_pengumuman';
	public $primary_key = 'id_kategori';
	public $form_data = array
	(
		'nama_kategori' => array(
			'title' => 'Nama Kategori',
			'type' => 'text',
			'col_width' => 'col-sm-6',
			'validate' => 'required',
		),
		'icon' => array(
			'title' => 'Icon',
			'type' => 'text',
			'col_width' => 'col-sm-4',
		),
	);
	
}