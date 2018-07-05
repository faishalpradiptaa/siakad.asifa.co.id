<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class keu_nominal extends crud_controller {

	public $title = 'Nominal Pembayaran';
	public $table = 'tb_keu_rf_nominal';
	public $primary_key = 'no_induk';
	public $additional_script_main = 'keu_nominal/additional_main';
	
	public $column = array
	(
		'no_induk' => array(
			'title' => 'No Induk',
			'width' => '10%',
			'filter' => 'text',
		),
		'nama' => array(
			'title' => 'Nama',
			'filter' => 'text',
		),
		'angkatan' => array(
			'title' => 'Angkatan',
			'width' => '5%',
			'filter' => 'text',
			'attribut' => array('data-class' => 'text-center', 'data-visible' => 'false'),
		),
		'nisn' => array(
			'title' => 'NISN',
			'width' => '8%',
			'filter' => 'text',
			'attribut' => array('data-class' => 'text-center', 'data-visible' => 'false'),
		),
		'tahun_lahir' => array(
			'title' => 'Tahun Lahir',
			'width' => '8%',
			'filter' => 'text',
			'attribut' => array('data-class' => 'text-center', 'data-visible' => 'false'),
		),
		'nama_status' => array(
			'title' => 'Status',
			'width' => '8%',
			'filter' => 'text',
			'attribut' => array('data-class' => 'text-center'),
		),
		
	);
	
	// protected CRUD function 
	protected function beforeMain($pack)
	{
		$this->load->model('mod_nominal');
		$jenis = $this->mod_nominal->getAllJenis();
		if(is_array($jenis)) foreach($jenis as $key => $val)
		{
			$kode = 'jenis_'.$key;
			$this->column[$kode] = array(
				'title' => str_replace(' ', '<br> ',$val->nama_jenis),
				'width' => '10%',
				'attribut' => array('data-class' => 'text-right'),
			);			
		}
		$this->column['options-no-db'] = array(
			'title' => 'Option',
			'width' => '7%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		);
		return $pack;
	}
	
	protected function renderTable($kolom, $table, $primary_key)
	{
		$this->load->model('mod_nominal');
		$jenis = $this->mod_nominal->getAllJenis();
		$select = array();
		foreach($jenis as $key => $row)
		{
			$kode = 'jenis_'.$key;
			$kolom['field'][] = $kode;
			$kolom['filter'][] = $kode;
			$select[] = "sum(if(jp.kode_jenis = '".$row->kode_jenis."', n.nominal, 0)) as $kode";
		}
		
		$select = implode(',',$select);
		
		$query = "SELECT
			s.no_induk, s.nama, s.angkatan, s.nisn, s.tahun_lahir, st.nama_status,
			$select
		FROM
			tb_akd_rf_siswa s
		JOIN
			tb_keu_rf_jenis_pembayaran jp 
		LEFT JOIN
			tb_keu_rf_nominal n ON n.no_induk=s.no_induk AND n.kode_jenis=jp.kode_jenis
		JOIN
			tb_app_rf_status st ON s.status_akademis=st.kode_status
		GROUP BY
			s.no_induk";
			
		$data_baru = array();
		$data = $this->datatable->render($kolom, $query, $primary_key, true, true);
		foreach($data->data as $i => $row)
		{
			$data_baru[$i] = array(
				$row->no_induk,
				$row->nama,
				$row->angkatan,
				$row->nisn,
				$row->tahun_lahir,
				$row->nama_status,
			);
			if(is_array($jenis)) foreach($jenis as $key=>$val)
			{
				$nama_field = "jenis_$key";
				$data_baru[$i][] = number_format($row->$nama_field,0,',','.');
			}
			$data_baru[$i][] = '<a href="'.site_url('keu_nominal/form/'.my_base64_encode($row->no_induk)).'" class="btn btn-xs btn-primary" data-original-title="Ubah" rel="tooltip" data-toggle="modal" data-target="#main-modal-lg"><i class="fa fa-pencil"></i></a>';
		}
		
		$data->data = $data_baru;
		return $data;
	}
	
	// override function
	public function form($enc_no_induk = false)
	{
		$this->load->model('mod_siswa');
		$this->load->model('mod_nominal');
		$jenis = $this->mod_nominal->getAllJenis();
		
		if ($this->input->server('REQUEST_METHOD') == 'POST') 
		{
			$res = $this->mod_nominal->setNominal($_POST['nominal'], $_POST['siswa']);
			die($res ? 'ok' : 'not ok');
		}
		$no_induk = $enc_no_induk ? base64_decode($enc_no_induk) : false;
		
		$pack = array(
			'no_induk' => $no_induk,
			'angkatan' => $this->mod_siswa->getAllAngkatan(),
			'jenis' => $jenis,
			'nominal' => $no_induk ? $this->mod_nominal->getSinglePerSiswaAllJenis($no_induk) : false,
		);
		$this->load->view('keu_nominal/v_form', $pack);
	}
	
	// public function
	public function get_siswa()
	{
		$this->load->model('mod_kelas');
		if(isset($_GET['angkatan'])) $data = $this->mod_kelas->getSiswaByAngkatan($_GET['angkatan']);
		else return false;
		echo json_encode($data);
	}
}