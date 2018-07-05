<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_tugas extends MY_Model
{
	
	public function getAllMyTugas($kode_mp=false, $id_tugas=false)
	{
		$CI =& get_instance();
		$detail_siswa =& $CI->detail_siswa;
		$where = array();
		
		if($kode_mp) $where[] = "t.kode_mp=".$this->db->escape($kode_mp);
		if($id_tugas) $where[] = "t.id_tugas=".$this->db->escape($id_tugas);
		$where = $where ? "AND ".implode(' AND ', $where) : '';
		
		$query = "SELECT
			t.*, m.nama_mp, k.nama_kelas, ts.id_submit, ts.tgl_submit, ts.alamat_file, ts.nama_file, ts.ukuran_file, ts.tipe_file
		FROM
			tb_akd_tr_tugas t
		JOIN
			tb_akd_tr_ambil_kelas ak ON ak.kode_kelas=t.kode_kelas AND ak.kode_thn_ajaran=t.kode_thn_ajaran AND ak.kode_jenjang=t.kode_jenjang
		JOIN
			tb_akd_tr_ambil_mp am ON am.id_ambil_kelas=ak.id_ambil_kelas AND am.kode_mp=t.kode_mp AND am.kode_thn_ajaran=t.kode_thn_ajaran AND am.kode_jenjang=t.kode_jenjang
		JOIN
			tb_akd_rf_mp m ON m.kode_mp=t.kode_mp AND m.kode_thn_ajaran=t.kode_thn_ajaran AND m.kode_jenjang=t.kode_jenjang
		JOIN
			tb_akd_rf_kelas k ON k.kode_kelas=t.kode_kelas AND k.kode_thn_ajaran=t.kode_thn_ajaran AND k.kode_jenjang=t.kode_jenjang
		LEFT JOIN
			tb_akd_tr_tugas_siswa ts ON t.id_tugas=ts.id_tugas AND ak.no_induk=ts.no_induk
		WHERE
			ak.no_induk = '".NO_INDUK."'
			AND t.kode_thn_ajaran = '".THN_AJARAN."'
			AND t.kode_jenjang = '".JENJANG."'
			AND t.status = 'active'
			$where
		ORDER BY
			batas_tgl_kumpul ASC
		";
		return $id_tugas ? $this->db->query($query)->row() : $this->db->query($query)->result();
		
		
	}
	
	public function submitTugas($kode_mp, $id_tugas, $input_file)
	{
		$tugas = $this->getAllMyTugas($kode_mp, $id_tugas);
		if(!$tugas || strtotime($tugas->batas_tgl_kumpul) < strtotime('now'))
		{
			$this->session->set_flashdata('error', 'Tugas tidak ditemukan');
			return false;
		}
		$upload_path = 'upload_tugas/'.my_base64_encode(THN_AJARAN.JENJANG).'/'.my_base64_encode($tugas->kode_mp).'/'.my_base64_encode($id_tugas);
		if(!file_exists($upload_path)) mkdir($upload_path, '0775', true);
		
		$arr = pathinfo($_FILES[$input_file]['name']);
		$filename = md5(NO_INDUK.$id_tugas).'.'.$arr['extension'];
		
		$config = $this->config->item('upload');
		$config['upload_path'] = FCPATH.$upload_path;
		$config['file_name'] = $filename;

		$this->load->library('upload', $config);
		if (!$this->upload->do_upload($input_file))
		{
			$this->session->set_flashdata('error', $this->upload->display_errors());
			return false;
		}
		
		$this->db
			->where('id_tugas', $id_tugas)
			->where('no_induk', NO_INDUK)
			->delete('tb_akd_tr_tugas_siswa');
			
		$pack = array(
			'id_tugas' => $id_tugas,
			'no_induk' => NO_INDUK,
			'deskripsi' => null,
			'alamat_file' => $upload_path.'/'.$filename,
			'nama_file' => $_FILES[$input_file]['name'],
			'ukuran_file' => $_FILES[$input_file]['size'],
			'tipe_file' => $_FILES[$input_file]['type'],
			'tgl_submit' => date('Y-m-d H:i:s'),
		);
		$res = $this->db->insert('tb_akd_tr_tugas_siswa', $pack);
		if($res)
		{
			$this->session->set_flashdata('success', 'Tugas berhasil dikirimkan');
			return true;
		}
		
		$this->session->set_flashdata('error', 'Tugas gagal dikirimkan');
		return false;
	}

	public function getMySubmit($id_submit)
	{
		return $this->db
			->where('id_submit', $id_submit)
			->where('no_induk', NO_INDUK)
			->get('tb_akd_tr_tugas_siswa')
			->row();
	}
	

}