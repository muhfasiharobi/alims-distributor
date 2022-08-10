<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_delivery_plan();
		break;
	
		case "form-schedule-delivery-plan":
			form_schedule_delivery_plan();
		break;
	
		case "schedule-delivery-plan":
			$delivery_distribution_id = idbaru("delivery_distribution","delivery_distribution_id");
			
			mysql_query("UPDATE delivery_plan SET delivery_schedule_id = '".$_POST['delivery_schedule_id']."', delivery_session_id = '".$_POST['delivery_session_id']."', delivery_plan_status = 'Closed', delivery_plan_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE delivery_plan_id = '".$_POST['delivery_plan_id']."'");
			
			$tbl_delivery_distribution = mysql_query("SELECT * FROM delivery_distribution WHERE delivery_schedule_id = '".$_POST['delivery_schedule_id']."' AND delivery_session_id = '".$_POST['delivery_session_id']."'");
			$jumlah_tbl_delivery_distribution = mysql_num_rows($tbl_delivery_distribution);
			
			if ($jumlah_tbl_delivery_distribution < 1)
			{
				mysql_query("INSERT INTO delivery_distribution(delivery_distribution_id, delivery_schedule_id, delivery_session_id) VALUES ('".$delivery_distribution_id."', '".$_POST['delivery_schedule_id']."', '".$_POST['delivery_session_id']."')");
			}
			
			header("location:../system/home.php?alimms=delivery-plan");
		break;
		
		case "form-edit-delivery-plan":
			form_edit_delivery_plan();
		break;
		
		case "edit-delivery-plan":
			$delivery_distribution_id = idbaru("delivery_distribution","delivery_distribution_id");
			
			mysql_query("UPDATE delivery_plan SET delivery_schedule_id = '".$_POST['delivery_schedule_id']."', delivery_session_id = '".$_POST['delivery_session_id']."', delivery_plan_datetime = '".$waktu_sekarang."', user_id = '".$jumlah_tbl_delivery_plan."' WHERE delivery_plan_id = '".$_POST['delivery_plan_id']."'");
			
			$tbl_delivery_plan = mysql_query("SELECT * FROM delivery_distribution WHERE delivery_schedule_id = '".$_POST['delivery_schedule_id']."' AND delivery_session_id = '".$_POST['delivery_session_id']."'");
			$jumlah_tbl_delivery_plan = mysql_num_rows($tbl_delivery_plan);
			
			if ($jumlah_tbl_delivery_plan > 0)
			{
				mysql_query("DELETE FROM delivery_distribution WHERE delivery_schedule_id = '".$_POST['delivery_schedule_delete_id']."' AND delivery_session_id = '".$_POST['delivery_session_delete_id']."'");
			}
			else
			{
				mysql_query("INSERT INTO delivery_distribution(delivery_distribution_id, delivery_schedule_id, delivery_session_id) VALUES ('".$delivery_distribution_id."', '".$_POST['delivery_schedule_id']."', '".$_POST['delivery_session_id']."')");
			}
			
			header("location:../system/home.php?alimms=delivery-plan");	
		break;
	}
?>