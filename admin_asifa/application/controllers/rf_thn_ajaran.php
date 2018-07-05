<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//$kolom = array('kode_thn_ajaran','thn_ajaran','sem_ajaran','status_ajaran','tgl_awal','tgl_akhir','options-no-db');
class rf_thn_ajaran extends crud_controller {

	public $title = 'Tahun Ajaran';
	public $additional_script_main = 'rf_thn_ajaran/additional_main';
	public $column = array
	(
		'kode_thn_ajaran' => array(
			'title' => 'Kode',
			'width' => '15%',
			'filter' => 'text',
		), 
		'thn_ajaran' => array(
			'title' => 'Tahun Ajaran',
			'filter' => 'text',
		), 
		'sem_ajaran' => array(
			'title' => 'Semester',
			'width' => '15%',
			'filter' => 'text',
		), 
		'status_ajaran' => array(
			'title' => 'Aktif',
			'width' => '15%',
			'filter' => 'text',
			'attribut' => array('data-class' => 'text-center'),
		), 
		'tgl_awal' => array(
			'title' => 'Mulai',
			'filter' => 'text',
			'attribut' => array('data-class' => 'text-center', 'data-visible' => 'false'),
		), 
		'tgl_akhir' => array(
			'title' => 'Sampai',
			'filter' => 'text',
			'attribut' => array('data-class' => 'text-center', 'data-visible' => 'false'),
		), 
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $table = 'tb_akd_rf_thn_ajaran';
	public $primary_key = 'kode_thn_ajaran';
	public $form_data = array
	(
		'kode_thn_ajaran' => array(
			'title' => 'Kode',
			'type' => 'text',
			'validate' => 'required;code',
		), 
		'thn_ajaran' => array(
			'title' => 'Tahun Ajaran',
			'type' => 'text',
			'validate' => 'required',
		), 
		'sem_ajaran' => array(
			'title' => 'Semester',
			'type' => 'text',
		), 
		'status_ajaran' => array(
			'title' => 'Aktif',
			'type' => 'switch',
			'on' => 'Ya',
			'off' => 'Tidak',
			'on_value' => 'active',
			'off_value' => 'not_active',
			'checked' => false,
		), 
		'tgl_awal' => array(
			'title' => 'Mulai',
			'type' => 'date',
			'col_width' => 'col-sm-4',
		), 
		'tgl_akhir' => array(
			'title' => 'Sampai',
			'type' => 'date',
			'col_width' => 'col-sm-4',
		), 
	);
	
	// protected CRUD function 
	protected function renderTable($kolom, $table, $primary_key)
	{
		$kolom['field'][] = 'kode_thn_ajaran';
		$kolom['filter'][] = 'kode_thn_ajaran';		
		$data = $this->datatable->render($kolom, $table, $primary_key);
		foreach($data->data as $key => $row)
		{
			$data->data[$key][3] = '<input type="checkbox" name="'.my_base64_encode($row[count($row)-1]).'" value="active" '.($row[3] == 'active' ? 'checked' : '').' class="main-switch" data-on-text="Ya" data-off-text="Tidak">';
			$data->data[$key][4] = dateMySQL2dateInd($row[4]);
			$data->data[$key][5] = dateMySQL2dateInd($row[5]);
		}
		return $data;
	}
	
	protected function afterSave($data, $id, $res)
	{
		if(!$res) return false;
		$this->load->model('mod_thn_ajaran');
		$id = $id ? $id : $res;
		return $this->mod_thn_ajaran->changeStatus($id, $data['status_ajaran']);
	}
	
	
	// custom method 
	public function state($enc_kode, $state)
	{
		$this->load->model('mod_thn_ajaran');
		$kode = base64_decode($enc_kode);
		$status = $state == 'true' ? 'active' : 'not_active';
		echo $this->mod_thn_ajaran->changeStatus($kode, $status) ? 'ok' : 'not ok';
	}
	
	
}