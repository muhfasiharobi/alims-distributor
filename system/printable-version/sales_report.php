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
	$salesfromDate = explode("-", $_GET['sales_from_date']);
	$DatesalesfromDate = $salesfromDate[0];
	$MonthsalesfromDate = $salesfromDate[1];
	$YearsalesfromDate = $salesfromDate[2];
	$sales_from_date = date("Y-m-d", mktime(0, 0, 0, $MonthsalesfromDate, $DatesalesfromDate, $YearsalesfromDate));
	
	$sales_from_date_indo = tanggal_indo($sales_from_date);
	
	$salestoDate = explode("-", $_GET['sales_to_date']);
	$DatesalestoDate = $salestoDate[0];
	$MonthsalestoDate = $salestoDate[1];
	$YearsalestoDate = $salestoDate[2];
	$sales_to_date = date("Y-m-d", mktime(0, 0, 0, $MonthsalestoDate, $DatesalestoDate, $YearsalestoDate));
	
	$sales_to_date_indo = tanggal_indo($sales_to_date);
	
	if ($_GET['tib'] == "form-print-by-customer-in-quantity-sales-report")
	{
?>
		<table id="header-table">
			<tbody>
				<tr>
					<td style="width: 50%;" rowspan="4"><img src="../../assets/admin/pages/media/invoice/walmart3.png"/></td>
				</tr>
				<tr>
					<td style="text-align: right;">LAPORAN PENJUALAN</td>
				</tr>
				<tr>
					<td style="text-align: right;">BY PELANGGAN IN QUANTITY</td>
				</tr>
				<tr>
					<td style="font-size: 11px; text-align: right;">Periode <?php echo $sales_from_date_indo ?> - <?php echo $sales_to_date_indo ?></td>
				</tr>
			</tbody>
		</table>
		<br />
		<table id="content-table">
			<thead>
				<tr>
					<th rowspan="2">
						No
					</th>
					<th rowspan="2">
						Pelanggan
					</th>
			<?php
				$tbl_product_sell = mysql_query("SELECT d.product_sell_name FROM sales_invoice a, sales_order b, sales_order_detail c, product_sell d WHERE d.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND c.product_sell_id = d.product_sell_id GROUP BY d.product_sell_id");
				while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
				{
			?>
					<th colspan="2">
						<?php echo $data_tbl_product_sell['product_sell_name'] ?>
					</th>
					<th rowspan="2">
						Sub Total
					</th>
			<?php
				}
			?>
				</tr>
				<tr>
			<?php
				$tbl_product_sell = mysql_query("SELECT d.product_sell_name FROM sales_invoice a, sales_order b, sales_order_detail c, product_sell d WHERE d.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND c.product_sell_id = d.product_sell_id GROUP BY d.product_sell_id");
				while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
				{
			?>
					<th>
						Jumlah
					</th>
					<th>
						Bonus
					</th>
			<?php
				}
			?>
				</tr>
			</thead>
			<tbody>
		<?php
			$no = 1;
			$tbl_customer = mysql_query("SELECT e.customer_id, e.customer_code, e.customer_name FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, customer e WHERE d.sales_request_active = '1' AND e.customer_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.customer_id = e.customer_id GROUP BY e.customer_id ORDER BY e.customer_code");
			while ($data_tbl_customer = mysql_fetch_array($tbl_customer))
			{
		?>
				<tr>
					<td style="width: 3%; text-align: center;">
						<?php echo $no ?>
					</td>
					<td style="text-align: left;">
						<?php echo $data_tbl_customer['customer_code'] ?> - <?php echo $data_tbl_customer['customer_name'] ?>
					</td>
			<?php
				$tbl_product_sell = mysql_query("SELECT d.product_sell_id, d.product_sell_name FROM sales_invoice a, sales_order b, sales_order_detail c, product_sell d WHERE d.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND c.product_sell_id = d.product_sell_id GROUP BY d.product_sell_id");
				while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
				{
					$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity) AS total_quantity, SUM(c.sales_order_detail_bonus) AS total_bonus, SUM(c.sales_order_detail_quantity + c.sales_order_detail_bonus) AS sub_total_quantity FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE d.sales_request_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.customer_id = '".$data_tbl_customer['customer_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
					$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
					
					$total_quantity = format_angka($data_tbl_sales_order_detail['total_quantity']);
					$total_bonus = format_angka($data_tbl_sales_order_detail['total_bonus']);
					$sub_total_quantity = format_angka($data_tbl_sales_order_detail['sub_total_quantity']);
			?>
					<td style="text-align: center;">
						<?php echo $total_quantity ?>
					</td>
					<td style="text-align: center;">
						<?php echo $total_bonus ?>
					</td>
					<td style="text-align: center;">
						<?php echo $sub_total_quantity ?>
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
					<th colspan="2">
						Grand Total
					</th>
			<?php
				$tbl_product_sell = mysql_query("SELECT d.product_sell_id, d.product_sell_name FROM sales_invoice a, sales_order b, sales_order_detail c, product_sell d WHERE d.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND c.product_sell_id = d.product_sell_id GROUP BY d.product_sell_id");
				while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
				{
					$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity) AS total_quantity, SUM(c.sales_order_detail_bonus) AS total_bonus, SUM(c.sales_order_detail_quantity + c.sales_order_detail_bonus) AS sub_total_quantity FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE d.sales_request_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
					$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
					
					$total_quantity = format_angka($data_tbl_sales_order_detail['total_quantity']);
					$total_bonus = format_angka($data_tbl_sales_order_detail['total_bonus']);
					$sub_total_quantity = format_angka($data_tbl_sales_order_detail['sub_total_quantity']);
			?>
					<th>
						<?php echo $total_quantity ?>
					</th>
					<th>
						<?php echo $total_bonus ?>
					</th>
					<th>
						<?php echo $sub_total_quantity ?>
					</th>
			<?php	
				}
			?>
				</tr>
			</thead>
		</table>
		<small><i>Di Cetak Oleh : <?php echo $_SESSION['user_name'] ?> | <?php echo date("d-m-Y H:i:s") ?></i></small>
<?php
	}
	elseif ($_GET['tib'] == "form-print-by-salesman-in-quantity-sales-report")
	{
		if ($_GET['salesman_id'] == '0')
		{
?>
			<table id="header-table">
				<tbody>
					<tr>
						<td style="width: 50%;" rowspan="4"><img src="../../assets/admin/pages/media/invoice/walmart3.png"/></td>
					</tr>
					<tr>
						<td style="text-align: right;">LAPORAN PENJUALAN</td>
					</tr>
					<tr>
						<td style="text-align: right;">BY SALESMAN IN QUANTITY</td>
					</tr>
					<tr>
						<td style="font-size: 11px; text-align: right;">Periode <?php echo $sales_from_date_indo ?> - <?php echo $sales_to_date_indo ?></td>
					</tr>
				</tbody>
			</table>
			<br />
			<table id="content-table">
				<thead>
					<tr>
						<th rowspan="2">
							No
						</th>
						<th rowspan="2">
							Salesman
						</th>
				<?php
					$tbl_product_sell = mysql_query("SELECT d.product_sell_name FROM sales_invoice a, sales_order b, sales_order_detail c, product_sell d WHERE d.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND c.product_sell_id = d.product_sell_id GROUP BY d.product_sell_id");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
				?>
						<th colspan="2">
							<?php echo $data_tbl_product_sell['product_sell_name'] ?>
						</th>
						<th rowspan="2">
							Sub Total
						</th>
				<?php
					}
				?>
					</tr>
					<tr>
				<?php
					$tbl_product_sell = mysql_query("SELECT d.product_sell_id FROM sales_invoice a, sales_order b, sales_order_detail c, product_sell d WHERE d.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND c.product_sell_id = d.product_sell_id GROUP BY d.product_sell_id");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
				?>
						<th>
							Jumlah
						</th>
						<th>
							Bonus
						</th>
				<?php
					}
				?>
					</tr>
				</thead>
				<tbody>
			<?php
				$no = 1;
				$tbl_user = mysql_query("SELECT e.user_id, e.user_name FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, user e WHERE d.sales_request_active = '1' AND e.user_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.salesman_id = e.user_id GROUP BY e.user_id ORDER BY e.user_name");
				while ($data_tbl_user = mysql_fetch_array($tbl_user))
				{
			?>
					<tr>
						<td style="width: 3%; text-align: center;">
							<?php echo $no ?>
						</td>
						<td>
							<?php echo $data_tbl_user['user_name'] ?>
						</td>
				<?php
					$tbl_product_sell = mysql_query("SELECT c.product_sell_id FROM sales_invoice a, sales_order b, sales_order_detail c WHERE a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id GROUP BY c.product_sell_id");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
						$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity) AS total_sales_quantity, SUM(c.sales_order_detail_bonus) AS total_sales_bonus, SUM(c.sales_order_detail_quantity + c.sales_order_detail_bonus) AS sub_total_sales_quantity FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE d.sales_request_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.salesman_id = '".$data_tbl_user['user_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
						$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
						
						$total_sales_quantity = format_angka($data_tbl_sales_order_detail['total_sales_quantity']);
						$total_sales_bonus = format_angka($data_tbl_sales_order_detail['total_sales_bonus']);
						$sub_total_sales_quantity = format_angka($data_tbl_sales_order_detail['sub_total_sales_quantity']);
					?>
						<td style="text-align: center;">
							<?php echo $total_sales_quantity ?>
						</td>
						<td style="text-align: center;">
							<?php echo $total_sales_bonus ?>
						</td>
						<td style="text-align: center;">
							<?php echo $sub_total_sales_quantity ?>
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
						<th colspan="2">
							Grand Total
						</th>
				<?php
					$tbl_product_sell = mysql_query("SELECT c.product_sell_id FROM sales_invoice a, sales_order b, sales_order_detail c WHERE a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id GROUP BY c.product_sell_id");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
						$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity) AS total_sales_quantity, SUM(c.sales_order_detail_bonus) AS total_sales_bonus, SUM(c.sales_order_detail_quantity + c.sales_order_detail_bonus) AS sub_total_sales_quantity FROM sales_invoice a, sales_order b, sales_order_detail c WHERE a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id");
						$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
						
						$total_sales_quantity = format_angka($data_tbl_sales_order_detail['total_sales_quantity']);
						$total_sales_bonus = format_angka($data_tbl_sales_order_detail['total_sales_bonus']);
						$sub_total_sales_quantity = format_angka($data_tbl_sales_order_detail['sub_total_sales_quantity']);
				?>
						<th style="text-align: center;">
							<?php echo $total_sales_quantity ?>
						</th>
						<th style="text-align: center;">
							<?php echo $total_sales_bonus ?>
						</th>
						<th style="text-align: center;">
							<?php echo $sub_total_sales_quantity ?>
						</th>
				<?php	
					}
				?>
					</tr>
				</thead>
			</table>
			<small><i>Di Cetak Oleh : <?php echo $_SESSION['user_name'] ?> | <?php echo date("d-m-Y H:i:s") ?></i></small>
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
							<td style="text-align: right;">LAPORAN PENJUALAN</td>
					</tr>
					<tr>
							<td style="text-align: right;">BY SALESMAN IN QUANTITY</td>
					</tr>
					<tr>
							<td style="font-size: 11px; text-align: right;">Periode <?php echo $sales_from_date_indo ?> - <?php echo $sales_to_date_indo ?></td>
					</tr>
				</tbody>
			</table>
			<br />
			<table id="content-table">
				<thead>
					<tr>
						<th rowspan="2">
							No
						</th>
						<th rowspan="2">
							Salesman
						</th>
				<?php
					$tbl_product_sell = mysql_query("SELECT e.product_sell_name FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, product_sell e WHERE d.sales_request_active = '1' AND e.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND d.salesman_id = '".$_GET['salesman_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND c.product_sell_id = e.product_sell_id GROUP BY e.product_sell_id");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
				?>
						<th colspan="2">
							<?php echo $data_tbl_product_sell['product_sell_name'] ?>
						</th>
						<th rowspan="2">
							Sub Total
						</th>
				<?php
					}
				?>
					</tr>
					<tr>
				<?php
					$tbl_product_sell = mysql_query("SELECT e.product_sell_name FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, product_sell e WHERE d.sales_request_active = '1' AND e.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND d.salesman_id = '".$_GET['salesman_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND c.product_sell_id = e.product_sell_id GROUP BY e.product_sell_id");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
				?>
						<th>
							Jumlah
						</th>
						<th>
							Bonus
						</th>
				<?php
					}
				?>
					</tr>
				</thead>
				<tbody>
			<?php
				$no = 1;
				$tbl_user = mysql_query("SELECT e.user_id, e.user_name FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, user e WHERE d.sales_request_active = '1' AND e.user_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND d.salesman_id = '".$_GET['salesman_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.salesman_id = e.user_id GROUP BY e.user_id ORDER BY e.user_name");
				while ($data_tbl_user = mysql_fetch_array($tbl_user))
				{
			?>
					<tr>
						<td style="width: 3%; text-align: center;">
							<?php echo $no ?>
						</td>
						<td>
							<?php echo $data_tbl_user['user_name'] ?>
						</td>
				<?php
					$tbl_product_sell = mysql_query("SELECT c.product_sell_id FROM sales_invoice a, sales_order b, sales_order_detail c WHERE a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id GROUP BY c.product_sell_id");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
						$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity) AS total_sales_quantity, SUM(c.sales_order_detail_bonus) AS total_sales_bonus, SUM(c.sales_order_detail_quantity + c.sales_order_detail_bonus) AS sub_total_sales_quantity FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE d.sales_request_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.salesman_id = '".$data_tbl_user['user_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
						$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
						
						$total_sales_quantity = format_angka($data_tbl_sales_order_detail['total_sales_quantity']);
						$total_sales_bonus = format_angka($data_tbl_sales_order_detail['total_sales_bonus']);
						$sub_total_sales_quantity = format_angka($data_tbl_sales_order_detail['sub_total_sales_quantity']);
					?>
						<td style="text-align: center;">
							<?php echo $total_sales_quantity ?>
						</td>
						<td style="text-align: center;">
							<?php echo $total_sales_bonus ?>
						</td>
						<td style="text-align: center;">
							<?php echo $sub_total_sales_quantity ?>
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
						<th colspan="2">
							Grand Total
						</th>
				<?php
					$tbl_product_sell = mysql_query("SELECT c.product_sell_id FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE d.sales_request_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND d.salesman_id = '".$_GET['salesman_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id GROUP BY c.product_sell_id");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
						$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity) AS total_sales_quantity, SUM(c.sales_order_detail_bonus) AS total_sales_bonus, SUM(c.sales_order_detail_quantity + c.sales_order_detail_bonus) AS sub_total_sales_quantity FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE d.sales_request_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.salesman_id = '".$_GET['salesman_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
						$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
						
						$total_sales_quantity = format_angka($data_tbl_sales_order_detail['total_sales_quantity']);
						$total_sales_bonus = format_angka($data_tbl_sales_order_detail['total_sales_bonus']);
						$sub_total_sales_quantity = format_angka($data_tbl_sales_order_detail['sub_total_sales_quantity']);
				?>
						<th style="text-align: center;">
							<?php echo $total_sales_quantity ?>
						</th>
						<th style="text-align: center;">
							<?php echo $total_sales_bonus ?>
						</th>
						<th style="text-align: center;">
							<?php echo $sub_total_sales_quantity ?>
						</th>
				<?php	
					}
				?>
					</tr>
				</thead>
			</table>
			<small><i>Di Cetak Oleh : <?php echo $_SESSION['user_name'] ?> | <?php echo date("d-m-Y H:i:s") ?></i></small>
<?php
		}
	}
	elseif ($_GET['tib'] == "form-print-by-customer-city-in-value-sales-report")
	{
		if ($_GET['customer_city_id'] == '0')
		{
?>
			<table id="header-table">
				<tbody>
					<tr>
						<td style="width: 50%;" rowspan="4"><img src="../../assets/admin/pages/media/invoice/walmart3.png"/></td>
					</tr>
					<tr>
						<td style="text-align: right;">LAPORAN PENJUALAN</td>
					</tr>
					<tr>
						<td style="text-align: right;">BY KOTA/ KABUPATEN IN VALUE</td>
					</tr>
					<tr>
						<td style="font-size: 11px; text-align: right;">Periode <?php echo $sales_from_date_indo ?> - <?php echo $sales_to_date_indo ?></td>
					</tr>
				</tbody>
			</table>
			<br />
			<table id="content-table">
				<thead>
					<tr>
						<th>
							No
						</th>
						<th>
							Kota/ Kabupaten
						</th>
						<th>
							Kecamatan
						</th>
						<th>
							Penjualan
						</th>
						<th>
							Diskon
						</th>
						<th>
							Cash Diskon
						</th>
						<th>
							Biaya Pengiriman<br />
							(<small><i>Expence</i></small>)
						</th>
						<th>
							Sub Total
						</th>
					</tr>
				</thead>
				<tbody>
			<?php
				$no = 1;
				$tbl_customer_city = mysql_query("SELECT g.customer_city_id, g.customer_city_name FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, customer e, customer_districts f, customer_city g WHERE d.sales_request_active = '1' AND e.customer_active = '1' AND f.customer_districts_active = '1' AND g.customer_city_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.customer_id = e.customer_id AND e.customer_districts_id = f.customer_districts_id AND f.customer_city_id = g.customer_city_id GROUP BY g.customer_city_id ORDER BY g.customer_city_name");
				while ($data_tbl_customer_city = mysql_fetch_array($tbl_customer_city))
				{
			?>
					<tr>
						<td style="width: 3%; text-align: center;">
							<?php echo $no ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer_city['customer_city_name'] ?>
						</td>
						<td colspan="6">
						</td>
				<?php
					$tbl_customer_districts = mysql_query("SELECT f.customer_districts_id, f.customer_districts_name FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, customer e, customer_districts f WHERE d.sales_request_active = '1' AND e.customer_active = '1' AND f.customer_districts_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND f.customer_city_id = '".$data_tbl_customer_city['customer_city_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.customer_id = e.customer_id AND e.customer_districts_id = f.customer_districts_id GROUP BY f.customer_districts_id ORDER BY f.customer_districts_name");
					while ($data_tbl_customer_districts = mysql_fetch_array($tbl_customer_districts))
					{
						$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity * c.sales_order_detail_price) AS total_sales_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_discount) AS total_discount_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_discount_cash) AS total_cash_discount_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_delivery_charges_price) AS total_delivery_charges_price, SUM((c.sales_order_detail_quantity * c.sales_order_detail_price) - (c.sales_order_detail_quantity * c.sales_order_detail_discount) - (c.sales_order_detail_quantity * c.sales_order_detail_discount_cash)) AS sub_total_sales_price FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, customer e WHERE d.sales_request_active = '1' AND e.customer_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.customer_id = e.customer_id AND e.customer_districts_id = '".$data_tbl_customer_districts['customer_districts_id']."'");
						$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
						$total_sales_price = format_angka($data_tbl_sales_order_detail['total_sales_price']);
						$total_discount_price = format_angka($data_tbl_sales_order_detail['total_discount_price']);
						$total_cash_discount_price = format_angka($data_tbl_sales_order_detail['total_cash_discount_price']);
						$total_delivery_charges_price = format_angka($data_tbl_sales_order_detail['total_delivery_charges_price']);
						$sub_total_sales_price = format_angka($data_tbl_sales_order_detail['sub_total_sales_price']);		
				?>
						<tr>
							<td colspan="2">
							</td>
							<td style="text-align: center;">
								<?php echo $data_tbl_customer_districts['customer_districts_name'] ?>
							</td>
							<td style="text-align: right;">
								<?php echo $total_sales_price ?>
							</td>
							<td style="text-align: right;">
								<?php echo $total_discount_price ?>
							</td>
							<td style="text-align: right;">
								<?php echo $total_cash_discount_price ?>
							</td>
							<td style="text-align: right;">
								<?php echo $total_delivery_charges_price ?>
							</td>
							<td style="text-align: right;">
								<?php echo $sub_total_sales_price ?>
							</td>
						</tr>
				<?php
					}
				?>
					</tr>
					
				<?php
					$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity * c.sales_order_detail_price) AS total_sales_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_discount) AS total_discount_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_discount_cash) AS total_cash_discount_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_delivery_charges_price) AS total_delivery_charges_price, SUM((c.sales_order_detail_quantity * c.sales_order_detail_price) - (c.sales_order_detail_quantity * c.sales_order_detail_discount) - (c.sales_order_detail_quantity * c.sales_order_detail_discount_cash)) AS sub_total_sales_price FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, customer e, customer_districts f WHERE d.sales_request_active = '1' AND e.customer_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.customer_id = e.customer_id AND e.customer_districts_id = f.customer_districts_id AND f.customer_city_id = '".$data_tbl_customer_city['customer_city_id']."'");
					$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
					$total_sales_price = format_angka($data_tbl_sales_order_detail['total_sales_price']);
					$total_discount_price = format_angka($data_tbl_sales_order_detail['total_discount_price']);
					$total_cash_discount_price = format_angka($data_tbl_sales_order_detail['total_cash_discount_price']);
					$total_delivery_charges_price = format_angka($data_tbl_sales_order_detail['total_delivery_charges_price']);
					$sub_total_sales_price = format_angka($data_tbl_sales_order_detail['sub_total_sales_price']);		
				?>
					<tr style="font-size: 12px; font-weight: 600;">
						<td colspan="3" style="text-align: center;">
							Total
						</td>
						<td style="text-align: right;">
							<?php echo $total_sales_price ?>
						</td>
						<td style="text-align: right;">
							<?php echo $total_discount_price ?>
						</td>
						<td style="text-align: right;">
							<?php echo $total_cash_discount_price ?>
						</td>
						<td style="text-align: right;">
							<?php echo $total_delivery_charges_price ?>
						</td>
						<td style="text-align: right;">
							<?php echo $sub_total_sales_price ?>
						</td>
					</tr>
			<?php
				$no++;
				}
			?>
				</tbody>
				<thead>
				<?php
					$no = 1;
					$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity * c.sales_order_detail_price) AS total_sales_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_discount) AS total_discount_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_discount_cash) AS total_cash_discount_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_delivery_charges_price) AS total_delivery_charges_price, SUM((c.sales_order_detail_quantity * c.sales_order_detail_price) - (c.sales_order_detail_quantity * c.sales_order_detail_discount) - (c.sales_order_detail_quantity * c.sales_order_detail_discount_cash)) AS sub_total_sales_price FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, customer e, customer_districts f WHERE d.sales_request_active = '1' AND e.customer_active = '1' AND f.customer_districts_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.customer_id = e.customer_id AND e.customer_districts_id = f.customer_districts_id");
					$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
					$total_sales_price = format_angka($data_tbl_sales_order_detail['total_sales_price']);
					$total_discount_price = format_angka($data_tbl_sales_order_detail['total_discount_price']);
					$total_cash_discount_price = format_angka($data_tbl_sales_order_detail['total_cash_discount_price']);
					$total_delivery_charges_price = format_angka($data_tbl_sales_order_detail['total_delivery_charges_price']);
					$sub_total_sales_price = format_angka($data_tbl_sales_order_detail['sub_total_sales_price']);
				?>
					<tr>
						<th colspan="3">
							Grand Total
						</th>
						<th style="text-align: right;">
							<?php echo $total_sales_price ?>
						</th>
						<th style="text-align: right;">
							<?php echo $total_discount_price ?>
						</th>
						<th style="text-align: right;">
							<?php echo $total_cash_discount_price ?>
						</th>
						<th style="text-align: right;">
							<?php echo $total_delivery_charges_price ?>
						</th>
						<th style="text-align: right;">
							<?php echo $sub_total_sales_price ?>
						</th>
					</tr>
				</thead>
			</table>
			<small><i>Di Cetak Oleh : <?php echo $_SESSION['user_name'] ?> | <?php echo date("d-m-Y H:i:s") ?></i></small>
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
						<td style="text-align: right;">LAPORAN PENJUALAN</td>
					</tr>
					<tr>
						<td style="text-align: right;">BY KOTA/ KABUPATEN IN VALUE</td>
					</tr>
					<tr>
						<td style="font-size: 11px; text-align: right;">Periode <?php echo $sales_from_date_indo ?> - <?php echo $sales_to_date_indo ?></td>
					</tr>
				</tbody>
			</table>
			<br />
			<table id="content-table">
				<thead>
					<tr>
						<th>
							No
						</th>
						<th>
							Kota/ Kabupaten
						</th>
						<th>
							Kecamatan
						</th>
						<th>
							Penjualan
						</th>
						<th>
							Diskon
						</th>
						<th>
							Cash Diskon
						</th>
						<th>
							Biaya Pengiriman<br />
							(<small><i>Expence</i></small>)
						</th>
						<th>
							Sub Total
						</th>
					</tr>
				</thead>
				<tbody>
			<?php
				$no = 1;
				$tbl_customer_city = mysql_query("SELECT g.customer_city_id, g.customer_city_name FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, customer e, customer_districts f, customer_city g WHERE d.sales_request_active = '1' AND e.customer_active = '1' AND f.customer_districts_active = '1' AND g.customer_city_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.customer_id = e.customer_id AND e.customer_districts_id = f.customer_districts_id AND f.customer_city_id = g.customer_city_id AND g.customer_city_id = '".$_GET['customer_city_id']."' GROUP BY g.customer_city_id ORDER BY g.customer_city_name");
				while ($data_tbl_customer_city = mysql_fetch_array($tbl_customer_city))
				{
			?>
					<tr>
						<td style="width: 3%; text-align: center;">
							<?php echo $no ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer_city['customer_city_name'] ?>
						</td>
						<td colspan="6">
						</td>
				<?php
					$tbl_customer_districts = mysql_query("SELECT f.customer_districts_id, f.customer_districts_name FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, customer e, customer_districts f WHERE d.sales_request_active = '1' AND e.customer_active = '1' AND f.customer_districts_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND f.customer_city_id = '".$data_tbl_customer_city['customer_city_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.customer_id = e.customer_id AND e.customer_districts_id = f.customer_districts_id GROUP BY f.customer_districts_id ORDER BY f.customer_districts_name");
					while ($data_tbl_customer_districts = mysql_fetch_array($tbl_customer_districts))
					{
						$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity * c.sales_order_detail_price) AS total_sales_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_discount) AS total_discount_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_discount_cash) AS total_cash_discount_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_delivery_charges_price) AS total_delivery_charges_price, SUM((c.sales_order_detail_quantity * c.sales_order_detail_price) - (c.sales_order_detail_quantity * c.sales_order_detail_discount) - (c.sales_order_detail_quantity * c.sales_order_detail_discount_cash)) AS sub_total_sales_price FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, customer e WHERE d.sales_request_active = '1' AND e.customer_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.customer_id = e.customer_id AND e.customer_districts_id = '".$data_tbl_customer_districts['customer_districts_id']."'");
						$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
						$total_sales_price = format_angka($data_tbl_sales_order_detail['total_sales_price']);
						$total_discount_price = format_angka($data_tbl_sales_order_detail['total_discount_price']);
						$total_cash_discount_price = format_angka($data_tbl_sales_order_detail['total_cash_discount_price']);
						$total_delivery_charges_price = format_angka($data_tbl_sales_order_detail['total_delivery_charges_price']);
						$sub_total_sales_price = format_angka($data_tbl_sales_order_detail['sub_total_sales_price']);		
				?>
						<tr>
							<td colspan="2">
							</td>
							<td style="text-align: center;">
								<?php echo $data_tbl_customer_districts['customer_districts_name'] ?>
							</td>
							<td style="text-align: right;">
								<?php echo $total_sales_price ?>
							</td>
							<td style="text-align: right;">
								<?php echo $total_discount_price ?>
							</td>
							<td style="text-align: right;">
								<?php echo $total_cash_discount_price ?>
							</td>
							<td style="text-align: right;">
								<?php echo $total_delivery_charges_price ?>
							</td>
							<td style="text-align: right;">
								<?php echo $sub_total_sales_price ?>
							</td>
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
			<?php
				$no = 1;
				$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity * c.sales_order_detail_price) AS total_sales_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_discount) AS total_discount_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_discount_cash) AS total_cash_discount_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_delivery_charges_price) AS total_delivery_charges_price, SUM((c.sales_order_detail_quantity * c.sales_order_detail_price) - (c.sales_order_detail_quantity * c.sales_order_detail_discount) - (c.sales_order_detail_quantity * c.sales_order_detail_discount_cash)) AS sub_total_sales_price FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, customer e, customer_districts f WHERE d.sales_request_active = '1' AND e.customer_active = '1' AND f.customer_districts_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.customer_id = e.customer_id AND e.customer_districts_id = f.customer_districts_id AND f.customer_city_id = '".$_GET['customer_city_id']."'");
				$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
				$total_sales_price = format_angka($data_tbl_sales_order_detail['total_sales_price']);
				$total_discount_price = format_angka($data_tbl_sales_order_detail['total_discount_price']);
				$total_cash_discount_price = format_angka($data_tbl_sales_order_detail['total_cash_discount_price']);
				$total_delivery_charges_price = format_angka($data_tbl_sales_order_detail['total_delivery_charges_price']);
				$sub_total_sales_price = format_angka($data_tbl_sales_order_detail['sub_total_sales_price']);
			?>
					<tr>
						<th colspan="3">
							Grand Total
						</th>
						<th style="text-align: right;">
							<?php echo $total_sales_price ?>
						</th>
						<th style="text-align: right;">
							<?php echo $total_discount_price ?>
						</th>
						<th style="text-align: right;">
							<?php echo $total_cash_discount_price ?>
						</th>
						<th style="text-align: right;">
							<?php echo $total_delivery_charges_price ?>
						</th>
						<th style="text-align: right;">
							<?php echo $sub_total_sales_price ?>
						</th>
					</tr>
				</thead>
			</table>
			<small><i>Di Cetak Oleh : <?php echo $_SESSION['user_name'] ?> | <?php echo date("d-m-Y H:i:s") ?></i></small>
