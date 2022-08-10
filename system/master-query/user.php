<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_user();
		break;
		
		case "form-add-user":
			form_add_user();
		break;
	
		case "add-user":
			$user_id = idbaru("user","user_id");
				
			$location_file = $_FILES['user_photo']['tmp_name'];
			$type_file = $_FILES['user_photo']['type'];
			$name_file = $_FILES['user_photo']['name'];
			
			$name_file = explode(".", $name_file);
			$ekstension_name_file = $name_file[1];
			
			$random_name_file = $_POST['user_npp'].'.'.$ekstension_name_file;
			$destination_file = '../assets/layouts/layout6/img/user-photo/';
			$upload_file = $destination_file . $random_name_file;
			
			$user_password = md5($_POST['user_password']);

			if (!empty($location_file))
			{
				move_uploaded_file($location_file, $upload_file);
			  
				mysql_query("INSERT INTO user(user_id, user_photo, user_category_id, user_npp, user_name, user_phone, user_email, user_username, user_password, user_datetime, user_active) VALUES ('".$user_id."', '".$random_name_file."', '".$_POST['user_category_id']."', '".$_POST['user_npp']."', '".$_POST['user_name']."', '".$_POST['user_phone']."', '".$_POST['user_email']."', '".$_POST['user_username']."', '".$user_password."', '".$waktu_sekarang."', '1')");


			}
			else
			{
				mysql_query("INSERT INTO user(user_id, user_photo, user_category_id, user_npp, user_name, user_phone, user_email, user_username, user_password, user_datetime, user_active) VALUES ('".$user_id."','', '".$_POST['user_category_id']."', '".$_POST['user_npp']."', '".$_POST['user_name']."', '".$_POST['user_phone']."', '".$_POST['user_email']."', '".$_POST['user_username']."', '".$user_password."', '".$waktu_sekarang."', '1')");

			}
			
			header("location:../system/page_home.php?alimms=user");	
		break;
	
		case "form-edit-user":
			form_edit_user();
		break;
		
		case "edit-user":
			$location_file = $_FILES['user_photo']['tmp_name'];
			$type_file = $_FILES['user_photo']['type'];
			$name_file = $_FILES['user_photo']['name'];
			
			$name_file = explode(".", $name_file);
			$ekstension_name_file = $name_file[1];
			
			$random_name_file = $_POST['user_npp'].'.'.$ekstension_name_file;
			$destination_file = '../assets/layouts/layout6/img/user-photo/';
			$upload_file = $destination_file . $random_name_file;
			
			if (!empty($location_file))
			{
				$tbl_user = mysql_query("SELECT user_photo FROM user WHERE user_id = '".$_POST['user_id']."'");
				$data_tbl_user = mysql_fetch_array($tbl_user);
				
				unlink("../assets/layouts/layout6/img/user-photo/".$data_tbl_user['user_photo']);
				
				move_uploaded_file($location_file, $upload_file);
				
				if ($_POST['user_new_password'] == "")
				{
					mysql_query("UPDATE user SET user_photo = '".$random_name_file."', user_category_id = '".$_POST['user_category_id']."', user_npp = '".$_POST['user_npp']."', user_name = '".$_POST['user_name']."', user_phone = '".$_POST['user_phone']."', user_email = '".$_POST['user_email']."', user_username = '".$_POST['user_username']."', user_datetime = '".$waktu_sekarang."' WHERE user_id = '".$_POST['user_id']."'");
				}
				else
				{
					$user_password = md5($_POST['user_new_password']);
					
					mysql_query("UPDATE user SET user_photo = '".$random_name_file."', user_category_id = '".$_POST['user_category_id']."', user_npp = '".$_POST['user_npp']."', user_name = '".$_POST['user_name']."', user_phone = '".$_POST['user_phone']."', user_email = '".$_POST['user_email']."', user_username = '".$_POST['user_username']."', user_password = '".$user_password."', user_datetime = '".$waktu_sekarang."' WHERE user_id = '".$_POST['user_id']."'");
				}
			}
			else
			{

				if ($_POST['user_new_password'] == "")
				{
					mysql_query("UPDATE user SET user_category_id = '".$_POST['user_category_id']."', user_npp = '".$_POST['user_npp']."', user_name = '".$_POST['user_name']."', user_phone = '".$_POST['user_phone']."', user_email = '".$_POST['user_email']."', user_username = '".$_POST['user_username']."', user_datetime = '".$waktu_sekarang."' WHERE user_id = '".$_POST['user_id']."'");
echo $_POST['user_category_id'];
				}
				else
				{
					$user_password = md5($_POST['user_new_password']);
					
					mysql_query("UPDATE user SET user_category_id = '".$_POST['user_category_id']."', user_npp = '".$_POST['user_npp']."', user_name = '".$_POST['user_name']."', user_phone = '".$_POST['user_phone']."', user_email = '".$_POST['user_email']."', user_username = '".$_POST['user_username']."', user_password = '".$user_password."', user_datetime = '".$waktu_sekarang."' WHERE user_id = '".$_POST['user_id']."'");
				}
			}
			
			header("location:../system/page_home.php?alimms=user");	
		break;
	
		case "delete-user":
			mysql_query("UPDATE user SET user_datetime = '".$waktu_sekarang."', user_active = '0', user_id = '".$_SESSION['user_id']."' WHERE user_id = '".$_GET['user_id']."'");
			
			header("location:../system/page_home.php?alimms=user");	
		break;
	}
?>