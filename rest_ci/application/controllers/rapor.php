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
    function index_get()
    {
      $no_induk=$this->get('no_induk');
      $where = array(
  			'r.no_induk' => $no_induk,
  			'kode_temp_rapor' => 'RPR.AKD',
  			'status' => 'valid',
  		);

      $rapor=$this->db
        ->select('r.no_induk, sw.nama, r.kode_thn_ajaran')
        ->join('tb_akd_rf_thn_ajaran ta', 'ta.kode_thn_ajaran = r.kode_thn_ajaran')
        ->join('tb_akd_rf_siswa sw', 'r.no_induk = sw.no_induk')
        ->where($where)
  			->get('tb_akd_tr_rapor r')
  			->result_array();

      $A=$this->db
        ->select('d.kode_point,d.deskripsi')
        ->join('tb_akd_rf_thn_ajaran ta', 'ta.kode_thn_ajaran = d.kode_thn_ajaran')
        ->where('no_induk',$no_induk)
        ->where('ta.status_ajaran', 'active')
        ->get('tb_akd_tr_nilai_deskripsi d')
        ->result_array();

      $B=$this->db
        ->select('mp.nama_mp,kode_aspek,nilai')
        ->join('tb_akd_rf_thn_ajaran ta', 'ta.kode_thn_ajaran = nmp.kode_thn_ajaran')
        ->join('tb_akd_rf_mp mp', 'mp.kode_mp = nmp.kode_mp')
        ->where('no_induk',$no_induk)
        ->where('kode_temp_rapor','RPR.AKD')
        ->where('ta.status_ajaran', 'active')
        ->get('tb_akd_tr_nilai_mp nmp')
        ->result_array();

      $selectC=array(
                    'jrw.nama_jenis',
                    'count(rw.kode_jenis_riwayat) as total'
      );
      $C=$this->db
      ->select($selectC)
      ->join('tb_akd_rf_thn_ajaran ta', 'ta.kode_thn_ajaran = rw.kode_thn_ajaran')
      ->join('tb_akd_rf_jenis_riwayat jrw', 'jrw.kode_jenis = rw.kode_jenis_riwayat')
      ->where('rw.no_induk',$no_induk)
      ->group_by('rw.kode_jenis_riwayat')
      ->get('tb_akd_tr_riwayat rw')
      ->result_array();

    $rapor[0]['isi']['sikap']=$A;
    $rapor[0]['isi']['pengetahuan dan keterampilan']=$B;
    $rapor[0]['isi']['kehadiran']=$C;
    //print_r($rapor);
    $this->response($rapor, 200);
    //  $this->response($nilai_akd, 200);
    }
  }
  ?>
