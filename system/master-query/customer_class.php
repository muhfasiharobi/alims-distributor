<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_customer_class();
		break;
		
		case "form-add-customer-class":
			form_add_customer_class();
		break;
	
		case "add-customer-class":
			$customer_class_id = idbaru("customer_class","customer_class_id");
			
			mysql_query("INSERT INTO customer_class(customer_class_id, customer_class_name, customer_class_purchase_price_limit, customer_class_datetime, user_id) VALUES ('".$customer_class_id."', '".$_POST['customer_class_name']."', '".$_POST['customer_class_purchase_price_limit']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
	
			header("location:../system/page_home.php?alimms=customer-class");	
		break;
	
		case "form-edit-customer-class":
			form_edit_customer_class();
		break;
		
		case "edit-customer-class":
			mysql_query("UPDATE customer_class SET customer_class_name = '".$_POST['customer_class_name']."', customer_class_purchase_price_limit = '".$_POST['customer_class_purchase_price_limit']."', customer_class_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE customer_class_id = '".$_POST['customer_class_id']."'");
		
			header("location:../system/page_home.php?alimms=customer-class");	
		break;
	
		case "delete-customer-class":
			mysql_query("UPDATE customer_class SET customer_class_datetime = '".$waktu_sekarang."', customer_class_active = '0', user_id = '".$_SESSION['user_id']."' WHERE customer_class_id = '".$_GET['customer_class_id']."'");
			
			header("location:../system/page_home.php?alimms=customer-class");	
		break;
		
		case "active-customer-class":
			mysql_query("UPDATE customer_class SET customer_class_datetime = '".$waktu_sekarang."', customer_class_active = '1', user_id = '".$_SESSION['user_id']."' WHERE customer_class_id = '".$_GET['customer_class_id']."'");
			
			header("location:../system/page_home.php?alimms=customer-class");
		break;
	}
?>