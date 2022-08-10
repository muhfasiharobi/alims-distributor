<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_delivery_schedule();
		break;
	
		case "form-add-delivery-schedule":
			form_add_delivery_schedule();
		break;
	
		case "add-delivery-schedule":
			$delivery_schedule_id = idbaru("delivery_schedule","delivery_schedule_id");
			
			$delivery_schedule_date = explode("-", $_POST['delivery_schedule_date']);
			$date_delivery_schedule = $delivery_schedule_date[0];
			$month_delivery_schedule = $delivery_schedule_date[1];
			$year_delivery_schedule = $delivery_schedule_date[2];
			$delivery_schedule_date = date("Y-m-d", mktime(0, 0, 0, $month_delivery_schedule, $date_delivery_schedule, $year_delivery_schedule));
			
			mysql_query("INSERT INTO delivery_schedule(delivery_schedule_id, delivery_vehicle_id, delivery_schedule_date, delivery_schedule_driver_name, delivery_schedule_datetime, user_id) VALUES ('".$delivery_schedule_id."', '".$_POST['delivery_vehicle_id']."', '".$delivery_schedule_date."', '".$_POST['delivery_schedule_driver_name']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
			
			header("location:../system/page_home.php?alimms=delivery-schedule&tib=form-helper-delivery-schedule&delivery_schedule_id=".$delivery_schedule_id);
		break;
		
		case "form-helper-delivery-schedule":
			form_helper_delivery_schedule();
		break;
		
		case "helper-delivery-schedule":
			$delivery_schedule_detail_id = idbaru("delivery_schedule_detail","delivery_schedule_detail_id");
			
			mysql_query("INSERT INTO delivery_schedule_detail(delivery_schedule_detail_id, delivery_schedule_id, delivery_schedule_detail_helper_name) VALUES ('".$delivery_schedule_detail_id."', '".$_POST['delivery_schedule_id']."', '".$_POST['delivery_schedule_detail_helper_name']."')");
			
			header("location:../system/page_home.php?alimms=delivery-schedule&tib=form-helper-delivery-schedule&delivery_schedule_id=".$_POST['delivery_schedule_id']);	
		break;
	
		case "remove-delivery-schedule":
			$tbl_delivery_schedule_detail = mysql_query("SELECT delivery_schedule_id FROM delivery_schedule_detail WHERE delivery_schedule_detail_id = '".$_GET['delivery_schedule_detail_id']."'");
			$data_tbl_delivery_schedule_detail = mysql_fetch_array($tbl_delivery_schedule_detail);
										
			mysql_query("DELETE FROM delivery_schedule_detail WHERE delivery_schedule_detail_id = '".$_GET['delivery_schedule_detail_id']."'");
			
			header("location:../system/page_home.php?alimms=delivery-schedule&tib=form-helper-delivery-schedule&delivery_schedule_id=".$data_tbl_delivery_schedule_detail['delivery_schedule_id']);
		break;
	
		case "form-edit-delivery-schedule":
			form_edit_delivery_schedule();
		break;
	
		case "edit-delivery-schedule":
			$delivery_schedule_date = explode("-", $_POST['delivery_schedule_date']);
			$date_delivery_schedule = $delivery_schedule_date[0];
			$month_delivery_schedule = $delivery_schedule_date[1];
			$year_delivery_schedule = $delivery_schedule_date[2];
			$delivery_schedule_date = date("Y-m-d", mktime(0, 0, 0, $month_delivery_schedule, $date_delivery_schedule, $year_delivery_schedule));
			
			mysql_query("UPDATE delivery_schedule SET delivery_vehicle_id = '".$_POST['delivery_vehicle_id']."', delivery_schedule_date = '".$delivery_schedule_date."', delivery_schedule_driver_name = '".$_POST['delivery_schedule_driver_name']."', delivery_schedule_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE delivery_schedule_id = '".$_POST['delivery_schedule_id']."'");
			
			header("location:../system/page_home.php?alimms=delivery-schedule&tib=form-driver-delivery-schedule&delivery_schedule_id=".$_POST['delivery_schedule_id']);
		break;
		
		case "delete-delivery-schedule":
			mysql_query("UPDATE delivery_schedule SET delivery_schedule_datetime = '".$waktu_sekarang."', delivery_schedule_active = '0', user_id = '".$_SESSION['user_id']."' WHERE delivery_schedule_id = '".$_GET['delivery_schedule_id']."'");
			
			header("location:../system/page_home.php?alimms=delivery-schedule");
		break;
		
		case "form-view-delivery-schedule":
			form_view_delivery_schedule();
		break;
		
		case "active-delivery-schedule":
			mysql_query("UPDATE delivery_schedule SET delivery_schedule_datetime = '".$waktu_sekarang."', delivery_schedule_active = '1', user_id = '".$_SESSION['user_id']."' WHERE delivery_schedule_id = '".$_GET['delivery_schedule_id']."'");
			
			header("location:../system/page_home.php?alimms=delivery-schedule");	
		break;
	}
?>