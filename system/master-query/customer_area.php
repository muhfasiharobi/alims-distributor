<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_customer_area();
		break;
		
		case "form-add-customer-area":
			form_add_customer_area();
		break;
	
		case "add-customer-area":
			$customer_area_id = idbaru("customer_area","customer_area_id");
			
			mysql_query("INSERT INTO customer_area(customer_area_id, customer_area_name, customer_area_datetime, user_id) VALUES ('".$customer_area_id."', '".$_POST['customer_area_name']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
	
			header("location:../system/page_home.php?alimms=customer-area");	
		break;
	
		case "form-edit-customer-area":
			form_edit_customer_area();
		break;
		
		case "edit-customer-area":
			mysql_query("UPDATE customer_area SET customer_area_name = '".$_POST['customer_area_name']."', customer_area_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE customer_area_id = '".$_POST['customer_area_id']."'");
		
			header("location:../system/page_home.php?alimms=customer-area");	
		break;
	
		case "delete-customer-area":
			mysql_query("UPDATE customer_area SET customer_area_datetime = '".$waktu_sekarang."', customer_area_active = '0', user_id = '".$_SESSION['user_id']."' WHERE customer_area_id = '".$_GET['customer_area_id']."'");
			
			header("location:../system/page_home.php?alimms=customer-area");	
		break;
	
		case "active-customer-area":
			mysql_query("UPDATE customer_area SET customer_area_datetime = '".$waktu_sekarang."', customer_area_active = '1', user_id = '".$_SESSION['user_id']."' WHERE customer_area_id = '".$_GET['customer_area_id']."'");
			
			header("location:../system/page_home.php?alimms=customer-area");	
		break;
	}
?>