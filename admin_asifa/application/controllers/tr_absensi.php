<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tr_absensi extends crud_periodik_controller {

	public $title = 'Absensi Siswa';
	public $allow_import = false;
	public $allow_create = false;
	public $allow_update = false;
	public $allow_delete = false;
	
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
			'attribut' => array('data-class' => 'text-center', 'data-visible' => false),
		),
	);
	public $table = 'tb_akd_tr_nilai_absensi';
	public $primary_key = 'no_induk';
	public $additional_script_main = 'tr_absensi/additional_main';
	
	
	// Override CRUD function 
	protected function beforeMain($pack)
	{
		$this->load->model('mod_absensi');
		$jenis_absensi = $this->mod_absensi->getAllJenis();
		if(is_array($jenis_absensi)) foreach($jenis_absensi as $key => $val)
		{
			$this->column['jenis_'.$key] = array(
				'title' => str_replace(' ', '<br> ',$val->nama_jenis),
				'width' => '10%',
				'attribut' => array('data-class' => 'text-center'),
			);			
		}
		$this->column['options-no-db'] = array(
			'title' => 'Option',
			'width' => '12%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		);
		
		$this->crud_periodik_model->set('tb_akd_rf_kelas', 'kode_kelas');		
		$pack['kelas'] = $this->crud_periodik_model->getAllData();
		return $pack;
	}
	
	protected function renderTable($kolom, $table, $primary_key)
	{
		$kelas = $_GET['kelas'];
		$header = array();
		$this->load->model('mod_absensi');
		$jenis_absensi = $this->mod_absensi->getAllJenis();
		if(is_array($jenis_absensi)) foreach($jenis_absensi as $key => $val)
		{
			$kolom['field'][] = 'jenis_'.$key;
			$kolom['filter'][] = 'jenis_'.$key;
			$header[] = "SUM(IF(a.kode_jenis_absensi = '".$val->kode_jenis."', a.jumlah, 0)) as jenis_$key";
		}
		$header = implode(',', $header);
		
		$query = "SELECT
			ak.id_ambil_kelas,
			sw.no_induk,
			sw.nisn,
			sw.nama,
			st.nama_status, 
			$header
		FROM
			tb_akd_tr_ambil_kelas ak
		JOIN 
			tb_akd_rf_siswa sw ON sw.no_induk = ak.no_induk
		JOIN 
			tb_app_rf_status st ON st.kode_status = sw.status_akademis
		LEFT JOIN
			tb_akd_tr_nilai_absensi a ON a.no_induk=ak.no_induk AND a.kode_thn_ajaran=ak.kode_thn_ajaran AND a.kode_jenjang=ak.kode_jenjang
		WHERE
			ak.kode_thn_ajaran = '".THN_AJARAN."'
			AND ak.kode_jenjang = '".JENJANG."'
			AND ak.kode_kelas = '$kelas'
		GROUP BY
			ak.no_induk, ak.kode_thn_ajaran, ak.kode_jenjang";

		$data_baru = array();
		$data = $this->datatable->render($kolom, $query, $primary_key, true, true);
		
		foreach($data->data as $i => $row)
		{
			$data_baru[$i] = array(
				$row->no_induk,
				$row->nisn,
				$row->nama,
				$row->nama_status,
			);
			if(is_array($jenis_absensi)) foreach($jenis_absensi as $key=>$val)
			{
				$nama_field = "jenis_$key";
				$data_baru[$i][] = '<span class="live-text">'.$row->$nama_field.'</span><input type="hidden" min="0" class="form-control text-center" name="'.$val->kode_jenis.'" value="'.$row->$nama_field.'">';
			}
			$data_baru[$i][] = '<a href="javascript:;" class="btn btn-xs btn-primary" data-original-title="Ubah" rel="tooltip" data-toggle="live-edit" data-value="'.$row->no_induk.'"><i class="fa fa-pencil"></i></a>';
		}
		
		$data->data = $data_baru;
		return $data;
	}	
	
	// public custom function
	public function save()
	{
		if ($this->input->server('REQUEST_METHOD') != 'POST') return false;
		$this->load->model('mod_absensi');
		$res = $this->mod_absensi->saveSingleAbsensi($_POST['no_induk'], $_POST['data']);
		die( $res ? 'ok' : 'not ok');
	}
	
	public function save_batch()
	{
		if ($this->input->server('REQUEST_METHOD') != 'POST') return false;
		$this->load->model('mod_absensi');
		$res = $this->mod_absensi->saveBatchAbsensi($_POST['data']);
		die( $res ? 'ok' : 'not ok');
		
	}
}