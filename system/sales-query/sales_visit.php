<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_sales_visit();
		break;
		
		case "form-edit-sales-visit":
			form_edit_sales_visit();
		break;
		
		case "edit-sales-visit":
			$jumlah_sales_visit_detail_product_sell_quantity = count($_POST['sales_visit_detail_product_sell_quantity']);
			for($i=0; $i<$jumlah_sales_visit_detail_product_sell_quantity; $i++)
			{
				mysql_query("UPDATE sales_visit_detail SET sales_visit_detail_product_sell_quantity = '".$_POST['sales_visit_detail_product_sell_quantity'][$i]."' WHERE sales_visit_id = '".$_POST['sales_visit_id']."' AND product_sell_id = '".$_POST['product_sell_id'][$i]."'");
			}
			
			$tbl_sales_request = mysql_query("SELECT customer_id FROM sales_request WHERE sales_request_date = '".$_POST['sales_plan_date']."' AND salesman_id = '".$_POST['user_id']."' AND customer_id = '".$_POST['customer_id']."' AND sales_request_order_method = '".$_POST['sales_request_order_method']."'");
			$jumlah_tbl_sales_request = mysql_num_rows($tbl_sales_request);
		
			if ($_POST['sales_visit_status'] == 'Order')
			{
				if ($jumlah_tbl_sales_request > 0)
				{ 
					mysql_query("UPDATE sales_visit SET sales_visit_status = '".$_POST['sales_visit_status']."', sales_visit_description = 'Pelanggan Melakukan Permintaan' WHERE sales_visit_id = '".$_POST['sales_visit_id']."'");
					
					mysql_query("UPDATE sales_request SET sales_request_active = '1' WHERE sales_request_date = '".$_POST['sales_plan_date']."' AND salesman_id = '".$_POST['user_id']."' AND customer_id = '".$_POST['customer_id']."' AND sales_request_order_method = '".$_POST['sales_request_order_method']."'");
					
					header("location:../system/page_home.php?alimms=sales-visit");
				}
				else
				{
					mysql_query("UPDATE sales_visit SET sales_visit_status = '".$_POST['sales_visit_status']."', sales_visit_description = 'Pelanggan Melakukan Permintaan' WHERE sales_visit_id = '".$_POST['sales_visit_id']."'");
					
					header("location:../system/page_home.php?alimms=sales-visit&tib=form-order-sales-visit&sales_visit_id=".$_POST['sales_visit_id']);
				}
			}
			else
			{
				if ($jumlah_tbl_sales_request > 0)
				{ 
					mysql_query("UPDATE sales_visit SET sales_visit_status = '".$_POST['sales_visit_status']."', sales_visit_description = '".$_POST['sales_visit_description']."' WHERE sales_visit_id = '".$_POST['sales_visit_id']."'");
					
					mysql_query("UPDATE sales_request SET sales_request_active = '0' WHERE sales_request_date = '".$_POST['sales_plan_date']."' AND salesman_id = '".$_POST['user_id']."' AND customer_id = '".$_POST['customer_id']."' AND sales_request_order_method = '".$_POST['sales_request_order_method']."'");
				}
				else
				{
					mysql_query("UPDATE sales_visit SET sales_visit_status = '".$_POST['sales_visit_status']."', sales_visit_description = '".$_POST['sales_visit_description']."' WHERE sales_visit_id = '".$_POST['sales_visit_id']."'");
				}
				
				header("location:../system/page_home.php?alimms=sales-visit");
			}
		break;
		
		case "form-order-sales-visit":
			form_order_sales_visit();
		break;
	
		case "order-sales-visit":
			$sales_request_id = idbaru("sales_request","sales_request_id");
			$sales_order_id = idbaru("sales_order","sales_order_id");
			
			$sales_request_delivery_schedule_date = explode("-", $_POST['sales_request_delivery_schedule_date']);
			$date_sales_request_delivery_schedule = $sales_request_delivery_schedule_date[0];
			$month_sales_request_delivery_schedule = $sales_request_delivery_schedule_date[1];
			$year_sales_request_delivery_schedule = $sales_request_delivery_schedule_date[2];
			$sales_request_delivery_schedule_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_request_delivery_schedule, $date_sales_request_delivery_schedule, $year_sales_request_delivery_schedule));
			
			$unique_code = "TIB" . "/" . "SR" . "-" . $thn_sekarang . "/" . $bln_sekarang . "/";
			$tbl_sales_request = mysql_query("SELECT max(sales_request_no) as maxID FROM sales_request WHERE sales_request_no LIKE '$unique_code%'");
			$data_tbl_sales_request = mysql_fetch_array($tbl_sales_request);
			$idMax = $data_tbl_sales_request['maxID'];
			$noUrut = (int) substr($idMax, 15, 4);
			$noUrut++;
			$sales_request_no = $unique_code . sprintf("%04s", $noUrut);
			
			mysql_query("INSERT INTO sales_request(sales_request_id, sales_request_no, sales_request_date, salesman_id, customer_id, sales_request_payment_method, sales_request_order_method, sales_request_delivery_schedule_date, sales_request_product_sell_program_mix, sales_request_datetime, user_id) VALUES ('".$sales_request_id."', '".$sales_request_no."', '".$tgl_sekarang."', '".$_POST['user_id']."', '".$_POST['customer_id']."', '".$_POST['sales_request_payment_method']."', '".$_POST['sales_request_order_method']."', '".$sales_request_delivery_schedule_date."', '".$_POST['sales_request_product_sell_program_mix']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
			
                        mysql_query("INSERT INTO `sales_order`(`sales_order_id`, `sales_request_id`, `sales_order_status`, `sales_order_description`, `sales_order_overdue_day`, `sales_order_datetime`, `user_id`) VALUES ('".$sales_order_id."', '".$sales_request_id."','On Hold','','0','".$waktu_sekarang."','".$_SESSION['user_id']."')");
				
			header("location:../system/page_home.php?alimms=sales-visit&tib=form-product-sell-sales-visit&sales_request_id=".$sales_request_id);	
		break;
		
		case "form-product-sell-sales-visit":
			form_product_sell_sales_visit();
		break;
	
		case "product-sell-sales-visit":
			$sales_request_detail_id = idbaru("sales_request_detail","sales_request_detail_id");
			$sales_order_detail_id = idbaru("sales_order_detail","sales_order_detail_id");
			
			$tbl_sales_request = mysql_query("SELECT a.sales_request_payment_method, a.sales_request_product_sell_program_mix, b.customer_category_id, b.product_sell_price_id, b.customer_product_sell_program_promo, c.customer_city_id FROM sales_request a, customer b, customer_districts c WHERE a.sales_request_id = '".$_POST['sales_request_id']."' AND a.customer_id = b.customer_id AND b.customer_districts_id = c.customer_districts_id");
			$data_tbl_sales_request = mysql_fetch_array($tbl_sales_request);
			
			$tbl_sales_order = mysql_query("SELECT sales_order_id FROM sales_order WHERE sales_request_id = '".$_POST['sales_request_id']."'");
			$data_tbl_sales_order = mysql_fetch_array($tbl_sales_order);
			
			$tbl_product_sell = mysql_query("SELECT product_sell_name FROM product_sell WHERE product_sell_id = '".$_POST['product_sell_id']."'");
			$data_tbl_product_sell = mysql_fetch_array($tbl_product_sell);
			
			$tbl_product_sell_price = mysql_query("SELECT b.product_sell_price_detail_product_sell_price FROM product_sell_price a, product_sell_price_detail b WHERE a.product_sell_price_id = '".$data_tbl_sales_request['product_sell_price_id']."' AND b.product_sell_id = '".$_POST['product_sell_id']."' AND a.product_sell_price_id = b.product_sell_price_id");
			$data_tbl_product_sell_price = mysql_fetch_array($tbl_product_sell_price);
			
			$tbl_product_promo = mysql_query("SELECT product_promo_program_bonus, product_promo_piece_discount, product_promo_cash_discount FROM product_promo WHERE customer_category_id = '".$data_tbl_sales_request['customer_category_id']."' AND product_sell_id = '".$_POST['product_sell_id']."' AND product_promo_purchase_minimum <= '".$_POST['sales_request_detail_product_sell_quantity']."' AND product_promo_purchase_maximum >= '".$_POST['sales_request_detail_product_sell_quantity']."' AND product_promo_expiry_from_date <= '".$tgl_sekarang."' AND product_promo_expiry_to_date >= '".$tgl_sekarang."'");
			$data_tbl_product_promo = mysql_fetch_array($tbl_product_promo);
			
			$product_promo_program_bonus = floor($_POST['sales_request_detail_product_sell_quantity'] / $data_tbl_product_promo['product_promo_program_bonus']);
			
			$product_promo_cash_discount = ($data_tbl_product_promo['product_promo_cash_discount'] / 100) * $data_tbl_product_sell_price['product_sell_price_detail_product_sell_price'];
			
			$tbl_delivery_cost = mysql_query("SELECT delivery_cost_price FROM delivery_cost WHERE customer_city_id = '".$data_tbl_sales_request['customer_city_id']."'");
			$data_tbl_delivery_cost = mysql_fetch_array($tbl_delivery_cost);

if($data_tbl_product_promo['product_promo_piece_discount'] == ''){
$data_tbl_product_promo['product_promo_piece_discount'] = "0";
}

if($data_tbl_delivery_cost['delivery_cost_price'] == ''){
$data_tbl_delivery_cost['delivery_cost_price'] = "0";
}

			
			if ($data_tbl_sales_request['customer_product_sell_program_promo'] == 'Ya')
			{
				if ($data_tbl_sales_request['sales_request_payment_method'] == 'Cash')
				{
					if ($data_tbl_sales_request['sales_request_product_sell_program_mix'] == 'Ya')
					{
						if ($data_tbl_product_sell['product_sell_name'] == 'Cup 220 ml')
						{
							mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
							mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
						}
						elseif ($data_tbl_product_sell['product_sell_name'] == 'Botol 600 ml')
						{
							mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '0', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
							mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."','0', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
						}
						else
						{
							$tbl_sales_request_detail = mysql_query("SELECT a.sales_request_detail_product_sell_quantity FROM sales_request_detail a, product_sell b WHERE a.sales_request_id = '".$_POST['sales_request_id']."' AND b.product_sell_name = 'Botol 600 ml' AND a.product_sell_id = b.product_sell_id");
							$data_tbl_sales_request_detail = mysql_fetch_array($tbl_sales_request_detail);
							
							$product_sell_quantity = $data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] + $_POST['sales_request_detail_product_sell_quantity'];
							
							$tbl_product_promo = mysql_query("SELECT product_promo_program_bonus, product_promo_piece_discount, product_promo_cash_discount FROM product_promo WHERE customer_category_id = '".$data_tbl_sales_request['customer_category_id']."' AND product_sell_id = '".$_POST['product_sell_id']."' AND product_promo_purchase_minimum <= '".$product_sell_quantity."' AND product_promo_purchase_maximum >= '".$product_sell_quantity."' AND product_promo_expiry_from_date <= '".$tgl_sekarang."' AND product_promo_expiry_to_date >= '".$tgl_sekarang."'");
							$data_tbl_product_promo = mysql_fetch_array($tbl_product_promo);
							
							$product_promo_program_bonus = floor($product_sell_quantity / $data_tbl_product_promo['product_promo_program_bonus']);
							
							mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
							mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
						}
					}
					else
					{
						mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
						
						mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
					}
				}
				else
				{
					if ($data_tbl_sales_request['sales_request_product_sell_program_mix'] == 'Ya')
					{
						if ($data_tbl_product_sell['product_sell_name'] == 'Cup 220 ml')
						{

							mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '0', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
							mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '0', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
						}
						elseif ($data_tbl_product_sell['product_sell_name'] == 'Botol 600 ml')
						{
							mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', 0, '".$data_tbl_product_promo['product_promo_piece_discount']."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
							mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', 0, '".$data_tbl_product_promo['product_promo_piece_discount']."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
						}
						else
						{
							$tbl_sales_request_detail = mysql_query("SELECT a.sales_request_detail_product_sell_quantity FROM sales_request_detail a, product_sell b WHERE a.sales_request_id = '".$_POST['sales_request_id']."' AND b.product_sell_name = 'Botol 600 ml' AND a.product_sell_id = b.product_sell_id");
							$data_tbl_sales_request_detail = mysql_fetch_array($tbl_sales_request_detail);
							
							$product_sell_quantity = $data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] + $_POST['sales_request_detail_product_sell_quantity'];
							
							$tbl_product_promo = mysql_query("SELECT product_promo_program_bonus, product_promo_piece_discount, product_promo_cash_discount FROM product_promo WHERE customer_category_id = '".$data_tbl_sales_request['customer_category_id']."' AND product_sell_id = '".$_POST['product_sell_id']."' AND product_promo_purchase_minimum <= '".$product_sell_quantity."' AND product_promo_purchase_maximum >= '".$product_sell_quantity."' AND product_promo_expiry_from_date <= '".$tgl_sekarang."' AND product_promo_expiry_to_date >= '".$tgl_sekarang."'");
							$data_tbl_product_promo = mysql_fetch_array($tbl_product_promo);
							
							$product_promo_program_bonus = floor($product_sell_quantity / $data_tbl_product_promo['product_promo_program_bonus']);
							
							mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', 0, '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
							mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
						}
					}
					else
					{
						mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
						
						mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
					}
				}
			}
			else
			{
				mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', 0, 0, 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
				
				mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', 0, 0, 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
			}
			
			//header("location:../system/page_home.php?alimms=sales-visit&tib=form-product-sell-sales-visit&sales_request_id=".$_POST['sales_request_id']);	
		break;
	
		case "form-view-sales-visit":
			form_view_sales_visit();
		break;
	}
?>