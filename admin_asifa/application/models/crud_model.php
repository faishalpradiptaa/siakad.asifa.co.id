<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class crud_model extends CI_MODEL
{

	var $table = '';
	var $primary_key = '';

	function set($table, $primary_key)
	{
		$this->table = $table;
		$this->primary_key = $primary_key;
	}
	
	function get_all_data()
	{
		return $this->db->get($this->table)->result();
	}
	
	function getAllData()
	{
		return $this->get_all_data();
	}

	function get_detail_data($id)
	{
		return $this->db->where($this->primary_key, $id)->get($this->table)->row();
	}
	
	function getSingleData($id)
	{
		return $this->get_detail_data($id);
	}
	
	function save($data, $id = false)
	{
		if ($id) 
		{
			/* $data['modified_app'] = $this->config->item('application_id');
			$data['modified_by'] = USERNAME; 
			$data['modified_date'] = date('Y-m-d H:i:s'); */
			return $this->db->where($this->primary_key, $id)->update($this->table, $data);
		}
		else
		{
			/* $data['created_app'] = $this->config->item('application_id');
			$data['created_by'] = USERNAME;
			$data['created_date'] = date('Y-m-d H:i:s'); */			
			$res = $this->db->insert($this->table, $data);
			return $res;
		}
	}
	
	function delete($id)
	{
		return $this->db->where($this->primary_key, $id)->delete($this->table);
	}

	function get_all_data_from($table)
	{
		return $this->db->get($table)->result();
	}


}