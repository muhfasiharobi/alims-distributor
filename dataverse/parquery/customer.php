<?php
	switch($_GET['execute'])
	{
		default:
			default_customer_platform();
		break;
		
		case "add-customer-platform":
			add_customer_platform();
		break;
		
		case "add-customer":
			$customer_id = sequence("customer", "customer_id");	

			$reseller = mysql_fetch_array(mysql_query("SELECT * FROM reseller WHERE user_id = '".$_SESSION['user_id']."'"));
			
			if($_SESSION['user_category_name'] == "Administrator")
			{
				mysql_query("INSERT INTO `customer`(`customer_id`,`reseller_id`, `customer_code`, `customer_name`, `customer_address`, `customer_village`, `customer_districts`,`customer_city`, `customer_phone`, `customer_create`, `customer_update`, `user_activity_id`, `customer_active`) VALUES ('".$customer_id."','1','".$_POST['customer_code']."','".$_POST['customer_name']."','".$_POST['customer_address']."','".$_POST['customer_village']."','".$_POST['customer_districts']."','".$_POST['customer_city']."','".$_POST['customer_phone']."','".$today."','".$today."','".$_SESSION['user_id']."','1')");
			}
			else
			{
				mysql_query("INSERT INTO `customer`(`customer_id`,`reseller_id`, `customer_code`, `customer_name`, `customer_address`, `customer_village`, `customer_districts`,`customer_city`, `customer_phone`, `customer_create`, `customer_update`, `user_activity_id`, `customer_active`) VALUES ('".$customer_id."','".$reseller['reseller_id']."','".$_POST['customer_code']."','".$_POST['customer_name']."','".$_POST['customer_address']."','".$_POST['customer_village']."','".$_POST['customer_districts']."','".$_POST['customer_city']."','".$_POST['customer_phone']."','".$today."','".$today."','".$_SESSION['user_id']."','1')");
			}
			
			header("location:../dataverse/home.php?connect=customer");
		break;
		
		case "edit-customer-platform":
			edit_customer_platform();
		break;
		
		case "edit-customer":
		
			mysql_query("UPDATE customer SET customer_name = '".$_POST['customer_name']."', customer_address = '".$_POST['customer_address']."',customer_village = '".$_POST['customer_village']."',customer_districts = '".$_POST['customer_districts']."', customer_city = '".$_POST['customer_city']."' WHERE customer_id = '".$_POST['customer_id']."'");
			
			header("location:../dataverse/home.php?connect=customer");
		break;
		
		case "delete-customer":
		
			mysql_query("UPDATE customer SET customer_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', customer_active = '0' WHERE customer_id = '".$_GET['customer_id']."'");
			
			header("location:../dataverse/home.php?connect=customer");
		break;
	}
?>