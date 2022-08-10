<?php
	switch($_GET['execute'])
	{
		default:
			default_marketplace_platform();
		break;
		
		case "add-marketplace-platform":
			add_marketplace_platform();
		break;
		
		case "add-marketplace":
			$order_via_id = sequence("order_via", "order_via_id");
			
			$tgl_skrg = date('Y-m-d');
			
			mysql_query("INSERT INTO `order_via`(`order_via_id`, `order_via_name`, `order_via_create`, `order_via_update`, `user_activity_id`, `order_via_active`) VALUES ('".$order_via_id."','".$_POST['order_via_name']."','".$tgl_skrg."','".$today."','".$_SESSION['user_id']."','1')");
			
			header("location:../dataverse/home.php?connect=marketplace");
		break;
		
		case "edit-marketplace-platform":
			edit_marketplace_platform();
		break;
		
		case "edit-marketplace":

			mysql_query("UPDATE `order_via` SET `order_via_name`= '".$_POST['order_via_name']."' WHERE `order_via_id`= '".$_POST['order_via_id']."'");
			
			header("location:../dataverse/home.php?connect=marketplace");
		break;
		
		case "delete-marketplace":

			mysql_query("UPDATE order_via SET  order_via_active = '0' WHERE order_via_id = '".$_GET['order_via_id']."'");
			
			header("location:../dataverse/home.php?connect=marketplace");
		break;
	}
?>