<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class rf_user extends crud_controller {

	public $title = 'User';
	public $additional_script_main = 'rf_user/additional_main';
	public $column = array
	(
		'username' => array(
			'title' => 'Username',
			'width' => '20%',
			'filter' => 'text',
		),
		'nama' => array(
			'title' => 'Nama',
			'width' => '20%',
			'filter' => 'text',
		),
		'email' => array(
			'title' => 'Email',
			'width' => '20%',
			'filter' => 'text',
		),
		'telp' => array(
			'title' => 'Telp',
			'attribut' => array('data-visible' => 'false'),
			'filter' => 'text',
		),
		'status' => array(
			'title' => 'Aktif',
			'width' => '10%',
			'filter' => 'text',
		),
		'last_login' => array(
			'title' => 'Terakhir Login',
			'attribut' => array('data-visible' => 'false'),
			'filter' => 'text',
		),
		'role' => array(
			'title' => 'Role',
			'width' => '10%',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false', 'data-class' => 'text-center'),
		),
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '5%',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false'),
		)
	);
	public $table = 'tb_app_rf_user';
	public $primary_key = 'username';
	public $form_data = array
	(
		'username' => array(
			'title' => 'Username',
			'col_width' => 'col-sm-5',
			'type' => 'text',
			'validate' => 'required;code',
		),
		'password' => array(
			'title' => 'Password',
			'col_width' => 'col-sm-7',
			'type' => 'password',
			'id' => 'user-password'
		),
		'co_password' => array(
			'title' => 'Konfirmasi Password',
			'col_width' => 'col-sm-7',
			'type' => 'password',
			'validate' => 'match:#user-password',
		),
		'nama' => array(
			'title' => 'Nama',
			'type' => 'text',
			'validate' => 'required',
		),
		'email' => array(
			'title' => 'Email',
			'col_width' => 'col-sm-7',
			'type' => 'email',
			'validate' => 'required',
		),
		'telp' => array(
			'title' => 'Telp',
			'col_width' => 'col-sm-5',
			'type' => 'text',
		),
		'status' => array(
			'title' => 'Aktif',
			'type' => 'switch',
			'on' => 'Ya',
			'off' => 'Tidak',
			'on_value' => 'active',
			'off_value' => 'not_active',
		),
		/*'role' => array(
			'title' => 'Role',
			'col_width' => 'col-sm-4',
			'type' => 'text',
			'validate' => 'required',
		)*/
	);
	
	// protected CRUD function 
	protected function renderTable($kolom, $table, $primary_key)
	{
		$data = $this->datatable->render($kolom, $table, $primary_key);
		foreach($data->data as $key => $row)
		{
			$data->data[$key][4] = '<input type="checkbox" name="'.my_base64_encode($row[0]).'" value="active" '.($row[4] == 'active' ? 'checked' : '').' class="main-switch" data-on-text="Ya" data-off-text="Tidak">';
		}
		return $data;
	}
	
	protected function beforeSave($data, $id)
	{
		if(!$id && !$data['password']) return false;
		if($id && $data['password'] != $data['co_password']) return false;
		if($id && !$data['password']) unset($data['password']);
		unset($data['co_password']);
		if(isset($data['password'])) $data['password'] =  md5('=['.$data['password'].']=');
		$data['role'] = 'admin';
		return $data;
	}
	
	// custom method 
	public function state($enc_kode, $state)
	{
		$this->load->model('mod_user');
		$kode = base64_decode($enc_kode);
		$status = $state == 'true' ? 'active' : 'not_active';
		echo $this->mod_user->changeStatus($kode, $status) ? 'ok' : 'not ok';
	}
}