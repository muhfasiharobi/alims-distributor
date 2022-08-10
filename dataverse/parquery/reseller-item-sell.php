<?php
	switch($_GET['execute'])
	{
		default:
			default_reseller_item_sell_platform();
		break;
		
		case "add-reseller-item-sell-platform":
			add_reseller_item_sell_platform();
		break;
		
		case "add-reseller-item-sell":
			$reseller_item_sell_id = sequence("reseller_item_sell", "reseller_item_sell_id");
			$item_price_id = sequence("item_price", "item_price_id");
			$item_commission_id = sequence("item_commission", "item_commission_id");
			
			$tgl_skrg = date('Y-m-d');

			$item = mysql_fetch_array(mysql_query("SELECT * FROM item WHERE item_id = '".$_POST['item_id']."'"));

			$reseller = mysql_fetch_array(mysql_query("SELECT * FROM reseller WHERE reseller_id = '".$_POST['reseller_id']."'"));

			mysql_query("UPDATE user SET item_category_id = '".$item['item_category_id']."' WHERE user_id = '".$reseller['user_id']."'");


			mysql_query("INSERT INTO `reseller_item_sell`(`reseller_item_sell_id`, `reseller_id`, `item_id`, `item_price_id`, `item_commission_id`, `reseller_item_sell_update`, `user_activity_id`, `reseller_item_sell_active`) VALUES ('".$reseller_item_sell_id."','".$_POST['reseller_id']."','".$_POST['item_id']."','".$item_price_id."','".$item_commission_id."','".$today."','".$_SESSION['user_id']."','1')");
			
			mysql_query("INSERT INTO `item_price`(`item_price_id`, `item_price_date`, `item_id`, `item_price_value`, `item_price_create`, `item_price_update`, `user_activity_id`, `item_price_active`) VALUES ('".$item_price_id."','".$tgl_skrg."','".$_POST['item_id']."','".$_POST['item_price_value']."','".$today."','".$today."','".$_SESSION['user_id']."','1')");
			
			mysql_query("INSERT INTO `item_commission`(`item_commission_id`, `item_commission_date`, `item_id`, `item_commission_value`, `item_commission_create`, `item_commission_update`, `user_activity_id`, `item_commission_active`) VALUES ('".$item_commission_id."','".$tgl_skrg."','".$_POST['item_id']."','".$_POST['item_commission_value']."','".$today."','".$today."','".$_SESSION['user_id']."','1')");
			
			header("location:../dataverse/home.php?connect=reseller-item-sell&execute=add-reseller-item-sell-platform&reseller_id=".$_POST['reseller_id']);
		break;

		case "history-reseller-item-sell-platform":
			history_reseller_item_sell_platform();
		break;

		case "edit-reseller-item-sell-platform":
			edit_reseller_item_sell_platform();
		break;
		
		case "edit-reseller-item-sell":
			$item_price_date = explode("-", $_POST['item_price_date']);
			$date = $item_price_date[0];
			$month = $item_price_date[1];
			$year = $item_price_date[2];
			$item_price_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));

			mysql_query("UPDATE item_price SET item_price_date = '".$item_price_date."', item_price_value = '".$_POST['item_price_value']."', item_price_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."' WHERE item_price_id = '".$_POST['item_price_id']."'");
			
			header("location:../dataverse/home.php?connect=reseller-item-sell&execute=history-reseller-item-sell-platform&reseller_item_sell_id=".$_POST['reseller_item_sell_id']);
		break;
		
		case "delete-reseller-item-sell":
		
			mysql_query("UPDATE reseller_item_sell SET reseller_item_sell_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', reseller_item_sell_active = '0' WHERE reseller_item_sell_id = '".$_GET['reseller_item_sell_id']."'");
			
			header("location:../dataverse/home.php?connect=reseller-item-sell&execute=add-reseller-item-sell-platform&reseller_id=".$_GET['reseller_id']);
		break;
	}
?>