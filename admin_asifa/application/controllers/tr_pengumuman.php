<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tr_pengumuman extends crud_controller {

	public $title = 'Pengumuman';
	public $table = 'tb_app_tr_pengumuman';
	public $primary_key = 'id_pengumuman';
	public $additional_script_main = 'tr_pengumuman/additional_main';
	public $additional_script_form = 'tr_pengumuman/additional_form';
	public $column = array
	(
		'judul' => array(
			'title' => 'Judul',
			'filter' => 'text',
		),
		'nama_kategori' => array(
			'title' => 'Kategori',
			'filter' => 'text',
			'width' => '15%',
			'attribut' => array('data-class' => 'text-center'),
		),
		'publish_date' => array(
			'title' => 'Tgl Publikasi',
			'filter' => 'text',
			'width' => '15%',
			'attribut' => array('data-class' => 'text-center'),
		),
		'create_date' => array(
			'title' => 'Tgl Buat',
			'filter' => 'text',
			'width' => '15%',
			'attribut' => array('data-class' => 'text-center'),
		),
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $form_data = array
	(
		'judul' => array(
			'title' => 'Judul',
			'type' => 'text',
			'validate' => 'required',
		),
		'id_kategori' => array(
			'title' => 'Kategori',
			'col_width' => 'col-sm-4',
			'type' => 'select',
			'validate' => 'required',
		),
		'publish_date' => array(
			'title' => 'Tgl Publikasi',
			'col_width' => 'col-sm-5',
			'type' => 'date',
			'validate' => 'required',
		),
		'pengumuman' => array(
			'title' => 'Pengumuman',
			'type' => 'textarea',
			'col_width' => 'col-sm-12 margin-t-10',
		),
		'pengumuman_encoded' => array(
			'title' => 'Pengumuman',
			'type' => 'hidden',
		),
	);
	
	function __construct()
	{
		parent::__construct();
		$this->form_data['publish_date']['default'] = date('Y-m-d');
		$this->form_data['id_kategori']['data'] = $this->db
			->select('id_kategori as value, nama_kategori as text')
			->get('tb_app_rf_kat_pengumuman')
			->result();
	}
	
	// protected CRUD function 
	protected function renderTable($kolom, $table, $primary_key)
	{
		$table = $this->db
			->select('tb.*, kt.nama_kategori')
			->from($table.' tb')
			->join('tb_app_rf_kat_pengumuman kt', 'kt.id_kategori = tb.id_kategori', 'left');
			
		$data = $this->datatable->render($kolom, $table, $primary_key);
		foreach($data->data as $key => $row)
		{
			$data->data[$key][2] = date('d/m/Y', strtotime($row[2]));
			$data->data[$key][3] = date('d/m/Y H:i:s', strtotime($row[3]));
			$data->data[$key][count($row)-1] = str_replace('data-toggle=\'modal\'', '', $row[count($row)-1]);
		}
		return $data;
	}
	
	protected function beforeSave($data, $id)
	{
		$data['pengumuman'] = base64_decode($data['pengumuman_encoded']);
		unset($data['pengumuman_encoded']);
		return $data;
	}
	
}