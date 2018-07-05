<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rfp_mapel extends crud_periodik_controller {

	public $title = 'Mata Pelajaran';
	public $column = array
	(
		'kode_mp' => array(
			'title' => 'Kode',
			'filter' => 'text',
			'width' => '15%'
		), 
		'nama_mp' => array(
			'title' => 'Nama',
			'filter' => 'text',
		), 
		'nama_kelompok' => array(
			'title' => 'Kelompok',
			'filter' => 'select',
			'filter_field' => 'mp.kode_kelompok',
		), 
		'nama_jurusan' => array(
			'title' => 'Jurusan',
			'filter' => 'text',
			'width' => '12%',
			'attribut' => array('data-class' => 'text-center', 'data-visible' => 'false'),
		), 
		'kkm' => array(
			'title' => 'KKM',
			'width' => '7%',
			'attribut' => array('data-class' => 'text-center', 'data-visible' => 'false'),
		), 
		'sks' => array(
			'title' => 'SKS',
			'width' => '7%',
			'attribut' => array('data-class' => 'text-center', 'data-visible' => 'false'),
		), 
		'urutan' => array(
			'title' => 'Urutan',
			'width' => '7%',
			'attribut' => array('data-class' => 'text-center', 'data-visible' => 'false'),
		), 
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $table = 'tb_akd_rf_mp';
	public $primary_key = 'kode_mp';
	public $additional_script_form = 'rfp_mapel/additional_form';
	public $additional_script_detail = 'rfp_mapel/additional_detail';
	public $form_data = array();
	
	function __construct()
	{
		parent::__construct();
		
		$kelompok = $this->db
			->select('kode_kelompok as value, concat(kode_kelompok, " - ", nama_kelompok) as text, kode_jenis_rapor as additional', false)
			->order_by('kode_kelompok','ASC')
			->where('kode_thn_ajaran', THN_AJARAN)
			->where('kode_jenjang', JENJANG)
			->get('tb_akd_rf_kelompok_mp')
			->result();
		
		$this->column['nama_kelompok']['filter_data'] = $kelompok;		
		
		$this->form_data = array(
			'kode_mp' => array(
				'title' => 'Kode',
				'type' => 'text',
				'col_width' => 'col-sm-5',
				'validate' => 'required;code',
			), 
			'nama_mp' => array(
				'title' => 'Nama',
				'type' => 'text',
				'col_width' => 'col-sm-7',
				'validate' => 'required',
			), 
			'kode_kelompok' => array(
				'title' => 'Kelompok',
				'type' => 'select',
				'data' => $kelompok,
				'col_width' => 'col-sm-8',
				'validate' => 'required',
			), 
			'kode_jurusan' => array(
				'title' => 'Jurusan',
				'type' => 'select',
				'data' => $this->db->select('kode_jurusan as value, nama_jurusan as text')->order_by('nama_jurusan','ASC')->get('tb_akd_rf_jurusan')->result(),
				'col_width' => 'col-sm-8',
			), 
			'kkm' => array(
				'title' => 'KKM',
				'type' => 'number',
				'default' => 0,
				'col_width' => 'col-sm-3',
				'validate' => 'required',
			), 
			'sks' => array(
				'title' => 'SKS',
				'type' => 'number',
				'default' => 0,
				'col_width' => 'col-sm-3',
				'validate' => 'required',
			), 
			'urutan' => array(
				'title' => 'Urutan',
				'filter' => 'number',
				'default' => 0,
				'col_width' => 'col-sm-3',
			), 
			
		);
	}
	
	// protected CRUD function 
	protected function renderTable($kolom, $table, $primary_key)
	{
		$table = $this->db
			->select('mp.*, concat(mp.kode_kelompok, " - ", nama_kelompok) as nama_kelompok, jr.nama_jurusan', false)
			->from($table.' mp')
			->join('tb_akd_rf_kelompok_mp kl', 'mp.kode_kelompok=kl.kode_kelompok AND mp.kode_thn_ajaran=kl.kode_thn_ajaran AND mp.kode_jenjang=kl.kode_jenjang')
			->join('tb_akd_rf_jurusan jr', 'mp.kode_jurusan=jr.kode_jurusan', 'left')
			->where('mp.kode_thn_ajaran', THN_AJARAN)
			->where('mp.kode_jenjang', JENJANG);
		$data = $this->datatable->render($kolom, $table, $primary_key);
		return $data;
	}
	
	protected function beforeDetail($pack, $id)
	{
		$this->load->model('mod_mapel');
		$pack['deskripsi'] = $this->mod_mapel->getSingleMapelDeskripsi($id);
		return $pack;
	}
	
	protected function beforeForm($pack, $id)
	{
		$this->load->model('mod_mapel');
		$pack['deskripsi'] = $this->mod_mapel->getSingleMapelDeskripsi($id);
		return $pack;
	}
	
	protected function afterSave($data, $id, $res)
	{
		if(!$res) return $res;
		$this->load->model('mod_mapel');
		$data_aspek = array();
		if(isset($_POST['aspek_kode'])) foreach($_POST['aspek_kode'] as $key => $kode_aspek) $data_aspek[$kode_aspek] = $_POST['aspek_deskripsi'][$key];
		$this->mod_mapel->saveDeskripsiMapel($data['kode_mp'], $data_aspek);
		return $res;		
	}
	
	// public function
	public function autocomplete($limit=10)
	{
		$this->load->model('mod_mapel');
		$result = array(
			"total_count" => $limit,
			"incomplete_results" => false,
			"items" => $this->mod_mapel->getDataAutoComplete($limit),
		);
		echo json_encode($result);
	}
	
	
}