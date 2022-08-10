<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_user_category();
		break;
		
		case "form-add-user-category":
			form_add_user_category();
		break;
	
		case "add-user-category":
			$user_category_id = idbaru("user_category","user_category_id");
			
			mysql_query("INSERT INTO user_category(user_category_id, user_category_name, user_department_id, user_category_datetime, user_id) VALUES ('".$user_category_id."', '".$_POST['user_category_name']."', '".$_POST['user_department_id']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
	
			header("location:../system/page_home.php?alimms=user-category");	
		break;
	
		case "form-edit-user-category":
			form_edit_user_category();
		break;
		
		case "edit-user-category":
			mysql_query("UPDATE user_category SET user_category_name = '".$_POST['user_category_name']."', user_department_id = '".$_POST['user_department_id']."', user_category_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE user_category_id = '".$_POST['user_category_id']."'");
		
			header("location:../system/page_home.php?alimms=user-category");	
		break;
	
		case "delete-user-category":
			mysql_query("UPDATE user_category SET user_category_datetime = '".$waktu_sekarang."', user_category_active = '0', user_id = '".$_SESSION['user_id']."' WHERE user_category_id = '".$_GET['user_category_id']."'");
			
			header("location:../system/page_home.php?alimms=user-category");	
		break;
	}
?>