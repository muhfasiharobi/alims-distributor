<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_sales_plan();
		break;
		
		case "form-add-sales-plan":
			form_add_sales_plan();
		break;
		
		case "form-add-sales-plan-schedule":
			form_add_sales_plan_schedule();
		break;
	
		case "add-sales-plan":
			$sales_plan_id = idbaru("sales_plan","sales_plan_id");
			
			$sales_plan_date = explode("-", $_POST['sales_plan_date']);
			$date_sales_plan = $sales_plan_date[0];
			$month_sales_plan = $sales_plan_date[1];
			$year_sales_plan = $sales_plan_date[2];
			$sales_plan_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_plan, $date_sales_plan, $year_sales_plan));
			
			mysql_query("INSERT INTO sales_plan(sales_plan_id, salesman_id, sales_plan_date, sales_plan_datetime, user_id) VALUES ('".$sales_plan_id."', '".$_POST['salesman_id']."', '".$sales_plan_date."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
			
			header("location:../system/page_home.php?alimms=sales-plan&tib=form-add-sales-plan-schedule&sales_plan_id=".$sales_plan_id);
		break;
		
		case "form-customer-sales-plan":
			form_customer_sales_plan();
		break;
		
		case "form-sales-plan-schedule-entry":
			form_sales_plan_schedule_entry();
		break;
		
		case "add-sales-plan-schedule":
			$tbl_sales_schedule = mysql_query("SELECT * FROM sales_schedule_detail WHERE sales_schedule_id = '".$_POST['sales_schedule_id']."' order by sales_schedule_no");
			
			while($data_tbl_sales_schedule = mysql_fetch_array($tbl_sales_schedule)){
				
				$sales_plan_detail_id = idbaru("sales_plan_detail","sales_plan_detail_id");
				$sales_visit_id = idbaru("sales_visit","sales_visit_id");
				
				mysql_query("INSERT INTO sales_plan_detail(sales_plan_detail_id, sales_plan_id, customer_id) VALUES ('".$sales_plan_detail_id."', '".$_POST['sales_plan_id']."', '".$data_tbl_sales_schedule['customer_id']."')");

                                mysql_query("INSERT INTO `sales_visit`(`sales_visit_id`, `sales_plan_detail_id`, `sales_visit_time_in`, `sales_visit_time_out`, `sales_visit_status`, `sales_visit_description`, `sales_visit_datetime`, `user_id`) VALUES ('".$sales_visit_id."', '".$sales_plan_detail_id."','','','Call','','".$waktu_sekarang."','".$_SESSION['user_id']."')");
			
			}
			
			header("location:../system/page_home.php?alimms=sales-plan");	
		break;
		
		case "customer-sales-plan":
			$sales_plan_detail_id = idbaru("sales_plan_detail","sales_plan_detail_id");
			$sales_visit_id = idbaru("sales_visit","sales_visit_id");
			
			mysql_query("INSERT INTO sales_plan_detail(sales_plan_detail_id, sales_plan_id, customer_id) VALUES ('".$sales_plan_detail_id."', '".$_POST['sales_plan_id']."', '".$_POST['customer_id']."')");

                        mysql_query("INSERT INTO `sales_visit`(`sales_visit_id`, `sales_plan_detail_id`, `sales_visit_time_in`, `sales_visit_time_out`, `sales_visit_status`, `sales_visit_description`, `sales_visit_datetime`, `user_id`) VALUES ('".$sales_visit_id."', '".$sales_plan_detail_id."','','','Call','','".$waktu_sekarang."','".$_SESSION['user_id']."')");
			
			header("location:../system/page_home.php?alimms=sales-plan&tib=form-customer-sales-plan&sales_plan_id=".$_POST['sales_plan_id']);	
		break;
		
		case "remove-sales-plan":
			$tbl_sales_plan_detail = mysql_query("SELECT sales_plan_id FROM sales_plan_detail WHERE sales_plan_detail_id = '".$_GET['sales_plan_detail_id']."'");
			$data_tbl_sales_plan_detail = mysql_fetch_array($tbl_sales_plan_detail);
										
			mysql_query("DELETE FROM sales_plan_detail WHERE sales_plan_detail_id = '".$_GET['sales_plan_detail_id']."'");
			
			mysql_query("DELETE FROM sales_visit WHERE sales_plan_detail_id = '".$_GET['sales_plan_detail_id']."'");
			
			header("location:../system/page_home.php?alimms=sales-plan&tib=form-customer-sales-plan&sales_plan_id=".$data_tbl_sales_plan_detail['sales_plan_id']);	
		break;
		
		case "sales-plan-canceled":
										
			mysql_query("DELETE FROM sales_plan WHERE sales_plan_id = '".$_GET['sales_plan_id']."'");
			
			header("location:../system/page_home.php?alimms=sales-plan");	
		break;
		
		case "form-edit-sales-plan":
			form_edit_sales_plan();
		break;
		
		case "edit-sales-plan":
			$sales_plan_date = explode("-", $_POST['sales_plan_date']);
			$date_sales_plan = $sales_plan_date[0];
			$month_sales_plan = $sales_plan_date[1];
			$year_sales_plan = $sales_plan_date[2];
			$sales_plan_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_plan, $date_sales_plan, $year_sales_plan));
			
			mysql_query("UPDATE sales_plan SET salesman_id = '".$_POST['salesman_id']."', sales_plan_date = '".$sales_plan_date."', sales_plan_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE sales_plan_id = '".$_POST['sales_plan_id']."'");
			
			header("location:../system/page_home.php?alimms=sales-plan&tib=form-customer-sales-plan&sales_plan_id=".$_POST['sales_plan_id']);	
		break;
	
		case "delete-sales-plan":
			mysql_query("UPDATE sales_plan SET sales_plan_datetime = '".$waktu_sekarang."', sales_plan_active = '0', user_id = '".$_SESSION['user_id']."' WHERE sales_plan_id = '".$_GET['sales_plan_id']."'");
			
			header("location:../system/page_home.php?alimms=sales-plan");	
		break;
		
		case "form-view-sales-plan":
			form_view_sales_plan();
		break;
	}
?>