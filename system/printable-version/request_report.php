<?php
	error_reporting(0);
	ob_start();
	session_start();
	
	include "../../script_conn.php";
	include "../../library/currency.php";
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
	$salesrequestfromDate = explode("-", $_GET['sales_request_from_date']);
	$DatesalesrequestfromDate = $salesrequestfromDate[0];
	$MonthsalesrequestfromDate = $salesrequestfromDate[1];
	$YearsalesrequestfromDate = $salesrequestfromDate[2];
	$sales_request_from_date = $_GET['sales_request_from_date'];
	$sales_request_from_date_indo = tanggal_indo($sales_request_from_date);
	
	$salesrequesttoDate = explode("-", $_GET['sales_request_to_date']);
	$DatesalesrequesttoDate = $salesrequesttoDate[0];
	$MonthsalesrequesttoDate = $salesrequesttoDate[1];
	$YearsalesrequesttoDate = $salesrequesttoDate[2];
	$sales_request_to_date = $_GET['sales_request_to_date'];
	$sales_request_to_date_indo = tanggal_indo($_GET['sales_request_to_date']);
	
	if ($_GET['tib'] == "form-print-by-customer-type-request-report")
	{
?>
		<table id="header-table">
			<tbody>
				<tr>
					<td style="width: 50%;" rowspan="4"><img src="../../assets/pages/media/invoice/walmart3.png"/></td>
				</tr>
				<tr>
					<td style="text-align: right;">LAPORAN PERMINTAAN</td>
				</tr>
				<tr>
					<td style="text-align: right;">BY JENIS PELANGGAN</td>
				</tr>
				<tr>
					<td style="font-size: 11px; text-align: right;">Periode <?php echo $sales_request_from_date_indo ?> - <?php echo $sales_request_to_date_indo ?></td>
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
			<?php
				$tbl_customer_type = mysql_query("SELECT c.customer_type_name FROM sales_request a, customer b, customer_type c WHERE a.sales_request_active = '1' AND b.customer_active = '1' AND c.customer_type_active = '1' AND a.sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND a.customer_id = b.customer_id AND b.customer_type_id = c.customer_type_id GROUP BY c.customer_type_id");
				while($data_tbl_customer_type = mysql_fetch_array($tbl_customer_type))
				{
			?>
					<th>
						<?php echo $data_tbl_customer_type['customer_type_name'] ?>
					</th>
			<?php
				}
			?>
				</tr>
			</thead>
			<tbody>
		<?php
			$no = 1;
			$tbl_customer_city = mysql_query("SELECT d.customer_city_id, d.customer_city_name FROM sales_request a, customer b, customer_districts c, customer_city d WHERE a.sales_request_active = '1' AND b.customer_active = '1' AND c.customer_districts_active = '1' AND d.customer_city_active = '1' AND a.sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND a.customer_id = b.customer_id AND b.customer_districts_id = c.customer_districts_id AND c.customer_city_id = d.customer_city_id GROUP BY d.customer_city_id");
			while ($data_tbl_customer_city = mysql_fetch_array($tbl_customer_city))
			{
				$tbl_customer_type = mysql_query("SELECT c.customer_type_name FROM sales_request a, customer b, customer_type c WHERE a.sales_request_active = '1' AND b.customer_active = '1' AND c.customer_type_active = '1' AND a.sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND a.customer_id = b.customer_id AND b.customer_type_id = c.customer_type_id GROUP BY c.customer_type_id");
				$jumlah_tbl_customer_type = mysql_num_rows($tbl_customer_type);
		?>
				<tr>
					<td style="width: 3%; text-align: center;">
						<?php echo $no ?>
					</td>
					<td style="text-align: center;">
						<?php echo $data_tbl_customer_city['customer_city_name'] ?>
					</td>
					<td colspan="<?php echo $jumlah_tbl_customer_type + 1 ?>" style="text-align: center;">
					</td>
			<?php
				$tbl_customer_districts = mysql_query("SELECT c.customer_districts_id, c.customer_districts_name FROM sales_request a, customer b, customer_districts c WHERE a.sales_request_active = '1' AND b.customer_active = '1' AND c.customer_districts_active = '1' AND a.sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND c.customer_city_id = '".$data_tbl_customer_city['customer_city_id']."' AND a.customer_id = b.customer_id AND b.customer_districts_id = c.customer_districts_id GROUP BY c.customer_districts_id ORDER BY c.customer_districts_name");
				while($data_tbl_customer_districts = mysql_fetch_array($tbl_customer_districts))
				{
			?>
					<tr>
						<td colspan="2">
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer_districts['customer_districts_name'] ?>
						</td>
				<?php
					$tbl_customer_type = mysql_query("SELECT c.customer_type_id FROM sales_request a, customer b, customer_type c WHERE a.sales_request_active = '1' AND b.customer_active = '1' AND c.customer_type_active = '1' AND a.sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND a.customer_id = b.customer_id AND b.customer_type_id = c.customer_type_id GROUP BY c.customer_type_id");
					while($data_tbl_customer_type = mysql_fetch_array($tbl_customer_type))
					{
						$tbl_sales_request = mysql_query("SELECT COUNT(DISTINCT(b.customer_id)) AS total_quantity FROM sales_request a, customer b WHERE a.sales_request_active = '1' AND b.customer_active = '1' AND a.sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND b.customer_type_id = '".$data_tbl_customer_type['customer_type_id']."' AND b.customer_districts_id = '".$data_tbl_customer_districts['customer_districts_id']."' AND a.customer_id = b.customer_id");
						$data_tbl_sales_request = mysql_fetch_array($tbl_sales_request);
						
						$total_quantity = format_angka($data_tbl_sales_request['total_quantity']);
				?>
						<td style="text-align: center;">
							<?php echo $total_quantity ?>
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
					<td colspan="3" style="text-align: center;">
						Total
					</td>
			<?php
				$tbl_customer_type = mysql_query("SELECT c.customer_type_id FROM sales_request a, customer b, customer_type c WHERE a.sales_request_active = '1' AND b.customer_active = '1' AND c.customer_type_active = '1' AND a.sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND a.customer_id = b.customer_id AND b.customer_type_id = c.customer_type_id GROUP BY c.customer_type_id");
				while($data_tbl_customer_type = mysql_fetch_array($tbl_customer_type))
				{
					$tbl_sales_request = mysql_query("SELECT COUNT(DISTINCT(b.customer_id)) AS total_quantity FROM sales_request a, customer b, customer_districts c WHERE a.sales_request_active = '1' AND b.customer_active = '1' AND c.customer_districts_active = '1' AND a.sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND b.customer_type_id = '".$data_tbl_customer_type['customer_type_id']."' AND c.customer_city_id = '".$data_tbl_customer_city['customer_city_id']."' AND a.customer_id = b.customer_id AND b.customer_districts_id = c.customer_districts_id");
					$data_tbl_sales_request = mysql_fetch_array($tbl_sales_request);
					
					$total_quantity = format_angka($data_tbl_sales_request['total_quantity']);
			?>
					<td style="text-align: center;">
						<?php echo $total_quantity ?>
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
				$tbl_customer_type = mysql_query("SELECT c.customer_type_id FROM sales_request a, customer b, customer_type c WHERE a.sales_request_active = '1' AND b.customer_active = '1' AND c.customer_type_active = '1' AND a.sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND a.customer_id = b.customer_id AND b.customer_type_id = c.customer_type_id GROUP BY c.customer_type_id");
				while($data_tbl_customer_type = mysql_fetch_array($tbl_customer_type))
				{
					$tbl_sales_request = mysql_query("SELECT COUNT(DISTINCT(b.customer_id)) AS total_quantity FROM sales_request a, customer b WHERE a.sales_request_active = '1' AND b.customer_active = '1' AND a.sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND b.customer_type_id = '".$data_tbl_customer_type['customer_type_id']."' AND a.customer_id = b.customer_id");
					$data_tbl_sales_request = mysql_fetch_array($tbl_sales_request);
					
					$total_quantity = format_angka($data_tbl_sales_request['total_quantity']);
			?>
					<th>
						<?php echo $total_quantity ?>
					</th>
			<?php
				}
			?>
				</tr>
			</thead>
		</table>
<?php
	}
	elseif ($_GET['tib'] == "form-print-by-order-request-report")
	{
		
?>
		<table id="header-table">
			<tbody>
				<tr>
					<td style="width: 50%;" rowspan="4"><img src="../../assets/pages/media/invoice/walmart3.png"/></td>
				</tr>
				<tr>
					<td style="text-align: right;">LAPORAN PERMINTAAN</td>
				</tr>
				<tr>
					<td style="text-align: right;">BY PESANAN</td>
				</tr>
				<tr>
					<td style="font-size: 11px; text-align: right;">Periode <?php echo $sales_request_from_date_indo ?> - <?php echo $sales_request_to_date_indo ?></td>
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
						By Phone
					</th>
					<th>
						By Visit
					</th>
				</tr>
			</thead>
			<tbody>
		<?php
			$no = 1;
			$tbl_user = mysql_query("SELECT b.user_id, b.user_name FROM sales_request a, user b WHERE a.sales_request_active = '1' AND b.user_active = '1' AND a.sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND a.salesman_id = b.user_id GROUP BY b.user_id ORDER BY b.user_name");
			while($data_tbl_user = mysql_fetch_array($tbl_user))
			{
				$tbl_sales_request_by_phone = mysql_query("SELECT COUNT(customer_id) AS total_quantity FROM sales_request WHERE sales_request_active = '1' AND sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND salesman_id = '".$data_tbl_user['user_id']."' AND sales_request_order_method = 'By Phone'");
				$data_tbl_sales_request_by_phone = mysql_fetch_array($tbl_sales_request_by_phone);
				
				$tbl_sales_request_by_visit = mysql_query("SELECT COUNT(customer_id) AS total_quantity FROM sales_request WHERE sales_request_active = '1' AND sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND salesman_id = '".$data_tbl_user['user_id']."' AND sales_request_order_method = 'By Visit'");
				$data_tbl_sales_request_by_visit = mysql_fetch_array($tbl_sales_request_by_visit);
		?>
				<tr>
					<td style="width: 3%; text-align: center;">
						<?php echo $no ?>
					</td>
					<td style="text-align: center;">
						<?php echo $data_tbl_user['user_name'] ?>
					</td>
					<td style="text-align: center;">
						<?php echo $data_tbl_sales_request_by_phone['total_quantity'] ?>
					</td>
					<td style="text-align: center;">
						<?php echo $data_tbl_sales_request_by_visit['total_quantity'] ?>
					</td>
				</tr>
		<?php
			$no++;
			}
		?>
			</tbody>
			<thead>
				<?php
					$tbl_sales_request_by_phone = mysql_query("SELECT COUNT(customer_id) AS total_quantity FROM sales_request WHERE sales_request_active = '1' AND sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND sales_request_order_method = 'By Phone'");
					$data_tbl_sales_request_by_phone = mysql_fetch_array($tbl_sales_request_by_phone);
					
					$tbl_sales_request_by_visit = mysql_query("SELECT COUNT(customer_id) AS total_quantity FROM sales_request WHERE sales_request_active = '1' AND sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND sales_request_order_method = 'By Visit'");
					$data_tbl_sales_request_by_visit = mysql_fetch_array($tbl_sales_request_by_visit);
				?>
					<tr>
						<th colspan="2">
							Grand Total
						</th>
						<th style="text-align: center;">
							<?php echo $data_tbl_sales_request_by_phone['total_quantity'] ?>
						</th>
						<th style="text-align: center;">
							<?php echo $data_tbl_sales_request_by_visit['total_quantity'] ?>
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