<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class crud_periodik_model extends CI_MODEL
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
		return $this->db->where('kode_thn_ajaran',THN_AJARAN)->where('kode_jenjang',JENJANG)->get($this->table)->result();
	}
	
	function getAllData()
	{
		return $this->get_all_data();
	}

	function get_detail_data($id)
	{
		return $this->db->where('kode_thn_ajaran',THN_AJARAN)->where('kode_jenjang',JENJANG)->where($this->primary_key, $id)->get($this->table)->row();
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
			return $this->db->where('kode_thn_ajaran',THN_AJARAN)->where('kode_jenjang',JENJANG)->where($this->primary_key, $id)->update($this->table, $data);
		}
		else
		{
			/* $data['created_app'] = $this->config->item('application_id');
			$data['created_by'] = USERNAME;
			$data['created_date'] = date('Y-m-d H:i:s'); */			
			$data['kode_thn_ajaran'] = THN_AJARAN;
			$data['kode_jenjang'] = JENJANG;
			$res = $this->db->insert($this->table, $data);
			return $res;
		}
	}
	
	function delete($id)
	{
		return $this->db->where('kode_thn_ajaran',THN_AJARAN)->where('kode_jenjang',JENJANG)->where($this->primary_key, $id)->delete($this->table);
	}

	function get_all_data_from($table)
	{
		return $this->db->where('kode_thn_ajaran',THN_AJARAN)->where('kode_jenjang',JENJANG)->get($table)->result();
	}

	function checkIfDataExists($kode_thn_ajaran=false)
	{
		$kode_thn_ajaran = !$kode_thn_ajaran ? THN_AJARAN : $kode_thn_ajaran;
		return ($this->db->select('kode_thn_ajaran')->where('kode_thn_ajaran', $kode_thn_ajaran)->where('kode_jenjang',JENJANG)->get($this->table)->num_rows() > 0);
	}
	
	function import($kode_thn_ajaran)
	{
		// cek jika tahun ajaran ada
		$cek = $this->db->where('kode_thn_ajaran', $kode_thn_ajaran)->get('tb_akd_rf_thn_ajaran')->row();
		if(!$cek)
		{
			$this->session->set_flashdata('error', 'Tahun ajaran asal tidak ditemukan');
			return false;
		}
		
		// cek jika data di tahun ajaran tujuan masih ada
		if($this->checkIfDataExists())
		{
			$this->session->set_flashdata('error', 'Data pada tahun ajaran sekarang masih ada, harap kosongkan data terlebih dahulu');
			return false;
		}
		
		// get data di tahun ajaran asal
		$data = $this->db->where('kode_thn_ajaran', $kode_thn_ajaran)->where('kode_jenjang',JENJANG)->get($this->table)->result_array();
		if(!$data)
		{
			$this->session->set_flashdata('error', 'Data di tahun ajaran asal yang akan anda impor tidak ditemukan');
			return false;
		}
		
		// ganti thn ajaran & insert
		foreach($data as $key => $row) $data[$key]['kode_thn_ajaran'] = THN_AJARAN;		
		$res = $this->db->insert_batch($this->table, $data);
		
		if($res)
		{
			$this->session->set_flashdata('success', count($data).' data berhasil diimport dari tahun ajaran '.$cek->thn_ajaran.' '.$cek->sem_ajaran);
			return true;
		}
		else
		{
			$this->session->set_flashdata('error', 'Data gagal diimport');
			return false;
		}
		
		
		
	}
	
}