<?php
	switch($_GET['execute'])
	{
		default:
			default_reseller_platform();
		break;
		
		case "add-reseller-platform":
			add_reseller_platform();
		break;
		
		case "add-reseller":
			$reseller_id = sequence("reseller", "reseller_id");
			$user_id = sequence("user", "user_id");
			$item_price_id = sequence("item_price","item_price_id");
			$item_commission_id = sequence("item_commission","item_commission_id");
			
			$cek_username = mysql_num_rows(mysql_query("SELECT * FROM user WHERE user_username = '".$_POST['reseller_username']."'"));
			
			if($cek_username > 0)
			{
				echo "<script type='text/javascript'>  alert('Username sudah digunakan!'); </script>";
				echo "<script type='text/javascript'>window.location='home.php?connect=reseller';</script>";
			}
			else
			{
			


				mysql_query("INSERT INTO reseller(reseller_id, user_id, reseller_code, reseller_name, reseller_address, reseller_village, reseller_districts, reseller_city, reseller_phone, bank_id, reseller_account_number, reseller_account_name, reseller_create, reseller_update, user_activity_id, reseller_active) VALUES ('".$reseller_id."','".$user_id."', '".$_POST['reseller_code']."', '".$_POST['reseller_name']."', '".$_POST['reseller_address']."', '".$_POST['reseller_village']."', '".$_POST['reseller_districts']."', '".$_POST['reseller_city']."', '".$_POST['reseller_phone']."', '".$_POST['bank_id']."', '".$_POST['reseller_account_number']."', '".$_POST['reseller_account_name']."', '".$today."', '".$today."', '".$_SESSION['user_id']."', '1')");
				
				$password = md5($_POST['reseller_password']);
				
				mysql_query("INSERT INTO `user`(`user_id`, `user_category_id`, `user_photo`, `user_name`, `user_phone`, `user_email`, `user_username`, `user_password`, `user_confirm_password`, `user_original_password`, `user_create`, `user_update`, `user_activity_id`, `user_active`) VALUES ('".$user_id."','2','','".$_POST['reseller_name']."','".$_POST['reseller_phone']."','".$_POST['reseller_email']."','".$_POST['reseller_username']."','".$password."','".$password."','".$_POST['reseller_password']."','".$today."','".$today."','".$_SESSION['user_id']."','1')");
				
				header("location:../dataverse/home.php?connect=reseller-item-sell&execute=add-reseller-item-sell-platform&reseller_id=".$reseller_id);
			}
		break;
		
		case "edit-reseller-platform":
			edit_reseller_platform();
		break;
		
		case "edit-reseller":
		
			$cek_username = mysql_num_rows(mysql_query("SELECT * FROM user WHERE user_username = '".$_POST['reseller_username']."'"));
			
		
				mysql_query("UPDATE reseller SET reseller_code = '".$_POST['reseller_code']."', reseller_name = '".$_POST['reseller_name']."', reseller_address = '".$_POST['reseller_address']."', reseller_village = '".$_POST['reseller_village']."', reseller_districts = '".$_POST['reseller_districts']."', reseller_city = '".$_POST['reseller_city']."', reseller_phone = '".$_POST['reseller_phone']."', bank_id = '".$_POST['bank_id']."', reseller_account_number = '".$_POST['reseller_account_number']."', reseller_account_name = '".$_POST['reseller_account_name']."' WHERE reseller_id = '".$_POST['reseller_id']."'");
				
				$password = md5($_POST['reseller_password']);
				
				mysql_query("UPDATE user SET user_username = '".$_POST['reseller_username']."', user_password = '".$password."', user_confirm_password = '".$password."', user_original_password = '".$_POST['reseller_password']."' WHERE user_id = '".$_POST['user_id']."'");
				
			
			
			header("location:../dataverse/home.php?connect=reseller");
		break;
		
		case "delete-reseller":
			mysql_query("UPDATE reseller SET reseller_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', reseller_active = '0' WHERE reseller_id = '".$_GET['reseller_id']."'");
			
			header("location:../dataverse/home.php?connect=reseller");
		break;
	}
?>