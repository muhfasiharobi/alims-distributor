<?php
	$hostname['hostname'] = "";
	$username['username'] = "root";
	$password['password'] = "";
	$database['database'] = "db_elogistics";

	$connect = mysql_connect($hostname['hostname'], $username['username'], $password['password']);
	if (!$connect)
	{
		echo "Gagal Koneksi Database !!! ".mysql_error();
	}
	mysql_select_db($database['database']) or die ("Database Tidak Ada ".mysql_error());
?>