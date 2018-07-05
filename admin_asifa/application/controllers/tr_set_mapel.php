<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tr_set_mapel extends crud_periodik_controller {

	public $title = 'Pembagian Kelas Siswa';
	public $column = array
	(
		'no_induk' => array(
			'title' => 'No. Induk',
			'filter' => 'text',
			'width' => '10%'
		),
		'nisn' => array(
			'title' => 'NISN',
			'filter' => 'text',
			'width' => '10%'
		),
		'nama' => array(
			'title' => 'Nama',
			'filter' => 'text',
		),
		'nama_status' => array(
			'title' => 'Status',
			'filter' => 'text',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center'),
		),
		'angkatan' => array(
			'title' => 'Angkatan',
			'filter' => 'text',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center'),			
		),
		'nama_sekolah' => array(
			'title' => 'Sekolah',
			'filter' => 'text',
			'width' => '15%',
			'attribut' => array('data-class' => 'text-center'),			
		),
		'nama_jurusan' => array(
			'title' => 'Jurusan',
			'filter' => 'text',
			'width' => '10%',
		),
		'tahun_lahir' => array(
			'title' => 'Tahun Lahir',
			'filter' => 'text',
			'attribut' => array('data-visible'=>'false'),
		),
		'telp' => array(
			'title' => 'Telp',
			'filter' => 'text',
			'attribut' => array('data-visible'=>'false'),
		),
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $table = 'tb_akd_tr_ambil_kelas';
	public $primary_key = 'id_ambil_kelas';
	public $additional_script_main = 'tr_set_mapel/additional_main';
	
	public $allow_import = false;
	public $allow_delete = false;
	
	
	// protected CRUD function 
	protected function beforeMain($pack)
	{
		$this->crud_periodik_model->set('tb_akd_rf_kelas', 'kode_kelas');
		$pack['kelas'] = $this->crud_periodik_model->getAllData();
		return $pack;
	}
	
	protected function renderTable($kolom, $table, $primary_key)
	{
		$kelas = $_GET['kelas'];
		$table = $this->db
			->select('ak.id_ambil_kelas, sw.no_induk, sw.nisn, sw.nama, sw.angkatan, sw.tahun_lahir, sw.telp, st.nama_status, sk.nama_sekolah, jr.nama_jurusan')
			->from($table.' ak')
			->join('tb_akd_rf_siswa sw', 'sw.no_induk=ak.no_induk')
			->join('tb_app_rf_status st', 'st.kode_status = sw.status_akademis')
			->join('tb_akd_rf_sekolah sk', 'sk.kode_sekolah = ak.kode_sekolah', 'left')
			->join('tb_akd_rf_jurusan jr', 'jr.kode_jurusan = ak.kode_jurusan', 'left')
			->where('ak.kode_thn_ajaran', THN_AJARAN)
			->where('ak.kode_jenjang', JENJANG)
			->where('ak.kode_kelas', $kelas);

		$kolom['field'][] = 'id_ambil_kelas';
		$pos = count($kolom['field'])-2;
		$pos_id = count($kolom['field'])-1;
		
		$data = $this->datatable->render($kolom, $table, $primary_key);
		
		foreach($data->data as $key => $row)
		{
			$data->data[$key][$pos] = !$row[$pos_id] ? '' : '<a href="'.site_url(PAGE_ID.'/form/'.my_base64_encode($row[$pos_id])).'" class="btn btn-xs btn-primary" data-original-title="Ubah" rel="tooltip" data-toggle="modal" data-target="#main-modal-lg"><i class="fa fa-pencil"></i></a>';
		}
		return $data;
	}	
	
	// public function
	public function form($enc_id_kelas = false)
	{
		$this->load->model('mod_kelas');
		$this->load->model('mod_mapel');
		
		if ($this->input->server('REQUEST_METHOD') == 'POST') 
		{
			$res = $this->mod_mapel->assignSiswa($_POST['siswa'], $_POST['mapel']);
			die($res ? 'ok' : 'not ok');
		}
		$pack = array(
			'kelas' => $this->mod_kelas->getAllData(),
			'id_ambil_kelas' => $enc_id_kelas ? base64_decode($enc_id_kelas) : false,
		);
		$this->load->view('tr_set_mapel/v_form', $pack);
	}
	
	public function get_siswa($id_ambil_kelas = false)
	{
		if(!isset($_GET['kelas']) || !$_GET['kelas']) return false;
		
		$this->load->model('mod_mapel');	
		$data = $this->mod_mapel->getMapelSiswaByKelas($_GET['kelas'], $id_ambil_kelas);
		echo json_encode($data);
	}
	
}