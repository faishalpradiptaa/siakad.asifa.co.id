<?php

class datatable {
	
	/**
	 * Library datatable untuk Codeigniter
	 *
	 *  @param  array 					$columns 			Kolom yang ditampilkan di datatable, harus urut, untuk pilihan / option gunakan "options-no-db"
	 *  @param  string|db class $table   			Nama tabel, bisa berupa string atau object dari db, contoh: $table = $this->db->from('namatebel');
	 *  @param 	string          $primary_key 	Primary key untuk tiap-tiap row, terletak pada index terakhir pada data (biasanya untuk kolom action)
	 *  @param  boolean 				$output_raw 	Jika true maka akan memberikan output data berupa data mentah
	 *  @return object												Output berupa object yang siap untuk dijadikan json
	 */
	 private $query_after_filter = '';
	 private $query_after_limit = '';
	 
	function render($columns = array(), $table = false, $primary_key = 'id', $output_raw = false, $custom_query=false)
	{
		if (!is_array($columns) || count($columns) < 1 || !$table) return false;
		
		$filter_field = $columns;
		$default_operator_field = 'like';
		$operator_field = 'like';
		
		if (isset($columns['filter'])) $filter_field = $columns['filter'];
		if (isset($columns['operator'])) $operator_field = $columns['operator'];
		if (isset($columns['field'])) $columns = $columns['field'];
		
		if(isset($filter_field['field'])) $filter_field = $filter_field['field'];
		
		$CI = & get_instance();
		$length = $_GET['length'];
		$start = $_GET['start'];
		$keyword = $_GET['search']['value'];
		$sort = $_GET['order'];
		$attr = $_GET['columns'];
		$draw = $_GET['draw'];
		
		$reserved = array('options-no-db', 'options-no-db-link', 'no-no-db', 'detail-no-db');

		if (!$custom_query)
		{
			$table = (is_object($table)) ? $table : $CI->db->from($table);
			$sort = (count($sort) > 0) ? $sort[0] : false;
			$query_before_filter = $table->_compile_select();
		} 
		else
		{
			$sql = $table;
			$table =  $CI->db;
		}
		
		//search in all column
		if (!$custom_query)
		{
			$where = array();
			if ($sort) $table->order_by($columns[$sort['column']], $sort['dir']);
			if ($keyword) foreach ($columns as $col) if (!in_array($col, $reserved)) array_push($where, "$col like \"%$keyword%\"");
		}
		else
		{
			$where = array();
			if ($sort) $sort = 'Order by asas.'.$columns[$sort[0]['column']].' '.$sort[0]['dir'];
			if ($keyword) foreach ($columns as $col) if (!in_array($col, $reserved)) array_push($where, "asas.$col like \"%$keyword%\"");
		}
		
		if (!$custom_query)
		{
			if (count($where) > 0)
			{		
				$where = implode(' or ', $where);
				$table->where("($where)");
			}
		} else {
			if (count($where) > 0)
			{		
				
				$where = implode(' or ', $where);
				$where = "($where) ";
				
			} 
			else $where = '';
			
		}
		
		
		if (!$custom_query)
		{
			//search by per column
			//foreach ($attr as $key=>$col) if ($col['search']['value']) $table->like($columns[$key], $col['search']['value']);			
			
			//search by per column
			foreach ($attr as $key=>$col) if ($col['search']['value'])
			{
				$opr = isset($operator_field[$key]) ? $operator_field[$key] : $default_operator_field;
				if ($opr == 'like') $table->like($filter_field[$key], $col['search']['value']);	
				else if ($opr == '=') $table->where($filter_field[$key], $col['search']['value']);	
				else $table->like($filter_field[$key], $col['search']['value']);	
			}
		}
		else 
		{
			$search_pc = array();
			foreach ($attr as $key=>$col) if ($col['search']['value']) 
			{
				$opr = isset($operator_field[$key]) ? $operator_field[$key] : $default_operator_field;
				if ($opr == '=') array_push($search_pc, 'asas.'.$filter_field[$key] .' = \''. $col['search']['value'].'\'');
				else array_push($search_pc, 'asas.'.$filter_field[$key] .' like \'%'. $col['search']['value'].'%\'');
			}
			if (count($search_pc) > 0) $search_pc = implode(' and ', $search_pc);			
			else $search_pc = '';
		}
		
		$query = ($custom_query) ? $sql :  $table->_compile_select();
		$total_before = ($custom_query) ?  $table->query($query)->num_rows() : $table->query($query_before_filter)->num_rows();
		//$total_after = $table->query($query)->num_rows();
		if ($custom_query)
		{
			
			$where_c = '';
			if ($where && $search_pc) $where_c = " where $where and $search_pc ";
			else if ($where)  $where_c = " where $where ";
			else if ($search_pc)  $where_c = " where $search_pc "; 
			
			$limit = ($length > 0) ? "LIMIT $start,$length" : '';
			$query_count = "Select asas.* From ($query) as asas $where_c;"; 
			$query = "Select asas.* From ($query) as asas $where_c $sort $limit;";
			$this->query_after_filter = $query_count;
			$this->query_after_limit = $query;
		}
		else
		{
			$limit = ($length > 0) ? "LIMIT $start,$length" : '';
			$query_count = $query;
			$query = "$query $limit;";
			$this->query_after_filter = $query_count;
			$this->query_after_limit = $query;
		}
		$data = $table->query($query)->result();
		$total_after = $table->query($query_count)->num_rows();
		
		if (!$output_raw) 
		{
			$data_fix = array();
			foreach ($data as $i => $row)
			{
				$data_row = array();
				foreach($columns as $key=>$val) 
				{
					if ($val == 'options-no-db')
					{
						$data_row[$key] =
						"<div class='btn-group'><a href='#' data-toggle='datatable-dropdown' class='dropdown-toggle btn btn-xs btn-primary' data-original-title='Opsi' rel='tooltip'><i class='fa fa-cog'></i></a>
							 <ul class='dropdown-menu pull-right text-left'>
									<li><a class='clickable' href='".site_url(PAGE_ID.'/detail/'.my_base64_encode($row->$primary_key))."' data-toggle='modal' data-target='#main-modal-md'><i class='fa fa-file'></i> Detail</a></li>
									<li><a class='clickable' href='".site_url(PAGE_ID.'/form/'.my_base64_encode($row->$primary_key))."' data-toggle='modal' data-target='#main-modal-md'><i class='fa fa-pencil'></i> Ubah</a></li>
									<li><a class='clickable' href='".site_url(PAGE_ID.'/delete/'.my_base64_encode($row->$primary_key))."' data-toggle='delete'><i class='fa fa-trash'></i> Hapus</a></li>
							 </ul>
						</div>";
					}
					elseif ($val == 'options-no-db-link')
					{
						$data_row[$key] = 
							"<a href='".site_url(PAGE_ID.'/form/'.my_base64_encode($row->$primary_key))."' data-toggle='modal' data-target='#main-modal-md' data-original-title='Ubah' rel='tooltip'><i class='fa fa-pencil'></i></a> &nbsp; 
							<a href='".site_url(PAGE_ID.'/delete/'.my_base64_encode($row->$primary_key))."' data-toggle='delete' ><i class='fa fa-trash-o' data-original-title='Hapus' rel='tooltip'></i></a>";
					}
					elseif ($val == 'detail-no-db')
					{
						$data_row[$key] = "<a href='".site_url(PAGE_ID.'/detail/'.my_base64_encode($row->$primary_key))."' data-toggle='modal' data-target='#main-modal-md'><i class='fa fa-file-text-o'></i></a>";
					}
					elseif ($val == 'no-no-db')
					{
						$data_row[$key] = $start + $i + 1;
					}
					else $data_row[$key] = $row->$val;
				}
				array_push($data_fix, $data_row);		
			}
		} 
		else $data_fix = $data;
		
		
		$output = (object)array(
			"draw" => $draw,
			"recordsTotal" => $total_before,
			"recordsFiltered" => $total_after,
			"data" => $data_fix
		);
		return $output;
		
	}
	
	function getQueryAfterFilter()
	{
		return $this->query_after_filter;
	}
	
	function getQueryAfterLimit()
	{
		return $this->query_after_limit;
	}
}

