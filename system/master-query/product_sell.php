<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_product_sell();
		break;
		
		case "form-add-product-sell":
			form_add_product_sell();
		break;
	
		case "add-product-sell":
			$product_sell_id = idbaru("product_sell","product_sell_id");
			
			mysql_query("INSERT INTO product_sell(product_sell_id, product_sell_code, product_sell_name, product_unit_id, product_sell_datetime, user_id) VALUES ('".$product_sell_id."', '".$_POST['product_sell_code']."', '".$_POST['product_sell_name']."', '".$_POST['product_unit_id']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
	
			header("location:../system/page_home.php?alimms=product-sell");	
		break;
	
		case "form-edit-product-sell":
			form_edit_product_sell();
		break;
		
		case "edit-product-sell":
			mysql_query("UPDATE product_sell SET product_sell_code = '".$_POST['product_sell_code']."', product_sell_name = '".$_POST['product_sell_name']."', product_unit_id = '".$_POST['product_unit_id']."', product_sell_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE product_sell_id = '".$_POST['product_sell_id']."'");
		
			header("location:../system/page_home.php?alimms=product-sell");	
		break;
	
		case "delete-product-sell":
			mysql_query("UPDATE product_sell SET product_sell_datetime = '".$waktu_sekarang."', product_sell_active = '0', user_id = '".$_SESSION['user_id']."' WHERE product_sell_id = '".$_GET['product_sell_id']."'");
			
			header("location:../system/page_home.php?alimms=product-sell");	
		break;
		
		case "active-product-sell":
			mysql_query("UPDATE product_sell SET product_sell_datetime = '".$waktu_sekarang."', product_sell_active = '1', user_id = '".$_SESSION['user_id']."' WHERE product_sell_id = '".$_GET['product_sell_id']."'");
			
			header("location:../system/page_home.php?alimms=product-sell");	
		break;
	}
?>