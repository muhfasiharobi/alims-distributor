<?php
	switch($_GET['execute'])
	{
		default:
			default_item_stock_platform();
		break;
		
		case "add-item-stock-platform":
			add_item_stock_platform();
		break;
		
		case "add-item-stock":
			$item_stock_id = sequence("item_stock", "item_stock_id");
			
			mysql_query("");
			
			header("location:../dataverse/home.php?connect=item-stock");
		break;
		
		case "edit-item-stock-platform":
			edit_item_stock_platform();
		break;
		
		case "edit-item-stock":
			mysql_query("");
			
			header("location:../dataverse/home.php?connect=item-stock");
		break;
		
		case "delete-item-stock":
			mysql_query("");
			
			header("location:../dataverse/home.php?connect=item-stock");
		break;
	}
?>