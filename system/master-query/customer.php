<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_customer();
		break;
		
		case "form-add-customer":
			form_add_customer();
		break;
	
		case "add-customer":
			$customer_id = idbaru("customer","customer_id");
			
			mysql_query("INSERT INTO customer(customer_id, customer_category_id, customer_class_id, customer_code, customer_name, customer_address, customer_districts_id, customer_contact, customer_phone, product_sell_price_id, customer_product_sell_program_promo,customer_galon_category_id,selling_program_galon_id, customer_datetime,customer_active, user_id) VALUES ('".$customer_id."', '".$_POST['customer_category_id']."', '".$_POST['customer_class_id']."', '".$_POST['customer_code']."', '".$_POST['customer_name']."', '".$_POST['customer_address']."', '".$_POST['customer_districts_id']."', '".$_POST['customer_contact']."', '".$_POST['customer_phone']."', '".$_POST['product_sell_price_id']."', '".$_POST['customer_product_sell_program_promo']."', '".$_POST['customer_galon_category_id']."','".$_POST['selling_program_galon_id']."', '".$waktu_sekarang."',1, '".$_SESSION['user_id']."')");
	
			header("location:../system/page_home.php?alimms=customer");	
		break;
	
		case "form-edit-customer":
			form_edit_customer();
		break;
		
		case "edit-customer":
			
			mysql_query("UPDATE `customer` SET `selling_program_galon_id`= '".$_POST['selling_program_galon_id']."' WHERE customer_id = '".$_POST['customer_id']."'");
			
			mysql_query("UPDATE customer SET customer_category_id = '".$_POST['customer_category_id']."', customer_class_id = '".$_POST['customer_class_id']."', customer_code = '".$_POST['customer_code']."', customer_name = '".$_POST['customer_name']."', customer_address = '".$_POST['customer_address']."', customer_districts_id = '".$_POST['customer_districts_id']."', customer_contact = '".$_POST['customer_contact']."', customer_phone = '".$_POST['customer_phone']."', product_sell_price_id = '".$_POST['product_sell_price_id']."', customer_product_sell_program_promo = '".$_POST['customer_product_sell_program_promo']."', customer_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."', customer_galon_category_id = '".$_POST['customer_galon_category_id']."' WHERE customer_id = '".$_POST['customer_id']."'");
		
			header("location:../system/page_home.php?alimms=customer");	
		break;
	
		case "delete-customer":
			mysql_query("UPDATE customer SET customer_datetime = '".$waktu_sekarang."', customer_active = '0', user_id = '".$_SESSION['user_id']."' WHERE customer_id = '".$_GET['customer_id']."'");
			
			header("location:../system/page_home.php?alimms=customer");	
		break;
		
		case "active-customer":
			mysql_query("UPDATE customer SET customer_datetime = '".$waktu_sekarang."', customer_active = '1', user_id = '".$_SESSION['user_id']."' WHERE customer_id = '".$_GET['customer_id']."'");
			
			header("location:../system/page_home.php?alimms=customer");	
		break;
	}
?>