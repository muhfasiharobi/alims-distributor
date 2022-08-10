<?php
	switch($_GET['execute'])
	{
		default:
			default_item_price_platform();
		break;
		
		case "add-item-price-platform":
			add_item_price_platform();
		break;
		
		case "add-item-price":
			$item_price_id = sequence("item_price", "item_price_id");
			
			$item_price_date = explode("-", $_POST['item_price_date']);
			$date = $item_price_date[0];
			$month = $item_price_date[1];
			$year = $item_price_date[2];
			$item_price_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));

			mysql_query("INSERT INTO item_price(item_price_id, item_price_date, item_id, item_price_value, item_price_create, item_price_update, user_activity_id, item_price_active) VALUES ('".$item_price_id."', '".$item_price_date."', '".$_POST['item_id']."', '".$_POST['item_price_value']."', '".$today."', '".$today."', '".$_SESSION['user_id']."', '1')");
			
			mysql_query("UPDATE item_price SET item_price_active = '0' WHERE item_id = '".$_POST['item_id']."' AND item_price_id != '".$item_price_id."'");
			
			header("location:../dataverse/home.php?connect=item-price");
		break;

		case "history-item-price-platform":
			history_item_price_platform();
		break;

		case "edit-item-price-platform":
			edit_item_price_platform();
		break;
		
		case "edit-item-price":
			$item_price_date = explode("-", $_POST['item_price_date']);
			$date = $item_price_date[0];
			$month = $item_price_date[1];
			$year = $item_price_date[2];
			$item_price_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));

			mysql_query("UPDATE item_price SET item_price_date = '".$item_price_date."', item_price_value = '".$_POST['item_price_value']."', item_price_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."' WHERE item_price_id = '".$_POST['item_price_id']."'");
			
			header("location:../dataverse/home.php?connect=item-price&execute=history-item-price-platform&item_id=".$_POST['item_id']);
		break;
		
		case "delete-item-price":
			mysql_query("UPDATE item_price SET item_price_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', item_price_active = '0' WHERE item_price_id = '".$_GET['item_price_id']."'");
			
			header("location:../dataverse/home.php?connect=item-price&execute=history-item-price-platform&item_id=".$_GET['item_id']);
		break;
	}
?>