<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_customer_districts();
		break;
		
		case "form-add-customer-districts":
			form_add_customer_districts();
		break;
	
		case "add-customer-districts":
			$customer_districts_id = idbaru("customer_districts","customer_districts_id");
			
			mysql_query("INSERT INTO customer_districts(customer_districts_id, customer_districts_name, customer_city_id, customer_area_id, customer_districts_datetime, user_id) VALUES ('".$customer_districts_id."', '".$_POST['customer_districts_name']."', '".$_POST['customer_city_id']."', '".$_POST['customer_area_id']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
	
			header("location:../system/page_home.php?alimms=customer-districts");	
		break;
	
		case "form-edit-customer-districts":
			form_edit_customer_districts();
		break;
		
		case "edit-customer-districts":
			mysql_query("UPDATE customer_districts SET customer_districts_name = '".$_POST['customer_districts_name']."', customer_city_id = '".$_POST['customer_city_id']."', customer_area_id = '".$_POST['customer_area_id']."', customer_districts_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE customer_districts_id = '".$_POST['customer_districts_id']."'");
		
			header("location:../system/page_home.php?alimms=customer-districts");	
		break;
	
		case "delete-customer-districts":
			mysql_query("UPDATE customer_districts SET customer_districts_datetime = '".$waktu_sekarang."', customer_districts_active = '0', user_id = '".$_SESSION['user_id']."' WHERE customer_districts_id = '".$_GET['customer_districts_id']."'");
			
			header("location:../system/page_home.php?alimms=customer-districts");	
		break;
		
		case "active-customer-districts":
			mysql_query("UPDATE customer_districts SET customer_districts_datetime = '".$waktu_sekarang."', customer_districts_active = '1', user_id = '".$_SESSION['user_id']."' WHERE customer_districts_id = '".$_GET['customer_districts_id']."'");
			
			header("location:../system/page_home.php?alimms=customer-districts");	
		break;
	}
?>