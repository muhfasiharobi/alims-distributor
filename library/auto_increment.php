<?php
	include "../script_conn.php";
	
	function idbaru($tabel,$kunci) 
	{
		$tbl = mysql_query("SELECT MAX(".$kunci.")+1 as kode FROM ".$tabel);
		$data_tbl = mysql_fetch_array($tbl);
		$jumlah_data_tbl = mysql_num_rows($tbl);
		
		if ($data_tbl['kode']==null) 
		{
			$newID = 1;
		} 
		else
		{
			$newID = $data_tbl['kode'];
		}
		return $newID;
	}	
?>