<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_customer_galon_category();
		break;
		
		case "form-add-customer-galon-category":
			form_add_customer_galon_category();
		break;
	
		case "add-customer-galon-category":
			$customer_galon_category_id = idbaru("customer_galon_category","customer_galon_category_id");
			
			mysql_query("INSERT INTO `customer_galon_category`(`customer_galon_category_id`, `customer_galon_category_name`, `customer_galon_category_active`) VALUES ('".$customer_galon_category_id."','".$_POST['customer_galon_category_name']."','1')");
	
			header("location:../system/page_home.php?alimms=customer-galon-category");	
		break;
	
		case "form-edit-customer-galon-category":
			form_edit_customer_galon_category();
		break;
		
		case "edit-customer-galon-category":
			mysql_query("UPDATE `customer_galon_category` SET `customer_galon_category_name`= '".$_POST['customer_galon_category_name']."' WHERE `customer_galon_category_id`= '".$_POST['customer_galon_category_id']."'");
		
			header("location:../system/page_home.php?alimms=customer-galon-category");	
		break;
	
		case "delete-customer-galon-category":
			
			mysql_query("UPDATE customer_galon_category SET customer_galon_category_active = '0' WHERE customer_galon_category_id = '".$_GET['customer_galon_category_id']."'");
			
			header("location:../system/page_home.php?alimms=customer-galon-category");	
		break;
		
		case "active-customer-galon-category":
			mysql_query("UPDATE customer_galon_category SET customer_galon_category_active = '1' WHERE customer_galon_category_id = '".$_GET['customer_galon_category_id']."'");
			
			header("location:../system/page_home.php?alimms=customer-galon-category");	
		break;
	}
?>