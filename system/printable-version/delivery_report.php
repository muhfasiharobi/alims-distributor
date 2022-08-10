<?php
	error_reporting(0);
	ob_start();
	session_start();
	
	include "../../conn.php";
	include "../../library/currency.php";
	include "../../library/number.php";
	include "../../library/datetime.php";
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<html>
<head>
<meta charset="utf-8"/>
<title>Alimms | Art of Business Process Management</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<style type="text/css">
	#header-table
	{
		font: 15px Verdana, Arial, Sans-Serif;
		color: #666;
		width: 100%;
	}
	
	#content-table
	{
		border-collapse: collapse;
		font: 12px Verdana, Arial, Sans-Serif;
		color: #666;
		width: 100%;
	}
	
	#content-table th
	{
		background: #418AA4;
		color: #fff;
		font-weight: bold;
	}
	
	#content-table tr
	{
		background: #fafafa;
	}
	  
	#content-table th, #content-table td
	{
		vertical-align: middle;
		padding: 5px 10px;
		border: 1px solid #fff;
	}
	  
	#content-table tr:nth-child(even)
	{
		background: #f5f5f5;
	}
</style>
<link rel="shortcut icon" href="../../favicon.ico"/>
</head>
<body onload="window.print(); history.back();">
<?php
	$deliveryDate = explode("-", $_GET['delivery_date']);
	$DatedeliveryDate = $deliveryDate[0];
	$MonthdeliveryDate = $deliveryDate[1];
	$YeardeliveryDate = $deliveryDate[2];
	$delivery_date = date("Y-m-d", mktime(0, 0, 0, $MonthdeliveryDate, $DatedeliveryDate, $YeardeliveryDate));
	
	$delivery_date_indo = tanggal_indo($delivery_date);
	
	if ($_GET['tib'] == "form-print-by-vehicle-in-quantity-delivery-report")
	{
?>
	<table id="header-table">
		<tbody>
			<tr>
				<td style="width: 50%;" rowspan="4"><img src="../../assets/admin/pages/media/invoice/walmart3.png"/></td>
			</tr>
			<tr>
				<td style="text-align: right;">LAPORAN PENGIRIMAN</td>
			</tr>
			<tr>
				<td style="text-align: right;">BY KENDARAAN IN QUANTITY</td>
			</tr>
			<tr>
				<td style="font-size: 11px; text-align: right;">Periode <?php echo $delivery_date_indo ?></td>
			</tr>
		</tbody>
	</table>
	<br />
	<table id="content-table">
		<thead>
			<tr>
				<th rowspan=2>
					No
				</th>
				<th rowspan=2>
					Kendaraan
				</th>
				<th rowspan=2>
					Sesi
				</th>
				<th rowspan=2>
					Faktur
				</th>
				<th rowspan=2>
					Pelanggan
				</th>
				<th rowspan=2>
					Kecamatan
				</th>
				<th colspan=3>
					Rencana Pengiriman
				</th>
				<th colspan=3>
					Realisasi Pengiriman
				</th>
				<th rowspan=2>
					Status
				</th>
			</tr>
			<tr>
		<?php
			$tbl_product_sell = mysql_query("SELECT product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
			while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
			{
		?>
				<th>
					<?php echo $data_tbl_product_sell['product_sell_name'] ?>
				</th>
		<?php
			}
		?>
		<?php
			$tbl_product_sell = mysql_query("SELECT product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
			while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
			{
		?>
				<th>
					<?php echo $data_tbl_product_sell['product_sell_name'] ?>
				</th>
		<?php
			}
		?>
			</tr>
		</thead>
		<tbody>
		<?php
			$no = 1;
			$tbl_delivery_vehicle = mysql_query("SELECT c.delivery_vehicle_id, c.delivery_vehicle_license, c.delivery_vehicle_name FROM delivery_plan a, delivery_schedule b, delivery_vehicle c WHERE c.delivery_vehicle_active = '1' AND b.delivery_schedule_date = '".$delivery_date."' AND a.delivery_schedule_id = b.delivery_schedule_id AND b.delivery_vehicle_id = c.delivery_vehicle_id GROUP BY c.delivery_vehicle_id ORDER BY c.delivery_vehicle_license");
			while($data_tbl_delivery_vehicle = mysql_fetch_array($tbl_delivery_vehicle))
			{
		?>
				<tr>
					<td style="width: 3%; text-align: center;">
						<?php echo $no ?>
					</td>
					<td colspan="12" style="text-align: left;">
						(<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_license'] ?>)<br />
						<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_name'] ?>
					</td>
			<?php
				$tbl_delivery_session = mysql_query("SELECT c.delivery_session_id, c.delivery_session_name FROM delivery_plan a, delivery_schedule b, delivery_session c WHERE c.delivery_session_active = '1' AND b.delivery_schedule_date = '".$delivery_date."' AND b.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.delivery_session_id = c.delivery_session_id GROUP BY c.delivery_session_id ORDER BY c.delivery_session_name");
				while($data_tbl_delivery_session = mysql_fetch_array($tbl_delivery_session))
				{
			?>
					<tr>
						<td colspan="2">
						</td>
						<td colspan="11">
							<?php echo $data_tbl_delivery_session['delivery_session_name'] ?>
						</td>
				<?php
					$tbl_delivery_plan = mysql_query("SELECT a.delivery_plan_id, c.sales_invoice_no, c.sales_invoice_date, d.sales_order_id, f.customer_code, f.customer_name, g.customer_type_name, h.customer_districts_name FROM delivery_plan a, delivery_schedule b, sales_invoice c, sales_order d, sales_request e, customer f, customer_type g, customer_districts h WHERE b.delivery_schedule_date = '".$delivery_date."' AND a.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND b.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id AND d.sales_request_id = e.sales_request_id AND e.customer_id = f.customer_id AND f.customer_type_id = g.customer_type_id AND f.customer_districts_id = h.customer_districts_id ORDER BY c.sales_invoice_no");
					while($data_tbl_delivery_plan = mysql_fetch_array($tbl_delivery_plan))
					{
						$sales_invoice_date_indo = tanggal_indo($data_tbl_delivery_plan['sales_invoice_date']);
						
						$tbl_delivery_visit = mysql_query("SELECT delivery_visit_description, delivery_visit_status FROM delivery_visit WHERE delivery_plan_id = '".$data_tbl_delivery_plan['delivery_plan_id']."'");
						$data_tbl_delivery_visit = mysql_fetch_array($tbl_delivery_visit);
				?>
						<tr>
							<td colspan="3">
							</td>
							<td>
								<?php echo $data_tbl_delivery_plan['sales_invoice_no'] ?><br />
								<?php echo $sales_invoice_date_indo ?>
							</td>
							<td>
								<?php echo $data_tbl_delivery_plan['customer_type_name'] ?><br />
								<?php echo $data_tbl_delivery_plan['customer_code'] ?> - <?php echo $data_tbl_delivery_plan['customer_name'] ?>
							</td>
							<td>
								<?php echo $data_tbl_delivery_plan['customer_districts_name'] ?>
							</td>
					<?php
						$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
						while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
						{
							$tbl_sales_order_detail = mysql_query("SELECT sales_order_detail_quantity, sales_order_detail_bonus FROM sales_order_detail WHERE sales_order_id = '".$data_tbl_delivery_plan['sales_order_id']."' AND product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
							$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
							
							$sales_order_detail_quantity = format_angka($data_tbl_sales_order_detail['sales_order_detail_quantity']);
							$sales_order_detail_bonus = format_angka($data_tbl_sales_order_detail['sales_order_detail_bonus']);
					?>
							<td>
						<?php
							if ($data_tbl_sales_order_detail['sales_order_detail_quantity'] == "")
							{
						?>
								0
						<?php
							}
							else
							{
						?>
								<?php echo $sales_order_detail_quantity ?> Crt +<br />
								Bonus (<?php echo $sales_order_detail_bonus ?>) Crt
						<?php
							}
						?>
							</td>
					<?php
						}
					?>
					<?php
						$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
						while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
						{
							$tbl_sales_order_detail = mysql_query("SELECT a.delivery_visit_status, d.sales_order_detail_quantity, d.sales_order_detail_bonus FROM delivery_visit a, delivery_plan b, sales_invoice c, sales_order_detail d WHERE d.sales_order_id = '".$data_tbl_delivery_plan['sales_order_id']."' AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id");
							$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
							
							$sales_order_detail_quantity = format_angka($data_tbl_sales_order_detail['sales_order_detail_quantity']);
							$sales_order_detail_bonus = format_angka($data_tbl_sales_order_detail['sales_order_detail_bonus']);
					?>
							<td>
						<?php
							if ($data_tbl_sales_order_detail['delivery_visit_status'] == "Not Delivered")
							{
						?>
								0
						<?php
							}
							elseif ($data_tbl_sales_order_detail['delivery_visit_status'] == "Delivered")
							{
						?>
								<?php echo $sales_order_detail_quantity ?> Crt +<br />
								Bonus (<?php echo $sales_order_detail_bonus ?>) Crt
						<?php
							}
							else
							{
						?>
								0
						<?php
							}
						?>
							</td>
					<?php
						}
					?>
							<td>
						<?php
							if ($data_tbl_delivery_visit['delivery_visit_status'] == "Call")
							{
						?>
								<span class="label label-primary label-sm">Call</span>
						<?php
							}
							elseif ($data_tbl_delivery_visit['delivery_visit_status'] == "Delivered")
							{
						?>
								<span class="label label-success label-sm">Delivered</span>
						<?php
							}
							else
							{
						?>
								<span class="label label-danger label-sm">Not Delivered</span><br />
								<?php echo $data_tbl_delivery_visit['delivery_visit_description'] ?>
								
						<?php
							}
						?>
							</td>
						</tr>
				<?php
					}
				?>
					</tr>
					<tr style="font-size: 12px; font-weight: 600;">
						<td colspan="6">
							Sub Total
						</td>
				<?php
					$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
					while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
						$tbl_sales_order_detail = mysql_query("SELECT SUM(d.sales_order_detail_quantity) AS total_quantity, SUM(d.sales_order_detail_bonus) AS total_bonus FROM delivery_plan a, delivery_schedule b, sales_invoice c, sales_order_detail d WHERE a.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND b.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id");
						$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
						
						$total_quantity = format_angka($data_tbl_sales_order_detail['total_quantity']);
						$total_bonus = format_angka($data_tbl_sales_order_detail['total_bonus']);
				?>
						<td>
					<?php
						if ($data_tbl_sales_order_detail['total_quantity'] == "")
						{
					?>
							0
					<?php
						}
						else
						{
					?>
							<?php echo $total_quantity?> Crt +<br />
							Bonus (<?php echo $total_bonus ?>) Crt
					<?php
						}
					?>
						</td>
				<?php
					}
				?>
				<?php
					$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
					while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
						$tbl_sales_order_detail = mysql_query("SELECT a.delivery_visit_status, SUM(e.sales_order_detail_quantity) AS total_quantity, SUM(e.sales_order_detail_bonus) AS total_bonus FROM delivery_visit a, delivery_plan b, delivery_schedule c, sales_invoice d, sales_order_detail e WHERE a.delivery_visit_status = 'Delivered' AND b.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND c.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND e.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.delivery_schedule_id = c.delivery_schedule_id AND b.sales_invoice_id = d.sales_invoice_id AND d.sales_order_id = e.sales_order_id");
						$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
						
						$total_quantity = format_angka($data_tbl_sales_order_detail['total_quantity']);
						$total_bonus = format_angka($data_tbl_sales_order_detail['total_bonus']);
				?>
						<td>
					<?php
						if ($data_tbl_sales_order_detail['delivery_visit_status'] == "Not Delivered")
						{
					?>
							0
					<?php
						}
						elseif ($data_tbl_sales_order_detail['delivery_visit_status'] == "Delivered")
						{
					?>
							<?php echo $total_quantity ?> Crt +<br />
							Bonus (<?php echo $total_bonus ?>) Crt
					<?php
						}
						else
						{
					?>
							0
					<?php
						}
					?>
						</td>
				<?php
					}
				?>
						<td>
						</td>
					</tr>
			<?php
				}
			?>
				</tr>
				<tr style="font-size: 12px; font-weight: 600;">
					<td colspan="6">
						Total
					</td>
			<?php
				$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
				while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
				{
					$tbl_sales_order_detail = mysql_query("SELECT SUM(d.sales_order_detail_quantity) AS total_quantity, SUM(d.sales_order_detail_bonus) AS total_bonus FROM delivery_plan a, delivery_schedule b, sales_invoice c, sales_order_detail d WHERE b.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id");
					$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
					
					$total_quantity = format_angka($data_tbl_sales_order_detail['total_quantity']);
					$total_bonus = format_angka($data_tbl_sales_order_detail['total_bonus']);
			?>
					<td>
				<?php
					if ($data_tbl_sales_order_detail['total_quantity'] == "")
					{
				?>
						0
				<?php
					}
					else
					{
				?>
						<?php echo $total_quantity?> Crt +<br />
						Bonus (<?php echo $total_bonus ?>) Crt
				<?php
					}
				?>
					</td>
			<?php
				}
			?>
			<?php
				$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
				while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
				{
					$tbl_sales_order_detail = mysql_query("SELECT SUM(e.sales_order_detail_quantity) AS total_quantity, SUM(e.sales_order_detail_bonus) AS total_bonus FROM delivery_visit a, delivery_plan b, delivery_schedule c, sales_invoice d, sales_order_detail e WHERE a.delivery_visit_status = 'Delivered' AND c.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND e.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.delivery_schedule_id = c.delivery_schedule_id AND b.sales_invoice_id = d.sales_invoice_id AND d.sales_order_id = e.sales_order_id");
					$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
					
					$total_quantity = format_angka($data_tbl_sales_order_detail['total_quantity']);
					$total_bonus = format_angka($data_tbl_sales_order_detail['total_bonus']);
			?>
					<td>
				<?php
					if ($data_tbl_sales_order_detail['total_quantity'] == "")
					{
				?>
						0
				<?php
					}
					else
					{
				?>
						<?php echo $total_quantity?> Crt +<br />
						Bonus (<?php echo $total_bonus ?>) Crt
				<?php
					}
				?>
					</td>
			<?php
				}
			?>
					<td>
					</td>
				</tr>
		<?php
			$no++;
			}
		?>
		</tbody>
		<thead>
			<tr>
				<th colspan="6">
					Grand Total
				</th>
		<?php
			$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
			while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
			{
				$tbl_sales_order_detail = mysql_query("SELECT SUM(d.sales_order_detail_quantity) AS total_quantity, SUM(d.sales_order_detail_bonus) AS total_bonus FROM delivery_plan a, delivery_schedule b, sales_invoice c, sales_order_detail d WHERE b.delivery_schedule_date = '".$delivery_date."' AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id");
				$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
				
				$total_quantity = format_angka($data_tbl_sales_order_detail['total_quantity']);
				$total_bonus = format_angka($data_tbl_sales_order_detail['total_bonus']);
		?>
				<th>
			<?php
				if ($data_tbl_sales_order_detail['total_quantity'] == "")
				{
			?>
					0
			<?php
				}
				else
				{
			?>
					<?php echo $total_quantity?> Crt +<br />
					Bonus (<?php echo $total_bonus ?>) Crt
			<?php
				}
			?>
				</th>
		<?php
			}
		?>
		<?php
			$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
			while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
			{
				$tbl_sales_order_detail = mysql_query("SELECT SUM(e.sales_order_detail_quantity) AS total_quantity, SUM(e.sales_order_detail_bonus) AS total_bonus FROM delivery_visit a, delivery_plan b, delivery_schedule c, sales_invoice d, sales_order_detail e WHERE a.delivery_visit_status = 'Delivered' AND c.delivery_schedule_date = '".$delivery_date."' AND e.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.delivery_schedule_id = c.delivery_schedule_id AND b.sales_invoice_id = d.sales_invoice_id AND d.sales_order_id = e.sales_order_id");
				$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
				
				$total_quantity = format_angka($data_tbl_sales_order_detail['total_quantity']);
				$total_bonus = format_angka($data_tbl_sales_order_detail['total_bonus']);
		?>
				<th>
			<?php
				if ($data_tbl_sales_order_detail['total_quantity'] == "")
				{
			?>
					0
			<?php
				}
				else
				{
			?>
					<?php echo $total_quantity?> Crt +<br />
					Bonus (<?php echo $total_bonus ?>) Crt
			<?php
				}
			?>
				</th>
		<?php
			}
		?>
				<th>
				</th>
			</tr>
		</thead>
	</table>
<?php
	}
?>
	<small><i>Di Cetak Oleh : <?php echo $_SESSION['user_name'] ?> | <?php echo date("d-m-Y H:i:s") ?></i></small>
</body>
</html>