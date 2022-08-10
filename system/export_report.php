<?php

        if ($_GET['tib'] == "export-by-product-sell")
	{
		include "../script_conn.php";
		require('../fpdf/fpdf.php');
		require('../library/currency.php');
		require('../library/datetime.php');
		
		$sales_invoice_from_date_indo = tanggal_indo($_GET['sales_invoice_from_date']);
		$sales_invoice_to_date_indo = tanggal_indo($_GET['sales_invoice_from_date']);

		$pdf = new FPDF('L','mm',array(210,297)); //L For Landscape / P For Portrait
		$pdf->AddPage();
		$pdf->setFont('Arial','B',18);
		$pdf->Cell(280,10,'LAPORAN PENJUALAN SALESMAN',0,0,'C');
		$pdf->ln(8);
		$pdf->setFont('Arial','B',16);
		$pdf->Cell(280,10,'BERDASARKAN HARGA PRODUK',0,0,'C');
		$pdf->ln(8);
		$pdf->setFont('Arial','',12);
		$pdf->Cell(280,10,'Dari '.$sales_invoice_from_date_indo.' sampai '.$sales_invoice_to_date_indo.'',0,0,'C');
		$pdf->ln(20);
		$pdf->SetFillColor(192,192,192);
		$pdf->setFont('Arial','B',14);
		$pdf->Cell(45,8,'',0,0,'C');
		$pdf->Cell(10,8,'No',1,0,'C',true);
		$pdf->Cell(50,8,'Salesman',1,0,'C',true);
		$pdf->Cell(50,8,'Penjualan',1,0,'C',true);
		$pdf->Cell(45,8,'Potongan',1,0,'C',true);
		$pdf->Cell(40,8,'Sub Total',1,0,'C',true);
		$pdf->ln(8);

		$sales_invoice_from_date = $_GET['sales_invoice_from_date'];		
		$sales_invoice_to_date = $_GET['sales_invoice_to_date'];
		$n=1;

		$tbl_user = mysql_query("SELECT d.user_id, d.user_name FROM sales_invoice a, sales_order b, sales_request c, user d WHERE a.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' AND a.sales_invoice_status = 'Posted' AND d.user_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.salesman_id = d.user_id GROUP BY d.user_id ORDER BY d.user_name");
		while($data_tbl_user = mysql_fetch_array($tbl_user))
		{

			$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_product_sell_quantity * c.sales_order_detail_product_sell_price) AS total_price_product_sell, SUM(c.sales_order_detail_program_bonus * f.product_sell_price_detail_product_sell_price) AS total_price_program_bonus, SUM(c.sales_order_detail_product_sell_quantity * c.sales_order_detail_piece_discount) AS total_price_piece_discount, SUM(c.sales_order_detail_product_sell_quantity * c.sales_order_detail_cash_discount) AS total_price_cash_discount, SUM((c.sales_order_detail_product_sell_quantity + c.sales_order_detail_program_bonus) * c.sales_order_detail_delivery_cost_price) AS total_price_delivery_cost_price, SUM((c.sales_order_detail_product_sell_quantity * c.sales_order_detail_product_sell_price) - (c.sales_order_detail_program_bonus * f.product_sell_price_detail_product_sell_price) - (c.sales_order_detail_product_sell_quantity * c.sales_order_detail_piece_discount) - (c.sales_order_detail_product_sell_quantity * c.sales_order_detail_cash_discount) + ((c.sales_order_detail_product_sell_quantity + c.sales_order_detail_program_bonus) * c.sales_order_detail_delivery_cost_price)) AS sub_total_price_sales_product_sell FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, product_sell_price e, product_sell_price_detail f WHERE a.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' AND a.sales_invoice_status = 'Posted' AND e.product_sell_price_name = 'HPP' AND d.salesman_id = '".$data_tbl_user['user_id']."' AND e.product_sell_price_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND c.product_sell_id = f.product_sell_id AND e.product_sell_price_id = f.product_sell_price_id");
			$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
									
			$total_price_product_sell_indo = format_angka($data_tbl_sales_order_detail['total_price_product_sell']);
			$total_price_program_bonus_indo = format_angka($data_tbl_sales_order_detail['total_price_program_bonus']);
			$total_price_piece_discount_indo = format_angka($data_tbl_sales_order_detail['total_price_piece_discount']);
			$total_price_cash_discount_indo = format_angka($data_tbl_sales_order_detail['total_price_cash_discount']);
			$total_price_delivery_cost_price_indo = format_angka($data_tbl_sales_order_detail['total_price_delivery_cost_price']);
			$sub_total_price_sales_product_sell_indo = format_angka($data_tbl_sales_order_detail['sub_total_price_sales_product_sell']);
										
			$tbl_sum_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_product_sell_quantity * c.sales_order_detail_product_sell_price) AS total_price_product_sell, SUM(c.sales_order_detail_program_bonus * f.product_sell_price_detail_product_sell_price) AS total_price_program_bonus, SUM(c.sales_order_detail_product_sell_quantity * c.sales_order_detail_piece_discount) AS total_price_piece_discount, SUM(c.sales_order_detail_product_sell_quantity * c.sales_order_detail_cash_discount) AS total_price_cash_discount, SUM((c.sales_order_detail_product_sell_quantity + c.sales_order_detail_program_bonus) * c.sales_order_detail_delivery_cost_price) AS total_price_delivery_cost_price, SUM((c.sales_order_detail_product_sell_quantity * c.sales_order_detail_product_sell_price) - (c.sales_order_detail_program_bonus * f.product_sell_price_detail_product_sell_price) - (c.sales_order_detail_product_sell_quantity * c.sales_order_detail_piece_discount) - (c.sales_order_detail_product_sell_quantity * c.sales_order_detail_cash_discount) + ((c.sales_order_detail_product_sell_quantity + c.sales_order_detail_program_bonus) * c.sales_order_detail_delivery_cost_price)) AS sub_total_price_sales_product_sell FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, product_sell_price e, product_sell_price_detail f WHERE a.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' AND a.sales_invoice_status = 'Posted' AND e.product_sell_price_name = 'HPP' AND  e.product_sell_price_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND c.product_sell_id = f.product_sell_id AND e.product_sell_price_id = f.product_sell_price_id");
			$data_tbl_sum_sales_order_detail = mysql_fetch_array($tbl_sum_sales_order_detail);
										
			$sum_price_product_sell_indo = format_angka($data_tbl_sum_sales_order_detail['total_price_product_sell']);
			$sum_price_piece_discount_indo = format_angka($data_tbl_sum_sales_order_detail['total_price_piece_discount']);
			$sum_sub_total_price_sales_product_sell_indo = format_angka($data_tbl_sum_sales_order_detail['sub_total_price_sales_product_sell']);
	
			$pdf->setFont('Arial','B',12);
			$pdf->Cell(45,7,'',0,0,'C');
			$pdf->Cell(10,7,$n,1,0,'C');
			$pdf->Cell(50,7,$data_tbl_user['user_name'],1,0,'C');
			$pdf->Cell(50,7,$total_price_product_sell_indo,1,0,'C');
			$pdf->Cell(45,7,$total_price_piece_discount_indo,1,0,'C');
			$pdf->Cell(40,7,$sub_total_price_sales_product_sell_indo,1,0,'C');
			$pdf->ln(7);
			$n++;
		}
			$pdf->SetFillColor(192,192,192);
			$pdf->setFont('Arial','B',14);
			$pdf->Cell(45,8,'',0,0,'C');
			$pdf->Cell(60,8,'Total',1,0,'C',true);
			$pdf->Cell(50,8,$sum_price_product_sell_indo,1,0,'C',true);
			$pdf->Cell(45,8,$sum_price_piece_discount_indo,1,0,'C',true);
			$pdf->Cell(40,8,$sum_sub_total_price_sales_product_sell_indo,1,0,'C',true);
			$pdf->ln(5);

			//outPDF
			$pdf->Output();
         }
            elseif ($_GET['tib'] == "export-by-target-on-month")
	{
		include "../script_conn.php";
		require('../fpdf/fpdf.php');
		require('../library/currency.php');
		require('../library/datetime.php');

                $tgl_sekarang = date("Y-m-d");
		$thn_sekarang = date("Y");
		
		$blnthn_sekarang = date("Y-m");
		$blnthn_sebelum = date("Y-m", mktime(0,0,0, date("m") - 1, date("d"), date("Y")));
		
		$bln_sekarang = date("m");
		$bln_sebelum = date("m", mktime(0,0,0, date("m") - 1, date("d"), date("Y")));
		
		$tgl_sekarang_awal = date('Y-m-01', strtotime($tgl_sekarang));
		$tgl_sekarang_akhir = date('Y-m-t', strtotime($tgl_sekarang));
		
		$bln_sekarang_awal = date('Y-01', strtotime($tgl_sekarang));
		$bln_sekarang_akhir = date('Y-m', strtotime($tgl_sekarang));

		$pdf = new FPDF('L','mm',array(210,320)); //L For Landscape / P For Portrait
		$pdf->AddPage();
		$pdf->setFont('Arial','B',18);
		$pdf->Cell(300,10,'LAPORAN PENJUALAN SALESMAN',0,0,'C');
		$pdf->ln(8);
		$pdf->setFont('Arial','B',16);
		$pdf->Cell(300,10,'BERDASARKAN TARGET PENJUALAN',0,0,'C');
		$pdf->ln(20);
		$pdf->SetFillColor(192,192,192);
		$pdf->setFont('Arial','B',14);
                $n = 1;
			$tbl_product_sell = mysql_query("SELECT product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
			while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
				{
		                     if($n == 1){
                                     
                                       $pdf->Cell(120,8,$data_tbl_product_sell['product_sell_name'],1,0,'C',true);

                                     } else {
					
					$pdf->Cell(90,8,$data_tbl_product_sell['product_sell_name'],1,0,'C',true);
                                     }
                                     $n++;
				}
		$pdf->ln(8);
                $pdf->Cell(30,8,'Bulan',1,0,'C',true);
                        $tbl_product_sell = mysql_query("SELECT product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
			while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
				{
		
					$pdf->Cell(30,8,'Target',1,0,'C',true);
					$pdf->Cell(30,8,'Actual',1,0,'C',true);
		                        $pdf->Cell(30,8,'Prosentase',1,0,'C',true);
				}
		$pdf->ln(8);

                      $tbl_sales_invoice_on_month = mysql_query("SELECT DATE_FORMAT(sales_invoice_date, '%m') AS sales_invoice_date_on_month FROM sales_invoice WHERE DATE_FORMAT(sales_invoice_date, '%Y-%m') BETWEEN '".$bln_sekarang_awal."' AND '".$bln_sekarang_akhir."' AND sales_invoice_status = 'Posted' GROUP BY sales_invoice_date_on_month");
		      while($data_tbl_sales_invoice_on_month = mysql_fetch_array($tbl_sales_invoice_on_month))
			{

                             $blnthn_sekarang = $thn_sekarang.'-'.$data_tbl_sales_invoice_on_month['sales_invoice_date_on_month'];

			     $sales_invoice_date_on_month_indo = bulan($data_tbl_sales_invoice_on_month['sales_invoice_date_on_month']);
                             $pdf->Cell(30,8,$sales_invoice_date_on_month_indo,1,0,'C');

                             $tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1'");
			     while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
				{
				    $tbl_sales_target_detail = mysql_query("SELECT SUM(b.sales_target_detail_product_sell_quantity) AS sales_target_detail_product_sell_quantity FROM sales_target a, sales_target_detail b WHERE a.sales_target_period = '".$blnthn_sekarang."' AND a.sales_target_active = '1' AND b.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.sales_target_id = b.sales_target_id");
				    $data_tbl_sales_target_detail = mysql_fetch_array($tbl_sales_target_detail);
													
				    $sales_target_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_target_detail['sales_target_detail_product_sell_quantity']);
													
				    $tbl_sales_order_detail = mysql_query("SELECT SUM(b.sales_order_detail_product_sell_quantity) AS sales_order_detail_product_sell_quantity FROM sales_invoice a, sales_order_detail b WHERE DATE_FORMAT(a.sales_invoice_date, '%m') = '".$data_tbl_sales_invoice_on_month['sales_invoice_date_on_month']."' AND a.sales_invoice_status = 'Posted' AND b.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.sales_order_id = b.sales_order_id");
				    $data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
											
				    $sales_order_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity']);
											
				    $prosentase_product_sell_quantity = round(($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity'] / $data_tbl_sales_target_detail['sales_target_detail_product_sell_quantity']) * 100, 2);

                             $pdf->Cell(30,8,$sales_target_detail_product_sell_quantity_indo,1,0,'C');
                             $pdf->Cell(30,8,$sales_order_detail_product_sell_quantity_indo,1,0,'C');
                             $pdf->Cell(30,8,$prosentase_product_sell_quantity.'%',1,0,'C');

                                 }
		             $pdf->ln(8);
                        }
               $pdf->Output();

         }
           else
         {
                include "../script_conn.php";
		require('../fpdf/fpdf.php');
		require('../library/currency.php');
		require('../library/datetime.php');
                $sales_invoice_from_date_indo = tanggal_indo($_GET['sales_invoice_from_date']);
		$sales_invoice_to_date_indo = tanggal_indo($_GET['sales_invoice_from_date']);

		$pdf = new FPDF('L','mm',array(210,297)); //L For Landscape / P For Portrait
		$pdf->AddPage();
		$pdf->setFont('Arial','B',18);
		$pdf->Cell(280,10,'LAPORAN PENJUALAN SALESMAN',0,0,'C');
		$pdf->ln(8);
		$pdf->setFont('Arial','B',16);
		$pdf->Cell(280,10,'BERDASARKAN QUANTITY PRODUK',0,0,'C');
		$pdf->ln(8);
		$pdf->setFont('Arial','',12);
		$pdf->Cell(280,10,'Dari '.$sales_invoice_from_date_indo.' sampai '.$sales_invoice_to_date_indo.'',0,0,'C');
		$pdf->ln(20);
		$pdf->SetFillColor(192,192,192);
		$pdf->setFont('Arial','B',14);
		$pdf->Cell(45,8,'',0,0,'C');
		$pdf->Cell(10,8,'No',1,0,'C',true);
		$pdf->Cell(60,8,'Salesman',1,0,'C',true);
			$tbl_product_sell = mysql_query("SELECT product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
			while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
				{
		
					$pdf->Cell(40,8,$data_tbl_product_sell['product_sell_name'],1,0,'C',true);
		
				}
		$pdf->ln(8);

		$sales_invoice_from_date = $_GET['sales_invoice_from_date'];		
		$sales_invoice_to_date = $_GET['sales_invoice_to_date'];
		$n=1;
		
		$tbl_user = mysql_query("SELECT d.user_id, d.user_name FROM sales_invoice a, sales_order b, sales_request c, user d WHERE a.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' AND a.sales_invoice_status = 'Posted' AND d.user_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.salesman_id = d.user_id GROUP BY d.user_id ORDER BY d.user_name");
		while($data_tbl_user = mysql_fetch_array($tbl_user))
		{
			$pdf->setFont('Arial','B',12);
			$pdf->Cell(45,8,'',0,0,'C');
			$pdf->Cell(10,8,$n,1,0,'C');
			$pdf->Cell(60,8,$data_tbl_user['user_name'],1,0,'C');
			$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
			while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
				{
					$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_product_sell_quantity) AS sales_order_detail_product_sell_quantity, SUM(c.sales_order_detail_program_bonus) AS sales_order_detail_program_bonus, SUM(c.sales_order_detail_product_sell_quantity + c.sales_order_detail_program_bonus) AS sales_order_detail_product_sell_total_quantity FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE a.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.salesman_id = '".$data_tbl_user['user_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
					$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
											
					$sales_order_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity']);
					$sales_order_detail_program_bonus_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_program_bonus']);
					$sales_order_detail_product_sell_total_quantity_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_total_quantity']);

					$pdf->Cell(40,8,$sales_order_detail_product_sell_quantity_indo,1,0,'C');

				}
			$n++;
			$pdf->ln(8);
		}	

			$pdf->SetFillColor(192,192,192);
			$pdf->setFont('Arial','B',14);
			$pdf->Cell(45,8,'',0,0,'C');
			$pdf->Cell(70,8,'Total',1,0,'C',true);
			$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
			while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
				{
					$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_product_sell_quantity) AS sales_order_detail_product_sell_quantity, SUM(c.sales_order_detail_program_bonus) AS sales_order_detail_program_bonus, SUM(c.sales_order_detail_product_sell_quantity + c.sales_order_detail_program_bonus) AS sales_order_detail_product_sell_total_quantity FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE a.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
					$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
					
					$pdf->Cell(40,8,$data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity'],1,0,'C',true);

				}
			$pdf->ln(5);

			//outPDF
			$pdf->Output();
                }
?>