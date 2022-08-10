<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_customer_category();
		break;
		
		case "form-add-customer-category":
			form_add_customer_category();
		break;
	
		case "add-customer-category":
			$customer_category_id = idbaru("customer_category","customer_category_id");
			
			mysql_query("INSERT INTO customer_category(customer_category_id, customer_category_name, customer_category_datetime, user_id) VALUES ('".$customer_category_id."', '".$_POST['customer_category_name']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
	
			header("location:../system/page_home.php?alimms=customer-category");	
		break;
	
		case "form-edit-customer-category":
			form_edit_customer_category();
		break;
		
		case "edit-customer-category":
			mysql_query("UPDATE customer_category SET customer_category_name = '".$_POST['customer_category_name']."', customer_category_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE customer_category_id = '".$_POST['customer_category_id']."'");
		
			header("location:../system/page_home.php?alimms=customer-category");	
		break;
	
		case "delete-customer-category":
			mysql_query("UPDATE customer_category SET customer_category_datetime = '".$waktu_sekarang."', customer_category_active = '0', user_id = '".$_SESSION['user_id']."' WHERE customer_category_id = '".$_GET['customer_category_id']."'");
			
			header("location:../system/page_home.php?alimms=customer-category");	
		break;
		
		case "active-customer-category":
			mysql_query("UPDATE customer_category SET customer_category_datetime = '".$waktu_sekarang."', customer_category_active = '1', user_id = '".$_SESSION['user_id']."' WHERE customer_category_id = '".$_GET['customer_category_id']."'");
			
			header("location:../system/page_home.php?alimms=customer-category");	
		break;
	}
?>