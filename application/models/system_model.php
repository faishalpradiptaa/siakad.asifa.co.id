<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class system_model extends MY_Model
{
	public function login($u, $p)
	{
		$p = md5('=a51['.$p.']f4=');
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
			'no_induk' => $u,
			'password' => $p,
			'status_akademis' => 'valid',
		);
		$cek_user = $this->db->where($where)->get('tb_akd_rf_siswa')->row();
		if($cek_user)
		{
			// get thn ajaran aktif
			$thn_ajaran = $this->db->where('status_ajaran','active')->get('tb_akd_rf_thn_ajaran')->row();
			if(!$thn_ajaran) $thn_ajaran = $this->db->get('tb_akd_rf_thn_ajaran')->row();
			$this->session->set_userdata('current_thn_ajaran', isset($thn_ajaran->kode_thn_ajaran) ? $thn_ajaran->kode_thn_ajaran : '');
			
			$this->db->where($where)->update('tb_akd_rf_siswa', array('last_login' => date('Y-m-d H:i:s')));
			$sess_data = array(
				'logged_in' => true,
				'username' => $cek_user->no_induk,
				'no_induk' => $cek_user->no_induk,
				'nama' => $cek_user->nama,
				'status' => $cek_user->status,
				'role' => 'siswa',
			);
			$this->session->set_userdata($sess_data);
			return true;
		}
		else
		{
			$jml_failed = $jml_failed > 0 ? $jml_failed + 1 : 1;
			$this->session->set_userdata('failed_login', $jml_failed);
			$this->session->set_userdata('last_attempt', strtotime("now"));
			$this->session->set_flashdata('result_login', 'No.Induk atau Password yang anda masukkan salah.');
			$this->session->set_flashdata('username', $u);
			return false;
		}
		return false;
	}
	
	public function getTemplateRapor()
	{
		$CI =& get_instance();
		if(!$CI->detail_siswa) return false;
		return $this->db
		 ->where('kode_jenjang', $CI->detail_siswa->kode_jenjang)
		 ->where('kode_thn_ajaran', THN_AJARAN)
		 ->group_by('kode_template')
		 ->get('tb_akd_rf_template_rapor')
		 ->result();
	}
	
}