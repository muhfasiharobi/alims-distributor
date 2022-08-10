<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_product_promo();
		break;
		
		case "form-add-product-promo":
			form_add_product_promo();
		break;
	
		case "add-product-promo":
			$product_promo_id = idbaru("product_promo","product_promo_id");
			
			$product_promo_expiry_from_date = explode("-", $_POST['product_promo_expiry_from_date']);
			$date_product_promo_expiry_from = $product_promo_expiry_from_date[0];
			$month_product_promo_expiry_from = $product_promo_expiry_from_date[1];
			$year_product_promo_expiry_from = $product_promo_expiry_from_date[2];
			$product_promo_expiry_from_date = date("Y-m-d", mktime(0, 0, 0, $month_product_promo_expiry_from, $date_product_promo_expiry_from, $year_product_promo_expiry_from));
		
			$product_promo_expiry_to_date = explode("-", $_POST['product_promo_expiry_to_date']);
			$date_product_promo_expiry_to = $product_promo_expiry_to_date[0];
			$month_product_promo_expiry_to = $product_promo_expiry_to_date[1];
			$year_product_promo_expiry_to = $product_promo_expiry_to_date[2];
			$product_promo_expiry_to_date = date("Y-m-d", mktime(0, 0, 0, $month_product_promo_expiry_to, $date_product_promo_expiry_to, $year_product_promo_expiry_to));
			
			mysql_query("INSERT INTO product_promo(product_promo_id, customer_category_id, customer_galon_category_id, product_sell_id, product_promo_purchase_minimum, product_promo_purchase_maximum, product_promo_program_bonus, product_promo_piece_discount, product_promo_cash_discount, product_promo_expiry_from_date, product_promo_expiry_to_date, product_promo_datetime, user_id) VALUES ('".$product_promo_id."', '".$_POST['customer_category_id']."','".$_POST['customer_galon_category_id']."', '".$_POST['product_sell_id']."', '".$_POST['product_promo_purchase_minimum']."', '".$_POST['product_promo_purchase_maximum']."', '".$_POST['product_promo_program_bonus']."', '".$_POST['product_promo_piece_discount']."', '".$_POST['product_promo_cash_discount']."', '".$product_promo_expiry_from_date."', '".$product_promo_expiry_to_date."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
	
			header("location:../system/page_home.php?alimms=product-promo");	
		break;
	
		case "form-edit-product-promo":
			form_edit_product_promo();
		break;
		
		case "edit-product-promo":
			$product_promo_expiry_from_date = explode("-", $_POST['product_promo_expiry_from_date']);
			$date_product_promo_expiry_from = $product_promo_expiry_from_date[0];
			$month_product_promo_expiry_from = $product_promo_expiry_from_date[1];
			$year_product_promo_expiry_from = $product_promo_expiry_from_date[2];
			$product_promo_expiry_from_date = date("Y-m-d", mktime(0, 0, 0, $month_product_promo_expiry_from, $date_product_promo_expiry_from, $year_product_promo_expiry_from));
		
			$product_promo_expiry_to_date = explode("-", $_POST['product_promo_expiry_to_date']);
			$date_product_promo_expiry_to = $product_promo_expiry_to_date[0];
			$month_product_promo_expiry_to = $product_promo_expiry_to_date[1];
			$year_product_promo_expiry_to = $product_promo_expiry_to_date[2];
			$product_promo_expiry_to_date = date("Y-m-d", mktime(0, 0, 0, $month_product_promo_expiry_to, $date_product_promo_expiry_to, $year_product_promo_expiry_to));
			
			mysql_query("UPDATE product_promo SET customer_category_id = '".$_POST['customer_category_id']."', product_sell_id = '".$_POST['product_sell_id']."', product_promo_purchase_minimum = '".$_POST['product_promo_purchase_minimum']."', product_promo_purchase_maximum = '".$_POST['product_promo_purchase_maximum']."', product_promo_program_bonus = '".$_POST['product_promo_program_bonus']."', product_promo_piece_discount = '".$_POST['product_promo_piece_discount']."', product_promo_cash_discount = '".$_POST['product_promo_cash_discount']."', product_promo_expiry_from_date = '".$product_promo_expiry_from_date."', product_promo_expiry_to_date = '".$product_promo_expiry_to_date."', product_promo_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE product_promo_id = '".$_POST['product_promo_id']."'");
		
			header("location:../system/page_home.php?alimms=product-promo");	
		break;
	
		case "delete-product-promo":
			mysql_query("UPDATE product_promo SET product_promo_datetime = '".$waktu_sekarang."', product_promo_active = '0', user_id = '".$_SESSION['user_id']."' WHERE product_promo_id = '".$_GET['product_promo_id']."'");
			
			header("location:../system/page_home.php?alimms=product-promo");	
		break;
	
		case "active-product-promo":
			mysql_query("UPDATE product_promo SET product_promo_datetime = '".$waktu_sekarang."', product_promo_active = '1', user_id = '".$_SESSION['user_id']."' WHERE product_promo_id = '".$_GET['product_promo_id']."'");
			
			header("location:../system/page_home.php?alimms=product-promo");	
		break;
	}
?>