<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user_model extends CI_model {
  public function login($u, $p)
	{
    $p = md5('=a51['.$p.']f4=');
    $where = array(
			'no_induk' => $u,
			'password' => $p,
			'status_akademis' => 'valid',
		);
		$cek_user = $this->db->where($where)->get('tb_akd_rf_siswa')->row();
    if($cek_user!=0){
      return true;
    }else{
      return false;
    }
	}
}
