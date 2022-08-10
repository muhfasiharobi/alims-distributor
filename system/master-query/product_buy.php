<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_product_buy();
		break;
		
		case "form-add-product-buy":
			form_add_product_buy();
		break;
	
		case "add-product-buy":
			$product_buy_id = idbaru("product_buy","product_buy_id");
			
			mysql_query("INSERT INTO product_buy(product_buy_id, product_buy_name, product_category_id, product_buy_datetime, user_id) VALUES ('".$product_buy_id."', '".$_POST['product_buy_name']."', '".$_POST['product_category_id']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
	
			header("location:../system/page_home.php?alimms=product-buy");	
		break;
	
		case "form-edit-product-buy":
			form_edit_product_buy();
		break;
		
		case "edit-product-buy":
			mysql_query("UPDATE product_buy SET product_buy_name = '".$_POST['product_buy_name']."', product_category_id = '".$_POST['product_category_id']."', product_buy_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE product_buy_id = '".$_POST['product_buy_id']."'");
		
			header("location:../system/page_home.php?alimms=product-buy");	
		break;
	
		case "delete-product-buy":
			mysql_query("UPDATE product_buy SET product_buy_datetime = '".$waktu_sekarang."', product_buy_active = '0', user_id = '".$_SESSION['user_id']."' WHERE product_buy_id = '".$_GET['product_buy_id']."'");
			
			header("location:../system/page_home.php?alimms=product-buy");	
		break;
		
		case "active-product-buy":
			mysql_query("UPDATE product_buy SET product_buy_datetime = '".$waktu_sekarang."', product_buy_active = '1', user_id = '".$_SESSION['user_id']."' WHERE product_buy_id = '".$_GET['product_buy_id']."'");
			
			header("location:../system/page_home.php?alimms=product-buy");	
		break;
	}
?>