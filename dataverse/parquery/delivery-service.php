<?php
	switch($_GET['execute'])
	{
		default:
			default_delivery_service_platform();
		break;
		
		case "add-delivery-service-platform":
			add_delivery_service_platform();
		break;
		
		case "add-delivery-service":
			$delivery_service_id = sequence("delivery_service", "delivery_service_id");
			
			mysql_query("INSERT INTO `delivery_service`(`delivery_service_id`, `delivery_service_name`, `delivery_service_datetime`, `user_activity_id`, `delivery_service_active`) VALUES ('".$delivery_service_id."','".$_POST['delivery_service_name']."','".$today."','".$_SESSION['user_id']."','1')");
			
			header("location:../dataverse/home.php?connect=delivery-service");
		break;
		
		case "edit-delivery-service-platform":
			edit_delivery_service_platform();
		break;
		
		case "edit-delivery-service":

			mysql_query("UPDATE `delivery_service` SET `delivery_service_name`= '".$_POST['delivery_service_name']."' WHERE `delivery_service_id`= '".$_POST['delivery_service_id']."'");
			
			header("location:../dataverse/home.php?connect=delivery-service");
		break;
		
		case "delete-delivery-service":

			mysql_query("UPDATE delivery_service SET  delivery_service_active = '0' WHERE delivery_service_id = '".$_GET['delivery_service_id']."'");
			
			header("location:../dataverse/home.php?connect=delivery-service");
		break;
	}
?>