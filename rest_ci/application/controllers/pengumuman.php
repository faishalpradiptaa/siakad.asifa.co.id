<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class pengumuman extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    //Menampilkan data kontak
    function index_get() {
      $pengumuman=$this->db
  			->select('tb.judul,tb.publish_date, kt.nama_kategori')
  			->join('tb_app_rf_kat_pengumuman kt', 'kt.id_kategori = tb.id_kategori', 'left')
  			->where('publish_date <= DATE(NOW())')
  			->order_by('publish_date', 'DESC')
  			->order_by('id_pengumuman', 'DESC')
  			->get('tb_app_tr_pengumuman tb')
  			->result();
      $this->response($pengumuman, 200);
    }
  }
  ?>
