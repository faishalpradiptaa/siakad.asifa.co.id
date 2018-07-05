<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class crud_periodik_controller extends crud_controller{

	public $view_main = 'template/periodik_main';
	public $thn_ajaran = array();
	public $jenjang = array();
	public $curr_thn_ajaran = array();
	public $curr_jenjang = array();
	public $model = 'crud_periodik_model';
	
	public $allow_import = true;
	
	function __construct()
	{
		parent::__construct();
		
		// set tahun ajaran
		$this->thn_ajaran = $this->db->order_by('thn_ajaran DESC, sem_ajaran DESC')->get('tb_akd_rf_thn_ajaran')->result();		
		$this->curr_thn_ajaran = $this->db->where('kode_thn_ajaran', THN_AJARAN)->get('tb_akd_rf_thn_ajaran')->row();
		if(!$this->curr_thn_ajaran) 
		{
			show_404();
			die;
		}
		
		// set jenjang
		$this->jenjang = $this->db->order_by('nama_jenjang ASC')->get('tb_akd_rf_jenjang')->result();		
		$this->curr_jenjang = $this->db->where('kode_jenjang', JENJANG)->get('tb_akd_rf_jenjang')->row();
		if(!$this->curr_jenjang) 
		{
			show_404();
			die;
		}
	}
	
	public function index()
	{
		$pack = array();
		$model = $this->model;
		if($this->allow_import) $pack['data_exits'] = $this->$model->checkIfDataExists();
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
		else 
		{
			$table = $this->db->where('kode_thn_ajaran',THN_AJARAN)->where('kode_jenjang',JENJANG)->from($this->table);
			$data = $this->datatable->render($kolom, $table, $this->primary_key);
		}
		
		echo json_encode($data);
	}
	
	function change_thn_ajaran($thn)
	{
		$this->session->set_userdata('current_thn_ajaran', $thn);
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function change_jenjang($thn)
	{
		$this->session->set_userdata('current_jenjang', $thn);
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function import($kode_thn_ajaran)
	{
		if(!$this->allow_import)
		{
			show_404();
			return false;
		}
		$model = $this->model;
		$res = $this->$model->import($kode_thn_ajaran);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
?>