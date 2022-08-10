<?php
	switch($_GET['execute'])
	{
		default:
			default_item_purchase_platform();
		break;
		
		case "add-item-purchase-platform":
			add_item_purchase_platform();
		break;
		
		case "add-item-purchase":
			$item_purchase_id = sequence("item_purchase", "item_purchase_id");
			
			$item_purchase_date = explode("-", $_POST['item_purchase_date']);
			$date = $item_purchase_date[0];
			$month = $item_purchase_date[1];
			$year = $item_purchase_date[2];
			$item_purchase_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));

			$item_purchase_due_date = explode("-", $_POST['item_purchase_due_date']);
			$date = $item_purchase_due_date[0];
			$month = $item_purchase_due_date[1];
			$year = $item_purchase_due_date[2];
			$item_purchase_due_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));

			mysql_query("INSERT INTO item_purchase(item_purchase_id, item_purchase_date, item_purchase_due_date, item_category_id, supplier_id, item_purchase_create, item_purchase_update, user_activity_id, item_purchase_active) VALUES ('".$item_purchase_id."', '".$item_purchase_date."', '".$item_purchase_due_date."', '".$_POST['item_category_id']."', '".$_POST['supplier_id']."', '".$today."', '".$today."', '".$_SESSION['user_id']."', '0')");
			
			header("location:../dataverse/home.php?connect=item-purchase&execute=order-item-purchase-platform&item_purchase_id=".$item_purchase_id);
		break;

		case "order-item-purchase-platform":
			order_item_purchase_platform();
		break;

		case "order-item-purchase":
			$order_item_purchase_id = sequence("order_item_purchase", "order_item_purchase_id");

			mysql_query("INSERT INTO order_item_purchase(order_item_purchase_id, item_purchase_id, item_id, order_item_purchase_quantity, order_item_purchase_price, order_item_purchase_create, order_item_purchase_update, user_activity_id, order_item_purchase_active) VALUES ('".$order_item_purchase_id."', '".$_POST['item_purchase_id']."', '".$_POST['item_id']."', '".$_POST['order_item_purchase_quantity']."', '".$_POST['order_item_purchase_price']."', '".$today."', '".$today."', '".$_SESSION['user_id']."', '1')");
			
			mysql_query("UPDATE item_purchase SET item_purchase_active = '1' WHERE item_purchase_id = '".$_POST['item_purchase_id']."'");
			
			header("location:../dataverse/home.php?connect=item-purchase&execute=order-item-purchase-platform&item_purchase_id=".$_POST['item_purchase_id']);
		break;

		case "cancel-order-item-purchase":
			mysql_query("UPDATE item_purchase SET item_purchase_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', item_purchase_active = '0' WHERE item_purchase_id = '".$_GET['item_purchase_id']."'");
			
			mysql_query("UPDATE order_item_purchase SET order_item_purchase_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', order_item_purchase_active = '0' WHERE item_purchase_id = '".$_GET['item_purchase_id']."'");
			
			header("location:../dataverse/home.php?connect=item-purchase");
		break;
		
		case "delete-order-item-purchase":
			mysql_query("UPDATE order_item_purchase SET order_item_purchase_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', order_item_purchase_active = '0' WHERE order_item_purchase_id = '".$_GET['order_item_purchase_id']."'");
			
			header("location:../dataverse/home.php?connect=item-purchase&execute=order-item-purchase-platform&item_purchase_id=".$_GET['item_purchase_id']);
		break;

		case "edit-item-purchase-platform":
			edit_item_purchase_platform();
		break;
		
		case "edit-item-purchase":
			$item_purchase_date = explode("-", $_POST['item_purchase_date']);
			$date = $item_purchase_date[0];
			$month = $item_purchase_date[1];
			$year = $item_purchase_date[2];
			$item_purchase_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));

			$item_purchase_due_date = explode("-", $_POST['item_purchase_due_date']);
			$date = $item_purchase_due_date[0];
			$month = $item_purchase_due_date[1];
			$year = $item_purchase_due_date[2];
			$item_purchase_due_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));

			mysql_query("UPDATE item_purchase SET item_purchase_date = '".$item_purchase_date."', item_purchase_due_date = '".$item_purchase_due_date."', supplier_id = '".$_POST['supplier_id']."', item_purchase_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."' WHERE item_purchase_id = '".$_POST['item_purchase_id']."'");
			
			header("location:../dataverse/home.php?connect=item-purchase&execute=order-item-purchase-platform&item_purchase_id=".$_POST['item_purchase_id']);
		break;
		
		case "delete-item-purchase":
			mysql_query("UPDATE item_purchase SET item_purchase_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', item_purchase_active = '0' WHERE item_purchase_id = '".$_GET['item_purchase_id']."'");

			mysql_query("UPDATE order_item_purchase SET order_item_purchase_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', order_item_purchase_active = '0' WHERE item_purchase_id = '".$_GET['item_purchase_id']."'");
			
			header("location:../dataverse/home.php?connect=item-purchase");
		break;
	}
?>