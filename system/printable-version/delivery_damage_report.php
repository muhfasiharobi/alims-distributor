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
	
	if ($_GET['tib'] == "form-print-by-vehicle-in-quantity-delivery-damage-report")
	{
		if ($_GET['delivery_vehicle_id'] == '0')
		{
?>
			<table id="header-table">
				<tbody>
					<tr>
						<td style="width: 50%;" rowspan="4"><img src="../../assets/admin/pages/media/invoice/walmart3.png"/></td>
					</tr>
					<tr>
						<td style="text-align: right;">LAPORAN KERUSAKAN PENGIRIMAN</td>
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
						<th colspan=3>
							Rencana Pengiriman
						</th>
						<th colspan=3>
							Buffer Pengiriman
						</th>
						<th colspan=3>
							Kerusakan Loading
						</th>
						<th colspan=3>
							Kerusakan Pengiriman
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
						<td style="width: 3%;">
							<?php echo $no ?>
						</td>
						<td colspan="14">
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
							<td>
								<?php echo $data_tbl_delivery_session['delivery_session_name'] ?>
							</td>
					<?php
						$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
						while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
						{
							$tbl_sales_order_detail = mysql_query("SELECT SUM(d.sales_order_detail_quantity) AS total_quantity, SUM(d.sales_order_detail_bonus) AS total_bonus FROM delivery_plan a, delivery_schedule b, sales_invoice c, sales_order_detail d WHERE a.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND b.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
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
								<?php echo $total_quantity ?> Crt +<br />
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
							$tbl_sales_order_detail = mysql_query("SELECT a.delivery_buffer_stock FROM delivery_buffer a, delivery_distribution b, delivery_plan c, delivery_schedule d WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND c.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND d.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_distribution_id = b.delivery_distribution_id AND b.delivery_schedule_id = c.delivery_schedule_id AND b.delivery_session_id = c.delivery_session_id AND c.delivery_schedule_id = d.delivery_schedule_id");
							$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
							
							$delivery_buffer_stock = format_angka($data_tbl_sales_order_detail['delivery_buffer_stock']);
					?>
							<td>
						<?php
							if ($data_tbl_sales_order_detail['delivery_buffer_stock'] == "0")
							{
						?>
								0
						<?php
							}
							else
							{
						?>
								<?php echo $delivery_buffer_stock ?> Crt
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
							$tbl_sales_order_detail = mysql_query("SELECT a.delivery_damage_loading FROM delivery_damage a, delivery_cheque b, delivery_distribution c, delivery_plan d, delivery_schedule e WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND e.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_cheque_id = b.delivery_cheque_id AND b.delivery_distribution_id = c.delivery_distribution_id AND c.delivery_schedule_id = d.delivery_schedule_id AND c.delivery_session_id = d.delivery_session_id AND d.delivery_schedule_id = e.delivery_schedule_id");
							$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
							
							$delivery_damage_loading = format_angka($data_tbl_sales_order_detail['delivery_damage_loading']);
					?>
							<td>
						<?php
							if ($data_tbl_sales_order_detail['delivery_damage_loading'] == "0")
							{
						?>
								0
						<?php
							}
							else
							{
						?>
								<?php echo $delivery_damage_loading ?> Crt
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
							$tbl_sales_order_detail = mysql_query("SELECT a.delivery_damage_handling FROM delivery_damage a, delivery_cheque b, delivery_distribution c, delivery_plan d, delivery_schedule e WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND e.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_cheque_id = b.delivery_cheque_id AND b.delivery_distribution_id = c.delivery_distribution_id AND c.delivery_schedule_id = d.delivery_schedule_id AND c.delivery_session_id = d.delivery_session_id AND d.delivery_schedule_id = e.delivery_schedule_id");
							$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
							
							$delivery_damage_handling = format_angka($data_tbl_sales_order_detail['delivery_damage_handling']);
					?>
							<td>
						<?php
							if ($data_tbl_sales_order_detail['delivery_damage_handling'] == "0")
							{
						?>
								0
						<?php
							}
							else
							{
						?>
								<?php echo $delivery_damage_handling ?> Crt
						<?php
							}
						?>
							</td>
					<?php
						}
					?>
						</tr>
				<?php
					}
				?>
					</tr>
					<tr style="font-size: 12px; font-weight: 600;">
						<td colspan="3">
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
						$tbl_delivery_buffer = mysql_query("SELECT SUM(a.delivery_buffer_stock) AS total_buffer_stock FROM delivery_buffer a, delivery_distribution b, delivery_schedule c WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND c.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_distribution_id = b.delivery_distribution_id AND b.delivery_schedule_id = c.delivery_schedule_id");
						$data_tbl_delivery_buffer = mysql_fetch_array($tbl_delivery_buffer);
						
						$total_buffer_stock = format_angka($data_tbl_delivery_buffer['total_buffer_stock']);
				?>
						<td>
					<?php
						if ($data_tbl_delivery_buffer['total_buffer_stock'] == "0")
						{
					?>
							0
					<?php
						}
						else
						{
					?>
							<?php echo $total_buffer_stock ?> Crt
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
						$tbl_delivery_damage_loading = mysql_query("SELECT SUM(a.delivery_damage_loading) AS total_damage_loading FROM delivery_damage a, delivery_cheque b, delivery_distribution c, delivery_schedule d WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_cheque_id = b.delivery_cheque_id AND b.delivery_distribution_id = c.delivery_distribution_id AND c.delivery_schedule_id = d.delivery_schedule_id");
						$data_tbl_delivery_damage_loading = mysql_fetch_array($tbl_delivery_damage_loading);
						
						$total_damage_loading = format_angka($data_tbl_delivery_damage_loading['total_damage_loading']);
				?>
						<td>
					<?php
						if ($data_tbl_delivery_damage_loading['total_damage_loading'] == "0")
						{
					?>
							0
					<?php
						}
						else
						{
					?>
							<?php echo $total_damage_loading ?> Crt
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
						$tbl_delivery_damage_handling = mysql_query("SELECT SUM(a.delivery_damage_handling) AS total_damage_handling FROM delivery_damage a, delivery_cheque b, delivery_distribution c, delivery_schedule d WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_cheque_id = b.delivery_cheque_id AND b.delivery_distribution_id = c.delivery_distribution_id AND c.delivery_schedule_id = d.delivery_schedule_id");
						$data_tbl_delivery_damage_handling = mysql_fetch_array($tbl_delivery_damage_handling);
						
						$total_damage_handling = format_angka($data_tbl_delivery_damage_handling['total_damage_handling']);
				?>
						<td>
					<?php
						if ($data_tbl_delivery_damage_handling['total_damage_handling'] == "0")
						{
					?>
							0
					<?php
						}
						else
						{
					?>
							<?php echo $total_damage_handling ?> Crt
					<?php
						}
					?>
						</td>
				<?php
					}
				?>
					</tr>
			<?php
				$no++;
				}
			?>
				</tbody>
				<thead>
					<tr>
						<th colspan="3">
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
						$tbl_delivery_buffer = mysql_query("SELECT SUM(a.delivery_buffer_stock) AS total_buffer_stock FROM delivery_buffer a, delivery_distribution b, delivery_schedule c WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND c.delivery_schedule_date = '".$delivery_date."' AND a.delivery_distribution_id = b.delivery_distribution_id AND b.delivery_schedule_id = c.delivery_schedule_id");
						$data_tbl_delivery_buffer = mysql_fetch_array($tbl_delivery_buffer);
						
						$total_buffer_stock = format_angka($data_tbl_delivery_buffer['total_buffer_stock']);
				?>
						<th>
					<?php
						if ($data_tbl_delivery_buffer['total_buffer_stock'] == "0")
						{
					?>
							0
					<?php
						}
						else
						{
					?>
							<?php echo $total_buffer_stock ?> Crt
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
						$tbl_delivery_damage_loading = mysql_query("SELECT SUM(a.delivery_damage_loading) AS total_damage_loading FROM delivery_damage a, delivery_cheque b, delivery_distribution c, delivery_schedule d WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.delivery_schedule_date = '".$delivery_date."' AND a.delivery_cheque_id = b.delivery_cheque_id AND b.delivery_distribution_id = c.delivery_distribution_id AND c.delivery_schedule_id = d.delivery_schedule_id");
						$data_tbl_delivery_damage_loading = mysql_fetch_array($tbl_delivery_damage_loading);
						
						$total_damage_loading = format_angka($data_tbl_delivery_damage_loading['total_damage_loading']);
				?>
						<th>
					<?php
						if ($data_tbl_delivery_damage_loading['total_damage_loading'] == "0")
						{
					?>
							0
					<?php
						}
						else
						{
					?>
							<?php echo $total_damage_loading ?> Crt
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
						$tbl_delivery_damage_handling = mysql_query("SELECT SUM(a.delivery_damage_handling) AS total_damage_handling FROM delivery_damage a, delivery_cheque b, delivery_distribution c, delivery_schedule d WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.delivery_schedule_date = '".$delivery_date."' AND a.delivery_cheque_id = b.delivery_cheque_id AND b.delivery_distribution_id = c.delivery_distribution_id AND c.delivery_schedule_id = d.delivery_schedule_id");
						$data_tbl_delivery_damage_handling = mysql_fetch_array($tbl_delivery_damage_handling);
						
						$total_damage_handling = format_angka($data_tbl_delivery_damage_handling['total_damage_handling']);
				?>
						<th>
					<?php
						if ($data_tbl_delivery_damage_handling['total_damage_handling'] == "0")
						{
					?>
							0
					<?php
						}
						else
						{
					?>
							<?php echo $total_damage_handling ?> Crt
					<?php
						}
					?>
						</th>
				<?php
					}
				?>
					</tr>
				</thead>
			</table>
<?php
		}
		else
		{
?>
			<table id="header-table">
				<tbody>
					<tr>
						<td style="width: 50%;" rowspan="4"><img src="../../assets/admin/pages/media/invoice/walmart3.png"/></td>
					</tr>
					<tr>
						<td style="text-align: right;">LAPORAN KERUSAKAN PENGIRIMAN</td>
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
						<th colspan=3>
							Rencana Pengiriman
						</th>
						<th colspan=3>
							Buffer Pengiriman
						</th>
						<th colspan=3>
							Kerusakan Loading
						</th>
						<th colspan=3>
							Kerusakan Pengiriman
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
				$tbl_delivery_vehicle = mysql_query("SELECT c.delivery_vehicle_id, c.delivery_vehicle_license, c.delivery_vehicle_name FROM delivery_plan a, delivery_schedule b, delivery_vehicle c WHERE c.delivery_vehicle_active = '1' AND b.delivery_schedule_date = '".$delivery_date."' AND c.delivery_vehicle_id = '".$_GET['delivery_vehicle_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND b.delivery_vehicle_id = c.delivery_vehicle_id GROUP BY c.delivery_vehicle_id ORDER BY c.delivery_vehicle_license");
				while($data_tbl_delivery_vehicle = mysql_fetch_array($tbl_delivery_vehicle))
				{
			?>
					<tr>
						<td style="width: 3%;">
							<?php echo $no ?>
						</td>
						<td colspan="14">
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
							<td>
								<?php echo $data_tbl_delivery_session['delivery_session_name'] ?>
							</td>
					<?php
						$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
						while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
						{
							$tbl_sales_order_detail = mysql_query("SELECT SUM(d.sales_order_detail_quantity) AS total_quantity, SUM(d.sales_order_detail_bonus) AS total_bonus FROM delivery_plan a, delivery_schedule b, sales_invoice c, sales_order_detail d WHERE a.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND b.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
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
								<?php echo $total_quantity ?> Crt +<br />
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
							$tbl_sales_order_detail = mysql_query("SELECT a.delivery_buffer_stock FROM delivery_buffer a, delivery_distribution b, delivery_plan c, delivery_schedule d WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND c.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND d.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_distribution_id = b.delivery_distribution_id AND b.delivery_schedule_id = c.delivery_schedule_id AND b.delivery_session_id = c.delivery_session_id AND c.delivery_schedule_id = d.delivery_schedule_id");
							$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
							
							$delivery_buffer_stock = format_angka($data_tbl_sales_order_detail['delivery_buffer_stock']);
					?>
							<td>
						<?php
							if ($data_tbl_sales_order_detail['delivery_buffer_stock'] == "0")
							{
						?>
								0
						<?php
							}
							else
							{
						?>
								<?php echo $delivery_buffer_stock ?> Crt
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
							$tbl_sales_order_detail = mysql_query("SELECT a.delivery_damage_loading FROM delivery_damage a, delivery_cheque b, delivery_distribution c, delivery_plan d, delivery_schedule e WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND e.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_cheque_id = b.delivery_cheque_id AND b.delivery_distribution_id = c.delivery_distribution_id AND c.delivery_schedule_id = d.delivery_schedule_id AND c.delivery_session_id = d.delivery_session_id AND d.delivery_schedule_id = e.delivery_schedule_id");
							$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
							
							$delivery_damage_loading = format_angka($data_tbl_sales_order_detail['delivery_damage_loading']);
					?>
							<td>
						<?php
							if ($data_tbl_sales_order_detail['delivery_damage_loading'] == "0")
							{
						?>
								0
						<?php
							}
							else
							{
						?>
								<?php echo $delivery_damage_loading ?> Crt
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
							$tbl_sales_order_detail = mysql_query("SELECT a.delivery_damage_handling FROM delivery_damage a, delivery_cheque b, delivery_distribution c, delivery_plan d, delivery_schedule e WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND e.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_cheque_id = b.delivery_cheque_id AND b.delivery_distribution_id = c.delivery_distribution_id AND c.delivery_schedule_id = d.delivery_schedule_id AND c.delivery_session_id = d.delivery_session_id AND d.delivery_schedule_id = e.delivery_schedule_id");
							$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
							
							$delivery_damage_handling = format_angka($data_tbl_sales_order_detail['delivery_damage_handling']);
					?>
							<td>
						<?php
							if ($data_tbl_sales_order_detail['delivery_damage_handling'] == "0")
							{
						?>
								0
						<?php
							}
							else
							{
						?>
								<?php echo $delivery_damage_handling ?> Crt
						<?php
							}
						?>
							</td>
					<?php
						}
					?>
						</tr>
				<?php
					}
				?>
					</tr>
			<?php
				$no++;
				}
			?>
				</tbody>
				<thead>
					<tr>
						<th colspan="3">
							Grand Total
						</th>
				<?php
					$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
					while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
						$tbl_sales_order_detail = mysql_query("SELECT SUM(d.sales_order_detail_quantity) AS total_quantity, SUM(d.sales_order_detail_bonus) AS total_bonus FROM delivery_plan a, delivery_schedule b, sales_invoice c, sales_order_detail d WHERE b.delivery_schedule_date = '".$delivery_date."' AND b.delivery_vehicle_id = '".$_GET['delivery_vehicle_id']."' AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id");
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
						$tbl_delivery_buffer = mysql_query("SELECT SUM(a.delivery_buffer_stock) AS total_buffer_stock FROM delivery_buffer a, delivery_distribution b, delivery_schedule c WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND c.delivery_schedule_date = '".$delivery_date."' AND c.delivery_vehicle_id = '".$_GET['delivery_vehicle_id']."' AND a.delivery_distribution_id = b.delivery_distribution_id AND b.delivery_schedule_id = c.delivery_schedule_id");
						$data_tbl_delivery_buffer = mysql_fetch_array($tbl_delivery_buffer);
						
						$total_buffer_stock = format_angka($data_tbl_delivery_buffer['total_buffer_stock']);
				?>
						<th>
					<?php
						if ($data_tbl_delivery_buffer['total_buffer_stock'] == "0")
						{
					?>
							0
					<?php
						}
						else
						{
					?>
							<?php echo $total_buffer_stock ?> Crt
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
						$tbl_delivery_damage_loading = mysql_query("SELECT SUM(a.delivery_damage_loading) AS total_damage_loading FROM delivery_damage a, delivery_cheque b, delivery_distribution c, delivery_schedule d WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.delivery_schedule_date = '".$delivery_date."' AND d.delivery_vehicle_id = '".$_GET['delivery_vehicle_id']."' AND a.delivery_cheque_id = b.delivery_cheque_id AND b.delivery_distribution_id = c.delivery_distribution_id AND c.delivery_schedule_id = d.delivery_schedule_id");
						$data_tbl_delivery_damage_loading = mysql_fetch_array($tbl_delivery_damage_loading);
						
						$total_damage_loading = format_angka($data_tbl_delivery_damage_loading['total_damage_loading']);
				?>
						<th>
					<?php
						if ($data_tbl_delivery_damage_loading['total_damage_loading'] == "0")
						{
					?>
							0
					<?php
						}
						else
						{
					?>
							<?php echo $total_damage_loading ?> Crt
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
						$tbl_delivery_damage_handling = mysql_query("SELECT SUM(a.delivery_damage_handling) AS total_damage_handling FROM delivery_damage a, delivery_cheque b, delivery_distribution c, delivery_schedule d WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.delivery_schedule_date = '".$delivery_date."' AND d.delivery_vehicle_id = '".$_GET['delivery_vehicle_id']."' AND a.delivery_cheque_id = b.delivery_cheque_id AND b.delivery_distribution_id = c.delivery_distribution_id AND c.delivery_schedule_id = d.delivery_schedule_id");
						$data_tbl_delivery_damage_handling = mysql_fetch_array($tbl_delivery_damage_handling);
						
						$total_damage_handling = format_angka($data_tbl_delivery_damage_handling['total_damage_handling']);
				?>
						<th>
					<?php
						if ($data_tbl_delivery_damage_handling['total_damage_handling'] == "0")
						{
					?>
							0
					<?php
						}
						else
						{
					?>
							<?php echo $total_damage_handling ?> Crt
					<?php
						}
					?>
						</th>
				<?php
					}
				?>
					</tr>
				</thead>
			</table>
<?php
		}
	}
?>
	<small><i>Di Cetak Oleh : <?php echo $_SESSION['user_name'] ?> | <?php echo date("d-m-Y H:i:s") ?></i></small>
</body>
</html>