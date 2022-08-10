<?php
	//error_reporting(0);
	//ob_start();	
	session_start();
	
	include "script_conn.php";
	
	function antiinjection($data)
	{
		$filter_sql = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
		return $filter_sql;
	}
	
	$username = antiinjection($_POST['username']);
	$password = antiinjection(md5($_POST['password']));
	
	$tbl_user = mysql_query("SELECT a.user_id, a.user_username, a.user_password, a.user_name, b.user_category_name FROM user a, user_category b WHERE a.user_username = '".$username."' AND a.user_password = '".$password."' AND a.user_category_id = b.user_category_id");
	$jumlah_tbl_user = mysql_num_rows($tbl_user);
	$data_tbl_user = mysql_fetch_array($tbl_user);
	
	if ($jumlah_tbl_user > 0)
	{   
		$_SESSION['user_id'] = $data_tbl_user['user_id'];
		$_SESSION['user_username'] = $data_tbl_user['user_username'];
		$_SESSION['user_password'] = $data_tbl_user['user_password'];
		$_SESSION['user_name'] = $data_tbl_user['user_name'];
		$_SESSION['user_category_name'] = $data_tbl_user['user_category_name'];
		
		header("location:system/page_home.php?alimms=dashboard");
	}
	else
	{
		header("location:index.php");
	}
?>