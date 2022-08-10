<?php
	date_default_timezone_set("Asia/Jakarta");
	
	$today = date("Y-m-d H:i:s");
	$today_date = date("Y-m-d");
	$today_time = date("H:i:s");
	$today_year = date("Y");
	$today_month = date("m");
	
	function day($day)
	{
		switch ($day)
		{
			case 0 :
				$day = "Minggu";
				return $day;
				break;
			case 1 :
				$day = "Senin";
				return $day;
				break;
			case 2 :
				$day = "Selasa";
				return $day;
				break;
			case 3 :
				$day = "Rabu";
				return $day;
				break;
			case 4 :
				$day = "Kamis";
				return $day;
				break;
			case 5 :
				$day = "Jum'at";
				return $day;
				break;
			case 6 :
				$day = "Sabtu";
				return $day;
				break;
		}
	}
	
	function month($month)
	{
		switch ($month)
		{
			case 1 :
				$month = "Januari";
				return $month;
				break;
			case 2 :
				$month = "Februari";
				return $month;
				break;
			case 3 :
				$month = "Maret";
				return $month;
				break;
			case 4 :
				$month = "April";
				return $month;
				break;
			case 5 :
				$month = "Mei";
				return $month;
				break;
			case 6 :
				$month = "Juni";
				return $month;
				break;
			case 7 :
				$month = "Juli";
				return $month;
				break;
			case 8 :
				$month = "Agustus";
				return $month;
				break;
			case 9 :
				$month = "September";
				return $month;
				break;
			case 10 :
				$month = "Oktober";
				return $month;
				break;
			case 11 :
				$month = "November";
				return $month;
				break;
			case 12 :
				$month = "Desember";
				return $month;
				break;
		}
	}
	
	function indonesia_datetime()
	{
		$day_month = day(date("w"));
		$today_month = month(date("m"));
		return $day_month.", ".date("d")." ".$today_month." ".date("Y");
	}
	
	function indonesia_date_format($string)
	{
		$date = substr($string, 8, 2);
		$month = month(substr($string, 5, 2));
		$year = substr($string, 0, 4);
		return $date." ".$month." ".$year;
	}
	
	function indonesia_datetime_format($string)
	{
		$day = day(date("w", strtotime($string)));
		$date = substr($string, 8, 2);
		$month = month(substr($string, 5, 2));
		$year = substr($string, 0, 4);
		return $day.", ".$date." ".$month." ".$year;
	}
?>