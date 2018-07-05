<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tr_tugas extends crud_periodik_controller {

	public $title = 'Tugas';
	public $table = 'tb_akd_tr_tugas';
	public $primary_key = 'id_tugas';
	public $allow_import = false;
	public $additional_script_main = 'tr_tugas/additional_main';
	public $additional_script_form = 'tr_tugas/additional_form';
	public $view_detail = 'tr_tugas/v_detail';
	
	public $column = array
	(
		'id_tugas' => array(
			'title' => 'ID',
			'filter' => 'text',
			'width' => '8%',
			'attribut' => array('data-class' => 'text-center', 'data-visible' => 'false'),
		), 
		'nama_kelas' => array(
			'title' => 'Kelas',
			'filter' => 'text',
			'width' => '10%'
		), 
		'nama_mp' => array(
			'title' => 'Mata Pelajaran',
			'filter' => 'text',
			'width' => '20%'
		), 
		'nama_tugas' => array(
			'title' => 'Judul',
			'filter' => 'text',
		), 
		'is_multiple_submit' => array(
			'title' => 'Multiple Submit',
			'filter' => 'text',
			'attribut' => array('data-class' => 'text-center', 'data-visible' => 'false'),
		), 
		'tgl_buat' => array(
			'title' => 'Tgl Buat',
			'filter' => 'text',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center'),
		), 
		'batas_tgl_kumpul' => array(
			'title' => 'Batas Tgl Kumpul',
			'filter' => 'text',
			'width' => '15%',
			'attribut' => array('data-class' => 'text-center', 'data-visible' => 'false'),
		), 
		'nama_status' => array(
			'title' => 'Status',
			'filter' => 'text',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center'),
		), 
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	
	public $form_data = array(
		'kode_kelas' => array(
			'title' => 'Kelas',
			'type' => 'select',
			'col_width' => 'col-sm-8',
			'validate' => 'required',
		), 
		'kode_mp' => array(
			'title' => 'Mata Pelajaran',
			'type' => 'select',
			'col_width' => 'col-sm-6',
			'validate' => 'required',
		), 
		'nama_tugas' => array(
			'title' => 'Judul Tugas',
			'type' => 'text',
			'col_width' => 'col-sm-8',
			'validate' => 'required',
		), 
		'deskripsi' => array(
			'title' => 'Deskripsi Tugas',
			'type' => 'textarea',
			'col_width' => 'col-sm-12 margin-t-10',
		), 
		'is_multiple_submit' => array(
			'title' => 'Multiple Submit',
			'type' => 'switch',
			'on' => 'Ya',
			'off' => 'Tidak',
			'on_value' => '1',
			'off_value' => '0',
		), 
		'tgl_buat' => array(
			'title' => 'Tgl Buat',
			'type' => 'datetime',
			'col_width' => 'col-sm-3',
		), 
		'batas_tgl_kumpul' => array(
			'title' => 'Batas Pengumpulan',
			'type' => 'datetime',
			'col_width' => 'col-sm-3',
		), 
		'status' => array(
			'title' => 'Aktif',
			'type' => 'switch',
			'on' => 'Ya',
			'off' => 'Tidak',
			'on_value' => 'active',
			'off_value' => 'not_active',
		), 
		'deskripsi_encoded' => array(
			'title' => 'Deskripsi',
			'type' => 'hidden',
		),
	);
	
	
	
	// protected CRUD function 
	protected function renderTable($kolom, $table, $primary_key)
	{
		$query = "SELECT
			t.*, k.nama_kelas, CONCAT(m.kode_mp,' - ',m.nama_mp) as nama_mp, s.nama_status
		FROM
			tb_akd_tr_tugas t
		JOIN
			tb_akd_rf_kelas k ON t.kode_thn_ajaran=k.kode_thn_ajaran AND t.kode_jenjang=k.kode_jenjang AND t.kode_kelas=k.kode_kelas
		JOIN
			tb_akd_rf_mp m ON t.kode_thn_ajaran=m.kode_thn_ajaran AND t.kode_jenjang=m.kode_jenjang AND t.kode_mp=m.kode_mp
		JOIN
			tb_app_rf_status s ON t.status=s.kode_status
		WHERE
			t.kode_thn_ajaran = '".THN_AJARAN."'
			AND t.kode_jenjang = '".JENJANG."'
		";
		$data = $this->datatable->render($kolom, $query, $primary_key, false, true);
		foreach($data->data as $key => $row)
		{
			$data->data[$key][5] = date('d/m/Y', strtotime($row[5]));
			$data->data[$key][6] = date('d/m/Y H:i:s', strtotime($row[6]));
			$data->data[$key][count($row)-1] = str_replace('data-toggle=\'modal\'', '', $row[count($row)-1]);
		}
		return $data;
	}
	
	protected function beforeForm($data, $id)
	{
		$this->form_data['kode_kelas']['data'] = $this->db
			->select('kode_kelas as value, nama_kelas as text')
			->where('kode_thn_ajaran', THN_AJARAN)
			->where('kode_jenjang', JENJANG)
			->order_by('nama_kelas')
			->get('tb_akd_rf_kelas')
			->result();
			
			$this->form_data['kode_mp']['data'] = $this->db
			->select('kode_mp as value, CONCAT(kode_mp, " - ",nama_mp) as text', false)
			->where('kode_thn_ajaran', THN_AJARAN)
			->where('kode_jenjang', JENJANG)
			->order_by('kode_mp','ASC')
			->get('tb_akd_rf_mp')
			->result();
		$this->form_data['tgl_buat']['default'] = date('Y-m-d H:i');
		$this->form_data['batas_tgl_kumpul']['default'] = date('Y-m-d H:i', strtotime('+1 week'));
		return $data;
	}
	
	protected function beforeSave($data, $id)
	{
		$data['deskripsi'] = base64_decode($data['deskripsi_encoded']);
		unset($data['deskripsi_encoded']);
		return $data;
	}
	
	protected function beforeDetail($data, $id)
	{
		$tes = $this->form_data['deskripsi'];
		unset($this->form_data['deskripsi']);
		$this->form_data['deskripsi'] = $tes;
		return $data;
	}
	
	
	
	// public custom method_exists
	public function detail_submit($id_tugas)
	{
		$this->load->library('datatable');
		
		$db = $this->db
			->select('ts.*, s.nama as nama_siswa')
			->join('tb_akd_rf_siswa s', 'ts.no_induk=s.no_induk')
			->from('tb_akd_tr_tugas_siswa ts');
		
		$kolom = array('id_submit', 'no_induk', 'nama_siswa', 'tgl_submit', 'alamat_file');
		
		$data = $this->datatable->render($kolom, $db, $primary_key);
		foreach($data->data as $key => $row)
		{
			$data->data[$key][3] = date('d/m/Y H:i:s', strtotime($row[3]));
			$data->data[$key][4] = '<a href="'.site_url(PAGE_ID.'/download_submit/'.$row[0]).'" class="btn btn-xs btn-primary"><i class="fa fa-download margin-r-5"></i> Download</a>';
		}
		echo json_encode($data);
	}
	
	public function download_submit($id_submit)
	{
		$data = $this->db->where('id_submit', $id_submit)->get('tb_akd_tr_tugas_siswa')->row();
		$data->alamat_file = '../'.$data->alamat_file;
		if($data && file_exists($data->alamat_file))
		{
			header('Content-Type: application/octet-stream');
			header("Content-Transfer-Encoding: Binary"); 
			header("Content-disposition: attachment; filename=\"" . $data->nama_file . "\""); 
			readfile($data->alamat_file); 
		}
		else
		{
			redirect($_SERVER['HTTP_REFERER']);
		}
		
	}
	
	
}