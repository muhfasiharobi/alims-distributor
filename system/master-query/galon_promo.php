<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_galon_promo();
		break;
		
		case "form-add-galon-promo":
			form_add_galon_promo();
		break;
	
		case "add-galon-promo":
			$product_promo_galon_id = idbaru("product_promo_galon","product_promo_galon_id");
			
			mysql_query("INSERT INTO `product_promo_galon`(`product_promo_galon_id`, `customer_galon_category_id`, `product_sell_id`, `price`, `product_promo_galon_active`) VALUES ('".$product_promo_galon_id."','".$_POST['customer_galon_category_id']."','".$_POST['product_sell_id']."','".$_POST['price']."','1')");
	
			header("location:../system/page_home.php?alimms=galon-promo");	
		break;
	
		case "form-edit-galon-promo":
			form_edit_galon_promo();
		break;
		
		case "edit-galon-promo":
			
			mysql_query("UPDATE `product_promo_galon` SET `customer_galon_category_id`= '".$_POST['customer_galon_category_id']."',`product_sell_id`='".$_POST['product_sell_id']."',`price`='".$_POST['price']."' WHERE `product_promo_galon_id`= '".$_POST['product_promo_galon_id']."'");
		
			header("location:../system/page_home.php?alimms=galon-promo");	
		break;
	
		case "delete-galon-promo":
		
			mysql_query("UPDATE product_promo_galon SET product_promo_galon_active = '0' WHERE product_promo_galon_id = '".$_GET['product_promo_galon_id']."'");
			
			header("location:../system/page_home.php?alimms=galon-promo");	
		break;
	
		case "active-galon-promo":
		
			mysql_query("UPDATE galon_promo SET product_promo_active = '1' WHERE galon_promo_id = '".$_GET['galon_promo_id']."'");
			
			header("location:../system/page_home.php?alimms=galon-promo");	
		break;
	}
?>