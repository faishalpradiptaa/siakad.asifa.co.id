<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class pembayaran extends REST_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    //Menampilkan data kontak
    function index_get() {
      $no_induk=$this->get('no_induk');
      $query = "SELECT
  			tagih.*, s.nama as nama_siswa
  		FROM
  		(
  			SELECT
  				p.kode_pembayaran,
  				t.kode_tagihan,
  				t.no_induk,
  				t.kode_jenis,
  				j.nama_jenis,
  				j.tipe_jenis,
  				t.nominal as tagih,
  				p.nominal as bayar,
  				CASE tipe_jenis
  					WHEN 'per_bulan' THEN t.bulan_tagih
  					WHEN 'per_thn_ajaran' THEN ta.thn_ajaran
  					WHEN 'per_semester' THEN CONCAT(ta.thn_ajaran,' ',ta.sem_ajaran)
  					ELSE ''
  				END as periode,
  				p.tgl_bayar,
  				p.jenis_transaksi,
  				p.tgl_entry
  			FROM
  				tb_keu_tr_pembayaran p
  			JOIN
  				tb_keu_tr_tagihan t ON t.kode_tagihan=p.kode_tagihan
  			LEFT JOIN
  				 tb_keu_rf_jenis_pembayaran j ON j.kode_jenis=t.kode_jenis
  			LEFT JOIN
  				tb_akd_rf_thn_ajaran ta ON ta.kode_thn_ajaran=t.thn_ajaran_tagih
  			WHERE
  				p.no_induk = '".$no_induk."'
  		) as tagih
  		LEFT JOIN
  			tb_akd_rf_siswa s ON s.no_induk=tagih.no_induk
  		ORDER BY
  			tagih.tgl_bayar DESC";
  		$pembayaran=$this->db->query($query)->result();
      $this->response($pembayaran, 200);
    }
  }
  ?>
