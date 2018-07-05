<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rf_guru extends crud_controller {

	public $title = 'Guru';
	public $additional_script_main = 'rf_guru/additional_main';
	public $column = array
	(
		'no_induk' => array(
			'title' => 'No Induk',
			'filter' => 'text',
		),
		'nik' => array(
			'title' => 'NIK',
			'filter' => 'text',
		),
		'nip' => array(
			'title' => 'NIP',
			'filter' => 'text',
		),
		'nama' => array(
			'title' => 'Nama',
			'filter' => 'text',
		),
		'status_guru' => array(
			'title' => 'Aktif',
			'filter' => 'text',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center'),
		),
		'kota_lahir' => array(
			'title' => 'Tempat Lahir',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'tgl_lahir' => array(
			'title' => 'Tgl Lahir',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'jk' => array(
			'title' => 'JK',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'alamat' => array(
			'title' => 'Alamat',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'nama_agama' => array(
			'title' => 'Agama',
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
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $table = 'tb_akd_rf_guru';
	public $primary_key = 'no_induk';
	public $form_tabs = array(
		'tab_wajib' => array(
			'title' => 'Data Wajib'
		),
		'tab_optional' => array(
			'title' => 'Data Optional'
		),
	);
	
	function __construct()
	{
		parent::__construct();
		$this->form_data = array(
			'no_induk' => array(
				'title' => 'No Induk',
				'type' => 'text',
				'col_width' => 'col-sm-5',
				'validate' => 'required;code',
				'tab' => 'tab_wajib',
			),
			'nik' => array(
				'title' => 'NIK',
				'type' => 'text',
				'col_width' => 'col-sm-6',
				'tab' => 'tab_optional',
			),
			'nip' => array(
				'title' => 'NIP',
				'type' => 'text',
				'col_width' => 'col-sm-5',
				'validate' => 'required',
				'tab' => 'tab_wajib',
			),
			'nama' => array(
				'title' => 'Nama',
				'type' => 'text',
				'col_width' => 'col-sm-7',
				'validate' => 'required',
				'tab' => 'tab_wajib',
			),
			'status_guru' => array(
				'title' => 'Aktif',
				'type' => 'switch',
				'on' => 'Ya',
				'off' => 'Tidak',
				'on_value' => 'active',
				'off_value' => 'not_active',
				'tab' => 'tab_wajib',
			),
			'tempat_lahir' => array(
				'title' => 'Tempat Lahir',
				'type' => 'select',
				'data' => $this->db->select('id_kota as value, nama_kota as text')->order_by('nama_kota','ASC')->get('tb_app_rf_kota')->result(),
				'col_width' => 'col-sm-5',
				'tab' => 'tab_optional',
			),
			'tgl_lahir' => array(
				'title' => 'Tgl Lahir',
				'type' => 'date',
				'col_width' => 'col-sm-4',
				'tab' => 'tab_optional',
			),
			'jk' => array(
				'title' => 'JK',
				'type' => 'radio',
				'data' => array((object)array('text' => 'Laki - Laki', 'value' => 'l'), (object)array('text' => 'Perempuan', 'value' => 'p')),
				'default' => 'l',
				'validate' => 'required',
				'tab' => 'tab_wajib',
			),
			'alamat' => array(
				'title' => 'Alamat',
				'type' => 'text',
				'tab' => 'tab_optional',
			),
			'agama' => array(
				'title' => 'Agama',
				'type' => 'select',
				'data' => $this->db->select('kode_agama as value, nama_agama as text')->get('tb_akd_rf_agama')->result(),
				'col_width' => 'col-sm-4',
				'tab' => 'tab_optional',
			),
			'telp' => array(
				'title' => 'Telp',
				'type' => 'text',
				'col_width' => 'col-sm-5',
				'tab' => 'tab_optional',
			),
			'email' => array(
				'title' => 'Email',
				'type' => 'email',
				'col_width' => 'col-sm-5',
				'tab' => 'tab_optional',
			),
		);
	}
	
	// protected CRUD function 
	protected function renderTable($kolom, $table, $primary_key)
	{
		$table = $this->db
			->select('tb.*, kt.nama_kota as kota_lahir, ag.nama_agama')
			->from($table.' tb')
			->join('tb_app_rf_kota kt', 'kt.id_kota = tb.tempat_lahir', 'left')
			->join('tb_akd_rf_agama ag', 'ag.kode_agama = tb.agama', 'left');
			
		$data = $this->datatable->render($kolom, $table, $primary_key);
		foreach($data->data as $key => $row)
		{
			$data->data[$key][4] = '<input type="checkbox" name="'.my_base64_encode($row[0]).'" value="active" '.($row[4] == 'active' ? 'checked' : '').' class="main-switch" data-on-text="Ya" data-off-text="Tidak">';
		}
		return $data;
	}
	
	
	// public method 
	public function state($enc_kode, $state)
	{
		$this->load->model('mod_guru');
		$kode = base64_decode($enc_kode);
		$status = $state == 'true' ? 'active' : 'not_active';
		echo $this->mod_guru->changeStatus($kode, $status) ? 'ok' : 'not ok';
	}
	
	public function autocomplete($limit=10)
	{
		$this->load->model('mod_guru');
		$result = array(
			"total_count" => $limit,
			"incomplete_results" => false,
			"items" => $this->mod_guru->getDataAutoComplete($limit),
		);
		echo json_encode($result);
	}
	
}