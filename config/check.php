<?php
	error_reporting(0);
	ob_start();	
	session_start();
	
	include "connection.php";
	include "../library/datetime.php";
	include "../library/sequence.php";
	
	function sql_injection($string)
	{
		$real_escape_string = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($string,ENT_QUOTES))));
		return $real_escape_string;
	}
	
	$username = sql_injection($_POST['username']);
	$password = sql_injection(md5($_POST['password']));
	
	$user_query = mysql_query("SELECT a.user_id, a.user_name, a.user_username, a.user_password, a.item_category_id, b.user_category_name FROM user a, user_category b WHERE a.user_category_id = b.user_category_id AND a.user_username = '".$username."' AND a.user_password = '".$password."' AND a.user_active = '1' AND b.user_category_active = '1'");
	$user_num_rows = mysql_num_rows($user_query);
	$user_fetch_array = mysql_fetch_array($user_query);
	
	if ($user_num_rows > 0)
	{
		$_SESSION['user_id'] = $user_fetch_array['user_id'];
		$_SESSION['user_category_name'] = $user_fetch_array['user_category_name'];
		$_SESSION['item_category_id'] = $user_fetch_array['item_category_id'];
		$_SESSION['user_name'] = $user_fetch_array['user_name'];
		$_SESSION['user_username'] = $user_fetch_array['user_username'];
		$_SESSION['user_password'] = $user_fetch_array['user_password'];
		
		$user_history_id = sequence("user_history", "user_history_id");
		
		$user_history_information = $_SERVER['HTTP_USER_AGENT'];
		
		if (preg_match('/linux/i', $user_history_information))
		{
			$user_history_os = 'Linux';
		}
		elseif (preg_match('/macintosh|mac os x/i', $user_history_information))
		{
			$user_history_os = 'Mac';
		}
		elseif (preg_match('/windows|win32/i', $user_history_information))
		{
			$user_history_os = 'Windows';
		}
		
		if(preg_match('/MSIE/i', $user_history_information) && !preg_match('/Opera/i', $user_history_information))
		{
			$user_history_browser = 'Internet Explorer';
		}
		elseif(preg_match('/Firefox/i', $user_history_information))
		{
			$user_history_browser = 'Mozilla Firefox';
		}
		elseif(preg_match('/Chrome/i', $user_history_information))
		{
			$user_history_browser = 'Google Chrome';
		}
		elseif(preg_match('/Safari/i', $user_history_information))
		{
			$user_history_browser = 'Apple Safari';
		}
		elseif(preg_match('/Opera/i', $user_history_information))
		{
			$user_history_browser = 'Opera';
		}
		elseif(preg_match('/Netscape/i', $user_history_information))
		{
			$user_history_browser = 'Netscape';
		}
		
		mysql_query("INSERT INTO user_history(user_history_id, user_history_ip, user_history_os, user_history_browser, user_history_create, user_history_update, user_activity_id, user_history_active) VALUES ('".$user_history_id."', '".$_SERVER['REMOTE_ADDR']."', '".$user_history_os."', '".$user_history_browser."', '".$today."', '".$today."', '".$_SESSION['user_id']."', '1')");
		
		header("location:../dataverse/home.php?connect=dashboard");
	}
	else
	{
		header("location:../home.php?connect=login&action=error");
	}
?>