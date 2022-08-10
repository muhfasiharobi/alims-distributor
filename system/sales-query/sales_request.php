<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_sales_request();
		break;
		
		case "form-add-sales-request":
			form_add_sales_request();
		break;
	
		case "add-sales-request":
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
			mysql_query("INSERT INTO sales_request(sales_request_id, sales_request_no, sales_request_date, salesman_id, customer_id, sales_request_payment_method, sales_request_order_method, sales_request_delivery_schedule_date, sales_request_product_sell_program_mix, sales_request_datetime, user_id) VALUES ('".$sales_request_id."', '".$sales_request_no."', '".$tgl_sekarang."', '".$_POST['salesman_id']."', '".$_POST['customer_id']."', '".$_POST['sales_request_payment_method']."', '".$_POST['sales_request_order_method']."', '".$sales_request_delivery_schedule_date."', '".$_POST['sales_request_product_sell_program_mix']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");

            mysql_query("INSERT INTO `sales_order`(`sales_order_id`, `sales_request_id`, `sales_order_status`, `sales_order_description`, `sales_order_overdue_day`, `sales_order_datetime`, `user_id`) VALUES ('".$sales_order_id."', '".$sales_request_id."','On Hold','','0','".$waktu_sekarang."','".$_SESSION['user_id']."')");
				
			header("location:../system/page_home.php?alimms=sales-request&tib=form-product-sell-sales-request&sales_request_id=".$sales_request_id);	
		break;
		
		case "form-product-sell-sales-request":
			form_product_sell_sales_request();
		break;
		
		case "product-sell-sales-request":
			$sales_request_detail_id = idbaru("sales_request_detail","sales_request_detail_id");
			$sales_order_detail_id = idbaru("sales_order_detail","sales_order_detail_id");
			
			$tbl_sales_request = mysql_query("SELECT a.sales_request_payment_method, a.sales_request_product_sell_program_mix, b.customer_category_id, b.product_sell_price_id, b.customer_product_sell_program_promo, c.customer_city_id, b.customer_type_id, b.customer_id FROM sales_request a, customer b, customer_districts c WHERE a.sales_request_id = '".$_POST['sales_request_id']."' AND a.customer_id = b.customer_id AND b.customer_districts_id = c.customer_districts_id");
			$data_tbl_sales_request = mysql_fetch_array($tbl_sales_request);
			
			 $tbl_customer_category = mysql_query("SELECT customer_category_name FROM customer_category WHERE customer_category_id = '".$data_tbl_sales_request['customer_category_id']."'");
			$data_tbl_customer_category = mysql_fetch_array($tbl_customer_category);
			
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
			
			$tbl_customer_type = mysql_query("SELECT * FROM customer_type WHERE customer_type_id = '".$data_tbl_sales_request['customer_type_id']."'");
			$data_tbl_customer_type = mysql_fetch_array($tbl_customer_type);
			
			$tbl_galon_promo = mysql_query("SELECT * FROM galon_promo WHERE product_sell_id = '".$_POST['product_sell_id']."' AND customer_type_id = '".$data_tbl_customer_type['customer_type_id']."' AND product_promo_purchase_minimum <= '".$_POST['sales_request_detail_product_sell_quantity']."' AND product_promo_purchase_maximum >= '".$_POST['sales_request_detail_product_sell_quantity']."' AND product_promo_expiry_from_date <= '".$tgl_sekarang."' AND product_promo_expiry_to_date >= '".$tgl_sekarang."'");
			$data_tbl_galon_promo = mysql_fetch_array($tbl_galon_promo);
			 
			$tbl_product_galon_sell_price = mysql_query("SELECT * FROM product_sell_price a, product_sell_price_detail b WHERE a.product_sell_price_id = b.product_sell_price_id AND a.product_sell_price_name = '".$data_tbl_customer_type['customer_type_name']."' AND b.product_sell_id = '".$_POST['product_sell_id']."'");
			$data_tbl_product_galon_sell_price = mysql_fetch_array($tbl_product_galon_sell_price);
			

                        if($data_tbl_product_promo['product_promo_piece_discount'] == ''){
                           $data_tbl_product_promo['product_promo_piece_discount'] = "0";
                        }

                        if($data_tbl_delivery_cost['delivery_cost_price'] == ''){
                           $data_tbl_delivery_cost['delivery_cost_price'] = "0";
                        }

                        if($product_promo_cash_discount == ''){
                           $product_promo_cash_discount = "0";
                        }
		
		
		if($data_tbl_product_sell['product_sell_name'] == 'Galon 19 Ltr' || $data_tbl_product_sell['product_sell_name'] == 'Refill')
		{
		
			$sales_request_detail_id = idbaru("sales_request_detail","sales_request_detail_id");
			$sales_order_detail_id = idbaru("sales_order_detail","sales_order_detail_id");
			
			
			$tbl_sales_request = mysql_query("SELECT * FROM sales_request a, customer b WHERE a.sales_request_id = '".$_POST['sales_request_id']."' AND a.customer_id = b.customer_id");
			$data_tbl_sales_request = mysql_fetch_array($tbl_sales_request);
			
			$tbl_product_promo_galon = mysql_query("SELECT * FROM product_promo_galon  WHERE customer_galon_category_id = '".$data_tbl_sales_request['customer_galon_category_id']."'  AND product_sell_id = '".$_POST['product_sell_id']."' AND product_promo_galon_active = '1'");
			$data_tbl_product_promo_galon = mysql_fetch_array($tbl_product_promo_galon);
			
			if($data_tbl_product_sell['product_sell_name'] == 'Galon 19 Ltr'){
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
			
			mysql_query("INSERT INTO `sales_request_detail`(`sales_request_detail_id`, `sales_request_id`, `product_sell_id`, `sales_request_detail_product_sell_quantity`, `sales_request_detail_product_sell_price`, `sales_request_detail_program_bonus`, `sales_request_detail_piece_discount`, `sales_request_detail_cash_discount`, `sales_request_detail_delivery_cost_price`) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."','".$data_tbl_product_promo_galon['price']."', '".$product_quantity_extra."', '0', '0', '0')");
								
			mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_promo_galon['price']."','".$product_quantity_extra."', '0', '0', '0')");
			
			
		}
		else
		{
		
			if ($data_tbl_sales_request['customer_product_sell_program_promo'] == 'Ya')
			{

				if ($data_tbl_sales_request['sales_request_payment_method'] == 'Cash')
				{
					if ($data_tbl_sales_request['sales_request_product_sell_program_mix'] == 'Ya')
					{
						if ($data_tbl_product_sell['product_sell_name'] == 'Cup 220 ml')
						{
							if ($data_tbl_customer_category['customer_category_name'] == 'Grosir Kota')
							{
							
								$product_promo_piece_discount = $data_tbl_product_promo['product_promo_piece_discount'] + 500;
								
								mysql_query("INSERT INTO `sales_request_detail`(`sales_request_detail_id`, `sales_request_id`, `product_sell_id`, `sales_request_detail_product_sell_quantity`, `sales_request_detail_product_sell_price`, `sales_request_detail_program_bonus`, `sales_request_detail_piece_discount`, `sales_request_detail_cash_discount`, `sales_request_detail_delivery_cost_price`) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."','".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$product_promo_piece_discount."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
								
								mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."','".$product_promo_program_bonus."', '".$product_promo_piece_discount."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
							} 
							else
							{
								
								mysql_query("INSERT INTO `sales_request_detail`(`sales_request_detail_id`, `sales_request_id`, `product_sell_id`, `sales_request_detail_product_sell_quantity`, `sales_request_detail_product_sell_price`, `sales_request_detail_program_bonus`, `sales_request_detail_piece_discount`, `sales_request_detail_cash_discount`, `sales_request_detail_delivery_cost_price`) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."','".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
								mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."','".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
								
							}
						}
						elseif ($data_tbl_product_sell['product_sell_name'] == 'Botol 600 ml')
						{ 

							$tbl_sales_request_detail = mysql_query("SELECT a.sales_request_detail_product_sell_quantity, a.sales_request_detail_id FROM sales_request_detail a, product_sell b WHERE a.sales_request_id = '".$_POST['sales_request_id']."' AND b.product_sell_name = 'Botol 1500 ml' AND a.product_sell_id = b.product_sell_id");
							$data_tbl_sales_request_detail = mysql_fetch_array($tbl_sales_request_detail);
							
							$product_sell_quantity = $data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] + $_POST['sales_request_detail_product_sell_quantity'];
							
							$tbl_product_promo = mysql_query("SELECT product_promo_program_bonus, product_promo_piece_discount, product_promo_cash_discount FROM product_promo WHERE customer_category_id = '".$data_tbl_sales_request['customer_category_id']."' AND product_sell_id = '".$_POST['product_sell_id']."' AND product_promo_purchase_minimum <= '".$product_sell_quantity."' AND product_promo_purchase_maximum >= '".$product_sell_quantity."' AND product_promo_expiry_from_date <= '".$tgl_sekarang."' AND product_promo_expiry_to_date >= '".$tgl_sekarang."'");
							$data_tbl_product_promo = mysql_fetch_array($tbl_product_promo);
							
                                                        if ($data_tbl_product_promo['product_promo_piece_discount'] == ''){
                                                          $data_tbl_product_promo['product_promo_piece_discount'] = "0";
                                                         }

                                                        if ($data_tbl_delivery_cost['delivery_cost_price'] == ''){
                                                          $data_tbl_delivery_cost['delivery_cost_price'] = "0";
                                                        }

                                                        if ($product_promo_cash_discount == ''){
                                                          $product_promo_cash_discount = "0";
                                                        }

							mysql_query("UPDATE sales_request_detail SET sales_request_detail_piece_discount = '".$data_tbl_product_promo['product_promo_piece_discount']."' WHERE sales_request_id = '".$_POST['sales_request_id']."' AND product_sell_id = '3'");

                                                        mysql_query("UPDATE sales_order_detail SET sales_order_detail_piece_discount = '".$data_tbl_product_promo['product_promo_piece_discount']."' WHERE sales_request_detail_id='".$data_tbl_sales_request_detail['sales_request_detail_id']."'");
							
							mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', 0, '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
							mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', 0, '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
						}
						else
						{
							$tbl_sales_request_detail = mysql_query("SELECT a.sales_request_detail_product_sell_quantity, a.sales_request_detail_id FROM sales_request_detail a, product_sell b WHERE a.sales_request_id = '".$_POST['sales_request_id']."' AND b.product_sell_name = 'Botol 600 ml' AND a.product_sell_id = b.product_sell_id");
							$data_tbl_sales_request_detail = mysql_fetch_array($tbl_sales_request_detail);
							
							$product_sell_quantity = $data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] + $_POST['sales_request_detail_product_sell_quantity'];
							
							$tbl_product_promo = mysql_query("SELECT product_promo_program_bonus, product_promo_piece_discount, product_promo_cash_discount FROM product_promo WHERE customer_category_id = '".$data_tbl_sales_request['customer_category_id']."' AND product_sell_id = '".$_POST['product_sell_id']."' AND product_promo_purchase_minimum <= '".$product_sell_quantity."' AND product_promo_purchase_maximum >= '".$product_sell_quantity."' AND product_promo_expiry_from_date <= '".$tgl_sekarang."' AND product_promo_expiry_to_date >= '".$tgl_sekarang."'");
							$data_tbl_product_promo = mysql_fetch_array($tbl_product_promo);
							
							$product_promo_program_bonus = floor($product_sell_quantity / $data_tbl_product_promo['product_promo_program_bonus']);

                                                        if ($data_tbl_product_promo['product_promo_piece_discount'] == ''){
                                                          $data_tbl_product_promo['product_promo_piece_discount'] = "0";
                                                         }

                                                        if ($data_tbl_delivery_cost['delivery_cost_price'] == ''){
                                                          $data_tbl_delivery_cost['delivery_cost_price'] = "0";
                                                        }

                                                        if ($product_promo_cash_discount == ''){
                                                          $product_promo_cash_discount = "0";
                                                        }
							
							mysql_query("UPDATE sales_request_detail SET sales_request_detail_piece_discount = '".$data_tbl_product_promo['product_promo_piece_discount']."' WHERE sales_request_id = '".$_POST['sales_request_id']."' AND product_sell_id = '2'");

                                                        mysql_query("UPDATE sales_order_detail SET sales_order_detail_piece_discount = '".$data_tbl_product_promo['product_promo_piece_discount']."' WHERE sales_request_detail_id='".$data_tbl_sales_request_detail['sales_request_detail_id']."'");
							
							mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
							mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
						}
					}
					else // BUKAN PROGRAM MIX
					{
						if ($data_tbl_product_sell['product_sell_name'] == 'Cup 220 ml')
						{
							if ($data_tbl_customer_category['customer_category_name'] == 'Grosir Kota')
							{
							
								$product_promo_piece_discount = $data_tbl_product_promo['product_promo_piece_discount'] + 500;
								
								mysql_query("INSERT INTO `sales_request_detail`(`sales_request_detail_id`, `sales_request_id`, `product_sell_id`, `sales_request_detail_product_sell_quantity`, `sales_request_detail_product_sell_price`, `sales_request_detail_program_bonus`, `sales_request_detail_piece_discount`, `sales_request_detail_cash_discount`, `sales_request_detail_delivery_cost_price`) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."','".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$product_promo_piece_discount."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
								
								mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."','".$product_promo_program_bonus."', '".$product_promo_piece_discount."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
							} 
							else
							{
								mysql_query("INSERT INTO `sales_request_detail`(`sales_request_detail_id`, `sales_request_id`, `product_sell_id`, `sales_request_detail_product_sell_quantity`, `sales_request_detail_product_sell_price`, `sales_request_detail_program_bonus`, `sales_request_detail_piece_discount`, `sales_request_detail_cash_discount`, `sales_request_detail_delivery_cost_price`) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."','".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
								mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."','".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
								
							}
						}
						mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
						
						mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
					}
				}
				else //CREDIT
				{
					if ($data_tbl_sales_request['sales_request_product_sell_program_mix'] == 'Ya')
					{
						if ($data_tbl_product_sell['product_sell_name'] == 'Cup 220 ml')
						{
							if ($data_tbl_customer_category['customer_category_name'] == 'Grosir Kota')
							{
							
								$product_promo_piece_discount = $data_tbl_product_promo['product_promo_piece_discount'] + 250;
								
								mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$product_promo_piece_discount."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
								mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$product_promo_piece_discount."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");	
							
							} 
							else
							{
							
								mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
								
								mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
							}
						}
						elseif ($data_tbl_product_sell['product_sell_name'] == 'Botol 600 ml')
						{

                                                        $tbl_sales_request_detail = mysql_query("SELECT a.sales_request_detail_product_sell_quantity, a.sales_request_detail_id FROM sales_request_detail a, product_sell b WHERE a.sales_request_id = '".$_POST['sales_request_id']."' AND b.product_sell_name = 'Botol 1500 ml' AND a.product_sell_id = b.product_sell_id");
							$data_tbl_sales_request_detail = mysql_fetch_array($tbl_sales_request_detail);
							
							$product_sell_quantity = $data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] + $_POST['sales_request_detail_product_sell_quantity'];
							
							$tbl_product_promo = mysql_query("SELECT product_promo_program_bonus, product_promo_piece_discount, product_promo_cash_discount FROM product_promo WHERE customer_category_id = '".$data_tbl_sales_request['customer_category_id']."' AND product_sell_id = '".$_POST['product_sell_id']."' AND product_promo_purchase_minimum <= '".$product_sell_quantity."' AND product_promo_purchase_maximum >= '".$product_sell_quantity."' AND product_promo_expiry_from_date <= '".$tgl_sekarang."' AND product_promo_expiry_to_date >= '".$tgl_sekarang."'");
							$data_tbl_product_promo = mysql_fetch_array($tbl_product_promo);
							
                                                        if ($data_tbl_product_promo['product_promo_piece_discount'] == ''){
                                                          $data_tbl_product_promo['product_promo_piece_discount'] = "0";
                                                         }

                                                        if ($data_tbl_delivery_cost['delivery_cost_price'] == ''){
                                                          $data_tbl_delivery_cost['delivery_cost_price'] = "0";
                                                        }

                                                        if ($product_promo_cash_discount == ''){
                                                          $product_promo_cash_discount = "0";
                                                        }

							mysql_query("UPDATE sales_request_detail SET sales_request_detail_piece_discount = '".$data_tbl_product_promo['product_promo_piece_discount']."' WHERE sales_request_id = '".$_POST['sales_request_id']."' AND product_sell_id = '3'");

                                                       mysql_query("UPDATE sales_order_detail SET sales_order_detail_piece_discount = '".$data_tbl_product_promo['product_promo_piece_discount']."' WHERE sales_request_detail_id='".$data_tbl_sales_request_detail['sales_request_detail_id']."'");

							mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', 0, '".$data_tbl_product_promo['product_promo_piece_discount']."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
							mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', 0, '".$data_tbl_product_promo['product_promo_piece_discount']."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
						}
						else
						{
							$tbl_sales_request_detail = mysql_query("SELECT a.sales_request_detail_product_sell_quantity, a.sales_request_detail_id FROM sales_request_detail a, product_sell b WHERE a.sales_request_id = '".$_POST['sales_request_id']."' AND b.product_sell_name = 'Botol 600 ml' AND a.product_sell_id = b.product_sell_id");
							$data_tbl_sales_request_detail = mysql_fetch_array($tbl_sales_request_detail);
							
							$product_sell_quantity = $data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] + $_POST['sales_request_detail_product_sell_quantity'];
							
							$tbl_product_promo = mysql_query("SELECT product_promo_program_bonus, product_promo_piece_discount, product_promo_cash_discount FROM product_promo WHERE customer_category_id = '".$data_tbl_sales_request['customer_category_id']."' AND product_sell_id = '".$_POST['product_sell_id']."' AND product_promo_purchase_minimum <= '".$product_sell_quantity."' AND product_promo_purchase_maximum >= '".$product_sell_quantity."' AND product_promo_expiry_from_date <= '".$tgl_sekarang."' AND product_promo_expiry_to_date >= '".$tgl_sekarang."'");
							$data_tbl_product_promo = mysql_fetch_array($tbl_product_promo);
							
							$product_promo_program_bonus = floor($product_sell_quantity / $data_tbl_product_promo['product_promo_program_bonus']);

                                                        if ($data_tbl_product_promo['product_promo_piece_discount'] == ''){
                                                          $data_tbl_product_promo['product_promo_piece_discount'] = "0";
                                                         }

                                                        if ($data_tbl_delivery_cost['delivery_cost_price'] == ''){
                                                          $data_tbl_delivery_cost['delivery_cost_price'] = "0";
                                                        }

                                                        if ($product_promo_cash_discount == ''){
                                                          $product_promo_cash_discount = "0";
                                                        }

                                                        mysql_query("UPDATE sales_request_detail SET sales_request_detail_piece_discount = '".$data_tbl_product_promo['product_promo_piece_discount']."' WHERE sales_request_id = '".$_POST['sales_request_id']."' AND product_sell_id = '2'");

                                                        mysql_query("UPDATE sales_order_detail SET sales_order_detail_piece_discount = '".$data_tbl_product_promo['product_promo_piece_discount']."' WHERE sales_request_detail_id='".$data_tbl_sales_request_detail['sales_request_detail_id']."'");
							
							mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
							mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
						}
					}
					else
					{
						if ($data_tbl_product_sell['product_sell_name'] == 'Cup 220 ml')
						{
							if ($data_tbl_customer_category['customer_category_name'] == 'Grosir Kota')
							{
							
								$product_promo_piece_discount = $data_tbl_product_promo['product_promo_piece_discount'] + 250;
								
								mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$product_promo_piece_discount."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
								mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$product_promo_piece_discount."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");	
							
							} 
							else
							{
							
								mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
								
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
			}
			else
			{

				mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$_POST['sales_request_id']."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', 0, 0, 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
				
				mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id']."', '".$_POST['sales_request_detail_product_sell_quantity']."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', 0, 0, 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
			}
	}
			header("location:../system/page_home.php?alimms=sales-request&tib=form-product-sell-sales-request&sales_request_id=".$_POST['sales_request_id']);	
		break;
		
		case "remove-product-sell-sales-request":
			$tbl_sales_request_detail = mysql_query("SELECT * FROM sales_request_detail WHERE sales_request_detail_id = '".$_GET['sales_request_detail_id']."'");
			$data_tbl_sales_request_detail = mysql_fetch_array($tbl_sales_request_detail);
			
			$tgl_sekarang = date('Y-m-d');
			
			$tbl_customer_category = mysql_query("SELECT b.customer_category_id FROM sales_request a, customer b WHERE a.customer_id = b.customer_id AND a.sales_request_id = '".$data_tbl_sales_request_detail['sales_request_id']."'");
			$data_tbl_customer_category = mysql_fetch_array($tbl_customer_category);
			
			if($data_tbl_sales_request_detail['product_sell_id'] == '2')
			{
				$sales_request_detail_product_sell_quantity = mysql_query("SELECT sales_request_detail_product_sell_quantity FROM sales_request_detail WHERE sales_request_id = '".$data_tbl_sales_request_detail['sales_request_id']."' AND product_sell_id = 3");
				$data_sales_request_detail_product_sell_quantity = mysql_fetch_array($sales_request_detail_product_sell_quantity);
				
				$tbl_product_promo = mysql_query("SELECT product_promo_program_bonus, product_promo_piece_discount, product_promo_cash_discount FROM product_promo WHERE customer_category_id = '".$data_tbl_customer_category['customer_category_id']."' AND product_sell_id = '3' AND product_promo_purchase_minimum <= '".$data_sales_request_detail_product_sell_quantity['sales_request_detail_product_sell_quantity']."' AND product_promo_purchase_maximum >= '".$data_sales_request_detail_product_sell_quantity['sales_request_detail_product_sell_quantity']."' AND product_promo_expiry_from_date <= '".$tgl_sekarang."' AND product_promo_expiry_to_date >= '".$tgl_sekarang."'");
				$data_tbl_product_promo = mysql_fetch_array($tbl_product_promo);
				
				mysql_query("UPDATE sales_request_detail SET sales_request_detail_piece_discount = '".$data_tbl_product_promo['product_promo_piece_discount']."' WHERE sales_request_id = '".$data_tbl_sales_request_detail['sales_request_id']."' AND product_sell_id = '3'");
				
			}
			else
			{
				$sales_request_detail_product_sell_quantity = mysql_query("SELECT sales_request_detail_product_sell_quantity FROM sales_request_detail WHERE sales_request_id = '".$data_tbl_sales_request_detail['sales_request_id']."' AND product_sell_id = 2");
				$data_sales_request_detail_product_sell_quantity = mysql_fetch_array($sales_request_detail_product_sell_quantity);
				
				$tbl_product_promo = mysql_query("SELECT product_promo_program_bonus, product_promo_piece_discount, product_promo_cash_discount FROM product_promo WHERE customer_category_id = '".$data_tbl_customer_category['customer_category_id']."' AND product_sell_id = '2' AND product_promo_purchase_minimum <= '".$data_sales_request_detail_product_sell_quantity['sales_request_detail_product_sell_quantity']."' AND product_promo_purchase_maximum >= '".$data_sales_request_detail_product_sell_quantity['sales_request_detail_product_sell_quantity']."' AND product_promo_expiry_from_date <= '".$tgl_sekarang."' AND product_promo_expiry_to_date >= '".$tgl_sekarang."'");
				$data_tbl_product_promo = mysql_fetch_array($tbl_product_promo);
				
				mysql_query("UPDATE sales_request_detail SET sales_request_detail_piece_discount = '".$data_tbl_product_promo['product_promo_piece_discount']."' WHERE sales_request_id = '".$data_tbl_sales_request_detail['sales_request_id']."' AND product_sell_id = '2'");
			}
										
			mysql_query("DELETE FROM sales_request_detail WHERE sales_request_detail_id = '".$_GET['sales_request_detail_id']."'");
			
			mysql_query("DELETE FROM sales_order_detail WHERE sales_request_detail_id = '".$_GET['sales_request_detail_id']."'");
			
			header("location:../system/page_home.php?alimms=sales-request&tib=form-product-sell-sales-request&sales_request_id=".$data_tbl_sales_request_detail['sales_request_id']);	
		break;
		
		case "form-edit-sales-request":
			form_edit_sales_request();
		break;
		
		case "edit-sales-request":
			$sales_request_delivery_schedule_date = explode("-", $_POST['sales_request_delivery_schedule_date']);
			$date_sales_request_delivery_schedule = $sales_request_delivery_schedule_date[0];
			$month_sales_request_delivery_schedule = $sales_request_delivery_schedule_date[1];
			$year_sales_request_delivery_schedule = $sales_request_delivery_schedule_date[2];
			$sales_request_delivery_schedule_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_request_delivery_schedule, $date_sales_request_delivery_schedule, $year_sales_request_delivery_schedule));
			
			mysql_query("UPDATE sales_request SET salesman_id = '".$_POST['salesman_id']."', customer_id = '".$_POST['customer_id']."', sales_request_payment_method = '".$_POST['sales_request_payment_method']."', sales_request_order_method = '".$_POST['sales_request_order_method']."', sales_request_delivery_schedule_date = '".$sales_request_delivery_schedule_date."', sales_request_product_sell_program_mix = '".$_POST['sales_request_product_sell_program_mix']."', sales_request_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE sales_request_id = '".$_POST['sales_request_id']."'");
			
			header("location:../system/page_home.php?alimms=sales-request&tib=form-product-sell-sales-request&sales_request_id=".$_POST['sales_request_id']);	
		break;
	
		case "delete-sales-request":
			mysql_query("UPDATE sales_request SET sales_request_status = 'Canceled', sales_request_datetime = '".$waktu_sekarang."', sales_request_active = '0', user_id = '".$_SESSION['user_id']."' WHERE sales_request_id = '".$_GET['sales_request_id']."'");
			
			mysql_query("UPDATE sales_order SET sales_order_status = 'Canceled', sales_order_description = 'Pesanan Dibatalkan', sales_order_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE sales_request_id = '".$_GET['sales_request_id']."'");
			
			header("location:../system/page_home.php?alimms=sales-request");	
		break;
		
		case "form-view-sales-request":
			form_view_sales_request();
		break;
		
		case "update-program-customer":
			
			mysql_query("UPDATE customer SET selling_program_galon_id = '1' WHERE customer_id = '".$_GET['customer_id']."'");
			
			header("location:../system/page_home.php?alimms=sales-request");
		
		break;
	}
?>