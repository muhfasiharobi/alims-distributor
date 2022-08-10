<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_sales_schedule();
		break;
		
		case "form-add-sales-schedule-user":
			form_add_sales_schedule_user();
		break;
		
		case "form-add-sales-schedule":
			form_add_sales_schedule();
		break;
		
		case "add-sales-schedule-user":
			$sales_schedule_user_id = idbaru("sales_schedule_user","sales_schedule_user_id");
	
			mysql_query("INSERT INTO `sales_schedule_user`(`sales_schedule_user_id`, `salesman_id`, `sales_schedule_user_active`, `sales_schedule_user_datetime`, `user_id`) VALUES ('".$sales_schedule_user_id."','".$_POST['salesman_id']."','1','".$waktu_sekarang."','".$_SESSION['user_id']."')");
			
			header("location:../system/page_home.php?alimms=sales-schedule");
		break;
	
		case "add-sales-schedule":
			$sales_schedule_id = idbaru("sales_schedule","sales_schedule_id");
			
			mysql_query("INSERT INTO `sales_schedule`(`sales_schedule_id`, `salesman_id`, `sales_schedule_day`, `sales_schedule_week`, `sales_schedule_datetime`, `sales_schedule_active`, `user_id`) VALUES ('".$sales_schedule_id."','".$_POST['salesman_id']."','".$_POST['sales_schedule_day']."','".$_POST['sales_schedule_week']."','".$waktu_sekarang."','1','".$_SESSION['user_id']."')");
			
			header("location:../system/page_home.php?alimms=sales-schedule&tib=form-sales-schedule-entry&sales_schedule_id=".$sales_schedule_id);
		break;
		
		case "form-sales-schedule-entry":
			form_sales_schedule_entry();
		break;
		
		case "add-sales-schedule-entry":
			$sales_schedule_detail_id = idbaru("sales_schedule_detail","sales_schedule_detail_id");
			$sales_visit_id = idbaru("sales_visit","sales_visit_id");
			
			$tbl_sales_schedule_no = mysql_query("SELECT MAX(sales_schedule_no) as sales_schedule_no FROM sales_schedule_detail WHERE sales_schedule_id = '".$_POST['sales_schedule_id']."'");
			$data_tbl_sales_schedule_no = mysql_fetch_array($tbl_sales_schedule_no);
			
			$sales_schedule_no = $data_tbl_sales_schedule_no['sales_schedule_no'] + 1;
			
			mysql_query("INSERT INTO sales_schedule_detail(sales_schedule_detail_id, sales_schedule_id, sales_schedule_no, customer_id) VALUES ('".$sales_schedule_detail_id."', '".$_POST['sales_schedule_id']."','".$sales_schedule_no."', '".$_POST['customer_id']."')");
			
			$sales_schedule_id = $_POST['sales_schedule_id'];
			
			header("location:../system/page_home.php?alimms=sales-schedule&tib=form-sales-schedule-entry&sales_schedule_id=".$sales_schedule_id);	
		break;
		
		case "remove-sales-schedule":
			$tbl_sales_schedule_detail = mysql_query("SELECT sales_schedule_id, sales_schedule_no FROM sales_schedule_detail WHERE sales_schedule_detail_id = '".$_GET['sales_schedule_detail_id']."'");
			$data_tbl_sales_schedule_detail = mysql_fetch_array($tbl_sales_schedule_detail);

                        $tbl_sales_schedule = mysql_query("SELECT * FROM sales_schedule_detail WHERE sales_schedule_id = '".$data_tbl_sales_schedule_detail['sales_schedule_id']."' AND sales_schedule_no > '".$data_tbl_sales_schedule_detail['sales_schedule_no']."' order by sales_schedule_no");
			while($data_tbl_sales_schedule = mysql_fetch_array($tbl_sales_schedule)){

				$sales_schedule_no = $data_tbl_sales_schedule['sales_schedule_no'] - 1;

				mysql_query("UPDATE sales_schedule_detail SET sales_schedule_no = '".$sales_schedule_no."' WHERE sales_schedule_detail_id = '".$data_tbl_sales_schedule['sales_schedule_detail_id']."'");

			}
										
			mysql_query("DELETE FROM sales_schedule_detail WHERE sales_schedule_detail_id = '".$_GET['sales_schedule_detail_id']."'");
			
			mysql_query("DELETE FROM sales_visit WHERE sales_schedule_detail_id = '".$_GET['sales_schedule_detail_id']."'");
			
			header("location:../system/page_home.php?alimms=sales-schedule&tib=form-sales-schedule-entry&sales_schedule_id=".$data_tbl_sales_schedule_detail['sales_schedule_id']);	
		break;
		
		case "form-edit-sales-schedule-entry":
			form_edit_sales_schedule_entry();
		break;
		
		case "edit-sales-schedule":
			$sales_schedule_date = explode("-", $_POST['sales_schedule_date']);
			$date_sales_schedule = $sales_schedule_date[0];
			$month_sales_schedule = $sales_schedule_date[1];
			$year_sales_schedule = $sales_schedule_date[2];
			$sales_schedule_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_schedule, $date_sales_schedule, $year_sales_schedule));
			
			mysql_query("UPDATE sales_schedule SET salesman_id = '".$_POST['salesman_id']."', sales_schedule_date = '".$sales_schedule_date."', sales_schedule_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE sales_schedule_id = '".$_POST['sales_schedule_id']."'");
			
			header("location:../system/page_home.php?alimms=sales-schedule&tib=form-customer-sales-schedule&sales_schedule_id=".$_POST['sales_schedule_id']);	
		break;
	
		case "delete-sales-schedule":
			
			$tbl_sales_schedule = mysql_fetch_array(mysql_query("select * from sales_schedule where sales_schedule_id = '".$_GET['sales_schedule_id']."'"));
			$salesman_id = $tbl_sales_schedule['salesman_id'];
		
			mysql_query("UPDATE sales_schedule SET sales_schedule_datetime = '".$waktu_sekarang."', sales_schedule_active = '0', user_id = '".$_SESSION['user_id']."' WHERE sales_schedule_id = '".$_GET['sales_schedule_id']."'");
			
			header("location:../system/page_home.php?alimms=sales-schedule&tib=form-view-sales-schedule&salesman_id=".$salesman_id);	
		break;
		
		case "delete-sales-schedule-user":
		
			mysql_query("UPDATE sales_schedule_user SET sales_schedule_user_datetime = '".$waktu_sekarang."', sales_schedule_user_active = '0', user_id = '".$_SESSION['user_id']."' WHERE sales_schedule_user_id = '".$_GET['sales_schedule_user_id']."'");
			
			header("location:../system/page_home.php?alimms=sales-schedule");	
		break;
		
		case "form-view-sales-schedule":
			form_view_sales_schedule();
		break;
		
		case "form-view-sales-schedule-entry":
			form_view_sales_schedule_entry();
		break;
	}
?>