<?php
		}
	}
	elseif ($_GET['tib'] == "form-print-by-product-sell-in-quantity-sales-report")
	{
?>
		<table id="header-table">
			<tbody>
				<tr>
					<td style="width: 50%;" rowspan="4"><img src="../../assets/admin/pages/media/invoice/walmart3.png"/></td>
				</tr>
				<tr>
					<td style="text-align: right;">LAPORAN PENJUALAN</td>
				</tr>
				<tr>
					<td style="text-align: right;">BY PRODUK IN QUANTITY</td>
				</tr>
				<tr>
					<td style="font-size: 11px; text-align: right;">Periode <?php echo $sales_from_date_indo ?> - <?php echo $sales_to_date_indo ?></td>
				</tr>
			</tbody>
		</table>
		<br />
		<table id="content-table">
			<thead>
				<tr>
					<th rowspan="2">
						No
					</th>
					<th rowspan="2">
						Pelanggan
					</th>
			<?php
				$tbl_product_sell = mysql_query("SELECT d.product_sell_name FROM sales_invoice a, sales_order b, sales_order_detail c, product_sell d WHERE d.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND c.product_sell_id = d.product_sell_id AND d.product_sell_id = '".$_GET['product_sell_id']."' GROUP BY d.product_sell_id");
				while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
				{
			?>
					<th colspan="2">
						<?php echo $data_tbl_product_sell['product_sell_name'] ?>
					</th>
					<th rowspan="2">
						Sub Total
					</th>
			<?php
				}
			?>
				</tr>
				<tr>
			<?php
				$tbl_product_sell = mysql_query("SELECT d.product_sell_name FROM sales_invoice a, sales_order b, sales_order_detail c, product_sell d WHERE d.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND c.product_sell_id = d.product_sell_id AND d.product_sell_id = '".$_GET['product_sell_id']."' GROUP BY d.product_sell_id");
				while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
				{
			?>
					<th>
						Jumlah
					</th>
					<th>
						Bonus
					</th>
			<?php
				}
			?>
				</tr>
			</thead>
			<tbody>
		<?php
			$no = 1;
			$tbl_customer = mysql_query("SELECT SUM(c.sales_order_detail_quantity) AS total_quantity, e.customer_id, e.customer_code, e.customer_name FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, customer e WHERE d.sales_request_active = '1' AND e.customer_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$_GET['product_sell_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.customer_id = e.customer_id GROUP BY e.customer_id ORDER BY total_quantity DESC");
			while ($data_tbl_customer = mysql_fetch_array($tbl_customer))
			{
				$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity) AS total_quantity, SUM(c.sales_order_detail_bonus) AS total_bonus, SUM(c.sales_order_detail_quantity + c.sales_order_detail_bonus) AS sub_total_quantity FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE d.sales_request_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$_GET['product_sell_id']."' AND d.customer_id = '".$data_tbl_customer['customer_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
				$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
				
				$total_quantity = format_angka($data_tbl_sales_order_detail['total_quantity']);
				$total_bonus = format_angka($data_tbl_sales_order_detail['total_bonus']);
				$sub_total_quantity = format_angka($data_tbl_sales_order_detail['sub_total_quantity']);
		?>
				<tr>
					<td style="width: 3%; text-align: center;">
						<?php echo $no ?>
					</td>
					<td style="text-align: left;">
						<?php echo $data_tbl_customer['customer_code'] ?> - <?php echo $data_tbl_customer['customer_name'] ?>
					</td>
					<td style="text-align: center;">
						<?php echo $total_quantity ?>
					</td>
					<td style="text-align: center;">
						<?php echo $total_bonus ?>
					</td>
					<td style="text-align: center;">
						<?php echo $sub_total_quantity ?>
					</td>
				</tr>
		<?php
			$no++;
			}
		?>
			</tbody>
			<thead>
				<tr>
					<th colspan="2">
						Grand Total
					</th>
			<?php
				$tbl_product_sell = mysql_query("SELECT c.product_sell_id FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE d.sales_request_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$_GET['product_sell_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id GROUP BY c.product_sell_id");
				while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
				{
					$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity) AS total_quantity, SUM(c.sales_order_detail_bonus) AS total_bonus, SUM(c.sales_order_detail_quantity + c.sales_order_detail_bonus) AS sub_total_quantity FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE d.sales_request_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
					$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
					
					$total_quantity = format_angka($data_tbl_sales_order_detail['total_quantity']);
					$total_bonus = format_angka($data_tbl_sales_order_detail['total_bonus']);
					$sub_total_quantity = format_angka($data_tbl_sales_order_detail['sub_total_quantity']);
			?>
					<th style="text-align: center;">
						<?php echo $total_quantity ?>
					</th>
					<th style="text-align: center;">
						<?php echo $total_bonus ?>
					</th>
					<th style="text-align: center;">
						<?php echo $sub_total_quantity ?>
					</th>
			<?php	
				}
			?>
				</tr>
			</thead>
		</table>
		<small><i>Di Cetak Oleh : <?php echo $_SESSION['user_name'] ?> | <?php echo date("d-m-Y H:i:s") ?></i></small>
