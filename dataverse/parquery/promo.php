<?php
	switch($_GET['execute'])
	{
		default:
			default_promo_platform();
		break;
		
		case "add-promo-platform":
			add_promo_platform();
		break;
		
		case "add-promo":
			$promo_id = sequence("promo", "promo_id");

			$promo_from_date = explode("-", $_POST['from_date']);
			$date = $promo_from_date[0];
			$month = $promo_from_date[1];
			$year = $promo_from_date[2];
			$promo_from_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));

			$promo_to_date = explode("-", $_POST['to_date']);
			$date = $promo_to_date[0];
			$month = $promo_to_date[1];
			$year = $promo_to_date[2];
			$promo_to_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));

			mysql_query("INSERT INTO `promo`(`promo_id`, `promo_name`, `promo_from_date`, `promo_to_date`,`kategori_promo`,`promo_value`, `promo_update`, `user_activity_id`, `promo_active`) VALUES ('".$promo_id."','".$_POST['promo_name']."','".$promo_from_date."','".$promo_to_date."','".$_POST['kategori_promo']."','".$_POST['promo_value']."','".$today."','".$_SESSION['user_id']."','1')");
			
			header("location:../dataverse/home.php?connect=promo");
		break;

		case "add-item-promo-platform":
			add_item_promo_platform();
		break;

		case "edit-promo-platform":
			edit_promo_platform();
		break;
		
		case "edit-promo":

			$promo_from_date = explode("-", $_POST['from_date']);
			$date = $promo_from_date[0];
			$month = $promo_from_date[1];
			$year = $promo_from_date[2];
			$promo_from_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));

			$promo_to_date = explode("-", $_POST['to_date']);
			$date = $promo_to_date[0];
			$month = $promo_to_date[1];
			$year = $promo_to_date[2];
			$promo_to_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));

			mysql_query("UPDATE promo SET promo_name = '".$_POST['promo_name']."', promo_value = '".$_POST['promo_value']."', promo_from_date = '".$promo_from_date."', promo_to_date = '".$promo_to_date."' WHERE promo_id = '".$_POST['promo_id']."'");
			
			header("location:../dataverse/home.php?connect=promo");
		break;
		
		case "delete-promo":
		
			mysql_query("UPDATE promo SET promo_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', promo_active = '0' WHERE promo_id = '".$_GET['promo_id']."'");
			
			header("location:../dataverse/home.php?connect=promo");
		break;
	}
?>