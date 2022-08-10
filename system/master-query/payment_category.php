<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_payment_category();
		break;
		
		case "form-add-payment-category":
			form_add_payment_category();
		break;
	
		case "add-payment-category":
			$payment_category_id = idbaru("payment_category","payment_category_id");
			
			mysql_query("INSERT INTO payment_category(payment_category_id, payment_category_name, payment_category_datetime, user_id) VALUES ('".$payment_category_id."', '".$_POST['payment_category_name']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
	
			header("location:../system/page_home.php?alimms=payment-category");	
		break;
	
		case "form-edit-payment-category":
			form_edit_payment_category();
		break;
		
		case "edit-payment-category":
			mysql_query("UPDATE payment_category SET payment_category_name = '".$_POST['payment_category_name']."', payment_category_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE payment_category_id = '".$_POST['payment_category_id']."'");
		
			header("location:../system/page_home.php?alimms=payment-category");	
		break;
	
		case "delete-payment-category":
			mysql_query("UPDATE payment_category SET payment_category_datetime = '".$waktu_sekarang."', payment_category_active = '0', user_id = '".$_SESSION['user_id']."' WHERE payment_category_id = '".$_GET['payment_category_id']."'");
			
			header("location:../system/page_home.php?alimms=payment-category");	
		break;
		
		case "active-payment-category":
			mysql_query("UPDATE payment_category SET payment_category_datetime = '".$waktu_sekarang."', payment_category_active = '1', user_id = '".$_SESSION['user_id']."' WHERE payment_category_id = '".$_GET['payment_category_id']."'");
			
			header("location:../system/page_home.php?alimms=payment-category");	
		break;
	}
?>