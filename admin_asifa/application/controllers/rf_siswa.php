<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rf_siswa extends crud_controller {

	public $title = 'Siswa';
	public $column = array
	(
		'tahun_lahir' => array(
			'title' => 'Tahun Lahir',
			'filter' => 'text',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center'),
		),
		'no_induk' => array(
			'title' => 'No.Induk',
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
		'jk' => array(
			'title' => 'Jenis Kelamin',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'kota_lahir' => array(
			'title' => 'Tempat Lahir',
			'attribut' => array('data-visible' => 'false'),
		),
		'tgl_lahir' => array(
			'title' => 'Tgl Lahir',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'alamat' => array(
			'title' => 'Alamat',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'nama_ayah' => array(
			'title' => 'Nama Ayah',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'telp_ayah' => array(
			'title' => 'Telp Ayah',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'nama_ibu' => array(
			'title' => 'Nama Ibu',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'telp_ibu' => array(
			'title' => 'Telp Ibu',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'nama_telp_darurat' => array(
			'title' => 'Nama Telp Darurat',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'telp' => array(
			'title' => 'Telp',
			'filter' => 'text',
			'width' => '10%'
		),
		'tgl_masuk' => array(
			'title' => 'Tgl Masuk',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'nama_status' => array(
			'title' => 'Status',
			'filter' => 'text',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center'),
		),
		'angkatan' => array(
			'title' => 'Ankatan',
			'filter' => 'text',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center'),
		),
		'nama_agama' => array(
			'title' => 'Agama',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'email' => array(
			'title' => 'Email',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'last_login' => array(
			'title' => 'Terakhir Login',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $form_data = array(
		'tahun_lahir' => array(
			'title' => 'Tahun Lahir',
			'type' => 'number',
			'col_width' => 'col-sm-4',
			'validate' => 'required',
		),
		'no_induk' => array(
			'title' => 'No.Induk',
			'type' => 'text',
			'col_width' => 'col-sm-5',
			'validate' => 'required;code',
		),
		'nisn' => array(
			'title' => 'NISN',
			'type' => 'text',
			'col_width' => 'col-sm-5',
		),
		'nama' => array(
			'title' => 'Nama',
			'type' => 'text',
			'col_width' => 'col-sm-9',
			'validate' => 'required',
		),
		'jk' => array(
			'title' => 'Jenis Kelamin',
			'type' => 'radio',
			'data' => array( array('value'=>'l','text'=>'Laki-laki'), array('value'=>'p','text'=>'Perempuan') ),
			'col_width' => 'col-sm-9',
			'validate' => 'required',
			'default' => 'l',
		),
		'tempat_lahir' => array(
			'title' => 'Tempat Lahir',
			'type' => 'select',
			'col_width' => 'col-sm-7',
			'validate' => 'required',
		),
		'tgl_lahir' => array(
			'title' => 'Tgl Lahir',
			'type' => 'date',
			'col_width' => 'col-sm-4',
			'validate' => 'required',
		),
		'alamat' => array(
			'title' => 'Alamat',
			'type' => 'text',
			'col_width' => 'col-sm-9',
			'validate' => 'required',
		),
		'nama_ayah' => array(
			'title' => 'Nama Ayah',
			'type' => 'text',
			'col_width' => 'col-sm-8',
		),
		'telp_ayah' => array(
			'title' => 'Telp Ayah',
			'type' => 'text',
			'col_width' => 'col-sm-6',
		),
		'nama_ibu' => array(
			'title' => 'Nama Ibu',
			'type' => 'text',
			'col_width' => 'col-sm-8',
		),
		'telp_ibu' => array(
			'title' => 'Telp Ibu',
			'type' => 'text',
			'col_width' => 'col-sm-6',
		),
		'nama_telp_darurat' => array(
			'title' => 'Nama Telp Darurat',
			'type' => 'text',
			'col_width' => 'col-sm-6',
		),
		'telp' => array(
			'title' => 'Telp',
			'type' => 'text',
			'col_width' => 'col-sm-6',
			'validate' => 'required',
		),
		'tgl_masuk' => array(
			'title' => 'Tgl Masuk',
			'type' => 'date',
			'col_width' => 'col-sm-4',
			'validate' => 'required',
		),
		'status_akademis' => array(
			'title' => 'Status',
			'type' => 'select',
			'col_width' => 'col-sm-4',
			'validate' => 'required',
		),
		'angkatan' => array(
			'title' => 'Angkatan',
			'type' => 'text',
			'col_width' => 'col-sm-4',
			'validate' => 'required',
		),
		'agama' => array(
			'title' => 'Agama',
			'type' => 'select',
			'col_width' => 'col-sm-5',
			'validate' => 'required',
		),
		'email' => array(
			'title' => 'Email',
			'type' => 'text',
			'col_width' => 'col-sm-7',
		),
		'password' => array(
			'title' => 'Password',
			'type' => 'password',
			'col_width' => 'col-sm-6',
			'validate' => 'required',
		),
	);
	public $table = 'tb_akd_rf_siswa';
	public $primary_key = 'no_induk';
	public $additional_script_form = 'rf_siswa/additional_form';
	public $view_detail = 'rf_siswa/v_detail';
	
	
	// protected CRUD function 
	protected function renderTable($kolom, $table, $primary_key)
	{
		$table = $this->db
			->select('tb.*, kt.nama_kota as kota_lahir, ag.nama_agama, st.nama_status')
			->from($table.' tb')
			->join('tb_app_rf_kota kt', 'kt.id_kota = tb.tempat_lahir', 'left')
			->join('tb_app_rf_status st', 'st.kode_status = tb.status_akademis')
			->join('tb_akd_rf_agama ag', 'ag.kode_agama = tb.agama', 'left');
			
		$data = $this->datatable->render($kolom, $table, $primary_key);
		foreach($data->data as $key => $row)
		{
			// format jk
			$data->data[$key][4] = $row[4] == 'l' ? 'Laki-laki' : 'Perempuan';
			// format tgl lahir
			$data->data[$key][6] = dateMySQL2dateInd($row[6]);
			// format tgl masuk			
			$data->data[$key][14] = dateMySQL2dateInd($row[14]);
			
			$data->data[$key][count($row)-1] = preg_replace('/#main-modal-md/','#main-modal-lg',$row[count($row)-1], 1);
		}
		return $data;
	}
	
	protected function beforeForm($pack, $id=false)
	{
		$this->form_data['tempat_lahir']['data'] = $this->db->select('id_kota as value, nama_kota as text')->order_by('nama_kota','ASC')->get('tb_app_rf_kota')->result();
		$this->form_data['status_akademis']['data'] = $this->db->select('kode_status as value, nama_status as text')->where('tags like "%siswa%"')->get('tb_app_rf_status')->result();
		$this->form_data['agama']['data'] = $this->db->select('kode_agama as value, nama_agama as text')->order_by('nama_agama','ASC')->get('tb_akd_rf_agama')->result();
		if($id)
		{
			$this->form_data['password']['validate'] = '';
		}
		return $pack;
	}

	protected function beforeDetail($pack, $id)
	{
		$this->load->model('mod_siswa');
		$this->load->model('mod_riwayat');
		$this->load->model('mod_tagihan');
		$this->load->model('mod_pembayaran');
		
		$pack['tahun_ajaran'] = $this->db->where('kode_thn_ajaran', THN_AJARAN)->get('tb_akd_rf_thn_ajaran')->row();
		$pack['akademik'] = $this->mod_siswa->getDetailByNoInduk($id);
		$pack['riwayat'] = $this->mod_riwayat->getDataByNoInduk($id);
		$pack['tagihan'] = $this->mod_tagihan->getDataByNoInduk($id);
		$pack['pembayaran'] = $this->mod_pembayaran->getDataByNoInduk($id);
		return $this->beforeForm($pack, $id);
	}
	
	protected function beforeSave($data, $id)
	{
		if($id && !$data['password']) unset($data['password']);
		else if($data['password']) $data['password'] =  md5('=a51['.$data['password'].']f4=');		
		return $data;
	}
	
	
	// public function
	public function autocomplete($limit=10)
	{
		$this->load->model('mod_siswa');
		$result = array(
			"total_count" => $limit,
			"incomplete_results" => false,
			"items" => $this->mod_siswa->getDataAutoComplete($limit),
		);
		echo json_encode($result);
	}
	
}