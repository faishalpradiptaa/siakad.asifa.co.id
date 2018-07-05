<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rf_jenjang extends crud_controller {

	public $title = 'Jenjang Pendidikan';
	public $additional_script_main = 'rf_jenjang/additional_main';
	public $column = array
	(
		'kode_jenjang' => array(
			'title' => 'Kode Jenjang',
			'width' => '25%',
			'filter' => 'text',
		), 
		'nama_jenjang' => array(
			'title' => 'Nama Jenjang',
			'width' => '30%',
			'filter' => 'text',
		), 
		'status_jenjang' => array(
			'title' => 'Aktif',
			'width' => '15%',
			'filter' => 'text',
			'attribut' => array('data-class' => 'text-center'),
		), 
		'keterangan' => array(
			'title' => 'Keterangan',
			'filter' => 'text',
		), 
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $table = 'tb_akd_rf_jenjang';
	public $primary_key = 'kode_jenjang';
	public $form_data = array
	(
		'kode_jenjang' => array(
			'title' => 'Kode Jenjang',
			'type' => 'text',
			'validate' => 'required;code',
		),
		'nama_jenjang' => array(
			'title' => 'Nama Jenjang',
			'type' => 'text',
			'validate' => 'required',
		),
		'status_jenjang' => array(
			'title' => 'Aktif',
			'type' => 'switch',
			'on' => 'Ya',
			'off' => 'Tidak',
			'on_value' => 'active',
			'off_value' => 'not_active',
			'checked' => false,
		), 
		'keterangan' => array(
			'title' => 'Keterangan',
			'type' => 'text',
		),
	);
	
	// protected CRUD function 
	protected function renderTable($kolom, $table, $primary_key)
	{
		$data = $this->datatable->render($kolom, $table, $primary_key);
		foreach($data->data as $key => $row)
		{
			$data->data[$key][2] = '<input type="checkbox" name="'.my_base64_encode($row[0]).'" value="active" '.($row[2] == 'active' ? 'checked' : '').' class="main-switch" data-on-text="Ya" data-off-text="Tidak">';
		}
		return $data;
	}
	
	protected function afterSave($data, $id, $res)
	{
		if(!$res) return false;
		$this->load->model('mod_jenjang');
		$id = $id ? $id : $res;
		return $this->mod_jenjang->changeStatus($id, $data['status_jenjang']);
	}
	
	
	// custom method 
	public function state($enc_kode, $state)
	{
		$this->load->model('mod_jenjang');
		$kode = base64_decode($enc_kode);
		$status = $state == 'true' ? 'active' : 'not_active';
		echo $this->mod_jenjang->changeStatus($kode, $status) ? 'ok' : 'not ok';
	}
	
	
}