<?php
	switch($_GET['execute'])
	{
		default:
			default_retur_item_selling_platform();
		break;
		
		case "add-retur-item-selling-platform":
			add_retur_item_selling_platform();
		break;
		
		case "add-retur-item-selling":
			$retur_item_selling_id = sequence("retur_item_selling", "retur_item_selling_id");
			
			$retur_item_selling_date = explode("-", $_POST['retur_item_selling_date']);
			$date = $retur_item_selling_date[0];
			$month = $retur_item_selling_date[1];
			$year = $retur_item_selling_date[2];
			$retur_item_selling_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));

			mysql_query("INSERT INTO `retur_item_selling`(`retur_item_selling_id`, `retur_item_selling_date`, `reseller_id`, `retur_item_selling_datetime`, `retur_item_selling_active`) VALUES ('".$retur_item_selling_id."','".$retur_item_selling_date."','".$_POST['reseller_id']."','".$today."','1')");
		
			header("location:../dataverse/home.php?connect=retur-item-selling&execute=order-retur-item-selling-platform&retur_item_selling_id=".$retur_item_selling_id);
		break;
		
		case "order-retur-item-selling-platform":
			order_retur_item_selling_platform();
		break;
		
		case "order-retur-item-selling":
		    $order_retur_item_selling_id = sequence("order_retur_item_selling", "order_retur_item_selling_id");
		    
		    mysql_query("INSERT INTO `order_retur_item_selling`(`order_retur_item_selling_id`, `retur_item_selling_id`,`item_id`, `order_retur_item_selling_quantity`) VALUES ('".$order_retur_item_selling_id."','".$_POST['retur_item_selling_id']."','".$_POST['item_id']."','".$_POST['order_retur_item_selling_quantity']."')");
		    
		    header("location:../dataverse/home.php?connect=retur-item-selling&execute=order-retur-item-selling-platform&retur_item_selling_id=".$_POST['retur_item_selling_id']);
		break;
		
		case "delete-retur-order-item-selling":
		    
		    mysql_query("DELETE FROM order_retur_item_selling WHERE order_retur_item_selling_id = '".$_GET['order_retur_item_selling_id']."'");
		    
		    header("location:../dataverse/home.php?connect=retur-item-selling&execute=order-retur-item-selling-platform&retur_item_selling_id=".$_GET['retur_item_selling_id']);
		break;
		
		case "cancel-retur-item-selling":
		    
		    mysql_query("UPDATE retur_item_selling SET retur_item_selling_active = '0' WHERE retur_item_selling_id = '".$_GET['retur_item_selling_id']."'");
		    
		    header("location:../dataverse/home.php?connect=retur-item-selling");
		break;
		
		case "edit-retur-item-selling-platform":
			edit_retur_item_selling_platform();
		break;
		
		case "edit-retur-item-selling":
		    
		    $retur_item_selling_date = explode("-", $_POST['retur_item_selling_date']);
			$date = $retur_item_selling_date[0];
			$month = $retur_item_selling_date[1];
			$year = $retur_item_selling_date[2];
			$retur_item_selling_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
		    
		    mysql_query("UPDATE retur_item_selling SET retur_item_selling_date = '".$retur_item_selling_date."', supplier_id = '".$_POST['supplier_id']."' WHERE retur_item_selling_id = '".$_POST['retur_item_selling_id']."'");
		    
		   header("location:../dataverse/home.php?connect=retur-item-selling&execute=order-retur-item-selling-platform&retur_item_selling_id=".$_POST['retur_item_selling_id']);
		break;
		
		case "detail-retur-item-selling-platform":
			detail_retur_item_selling_platform();
		break;
	}