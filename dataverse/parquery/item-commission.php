<?php
	switch($_GET['execute'])
	{
		default:
			default_item_commission_platform();
		break;
		
		case "add-item-commission-platform":
			add_item_commission_platform();
		break;
		
		case "add-item-commission":
			$item_commission_id = sequence("item_commission", "item_commission_id");
			
			$item_commission_date = explode("-", $_POST['item_commission_date']);
			$date = $item_commission_date[0];
			$month = $item_commission_date[1];
			$year = $item_commission_date[2];
			$item_commission_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));

			mysql_query("INSERT INTO item_commission(item_commission_id, item_commission_date, item_id, minimal_selling, maximal_selling, item_commission_value, item_commission_create, item_commission_update, user_activity_id, item_commission_active) VALUES ('".$item_commission_id."', '".$item_commission_date."', '".$_POST['item_id']."', '".$_POST['minimal_selling']."', '".$_POST['maximal_selling']."', '".$_POST['item_commission_value']."', '".$today."', '".$today."', '".$_SESSION['user_id']."', '1')");
			
			header("location:../dataverse/home.php?connect=item-commission");
		break;

		case "history-item-commission-platform":
			history_item_commission_platform();
		break;

		case "edit-item-commission-platform":
			edit_item_commission_platform();
		break;
		
		case "edit-item-commission":
			$item_commission_date = explode("-", $_POST['item_commission_date']);
			$date = $item_commission_date[0];
			$month = $item_commission_date[1];
			$year = $item_commission_date[2];
			$item_commission_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));

			mysql_query("UPDATE item_commission SET item_commission_date = '".$item_commission_date."', item_commission_value = '".$_POST['item_commission_value']."', minimal_selling = '".$_POST['minimal_selling']."', maximal_selling = '".$_POST['maximal_selling']."' ,item_commission_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."' WHERE item_commission_id = '".$_POST['item_commission_id']."'");
			
			header("location:../dataverse/home.php?connect=item-commission&execute=history-item-commission-platform&item_id=".$_POST['item_id']);
		break;
		
		case "delete-item-commission":
			mysql_query("UPDATE item_commission SET item_commission_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', item_commission_active = '0' WHERE item_commission_id = '".$_GET['item_commission_id']."'");
			
			header("location:../dataverse/home.php?connect=item-commission&execute=history-item-commission-platform&item_id=".$_GET['item_id']);
		break;
	}
?>