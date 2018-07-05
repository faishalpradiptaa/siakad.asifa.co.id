<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tr_set_sekolah extends crud_periodik_controller {

	public $title = 'Pembagian Sekolah Siswa';
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
			'width' => '8%'
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
		'nama_kelas' => array(
			'title' => 'Kelas',
			'filter' => 'text',
			'width' => '12%',
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
	public $additional_script_main = 'tr_set_sekolah/additional_main';
	
	public $allow_update = false;
	public $allow_import = false;
	
	
	// protected CRUD function 
	protected function beforeMain($pack)
	{
		$this->load->model('mod_sekolah');
		$pack['sekolah'] = $this->mod_sekolah->getDataByJenjang();
		return $pack;
	}
	
	protected function renderTable($kolom, $table, $primary_key)
	{
		$sekolah = $_GET['sekolah'];
		if($sekolah == 'null')
		{
			$table = $this->db
				->select('ak.id_ambil_kelas, sw.no_induk, sw.nisn, sw.nama, sw.angkatan, sw.tahun_lahir, sw.telp, st.nama_status, jr.nama_jurusan, kl.nama_kelas')
				->from('tb_akd_rf_siswa sw')
				->join('tb_app_rf_status st', 'st.kode_status = sw.status_akademis')
				->join($table.' ak', 'sw.no_induk=ak.no_induk AND ak.kode_thn_ajaran = "'.THN_AJARAN.'"', 'left')
				->join('tb_akd_rf_jurusan jr', 'jr.kode_jurusan = ak.kode_jurusan', 'left')
				->join('tb_akd_rf_kelas kl', 'kl.kode_kelas = ak.kode_kelas AND kl.kode_thn_ajaran=ak.kode_thn_ajaran', 'left')
				->where('ak.kode_sekolah is null')
				->where('(ak.kode_jenjang = "'.JENJANG.'" or ak.kode_jenjang is null)');
		}
		else
		{
			$table = $this->db
				->select('ak.id_ambil_kelas, sw.no_induk, sw.nisn, sw.nama, sw.angkatan, sw.tahun_lahir, sw.telp, st.nama_status, jr.nama_jurusan, kl.nama_kelas ')
				->from($table.' ak')
				->join('tb_akd_rf_siswa sw', 'sw.no_induk=ak.no_induk')
				->join('tb_app_rf_status st', 'st.kode_status = sw.status_akademis')
				->join('tb_akd_rf_jurusan jr', 'jr.kode_jurusan = ak.kode_jurusan', 'left')
				->join('tb_akd_rf_kelas kl', 'kl.kode_kelas = ak.kode_kelas AND kl.kode_thn_ajaran=ak.kode_thn_ajaran', 'left')
				->where('ak.kode_thn_ajaran', THN_AJARAN)
				->where('ak.kode_sekolah', $sekolah);
		}
		
		$kolom['field'][] = 'id_ambil_kelas';
		$pos = count($kolom['field'])-2;
		$pos_id = count($kolom['field'])-1;
		
		$data = $this->datatable->render($kolom, $table, $primary_key);
		
		foreach($data->data as $key => $row)
		{
			$data->data[$key][$pos] = $sekolah == 'null' ? '' : '<a href="'.site_url(PAGE_ID.'/delete/'.my_base64_encode($row[$pos_id])).'" class="btn btn-xs btn-danger" data-original-title="Batalkan" rel="tooltip" data-toggle="delete"><i class="fa fa-ban"></i></a>';
		}
		return $data;
	}	
	
	// public function
	public function form()
	{
		$this->load->model('mod_kelas');
		$this->load->model('mod_siswa');
		$this->load->model('mod_sekolah');
		$this->load->model('crud_model');
		
		if ($this->input->server('REQUEST_METHOD') == 'POST') 
		{
			$this->load->model('mod_sekolah');
			$res = $this->mod_sekolah->assignSiswa($_POST['out_sekolah'], $_POST['out_jurusan'], $_POST['siswa']);
			die($res ? 'ok' : 'not ok');
		}
		
		$pack = array(
			'kelas' => $this->mod_kelas->getAllData(),
			'angkatan' => $this->mod_siswa->getAllAngkatan(),
			'sekolah' => $this->mod_sekolah->getDataByJenjang(),
		);
		
		$this->crud_model->set('tb_akd_rf_jurusan', 'kode_jurusan');
		$pack['jurusan'] = $this->crud_model->getAllData();
		
		$this->load->view('tr_set_sekolah/v_form', $pack);
	}
	
	public function delete($id)
	{
		$id = base64_decode($id);
		$this->load->model('mod_sekolah');
		$res = $this->mod_sekolah->resetSekolahSiswa($id);
		echo $res ? 'ok' : 'not ok';
	}
	
	public function get_siswa()
	{
		$this->load->model('mod_kelas');
		$this->load->model('mod_sekolah');
		if(isset($_GET['sekolah'])) $data = $this->mod_sekolah->getSiswaBySekolah($_GET['sekolah'], $_GET['jurusan'], $_GET['kode_thn_ajaran']);
		else if(isset($_GET['kelas'])) $data = $this->mod_kelas->getSiswaByKelas(THN_AJARAN, $_GET['kelas']);
		else if(isset($_GET['angkatan'])) $data = $this->mod_kelas->getSiswaByAngkatan($_GET['angkatan']);
		else if(isset($_GET['non_sekolah'])) $data = $this->mod_sekolah->getSiswaBySekolah(false);
		else return false;
		echo json_encode($data);
	}
	
}