<?php


function dump($data, $is_die = true)
{
	echo '<pre>';print_r($data);echo '</pre>';
	if ($is_die) die;
}

function filesize2String($filesize)
{
	if ($filesize < 1000000 )
		$str = round($filesize/1000). ' Kb';
	else if ($filesize >= 1000000 && $filesize < 1000000000 ) 
		$str = number_format($filesize/1000000, 2). ' Mb';
	else 
		$str = number_format($filesize/1000000000, 2). ' Gb';
	
	return $str ;
}

function datetime2History($date)
{
	$past = new DateTime($date);
	$now = new DateTime('now');
	$interval = $past->diff($now);
	
	$str = $interval->format('%y tahun;%m bulan;%d hari;%h jam;%i menit;%s detik');
	$arr = explode(';', $str);
	
	foreach($arr as $val)
	{
		if (substr($val, 0, 1) !== '0') return $val;
	}
}

function date2Lama($date)
{
	$past = new DateTime($date);
	$now = new DateTime('now');
	$interval = $past->diff($now);
	
	return $interval->format('%y thn %m bln');
}

function dateInd2dateMySQL($date)
{
	if(!$date) return $date;
	$arr = explode('/', $date);
	return $arr[2].'-'.$arr[1].'-'.$arr[0];
}

function dateMySQL2dateInd($date)
{
	if(!$date) return $date;
	$arr = explode('-', $date);
	return $arr[2].'/'.$arr[1].'/'.$arr[0];
}

function my_base64_encode($str)
{
	return $str ? str_replace('=','',base64_encode($str)) : $str;
}

function getDatePickerRange()
{
	$bulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
	$text = array();
	for ($i = 0; $i < 6; $i++)
	{
		$date = strtotime("-$i month");
		$date_awal = date('Y-m-1', $date);
		$date_akhir = date('Y-m-t', $date);
		$label = $bulan[(int)date('m', $date)].' '.date('Y', $date);
		
		$text[] = "'$label': ['$date_awal', '$date_akhir']";		
	}
	$tahun = (int)date('Y') - 1;
	$text[] = "'Tahun Lalu': ['$tahun-01-01', '$tahun-12-31']";
	return implode(',', $text);
}

function replaceMonthToInd($str)
{
	$bulan = array('Jan' => 'Januari', 'Feb' => 'Februari', 'Mar' => 'Maret', 'Apr' => 'April', 'May' => 'Mei', 'Jun' => 'Juni', 'Jul' => 'Juli', 'Aug' => 'Agustus', 'Sep' => 'September', 'Oct' => 'Oktober', 'Nov' => 'November', 'Dec' => 'Desember' );
	return str_replace(array_keys($bulan), array_values($bulan), $str);
}