<?php
	}
	elseif ($_GET['tib'] == "form-print-by-salesman-in-quantity-sales-report")
	{
		if ($_GET['salesman_id'] == '0')
		{
?>
			<table id="header-table">
				<tbody>
					<tr>
						<td style="width: 50%;" rowspan="4"><img src="../../assets/admin/pages/media/invoice/walmart3.png"/></td>
					</tr>
					<tr>
						<td style="text-align: right;">LAPORAN PENJUALAN</td>
					</tr>
					<tr>
						<td style="text-align: right;">BY SALESMAN IN QUANTITY</td>
					</tr>
					<tr>
						<td style="font-size: 11px; text-align: right;">Periode <?php echo $sales_from_date_indo ?> - <?php echo $sales_to_date_indo ?></td>
					</tr>
				</tbody>
			</table>
			<br />
			<table id="content-table">
				<thead>
					<tr>
						<th rowspan="2">
							No
						</th>
						<th rowspan="2">
							Salesman
						</th>
				<?php
					$tbl_product_sell = mysql_query("SELECT d.product_sell_name FROM sales_invoice a, sales_order b, sales_order_detail c, product_sell d WHERE d.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND c.product_sell_id = d.product_sell_id GROUP BY d.product_sell_id");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
				?>
						<th colspan="2">
							<?php echo $data_tbl_product_sell['product_sell_name'] ?>
						</th>
						<th rowspan="2">
							Sub Total
						</th>
				<?php
					}
				?>
					</tr>
					<tr>
				<?php
					$tbl_product_sell = mysql_query("SELECT d.product_sell_id FROM sales_invoice a, sales_order b, sales_order_detail c, product_sell d WHERE d.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND c.product_sell_id = d.product_sell_id GROUP BY d.product_sell_id");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
				?>
						<th>
							Jumlah
						</th>
						<th>
							Bonus
						</th>
				<?php
					}
				?>
					</tr>
				</thead>
				<tbody>
			<?php
				$no = 1;
				$tbl_user = mysql_query("SELECT e.user_id, e.user_name FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, user e WHERE d.sales_request_active = '1' AND e.user_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.salesman_id = e.user_id GROUP BY e.user_id ORDER BY e.user_name");
				while ($data_tbl_user = mysql_fetch_array($tbl_user))
				{
			?>
					<tr>
						<td style="width: 3%; text-align: center;">
							<?php echo $no ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_user['user_name'] ?>
						</td>
				<?php
					$tbl_product_sell = mysql_query("SELECT c.product_sell_id FROM sales_invoice a, sales_order b, sales_order_detail c WHERE a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id GROUP BY c.product_sell_id");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
						$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity) AS total_sales_quantity, SUM(c.sales_order_detail_bonus) AS total_sales_bonus, SUM(c.sales_order_detail_quantity + c.sales_order_detail_bonus) AS sub_total_sales_quantity FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE d.sales_request_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.salesman_id = '".$data_tbl_user['user_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
						$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
						
						$total_sales_quantity = format_angka($data_tbl_sales_order_detail['total_sales_quantity']);
						$total_sales_bonus = format_angka($data_tbl_sales_order_detail['total_sales_bonus']);
						$sub_total_sales_quantity = format_angka($data_tbl_sales_order_detail['sub_total_sales_quantity']);
					?>
						<td style="text-align: center;">
							<?php echo $total_sales_quantity ?>
						</td>
						<td style="text-align: center;">
							<?php echo $total_sales_bonus ?>
						</td>
						<td style="text-align: center;">
							<?php echo $sub_total_sales_quantity ?>
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
						<th colspan="2">
							Grand Total
						</th>
				<?php
					$tbl_product_sell = mysql_query("SELECT c.product_sell_id FROM sales_invoice a, sales_order b, sales_order_detail c WHERE a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id GROUP BY c.product_sell_id");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
						$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity) AS total_sales_quantity, SUM(c.sales_order_detail_bonus) AS total_sales_bonus, SUM(c.sales_order_detail_quantity + c.sales_order_detail_bonus) AS sub_total_sales_quantity FROM sales_invoice a, sales_order b, sales_order_detail c WHERE a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id");
						$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
						
						$total_sales_quantity = format_angka($data_tbl_sales_order_detail['total_sales_quantity']);
						$total_sales_bonus = format_angka($data_tbl_sales_order_detail['total_sales_bonus']);
						$sub_total_sales_quantity = format_angka($data_tbl_sales_order_detail['sub_total_sales_quantity']);
				?>
						<th style="text-align: center;">
							<?php echo $total_sales_quantity ?>
						</th>
						<th style="text-align: center;">
							<?php echo $total_sales_bonus ?>
						</th>
						<th style="text-align: center;">
							<?php echo $sub_total_sales_quantity ?>
						</th>
				<?php	
					}
				?>
					</tr>
				</thead>
			</table>
			<small><i>Di Cetak Oleh : <?php echo $_SESSION['user_name'] ?> | <?php echo date("d-m-Y H:i:s") ?></i></small>
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
						<td style="text-align: right;">LAPORAN PENJUALAN</td>
					</tr>
					<tr>
						<td style="text-align: right;">BY SALESMAN IN QUANTITY</td>
					</tr>
					<tr>
						<td style="font-size: 11px; text-align: right;">Periode <?php echo $sales_from_date_indo ?> - <?php echo $sales_to_date_indo ?></td>
					</tr>
				</tbody>
			</table>
			<br />
			<table id="content-table">
				<thead>
					<tr>
						<th rowspan="2">
							No
						</th>
						<th rowspan="2">
							Salesman
						</th>
				<?php
					$tbl_product_sell = mysql_query("SELECT e.product_sell_name FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, product_sell e WHERE d.sales_request_active = '1' AND e.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND d.salesman_id = '".$_POST['salesman_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND c.product_sell_id = e.product_sell_id GROUP BY e.product_sell_id");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
				?>
						<th colspan="2">
							<?php echo $data_tbl_product_sell['product_sell_name'] ?>
						</th>
						<th rowspan="2">
							Sub Total
						</th>
				<?php
					}
				?>
					</tr>
					<tr>
				<?php
					$tbl_product_sell = mysql_query("SELECT e.product_sell_id FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, product_sell e WHERE d.sales_request_active = '1' AND e.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND d.salesman_id = '".$_POST['salesman_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND c.product_sell_id = e.product_sell_id GROUP BY e.product_sell_id");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
				?>
						<th>
							Jumlah
						</th>
						<th>
							Bonus
						</th>
				<?php
					}
				?>
					</tr>
				</thead>
				<tbody>
			<?php
				$no = 1;
				$tbl_user = mysql_query("SELECT e.user_id, e.user_name FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, user e WHERE d.sales_request_active = '1' AND e.user_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND d.salesman_id = '".$_POST['salesman_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.salesman_id = e.user_id GROUP BY e.user_id ORDER BY e.user_name");
				while ($data_tbl_user = mysql_fetch_array($tbl_user))
				{
			?>
					<tr>
						<td style="width: 3%; text-align: center;">
							<?php echo $no ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_user['user_name'] ?>
						</td>
				<?php
					$tbl_product_sell = mysql_query("SELECT c.product_sell_id FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND d.salesman_id = '".$data_tbl_user['user_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id GROUP BY c.product_sell_id");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
						$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity) AS total_sales_quantity, SUM(c.sales_order_detail_bonus) AS total_sales_bonus, SUM(c.sales_order_detail_quantity + c.sales_order_detail_bonus) AS sub_total_sales_quantity FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE d.sales_request_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.salesman_id = '".$data_tbl_user['user_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
						$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
						
						$total_sales_quantity = format_angka($data_tbl_sales_order_detail['total_sales_quantity']);
						$total_sales_bonus = format_angka($data_tbl_sales_order_detail['total_sales_bonus']);
						$sub_total_sales_quantity = format_angka($data_tbl_sales_order_detail['sub_total_sales_quantity']);
				?>
						<td style="text-align: center;">
							<?php echo $total_sales_quantity ?>
						</td>
						<td style="text-align: center;">
							<?php echo $total_sales_bonus ?>
						</td>
						<td style="text-align: center;">
							<?php echo $sub_total_sales_quantity ?>
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
						<th colspan="2">
							Grand Total
						</th>
				<?php
					$tbl_product_sell = mysql_query("SELECT c.product_sell_id FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE d.sales_request_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND d.salesman_id = '".$_POST['salesman_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id GROUP BY c.product_sell_id");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
						$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity) AS total_sales_quantity, SUM(c.sales_order_detail_bonus) AS total_sales_bonus, SUM(c.sales_order_detail_quantity + c.sales_order_detail_bonus) AS sub_total_sales_quantity FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE d.sales_request_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.salesman_id = '".$_POST['salesman_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
						$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
						
						$total_sales_quantity = format_angka($data_tbl_sales_order_detail['total_sales_quantity']);
						$total_sales_bonus = format_angka($data_tbl_sales_order_detail['total_sales_bonus']);
						$sub_total_sales_quantity = format_angka($data_tbl_sales_order_detail['sub_total_sales_quantity']);
				?>
						<th style="text-align: center;">
							<?php echo $total_sales_quantity ?>
						</th>
						<th style="text-align: center;">
							<?php echo $total_sales_bonus ?>
						</th>
						<th style="text-align: center;">
							<?php echo $sub_total_sales_quantity ?>
						</th>
				<?php	
					}
				?>
					</tr>
				</thead>
			</table>
			<small><i>Di Cetak Oleh : <?php echo $_SESSION['user_name'] ?> | <?php echo date("d-m-Y H:i:s") ?></i></small>
<?php
		}
	}
	elseif ($_GET['tib'] == "form-print-by-salesman-in-value-sales-report")
	{
		if ($_GET['salesman_id'] == '0')
		{
?>
			<table id="header-table">
				<tbody>
					<tr>
						<td style="width: 50%;" rowspan="4"><img src="../../assets/admin/pages/media/invoice/walmart3.png"/></td>
					</tr>
					<tr>
						<td style="text-align: right;">LAPORAN PENJUALAN</td>
					</tr>
					<tr>
						<td style="text-align: right;">BY SALESMAN IN VALUE</td>
					</tr>
					<tr>
						<td style="font-size: 11px; text-align: right;">Periode <?php echo $sales_from_date_indo ?> - <?php echo $sales_to_date_indo ?></td>
					</tr>
				</tbody>
			</table>
			<br />
			<table id="content-table">
				<thead>
					<tr>
						<th>
							No
						</th>
						<th>
							Salesman
						</th>
						<th>
							Penjualan
						</th>
						<th>
							Diskon
						</th>
						<th>
							Cash Diskon
						</th>
						<th>
							Biaya Pengiriman<br />
							(<small><i>Expence</i></small>)
						</th>
						<th>
							Sub Total
						</th>
					</tr>
				</thead>
				<tbody>
			<?php
				$no = 1;
				$tbl_user = mysql_query("SELECT e.user_id, e.user_name FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, user e WHERE d.sales_request_active = '1' AND e.user_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.salesman_id = e.user_id GROUP BY e.user_id ORDER BY e.user_name");
				while ($data_tbl_user = mysql_fetch_array($tbl_user))
				{
					$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity * c.sales_order_detail_price) AS total_sales_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_discount) AS total_discount_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_discount_cash) AS total_cash_discount_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_delivery_charges_price) AS total_delivery_charges_price, SUM((c.sales_order_detail_quantity * c.sales_order_detail_price) - (c.sales_order_detail_quantity * c.sales_order_detail_discount) - (c.sales_order_detail_quantity * c.sales_order_detail_discount_cash)) AS sub_total_sales_price FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE d.sales_request_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND d.salesman_id = '".$data_tbl_user['user_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
					$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
					
					$total_sales_price = format_angka($data_tbl_sales_order_detail['total_sales_price']);
					$total_discount_price = format_angka($data_tbl_sales_order_detail['total_discount_price']);
					$total_cash_discount_price = format_angka($data_tbl_sales_order_detail['total_cash_discount_price']);
					$total_delivery_charges_price = format_angka($data_tbl_sales_order_detail['total_delivery_charges_price']);
					$sub_total_sales_price = format_angka($data_tbl_sales_order_detail['sub_total_sales_price']);
			?>
					<tr>
						<td style="width: 3%; text-align: center;">
							<?php echo $no ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_user['user_name'] ?>
						</td>
						<td style="text-align: right;">
							<?php echo $total_sales_price ?>
						</td>
						<td style="text-align: right;">
							<?php echo $total_discount_price ?>
						</td>
						<td style="text-align: right;">
							<?php echo $total_cash_discount_price ?>
						</td>
						<td style="text-align: right;">
							<?php echo $total_delivery_charges_price ?>
						</td>
						<td style="text-align: right;">
							<?php echo $sub_total_sales_price ?>
						</td>
					</tr>
			<?php
				$no++;
				}
			?>
				</tbody>
				<thead>
			<?php
				$no = 1;
				$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity * c.sales_order_detail_price) AS total_sales_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_discount) AS total_discount_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_discount_cash) AS total_cash_discount_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_delivery_charges_price) AS total_delivery_charges_price, SUM((c.sales_order_detail_quantity * c.sales_order_detail_price) - (c.sales_order_detail_quantity * c.sales_order_detail_discount) - (c.sales_order_detail_quantity * c.sales_order_detail_discount_cash)) AS sub_total_sales_price FROM sales_invoice a, sales_order b, sales_order_detail c WHERE a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id");
				$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
				
				$total_sales_price = format_angka($data_tbl_sales_order_detail['total_sales_price']);
				$total_discount_price = format_angka($data_tbl_sales_order_detail['total_discount_price']);
				$total_cash_discount_price = format_angka($data_tbl_sales_order_detail['total_cash_discount_price']);
				$total_delivery_charges_price = format_angka($data_tbl_sales_order_detail['total_delivery_charges_price']);
				$sub_total_sales_price = format_angka($data_tbl_sales_order_detail['sub_total_sales_price']);
			?>
					<tr>
						<th colspan="2">
							Grand Total
						</th>
						<th style="text-align: right;">
							<?php echo $total_sales_price ?>
						</th>
						<th style="text-align: right;">
							<?php echo $total_discount_price ?>
						</th>
						<th style="text-align: right;">
							<?php echo $total_cash_discount_price ?>
						</th>
						<th style="text-align: right;">
							<?php echo $total_delivery_charges_price ?>
						</th>
						<th style="text-align: right;">
							<?php echo $sub_total_sales_price ?>
						</th>
					</tr>
				</thead>
			</table>
			<small><i>Di Cetak Oleh : <?php echo $_SESSION['user_name'] ?> | <?php echo date("d-m-Y H:i:s") ?></i></small>
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
						<td style="text-align: right;">LAPORAN PENJUALAN</td>
					</tr>
					<tr>
						<td style="text-align: right;">BY SALESMAN IN VALUE</td>
					</tr>
					<tr>
						<td style="font-size: 11px; text-align: right;">Periode <?php echo $sales_from_date_indo ?> - <?php echo $sales_to_date_indo ?></td>
					</tr>
				</tbody>
			</table>
			<br />
			<table id="content-table">
				<thead>
					<tr>
						<th>
							No
						</th>
						<th>
							Salesman
						</th>
						<th>
							Penjualan
						</th>
						<th>
							Diskon
						</th>
						<th>
							Cash Diskon
						</th>
						<th>
							Biaya Pengiriman<br />
							(<small><i>Expence</i></small>)
						</th>
						<th>
							Sub Total
						</th>
					</tr>
				</thead>
				<tbody>
			<?php
				$no = 1;
				$tbl_user = mysql_query("SELECT e.user_id, e.user_name FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, user e WHERE d.sales_request_active = '1' AND e.user_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND d.salesman_id = '".$_GET['salesman_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.salesman_id = e.user_id GROUP BY e.user_id ORDER BY e.user_name");
				while ($data_tbl_user = mysql_fetch_array($tbl_user))
				{
					$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity * c.sales_order_detail_price) AS total_sales_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_discount) AS total_discount_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_discount_cash) AS total_cash_discount_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_delivery_charges_price) AS total_delivery_charges_price, SUM((c.sales_order_detail_quantity * c.sales_order_detail_price) - (c.sales_order_detail_quantity * c.sales_order_detail_discount) - (c.sales_order_detail_quantity * c.sales_order_detail_discount_cash)) AS sub_total_sales_price FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE d.sales_request_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND d.salesman_id = '".$data_tbl_user['user_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
					$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
					$total_sales_price = format_angka($data_tbl_sales_order_detail['total_sales_price']);
					$total_discount_price = format_angka($data_tbl_sales_order_detail['total_discount_price']);
					$total_cash_discount_price = format_angka($data_tbl_sales_order_detail['total_cash_discount_price']);
					$total_delivery_charges_price = format_angka($data_tbl_sales_order_detail['total_delivery_charges_price']);
					$sub_total_sales_price = format_angka($data_tbl_sales_order_detail['sub_total_sales_price']);
			?>
					<tr>
						<td style="width: 3%; text-align: center;">
							<?php echo $no ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_user['user_name'] ?>
						</td>
						<td style="text-align: right;">
							<?php echo $total_sales_price ?>
						</td>
						<td style="text-align: right;">
							<?php echo $total_discount_price ?>
						</td>
						<td style="text-align: right;">
							<?php echo $total_cash_discount_price ?>
						</td>
						<td style="text-align: right;">
							<?php echo $total_delivery_charges_price ?>
						</td>
						<td style="text-align: right;">
							<?php echo $sub_total_sales_price ?>
						</td>
					</tr>
			<?php
				$no++;
				}
			?>
				</tbody>
				<thead>
			<?php
				$no = 1;
				$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity * c.sales_order_detail_price) AS total_sales_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_discount) AS total_discount_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_discount_cash) AS total_cash_discount_price, SUM(c.sales_order_detail_quantity * c.sales_order_detail_delivery_charges_price) AS total_delivery_charges_price, SUM((c.sales_order_detail_quantity * c.sales_order_detail_price) - (c.sales_order_detail_quantity * c.sales_order_detail_discount) - (c.sales_order_detail_quantity * c.sales_order_detail_discount_cash)) AS sub_total_sales_price FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND d.salesman_id = '".$_GET['salesman_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
				$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
				
				$total_sales_price = format_angka($data_tbl_sales_order_detail['total_sales_price']);
				$total_discount_price = format_angka($data_tbl_sales_order_detail['total_discount_price']);
				$total_cash_discount_price = format_angka($data_tbl_sales_order_detail['total_cash_discount_price']);
				$total_delivery_charges_price = format_angka($data_tbl_sales_order_detail['total_delivery_charges_price']);
				$sub_total_sales_price = format_angka($data_tbl_sales_order_detail['sub_total_sales_price']);
			?>
					<tr>
						<th colspan="2">
							Grand Total
						</th>
						<th style="text-align: right;">
							<?php echo $total_sales_price ?>
						</th>
						<th style="text-align: right;">
							<?php echo $total_discount_price ?>
						</th>
						<th style="text-align: right;">
							<?php echo $total_cash_discount_price ?>
						</th>
						<th style="text-align: right;">
							<?php echo $total_delivery_charges_price ?>
						</th>
						<th style="text-align: right;">
							<?php echo $sub_total_sales_price ?>
						</th>
					</tr>
				</thead>
			</table>
			<small><i>Di Cetak Oleh : <?php echo $_SESSION['user_name'] ?> | <?php echo date("d-m-Y H:i:s") ?></i></small>
