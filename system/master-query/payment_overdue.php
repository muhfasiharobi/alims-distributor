<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_payment_overdue();
		break;
		
		case "form-add-payment-overdue":
			form_add_payment_overdue();
		break;
	
		case "add-payment-overdue":
			$payment_overdue_id = idbaru("payment_overdue","payment_overdue_id");
			
			mysql_query("INSERT INTO payment_overdue(payment_overdue_id, payment_overdue_day, payment_overdue_datetime, user_id) VALUES ('".$payment_overdue_id."', '".$_POST['payment_overdue_day']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
	
			header("location:../system/page_home.php?alimms=payment-overdue");	
		break;
	
		case "form-edit-payment-overdue":
			form_edit_payment_overdue();
		break;
		
		case "edit-payment-overdue":
			mysql_query("UPDATE payment_overdue SET payment_overdue_day = '".$_POST['payment_overdue_day']."', payment_overdue_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE payment_overdue_id = '".$_POST['payment_overdue_id']."'");
		
			header("location:../system/page_home.php?alimms=payment-overdue");	
		break;
	
		case "delete-payment-overdue":
			mysql_query("UPDATE payment_overdue SET payment_overdue_datetime = '".$waktu_sekarang."', payment_overdue_active = '0', user_id = '".$_SESSION['user_id']."' WHERE payment_overdue_id = '".$_GET['payment_overdue_id']."'");
			
			header("location:../system/page_home.php?alimms=payment-overdue");	
		break;
		
		case "active-payment-overdue":
			mysql_query("UPDATE payment_overdue SET payment_overdue_datetime = '".$waktu_sekarang."', payment_overdue_active = '1', user_id = '".$_SESSION['user_id']."' WHERE payment_overdue_id = '".$_GET['payment_overdue_id']."'");
			
			header("location:../system/page_home.php?alimms=payment-overdue");	
		break;
	}
?>