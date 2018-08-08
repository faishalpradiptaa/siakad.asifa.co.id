<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_kehadiran extends MY_Model
{

	public function getDataByThnAjaran($kode_thn_ajaran)
	{
		$jenis = $this->db
			->order_by('kode_jenis','ASC')
			->get('tb_akd_rf_jenis_riwayat')
			->result();

		$data = $this->db
			->where('kode_jenjang', JENJANG)
			->where('no_induk', NO_INDUK)
			->where('kode_thn_ajaran', $kode_thn_ajaran)
			->order_by('tgl', 'ASC')
			->get('tb_akd_tr_riwayat')
			->result();

		return (object)array(
			'jenis' => $jenis,
			'data' => $data,
		);	
	}
}
