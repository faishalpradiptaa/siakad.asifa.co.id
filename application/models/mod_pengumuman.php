<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_pengumuman extends MY_Model
{
	public function getLimitedData($limit=25)
	{
		return $this->db
			->select('tb.*, kt.nama_kategori, kt.icon')
			->join('tb_app_rf_kat_pengumuman kt', 'kt.id_kategori = tb.id_kategori', 'left')
			->where('publish_date <= DATE(NOW())')
			->order_by('publish_date', 'DESC')
			->order_by('id_pengumuman', 'DESC')
			->limit($limit)
			->get('tb_app_tr_pengumuman tb')
			->result();
	}
	
	public function getSingleData($id)
	{
		return $this->db
			->select('tb.*, kt.nama_kategori, kt.icon')
			->join('tb_app_rf_kat_pengumuman kt', 'kt.id_kategori = tb.id_kategori', 'left')
			->where('publish_date <= DATE(NOW())')
			->where('id_pengumuman', $id)
			->get('tb_app_tr_pengumuman tb')
			->row();
	}
	
	public function getAllKategori()
	{
		return $this->db
			->get('tb_app_rf_kat_pengumuman')
			->result();
	}
	
}