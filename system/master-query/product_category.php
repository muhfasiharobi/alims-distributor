<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_product_category();
		break;
		
		case "form-add-product-category":
			form_add_product_category();
		break;
	
		case "add-product-category":
			$product_category_id = idbaru("product_category","product_category_id");
			
			mysql_query("INSERT INTO product_category(product_category_id, product_category_name, product_category_datetime, user_id) VALUES ('".$product_category_id."', '".$_POST['product_category_name']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
	
			header("location:../system/page_home.php?alimms=product-category");	
		break;
	
		case "form-edit-product-category":
			form_edit_product_category();
		break;
		
		case "edit-product-category":
			mysql_query("UPDATE product_category SET product_category_name = '".$_POST['product_category_name']."', product_category_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE product_category_id = '".$_POST['product_category_id']."'");
		
			header("location:../system/page_home.php?alimms=product-category");	
		break;
	
		case "delete-product-category":
			mysql_query("UPDATE product_category SET product_category_datetime = '".$waktu_sekarang."', product_category_active = '0', user_id = '".$_SESSION['user_id']."' WHERE product_category_id = '".$_GET['product_category_id']."'");
			
			header("location:../system/page_home.php?alimms=product-category");	
		break;
	
		case "active-product-category":
			mysql_query("UPDATE product_category SET product_category_datetime = '".$waktu_sekarang."', product_category_active = '1', user_id = '".$_SESSION['user_id']."' WHERE product_category_id = '".$_GET['product_category_id']."'");
			
			header("location:../system/page_home.php?alimms=product-category");	
		break;
	}
?>