<?php
		}
	}
	elseif ($_GET['tib'] == "form-print-by-salesman-in-quantity-in-value-sales-report")
	{
		if ($_GET['salesman_id'] == '0')
		{
?>
			<table id="header-table">
				<tbody>
					<tr>
						<td style="width: 50%;" rowspan="4"><img src="../../assets/admin/pages/media/invoice/walmart3.png"/></td>
					</tr>
					<tr>
						<td style="text-align: right;">LAPORAN PENJUALAN</td>
					</tr>
					<tr>
						<td style="text-align: right;">BY SALESMAN IN QUANTITY IN VALUE</td>
					</tr>
					<tr>
						<td style="font-size: 11px; text-align: right;">Periode <?php echo $sales_from_date_indo ?> - <?php echo $sales_to_date_indo ?></td>
					</tr>
				</tbody>
			</table>
			<br />
			<table id="content-table">
				<thead>
					<tr>
						<th rowspan="2">
							No
						</th>
						<th rowspan="2">
							Faktur
						</th>
						<th rowspan="2">
							Pelanggan
						</th>
				<?php
					$tbl_product_sell = mysql_query("SELECT d.product_sell_name FROM sales_invoice a, sales_order b, sales_order_detail c, product_sell d WHERE d.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND c.product_sell_id = d.product_sell_id GROUP BY d.product_sell_id ORDER BY d.product_sell_code");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
				?>
						<th colspan="3">
							<?php echo $data_tbl_product_sell['product_sell_name'] ?>
						</th>
						<th rowspan="2">
							Sub Total
						</th>
				<?php
					}
				?>
					</tr>
					<tr>
				<?php
					$tbl_product_sell = mysql_query("SELECT d.product_sell_name FROM sales_invoice a, sales_order b, sales_order_detail c, product_sell d WHERE d.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND c.product_sell_id = d.product_sell_id GROUP BY d.product_sell_id");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
				?>
						<th>
							Jumlah
						</th>
						<th>
							Bonus
						</th>
						<th>
							Harga Jual
						</th>
				<?php
					}
				?>
					</tr>
				</thead>
				<tbody>
			<?php
				$tbl_user = mysql_query("SELECT e.user_id, e.user_name, e.user_no FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, user e WHERE d.sales_request_active = '1' AND e.user_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.salesman_id = e.user_id GROUP BY e.user_id ORDER BY e.user_name");
				while ($data_tbl_user = mysql_fetch_array($tbl_user))
				{
			?>
					<tr>
						<td colspan="15">
							<?php echo $data_tbl_user['user_no'] ?> - <?php echo $data_tbl_user['user_name'] ?>
						</td>
				<?php
					$no = 1;
					$tbl_sales_invoice = mysql_query("SELECT a.sales_invoice_id, a.sales_invoice_no, a.sales_invoice_date, e.customer_code, e.customer_name, f.customer_category_name, g.customer_districts_name FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, customer e, customer_category f, customer_districts g WHERE d.sales_request_active = '1' AND e.customer_active = '1' AND f.customer_category_active = '1' AND g.customer_districts_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND d.salesman_id = '".$data_tbl_user['user_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.customer_id = e.customer_id AND e.customer_category_id = f.customer_category_id AND e.customer_districts_id = g.customer_districts_id GROUP BY a.sales_invoice_id ORDER BY a.sales_invoice_no");
					while ($data_tbl_sales_invoice = mysql_fetch_array($tbl_sales_invoice))
					{
						$sales_invoice_date_indo = tanggal_indo($data_tbl_sales_invoice['sales_invoice_date']);
				?>
						<tr>
							<td style="width: 3%; text-align: center;">
								<?php echo $no ?>
							</td>
							<td style="text-align: left;">
								<?php echo $data_tbl_sales_invoice['sales_invoice_no'] ?><br /><?php echo $sales_invoice_date_indo ?>
							</td>
							<td style="text-align: left;">
								(<?php echo $data_tbl_sales_invoice['customer_category_name'] ?>)<br />
								<?php echo $data_tbl_sales_invoice['customer_code'] ?> - <?php echo $data_tbl_sales_invoice['customer_name'] ?> (<?php echo $data_tbl_sales_invoice['customer_districts_name'] ?>)
							</td>
					<?php
						$tbl_product_sell = mysql_query("SELECT d.product_sell_id, d.product_sell_price FROM sales_invoice a, sales_order b, sales_order_detail c, product_sell d WHERE d.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND c.product_sell_id = d.product_sell_id GROUP BY d.product_sell_id");
						while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
						{	
						$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity) AS total_quantity, SUM(c.sales_order_detail_bonus) AS total_bonus, SUM(c.sales_order_detail_price - c.sales_order_detail_discount - c.sales_order_detail_discount_cash) AS sales_price, SUM(c.sales_order_detail_quantity * (c.sales_order_detail_price - c.sales_order_detail_discount - c.sales_order_detail_discount_cash)) AS sub_total_sales_price FROM sales_invoice a, sales_order b, sales_order_detail c WHERE a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_invoice_id = '".$data_tbl_sales_invoice['sales_invoice_id']."' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id");
						$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
						$total_quantity = format_angka($data_tbl_sales_order_detail['total_quantity']);
						$total_bonus = format_angka($data_tbl_sales_order_detail['total_bonus']);
						$sales_price = format_angka($data_tbl_sales_order_detail['sales_price']);
						$sub_total_sales_price = format_angka($data_tbl_sales_order_detail['sub_total_sales_price']);
					?>
							<td style="text-align: center;">
								<?php echo $total_quantity ?>
							</td>
							<td style="text-align: center;">
								<?php echo $total_bonus ?>
							</td>
							<td style="text-align: right;">
								<?php echo $sales_price ?>
							</td>
							<td style="text-align: right;">
								<?php echo $sub_total_sales_price ?>
							</td>
					<?php
						}
					?>
						</tr>
				<?php
					$no++;
					}
				?>
					</tr>
					<tr style="font-size: 12px; font-weight: 600;">
						<td colspan="3" style="text-align: center;">
							Total
						</td>
				<?php
					$tbl_product_sell = mysql_query("SELECT d.product_sell_id, d.product_sell_price FROM sales_invoice a, sales_order b, sales_order_detail c, product_sell d WHERE d.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND c.product_sell_id = d.product_sell_id GROUP BY d.product_sell_id");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
						$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity) AS total_sales_quantity, SUM(c.sales_order_detail_bonus) AS total_sales_bonus, SUM(c.sales_order_detail_quantity * (c.sales_order_detail_price - c.sales_order_detail_discount - c.sales_order_detail_discount_cash)) AS sub_total_sales_price FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE d.sales_request_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.salesman_id = '".$data_tbl_user['user_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
						$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
						
						$total_sales_quantity = format_angka($data_tbl_sales_order_detail['total_sales_quantity']);
						$total_sales_bonus = format_angka($data_tbl_sales_order_detail['total_sales_bonus']);
						$sub_total_sales_price = format_angka($data_tbl_sales_order_detail['sub_total_sales_price']);
				?>
						<td style="text-align: center;">
							<?php echo $total_sales_quantity ?>
						</td>
						<td style="text-align: center;">
							<?php echo $total_sales_bonus ?>
						</td>
						<td>
						</td>
						<td style="text-align: right;">
							<?php echo $sub_total_sales_price ?>
						</td>
				<?php
					}
				?>
					</tr>
			<?php
				}
			?>
				</tbody>
				<thead>
					<tr>
						<th colspan="3">
							Grand Total
						</th>
				<?php
					$tbl_product_sell = mysql_query("SELECT d.product_sell_id, d.product_sell_price FROM sales_invoice a, sales_order b, sales_order_detail c, product_sell d WHERE d.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND c.product_sell_id = d.product_sell_id GROUP BY d.product_sell_id");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
						$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity) AS total_sales_quantity, SUM(c.sales_order_detail_bonus) AS total_sales_bonus, SUM(c.sales_order_detail_quantity * (c.sales_order_detail_price - c.sales_order_detail_discount - c.sales_order_detail_discount_cash)) AS sub_total_sales_price FROM sales_invoice a, sales_order b, sales_order_detail c WHERE a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id");
						$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
						
						$total_sales_quantity = format_angka($data_tbl_sales_order_detail['total_sales_quantity']);
						$total_sales_bonus = format_angka($data_tbl_sales_order_detail['total_sales_bonus']);
						$sub_total_sales_price = format_angka($data_tbl_sales_order_detail['sub_total_sales_price']);
				?>
						<th style="text-align: center;">
							<?php echo $total_sales_quantity ?>
						</th>
						<th style="text-align: center;">
							<?php echo $total_sales_bonus ?>
						</th>
						<th>
						</th>
						<th style="text-align: right;">
							<?php echo $sub_total_sales_price ?>
						</th>
				<?php
					}
				?>
					</tr>
				</thead>
			</table>
			<small><i>Di Cetak Oleh : <?php echo $_SESSION['user_name'] ?> | <?php echo date("d-m-Y H:i:s") ?></i></small>
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
						<td style="text-align: right;">LAPORAN PENJUALAN</td>
					</tr>
					<tr>
						<td style="text-align: right;">BY SALESMAN IN QUANTITY IN VALUE</td>
					</tr>
					<tr>
						<td style="font-size: 11px; text-align: right;">Periode <?php echo $sales_from_date_indo ?> - <?php echo $sales_to_date_indo ?></td>
					</tr>
				</tbody>
			</table>
			<br />
			<table id="content-table">
				<thead>
					<tr>
						<th rowspan="2">
							No
						</th>
						<th rowspan="2">
							Faktur
						</th>
						<th rowspan="2">
							Pelanggan
						</th>
				<?php
					$tbl_product_sell = mysql_query("SELECT e.product_sell_name FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, product_sell e WHERE d.sales_request_active = '1' AND e.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND d.salesman_id = '".$_GET['salesman_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND c.product_sell_id = e.product_sell_id GROUP BY e.product_sell_id");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
				?>
						<th colspan="3">
							<?php echo $data_tbl_product_sell['product_sell_name'] ?>
						</th>
						<th rowspan="2">
							Sub Total
						</th>
				<?php
					}
				?>
					</tr>
					<tr>
				<?php
					$tbl_product_sell = mysql_query("SELECT e.product_sell_name FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, product_sell e WHERE d.sales_request_active = '1' AND e.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND d.salesman_id = '".$_GET['salesman_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND c.product_sell_id = e.product_sell_id GROUP BY e.product_sell_id");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
				?>
						<th>
							Jumlah
						</th>
						<th>
							Bonus
						</th>
						<th>
							Harga Jual
						</th>
				<?php
					}
				?>
					</tr>
				</thead>
				<tbody>
			<?php
				$tbl_user = mysql_query("SELECT e.user_id, e.user_name, e.user_no FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, user e WHERE d.sales_request_active = '1' AND e.user_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND d.salesman_id = '".$_GET['salesman_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.salesman_id = e.user_id GROUP BY e.user_id ORDER BY e.user_name");
				while ($data_tbl_user = mysql_fetch_array($tbl_user))
				{
			?>
					<tr>
						<td colspan="15">
							<?php echo $data_tbl_user['user_no'] ?> - <?php echo $data_tbl_user['user_name'] ?>
						</td>
				<?php
					$no = 1;
					$tbl_sales_invoice = mysql_query("SELECT a.sales_invoice_id, a.sales_invoice_no, a.sales_invoice_date, e.customer_code, e.customer_name, f.customer_category_name, g.customer_districts_name FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, customer e, customer_category f, customer_districts g WHERE d.sales_request_active = '1' AND e.customer_active = '1' AND f.customer_category_active = '1' AND g.customer_districts_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND d.salesman_id = '".$data_tbl_user['user_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.customer_id = e.customer_id AND e.customer_category_id = f.customer_category_id AND e.customer_districts_id = g.customer_districts_id GROUP BY a.sales_invoice_id ORDER BY a.sales_invoice_no");
					while ($data_tbl_sales_invoice = mysql_fetch_array($tbl_sales_invoice))
					{
						$sales_invoice_date_indo = tanggal_indo($data_tbl_sales_invoice['sales_invoice_date']);
				?>
						<tr>
							<td style="width: 3%; text-align: center;">
								<?php echo $no ?>
							</td>
							<td style="text-align: left;">
								<?php echo $data_tbl_sales_invoice['sales_invoice_no'] ?><br /><?php echo $sales_invoice_date_indo ?>
							</td>
							<td style="text-align: left;">
								(<?php echo $data_tbl_sales_invoice['customer_category_name'] ?>)<br />
								<?php echo $data_tbl_sales_invoice['customer_code'] ?> - <?php echo $data_tbl_sales_invoice['customer_name'] ?> (<?php echo $data_tbl_sales_invoice['customer_districts_name'] ?>)
							</td>
					<?php
						$tbl_product_sell = mysql_query("SELECT e.product_sell_id, e.product_sell_price FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, product_sell e WHERE d.sales_request_active = '1' AND e.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND d.salesman_id = '".$data_tbl_user['user_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND c.product_sell_id = e.product_sell_id GROUP BY e.product_sell_id");
						while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
						{	
						$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity) AS total_quantity, SUM(c.sales_order_detail_bonus) AS total_bonus, SUM(c.sales_order_detail_price - c.sales_order_detail_discount - c.sales_order_detail_discount_cash) AS sales_price, SUM(c.sales_order_detail_quantity * (c.sales_order_detail_price - c.sales_order_detail_discount - c.sales_order_detail_discount_cash)) AS sub_total_sales_price FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND a.sales_invoice_id = '".$data_tbl_sales_invoice['sales_invoice_id']."' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.salesman_id = '".$data_tbl_user['user_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
						$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
						$total_quantity = format_angka($data_tbl_sales_order_detail['total_quantity']);
						$total_bonus = format_angka($data_tbl_sales_order_detail['total_bonus']);
						$sales_price = format_angka($data_tbl_sales_order_detail['sales_price']);
						$sub_total_sales_price = format_angka($data_tbl_sales_order_detail['sub_total_sales_price']);
					?>
							<td style="text-align: center;">
								<?php echo $total_quantity ?>
							</td>
							<td style="text-align: center;">
								<?php echo $total_bonus ?>
							</td>
							<td style="text-align: right;">
								<?php echo $sales_price ?>
							</td>
							<td style="text-align: right;">
								<?php echo $sub_total_sales_price ?>
							</td>
					<?php
						}
					?>
						</tr>
				<?php
					$no++;
					}
				?>
					</tr>
			<?php
				}
			?>
				</tbody>
				<thead>
					<tr>
						<th colspan="3">
							Grand Total
						</th>
				<?php
					$tbl_product_sell = mysql_query("SELECT e.product_sell_id, e.product_sell_price FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, product_sell e WHERE d.sales_request_active = '1' AND e.product_sell_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND d.salesman_id = '".$_GET['salesman_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND c.product_sell_id = e.product_sell_id GROUP BY e.product_sell_id");
					while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
					{
						$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity) AS total_sales_quantity, SUM(c.sales_order_detail_bonus) AS total_sales_bonus, SUM(c.sales_order_detail_quantity * (c.sales_order_detail_price - c.sales_order_detail_discount - c.sales_order_detail_discount_cash)) AS sub_total_sales_price FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE d.sales_request_active = '1' AND a.sales_invoice_date BETWEEN '".$sales_from_date."' AND '".$sales_to_date."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.salesman_id = '".$_GET['salesman_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
						$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
						
						$total_sales_quantity = format_angka($data_tbl_sales_order_detail['total_sales_quantity']);
						$total_sales_bonus = format_angka($data_tbl_sales_order_detail['total_sales_bonus']);
						$sub_total_sales_price = format_angka($data_tbl_sales_order_detail['sub_total_sales_price']);
				?>
						<th style="text-align: center;">
							<?php echo $total_sales_quantity ?>
						</th>
						<th style="text-align: center;">
							<?php echo $total_sales_bonus ?>
						</th>
						<th>
						</th>
						<th style="text-align: right;">
							<?php echo $sub_total_sales_price ?>
						</th>
				<?php
					}
				?>
					</tr>
				</thead>
			</table>
			<small><i>Di Cetak Oleh : <?php echo $_SESSION['user_name'] ?> | <?php echo date("d-m-Y H:i:s") ?></i></small>
<?php
		}
	}
?>
</body>
</html>