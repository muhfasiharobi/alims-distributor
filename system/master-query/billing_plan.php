<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_billing_plan();
		break;
		
		case "form-add-billing-plan":
			form_add_billing_plan();
		break;
	
		case "add-billing-plan":
			$billing_plan_id = idbaru("billing_plan","billing_plan_id");
			
			$billing_plan_date = explode("-", $_POST['billing_plan_date']);
			$date_billing_plan = $billing_plan_date[0];
			$month_billing_plan = $billing_plan_date[1];
			$year_billing_plan = $billing_plan_date[2];
			$billing_plan_date = date("Y-m-d", mktime(0, 0, 0, $month_billing_plan, $date_billing_plan, $year_billing_plan));
			
			mysql_query("INSERT INTO billing_plan(billing_plan_id, salesman_id, billing_plan_date, billing_plan_datetime,billing_plan_active, user_id) VALUES ('".$billing_plan_id."', '".$_POST['salesman_id']."', '".$billing_plan_date."', '".$waktu_sekarang."', '1', '".$_SESSION['user_id']."')");
			
			header("location:../system/page_home.php?alimms=billing-plan&tib=form-invoice-billing-plan&billing_plan_id=".$billing_plan_id);
		break;
		
		case "form-invoice-billing-plan":
			form_invoice_billing_plan();
		break;
		
		case "invoice-billing-plan":
			$billing_plan_detail_id = idbaru("billing_plan_detail","billing_plan_detail_id");
			$billing_visit_id = idbaru("billing_visit","billing_visit_id");
			
			mysql_query("INSERT INTO billing_plan_detail(billing_plan_detail_id, billing_plan_id, sales_invoice_id) VALUES ('".$billing_plan_detail_id."', '".$_POST['billing_plan_id']."', '".$_POST['sales_invoice_id']."')");
			
			//mysql_query("INSERT INTO billing_visit(billing_visit_id, billing_plan_detail_id) VALUES ('".$billing_visit_id."', '".$billing_plan_detail_id."')");

                        mysql_query("INSERT INTO `billing_visit`(`billing_visit_id`, `billing_plan_detail_id`, `billing_visit_time_in`, `billing_visit_time_out`, `billing_visit_status`, `billing_visit_description`, `billing_visit_datetime`, `user_id`) VALUES ('".$billing_visit_id."','".$billing_plan_detail_id."','00:00:00','00:00:00','Call','','0000-00-00 00:00:00','".$_SESSION['user_id']."')");
			
			header("location:../system/page_home.php?alimms=billing-plan&tib=form-invoice-billing-plan&billing_plan_id=".$_POST['billing_plan_id']);	
		break;
		
		case "remove-billing-plan":
			$tbl_billing_plan_detail = mysql_query("SELECT billing_plan_id FROM billing_plan_detail WHERE billing_plan_detail_id = '".$_GET['billing_plan_detail_id']."'");
			$data_tbl_billing_plan_detail = mysql_fetch_array($tbl_billing_plan_detail);
										
			mysql_query("DELETE FROM billing_plan_detail WHERE billing_plan_detail_id = '".$_GET['billing_plan_detail_id']."'");
			
			mysql_query("DELETE FROM billing_visit WHERE billing_plan_detail_id = '".$_GET['billing_plan_detail_id']."'");
			
			header("location:../system/page_home.php?alimms=billing-plan&tib=form-invoice-billing-plan&billing_plan_id=".$data_tbl_billing_plan_detail['billing_plan_id']);	
		break;
		
		case "form-edit-billing-plan":
			form_edit_billing_plan();
		break;
		
		case "edit-billing-plan":
			$billing_plan_date = explode("-", $_POST['billing_plan_date']);
			$date_billing_plan = $billing_plan_date[0];
			$month_billing_plan = $billing_plan_date[1];
			$year_billing_plan = $billing_plan_date[2];
			$billing_plan_date = date("Y-m-d", mktime(0, 0, 0, $month_billing_plan, $date_billing_plan, $year_billing_plan));
			
			mysql_query("UPDATE billing_plan SET salesman_id = '".$_POST['salesman_id']."', billing_plan_date = '".$billing_plan_date."', billing_plan_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE billing_plan_id = '".$_POST['billing_plan_id']."'");
			
			header("location:../system/page_home.php?alimms=billing-plan&tib=form-invoice-billing-plan&billing_plan_id=".$_POST['billing_plan_id']);	
		break;
	
		case "delete-billing-plan":
			mysql_query("UPDATE billing_plan SET billing_plan_datetime = '".$waktu_sekarang."', billing_plan_active = '0', user_id = '".$_SESSION['user_id']."' WHERE billing_plan_id = '".$_GET['billing_plan_id']."'");
			
			header("location:../system/page_home.php?alimms=billing-plan");	
		break;
			
		case "form-view-billing-plan":
			form_view_billing_plan();
		break;
	}
?>