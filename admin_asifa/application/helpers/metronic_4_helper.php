<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$metronic_instance = false;

function getMetronicMenu()
{
	global $metronic_instance;
	if (!$metronic_instance) 
	{
		$metronic_instance =& get_instance();
		$metronic_instance->load->model('sys_model');
	}
	$data_raw = $metronic_instance->sys_model->getMenu();
	//dump($data_raw);
	
	$data_asal = array();
	$data = array();
	$exception = array('', '#', 'javascript:;');
	
	
	foreach($data_raw as $i => $row) 
	{
		$row->URL = in_array($row->URL, $exception) ? 'javascript:;' : site_url($row->URL);
		$data_asal[$row->Menu_id] = $row;
		if (!$row->Induk_Menu) 
		{
			$data[$row->Menu_id] = $row;
			$data_raw[$i] = false;
			unset($data_raw[$i]);
		}
	}
	
	$html = '<ul class="page-sidebar-menu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">';
	foreach($data as $row) 
	{
		$my_child = trim(getChildMetronicMenuHTML($row, $data_raw));
		$html .= '<li><a href="'.$row->URL.'" id="'.$row->Menu_id.'"><i class="fa '.$row->Icon.'"></i> <span class="title">'.$row->Nama_Menu.'</span> '.($my_child ? ' <span class="arrow "></span>' : '').'</a> '.$my_child.'</li>';
	}
	$html .= '</ul>';
	
	$pack = (object)array(
		'data' => $data_raw,
		'tree' => $html,
	);
	return $pack->tree;
}

function getChildMetronicMenuHTML($induk, &$raw)
{
	$child = '';
	$z = $raw;
	if($z) foreach($z as $i => $row) if ($row->Induk_Menu == $induk->Menu_id) 
	{
		//if($row->Menu_id == 'Simpeg_DP3_Master') dump($raw, false);
		$child .= '<li><a href="'.$row->URL.'" id="'.$row->Menu_id.'"><i class="fa '.$row->Icon.'"></i> <span class="title">'.$row->Nama_Menu.'</span>';
		unset($raw[$i]);
		$mychild = trim(getChildMetronicMenuHTML($row, $raw));
		$child .= $mychild ? '<span class="arrow "></span> </a>'.$mychild : '</a>';
		$child .= '</li>';
	}
	$child = $child ? '<ul class="sub-menu">'.$child.'</ul>' : '';
	
	return $child;
}




function getMetronicBreadcrumb($active_page)
{
	global $metronic_instance;
	if (!$metronic_instance) 
	{
		$metronic_instance =& get_instance();
		$metronic_instance->load->model('sys_model');
	}
	$data_raw = $metronic_instance->sys_model->getMenu();
	$data_new = array();
	$start = false;
	
	foreach($data_raw as $i => $row) 
	{
		if(substr($row->URL, strlen($active_page)*-1) == $active_page) $start = $row->Menu_id;
		$data_new[$row->Menu_id] = $row;
	}
	
	if(!$start) return false;
	
	$i = 0;
	$arr_bread = array();
	while($start && $i < 10)
	{
		array_push($arr_bread, $start);
		$start = $data_new[$start]->Induk_Menu ? $data_new[$start]->Induk_Menu : false;
		$i++;
	}
	$arr_bread = array_reverse($arr_bread);
	
	$breadcrumb = array();
	foreach($arr_bread as $bread) if (isset($data_new[$bread]))
	{
		$row = $data_new[$bread];
		$breadcrumb[] = '<li><a href="'.$row->URL.'">'.$row->Nama_Menu.'</a></li>';
	}
	$breadcrumb = '<ul class="page-breadcrumb breadcrumb">'.implode('<li><i class="fa fa-circle"></i></li>',$breadcrumb).'</ul>';
	return $breadcrumb;
	
	
}


