<?php
	switch($_GET['execute'])
	{
		default:
			default_retur_item_purchase_platform();
		break;
		
		case "add-retur-item-purchase-platform":
			add_retur_item_purchase_platform();
		break;
		
		case "add-retur-item-purchase":
			$retur_item_purchase_id = sequence("retur_item_purchase", "retur_item_purchase_id");
			
			$retur_item_purchase_date = explode("-", $_POST['retur_item_purchase_date']);
			$date = $retur_item_purchase_date[0];
			$month = $retur_item_purchase_date[1];
			$year = $retur_item_purchase_date[2];
			$retur_item_purchase_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
			
			mysql_query("INSERT INTO `retur_item_purchase`(`retur_item_purchase_id`, `retur_item_purchase_date`, `supplier_id`, `retur_item_purchase_datetime`, `retur_item_purchase_active`) VALUES ('".$retur_item_purchase_id."','".$retur_item_purchase_date."','".$_POST['supplier_id']."','".$today."','1')");
		
			header("location:../dataverse/home.php?connect=retur-item-purchase&execute=order-retur-item-purchase-platform&retur_item_purchase_id=".$retur_item_purchase_id);
		break;
		
		case "order-retur-item-purchase-platform":
			order_retur_item_purchase_platform();
		break;
		
		case "order-retur-item-purchase":
		    $order_retur_item_purchase_id = sequence("order_retur_item_purchase", "order_retur_item_purchase_id");
		    
		    mysql_query("INSERT INTO `order_retur_item_purchase`(`order_retur_item_purchase_id`, `retur_item_purchase_id`,`item_id`, `order_retur_item_purchase_quantity`) VALUES ('".$order_retur_item_purchase_id."','".$_POST['retur_item_purchase_id']."','".$_POST['item_id']."','".$_POST['order_retur_item_purchase_quantity']."')");
		    
		    header("location:../dataverse/home.php?connect=retur-item-purchase&execute=order-retur-item-purchase-platform&retur_item_purchase_id=".$_POST['retur_item_purchase_id']);
		break;
		
		case "delete-retur-order-item-purchase":
		    
		    mysql_query("DELETE FROM order_retur_item_purchase WHERE order_retur_item_purchase_id = '".$_GET['order_retur_item_purchase_id']."'");
		    
		    header("location:../dataverse/home.php?connect=retur-item-purchase&execute=order-retur-item-purchase-platform&retur_item_purchase_id=".$_GET['retur_item_purchase_id']);
		break;
		
		case "cancel-retur-item-purchase":
		    
		    mysql_query("UPDATE retur_item_purchase SET retur_item_purchase_active = '0' WHERE retur_item_purchase_id = '".$_GET['retur_item_purchase_id']."'");
		    
		    header("location:../dataverse/home.php?connect=retur-item-purchase");
		break;
		
		case "edit-retur-item-purchase-platform":
			edit_retur_item_purchase_platform();
		break;
		
		case "edit-retur-item-purchase":
		    
		    $retur_item_purchase_date = explode("-", $_POST['retur_item_purchase_date']);
			$date = $retur_item_purchase_date[0];
			$month = $retur_item_purchase_date[1];
			$year = $retur_item_purchase_date[2];
			$retur_item_purchase_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
		    
		    mysql_query("UPDATE retur_item_purchase SET retur_item_purchase_date = '".$retur_item_purchase_date."', supplier_id = '".$_POST['supplier_id']."' WHERE retur_item_purchase_id = '".$_POST['retur_item_purchase_id']."'");
		    
		   header("location:../dataverse/home.php?connect=retur-item-purchase&execute=order-retur-item-purchase-platform&retur_item_purchase_id=".$_POST['retur_item_purchase_id']);
		break;
		
		case "detail-retur-item-purchase-platform":
			detail_retur_item_purchase_platform();
		break;
	}
?>