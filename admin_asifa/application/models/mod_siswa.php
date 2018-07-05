<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mod_siswa extends MY_Model
{
	public function getAllAngkatan()
	{
		return $this->db->select('angkatan')->group_by('angkatan')->get('tb_akd_rf_siswa')->result();
	}
	
	public function getDetailByIdAmbilKelas($id_ambil_kelas)
	{
		return $this->db
			->select('ak.*, sw.no_induk, sw.nisn, sw.nama, sw.angkatan, sw.tahun_lahir, sw.telp, st.nama_status, sk.nama_sekolah, jr.nama_jurusan, kl.nama_kelas, gr.nama as nama_wali_kelas, sk.kepsek, sk.nip_kepsek')
			->join('tb_akd_rf_siswa sw', 'sw.no_induk=ak.no_induk')
			->join('tb_app_rf_status st', 'st.kode_status = sw.status_akademis')
			->join('tb_akd_rf_sekolah sk', 'sk.kode_sekolah = ak.kode_sekolah AND sk.jenjang=ak.kode_jenjang', 'left')
			->join('tb_akd_rf_jurusan jr', 'jr.kode_jurusan = ak.kode_jurusan', 'left')
			->join('tb_akd_rf_kelas kl', 'kl.kode_kelas = ak.kode_kelas AND kl.kode_thn_ajaran=ak.kode_thn_ajaran AND kl.kode_jenjang=ak.kode_jenjang')
			->join('tb_akd_rf_guru gr', 'kl.no_induk_guru=gr.no_induk', 'left')
			->where('ak.kode_thn_ajaran', THN_AJARAN)
			->where('ak.kode_jenjang', JENJANG)
			->where('ak.id_ambil_kelas', $id_ambil_kelas)
			->get('tb_akd_tr_ambil_kelas ak')
			->row();		
	}
	
	public function getDetailByNoInduk($no_induk)
	{
		return $this->db
			->select('ak.*, sw.no_induk, sw.nisn, sw.nama, sw.angkatan, sw.tahun_lahir, sw.telp, st.nama_status, jj.nama_jenjang, sk.nama_sekolah, jr.nama_jurusan, kl.nama_kelas, gr.nama as nama_wali_kelas, sk.kepsek, sk.nip_kepsek')
			->join('tb_akd_rf_siswa sw', 'sw.no_induk=ak.no_induk')
			->join('tb_app_rf_status st', 'st.kode_status = sw.status_akademis')
			->join('tb_akd_rf_jenjang jj', 'jj.kode_jenjang = ak.kode_jenjang')
			->join('tb_akd_rf_sekolah sk', 'sk.kode_sekolah = ak.kode_sekolah AND sk.jenjang=ak.kode_jenjang', 'left')
			->join('tb_akd_rf_jurusan jr', 'jr.kode_jurusan = ak.kode_jurusan', 'left')
			->join('tb_akd_rf_kelas kl', 'kl.kode_kelas = ak.kode_kelas AND kl.kode_thn_ajaran=ak.kode_thn_ajaran AND kl.kode_jenjang=ak.kode_jenjang')
			->join('tb_akd_rf_guru gr', 'kl.no_induk_guru=gr.no_induk')
			->where('ak.kode_thn_ajaran', THN_AJARAN)
			->where('ak.kode_jenjang', JENJANG)
			->where('ak.no_induk', $no_induk)
			->get('tb_akd_tr_ambil_kelas ak')
			->row();		
	}
	
	function getDataAutoComplete($limit=10)
	{
		$txt = isset($_GET['q']) ? $_GET['q'] : '';
		$query = "SELECT
			no_induk AS id,
			nama AS text,
			'' as encoded_id
		FROM
			tb_akd_rf_siswa
		WHERE
			no_induk LIKE '%$txt%'
			OR nama LIKE '%$txt%'
		LIMIT $limit";
		$data = $this->db->query($query)->result();
		foreach($data as $row) $row->encoded_id = my_base64_encode($row->id);
		return $data;
	}
	
}