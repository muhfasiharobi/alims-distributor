<?php
	switch($_GET['execute'])
	{
		default:
			default_user_platform();
		break;
		
		case "add-user-platform":
			add_user_platform();
		break;
		
		case "add-user":
			$user_id = sequence("user", "user_id");

			$user_password = md5($_POST['user_password']);
			$user_confirm_password = md5($_POST['user_confirm_password']);
			$user_original_password = date("dmY").$_POST['user_password'].date("His");
			
			mysql_query("INSERT INTO user(user_id, user_category_id, user_name, user_phone, user_email, user_username, user_password, user_confirm_password, user_original_password, user_create, user_update, user_activity_id, user_active) VALUES ('".$user_id."', '".$_POST['user_category_id']."', '".$_POST['user_name']."', '".$_POST['user_phone']."', '".$_POST['user_email']."', '".$_POST['user_username']."', '".$user_password."', '".$user_confirm_password."', '".$user_original_password."', '".$today."', '".$today."', '".$_SESSION['user_id']."', '1')");

			$user_category = mysql_fetch_array(mysql_query("SELECT * FROM user_category WHERE user_category_id = '".$_POST['user_category_id']."'"));

			if($user_category['user_category_name'] == "Admin Penjualan")
			{
				header("location:../dataverse/home.php?connect=user&execute=form-add-detail-user&user_id=".$user_id);
			}
			else
			{
				header("location:../dataverse/home.php?connect=user");
			}
			
			
		break;
		
		case "form-add-detail-user":
			form_add_detail_user();
		break;

		case "add-detail-user":
			$reseller_id = sequence("reseller", "reseller_id");

			mysql_query("UPDATE user SET item_category_id = '".$_POST['item_category_id']."' WHERE user_id = '".$_POST['user_id']."'");

			mysql_query("INSERT INTO reseller(reseller_id, user_id, reseller_code, reseller_name, reseller_address, reseller_village, reseller_districts, reseller_city, reseller_phone, bank_id, reseller_account_number, reseller_account_name, reseller_create, reseller_update, user_activity_id, reseller_active) VALUES ('".$reseller_id."','".$_POST['user_id']."', '".$_POST['kode_baru']."', '".$_POST['reseller_name']."', '', '', '', '', '".$_POST['reseller_phone']."', '', '', '', '".$today."', '".$today."', '".$_SESSION['user_id']."', '1')");

			$item_category = mysql_query("SELECT * FROM item WHERE item_category_id = '".$_POST['item_category_id']."'");
			while($data_item_category = mysql_fetch_array($item_category))
			{
				$reseller_item_sell_id = sequence("reseller_item_sell", "reseller_item_sell_id");

				mysql_query("INSERT INTO `reseller_item_sell`(`reseller_item_sell_id`, `reseller_id`, `item_id`, `item_price_id`, `item_commission_id`, `reseller_item_sell_update`, `user_activity_id`, `reseller_item_sell_active`) VALUES ('".$reseller_item_sell_id."','".$reseller_id."','".$data_item_category['item_id']."','','','".$today."','".$_SESSION['user_id']."','1')");
			}

			

			header("location:../dataverse/home.php?connect=user");
		break;

		case "edit-user-platform":
			edit_user_platform();
		break;
		
		case "edit-user":
			if ($_POST['user_new_password'] == "" && $_POST['user_confirm_new_password'] == "")
			{
				mysql_query("UPDATE user SET user_category_id = '".$_POST['user_category_id']."', user_name = '".$_POST['user_name']."', user_phone = '".$_POST['user_phone']."', user_email = '".$_POST['user_email']."', user_username = '".$_POST['user_username']."', user_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."' WHERE user_id = '".$_POST['user_id']."'");
			}
			else
			{
				$user_password = md5($_POST['user_new_password']);
				$user_confirm_password = md5($_POST['user_confirm_new_password']);
				$user_original_password = $_POST['user_new_password'];

				mysql_query("UPDATE user SET user_category_id = '".$_POST['user_category_id']."', user_name = '".$_POST['user_name']."', user_phone = '".$_POST['user_phone']."', user_email = '".$_POST['user_email']."', user_username = '".$_POST['user_username']."', user_password = '".$user_password."', user_confirm_password = '".$user_confirm_password."', user_original_password = '".$user_original_password."', user_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."' WHERE user_id = '".$_POST['user_id']."'");
			}
			
			header("location:../dataverse/home.php?connect=user");
		break;
		
		case "delete-user":
			mysql_query("UPDATE user SET user_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', user_active = '0' WHERE user_id = '".$_GET['user_id']."'");
			
			header("location:../dataverse/home.php?connect=user");
		break;
	}
?>