<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_sales_target();
		break;
	
		case "form-add-sales-target":
			form_add_sales_target();
		break;
	
		case "add-sales-target":
			$sales_target_id = idbaru("sales_target","sales_target_id");
			
			$sales_target_period = explode("-", $_POST['sales_target_period']);
			$month_sales_target = $sales_target_period[0];
			$year_sales_target = $sales_target_period[1];
			$sales_target_period = $year_sales_target.'-'.$month_sales_target;
			
			mysql_query("INSERT INTO sales_target(sales_target_id, salesman_id, sales_target_period, sales_target_value, sales_target_datetime, user_id) VALUES ('".$sales_target_id."', '".$_POST['salesman_id']."', '".$sales_target_period."','".$_POST['sales_target_value']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
			header("location:../system/page_home.php?alimms=sales-target&tib=form-product-sell-sales-target&sales_target_id=".$sales_target_id);	
		break;
		
		case "form-product-sell-sales-target":
			form_product_sell_sales_target();
		break;
		
		case "product-sell-sales-target":
			$sales_target_detail_id = idbaru("sales_target_detail","sales_target_detail_id");
			
			mysql_query("INSERT INTO sales_target_detail(sales_target_detail_id, sales_target_id, product_sell_id, sales_target_detail_product_sell_quantity) VALUES ('".$sales_target_detail_id."', '".$_POST['sales_target_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_target_detail_product_sell_quantity']."')");
			
			header("location:../system/page_home.php?alimms=sales-target&tib=form-product-sell-sales-target&sales_target_id=".$_POST['sales_target_id']);	
		break;
		
		case "remove-sales-target":
			$tbl_sales_target_detail = mysql_query("SELECT sales_target_id FROM sales_target_detail WHERE sales_target_detail_id = '".$_GET['sales_target_detail_id']."'");
			$data_tbl_sales_target_detail = mysql_fetch_array($tbl_sales_target_detail);
										
			mysql_query("DELETE FROM sales_target_detail WHERE sales_target_detail_id = '".$_GET['sales_target_detail_id']."'");
			
			header("location:../system/page_home.php?alimms=sales-target&tib=form-product-sell-sales-target&sales_target_id=".$data_tbl_sales_target_detail['sales_target_id']);	
		break;
	
		case "form-edit-sales-target":
			form_edit_sales_target();
		break;
		
		case "edit-sales-target":
			$sales_target_period = explode("-", $_POST['sales_target_period']);
			$month_sales_target = $sales_target_period[0];
			$year_sales_target = $sales_target_period[1];
			$sales_target_period = $year_sales_target.'-'.$month_sales_target;
			
			mysql_query("UPDATE sales_target SET salesman_id = '".$_POST['salesman_id']."', sales_target_period = '".$sales_target_period."', sales_target_value = '".$_POST['sales_target_value']."', sales_target_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE sales_target_id = '".$_POST['sales_target_id']."'");
			
			
			header("location:../system/page_home.php?alimms=sales-target&tib=form-product-sell-sales-target&sales_target_id=".$_POST['sales_target_id']);
		break;
		
		case "delete-sales-target":
			mysql_query("UPDATE sales_target SET sales_target_datetime = '".$waktu_sekarang."', sales_target_active = '0', user_id = '".$_SESSION['user_id']."' WHERE sales_target_id = '".$_GET['sales_target_id']."'");
			
			header("location:../system/page_home.php?alimms=sales-target");	
		break;
	}
?>