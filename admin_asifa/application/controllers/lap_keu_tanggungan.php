<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class lap_keu_tanggungan extends admin_controller {
	
	public $title = 'Laporan Tanggungan';
	public $column = array
	(
		'no_induk' => array(
			'title' => 'No.Induk',
			'width' => '50',
			'filter' => 'text',
		),
		'nama_siswa' => array(
			'title' => 'Nama Siswa',
			'filter' => 'text',
		),
	);

	public function index()
	{
		$jenis = $this->db
			->order_by('tipe_jenis', 'ASC')
			->get('tb_keu_rf_jenis_pembayaran')
			->result();
			
		foreach($jenis as $row)
		{
			$kode = str_replace(array('-','.'),'_',$row->kode_jenis);
			$this->column[$kode] = array(
				'title' => str_replace(' ','<br>',$row->nama_jenis),
				'width' => '40',
				'attribut' => array('data-class' => 'text-right export-number'),
			);
		}
		$this->column['total'] = array(
				'title' => 'Total',
				'width' => '40',
				'attribut' => array('data-class' => 'text-right export-number'),
			);
		$pack = array(
			'jenis' => $jenis,
		);
		$this->load->template('lap_keu_tanggungan/v_main', $pack);
		
	}
	
	public function get_datatable()
	{
		$jenis = $this->db
			->order_by('tipe_jenis', 'ASC')
			->get('tb_keu_rf_jenis_pembayaran')
			->result();
		
		$header = array();
		$header_sum = array();
		$kolom = array('no_induk', 'nama_siswa');
		foreach($jenis as $row)
		{
			$kode = str_replace(array('-','.'),'_',$row->kode_jenis);
			$header[] = "SUM(IF(tg.kode_jenis = '".$row->kode_jenis."', tg.tot_tanggungan, 0)) as $kode";
			$header_sum[$kode] = "SUM($kode) as $kode";
			$kolom[] = $kode;
		}
		$header_sum['total'] = "SUM(total) as total";
		$kolom[] = 'total';
		$header = $header ? implode(',', $header).',' : '';

		$query = "SELECT
			s.nama as nama_siswa, mtg.*
		FROM
		(
			SELECT
				tg.no_induk,
				$header
				SUM(tg.tot_tanggungan) as total
			FROM
			(
				SELECT
					t.no_induk,
					t.kode_jenis,
					SUM(t.tanggungan) as tot_tanggungan
				FROM
				(
					SELECT
						t.no_induk, 
						t.kode_jenis, 
						t.nominal as tagih, 
						sum(COALESCE(p.nominal,0)) as bayar, 
						t.nominal - sum(COALESCE(p.nominal,0)) as tanggungan
					FROM
						tb_keu_tr_tagihan t
					LEFT JOIN
						tb_keu_tr_pembayaran p ON t.kode_tagihan=p.kode_tagihan
					GROUP BY
						t.kode_tagihan
				) as t
				GROUP BY
					t.no_induk, t.kode_jenis
			) as tg
			GROUP BY
				tg.no_induk
		) as mtg
		LEFT JOIN
			tb_akd_rf_siswa s ON s.no_induk=mtg.no_induk";
		
		$this->load->library('datatable');
		$data = $this->datatable->render($kolom, $query, 'no_induk', false, true);
		foreach($data->data as $key=>$row)
		{
			for($i=2; $i<count($jenis)+2; $i++) $data->data[$key][$i] = number_format($row[$i],0,',','.');
			$data->data[$key][count($row)-1] = number_format($row[count($row)-1],0,',','.');
		}
		
		$query_sum = $this->datatable->getQueryAfterFilter();
		$query_sum = str_replace('asas.*', implode(',', $header_sum), $query_sum);
		$total = $this->db->query($query_sum)->row_array();
		
		$data->total = array();
		foreach($kolom as $key => $val)
		{
			$data->total[$key] = isset($total[$val]) ? $total[$val] : '';
		}
		
		echo json_encode($data);
	}
	
}