<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rf_sekolah extends crud_controller {

	public $title = 'Sekolah';
	public $column = array
	(
		'kode_sekolah' => array(
			'title' => 'Kode',
			'filter' => 'text',
		),
		'nama_sekolah' => array(
			'title' => 'Nama',
			'filter' => 'text',
		),
		'npsn' => array(
			'title' => 'NPSN',
			'filter' => 'text',
		),
		'nis' => array(
			'title' => 'NIS',
			'filter' => 'text',
		),
		'jenjang' => array(
			'title' => 'Jenjang',
			'filter' => 'text',
		),
		'alamat' => array(
			'title' => 'Alamat',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'kode_pos' => array(
			'title' => 'Kode Pos',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'kelurahan' => array(
			'title' => 'Kelurahan',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'kecamatan' => array(
			'title' => 'Kecamatan',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'nama_kota' => array(
			'title' => 'Kota',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'telp' => array(
			'title' => 'Telp',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'email' => array(
			'title' => 'Email',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'website' => array(
			'title' => 'Website',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'kepsek' => array(
			'title' => 'Kepsek',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'nip_kepsek' => array(
			'title' => 'Nip Kepsek',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $table = 'tb_akd_rf_sekolah';
	public $primary_key = 'kode_sekolah';
	public $form_data = array();
	public $form_tabs = array(
		'tab_identitas' => array(
			'title' => 'Identitas Sekolah'
		),
		'tab_alamat' => array(
			'title' => 'Lokasi Sekolah'
		),
		'tab_kontak' => array(
			'title' => 'Kontak Sekolah'
		)
	);
	

	function __construct()
	{
		parent::__construct();
		$this->form_data = array
		(
			'kode_sekolah' => array(
				'title' => 'Kode',
				'tab' => 'tab_identitas',
				'type' => 'text',
				'col_width' => 'col-sm-4',
				'validate' => 'required;code',
			),
			'nama_sekolah' => array(
				'title' => 'Nama',
				'tab' => 'tab_identitas',
				'type' => 'text',
				'validate' => 'required',
			),
			'npsn' => array(
				'title' => 'NPSN',
				'tab' => 'tab_identitas',
				'type' => 'text',
				'col_width' => 'col-sm-5',
				'validate' => 'required',
			),
			'nis' => array(
				'title' => 'NIS',
				'tab' => 'tab_identitas',
				'type' => 'text',
				'col_width' => 'col-sm-5',
				'validate' => 'required',
			),
			'jenjang' => array(
				'title' => 'Jenjang',
				'tab' => 'tab_identitas',
				'col_width' => 'col-sm-4',
				'type' => 'select',
				'data' => $this->db->select('kode_jenjang as value, nama_jenjang as text')->get('tb_akd_rf_jenjang')->result(),
				'validate' => 'required',
			),
			'alamat' => array(
				'title' => 'Alamat',
				'tab' => 'tab_alamat',
				'type' => 'text',
				'validate' => 'required',
			),
			'kode_pos' => array(
				'title' => 'Kode Pos',
				'tab' => 'tab_alamat',
				'type' => 'text',
				'col_width' => 'col-sm-3',
			),
			'kelurahan' => array(
				'title' => 'Kelurahan',
				'tab' => 'tab_alamat',
				'type' => 'text',
			),
			'kecamatan' => array(
				'title' => 'Kecamatan',
				'tab' => 'tab_alamat',
				'type' => 'text',
			),
			'kota' => array(
				'title' => 'Kota',
				'tab' => 'tab_alamat',
				'type' => 'select',
				'data' => $this->db->select('id_kota as value, nama_kota as text')->order_by('nama_kota','ASC')->get('tb_app_rf_kota')->result(),
				'col_width' => 'col-sm-6',
			),
			'telp' => array(
				'title' => 'Telp',
				'tab' => 'tab_kontak',
				'type' => 'text',
				'col_width' => 'col-sm-5',
			),
			'email' => array(
				'title' => 'Email',
				'tab' => 'tab_kontak',
				'type' => 'text',
				'col_width' => 'col-sm-5',
			),
			'website' => array(
				'title' => 'Website',
				'tab' => 'tab_kontak',
				'type' => 'text',
				'col_width' => 'col-sm-5',
			),
			'kepsek' => array(
				'title' => 'Kepsek',
				'tab' => 'tab_identitas',
				'type' => 'text',
			),
			'nip_kepsek' => array(
				'title' => 'Nip Kepsek',
				'tab' => 'tab_identitas',
				'type' => 'text',
				'col_width' => 'col-sm-5',
			)
		);
		
	}
	
	// protected CRUD function 
	protected function renderTable($kolom, $table, $primary_key)
	{
		$table = $this->db
						->select('tb.*, kt.nama_kota')
						->from($table.' tb')
						->join('tb_app_rf_kota kt', 'kt.id_kota = tb.kota', 'left');
						
		$data = $this->datatable->render($kolom, $table, $primary_key);
		return $data;
	}
	
	
}