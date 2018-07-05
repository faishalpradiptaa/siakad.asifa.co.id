<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_keuangan extends CI_MODEL
{
	
	public function getMyTagihan()
	{
		$query = "SELECT
			tagih.*, s.nama as nama_siswa
		FROM
		(
			SELECT
				t.kode_tagihan, 
				t.no_induk, 
				t.kode_jenis, 
				j.nama_jenis,
				j.tipe_jenis,
				t.nominal as tagih, 
				sum(COALESCE(p.nominal,0)) as bayar, 
				t.nominal - sum(COALESCE(p.nominal,0)) as tanggungan,
				t.status_tagihan,
				CASE tipe_jenis
					WHEN 'per_bulan' THEN t.bulan_tagih
					WHEN 'per_thn_ajaran' THEN ta.thn_ajaran
					WHEN 'per_semester' THEN CONCAT(ta.thn_ajaran,' ',ta.sem_ajaran)
					ELSE ''
				END as periode,
				t.keterangan,
				DATE_FORMAT(t.tgl_tagih, '%d/%m/%Y') as tgl_tagih,
				CONCAT_WS(', ', DATE_FORMAT(p.tgl_bayar, '%d/%m/%Y')) as tgl_bayar
			FROM
				tb_keu_tr_tagihan t
			LEFT JOIN
				tb_keu_rf_jenis_pembayaran j ON j.kode_jenis=t.kode_jenis
			LEFT JOIN
				tb_akd_rf_thn_ajaran ta ON ta.kode_thn_ajaran=t.thn_ajaran_tagih
			LEFT JOIN
				tb_keu_tr_pembayaran p ON t.kode_tagihan=p.kode_tagihan
			WHERE
				t.no_induk = '".NO_INDUK."'
			GROUP BY
				t.kode_tagihan
			ORDER BY
				t.tgl_tagih ASC			
		) as tagih
		LEFT JOIN
			tb_akd_rf_siswa s ON s.no_induk=tagih.no_induk";
		
		return $this->db->query($query)->result();		
	}

	public function getMyPembayaran()
	{
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
				p.no_induk = '".NO_INDUK."'
		) as tagih
		LEFT JOIN
			tb_akd_rf_siswa s ON s.no_induk=tagih.no_induk
		ORDER BY
			tagih.tgl_bayar DESC";
		return $this->db->query($query)->result();
	}
	
}