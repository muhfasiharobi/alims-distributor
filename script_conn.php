<?php
	$alimms['hostname'] = "localhost";
	$alimms['username'] = "root";
	$alimms['password'] = "";
	$alimms['database'] = "iaucxclf_alimms_new";

	$conn = mysql_connect($alimms['hostname'], $alimms['username'], $alimms['password']);
	if (! $conn)
	{
		echo "Gagal Koneksi Database !!!".mysql_error();
	}
	mysql_select_db($alimms['database'])
	or die ("Database Tidak Ada".mysql_error());
?>