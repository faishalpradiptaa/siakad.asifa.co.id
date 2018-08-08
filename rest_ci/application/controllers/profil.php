<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class profil extends REST_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //Menampilkan data kontak
    function index_get() {
      $no_induk=$this->get('no_induk');
      //$thn_ajaran=$this->get('thn_ajaran');
      $query1 = $this->db
      ->select('sw.no_induk,sw.nisn,sw.nama,sw.tgl_lahir,sw.alamat,sw.nama_ayah,sw.telp_ayah,sw.nama_ibu,sw.telp_ibu,sw.telp,sw.angkatan,sw.email , ag.nama_agama')
      ->distinct()
      ->join('tb_akd_rf_agama ag', 'ag.kode_agama=sw.agama')
      ->where('no_induk', $no_induk)
      ->get('tb_akd_rf_siswa sw')
      ->result();

      $query2 = $this->db
      ->select('ak.no_induk,jj.nama_jenjang,jr.nama_jurusan,sk.nama_sekolah,kl.nama_kelas,ta.thn_ajaran,ta.sem_ajaran,ta.status_ajaran')
      ->distinct()
      ->join('tb_akd_rf_jenjang jj', 'jj.kode_jenjang=ak.kode_jenjang')
      ->join('tb_akd_rf_jurusan jr', 'jr.kode_jurusan=ak.kode_jurusan')
      ->join('tb_akd_rf_sekolah sk', 'sk.kode_sekolah=ak.kode_sekolah')
      ->join('tb_akd_rf_kelas kl', 'kl.kode_kelas=ak.kode_kelas')
      ->join('tb_akd_rf_thn_ajaran ta', 'ta.kode_thn_ajaran=kl.kode_thn_ajaran')
      ->where('ak.no_induk', $no_induk)
      ->where('ta.status_ajaran', 'active')
      ->get('tb_akd_tr_ambil_kelas ak')
      ->result();

        // $query3 = $this->db
        // ->distinct()
        // ->where('kode_thn_ajaran', $thn_ajaran)
        // ->get('tb_akd_rf_thn_ajaran')
        // ->result();

        $query = array_merge($query1,$query2);
        //$query =$query1.$query2.$query3
        //$this->db->where('no_induk', $no_induk)->where('password', $password);
        //$login=$this->db->get('tb_akd_rf_siswa')->result();
        $this->response($query, 200);

    }

    function index_post() {
        $data = array(
                    'id'   => $this->post('id'),
                    'nama' => $this->post('nama'),
                    'nomor'=> $this->post('nomor'));
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
