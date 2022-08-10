<?php
	switch($_GET['execute'])
	{
		default:
			default_bank_platform();
		break;
		
		case "add-bank-platform":
			add_bank_platform();
		break;
		
		case "add-bank":
			$bank_id = sequence("bank", "bank_id");
			
			$tgl_skrg = date('Y-m-d');
			
			mysql_query("INSERT INTO `bank`(`bank_id`, `bank_name`, `bank_update`, `bank_active`) VALUES ('".$bank_id."','".$_POST['bank_name']."','".$today."','1')");
			
			header("location:../dataverse/home.php?connect=bank");
		break;
		
		case "edit-bank-platform":
			edit_bank_platform();
		break;
		
		case "edit-bank":

			mysql_query("UPDATE `bank` SET `bank_name`='".$_POST['bank_name']."',`bank_update`='".$today."' WHERE `bank_id`= '".$_POST['bank_id']."'");
			
			header("location:../dataverse/home.php?connect=bank");
		break;
		
		case "delete-bank":

			mysql_query("UPDATE bank SET  bank_active = '0' WHERE bank_id = '".$_GET['bank_id']."'");
			
			header("location:../dataverse/home.php?connect=bank");
		break;
	}
?>