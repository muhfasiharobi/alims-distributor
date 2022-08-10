<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_payment_order();
		break;
		
		case "form-add-payment-order":
			form_add_payment_order();
		break;
	
		case "add-payment-order":
			$payment_order_detail_id = idbaru("payment_order_detail","payment_order_detail_id");
			
			$payment_order_detail_payment_date = explode("-", $_POST['payment_order_detail_payment_date']);
			$date_payment_order_detail_payment = $payment_order_detail_payment_date[0];
			$month_payment_order_detail_payment = $payment_order_detail_payment_date[1];
			$year_payment_order_detail_payment = $payment_order_detail_payment_date[2];
			$payment_order_detail_payment_date = date("Y-m-d", mktime(0, 0, 0, $month_payment_order_detail_payment, $date_payment_order_detail_payment, $year_payment_order_detail_payment));
			
			//mysql_query("INSERT INTO payment_order_detail(payment_order_detail_id, payment_order_id, payment_category_id, payment_order_detail_payment_date, payment_order_detail_payment_datetime, user_id) VALUES ('".$payment_order_detail_id."', '".$_POST['payment_order_id']."', '".$_POST['payment_category_id']."', '".$payment_order_detail_payment_date."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");

mysql_query("INSERT INTO `payment_order_detail`(`payment_order_detail_id`, `payment_order_id`, `payment_category_id`, `payment_order_detail_payment_date`, `payment_order_detail_account_no`, `payment_order_detail_bank_name`, `payment_order_detail_account_name`, `payment_order_detail_payment_nominal`, `payment_order_detail_payment_due_date`, `payment_order_detail_payment_status`, `payment_order_detail_payment_description`, `payment_order_detail_payment_datetime`, `user_id`) VALUES ('".$payment_order_detail_id."', '".$_POST['payment_order_id']."', '".$_POST['payment_category_id']."', '".$payment_order_detail_payment_date."','','','','0','0000-00-00','On Hold','','0000-00-00 00:00:00','0')");
			
			header("location:../system/page_home.php?alimms=payment-order&tib=form-paid-payment-order&payment_order_detail_id=".$payment_order_detail_id);
		break;
		
		case "form-paid-payment-order":
			form_paid_payment_order();
		break;
	
		case "paid-payment-order":
			$payment_order_detail_payment_due_date = explode("-", $_POST['payment_order_detail_payment_due_date']);
			$date_payment_order_detail_payment_due = $payment_order_detail_payment_due_date[0];
			$month_payment_order_detail_payment_due = $payment_order_detail_payment_due_date[1];
			$year_payment_order_detail_payment_due = $payment_order_detail_payment_due_date[2];
			$payment_order_detail_payment_date_due = date("Y-m-d", mktime(0, 0, 0, $month_payment_order_detail_payment_due, $date_payment_order_detail_payment_due, $year_payment_order_detail_payment_due));
			
			if ($_POST['payment_order_detail_payment_status'] == "Unpaid")
			{
				if ($_POST['payment_order_detail_payment_due_date'] != "")
				{
					mysql_query("UPDATE payment_order_detail SET payment_order_detail_account_no = '".$_POST['payment_order_detail_account_no']."', payment_order_detail_bank_name = '".$_POST['payment_order_detail_bank_name']."', payment_order_detail_account_name = '".$_POST['payment_order_detail_account_name']."', payment_order_detail_payment_nominal = '".$_POST['payment_order_detail_payment_nominal']."', payment_order_detail_payment_due_date = '".$payment_order_detail_payment_date_due."', payment_order_detail_payment_status = '".$_POST['payment_order_detail_payment_status']."', payment_order_detail_payment_description = '".$_POST['payment_order_detail_payment_description']."', payment_order_detail_payment_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE payment_order_detail_id = '".$_POST['payment_order_detail_id']."'");
				}
				else
				{
					mysql_query("UPDATE payment_order_detail SET payment_order_detail_account_no = '".$_POST['payment_order_detail_account_no']."', payment_order_detail_bank_name = '".$_POST['payment_order_detail_bank_name']."', payment_order_detail_account_name = '".$_POST['payment_order_detail_account_name']."', payment_order_detail_payment_nominal = '".$_POST['payment_order_detail_payment_nominal']."', payment_order_detail_payment_status = '".$_POST['payment_order_detail_payment_status']."', payment_order_detail_payment_description = '".$_POST['payment_order_detail_payment_description']."', payment_order_detail_payment_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE payment_order_detail_id = '".$_POST['payment_order_detail_id']."'");
				}
				
				$tbl_payment_order_detail = mysql_query("SELECT payment_order_id FROM payment_order_detail WHERE payment_order_detail_id = '".$_POST['payment_order_detail_id']."'");
				$data_tbl_payment_order_detail = mysql_fetch_array($tbl_payment_order_detail);
				
				mysql_query("UPDATE payment_order SET payment_order_status = '".$_POST['payment_order_detail_payment_status']."', payment_order_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE payment_order_id = '".$data_tbl_payment_order_detail['payment_order_id']."'");
			}
			else
			{
				if ($_POST['payment_order_detail_payment_due_date'] != "")
				{
					mysql_query("UPDATE payment_order_detail SET payment_order_detail_account_no = '".$_POST['payment_order_detail_account_no']."', payment_order_detail_bank_name = '".$_POST['payment_order_detail_bank_name']."', payment_order_detail_account_name = '".$_POST['payment_order_detail_account_name']."', payment_order_detail_payment_nominal = '".$_POST['payment_order_detail_payment_nominal']."', payment_order_detail_payment_due_date = '".$payment_order_detail_payment_date_due."', payment_order_detail_payment_status = '".$_POST['payment_order_detail_payment_status']."', payment_order_detail_payment_description = 'Pembayaran Lunas', payment_order_detail_payment_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE payment_order_detail_id = '".$_POST['payment_order_detail_id']."'");
				}
				else
				{
					mysql_query("UPDATE payment_order_detail SET payment_order_detail_account_no = '".$_POST['payment_order_detail_account_no']."', payment_order_detail_bank_name = '".$_POST['payment_order_detail_bank_name']."', payment_order_detail_account_name = '".$_POST['payment_order_detail_account_name']."', payment_order_detail_payment_nominal = '".$_POST['payment_order_detail_payment_nominal']."', payment_order_detail_payment_status = '".$_POST['payment_order_detail_payment_status']."', payment_order_detail_payment_description = 'Pembayaran Lunas', payment_order_detail_payment_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE payment_order_detail_id = '".$_POST['payment_order_detail_id']."'");
				}
				
				$tbl_payment_order_detail = mysql_query("SELECT payment_order_id FROM payment_order_detail WHERE payment_order_detail_id = '".$_POST['payment_order_detail_id']."'");
				$data_tbl_payment_order_detail = mysql_fetch_array($tbl_payment_order_detail);
										
				mysql_query("UPDATE payment_order SET payment_order_status = '".$_POST['payment_order_detail_payment_status']."', payment_order_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE payment_order_id = '".$data_tbl_payment_order_detail['payment_order_id']."'");
			}
			
			header("location:../system/page_home.php?alimms=payment-order");
		break;
	
		case "remove-payment-order":
			mysql_query("DELETE FROM payment_order_detail WHERE payment_order_detail_id = '".$_GET['payment_order_detail_id']."'");
			
			header("location:../system/page_home.php?alimms=payment-order");	
		break;
	
		case "form-view-payment-order":
			form_view_payment_order();
		break;
	}
?>