<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_delivery_vehicle();
		break;
		
		case "form-add-delivery-vehicle":
			form_add_delivery_vehicle();
		break;
	
		case "add-delivery-vehicle":
			$delivery_vehicle_id = idbaru("delivery_vehicle","delivery_vehicle_id");
			
			mysql_query("INSERT INTO delivery_vehicle(delivery_vehicle_id, delivery_vehicle_license_no, delivery_vehicle_name, delivery_vehicle_payload_capacity, delivery_vehicle_datetime, user_id) VALUES ('".$delivery_vehicle_id."', '".$_POST['delivery_vehicle_license_no']."', '".$_POST['delivery_vehicle_name']."', '".$_POST['delivery_vehicle_payload_capacity']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
	
			header("location:../system/page_home.php?alimms=delivery-vehicle");
		break;
	
		case "form-edit-delivery-vehicle":
			form_edit_delivery_vehicle();
		break;
		
		case "edit-delivery-vehicle":
			mysql_query("UPDATE delivery_vehicle SET delivery_vehicle_license_no = '".$_POST['delivery_vehicle_license_no']."', delivery_vehicle_name = '".$_POST['delivery_vehicle_name']."', delivery_vehicle_payload_capacity = '".$_POST['delivery_vehicle_payload_capacity']."', delivery_vehicle_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE delivery_vehicle_id = '".$_POST['delivery_vehicle_id']."'");
		
			header("location:../system/page_home.php?alimms=delivery-vehicle");
		break;
	
		case "delete-delivery-vehicle":
			mysql_query("UPDATE delivery_vehicle SET delivery_vehicle_datetime = '".$waktu_sekarang."', delivery_vehicle_active = '0', user_id = '".$_SESSION['user_id']."' WHERE delivery_vehicle_id = '".$_GET['delivery_vehicle_id']."'");
			
			header("location:../system/page_home.php?alimms=delivery-vehicle");
		break;
		
		case "active-delivery-vehicle":
			mysql_query("UPDATE delivery_vehicle SET delivery_vehicle_datetime = '".$waktu_sekarang."', delivery_vehicle_active = '1', user_id = '".$_SESSION['user_id']."' WHERE delivery_vehicle_id = '".$_GET['delivery_vehicle_id']."'");
			
			header("location:../system/page_home.php?alimms=delivery-vehicle");	
		break;
	}
?>