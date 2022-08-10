<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_payment_request();
		break;
		
		case "form-add-payment-request":
			form_add_payment_request();
		break;
	
		case "add-payment-request":
			$payment_request_detail_id = idbaru("payment_request_detail","payment_request_detail_id");
			
			
			$payment_request_detail_payment_date = explode("-", $_POST['payment_request_detail_payment_date']);
			$date_payment_request_detail_payment = $payment_request_detail_payment_date[0];
			$month_payment_request_detail_payment = $payment_request_detail_payment_date[1];
			$year_payment_request_detail_payment = $payment_request_detail_payment_date[2];
			$payment_request_detail_payment_date = date("Y-m-d", mktime(0, 0, 0, $month_payment_request_detail_payment, $date_payment_request_detail_payment, $year_payment_request_detail_payment));
			
			$tbl_payment_request = mysql_query("SELECT payment_request_id, sales_invoice_id FROM payment_request WHERE sales_invoice_id = '".$_POST['sales_invoice_id']."'");
			$data_tbl_payment_request = mysql_fetch_array($tbl_payment_request);
			
			if($data_tbl_payment_request['payment_request_id'] == ""){
				
				$payment_request_id = idbaru("payment_request","payment_request_id");
				
				mysql_query("INSERT INTO `payment_request`(`payment_request_id`, `sales_invoice_id`, `payment_request_status`, `payment_request_datetime`, `user_id`) VALUES ('".$payment_request_id."','".$_POST['sales_invoice_id']."','Call','".$waktu_sekarang."','".$_SESSION['user_id']."')");
				
				mysql_query("INSERT INTO `payment_request_detail`(`payment_request_detail_id`, `payment_request_id`, `payment_category_id`, `payment_request_detail_payment_date`, `payment_request_detail_account_no`, `payment_request_detail_bank_name`, `payment_request_detail_account_name`, `payment_request_detail_payment_nominal`, `payment_request_detail_payment_description`, `payment_request_detail_payment_datetime`, `user_id`) VALUES ('".$payment_request_detail_id."', '".$payment_request_id."', '".$_POST['payment_category_id']."', '".$payment_request_detail_payment_date."','','','','0','','".$waktu_sekarang."','".$_SESSION['user_id']."')");
			}
			else
			{
				
				mysql_query("INSERT INTO `payment_request_detail`(`payment_request_detail_id`, `payment_request_id`, `payment_category_id`, `payment_request_detail_payment_date`, `payment_request_detail_account_no`, `payment_request_detail_bank_name`, `payment_request_detail_account_name`, `payment_request_detail_payment_nominal`, `payment_request_detail_payment_description`, `payment_request_detail_payment_datetime`, `user_id`) VALUES ('".$payment_request_detail_id."', '".$data_tbl_payment_request['payment_request_id']."', '".$_POST['payment_category_id']."', '".$payment_order_detail_payment_date."','','','','0','','".$waktu_sekarang."','".$_SESSION['user_id']."')");
				
			}
			
			
			
			header("location:../system/page_home.php?alimms=payment-request&tib=form-paid-payment-request&payment_request_detail_id=".$payment_request_detail_id);
		break;
		
		case "form-paid-payment-request":
			form_paid_payment_request();
		break;
	
		case "paid-payment-request":
		
			$tbl_payment_request = mysql_query("SELECT payment_request_id FROM payment_request_detail WHERE payment_request_detail_id = '".$_POST['payment_request_detail_id']."'");
			$data_tbl_payment_request = mysql_fetch_array($tbl_payment_request);
			
			mysql_query("UPDATE `payment_request_detail` SET `payment_request_detail_account_no`= '".$_POST['payment_request_detail_account_no']."',`payment_request_detail_bank_name`= '".$_POST['payment_request_detail_bank_name']."',`payment_request_detail_account_name`= '".$_POST['payment_request_detail_account_name']."',`payment_request_detail_payment_nominal`= '".$_POST['payment_request_detail_payment_nominal']."',`payment_request_detail_payment_description`= '".$_POST['payment_request_detail_payment_description']."',`payment_request_detail_payment_datetime`= '".$waktu_sekarang."',`user_id`= '".$_SESSION['user_id']."' WHERE payment_request_detail_id = '".$_POST['payment_request_detail_id']."'");
	
			mysql_query("UPDATE payment_request SET payment_request_status = '".$_POST['payment_order_detail_payment_status']."', payment_request_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE payment_request_id = '".$data_tbl_payment_request['payment_request_id']."'");
			
			header("location:../system/page_home.php?alimms=payment-request");
		break;
	
		case "remove-payment-request":
			mysql_query("DELETE FROM payment_order_detail WHERE payment_order_detail_id = '".$_GET['payment_order_detail_id']."'");
			
			header("location:../system/page_home.php?alimms=payment-order");	
		break;
	
		case "form-view-payment-request":
			form_view_payment_request();
		break;
	}
?>