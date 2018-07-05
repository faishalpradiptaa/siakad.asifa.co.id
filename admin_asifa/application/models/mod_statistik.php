<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_statistik extends MY_Model
{
	public $total_siswa = false;
	
	function getJmlAllSiswa()
	{
		$this->total_siswa = $this->db
			->get('tb_akd_rf_siswa')
			->num_rows();
		return $this->total_siswa;
	}
	
	function getJmlSiswaValid()
	{
		return $this->db
			->where('status_akademis','valid')
			->get('tb_akd_rf_siswa')
			->num_rows();
	}
	
	function getJmlSiswaMenunggak()
	{
		return $this->db
			->where('status_tagihan <> \'Lunas\'')
			->group_by('no_induk')
			->get('tb_keu_tr_tagihan')
			->num_rows();
	}
	
	function getJmlSiswaPerAngkatan()
	{
		$query = "SELECT
			angkatan, count(*) as jml
		FROM
			tb_akd_rf_siswa
		WHERE
			status_akademis = 'valid'		
		GROUP BY
			angkatan
		ORDER BY
			angkatan ASC";
		return $this->db->query($query)->result();
	}

	function getJmlSiswaPerUmur()
	{
		$query = "SELECT
			COALESCE(CONCAT(age,' thn'), 'Belum Diisi') as age, count(*) as jml
		FROM
		(
			SELECT
				no_induk, TIMESTAMPDIFF(YEAR , tgl_lahir, CURDATE()) as age
			FROM
				tb_akd_rf_siswa
		) as main
		GROUP BY
			age";
		return $this->db->query($query)->result();
	}

	function getJmlSiswaPerJenjang()
	{
		$query = "SELECT
			a.kode_jenjang, COALESCE(j.nama_jenjang,'Belum di Set') as nama_jenjang, count(*) as jml
		FROM
			tb_akd_rf_siswa s
		LEFT JOIN
			tb_akd_tr_ambil_kelas a ON a.no_induk=s.no_induk AND a.kode_thn_ajaran='".THN_AJARAN."'
		LEFT JOIN
			tb_akd_rf_jenjang j ON a.kode_jenjang=j.kode_jenjang
		GROUP BY
			a.kode_jenjang";
		return $this->db->query($query)->result();
	}

	function getPemasukanBulanIni()
	{
		$query = "SELECT
			sum(nominal) as jml
		FROM
			tb_keu_tr_pembayaran
		WHERE
			MONTH(tgl_bayar) = MONTH(NOW())
			AND YEAR(tgl_bayar) = YEAR(NOW())
			AND jenis_transaksi = 'pembayaran'";
		$jml_nominal = $this->db->query($query)->row();
		
		$query = "SELECT
			no_induk
		FROM
			tb_keu_tr_pembayaran
		WHERE
			MONTH(tgl_bayar) = MONTH(NOW())
			AND YEAR(tgl_bayar) = YEAR(NOW())
			AND jenis_transaksi = 'pembayaran'
		GROUP BY
			no_induk";
		$jml_siswa = $this->db->query($query)->num_rows();
		
		return (object)array(
			'jml_nominal' => $jml_nominal->jml,
			'jml_siswa' => $jml_siswa,
		);
	}

	function getPemasukan12BulanTerakhir()
	{
		$query = "SELECT
			DATE_FORMAT(tgl_bayar, '%b') as bln, YEAR(tgl_bayar) as thn, SUM(nominal) as total
		FROM
			tb_keu_tr_pembayaran
		WHERE
			jenis_transaksi = 'pembayaran'
			#AND tgl_bayar >= DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01') ,INTERVAL -12 MONTH)
		GROUP BY
			MONTH(tgl_bayar), YEAR(tgl_bayar)
		ORDER BY
			tgl_bayar ASC";
		return $this->db->query($query)->result();
	}
	
	function getPiutang()
	{
		$query = "SELECT
			sum(tagih)-sum(bayar) as piutang
		FROM
		(
			SELECT
				t.kode_tagihan, t.nominal as tagih, sum(COALESCE(p.nominal,0)) as bayar
			FROM
				tb_keu_tr_tagihan t
			LEFT JOIN 
				tb_keu_tr_pembayaran p ON t.kode_tagihan=p.kode_tagihan
			WHERE
				status_tagihan <> 'Lunas'
			GROUP BY
				t.kode_tagihan
		) main";
		return $this->db->query($query)->row()->piutang;
	}
}