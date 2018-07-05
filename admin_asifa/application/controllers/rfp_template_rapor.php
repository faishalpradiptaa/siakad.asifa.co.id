<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rfp_template_rapor extends crud_periodik_controller {

	public $title = 'Template Rapor';
	public $column = array
	(
		'kode_template' => array(
			'title' => 'Kode',
			'filter' => 'text',
			'width' => '15%'
		), 
		'nama_template' => array(
			'title' => 'Nama',
			'filter' => 'text',
		), 
		'nama_jenis' => array(
			'title' => 'Jenis',
			'filter' => 'select',
			'width' => '15%',
			'filter_field' => 'tmp.kode_jenis',
			'filter_operator' => '=',
		), 
		'nama_sekolah' => array(
			'title' => 'Sekolah',
			'filter' => 'text',
		), 
		'view_template' => array(
			'title' => 'View Template',
			'attribut' => array('data-visible' => 'false'),
		), 
		'print_template' => array(
			'title' => 'Print Template',
			'attribut' => array('data-visible' => 'false'),
		), 
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $table = 'tb_akd_rf_template_rapor';
	public $primary_key = 'kode_template';
	public $form_data = array();
	
	function __construct()
	{
		parent::__construct();
		
		$jenis = $this->db->select('kode_jenis as value, nama_jenis as text')->order_by('nama_jenis','ASC')->get('tb_akd_rf_jenis_rapor')->result();
		$sekolah = $this->db->select('kode_sekolah as value, nama_sekolah as text')->order_by('nama_sekolah','ASC')->get('tb_akd_rf_sekolah')->result();
		
		$this->column['nama_jenis']['filter_data'] = $jenis;
		
		$this->form_data = array(
			'kode_template' => array(
				'title' => 'Kode',
				'type' => 'text',
				'col_width' => 'col-sm-5',
				'validate' => 'required;code',
			), 
			'nama_template' => array(
				'title' => 'Nama',
				'type' => 'text',
				'col_width' => 'col-sm-7',
				'validate' => 'required',
			), 
			'kode_jenis' => array(
				'title' => 'Jenis Rapor',
				'type' => 'select',
				'data' => $jenis,
				'col_width' => 'col-sm-5',
				'validate' => 'required',
			), 
			/*'kode_sekolah' => array(
				'title' => 'Sekolah',
				'type' => 'select',
				'data' => $sekolah,
				'col_width' => 'col-sm-8',
			),
			*/
			'rumus_ip' => array(
				'title' => 'Rumus IP',
				'type' => 'text',
				'col_width' => 'col-sm-9',
			), 
			'ttd_1' => array(
				'title' => 'TTD 1',
				'type' => 'text',
				'col_width' => 'col-sm-9',
			),
			'nama_ttd_1' => array(
				'title' => 'Nama TTD 1',
				'type' => 'text',
				'col_width' => 'col-sm-9',
			), 
			'ttd_2' => array(
				'title' => 'TTD 2',
				'type' => 'text',
				'col_width' => 'col-sm-9',
			), 
			'nama_ttd_2' => array(
				'title' => 'Nama TTD 2',
				'type' => 'text',
				'col_width' => 'col-sm-9',
			), 
			'view_template' => array(
				'title' => 'View Template',
				'type' => 'text',
				'col_width' => 'col-sm-6',
				'validate' => 'required',
			), 
			'print_template' => array(
				'title' => 'Print Template',
				'type' => 'text',
				'col_width' => 'col-sm-6',
				'validate' => 'required',
			), 
		);
	}
	
	// protected CRUD function 
	protected function renderTable($kolom, $table, $primary_key)
	{
		$table = $this->db
			->select('tmp.*, jn.nama_jenis')
			->from($table.' tmp')
			->join('tb_akd_rf_jenis_rapor jn', 'jn.kode_jenis=tmp.kode_jenis')
			->join('tb_akd_rf_sekolah sk', 'sk.kode_sekolah=tmp.kode_sekolah', 'left')
			->where('tmp.kode_thn_ajaran', THN_AJARAN)
			->where('tmp.kode_jenjang',JENJANG);
		$data = $this->datatable->render($kolom, $table, $primary_key);
		if(is_array)foreach($data->data as $key => $row)
		{
			$url = site_url(PAGE_ID.'/structure/'.my_base64_encode($row[0]));
			$data->data[$key][count($row)-1] .= ' <a href="'.$url.'" class="btn btn-xs btn-success" data-original-title="Atur Sususan" rel="tooltip"><i class="fa fa-file"></i></a>';
		}
		return $data;
	}
	
	// public function
	public function import($kode_thn_ajaran)
	{
		$this->load->model('mod_template_rapor');
		$res = $this->mod_template_rapor->import($kode_thn_ajaran);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function structure($enc_kode)
	{
		$this->load->model('mod_template_rapor');
		$kode = base64_decode($enc_kode);
		$pack = array(
			'raw_kode' => $enc_kode,
			'kode' => $kode,
			'detail' => $this->mod_template_rapor->getDetail($kode),
			'point' => $this->mod_template_rapor->getTreePoint($kode),
		);
		$this->load->template('rfp_template_rapor/structure-main', $pack);
	}
	
	public function form_point($enc_kode_template, $enc_id = false)
	{
		$this->load->model('mod_template_rapor');
		$kode_template = base64_decode($enc_kode_template);
		$id = $enc_id ? base64_decode($enc_id) : false;
		
		if ($this->input->server('REQUEST_METHOD') == 'POST') 
		{
			$data = array(
				'kode_point' => $_POST['kode_point'],
				'nama_point' => $_POST['nama_point'],
				'text_point' => $_POST['text_point'],
				'tipe_point' => $_POST['tipe_point'],
				'param_point' => $_POST['param_point'] ? json_encode($_POST['param_point']) : null,
			);
			$res = $this->mod_template_rapor->savePoint($kode_template, $id, $data);
			die($res ? 'ok' : 'not ok');
		}

		$this->load->model('crud_model');
		$this->load->model('mod_mapel');
		$this->crud_model->set('tb_akd_rf_jenis_riwayat', 'kode_jenis');		
		$template = $this->mod_template_rapor->getDetail($kode_template);
		
		$pack = array(
			'raw_kode_template' => $enc_kode_template,
			'kode_template' => $kode_template,
			'raw_id' => $enc_id,
			'id' => $id,
			'jenis_riwayat' => $this->crud_model->getAllData(),
			'mapel' => $this->mod_mapel->getMapelByJenisRapor($template->kode_jenis),
			'data' => $id ? $this->mod_template_rapor->getDetailPoint($kode_template, $id) : false,
		);
		$this->load->view('rfp_template_rapor/structure-form', $pack);
	}
	
	public function delete_point($enc_kode_template, $enc_id)
	{
		$this->load->model('mod_template_rapor');
		$kode_template = base64_decode($enc_kode_template);
		$id = $enc_id ? base64_decode($enc_id) : false;
		$res = $this->mod_template_rapor->deletePoint($kode_template, $id);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function sort_point($enc_kode_template)
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') 
		{
			$this->load->model('mod_template_rapor');
			$kode_template = base64_decode($enc_kode_template);
			$data = json_decode($_POST['data_json']);
			$res = $this->mod_template_rapor->sortPoint($kode_template, $data);
			die($res ? 'ok' : 'not ok');
		}
	}
	
	
	
	
}