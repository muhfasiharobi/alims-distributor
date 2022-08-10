<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_sales_request_galon();
		break;
		
		case "form-add-sales-request-galon":
			form_add_sales_request_galon();
		break;
		
		case "form-product-sell-sales-request-galon":
			form_product_sell_sales_request_galon();
		break;
	
		case "add-sales-request-galon":
			$sales_request_id = idbaru("sales_request","sales_request_id");
			$sales_order_id = idbaru("sales_order","sales_order_id");
			$sales_request_delivery_schedule_date = date('Y-m-d');
			
			$unique_code = "TIB" . "/" . "SR" . "-" . $thn_sekarang . "/" . $bln_sekarang . "/";
			$tbl_sales_request = mysql_query("SELECT max(sales_request_no) as maxID FROM sales_request WHERE sales_request_no LIKE '$unique_code%'");
			$data_tbl_sales_request = mysql_fetch_array($tbl_sales_request);
			$idMax = $data_tbl_sales_request['maxID'];
			$noUrut = (int) substr($idMax, 15, 4);
			$noUrut++;
			$sales_request_no = $unique_code . sprintf("%04s", $noUrut);
			
			mysql_query("INSERT INTO sales_request(sales_request_id, sales_request_no, sales_request_date, salesman_id, customer_id, sales_request_payment_method, sales_request_order_method, sales_request_delivery_schedule_date, sales_request_product_sell_program_mix, sales_request_datetime, user_id) VALUES ('".$sales_request_id."', '".$sales_request_no."', '".$tgl_sekarang."', '".$_POST['salesman_id']."', '".$_POST['customer_id']."', 'Cash', '".$_POST['sales_request_order_method']."', '".$sales_request_delivery_schedule_date."', 'Ya', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");

            mysql_query("INSERT INTO `sales_order`(`sales_order_id`, `sales_request_id`, `sales_order_status`, `sales_order_description`, `sales_order_overdue_day`, `sales_order_datetime`, `user_id`) VALUES ('".$sales_order_id."', '".$sales_request_id."','On Hold','','0','".$waktu_sekarang."','".$_SESSION['user_id']."')");
			
				
			header("location:../system/page_home.php?alimms=sales-request-galon&tib=form-product-sell-sales-request-galon&sales_request_id=".$sales_request_id);	
		break;
		
		case "product-sell-sales-request-galon":
		
			$sales_request_detail_id = idbaru("sales_request_detail","sales_request_detail_id");
			$sales_order_detail_id = idbaru("sales_order_detail","sales_order_detail_id");
			
			$tbl_transaction_galon = mysql_query("SELECT transaction_galon_id FROM transaction_galon WHERE transaction_galon_name = '".$_POST['sales_request_payment_method']."'");
			$data_tbl_transaction_galon = mysql_fetch_array($tbl_transaction_galon);
			
			$tbl_sales_request = mysql_query("SELECT * FROM sales_request a, customer b WHERE a.sales_request_id = '".$_POST['sales_request_id']."' AND a.customer_id = b.customer_id");
			$data_tbl_sales_request = mysql_fetch_array($tbl_sales_request);
			
			$tbl_product_promo_galon = mysql_query("SELECT * FROM product_promo_galon WHERE customer_galon_category_id = '".$data_tbl_sales_request['customer_galon_category_id']."' AND transaction_galon_id = '".$data_tbl_transaction_galon['transaction_galon_id']."'");
			$data_tbl_product_promo_galon = mysql_fetch_array($tbl_product_promo_galon);
			
			$product_sell_price = $data_tbl_product_promo_galon['galon_price'] + $data_tbl_product_promo_galon['refill_price'];
			
			if($data_tbl_transaction_galon['transaction_galon_id'] == 1){
			
				if($data_tbl_sales_request['selling_program_galon_id'] == '2'){
					$product_quantity_extra = $_POST['sales_request_detail_product_sell_quantity'] / 1;
				} else if($data_tbl_sales_request['selling_program_galon_id'] == '3'){
					$product_quantity_extra = floor($_POST['sales_request_detail_product_sell_quantity'] / 2);
				} else if($data_tbl_sales_request['selling_program_galon_id'] == '4'){
					$product_quantity_extra = floor($_POST['sales_request_detail_product_sell_quantity'] / 3);
				} else {
					$product_quantity_extra = 0;
				}
			
			}
			
			$tbl_sales_order = mysql_query("SELECT sales_order_id FROM sales_order WHERE sales_request_id = '".$_POST['sales_request_id']."'");
			$data_tbl_sales_order = mysql_fetch_array($tbl_sales_order);
			
			mysql_query("INSERT INTO `sales_request_detail`(`sales_request_detail_id`, `sales_request_id`, `product_sell_id`, `product_promo_galon_id`, `sales_request_detail_product_sell_quantity`, `sales_request_detail_product_sell_price`, `sales_request_detail_program_bonus`, `sales_request_detail_piece_discount`, `sales_request_detail_cash_discount`, `sales_request_detail_delivery_cost_price`) VALUES ('".$sales_request_detail_id."','".$_POST['sales_request_id']."','4','".$data_tbl_product_promo_galon['product_promo_galon_id']."','".$_POST['sales_request_detail_product_sell_quantity']."','".$product_sell_price."','".$product_quantity_extra."','0','0','0')");
			
			mysql_query("INSERT INTO `sales_order_detail`(`sales_order_detail_id`, `sales_order_id`, `sales_request_detail_id`, `product_sell_id`, `sales_order_detail_product_sell_quantity`, `sales_order_detail_product_sell_price`, `sales_order_detail_program_bonus`, `sales_order_detail_piece_discount`, `sales_order_detail_cash_discount`, `sales_order_detail_delivery_cost_price`) VALUES ('".$sales_order_detail_id."','".$data_tbl_sales_order['sales_order_id']."','".$sales_request_detail_id."','4','".$_POST['sales_request_detail_product_sell_quantity']."','".$product_sell_price."','".$product_quantity_extra."','0','0','0')");
			
			header("location:../system/page_home.php?alimms=sales-request-galon&tib=form-product-sell-sales-request-galon&sales_request_id=".$_POST['sales_request_id']);
		break;
		
		case "remove-product-sell-sales-request-galon":
			$tbl_sales_request_detail = mysql_query("SELECT * FROM sales_request_detail WHERE sales_request_detail_id = '".$_GET['sales_request_detail_id']."'");
			$data_tbl_sales_request_detail = mysql_fetch_array($tbl_sales_request_detail);
										
			mysql_query("DELETE FROM sales_request_detail WHERE sales_request_detail_id = '".$_GET['sales_request_detail_id']."'");
			
			mysql_query("DELETE FROM sales_order_detail WHERE sales_request_detail_id = '".$_GET['sales_request_detail_id']."'");
			
			header("location:../system/page_home.php?alimms=sales-request-galon&tib=form-product-sell-sales-request-galon&sales_request_id=".$data_tbl_sales_request_detail['sales_request_id']);	
		break;
		
		case "form-edit-sales-request-galon":
			form_edit_sales_request_galon();
		break;
		
		case "edit-sales-request-galon":
			
			mysql_query("UPDATE `sales_request` SET `salesman_id`= '".$_POST['salesman_id']."',`customer_id`= '".$_POST['customer_id']."',`sales_request_order_method`= '".$_POST['sales_request_order_method']."' WHERE sales_request_id = '".$_POST['sales_request_id']."'");
			header("location:../system/page_home.php?alimms=sales-request-galon&tib=form-product-sell-sales-request-galon&sales_request_id=".$_POST['sales_request_id']);
		break;
		
		case "form-view-sales-request-galon":
			form_view_sales_request_galon();
		break;
		
		case "delete-sales-request-galon":
			mysql_query("UPDATE sales_request SET sales_request_status = 'Canceled', sales_request_datetime = '".$waktu_sekarang."', sales_request_active = '0', user_id = '".$_SESSION['user_id']."' WHERE sales_request_id = '".$_GET['sales_request_id']."'");
			
			mysql_query("UPDATE sales_order SET sales_order_status = 'Canceled', sales_order_description = 'Pesanan Dibatalkan', sales_order_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE sales_request_id = '".$_GET['sales_request_id']."'");
			
			header("location:../system/page_home.php?alimms=sales-request-galon");	
		break;
		
		case "update-program-customer":
			
			mysql_query("UPDATE customer SET selling_program_galon_id = '1' WHERE customer_id = '".$_GET['customer_id']."'");
			
			header("location:../system/page_home.php?alimms=sales-request-galon");
		
		break;
	}
?>