<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class keu_jenis extends crud_controller {

	public $title = 'Jenis Pembayaran';
	public $column = array
	(
		'kode_jenis' => array(
			'title' => 'Kode',
			'width' => '25%',
			'filter' => 'text',
		),
		'nama_jenis' => array(
			'title' => 'Nama',
			'filter' => 'text',
		),
		'tipe_jenis' => array(
			'title' => 'Tipe',
			'width' => '10%',
			'filter' => 'text',
		),
		'nominal_dasar' => array(
			'title' => 'Nominal Dasar',
			'width' => '10%',
			'filter' => 'text',
		),
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $table = 'tb_keu_rf_jenis_pembayaran';
	public $primary_key = 'kode_jenis';
	public $form_data = array
	(
		'kode_jenis' => array(
			'title' => 'Kode',
			'type' => 'text',
			'col_width' => 'col-sm-4',
			'validate' => 'required;code',
		),
		'nama_jenis' => array(
			'title' => 'Nama',
			'type' => 'text',
			'col_width' => 'col-sm-8',
			'validate' => 'required',
		),
		'tipe_jenis' => array(
			'title' => 'Tipe',
			'type' => 'select',
			'data' => array(
				array('value'=>'sekali_bayar', 'text'=>'Sekali Bayar'),
				array('value'=>'per_bulan', 'text'=>'Per Bulan'),
				array('value'=>'per_semester', 'text'=>'Per Semster'),
				array('value'=>'per_thn_ajaran', 'text'=>'Per Tahun Ajaran'),
			),
			'col_width' => 'col-sm-5',
			'validate' => 'required',
		),
		'nominal_dasar' => array(
			'title' => 'Nominal Dasar',
			'type' => 'currency',
			'col_width' => 'col-sm-5',
		),
	);
	
	// protected CRUD function 
	protected function renderTable($kolom, $table, $primary_key)
	{
		$data = $this->datatable->render($kolom, $table, $primary_key);
		foreach($data->data as $key => $row)
		{
			$data->data[$key][2] = ucwords(str_replace('_', ' ', $row[2]));
		}
		return $data;
	}
	
	
}