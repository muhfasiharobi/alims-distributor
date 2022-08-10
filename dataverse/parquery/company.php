<?php
	switch($_GET['execute'])
	{
		default:
			default_company_platform();
		break;
		
		case "add-company-platform":
			add_company_platform();
		break;
		
		case "add-company":
			$company_id = sequence("company", "company_id");
			
			mysql_query("INSERT INTO `company`(`company_id`, `company_name`, `company_address`, `company_village`, `company_districts`, `company_city`, `company_phone`,`company_email`, `company_account_bank`, `company_account_number`, `company_account_name`, `company_datetime`, `company_active`) VALUES ('".$company_id."','".$_POST['company_name']."','".$_POST['company_address']."','".$_POST['company_village']."','".$_POST['company_districts']."','".$_POST['company_city']."','".$_POST['company_phone']."','".$_POST['company_email']."','".$_POST['company_account_bank']."','".$_POST['company_account_number']."','".$_POST['company_account_name']."','".$today."','1')");
			
			header("location:../dataverse/home.php?connect=company");
		break;
		
		case "edit-company-platform":
			edit_company_platform();
		break;
		
		case "edit-company":
		    
		         // ambil data file
                $namaFile = $_FILES['logo']['name'];
                $namaSementara = $_FILES['logo']['tmp_name'];
                
                // tentukan lokasi file akan dipindahkan
                $dirUpload = "../assets/global/img/";
                
                // pindahkan file
                $terupload = move_uploaded_file($namaSementara, $dirUpload.$namaFile);

		
			    mysql_query("UPDATE company SET company_name = '".$_POST['company_name']."', company_address = '".$_POST['company_address']."', company_village = '".$_POST['company_village']."', company_districts = '".$_POST['company_districts']."', company_city = '".$_POST['company_city']."', company_phone = '".$_POST['company_phone']."',company_email = '".$_POST['company_email']."', company_account_bank = '".$_POST['company_account_bank']."', company_account_number = '".$_POST['company_account_number']."', company_account_name = '".$_POST['company_account_name']."', company_logo = '".$namaFile."', company_datetime = '".$today."' WHERE company_id = '".$_POST['company_id']."'");
			
			header("location:../dataverse/home.php?connect=company");
		break;
		
		case "delete-company":
		
			mysql_query("UPDATE company SET company_active = '0' WHERE company_id = '".$_GET['company_id']."'");
			
			header("location:../dataverse/home.php?connect=company");
		break;
	}
?>