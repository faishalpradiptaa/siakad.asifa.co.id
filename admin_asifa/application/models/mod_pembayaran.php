<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_pembayaran extends MY_Model
{
	public function getCatatan($no_induk)
	{
		return $this->db
			->where('no_induk', $no_induk)
			->get('tb_keu_tr_catatan')
			->row();
	}
	
	public function getMainQuery($where='')
	{
		if($where) $where = "WHERE $where";
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
				p.bank,
				p.tgl_entry
			FROM
				tb_keu_tr_pembayaran p
			JOIN
				tb_keu_tr_tagihan t ON t.kode_tagihan=p.kode_tagihan
			LEFT JOIN
				 tb_keu_rf_jenis_pembayaran j ON j.kode_jenis=t.kode_jenis
			LEFT JOIN
				tb_akd_rf_thn_ajaran ta ON ta.kode_thn_ajaran=t.thn_ajaran_tagih
			$where
		) as tagih
		LEFT JOIN
			tb_akd_rf_siswa s ON s.no_induk=tagih.no_induk
		ORDER BY
			tagih.tgl_bayar ASC";
		return $query;
	}
	
	public function getDataTanggungan($no_induk)
	{
		$catatan = $this->getCatatan($no_induk);
		$bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
		
		$query = "SELECT
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
			END as periode
		FROM
			tb_keu_tr_tagihan t
		LEFT JOIN
			tb_keu_rf_jenis_pembayaran j ON j.kode_jenis=t.kode_jenis
		LEFT JOIN
			tb_akd_rf_thn_ajaran ta ON ta.kode_thn_ajaran=t.thn_ajaran_tagih
		LEFT JOIN
			tb_keu_tr_pembayaran p ON t.kode_tagihan=p.kode_tagihan
		WHERE
			t.no_induk = '$no_induk'
		GROUP BY
			t.kode_tagihan
		HAVING
			tanggungan > 0";
		$raw_tanggungan = $this->db->query($query)->result();
		$tanggungan = array();
		
		if(is_array($raw_tanggungan))foreach($raw_tanggungan as $row)
		{
			$tanggungan[] = (object)array(
				'kode_tagihan' => $row->kode_tagihan,
				'periode' => $row->tipe_jenis == 'per_bulan' ? $bulan[(int)date('m', strtotime($row->periode))].' '.date('Y', strtotime($row->periode)) : $row->periode,
				'kategori' => $row->nama_jenis,
				'kode_jenis' => $row->kode_jenis,
				'tanggungan' => $row->tanggungan,
			);
		}
		
		$data = array(
			'catatan' => $catatan,
			'tanggungan' => $tanggungan,
		);
		return $data;
	}

	public function getDataByKodeTagihan($kode_tagihan)
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
			WHERE p.kode_tagihan = '$kode_tagihan'
		) as tagih
		LEFT JOIN
			tb_akd_rf_siswa s ON s.no_induk=tagih.no_induk
		ORDER BY
			tagih.tgl_bayar ASC";
		return $this->db->query($query)->result();
	}
	
	public function getSingleData($kode_pembayaran)
	{
		$query = $this->getMainQuery("p.kode_pembayaran = '$kode_pembayaran'");
		return $this->db->query($query)->row();
	}
	
	public function getDataByNoInduk($no_induk)
	{
		$query = $this->getMainQuery("p.no_induk = '$no_induk'");
		return $this->db->query($query)->result();
	}
	
	public function bayarTanggunganFromPOST()
	{
		$data = (object)array();
		foreach($_POST as $key=>$val) if(substr($key,0,3)=='in_') $data->$key = $val;
		
		$this->db->trans_start();
		
		// get tanggungan
		$tanggungan_org = array();
		$tanggungan_change = array();
		$tanggungan = $this->getDataTanggungan($data->in_no_induk)['tanggungan'];
		foreach($tanggungan as $row) $tanggungan_org[$row->kode_tagihan] = $row;

		// kalkulasi lunas atau tidaknya tanggungan
		foreach($data->in_bayar as $key=>$val)
		{
			$val = (int)str_replace('.','',$val);
			$tg = $tanggungan_org[$key]->tanggungan;
			if($tg <= $val)
				$tanggungan_change[$key] = array('status_tagihan'=>'Lunas');
			else
				$tanggungan_change[$key] = array('status_tagihan'=>'Belum Lunas');
		}
		
		// insert data pembayaran
		$bayar = array();
		$i = 0;
		foreach($data->in_bayar as $key=>$val) 
		{
			$val = (int)str_replace('.','',trim($val));
			if(!$val || $val <= 0) continue;
			$bayar[] = array(
				'kode_pembayaran' => 'BY-'.date('ymdHis').++$i,
				'no_induk' => $data->in_no_induk,
				'kode_tagihan' => $key,
				'kode_jenis' => $tanggungan_org[$key]->kode_jenis,
				'nominal' => $val,
				'jenis_transaksi' => $data->in_jenis_transaksi,
				'tgl_bayar' => dateInd2dateMySQL($data->in_tgl_transaksi),
				'bank' => $data->in_bank,
			);
		}
		if($bayar) $this->db->insert_batch('tb_keu_tr_pembayaran', $bayar);
		
		// update status tagihan jika berubah
		foreach($tanggungan_change as $key=>$val)
		{
			$this->db->where('kode_tagihan', $key)->update('tb_keu_tr_tagihan', $val);
		}
		
		// simpan catatan
		$this->db->where('no_induk', $data->in_no_induk)->delete('tb_keu_tr_catatan');
		if($data->in_catatan)
		{
			$this->db->insert('tb_keu_tr_catatan', array('no_induk' => $data->in_no_induk, 'catatan'=>$data->in_catatan));
		}
		
		$this->db->trans_complete();
		$res = $this->db->trans_status();
		return array(
			'status' => $res,
			'text' => $res ? 'Data Berhasil disimpan' : 'Data gagal disimpan dikarenakan ada kesalahan di database',
		);
		
		
	}

	public function ubahPembayaran($id, $args)
	{
		$nominal = $args['nominal'];
		$tgl_bayar = $args['tgl_bayar'];
		$bayar = $this->getSingleData($id);
		if(!$bayar) return false;
		
		$CI = &get_instance();
		$tagih = $CI->mod_tagihan->getSingleData($bayar->kode_tagihan);
		if($nominal > $bayar->bayar + $tagih->tanggungan) return false;
		
		$this->db->trans_start();
		$data = array(
			'nominal' => $nominal,
			'tgl_bayar' => $tgl_bayar,
		);
		$this->db->where('kode_pembayaran', $id)->update('tb_keu_tr_pembayaran', $data);
		
		$data = array(
			'status_tagihan' => $nominal == $bayar->bayar + $tagih->tanggungan ? 'Lunas' : 'Belum Lunas',
		);
		$this->db->where('kode_tagihan', $tagih->kode_tagihan)->update('tb_keu_tr_tagihan', $data);
		$this->db->trans_complete();
		return $this->db->trans_status();		
	}

	public function deletePembayaran($id)
	{
		$detail = $this->getSingleData($id);
		if(!$detail) return false;
			
		$this->db->trans_start();
		$this->db->where('kode_pembayaran', $id)->delete('tb_keu_tr_pembayaran');		
		$data = array(
			'status_tagihan' => 'Belum Lunas',
		);
		$this->db->where('kode_tagihan', $detail->kode_tagihan)->update('tb_keu_tr_tagihan', $data);
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
}