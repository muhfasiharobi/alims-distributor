<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_customer_request();
		break;
		
		case "form-approval-customer-request":
			form_approval_customer_request();
		break;
		
		case "approval-customer-request":
			$customer_id = idbaru("customer","customer_id");
			
			$tbl_customer_request = mysql_query("SELECT customer_request_id, customer_request_name, customer_request_address, customer_districts_id, customer_request_contact, customer_request_phone FROM customer_request WHERE customer_request_id = '".$_POST['customer_request_id']."'");
			$data_tbl_customer_request = mysql_fetch_array($tbl_customer_request);
			
			if ($_POST['customer_request_status'] == 'Approved')
			{
				mysql_query("UPDATE customer_request SET customer_request_status = '".$_POST['customer_request_status']."', customer_request_description = 'Permintaan Disetujui' WHERE customer_request_id = '".$_POST['customer_request_id']."'");
				
				mysql_query("INSERT INTO customer(customer_id, customer_name, customer_address, customer_districts_id, customer_contact, customer_phone) VALUES ('".$customer_id."', '".$data_tbl_customer_request['customer_request_name']."', '".$data_tbl_customer_request['customer_request_address']."', '".$data_tbl_customer_request['customer_districts_id']."', '".$data_tbl_customer_request['customer_request_contact']."', '".$data_tbl_customer_request['customer_request_phone']."')");
				
				header("location:../system/page_home.php?alimms=customer-request&tib=form-registration-customer-request&customer_id=".$customer_id);
			}
			else
			{
				mysql_query("UPDATE customer_request SET customer_request_status = '".$_POST['customer_request_status']."', customer_request_description = '".$_POST['customer_request_description']."' WHERE customer_request_id = '".$_POST['customer_request_id']."'");
				
				header("location:../system/page_home.php?alimms=customer-request");
			}	
		break;
		
		case "form-registration-customer-request":
			form_registration_customer_request();
		break;
		
		case "registration-customer-request":
			mysql_query("UPDATE customer SET customer_category_id = '".$_POST['customer_category_id']."', customer_class_id = '".$_POST['customer_class_id']."', customer_code = '".$_POST['customer_code']."', product_sell_price_id = '".$_POST['product_sell_price_id']."', customer_product_sell_program_promo = '".$_POST['customer_product_sell_program_promo']."', customer_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE customer_id = '".$_POST['customer_id']."'");
		
			header("location:../system/page_home.php?alimms=customer-request");	
		break;
	}
?>