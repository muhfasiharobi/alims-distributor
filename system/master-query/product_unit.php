<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_product_unit();
		break;
		
		case "form-add-product-unit":
			form_add_product_unit();
		break;
	
		case "add-product-unit":
			$product_unit_id = idbaru("product_unit","product_unit_id");
			
			mysql_query("INSERT INTO product_unit(product_unit_id, product_unit_name, product_unit_datetime, user_id) VALUES ('".$product_unit_id."', '".$_POST['product_unit_name']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
	
			header("location:../system/page_home.php?alimms=product-unit");	
		break;
	
		case "form-edit-product-unit":
			form_edit_product_unit();
		break;
		
		case "edit-product-unit":
			mysql_query("UPDATE product_unit SET product_unit_name = '".$_POST['product_unit_name']."', product_unit_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE product_unit_id = '".$_POST['product_unit_id']."'");
		
			header("location:../system/page_home.php?alimms=product-unit");	
		break;
	
		case "delete-product-unit":
			mysql_query("UPDATE product_unit SET product_unit_datetime = '".$waktu_sekarang."', product_unit_active = '0', user_id = '".$_SESSION['user_id']."' WHERE product_unit_id = '".$_GET['product_unit_id']."'");
			
			header("location:../system/page_home.php?alimms=product-unit");	
		break;
	}
?>