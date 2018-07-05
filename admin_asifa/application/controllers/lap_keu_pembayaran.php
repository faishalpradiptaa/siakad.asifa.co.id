<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class lap_keu_pembayaran extends crud_controller {

	public $title = 'Laporan Pembayaran';
	public $table = 'tb_keu_tr_pembayaran';
	public $primary_key = 'kode_pembayaran';
	public $additional_script_main = 'lap_keu_pembayaran/additional_main';
	
	public $column = array
	(
		'kode_pembayaran' => array(
			'title' => 'Kode',
			'width' => '100',
			'filter' => 'text',
			'attribut' => array('data-class' => 'text-center', 'data-visible' => 'false'),
		),
		'kode_tagihan' => array(
			'title' => 'Kode Tagihan',
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
		'tgl_bayar' => array(
			'title' => 'Tgl Bayar',
			'width' => '50',
			'attribut' => array('data-class' => 'text-center'),
		),
		'jenis_transaksi' => array(
			'title' => 'Transaksi',
			'width' => '50',
			'attribut' => array('data-class' => 'text-center'),
		),
		'bank' => array(
			'title' => 'Bank',
			'width' => '50',
			'filter' => 'text',
			'attribut' => array('data-class' => 'text-center'),
		),
		'bayar' => array(
			'title' => 'Bayar',
			'width' => '50',
			'attribut' => array('data-class' => 'text-right export-number'),
		),
		'tgl_entry' => array(
			'title' => 'Tgl Entry',
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
		
		$where = array();
		if(isset($_GET['in_taw']) && $_GET['in_taw']) $where[] = "p.tgl_bayar >= '".$_GET['in_taw']."'";
		if(isset($_GET['in_tak']) && $_GET['in_tak']) $where[] = "p.tgl_bayar <= '".$_GET['in_tak']."'";
		$where = $where ? ' WHERE '.implode(' AND ', $where) : '';
		
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
			tb_akd_rf_siswa s ON s.no_induk=tagih.no_induk";
		$data = $this->datatable->render($kolom, $query, $primary_key, true, true);
		$data_baru = array();
		foreach($data->data as $key => $row)
		{
			$data_baru[] = array(
				$row->kode_pembayaran,
				$row->kode_tagihan,
				$row->no_induk,
				$row->nama_siswa,
				$row->nama_jenis,
				$row->tipe_jenis == 'per_bulan' ? $bulan[(int)date('m', strtotime($row->periode))].' '.date('Y', strtotime($row->periode)) : $row->periode,
				date('d/m/Y', strtotime($row->tgl_bayar)),
				ucwords($row->jenis_transaksi),
				$row->bank,
				number_format($row->bayar,0,',','.'),
				date('d/m/Y', strtotime($row->tgl_entry)),
				'<a href="'.site_url(PAGE_ID.'/form/'.my_base64_encode($row->kode_pembayaran)).'" class="btn btn-xs btn-primary" data-original-title="Ubah" rel="tooltip" data-toggle="modal" data-target="#main-modal-lg"><i class="fa fa-pencil"></i></a>'
			);
		}
		$data->data = $data_baru;
		
		$query_sum = $this->datatable->getQueryAfterFilter();
		$query_sum = str_replace('asas.*', 'SUM(COALESCE(asas.bayar)) as total_bayar', $query_sum);
		$total = $this->db->query($query_sum)->row();
		$data->sum_total = $total ? $total->total_bayar : 0;
		return $data;
	}
	
	// override CRUD function
	public function form($id)
	{
		$raw_id = $id;
		$id = $id ? base64_decode($id) : false;
		$this->load->model('mod_pembayaran');
		$this->load->model('mod_tagihan');
		
		if ($this->input->server('REQUEST_METHOD') == 'POST') 
		{
			$args = array(
				'nominal' => str_replace('.','',$_POST['nominal_bayar']),
				'tgl_bayar' => dateInd2dateMySQL($_POST['tgl_bayar']),
			);
			$res = $this->mod_pembayaran->ubahPembayaran($id,$args);
			die($res ? 'ok' : 'not ok');
		}
		$bayar = $this->mod_pembayaran->getSingleData($id);
		
		$pack = array(
			'pembayaran' => $bayar,
			'tagihan' => $this->mod_tagihan->getSingleData($bayar->kode_tagihan),
			'id' => $id,
			'raw_id' => $raw_id,
		);
		
		$this->load->view(PAGE_ID.'/v_form', $pack);
		
	}
	
	public function delete($id)
	{
		$raw_id = $id;
		$id = $id ? base64_decode($id) : false;
		$this->load->model('mod_pembayaran');
		$this->load->model('mod_tagihan');
		$res = $this->mod_pembayaran->deletePembayaran($id);
		die($res ? 'ok' : 'not ok');
	}
}