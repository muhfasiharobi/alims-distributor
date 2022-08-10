<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_user_department();
		break;
		
		case "form-add-user-department":
			form_add_user_department();
		break;
	
		case "add-user-department":
			$user_department_id = idbaru("user_department","user_department_id");
			
			mysql_query("INSERT INTO user_department(user_department_id, user_department_name, user_department_datetime, user_id) VALUES ('".$user_department_id."', '".$_POST['user_department_name']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
	
			header("location:../system/page_home.php?alimms=user-department");	
		break;
	
		case "form-edit-user-department":
			form_edit_user_department();
		break;
		
		case "edit-user-department":
			mysql_query("UPDATE user_department SET user_department_name = '".$_POST['user_department_name']."', user_department_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE user_department_id = '".$_POST['user_department_id']."'");
		
			header("location:../system/page_home.php?alimms=user-department");	
		break;
	
		case "delete-user-department":
			mysql_query("UPDATE user_department SET user_department_datetime = '".$waktu_sekarang."', user_department_active = '0', user_id = '".$_SESSION['user_id']."' WHERE user_department_id = '".$_GET['user_department_id']."'");
			
			header("location:../system/page_home.php?alimms=user-department");	
		break;
	}
?>