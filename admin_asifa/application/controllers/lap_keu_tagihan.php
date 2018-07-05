<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class lap_keu_tagihan extends crud_controller {

	public $title = 'Laporan Tagihan';
	public $table = 'tb_keu_tr_tagihan';
	public $primary_key = 'kode_tagihan';
	public $additional_script_main = 'lap_keu_tagihan/additional_main';
	
	public $column = array
	(
		'kode_tagihan' => array(
			'title' => 'Kode',
			'width' => '100',
			'filter' => 'text',
			'attribut' => array('data-class' => 'text-center', 'data-visible' => 'false'),
		),
		'no_induk' => array(
			'title' => 'No.Induk',
			'width' => '50',
			'filter' => 'text',
		),
		'nama_siswa' => array(
			'title' => 'Nama Siswa',
			'filter' => 'text',
		),
		'nama_jenis' => array(
			'title' => 'Jenis',
			'filter' => 'select',
			'filter_data' => array(),
			'filter_operator' => '=',
			'filter_field' => 'kode_jenis',
			'width' => '80',
			'attribut' => array('data-class' => 'text-center'),
		),
		'periode' => array(
			'title' => 'Periode',
			'filter' => 'text',
			'width' => '80',
			'attribut' => array('data-class' => 'text-center'),
		),
		'tagih' => array(
			'title' => 'Tagihan',
			'width' => '50',
			'attribut' => array('data-class' => 'text-right export-number'),
		),
		'bayar' => array(
			'title' => 'Dibayar',
			'width' => '50',
			'attribut' => array('data-class' => 'text-right export-number'),
		),
		'status_tagihan' => array(
			'title' => 'Status',
			'width' => '70',
			'filter' => 'select',
			'filter_data' => array(array('value'=>'Lunas','text'=>'Lunas'), array('value'=>'Belum Lunas','text'=>'Belum Lunas') ),
			'filter_operator' => '=',
			'attribut' => array('data-class' => 'text-center'),
		),
		'keterangan' => array(
			'title' => 'Keterangan',
			'filter' => 'text',
			'attribut' => array('data-visible' => 'false'),
		),
		'tgl_tagih' => array(
			'title' => 'Tgl Tagih',
			'width' => '50',
			'attribut' => array('data-class' => 'text-center', 'data-visible' => 'false'),
		),
		'tgl_bayar' => array(
			'title' => 'Tgl Bayar',
			'width' => '50',
			'attribut' => array('data-class' => 'text-center', 'data-visible' => 'false'),
		),
		'options-no-db' => array(
			'title' => 'Option',
			'width' => '40',
			'attribut' => array('data-class' => 'text-center', 'data-sortable' => 'false', 'data-visible' => 'false'),
		)
	);
	
	// protected CRUD function 
	protected function beforeMain($pack)
	{
		$this->column['nama_jenis']['filter_data'] = $this->db->select('kode_jenis as value, nama_jenis as text')->get('tb_keu_rf_jenis_pembayaran')->result();
		return $pack;
	}
	
	protected function renderTable($kolom, $table, $primary_key)
	{
		$bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
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
			GROUP BY
				t.kode_tagihan
		) as tagih
		LEFT JOIN
			tb_akd_rf_siswa s ON s.no_induk=tagih.no_induk";
			
		$data = $this->datatable->render($kolom, $query, $primary_key, true, true);
		$data_baru = array();
		foreach($data->data as $key => $row)
		{
			$data_baru[] = array(
				$row->kode_tagihan,
				$row->no_induk,
				$row->nama_siswa,
				$row->nama_jenis,
				$row->tipe_jenis == 'per_bulan' ? $bulan[(int)date('m', strtotime($row->periode))].' '.date('Y', strtotime($row->periode)) : $row->periode,
				number_format($row->tagih,0,',','.'),
				number_format($row->bayar,0,',','.'),
				$row->status_tagihan,
				$row->keterangan,
				$row->tgl_tagih,
				$row->tgl_bayar,
				'<a href="'.site_url(PAGE_ID.'/form/'.my_base64_encode($row->kode_tagihan)).'" class="btn btn-xs btn-primary" data-original-title="Ubah" rel="tooltip" data-toggle="modal" data-target="#main-modal-lg"><i class="fa fa-pencil"></i></a>'
			);
		}
		$data->data = $data_baru;
		return $data;
	}
	
	// override CRUD function
	public function form($id)
	{
		$raw_id = $id;
		$id = $id ? base64_decode($id) : false;
		$this->load->model('mod_tagihan');
		$this->load->model('mod_pembayaran');
		
		if ($this->input->server('REQUEST_METHOD') == 'POST') 
		{
			$res = $this->mod_tagihan->ubahNominalTagihan($id, str_replace('.','',$_POST['nominal_tagihan']));
			die($res ? 'ok' : 'not ok');
		}
		
		$pack = array(
			'tagihan' => $this->mod_tagihan->getSingleData($id),
			'pembayaran' => $this->mod_pembayaran->getDataByKodeTagihan($id),
			'id' => $id,
			'raw_id' => $raw_id,
		);
		
		$this->load->view(PAGE_ID.'/v_form', $pack);
		
	}
	
	public function delete($id)
	{
		$raw_id = $id;
		$id = $id ? base64_decode($id) : false;
		$this->load->model('mod_tagihan');
		$res = $this->mod_tagihan->deleteTagihan($id);
		die($res ? 'ok' : 'not ok');
		
	}
}