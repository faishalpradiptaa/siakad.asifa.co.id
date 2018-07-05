<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class st_predikat extends crud_controller {

	public $title = 'Predikat';
	public $column = array
	(
		'nama_predikat' => array(
			'title' => 'Nama',
			'filter' => 'text',
		), 
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $table = 'tb_akd_rf_predikat';
	public $primary_key = 'id_predikat';
	public $form_data = array
	(
		'nama_predikat' => array(
			'title' => 'Nama',
			'filter' => 'text',
			'col_width' => 'col-sm-7',
			'validate' => 'required',
		), 
	);
	public $view_form = 'st_predikat/v_form';
	public $view_detail = 'st_predikat/v_detail';

	// protected CRUD method
	protected function afterSave($data, $id=false, $res=false)
	{
		if(!$res) return $res;
		$data = $_POST['grade_kategori'];
		$this->load->model('mod_predikat');
		return $this->mod_predikat->saveGrade($id, $data);
	}
	
	protected function beforeForm($pack, $id=false)
	{
		if(!$id) return $pack;
		$this->load->model('mod_predikat');
		$pack['data']->detail = $this->mod_predikat->getDetail($id);
		return $pack;
	}
	
	protected function beforeDetail($pack, $id=false)
	{
		return $this->beforeForm($pack, $id);
	}
}