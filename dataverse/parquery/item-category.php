<?php
	switch($_GET['execute'])
	{
		default:
			default_item_category_platform();
		break;
		
		case "add-item-category-platform":
			add_item_category_platform();
		break;
		
		case "add-item-category":
			$item_category_id = sequence("item_category", "item_category_id");
			
			mysql_query("INSERT INTO item_category(item_category_id, item_category_name, id_label, item_category_create, item_category_update, user_activity_id, item_category_active) VALUES ('".$item_category_id."', '".$_POST['item_category_name']."', '".$_POST['id_label']."','".$today."', '".$today."', '".$_SESSION['user_id']."', '1')");
			
			header("location:../dataverse/home.php?connect=item-category");
		break;
		
		case "edit-item-category-platform":
			edit_item_category_platform();
		break;
		
		case "edit-item-category":
			mysql_query("UPDATE item_category SET item_category_name = '".$_POST['item_category_name']."', id_label = '".$_POST['id_label']."',item_category_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."' WHERE item_category_id = '".$_POST['item_category_id']."'");
			
			header("location:../dataverse/home.php?connect=item-category");
		break;
		
		case "delete-item-category":
			mysql_query("UPDATE item_category SET item_category_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', item_category_active = '0' WHERE item_category_id = '".$_GET['item_category_id']."'");
			
			header("location:../dataverse/home.php?connect=item-category");
		break;
	}
?>