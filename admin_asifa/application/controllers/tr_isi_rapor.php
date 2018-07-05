<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tr_isi_rapor extends crud_periodik_controller {

	public $title = 'Pengisian Rapor';
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
		
		'angkatan' => array(
			'title' => 'Angkatan',
			'filter' => 'text',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-visible'=>'false'),			
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
		'status_rapor' => array(
			'title' => 'Status Rapor',
			'filter' => 'select',
			'filter_data' => array( 
				array('value'=>'-1', 'text'=>'Belum Diisi'), 
				array('value'=>'valid', 'text'=>'Valid'), 
				array('value'=>'invalid', 'text'=>'Belum Valid'), 
			),
			'filter_field' => 'COALESCE(rp.status,"-1")',
			'filter_operator' => '=',
			'width' => '15%',
			'attribut' => array('data-class' => 'text-center'),
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
			'title' => 'Isi Rapor',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $table = 'tb_akd_tr_ambil_kelas';
	public $primary_key = 'id_ambil_kelas';
	public $additional_script_main = 'tr_isi_rapor/additional_main';
	
	public $allow_update = false;
	public $allow_delete = false;
	public $allow_import = false;
	
	
	// protected CRUD function 
	protected function beforeMain($pack)
	{
		$this->crud_periodik_model->set('tb_akd_rf_kelas', 'kode_kelas');
		$pack['kelas'] = $this->crud_periodik_model->getAllData();
		
		$kode_template = $this->uri->segment(3);
		$this->load->model('crud_periodik_model');
		$this->crud_periodik_model->set('tb_akd_rf_template_rapor', 'kode_template');
		$pack['template_rapor'] = $this->crud_periodik_model->getSingleData($kode_template);
		$this->title .= ' '.$pack['jenis_rapor']->nama_jenis;
		return $pack;
	}
	
	protected function renderTable($kolom, $table, $primary_key)
	{
		$kode_template = $this->uri->segment(3);
		$kelas = $_GET['kelas'];
	
		$table = $this->db
			->select('ak.id_ambil_kelas, sw.no_induk, sw.nisn, sw.nama, sw.angkatan, sw.tahun_lahir, sw.telp, str.nama_status as status_rapor, sk.nama_sekolah, jr.nama_jurusan', false)
			->from($table.' ak')
			->join('tb_akd_rf_siswa sw', 'sw.no_induk=ak.no_induk')
			->join('tb_akd_rf_sekolah sk', 'sk.kode_sekolah = ak.kode_sekolah AND sk.jenjang=ak.kode_jenjang', 'left')
			->join('tb_akd_rf_jurusan jr', 'jr.kode_jurusan = ak.kode_jurusan', 'left')
			->join('tb_akd_tr_rapor rp', 'rp.id_ambil_kelas=ak.id_ambil_kelas AND rp.kode_thn_ajaran=ak.kode_thn_ajaran AND rp.kode_jenjang=ak.kode_jenjang AND rp.kode_temp_rapor="'.$kode_template.'"', 'left')
			->join('tb_app_rf_status str', 'str.kode_status = rp.status', 'left')
			->where('ak.kode_thn_ajaran', THN_AJARAN)
			->where('ak.kode_jenjang', JENJANG)
			->where('ak.kode_kelas', $kelas);
		
		$kolom['field'][] = 'id_ambil_kelas';
		$pos = count($kolom['field'])-2;
		$pos_id = count($kolom['field'])-1;
		
		$data = $this->datatable->render($kolom, $table, $primary_key);
		
		foreach($data->data as $key => $row)
		{
			$data->data[$key][$pos] = '
				<a href="'.site_url(PAGE_ID.'/form/'.$kode_template.'/'.my_base64_encode($row[$pos_id])).'" class="btn btn-xs btn-primary" data-original-title="Isi Rapor" rel="tooltip"><i class="fa fa-pencil"></i></a> 
				<a href="'.site_url(PAGE_ID.'/view/'.$kode_template.'/'.my_base64_encode($row[$pos_id])).'" class="btn btn-xs btn-success" data-original-title="Lihat Rapor" rel="tooltip"><i class="fa fa-file"></i></a>';
		}
		return $data;
	}	
	
	// public function
	public function form($kode_template, $enc_id_ambil_kelas)
	{
		$id_ambil_kelas = base64_decode($enc_id_ambil_kelas);
		
		$this->load->model('mod_template_rapor');
		$this->load->model('mod_siswa');
		$this->load->model('mod_rapor');
		
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$data = array(
				'custom' => isset($_POST['custom']) ? $_POST['custom'] : false,
				'mapel' => isset($_POST['mapel']) ? $_POST['mapel'] : false,
				'ringkasan_mapel' => isset($_POST['ringkasan_mapel']) ? $_POST['ringkasan_mapel'] : false,
				'ekskul' => isset($_POST['ekskul']) ? $_POST['ekskul'] : false,
				'prestasi' => isset($_POST['prestasi']) ? $_POST['prestasi'] : false,
				'deskripsi' => isset($_POST['deskripsi']) ? $_POST['deskripsi'] : false,
				'data' => isset($_POST['data']) ? $_POST['data'] : false,
			);
			$res = $this->mod_rapor->save($kode_template, $id_ambil_kelas, $data);
			redirect($_SERVER['HTTP_REFERER']);			
		}
		
		$pack = array(
			'template' => $this->mod_template_rapor->getDetail($kode_template),
			'siswa' => $this->mod_siswa->getDetailByIdAmbilKelas($id_ambil_kelas),
			'rapor' => $this->mod_rapor->getPropertyRapor($kode_template, $id_ambil_kelas),
		);
		
		$pack['form'] = $this->mod_template_rapor->getTemplateForm($kode_template, $pack['siswa']);
		$this->title = $pack['template']->nama_template;
		$this->load->template('tr_isi_rapor/v_form', $pack);
	}
	
	public function view($kode_template, $enc_id_ambil_kelas)
	{
		$id_ambil_kelas = base64_decode($enc_id_ambil_kelas);
		
		$this->load->model('mod_template_rapor');
		$this->load->model('mod_siswa');
		$this->load->model('mod_rapor');
		
		
		$pack = array(
			'template' => $this->mod_template_rapor->getDetail($kode_template),
			'siswa' => $this->mod_siswa->getDetailByIdAmbilKelas($id_ambil_kelas),
			'rapor' => $this->mod_rapor->getPropertyRapor($kode_template, $id_ambil_kelas),
		);
		$pack['view'] = $this->mod_template_rapor->getTemplateView($kode_template, $pack['siswa']);
		$this->title = $pack['template']->nama_template;
		$this->load->template('tr_isi_rapor/v_view', $pack);

	}
	

	
}