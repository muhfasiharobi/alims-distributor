<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_billing_dashboard();
		break;
		
		case "form-add-billingman-visit-dashboard":
			mysql_query("UPDATE `billing_visit` SET `billing_visit_time_in`= '".$waktu."' WHERE billing_visit_id = '".$_GET['billing_visit_id']."'");
			form_add_billingman_visit_dashboard();
		break;
		
		case "add-billingman-visit-payment":
			
			mysql_query("UPDATE `billing_visit` SET `billing_visit_time_out`= '".$waktu."',`billing_visit_status`='".$_POST['payment_order_detail_payment_status']."',`billing_visit_description`='".$_POST['payment_order_detail_payment_description']."',`billing_visit_datetime`= '".$waktu_sekarang."',`user_id`= '".$_SESSION['user_id']."' WHERE billing_visit_id = '".$_POST['billing_visit_id']."'");
			
			$billing_visit_detail_id = idbaru("billing_visit_detail","billing_visit_detail_id");
			
			mysql_query("INSERT INTO `billing_visit_detail`(`billing_visit_detail_id`, `billing_visit_id`, `billing_visit_detail_nominal`, `billing_visit_detail_description`) VALUES ('".$billing_visit_detail_id."','".$_POST['billing_visit_id']."','".$_POST['billing_visit_detail_payment_nominal']."','".$_POST['payment_order_detail_payment_description']."')");
		
		header("location:../system/page_home.php?alimms=dashboard");	
		
		case "form-view-billingman-visit-dashboard":
			form_view_billingman_visit_dashboard();
		break;
		
		break;
		
	}
?>