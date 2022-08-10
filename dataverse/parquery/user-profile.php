<?php
	switch($_GET['execute'])
	{
		default:
			default_user_profile_platform();
		break;
		
		case "update-profile":
		    
		    mysql_query("UPDATE user SET user_name = '".$_POST['user_name']."', user_phone = '".$_POST['user_phone']."', user_email = '".$_POST['user_email']."', user_username = '".$_POST['user_username']."' WHERE user_id = '".$_POST['user_id']."'");
		    
		    header("location:../dataverse/home.php?connect=user-profile");
		break;
		
		case "update-password":
		    
		    if($_POST['new-password'] != $_POST['confirm-password'])
		    {
		        echo "<script>alert('Password Tidak Sama!');history.go(-1);</script>";
		    }
		    else
		    {
		        mysql_query("UPDATE user SET user_password = '".md5($_POST['new-password'])."', user_original_password = '".$_POST['new-password']."' WHERE user_id = '".$_POST['user_id']."'");
		    
		        header("location:../dataverse/home.php?connect=user-profile");
		    }
		    
		    
		break;
		
		case "update-foto-profil":
		    
		    // ambil data file
                $namaFile = $_FILES['foto-profil']['name'];
                $namaSementara = $_FILES['foto-profil']['tmp_name'];
                
                // tentukan lokasi file akan dipindahkan
                $dirUpload = "../assets/global/img/";
                
                // pindahkan file
                $terupload = move_uploaded_file($namaSementara, $dirUpload.$namaFile);
                
                mysql_query("UPDATE user SET user_photo = '".$namaFile."' WHERE user_id = '".$_SESSION['user_id']."'");
                
                header("location:../dataverse/home.php?connect=user-profile");
		break;
	}
?>