<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_visit_dashboard();
		break;
		
		case "form-add-sales-visit-dashboard":
			mysql_query("UPDATE sales_visit SET sales_visit_time_in = '".$waktu."' WHERE sales_visit_id = '".$_GET['sales_visit_id']."'");
			
			form_add_sales_visit_dashboard();
		break;
	
		case "add-sales-visit-dashboard":
			$jumlah_sales_visit_detail_product_sell_quantity = count($_POST['sales_visit_detail_product_sell_quantity']);
			for($i=0; $i<$jumlah_sales_visit_detail_product_sell_quantity; $i++)
			{
				mysql_query("INSERT INTO sales_visit_detail(sales_visit_id, product_sell_id, sales_visit_detail_product_sell_quantity) VALUES('".$_POST['sales_visit_id']."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_visit_detail_product_sell_quantity'][$i]."')");	
			}
			
			$tbl_visit_plan = mysql_query("SELECT c.customer_code, c.customer_id FROM sales_visit a, sales_plan_detail b, customer c WHERE a.sales_visit_id = '".$_POST['sales_visit_id']."' AND a.sales_plan_detail_id = b.sales_plan_detail_id AND b.customer_id = c.customer_id");
			$data_tbl_visit_plan = mysql_fetch_array($tbl_visit_plan);
			
			$jumlah_product_display_photo = count($_FILES['product_display_photo']['name']);
			for ($i=0; $i<$jumlah_product_display_photo; $i++)
			{
				$location_file = $_FILES['product_display_photo']['tmp_name'][$i];
				$type_file = $_FILES['product_display_photo']['type'][$i];
				$name_file = $_FILES['product_display_photo']['name'][$i];
				$random_number = rand(1, 50);
				
				$name_file = explode(".", $name_file);
				$ekstension_name_file = $name_file[1];
				
				$random_name_file = $data_tbl_visit_plan['customer_code'].'-'.$tgl_sekarang_indo_without_minus.'-'.$random_number.'.'.$ekstension_name_file;
				$destination_file = '../assets/layouts/layout6/img/product-display/';
				$upload_file = $destination_file . $random_name_file;
				
				if (move_uploaded_file($location_file, $upload_file))
				{
					mysql_query("INSERT INTO product_display(sales_visit_id, product_display_photo) VALUES('".$_POST['sales_visit_id']."', '".$random_name_file."')");	
				}
			}
			
			if ($_POST['sales_visit_status'] == 'Order')
			{
				mysql_query("UPDATE sales_visit SET sales_visit_time_out = '".$waktu."', sales_visit_status = '".$_POST['sales_visit_status']."', sales_visit_description = 'Pelanggan Melakukan Permintaan', sales_visit_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE sales_visit_id = '".$_POST['sales_visit_id']."'");
				
				header("location:../system/page_home.php?alimms=dashboard&tib=form-product-sell-sales-visit-dashboard&customer_id=".$data_tbl_visit_plan['customer_id']);	
			}
			else
			{
				mysql_query("UPDATE sales_visit SET sales_visit_time_out = '".$waktu."', sales_visit_status = '".$_POST['sales_visit_status']."', sales_visit_description = '".$_POST['sales_visit_description']."', sales_visit_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE sales_visit_id = '".$_POST['sales_visit_id']."'");
				
				header("location:../system/page_home.php?alimms=dashboard");	
			}
		break;
		
		case "form-order-sales-visit-dashboard":
			form_order_sales_visit_dashboard();
		break;
		
		case "order-sales-visit-dashboard":
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
			
			mysql_query("INSERT INTO sales_request(sales_request_id, sales_request_no, sales_request_date, salesman_id, customer_id, sales_request_payment_method, sales_request_order_method, sales_request_delivery_schedule_date, sales_request_product_sell_program_mix, sales_request_datetime, user_id) VALUES ('".$sales_request_id."', '".$sales_request_no."', '".$tgl_sekarang."', '".$_SESSION['user_id']."', '".$_POST['customer_id']."', '".$_POST['sales_request_payment_method']."', '".$_POST['sales_request_order_method']."', '".$sales_request_delivery_schedule_date."', '".$_POST['sales_request_product_sell_program_mix']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
			
			 mysql_query("INSERT INTO `sales_order`(`sales_order_id`, `sales_request_id`, `sales_order_status`, `sales_order_description`, `sales_order_overdue_day`, `sales_order_datetime`, `user_id`) VALUES ('".$sales_order_id."', '".$sales_request_id."','On Hold','','0','".$waktu_sekarang."','".$_SESSION['user_id']."')");
				
			header("location:../system/page_home.php?alimms=dashboard&tib=form-product-sell-sales-visit-dashboard&sales_request_id=".$sales_request_id);	
		break;
		
		case "form-product-sell-sales-visit-dashboard":
			form_product_sell_sales_visit_dashboard();
		break;
	
		case "product-sell-sales-visit-dashboard":
		
			if($_POST['get_sales_request_id'] != ""){
				$sales_request_id = $_POST['get_sales_request_id'];
				
				mysql_query("UPDATE sales_request SET sales_request_payment_method = '".$_POST['sales_request_payment_method']."',sales_request_product_sell_program_mix = '".$_POST['sales_request_product_sell_program_mix']."' WHERE sales_request_id = '".$sales_request_id."'");
				
			} else {
				
				$sales_request_id = idbaru("sales_request","sales_request_id");
				$sales_order_id = idbaru("sales_order","sales_order_id");
				
				$unique_code = "TIB" . "/" . "SR" . "-" . $thn_sekarang . "/" . $bln_sekarang . "/";
				$tbl_sales_request = mysql_query("SELECT max(sales_request_no) as maxID FROM sales_request WHERE sales_request_no LIKE '$unique_code%'");
				$data_tbl_sales_request = mysql_fetch_array($tbl_sales_request);
				$idMax = $data_tbl_sales_request['maxID'];
				$noUrut = (int) substr($idMax, 15, 4);
				$noUrut++;
				$sales_request_no = $unique_code . sprintf("%04s", $noUrut);

                                $sales_request_delivery_schedule_date = date("Y-m-d", mktime(0,0,0, date("m"), date("d")+1 , date("Y")));
				
				mysql_query("INSERT INTO sales_request(sales_request_id, sales_request_no, sales_request_date, salesman_id, customer_id, sales_request_payment_method, sales_request_order_method, sales_request_delivery_schedule_date, sales_request_product_sell_program_mix, sales_request_datetime, user_id) VALUES ('".$sales_request_id."', '".$sales_request_no."', '".$tgl_sekarang."', '".$_SESSION['user_id']."', '".$_POST['customer_id']."', '".$_POST['sales_request_payment_method']."', 'By Visit', '".$sales_request_delivery_schedule_date."', '".$_POST['sales_request_product_sell_program_mix']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
				
				 mysql_query("INSERT INTO `sales_order`(`sales_order_id`, `sales_request_id`, `sales_order_status`, `sales_order_description`, `sales_order_overdue_day`, `sales_order_datetime`, `user_id`) VALUES ('".$sales_order_id."', '".$sales_request_id."','On Hold','','0','".$waktu_sekarang."','".$_SESSION['user_id']."')");
			}
			
		$jumlah_sales_request_detail_product_sell_quantity = count($_POST['sales_request_detail_product_sell_quantity']);
			for($i=0; $i<$jumlah_sales_request_detail_product_sell_quantity; $i++)
			{ 	
			if($_POST['sales_request_detail_product_sell_quantity'][$i] == 0){
				
			} else {
			$sales_request_detail_id = idbaru("sales_request_detail","sales_request_detail_id");
			$sales_order_detail_id = idbaru("sales_order_detail","sales_order_detail_id");
			
			$tbl_sales_request = mysql_query("SELECT a.sales_request_payment_method, a.sales_request_product_sell_program_mix, b.customer_category_id, b.product_sell_price_id, b.customer_product_sell_program_promo, c.customer_city_id FROM sales_request a, customer b, customer_districts c WHERE a.sales_request_id = '".$sales_request_id."' AND a.customer_id = b.customer_id AND b.customer_districts_id = c.customer_districts_id");
			$data_tbl_sales_request = mysql_fetch_array($tbl_sales_request);
			
			$tbl_customer_category = mysql_query("SELECT customer_category_name FROM customer_category WHERE customer_category_id = '".$data_tbl_sales_request['customer_category_id']."'");
			$data_tbl_customer_category = mysql_fetch_array($tbl_customer_category);
			
			$tbl_sales_order = mysql_query("SELECT sales_order_id FROM sales_order WHERE sales_request_id = '".$sales_request_id."'");
			$data_tbl_sales_order = mysql_fetch_array($tbl_sales_order);
			
			$tbl_product_sell = mysql_query("SELECT product_sell_name FROM product_sell WHERE product_sell_id = '".$_POST['product_sell_id'][$i]."'");
			$data_tbl_product_sell = mysql_fetch_array($tbl_product_sell);
			
			$tbl_product_sell_price = mysql_query("SELECT b.product_sell_price_detail_product_sell_price FROM product_sell_price a, product_sell_price_detail b WHERE a.product_sell_price_id = '".$data_tbl_sales_request['product_sell_price_id']."' AND b.product_sell_id = '".$_POST['product_sell_id'][$i]."' AND a.product_sell_price_id = b.product_sell_price_id");
			$data_tbl_product_sell_price = mysql_fetch_array($tbl_product_sell_price);
			
			$tbl_product_promo = mysql_query("SELECT product_promo_program_bonus, product_promo_piece_discount, product_promo_cash_discount FROM product_promo WHERE customer_category_id = '".$data_tbl_sales_request['customer_category_id']."' AND product_sell_id = '".$_POST['product_sell_id'][$i]."' AND product_promo_purchase_minimum <= '".$_POST['sales_request_detail_product_sell_quantity'][$i]."' AND product_promo_purchase_maximum >= '".$_POST['sales_request_detail_product_sell_quantity'][$i]."' AND product_promo_expiry_from_date <= '".$tgl_sekarang."' AND product_promo_expiry_to_date >= '".$tgl_sekarang."'");
			$data_tbl_product_promo = mysql_fetch_array($tbl_product_promo);
			
			$product_promo_program_bonus = floor($_POST['sales_request_detail_product_sell_quantity'][$i] / $data_tbl_product_promo['product_promo_program_bonus']);
			
			$product_promo_cash_discount = ($data_tbl_product_promo['product_promo_cash_discount'] / 100) * $data_tbl_product_sell_price['product_sell_price_detail_product_sell_price'];
			
			$tbl_delivery_cost = mysql_query("SELECT delivery_cost_price FROM delivery_cost WHERE customer_city_id = '".$data_tbl_sales_request['customer_city_id']."'");
			$data_tbl_delivery_cost = mysql_fetch_array($tbl_delivery_cost);

                        if($data_tbl_product_promo['product_promo_piece_discount'] == ''){
                           $data_tbl_product_promo['product_promo_piece_discount'] = "0";
                        }

                        if($data_tbl_delivery_cost['delivery_cost_price'] == ''){
                           $data_tbl_delivery_cost['delivery_cost_price'] = "0";
                        }

                        if($product_promo_cash_discount == ''){
                           $product_promo_cash_discount = "0";
                        }

			
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
							
								if ($_POST['sales_request_detail_product_sell_quantity'][$i] >= 300)
								{
									$product_promo_piece_discount = $data_tbl_product_promo['product_promo_piece_discount'] + 500;
								}
								else
								{
									$product_promo_piece_discount = $data_tbl_product_promo['product_promo_piece_discount'];
								}
								
								mysql_query("INSERT INTO `sales_request_detail`(`sales_request_detail_id`, `sales_request_id`, `product_sell_id`, `sales_request_detail_product_sell_quantity`, `sales_request_detail_product_sell_price`, `sales_request_detail_program_bonus`, `sales_request_detail_piece_discount`, `sales_request_detail_cash_discount`, `sales_request_detail_delivery_cost_price`) VALUES ('".$sales_request_detail_id."', '".$sales_request_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."','".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$product_promo_piece_discount."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
								
								mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."','".$product_promo_program_bonus."', '".$product_promo_piece_discount."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
							} 
							else
							{
								
								mysql_query("INSERT INTO `sales_request_detail`(`sales_request_detail_id`, `sales_request_id`, `product_sell_id`, `sales_request_detail_product_sell_quantity`, `sales_request_detail_product_sell_price`, `sales_request_detail_program_bonus`, `sales_request_detail_piece_discount`, `sales_request_detail_cash_discount`, `sales_request_detail_delivery_cost_price`) VALUES ('".$sales_request_detail_id."', '".$sales_request_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."','".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
								mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."','".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
								
							}
						}
						elseif ($data_tbl_product_sell['product_sell_name'] == 'Botol 600 ml')
						{
							$tbl_sales_request_detail = mysql_query("SELECT a.sales_request_detail_product_sell_quantity, a.sales_request_detail_id FROM sales_request_detail a, product_sell b WHERE a.sales_request_id = '".$sales_request_id."' AND b.product_sell_name = 'Botol 1500 ml' AND a.product_sell_id = b.product_sell_id");
							$data_tbl_sales_request_detail = mysql_fetch_array($tbl_sales_request_detail);
							
							$product_sell_quantity = $data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] + $_POST['sales_request_detail_product_sell_quantity'][$i];
							
							$tbl_product_promo = mysql_query("SELECT product_promo_program_bonus, product_promo_piece_discount, product_promo_cash_discount FROM product_promo WHERE customer_category_id = '".$data_tbl_sales_request['customer_category_id']."' AND product_sell_id = '".$_POST['product_sell_id'][$i]."' AND product_promo_purchase_minimum <= '".$product_sell_quantity."' AND product_promo_purchase_maximum >= '".$product_sell_quantity."' AND product_promo_expiry_from_date <= '".$tgl_sekarang."' AND product_promo_expiry_to_date >= '".$tgl_sekarang."'");
							$data_tbl_product_promo = mysql_fetch_array($tbl_product_promo);

                                                        if($data_tbl_product_promo['product_promo_piece_discount'] == ''){
                                                         $data_tbl_product_promo['product_promo_piece_discount'] = "0";
                                                        }

                                                         if($data_tbl_delivery_cost['delivery_cost_price'] == ''){
                                                           $data_tbl_delivery_cost['delivery_cost_price'] = "0";
                                                         }

                                                        if($product_promo_cash_discount == ''){
                                                          $product_promo_cash_discount = "0";
                                                        }
							
							mysql_query("UPDATE sales_request_detail SET sales_request_detail_piece_discount = '".$data_tbl_product_promo['product_promo_piece_discount']."' WHERE sales_request_id = '".$sales_request_id."' AND product_sell_id = '3'");

                                                        mysql_query("UPDATE sales_order_detail SET sales_order_detail_piece_discount = '".$data_tbl_product_promo['product_promo_piece_discount']."' WHERE sales_request_detail_id='".$data_tbl_sales_request_detail['sales_request_detail_id']."'");
							
							mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$sales_request_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', 0, '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
							mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', 0, '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
						}
						else
						{
							$tbl_sales_request_detail = mysql_query("SELECT a.sales_request_detail_product_sell_quantity, a.sales_request_detail_id FROM sales_request_detail a, product_sell b WHERE a.sales_request_id = '".$sales_request_id."' AND b.product_sell_name = 'Botol 600 ml' AND a.product_sell_id = b.product_sell_id");
							$data_tbl_sales_request_detail = mysql_fetch_array($tbl_sales_request_detail);
							
							$product_sell_quantity = $data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] + $_POST['sales_request_detail_product_sell_quantity'][$i];
							
							$tbl_product_promo = mysql_query("SELECT product_promo_program_bonus, product_promo_piece_discount, product_promo_cash_discount FROM product_promo WHERE customer_category_id = '".$data_tbl_sales_request['customer_category_id']."' AND product_sell_id = '".$_POST['product_sell_id'][$i]."' AND product_promo_purchase_minimum <= '".$product_sell_quantity."' AND product_promo_purchase_maximum >= '".$product_sell_quantity."' AND product_promo_expiry_from_date <= '".$tgl_sekarang."' AND product_promo_expiry_to_date >= '".$tgl_sekarang."'");
							$data_tbl_product_promo = mysql_fetch_array($tbl_product_promo);
							
							$product_promo_program_bonus = floor($product_sell_quantity / $data_tbl_product_promo['product_promo_program_bonus']);

                                                        if($data_tbl_product_promo['product_promo_piece_discount'] == ''){
                                                         $data_tbl_product_promo['product_promo_piece_discount'] = "0";
                                                        }

                                                         if($data_tbl_delivery_cost['delivery_cost_price'] == ''){
                                                           $data_tbl_delivery_cost['delivery_cost_price'] = "0";
                                                         }

                                                        if($product_promo_cash_discount == ''){
                                                          $product_promo_cash_discount = "0";
                                                        }
							
							mysql_query("UPDATE sales_request_detail SET sales_request_detail_piece_discount = '".$data_tbl_product_promo['product_promo_piece_discount']."' WHERE sales_request_id = '".$sales_request_id."' AND product_sell_id = '2'");

                                                        mysql_query("UPDATE sales_order_detail SET sales_order_detail_piece_discount = '".$data_tbl_product_promo['product_promo_piece_discount']."' WHERE sales_request_detail_id='".$data_tbl_sales_request_detail['sales_request_detail_id']."'");
							
							mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$sales_request_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
							mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
						}
					}
					else // BUKAN PROGRAM MIX
					{
						if ($data_tbl_product_sell['product_sell_name'] == 'Cup 220 ml')
						{
							if ($data_tbl_customer_category['customer_category_name'] == 'Grosir Kota')
							{
							
								if ($_POST['sales_request_detail_product_sell_quantity'][$i] >= 300)
								{
									$product_promo_piece_discount = $data_tbl_product_promo['product_promo_piece_discount'] + 500;
								}
								else
								{
									$product_promo_piece_discount = $data_tbl_product_promo['product_promo_piece_discount'];
								}
								
								mysql_query("INSERT INTO `sales_request_detail`(`sales_request_detail_id`, `sales_request_id`, `product_sell_id`, `sales_request_detail_product_sell_quantity`, `sales_request_detail_product_sell_price`, `sales_request_detail_program_bonus`, `sales_request_detail_piece_discount`, `sales_request_detail_cash_discount`, `sales_request_detail_delivery_cost_price`) VALUES ('".$sales_request_detail_id."', '".$sales_request_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."','".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$product_promo_piece_discount."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
								
								mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."','".$product_promo_program_bonus."', '".$product_promo_piece_discount."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
							} 
							else
							{
								mysql_query("INSERT INTO `sales_request_detail`(`sales_request_detail_id`, `sales_request_id`, `product_sell_id`, `sales_request_detail_product_sell_quantity`, `sales_request_detail_product_sell_price`, `sales_request_detail_program_bonus`, `sales_request_detail_piece_discount`, `sales_request_detail_cash_discount`, `sales_request_detail_delivery_cost_price`) VALUES ('".$sales_request_detail_id."', '".$sales_request_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."','".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
								mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."','".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
								
							}
						}
						mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$sales_request_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
						
						mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
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
							
								if ($_POST['sales_request_detail_product_sell_quantity'][$i] >= 300)
								{
									$product_promo_piece_discount = $data_tbl_product_promo['product_promo_piece_discount'] + 250;
								}
								else
								{
									$product_promo_piece_discount = $data_tbl_product_promo['product_promo_piece_discount'];
								}
								
								mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$sales_request_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$product_promo_piece_discount."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
								mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$product_promo_piece_discount."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");	
							
							} 
							else
							{
							
								mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$sales_request_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
								
								mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
							}
						}
						elseif ($data_tbl_product_sell['product_sell_name'] == 'Botol 600 ml')
						{

                                                        $tbl_sales_request_detail = mysql_query("SELECT a.sales_request_detail_product_sell_quantity, a.sales_request_detail_id FROM sales_request_detail a, product_sell b WHERE a.sales_request_id = '".$sales_request_id."' AND b.product_sell_name = 'Botol 1500 ml' AND a.product_sell_id = b.product_sell_id");
							$data_tbl_sales_request_detail = mysql_fetch_array($tbl_sales_request_detail);
							
							$product_sell_quantity = $data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] + $_POST['sales_request_detail_product_sell_quantity'][$i];
							
							$tbl_product_promo = mysql_query("SELECT product_promo_program_bonus, product_promo_piece_discount, product_promo_cash_discount FROM product_promo WHERE customer_category_id = '".$data_tbl_sales_request['customer_category_id']."' AND product_sell_id = '".$_POST['product_sell_id'][$i]."' AND product_promo_purchase_minimum <= '".$product_sell_quantity."' AND product_promo_purchase_maximum >= '".$product_sell_quantity."' AND product_promo_expiry_from_date <= '".$tgl_sekarang."' AND product_promo_expiry_to_date >= '".$tgl_sekarang."'");
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

							mysql_query("UPDATE sales_request_detail SET sales_request_detail_piece_discount = '".$data_tbl_product_promo['product_promo_piece_discount']."' WHERE sales_request_id = '".$sales_request_id."' AND product_sell_id = '3'");

                                                        mysql_query("UPDATE sales_order_detail SET sales_order_detail_piece_discount = '".$data_tbl_product_promo['product_promo_piece_discount']."' WHERE sales_request_detail_id='".$data_tbl_sales_request_detail['sales_request_detail_id']."'");

							mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$sales_request_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', 0, '".$data_tbl_product_promo['product_promo_piece_discount']."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
							mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', 0, '".$data_tbl_product_promo['product_promo_piece_discount']."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
						}
						else
						{
							$tbl_sales_request_detail = mysql_query("SELECT a.sales_request_detail_product_sell_quantity, a.sales_request_detail_id FROM sales_request_detail a, product_sell b WHERE a.sales_request_id = '".$sales_request_id."' AND b.product_sell_name = 'Botol 600 ml' AND a.product_sell_id = b.product_sell_id");
							$data_tbl_sales_request_detail = mysql_fetch_array($tbl_sales_request_detail);
							
							$product_sell_quantity = $data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] + $_POST['sales_request_detail_product_sell_quantity'][$i];
							
							$tbl_product_promo = mysql_query("SELECT product_promo_program_bonus, product_promo_piece_discount, product_promo_cash_discount FROM product_promo WHERE customer_category_id = '".$data_tbl_sales_request['customer_category_id']."' AND product_sell_id = '".$_POST['product_sell_id'][$i]."' AND product_promo_purchase_minimum <= '".$product_sell_quantity."' AND product_promo_purchase_maximum >= '".$product_sell_quantity."' AND product_promo_expiry_from_date <= '".$tgl_sekarang."' AND product_promo_expiry_to_date >= '".$tgl_sekarang."'");
							$data_tbl_product_promo = mysql_fetch_array($tbl_product_promo);
							
							$product_promo_program_bonus = floor($product_sell_quantity / $data_tbl_product_promo['product_promo_program_bonus']);

                                                        if($data_tbl_product_promo['product_promo_piece_discount'] == ''){
                                                         $data_tbl_product_promo['product_promo_piece_discount'] = "0";
                                                        }

                                                         if($data_tbl_delivery_cost['delivery_cost_price'] == ''){
                                                           $data_tbl_delivery_cost['delivery_cost_price'] = "0";
                                                         }

                                                        if($product_promo_cash_discount == ''){
                                                          $product_promo_cash_discount = "0";
                                                        }

                                                        mysql_query("UPDATE sales_request_detail SET sales_request_detail_piece_discount = '".$data_tbl_product_promo['product_promo_piece_discount']."' WHERE sales_request_id = '".$sales_request_id."' AND product_sell_id = '2'");

                                                        mysql_query("UPDATE sales_order_detail SET sales_order_detail_piece_discount = '".$data_tbl_product_promo['product_promo_piece_discount']."' WHERE sales_request_detail_id='".$data_tbl_sales_request_detail['sales_request_detail_id']."'");
							
							mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$sales_request_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', '".$product_promo_cash_discount."', '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
							mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
						}
					}
					else
					{
						if ($data_tbl_product_sell['product_sell_name'] == 'Cup 220 ml')
						{
							if ($data_tbl_customer_category['customer_category_name'] == 'Grosir Kota')
							{
							
								$product_promo_piece_discount = $data_tbl_product_promo['product_promo_piece_discount'] + 250;
								
								mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$sales_request_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$product_promo_piece_discount."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
								mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$product_promo_piece_discount."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");	
							
							} 
							else
							{
							
								mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$sales_request_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
								
								mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
							}
						} 
						else 
						{
								mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$sales_request_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
							
								mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', '".$product_promo_program_bonus."', '".$data_tbl_product_promo['product_promo_piece_discount']."', 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
						}
					}
				}
			}
			else
			{
				mysql_query("INSERT INTO sales_request_detail(sales_request_detail_id, sales_request_id, product_sell_id, sales_request_detail_product_sell_quantity, sales_request_detail_product_sell_price, sales_request_detail_program_bonus, sales_request_detail_piece_discount, sales_request_detail_cash_discount, sales_request_detail_delivery_cost_price) VALUES ('".$sales_request_detail_id."', '".$sales_request_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', 0, 0, 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
				
				mysql_query("INSERT INTO sales_order_detail(sales_order_detail_id, sales_order_id, sales_request_detail_id, product_sell_id, sales_order_detail_product_sell_quantity, sales_order_detail_product_sell_price, sales_order_detail_program_bonus, sales_order_detail_piece_discount, sales_order_detail_cash_discount, sales_order_detail_delivery_cost_price) VALUES ('".$sales_order_detail_id."', '".$data_tbl_sales_order['sales_order_id']."', '".$sales_request_detail_id."', '".$_POST['product_sell_id'][$i]."', '".$_POST['sales_request_detail_product_sell_quantity'][$i]."', '".$data_tbl_product_sell_price['product_sell_price_detail_product_sell_price']."', 0, 0, 0, '".$data_tbl_delivery_cost['delivery_cost_price']."')");
			}
		}
		}	
		
		header("location:../system/page_home.php?alimms=dashboard");	
		break;
		
		case "remove-product-sell-sales-visit-dashboard":
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
			
			header("location:../system/page_home.php?alimms=dashboard&tib=form-product-sell-sales-visit-dashboard&sales_request_id=".$data_tbl_sales_request_detail['sales_request_id']);	
		break;
	
		case "form-view-sales-visit-dashboard":
			form_view_sales_visit_dashboard();
		break;
	
		case "form-add-customer-request-dashboard":
			form_add_customer_request_dashboard();
		break;
	
		case "add-customer-request-dashboard":
			$customer_request_id = idbaru("customer_request","customer_request_id");
			$customer_id = idbaru("customer","customer_id");
			$customer_request_date = explode("-", $_POST['customer_request_date']);
			$date_customer_request = $customer_request_date[0];
			$month_customer_request = $customer_request_date[1];
			$year_customer_request = $customer_request_date[2];
			$customer_request_date = date("Y-m-d", mktime(0, 0, 0, $month_customer_request, $date_customer_request, $year_customer_request));
			
			$jumlah_product_display_photo = count($_FILES['customer_display_photo']['name']);
			for ($i=0; $i<$jumlah_product_display_photo; $i++)
			{
				$location_file = $_FILES['customer_display_photo']['tmp_name'][$i];
				$type_file = $_FILES['customer_display_photo']['type'][$i];
				$name_file = $_FILES['customer_display_photo']['name'][$i];
				$random_number = rand(1, 50);
				
				$name_file = explode(".", $name_file);
				$ekstension_name_file = $name_file[1];
				
				$random_name_file = $customer_request_id.'-'.$tgl_sekarang_indo_without_minus.'-'.$random_number.'.'.$ekstension_name_file;
				$destination_file = '../assets/layouts/layout6/img/customer-display/';
				$upload_file = $destination_file . $random_name_file;
				
				if (move_uploaded_file($location_file, $upload_file))
				{
					mysql_query("INSERT INTO customer_display(customer_request_id, customer_display_photo) VALUES('".$customer_request_id."', '".$random_name_file."')");					
				}
			}
			
			mysql_query("INSERT INTO customer_request(customer_request_id, customer_request_date, customer_request_name, customer_request_address, customer_districts_id, customer_request_contact, customer_request_phone, customer_request_datetime, user_id) VALUES ('".$customer_request_id."', '".$customer_request_date."', '".$_POST['customer_request_name']."', '".$_POST['customer_request_address']."', '".$_POST['customer_districts_id']."', '".$_POST['customer_request_contact']."', '".$_POST['customer_request_phone']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
			
			header("location:../system/page_home.php?alimms=dashboard&tib=form-view-customer-request-dashboard");	
		break;
	
		case "form-edit-customer-request-dashboard":
			form_edit_customer_request_dashboard();
		break;
		
		case "edit-customer-request-dashboard":
			$customer_request_date = explode("-", $_POST['customer_request_date']);
			$date_customer_request = $customer_request_date[0];
			$month_customer_request = $customer_request_date[1];
			$year_customer_request = $customer_request_date[2];
			$customer_request_date = date("Y-m-d", mktime(0, 0, 0, $month_customer_request, $date_customer_request, $year_customer_request));
			$customer_request_id = $_POST['customer_request_id'];
			
			mysql_query("UPDATE customer_request SET customer_request_date = '".$customer_request_date."', customer_request_name = '".$_POST['customer_request_name']."', customer_request_address = '".$_POST['customer_request_address']."', customer_districts_id = '".$_POST['customer_districts_id']."', customer_request_contact = '".$_POST['customer_request_contact']."', customer_request_phone = '".$_POST['customer_request_phone']."', customer_request_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE customer_request_id = '".$_POST['customer_request_id']."'");
			$jumlah_product_display_photo = count($_FILES['customer_display_photo']['name']);
			for ($i=0; $i<$jumlah_product_display_photo; $i++)
			{
				$location_file = $_FILES['customer_display_photo']['tmp_name'][$i];
				$type_file = $_FILES['customer_display_photo']['type'][$i];
				$name_file = $_FILES['customer_display_photo']['name'][$i];
				$random_number = rand(1, 50);
				
				$name_file = explode(".", $name_file);
				$ekstension_name_file = $name_file[1];
				
				$random_name_file = $customer_request_id.'-'.$tgl_sekarang_indo_without_minus.'-'.$random_number.'.'.$ekstension_name_file;
				$destination_file = '../assets/layouts/layout6/img/customer-display/';
				$upload_file = $destination_file . $random_name_file;
				
				if (move_uploaded_file($location_file, $upload_file))
				{
					echo $random_name_file;
					echo " ";
					echo $_POST['data_customer_display'][$i];
					mysql_query("UPDATE customer_display SET customer_display_photo = '".$random_name_file."' WHERE customer_display_id = '".$_POST['data_customer_display'][$i]."'");					
				}
			}
			
			header("location:../system/page_home.php?alimms=dashboard&tib=form-edit-customer-request-detail-dashboard&customer_request_id=".$_POST['customer_request_id']);	
		break;
	
		case "delete-customer-request-dashboard":
			$customer_id = mysql_fetch_array(mysql_query("SELECT customer_id FROM customer_request WHERE customer_request_id = '".$_GET['customer_request_id']."'"));
			$tgl_skrg = date('Y-m-d');
			mysql_query("UPDATE sales_request SET sales_request_active = '0',sales_request_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE customer_id = '".$customer_id['customer_id']."' AND sales_request_date = '".$tgl_skrg."' AND salesman_id = '".$_SESSION['user_id']."'");
			mysql_query("UPDATE customer SET customer_datetime = '".$waktu_sekarang."', customer_active = '0', user_id = '".$_SESSION['user_id']."' WHERE customer_id = '".$customer_id['customer_id']."'");			
			mysql_query("UPDATE customer_request SET customer_request_datetime = '".$waktu_sekarang."', customer_request_active = '0', user_id = '".$_SESSION['user_id']."' WHERE customer_request_id = '".$_GET['customer_request_id']."'");
			header("location:../system/page_home.php?alimms=dashboard&tib=form-view-customer-request-dashboard");	
		break;
		
		case "form-view-customer-request-dashboard":
			form_view_customer_request_dashboard();
		break;
		
		case "form-view-customer-request-detail-dashboard":
			form_view_customer_request_detail_dashboard();
		break;
		
		case "form-edit-customer-request-detail-dashboard":
			form_edit_customer_request_detail_dashboard();
		break;
		
		case "edit-customer-request-detail-dashboard":
			
			mysql_query("UPDATE sales_request SET sales_request_payment_method = '".$_POST['sales_request_payment_method']."', sales_request_order_method = '".$_POST['sales_request_order_method']."', sales_request_delivery_schedule_date = '".$_POST['sales_request_delivery_schedule_date']."' WHERE sales_request_id = '".$_POST['sales_request_id']."'");
			
			header("location:../system/page_home.php?alimms=dashboard&tib=form-edit-product-sell-customer-request-dashboard&sales_request_id=".$sales_request_id);	
		break;
		
		case "form-edit-product-sell-customer-request-dashboard":
			form_edit_product_sell_customer_request_dashboard();
		break;
		
		case "form-order-customer-request-dashboard":
			form_order_customer_request_dashboard();
		break;

        case "form-view-sales-schedule-by-sales":
			form_view_sales_schedule_by_sales();
		break;
		
		case "form-view-sales-schedule-entry-by-sales":
			form_view_sales_schedule_entry_by_sales();
		break;
		
		case "form-add-billing-visit-dashboard":
			mysql_query("UPDATE `billing_visit` SET `billing_visit_time_in`= '".$waktu."' WHERE billing_visit_id = '".$_GET['billing_visit_id']."'");
			form_add_billing_visit_dashboard();
		break;
		
		case "add-billing-visit-payment":
			
			mysql_query("UPDATE `billing_visit` SET `billing_visit_time_out`= '".$waktu."',`billing_visit_status`='".$_POST['payment_order_detail_payment_status']."',`billing_visit_description`='".$_POST['payment_order_detail_payment_description']."',`billing_visit_datetime`= '".$waktu_sekarang."',`user_id`= '".$_SESSION['user_id']."' WHERE billing_visit_id = '".$_POST['billing_visit_id']."'");
			
			$billing_visit_detail_id = idbaru("billing_visit_detail","billing_visit_detail_id");
			
			mysql_query("INSERT INTO `billing_visit_detail`(`billing_visit_detail_id`, `billing_visit_id`, `billing_visit_detail_nominal`, `billing_visit_detail_description`) VALUES ('".$billing_visit_detail_id."','".$_POST['billing_visit_id']."','".$_POST['billing_visit_detail_payment_nominal']."','".$_POST['payment_order_detail_payment_description']."')");
		
		header("location:../system/page_home.php?alimms=dashboard");	
		
		break;
		
		case "form-view-billing-visit-dashboard":
			form_view_billing_visit_dashboard();
		break;
		
		case "form-view-sales-visit-order":
			form_view_sales_visit_order();
		break;
		
		case "form-view-sales-visit-not-order":
			form_view_sales_visit_not_order();
		break;
		
		case "form-search-call-book-salesman-dashboard":
			form_search_call_book_salesman_dashboard();
		break;
		
		case "form-result-call-book-salesman-dashboard":
			form_result_call_book_salesman_dashboard();
		break;
		
		case "move-sales-schedule-no":
			
			mysql_query("UPDATE sales_schedule_detail SET sales_schedule_no = '0' WHERE sales_schedule_detail_id = '".$_POST['sales_schedule_detail_id']."'");
			
			$awal = $_POST['sales_schedule_no_awal'];
			$akhir = $_POST['sales_schedule_no_akhir'];
			
			if($awal > $akhir){
				$loop = $awal - $akhir;
				for($a = 0; $a < $loop; $a++){
					$last = $akhir + $a;
					$new = $last + 1;
					$tbl_sales_schedule_detail = mysql_query("SELECT sales_schedule_detail_id FROM sales_schedule_detail WHERE sales_schedule_id = '".$_POST['sales_schedule_id']."' AND sales_schedule_no = '".$last."'");
					$data_tbl_sales_schedule_detail = mysql_fetch_array($tbl_sales_schedule_detail);
					
					$sales_schedule_detail_id[] = $data_tbl_sales_schedule_detail['sales_schedule_detail_id'];
					$sales_schedule_no[] = $new;
					
				}
			} else {
				$loop = $akhir - $awal;
				for($a = 1; $a <= $loop; $a++){
					$last = $awal + $a;
					$new = $last - 1;
					$tbl_sales_schedule_detail = mysql_query("SELECT sales_schedule_detail_id FROM sales_schedule_detail WHERE sales_schedule_id = '".$_POST['sales_schedule_id']."' AND sales_schedule_no = '".$last."'");
					$data_tbl_sales_schedule_detail = mysql_fetch_array($tbl_sales_schedule_detail);
					
					$sales_schedule_detail_id[] = $data_tbl_sales_schedule_detail['sales_schedule_detail_id'];
					$sales_schedule_no[] = $new;
				}
			}
			
			
			for($n = 0; $n <= count($sales_schedule_detail_id); $n++){
				mysql_query("UPDATE sales_schedule_detail SET sales_schedule_no = '".$sales_schedule_no[$n]."' WHERE sales_schedule_detail_id = '".$sales_schedule_detail_id[$n]."'");
			
			}
			
			mysql_query("UPDATE sales_schedule_detail SET sales_schedule_no = '".$akhir."' WHERE sales_schedule_no = '0' AND sales_schedule_id = '".$_POST['sales_schedule_id']."'");
			
			header("location:../system/page_home.php?alimms=dashboard&tib=form-view-sales-schedule-entry-by-sales&sales_schedule_id=".$_POST['sales_schedule_id']); 
		break;
		
	}
?>