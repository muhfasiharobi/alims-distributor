<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_delivery_session();
		break;
		
		case "form-add-delivery-session":
			form_add_delivery_session();
		break;
	
		case "add-delivery-session":
			$delivery_session_id = idbaru("delivery_session","delivery_session_id");
			
			mysql_query("INSERT INTO delivery_session(delivery_session_id, delivery_session_name, delivery_session_datetime, user_id) VALUES ('".$delivery_session_id."', '".$_POST['delivery_session_price']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
	
			header("location:../system/page_home.php?alimms=delivery-session");	
		break;
	
		case "form-edit-delivery-session":
			form_edit_delivery_session();
		break;
		
		case "edit-delivery-session":
			mysql_query("UPDATE delivery_session SET delivery_session_name = '".$_POST['delivery_session_name']."', delivery_session_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE delivery_session_id = '".$_POST['delivery_session_id']."'");
		
			header("location:../system/page_home.php?alimms=delivery-session");	
		break;
	
		case "delete-delivery-session":
			mysql_query("UPDATE delivery_session SET delivery_session_datetime = '".$waktu_sekarang."', delivery_session_active = '0', user_id = '".$_SESSION['user_id']."' WHERE delivery_session_id = '".$_GET['delivery_session_id']."'");
			
			header("location:../system/page_home.php?alimms=delivery-session");	
		break;
		
		case "active-delivery-session":
			mysql_query("UPDATE delivery_session SET delivery_session_datetime = '".$waktu_sekarang."', delivery_session_active = '1', user_id = '".$_SESSION['user_id']."' WHERE delivery_session_id = '".$_GET['delivery_session_id']."'");
			
			header("location:../system/page_home.php?alimms=delivery-session");	
		break;
	}
?>