<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_billing_visit();
		break;
	
		case "form-question-billing-visit":
			mysql_query("UPDATE billing_visit SET billing_visit_time_in = '".$waktu."' WHERE billing_visit_id = '".$_GET['billing_visit_id']."'");
			
			form_question_billing_visit();
		break;
	
		case "question-billing-visit":
			if ($_POST['billing_visit_status'] == 'Paid')
			{
				mysql_query("UPDATE billing_visit SET billing_visit_time_out = '".$waktu."', billing_visit_description = 'Pelanggan Membayar', billing_visit_status = '".$_POST['billing_visit_status']."', billing_visit_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE billing_visit_id = '".$_POST['billing_visit_id']."'");
				
				header("location:../system/home.php?alimms=billing-visit&tib=form-payment-billing-visit&billing_visit_id=".$_POST['billing_visit_id']);	
			}
			else
			{
				mysql_query("UPDATE billing_visit SET billing_visit_time_out = '".$waktu."', billing_visit_description = '".$_POST['billing_visit_description']."', billing_visit_status = '".$_POST['billing_visit_status']."', billing_visit_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE billing_visit_id = '".$_POST['billing_visit_id']."'");
				
				header("location:../system/home.php?alimms=billing-visit");	
			}
		break;
		
		case "form-payment-billing-visit":
			form_payment_billing_visit();
		break;
		
		case "payment-billing-visit":
			$billing_visit_detail_id = idbaru("billing_visit_detail","billing_visit_detail_id");
			
			$billingvisitdetaildueDate = explode("-", $_POST['billing_visit_detail_due_date']);
			$DatebillingvisitdetaildueDate = $billingvisitdetaildueDate[0];
			$MonthbillingvisitdetaildueDate = $billingvisitdetaildueDate[1];
			$YearbillingvisitdetaildueDate = $billingvisitdetaildueDate[2];
			$billing_visit_detail_due_date = date("Y-m-d", mktime(0, 0, 0, $MonthbillingvisitdetaildueDate, $DatebillingvisitdetaildueDate, $YearbillingvisitdetaildueDate));
			
			$tbl_customer = mysql_query("SELECT c.customer_code FROM billing_visit a, billing_work_plan_detail b, customer c WHERE a.billing_visit_id = '".$_POST['billing_visit_id']."' AND a.billing_work_plan_detail_id = b.billing_work_plan_detail_id AND b.customer_id = c.customer_id");
			$data_tbl_customer = mysql_fetch_array($tbl_customer);
			
			$tmp_file = $_FILES['billing_visit_detail_photo']['tmp_name'];
			$filename = $_FILES['billing_visit_detail_photo']['name'];
			$destination = '../../alimms/img-billing/';
			$random = rand(1, 10);
			$filename = $data_tbl_customer['customer_code'].'-'.$tgl_sekarang_indo.'-'.$random.'.jpg';
			$upload = $destination . $filename;
			
			if (!empty($tmp_file))
			{
				move_uploaded_file($tmp_file, $upload);
				
				mysql_query("INSERT INTO billing_visit_detail(billing_visit_detail_id, billing_visit_id, payment_type_id, billing_visit_detail_total_price, billing_visit_detail_description, billing_visit_detail_due_date, billing_visit_detail_photo) VALUES('".$billing_visit_detail_id."', '".$_POST['billing_visit_id']."', '".$_POST['payment_type_id']."', '".$_POST['billing_visit_detail_total_price']."', '".$_POST['billing_visit_detail_description']."', '".$billing_visit_detail_due_date."', '".$filename."')");	
			}
			else
			{
				mysql_query("INSERT INTO billing_visit_detail(billing_visit_detail_id, billing_visit_id, payment_type_id, billing_visit_detail_total_price, billing_visit_detail_description, billing_visit_detail_due_date) VALUES('".$billing_visit_detail_id."', '".$_POST['billing_visit_id']."', '".$_POST['payment_type_id']."', '".$_POST['billing_visit_detail_total_price']."', '".$_POST['billing_visit_detail_description']."', '".$billing_visit_detail_due_date."')");
			}
			
			header("location:../system/home.php?alimms=billing-visit");
		break;
	
		case "form-view-billing-visit":
			form_view_billing_visit();
		break;
	}
?>