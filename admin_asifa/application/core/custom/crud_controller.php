<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class crud_controller extends admin_controller{

	public $title = 'Nama';
	public $column = array
	(
		'id' => array(
			'title' => 'ID',
			'width' => '10%',
			'filter' => 'text',
			'attribut' => '{"class": "text-center"}',
		), 
		'nama_gol' => array(
			'title' => 'Nama Golongan',
			'filter' => 'text',
		), 
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '10%',
			'attribut' => '{"sortable": false, "class": "text-center"}',
		)
	);
	public $model = false;
	public $table = 'tes';
	public $primary_key = 'id';
	public $form_tabs = array();
	public $form_data = array(
		'nama' => array(
			'title' => 'Nama',
			'type' => 'text',
		),
	);
	public $allow_create = true;
	public $allow_update = true;
	public $allow_delete = true;
	
	public $view_main = 'template/crud_main';
	public $view_form = 'template/crud_form';
	public $view_detail = 'template/crud_detail';
	
	
	function __construct() 
	{
		parent::__construct();
		
		if (!$this->model)
		{
			$this->load->model('crud_model');
			$this->crud_model->set($this->table, $this->primary_key);
			$this->model = 'crud_model';
		}
		else
		{
			$model = $this->model;
			$this->load->model($model);
			$this->$model->set($this->table, $this->primary_key);
		}		
	}
	
	public function index()
	{
		$pack = array();
		if(method_exists($this,'beforeMain')) $pack = $this->beforeMain($pack);
		if(isset($this->additional_script_main)) $pack['additional_script'] = $this->load->view($this->additional_script_main, $pack, true);
		$this->load->template($this->view_main, $pack);
	}
	
	function get_datatable()
	{
		$this->load->library('datatable');
		$kolom = array_keys($this->column);
		$filter = $kolom;
		$operator = array();
		$i = 0;
		foreach($this->column as $col) 
		{
			if (isset($col['filter_field'])) $filter[$i] = $col['filter_field'];
			if (isset($col['filter_operator'])) $operator[$i] = $col['filter_operator'];
			$i++;
		}
		$kolom = array(
			'field' => $kolom,
			'filter' => $filter,
			'operator' => $operator,
		);
		
		if(method_exists($this,'renderTable')) $data = $this->renderTable($kolom, $this->table, $this->primary_key);
		else $data = $this->datatable->render($kolom, $this->table, $this->primary_key);
		
		echo json_encode($data);
	}
	
	public function form($id=false)
	{
		if ( (!$id && !$this->allow_create) || ($id && !$this->allow_update) )
		{
			show_404();
			die;
		}
		$raw_id = $id;
		$id = $id ? base64_decode($id) : false;
		$model = $this->model;
		
		if ($this->input->server('REQUEST_METHOD') == 'POST') 
		{
			$data = array();
			foreach ($this->form_data as $key => $val)
			{
				if($val['type'] == 'date')
				{
					$data[$key] = $_POST[$key] ? dateInd2dateMySQL($_POST[$key]) : null;
				}
				elseif($val['type'] == 'datetime') 
				{
					$arr_val = explode(' ',$_POST[$key]);
					$data[$key] = $_POST[$key] ? dateInd2dateMySQL($arr_val[0]).' '.$arr_val[1].':00' : null;
				}
				elseif($val['type'] == 'switch') 
				{
					$val['off_value'] = !isset($val['off_value']) ? null : $val['off_value'];
					$data[$key] = !isset($_POST[$key]) || $_POST[$key] != $val['on_value']  ? $val['off_value']  : $val['on_value'];
				}
				else $data[$key] = $_POST[$key];
				
				if($data[$key] == '') $data[$key] = null;
			}
			if(method_exists($this,'beforeSave')) $data = $this->beforeSave($data, $id);
			if(!$data) die('not ok');
			$res = $this->$model->save($data, $id);
			if(method_exists($this,'afterSave')) $res = $this->afterSave($data, $id, $res);
			die($res ? 'ok' : 'not ok');
		}
		$is_ajax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		$pack = array(
			'is_ajax' => $is_ajax,
			'data' => ($id) ? $this->$model->get_detail_data($id) : false,
			'id' => $id,
			'raw_id' => $raw_id,
		);
		if(method_exists($this,'beforeForm')) $pack = $this->beforeForm($pack, $id);
		if(isset($this->additional_script_form)) $pack['additional_script'] = $this->load->view($this->additional_script_form, $pack, true);
		if($is_ajax)
			$this->load->view($this->view_form, $pack);
		else
			$this->load->template($this->view_form, $pack);
	}
	
	public function detail($id)
	{
		$is_ajax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
		$raw_id = $id;
		$id = base64_decode($id);
		$model = $this->model;
		$pack = array(
			'data' => $this->$model->get_detail_data($id),
			'id' => $id,
			'raw_id' => $raw_id,
			'is_ajax' => $is_ajax,
		);
		if(method_exists($this,'beforeDetail')) $pack = $this->beforeDetail($pack, $id);
		if(isset($this->additional_script_detail)) $pack['additional_script'] = $this->load->view($this->additional_script_detail, $pack, true);
		if($is_ajax)
			$this->load->view($this->view_detail, $pack);
		else
			$this->load->template($this->view_detail, $pack);
	}
	
	public function delete($id)
	{
		if ( !$this->allow_delete) 
		{
			show_404();
			die;
		}
		$id = base64_decode($id);
		$model = $this->model;
		$res = $this->$model->delete($id);
		if ($res) echo 'ok';
	}
	
}
?>