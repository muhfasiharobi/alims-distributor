<?php
	switch($_GET['execute'])
	{
		default:
			default_user_category_platform();
		break;
		
		case "add-user-category-platform":
			add_user_category_platform();
		break;
		
		case "add-user-category":
			$user_category_id = sequence("user_category", "user_category_id");
			
			mysql_query("INSERT INTO user_category(user_category_id, user_category_name, user_category_create, user_category_update, user_activity_id, user_category_active) VALUES ('".$user_category_id."', '".$_POST['user_category_name']."', '".$today."', '".$today."', '".$_SESSION['user_id']."', '1')");
			
			header("location:../dataverse/home.php?connect=user-category");
		break;
		
		case "edit-user-category-platform":
			edit_user_category_platform();
		break;
		
		case "edit-user-category":
			mysql_query("UPDATE user_category SET user_category_name = '".$_POST['user_category_name']."', user_category_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."' WHERE user_category_id = '".$_POST['user_category_id']."'");
			
			header("location:../dataverse/home.php?connect=user-category");
		break;
		
		case "delete-user-category":
			mysql_query("UPDATE user_category SET user_category_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', user_category_active = '0' WHERE user_category_id = '".$_GET['user_category_id']."'");
			
			header("location:../dataverse/home.php?connect=user-category");
		break;
	}
?>