<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class login extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    //Menampilkan data kontak
    function index_get() {
      $no_induk=$this->get('no_induk');
      $password=$this->get('password');
      $password = md5('=a51['.$password.']f4=');
     //  $where = array(
     //   'no_induk' => $no_induk,
     //   'password' => $password,
     //   'status_akademis' => 'valid',
     // );
     // $cek_user = $this->db->where($where)->get('tb_akd_rf_siswa')->row();
      //$this->db->where('no_induk', $no_induk);
      //$this->db->where('password', $password);
      $cek=$this->db->where('no_induk', $no_induk)->where('password', $password)->get('tb_akd_rf_siswa')->row();
      if($cek){
        //$this->response($login, 200);
        // 200 being the HTTP response code
        $this->db->where('no_induk', $no_induk)->where('password', $password);
        $login=$this->db->get('tb_akd_rf_siswa')->result();
        $this->response($login, 200);
      }else{
        $this->response(array('error' => 'invalid'), 404);
      }
    }

    function index_post() {
        $data = array(
                    'id' => $this->post('id'),
                    'nama'          => $this->post('nama'),
                    'nomor'    => $this->post('nomor'));
        $insert = $this->db->insert('telepon', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }


    //Masukan function selanjutnya disini
}
?>
