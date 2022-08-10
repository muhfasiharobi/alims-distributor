<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_customer_city();
		break;
		
		case "form-add-customer-city":
			form_add_customer_city();
		break;
	
		case "add-customer-city":
			$customer_city_id = idbaru("customer_city","customer_city_id");
			
			mysql_query("INSERT INTO customer_city(customer_city_id, customer_city_name, customer_city_datetime, user_id) VALUES ('".$customer_city_id."', '".$_POST['customer_city_name']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
	
			header("location:../system/page_home.php?alimms=customer-city");	
		break;
	
		case "form-edit-customer-city":
			form_edit_customer_city();
		break;
		
		case "edit-customer-city":
			mysql_query("UPDATE customer_city SET customer_city_name = '".$_POST['customer_city_name']."', customer_city_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE customer_city_id = '".$_POST['customer_city_id']."'");
		
			header("location:../system/page_home.php?alimms=customer-city");	
		break;
	
		case "delete-customer-city":
			mysql_query("UPDATE customer_city SET customer_city_datetime = '".$waktu_sekarang."', customer_city_active = '0', user_id = '".$_SESSION['user_id']."' WHERE customer_city_id = '".$_GET['customer_city_id']."'");
			
			header("location:../system/page_home.php?alimms=customer-city");	
		break;
		
		case "active-customer-city":
			mysql_query("UPDATE customer_city SET customer_city_datetime = '".$waktu_sekarang."', customer_city_active = '1', user_id = '".$_SESSION['user_id']."' WHERE customer_city_id = '".$_GET['customer_city_id']."'");
			
			header("location:../system/page_home.php?alimms=customer-city");	
		break;
	}
?>