<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_siswa extends MY_Model
{

	public function getDetail($thn_ajaran=false)
	{
		$thn_ajaran = $thn_ajaran ? $thn_ajaran : THN_AJARAN;
		return $this->db
			->select('ak.*, sw.*, ag.nama_agama, jj.nama_jenjang, kt.nama_kota as kota_lahir, st.nama_status, sk.nama_sekolah, jr.nama_jurusan, kl.nama_kelas, gr.nama as nama_wali_kelas, sk.kepsek, sk.nip_kepsek')
			->join('tb_akd_rf_siswa sw', 'sw.no_induk=ak.no_induk')
			->join('tb_app_rf_status st', 'st.kode_status = sw.status_akademis')
			->join('tb_akd_rf_jenjang jj', 'jj.kode_jenjang = ak.kode_jenjang')
			->join('tb_akd_rf_sekolah sk', 'sk.kode_sekolah = ak.kode_sekolah AND sk.jenjang=ak.kode_jenjang', 'left')
			->join('tb_akd_rf_jurusan jr', 'jr.kode_jurusan = ak.kode_jurusan', 'left')
			->join('tb_akd_rf_kelas kl', 'kl.kode_kelas = ak.kode_kelas AND kl.kode_thn_ajaran=ak.kode_thn_ajaran AND kl.kode_jenjang=ak.kode_jenjang')
			->join('tb_akd_rf_guru gr', 'kl.no_induk_guru=gr.no_induk', 'left')
			->join('tb_akd_rf_agama ag', 'sw.agama=ag.kode_agama', 'left')
			->join('tb_app_rf_kota kt', 'kt.id_kota=sw.tempat_lahir', 'left')
			->where('ak.kode_thn_ajaran', $thn_ajaran)
			->where('ak.no_induk', NO_INDUK)
			->get('tb_akd_tr_ambil_kelas ak')
			->row();		
	}
	
	public function getThnAjaranByPengambilan()
	{
		return $this->db
			->select('t.*')
			->where('no_induk', NO_INDUK)
			->where('kode_jenjang', JENJANG)
			->join('tb_akd_rf_thn_ajaran t', 't.kode_thn_ajaran=ak.kode_thn_ajaran')
			->group_by('t.kode_thn_ajaran')
			->order_by('t.thn_ajaran', 'ASC')
			->order_by('t.sem_ajaran', 'ASC')
			->get('tb_akd_tr_ambil_kelas ak')
			->result();
		
	}
	
	public function updateProfile($data)
	{
		if($data['pass_baru'])
		{
			if(!$data['pass_lama'])
			{
				$this->session->set_flashdata('error', 'Harap isi password lama dahulu.');
				return false;
			}
			if($data['pass_baru'] != $data['pass_confirm'])
			{
				$this->session->set_flashdata('error', 'Password dan Ulangi password harus sama.');
				return false;
			}
			$p = md5('=a51['.$data['pass_lama'].']f4=');
			$cek = $this->db->where('password', $p)->where('no_induk', NO_INDUK)->get('tb_akd_rf_siswa')->row();
			if(!$cek)
			{
				$this->session->set_flashdata('error', 'Password lama yang anda masukkan salah.');
				return false;
			}
			
			$p = md5('=a51['.$data['pass_baru'].']f4=');
			$res = $this->db->where('no_induk', NO_INDUK)->update('tb_akd_rf_siswa', array('password'=>$p));
			if($res)
				$this->session->set_flashdata('success', 'Password berhasil diupdate.');
			else
				$this->session->set_flashdata('error', 'Password gagal diupdate.');
		}
		
		$send = array(
			'alamat' => $data['alamat'],
			'telp' => $data['telp'],
			'email' => $data['email'],
			'nama_ayah' => $data['nama_ayah'],
			'telp_ayah' => $data['telp_ayah'],
			'nama_ibu' => $data['nama_ibu'],
			'telp_ibu' => $data['telp_ibu'],
		);
		$res = $this->db->where('no_induk', NO_INDUK)->update('tb_akd_rf_siswa', $send);
		if($res)
			$this->session->set_flashdata('success', 'Data profil berhasil diupdate.');
		else
			$this->session->set_flashdata('error', 'Data profil gagal diupdate.');
	
		
		
		return $res;
		
	}
}