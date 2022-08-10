<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_product_sell_price();
		break;
		
		case "form-add-product-sell-price":
			form_add_product_sell_price();
		break;
	
		case "add-product-sell-price":
			$product_sell_price_id = idbaru("product_sell_price","product_sell_price_id");
			
			mysql_query("INSERT INTO product_sell_price(product_sell_price_id, product_sell_price_name, product_sell_price_datetime, user_id) VALUES ('".$product_sell_price_id."', '".$_POST['product_sell_price_name']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
			
			header("location:../system/page_home.php?alimms=product-sell-price&tib=form-product-sell-product-sell-price&product_sell_price_id=".$product_sell_price_id);	
		break;
		
		case "form-product-sell-product-sell-price":
			form_product_sell_product_sell_price();
		break;
		
		case "product-sell-product-sell-price":
			$product_sell_price_detail_id = idbaru("product_sell_price_detail","product_sell_price_detail_id");
			
			mysql_query("INSERT INTO product_sell_price_detail(product_sell_price_detail_id, product_sell_price_id, product_sell_id, product_sell_price_detail_product_sell_price) VALUES ('".$product_sell_price_detail_id."', '".$_POST['product_sell_price_id']."', '".$_POST['product_sell_id']."', '".$_POST['product_sell_price_detail_product_sell_price']."')");
			
			header("location:../system/page_home.php?alimms=product-sell-price&tib=form-product-sell-product-sell-price&product_sell_price_id=".$_POST['product_sell_price_id']);	
		break;
		
		case "remove-product-sell-price":
			$tbl_product_sell_price_detail = mysql_query("SELECT product_sell_price_id FROM product_sell_price_detail WHERE product_sell_price_detail_id = '".$_GET['product_sell_price_detail_id']."'");
			$data_tbl_product_sell_price_detail = mysql_fetch_array($tbl_product_sell_price_detail);
										
			mysql_query("DELETE FROM product_sell_price_detail WHERE product_sell_price_detail_id = '".$_GET['product_sell_price_detail_id']."'");
			
			header("location:../system/page_home.php?alimms=product-sell-price&tib=form-product-sell-product-sell-price&product_sell_price_id=".$data_tbl_product_sell_price_detail['product_sell_price_id']);	
		break;
	
		case "form-edit-product-sell-price":
			form_edit_product_sell_price();
		break;
		
		case "edit-product-sell-price":
			mysql_query("UPDATE product_sell_price SET product_sell_price_name = '".$_POST['product_sell_price_name']."', product_sell_price_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE product_sell_price_id = '".$_POST['product_sell_price_id']."'");
			
			header("location:../system/page_home.php?alimms=product-sell-price&tib=form-product-sell-product-sell-price&product_sell_price_id=".$_POST['product_sell_price_id']);	
		break;
	
		case "delete-product-sell-price":
			mysql_query("UPDATE product_sell_price SET product_sell_price_datetime = '".$waktu_sekarang."', product_sell_price_active = '0', user_id = '".$_SESSION['user_id']."' WHERE product_sell_price_id = '".$_GET['product_sell_price_id']."'");
			
			header("location:../system/page_home.php?alimms=product-sell-price");	
		break;
	
		case "active-product-sell-price":
			mysql_query("UPDATE product_sell_price SET product_sell_price_datetime = '".$waktu_sekarang."', product_sell_price_active = '1', user_id = '".$_SESSION['user_id']."' WHERE product_sell_price_id = '".$_GET['product_sell_price_id']."'");
			
			header("location:../system/page_home.php?alimms=product-sell-price");	
		break;
	}
?>