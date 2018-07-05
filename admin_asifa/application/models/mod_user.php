<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_user extends MY_Model
{
	public function login($u, $p)
	{
		$p = md5('=['.$p.']=');
		
		$max_attempts = $this->config->item('max_failed_login_attempts');
		$failed_attempts_delay = $this->config->item('delay_failed_login_attempts');
		$jml_failed = $this->session->userdata('failed_login');
		$last_attempt = $this->session->userdata('last_attempt');
		$selisih = strtotime("now") - $last_attempt;

		if ($jml_failed >= $max_attempts && $selisih < $failed_attempts_delay)
		{
			$this->session->set_flashdata('result_login', 'Anda sudah gagal login '.$max_attempts.' kali, harap tunggu beberapa menit atau silahkan menghubungi administrator.');			
			$this->session->set_userdata('last_attempt', strtotime("now"));
			redirect(base_url());
		} 
		else if ($jml_failed >= $max_attempts && $selisih >= $failed_attempts_delay)
		{
			$this->session->unset_userdata('failed_login');
			$this->session->unset_userdata('last_attempt');
			$jml_failed = 0;
		}
		
		$where = array(
			'username' => $u,
			'password' => $p,
			'status' => 'active',
		);
		$cek_user = $this->db->where($where)->get('tb_app_rf_user')->row();
		if($cek_user)
		{
			// get thn ajaran aktif
			$thn_ajaran = $this->db->where('status_ajaran','active')->get('tb_akd_rf_thn_ajaran')->row();
			if(!$thn_ajaran) $thn_ajaran = $this->db->get('tb_akd_rf_thn_ajaran')->row();
			$this->session->set_userdata('current_thn_ajaran', isset($thn_ajaran->kode_thn_ajaran) ? $thn_ajaran->kode_thn_ajaran : '');
			
			// get jenjang aktif
			$jenjang = $this->db->where('status_jenjang','active')->get('tb_akd_rf_jenjang')->row();
			if(!$jenjang) $jenjang = $this->db->get('tb_akd_rf_jenjang')->row();
			$this->session->set_userdata('current_jenjang', isset($jenjang->kode_jenjang) ? $jenjang->kode_jenjang : '');
			
			$this->db->where($where)->update('tb_app_rf_user', array('last_login' => date('Y-m-d H:i:s')));
			$sess_data = array(
				'logged_in' => true,
				'username' => $cek_user->username,
				'nama' => $cek_user->nama,
				'status' => $cek_user->status,
				'role' => $cek_user->role,
			);
			$this->session->set_userdata($sess_data);
			return true;
		}
		else
		{
			$jml_failed = $jml_failed > 0 ? $jml_failed + 1 : 1;
			$this->session->set_userdata('failed_login', $jml_failed);
			$this->session->set_userdata('last_attempt', strtotime("now"));
			$this->session->set_flashdata('result_login', 'Username atau Password yang anda masukkan salah.');
			$this->session->set_flashdata('username', $u);
			return false;
		}
		return false;
	}
	
	public function changeStatus($kode, $status)
	{
		$this->db->trans_start();
		$this->db->where('username',$kode)->update('tb_app_rf_user', array('status' => $status));
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
}