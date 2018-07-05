<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_mapel extends MY_Model
{
	function getMapelByJenisRapor($jenis_rapor)
	{
		return $this->db
			->select('m.*')
			->where('k.kode_thn_ajaran', THN_AJARAN)
			->where('k.kode_jenjang', JENJANG)
			->where('k.kode_jenis_rapor', $jenis_rapor)
			->join('tb_akd_rf_mp m', 'k.kode_thn_ajaran=m.kode_thn_ajaran AND k.kode_jenjang=m.kode_jenjang AND m.kode_kelompok=k.kode_kelompok')
			->get('tb_akd_rf_kelompok_mp k')
			->result();
	}
	
	function getDataAutoComplete($limit=10)
	{
		$txt = isset($_GET['q']) ? $_GET['q'] : '';
		$query = "SELECT
			kode_mp AS id,
			nama_mp AS text
		FROM
			tb_akd_rf_mp
		WHERE
			kode_thn_ajaran = '".THN_AJARAN."'
			AND kode_jenjang = '".JENJANG."'
			AND ( kode_mp LIKE '%$txt%' OR nama_mp LIKE '%$txt%' )
		ORDER BY
			nama_mp ASC
		LIMIT $limit";
		
		$data = $this->db->query($query)->result();
		return $data;
	}

	function getSingleMapelDeskripsi($kode_mapel = false)
	{
		$query = "SELECT
			mp.kode_mp, ar.kode_aspek, ar.tipe, ar.nama_aspek, dm.deskripsi, tr.kode_jenis
		FROM
			tb_akd_rf_point_rapor pr
		JOIN
			tb_akd_rf_aspek_rapor ar ON ar.kode_thn_ajaran=pr.kode_thn_ajaran AND ar.kode_jenjang=pr.kode_jenjang AND ar.kode_point=pr.kode_point AND ar.tipe <> 'rumus'
		JOIN
			tb_akd_rf_template_rapor tr ON tr.kode_thn_ajaran=ar.kode_thn_ajaran AND tr.kode_jenjang=ar.kode_jenjang AND tr.kode_template=ar.kode_temp_rapor
		LEFT JOIN
			tb_akd_rf_mp mp ON pr.kode_thn_ajaran=mp.kode_thn_ajaran AND pr.kode_jenjang=mp.kode_jenjang AND mp.kode_mp = '$kode_mapel'
		LEFT JOIN
			tb_akd_rf_deskripsi_mp dm ON dm.kode_thn_ajaran=mp.kode_thn_ajaran AND dm.kode_jenjang=mp.kode_jenjang AND dm.kode_mp=mp.kode_mp AND dm.kode_aspek=ar.kode_aspek
		WHERE
			pr.tipe_point = 'mapel'
			AND ar.tipe = 'nilai_predikat'
			AND pr.kode_thn_ajaran = '".THN_AJARAN."'
			AND pr.kode_jenjang = '".JENJANG."'";
			
		return $this->db->query($query)->result();
	}
	
	function saveDeskripsiMapel($kode_mp, $data_aspek)
	{
		$this->db->trans_start();
		$send = array(
			'kode_mp' => $kode_mp,
			'kode_thn_ajaran' => THN_AJARAN,
			'kode_jenjang' => JENJANG,
		);
		$this->db->where($send)->delete('tb_akd_rf_deskripsi_mp');
		
		if(is_array($data_aspek)) foreach($data_aspek as $kode_aspek => $deskripsi) if($deskripsi)
		{
			$send['kode_aspek'] = $kode_aspek;
			$send['deskripsi'] = $deskripsi;
			$this->db->insert('tb_akd_rf_deskripsi_mp', $send);			
		}
		
		$this->db->trans_complete();
		return $this->db->trans_status();		
	}
	
	function getMapelSiswaByKelas($kelas, $id_ambil_kelas = false, $kode_thn_ajaran = THN_AJARAN)
	{
		$in_kelas = "ak.kode_kelas IN ('".implode("','", $kelas)."')";
		if($id_ambil_kelas) $in_kelas .= " AND ak.id_ambil_kelas='$id_ambil_kelas' ";

		$query = "SELECT
			ak.id_ambil_kelas, kode_kelas, sw.no_induk, sw.nama
		FROM
			tb_akd_tr_ambil_kelas ak
		JOIN
			tb_akd_rf_siswa sw ON ak.no_induk=sw.no_induk
		WHERE
			$in_kelas
			AND ak.kode_thn_ajaran = '$kode_thn_ajaran'
			AND ak.kode_jenjang = '".JENJANG."'
		ORDER BY
			no_induk ASC";
		$siswa = $this->db->query($query)->result();
		
		$query = "SELECT
			GROUP_CONCAT(ak.id_ambil_kelas SEPARATOR ' ') as id_ak, am.kode_mp, mp.nama_mp
		FROM
			tb_akd_tr_ambil_kelas ak
		JOIN
			tb_akd_tr_ambil_mp am ON ak.id_ambil_kelas=am.id_ambil_kelas
		JOIN
			tb_akd_rf_mp mp ON mp.kode_mp=am.kode_mp AND mp.kode_thn_ajaran=am.kode_thn_ajaran AND mp.kode_jenjang=am.kode_jenjang
		WHERE
			$in_kelas
			AND ak.kode_thn_ajaran = '$kode_thn_ajaran'
			AND ak.kode_jenjang = '".JENJANG."'
		GROUP BY
			kode_mp";
		$mapel = $this->db->query($query)->result();
		
		$pack = array(
			'siswa' => $siswa,
			'mapel' => $mapel,
		);
		return $pack;
		
	}

	function assignSiswa($ar_siswa, $ar_mapel)
	{
		if(!$ar_siswa || !is_array($ar_siswa) ) return false;
		
		$this->db->trans_start();
		$send = array();
		$where_ak = "id_ambil_kelas IN ('".implode("','", $ar_siswa)."')";
		$ak_detail = array();
		$data = $this->db->where($where_ak)->get('tb_akd_tr_ambil_kelas')->result();
		foreach($data as $row) $ak_detail[$row->id_ambil_kelas] = $row;
		$data = array();
		
		$this->db->where($where_ak)->delete('tb_akd_tr_ambil_mp');
		
		$mapel_exits = array();
		if(is_array($ar_mapel)) foreach($ar_mapel as $mapel)
		{
			$ar_str = explode('|', $mapel);
			$ar_kelas = explode(' ',$ar_str[1]);
			$kode_mapel = $ar_str[0];
			if(in_array($kode_mapel, $mapel_exits)) continue;			
			$id_ambil = array_intersect($ar_kelas, $ar_siswa);
			foreach($id_ambil as $row)
			{
				$send[] = array(
					'id_ambil_kelas' => $row,
					'no_induk' => $ak_detail[$row]->no_induk,
					'kode_thn_ajaran' => THN_AJARAN,
					'kode_jenjang' => JENJANG,
					//'kode_kelas' => $ak_detail[$row]->kode_kelas,
					'kode_mp' => $kode_mapel,
				);
			}
			$mapel_exits[] = $kode_mapel;
		}
		if($send) $this->db->insert_batch('tb_akd_tr_ambil_mp', $send);
		
		$this->db->trans_complete();
		return $this->db->trans_status();
		
	}
}