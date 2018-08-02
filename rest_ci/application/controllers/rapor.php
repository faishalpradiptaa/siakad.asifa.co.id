<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class rapor extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    //Menampilkan data kontak
    function index_get() {
      $no_induk=$this->get('no_induk');
      $where = array(
  			'no_induk' => $no_induk,
  			'kode_temp_rapor' => 'RPR.AKD',
  			'status' => 'valid',
  		);
      $rapor=$this->db
  			->where($where)
  			->get('tb_akd_tr_rapor')
  			->result();
      $this->response($rapor, 200);
    }
  }
  ?>
