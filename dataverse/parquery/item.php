<?php
	switch($_GET['execute'])
	{
		default:
			default_item_platform();
		break;
		
		case "add-item-platform":
			add_item_platform();
		break;
		
		case "add-item":
			$item_id = sequence("item", "item_id");
			
			mysql_query("INSERT INTO item(item_id, item_category_id, item_name, item_create, item_update, user_activity_id, item_active) VALUES ('".$item_id."', '".$_POST['item_category_id']."', '".$_POST['item_name']."', '".$today."', '".$today."', '".$_SESSION['user_id']."', '1')");
			
			header("location:../dataverse/home.php?connect=item");
		break;
		
		case "edit-item-platform":
			edit_item_platform();
		break;
		
		case "edit-item":
			mysql_query("UPDATE item SET item_category_id = '".$_POST['item_category_id']."', item_name = '".$_POST['item_name']."', item_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."' WHERE item_id = '".$_POST['item_id']."'");
			
			header("location:../dataverse/home.php?connect=item");
		break;
		
		case "delete-item":
			mysql_query("UPDATE item SET item_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', item_active = '0' WHERE item_id = '".$_GET['item_id']."'");
			
			header("location:../dataverse/home.php?connect=item");
		break;
	}
?>