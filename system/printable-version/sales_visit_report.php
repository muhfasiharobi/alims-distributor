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
	$salesvisitfromDate = explode("-", $_GET['sales_visit_from_date']);
	$DatesalesvisitfromDate = $salesvisitfromDate[0];
	$MonthsalesvisitfromDate = $salesvisitfromDate[1];
	$YearsalesvisitfromDate = $salesvisitfromDate[2];
	$sales_visit_from_date = date("Y-m-d", mktime(0, 0, 0, $MonthsalesvisitfromDate, $DatesalesvisitfromDate, $YearsalesvisitfromDate));
	
	$sales_visit_from_date_indo = tanggal_indo($sales_visit_from_date);
	
	$salesvisittoDate = explode("-", $_GET['sales_visit_to_date']);
	$DatesalesvisittoDate = $salesvisittoDate[0];
	$MonthsalesvisittoDate = $salesvisittoDate[1];
	$YearsalesvisittoDate = $salesvisittoDate[2];
	$sales_visit_to_date = date("Y-m-d", mktime(0, 0, 0, $MonthsalesvisittoDate, $DatesalesvisittoDate, $YearsalesvisittoDate));
	
	$sales_visit_to_date_indo = tanggal_indo($sales_visit_to_date);
	
	$salesvisitDate = explode("-", $_GET['sales_visit_date']);
	$DatesalesvisitDate = $salesvisitDate[0];
	$MonthsalesvisitDate = $salesvisitDate[1];
	$YearsalesvisitDate = $salesvisitDate[2];
	$sales_visit_date = date("Y-m-d", mktime(0, 0, 0, $MonthsalesvisitDate, $DatesalesvisitDate, $YearsalesvisitDate));
	
	$sales_visit_date_indo = tanggal_indo($sales_visit_date);
	
	if ($_GET['tib'] == "form-print-by-salesman-in-count-sales-visit-report")
	{
?>
		<table id="header-table">
			<tbody>
				<tr>
					<td style="width: 50%;" rowspan="4"><img src="../../assets/admin/pages/media/invoice/walmart3.png"/></td>
				</tr>
				<tr>
					<td style="text-align: right;">LAPORAN KUNJUNGAN</td>
				</tr>
				<tr>
					<td style="text-align: right;">BY SALESMAN IN COUNT</td>
				</tr>
				<tr>
					<td style="font-size: 11px; text-align: right;">Periode <?php echo $sales_visit_from_date_indo ?> - <?php echo $sales_visit_to_date_indo ?></td>
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
						Kunjungan
					</th>
					<th>
						Yang Dikunjungi
					</th>
					<th>
						Yang Belum Dikunjungi
					</th>
					<th>
						Yang Order
					</th>
					<th>
						Yang Tidak Order
					</th>
				</tr>
			</thead>
			<tbody>
		<?php
			$no = 1;
			$tbl_sales_work_plan = mysql_query("SELECT COUNT(b.customer_id) AS quantity_work_plan, c.user_id, c.user_name FROM sales_work_plan a, sales_work_plan_detail b, user c WHERE a.sales_work_plan_active = '1' AND a.sales_work_plan_date BETWEEN '".$sales_visit_from_date."' AND '".$sales_visit_to_date."' AND a.sales_work_plan_id = b.sales_work_plan_id AND a.salesman_id = c.user_id GROUP BY c.user_id ORDER BY c.user_name");
			while ($data_tbl_sales_work_plan = mysql_fetch_array($tbl_sales_work_plan))
			{
				$tbl_sales_visit_yes = mysql_query("SELECT COUNT(a.sales_visit_time_in) AS total_quantity FROM sales_visit a, sales_work_plan b, sales_work_plan_detail c WHERE b.sales_work_plan_active = '1' AND NOT a.sales_visit_time_in = '00:00:00' AND b.salesman_id = '".$data_tbl_sales_work_plan['user_id']."' AND b.sales_work_plan_date BETWEEN '".$sales_visit_from_date."' AND '".$sales_visit_to_date."' AND a.sales_work_plan_detail_id = c.sales_work_plan_detail_id AND b.sales_work_plan_id = c.sales_work_plan_id");
				$data_tbl_sales_visit_yes = mysql_fetch_array($tbl_sales_visit_yes);
	
	$tbl_sales_visit_no = mysql_query("SELECT COUNT(a.sales_visit_time_in) AS total_quantity FROM sales_visit a, sales_work_plan b, sales_work_plan_detail c WHERE b.sales_work_plan_active = '1' AND a.sales_visit_time_in = '00:00:00' AND b.salesman_id = '".$data_tbl_sales_work_plan['user_id']."' AND b.sales_work_plan_date BETWEEN '".$sales_visit_from_date."' AND '".$sales_visit_to_date."' AND a.sales_work_plan_detail_id = c.sales_work_plan_detail_id AND b.sales_work_plan_id = c.sales_work_plan_id");
				$data_tbl_sales_visit_no = mysql_fetch_array($tbl_sales_visit_no);
	
				$tbl_sales_visit_order = mysql_query("SELECT COUNT(a.sales_visit_status) AS total_quantity FROM sales_visit a, sales_work_plan b, sales_work_plan_detail c WHERE b.sales_work_plan_active = '1' AND b.sales_work_plan_date BETWEEN '".$sales_visit_from_date."' AND '".$sales_visit_to_date."' AND a.sales_visit_status = 'Order' AND b.salesman_id = '".$data_tbl_sales_work_plan['user_id']."' AND a.sales_work_plan_detail_id = c.sales_work_plan_detail_id AND b.sales_work_plan_id = c.sales_work_plan_id");
				$data_tbl_sales_visit_order = mysql_fetch_array($tbl_sales_visit_order);
				
				$tbl_sales_visit_not_order = mysql_query("SELECT COUNT(a.sales_visit_status) AS total_quantity FROM sales_visit a, sales_work_plan b, sales_work_plan_detail c WHERE b.sales_work_plan_active = '1' AND b.sales_work_plan_date BETWEEN '".$sales_visit_from_date."' AND '".$sales_visit_to_date."' AND a.sales_visit_status = 'Not Order' AND b.salesman_id = '".$data_tbl_sales_work_plan['user_id']."' AND a.sales_work_plan_detail_id = c.sales_work_plan_detail_id AND b.sales_work_plan_id = c.sales_work_plan_id");
				$data_tbl_sales_visit_not_order = mysql_fetch_array($tbl_sales_visit_not_order);
		?>
				<tr>
					<td style="width: 3%; text-align: center;">
						<?php echo $no ?>
					</td>
					<td style="text-align: center;">
						<?php echo $data_tbl_sales_work_plan['user_name'] ?>
					</td>
					<td style="text-align: center;">
						<?php echo $data_tbl_sales_work_plan['quantity_work_plan'] ?>
					</td>
					<td style="text-align: center;">
						<?php echo $data_tbl_sales_visit_yes['total_quantity'] ?>
					</td>
					<td style="text-align: center;">
						<?php echo $data_tbl_sales_visit_no['total_quantity'] ?>
					</td>
					<td style="text-align: center;">
						<?php echo $data_tbl_sales_visit_order['total_quantity'] ?>
					</td>
					<td style="text-align: center;">
						<?php echo $data_tbl_sales_visit_not_order['total_quantity'] ?>
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
				$tbl_sales_work_plan = mysql_query("SELECT COUNT(b.customer_id) AS total_quantity FROM sales_work_plan a, sales_work_plan_detail b WHERE a.sales_work_plan_active = '1' AND a.sales_work_plan_date BETWEEN '".$sales_visit_from_date."' AND '".$sales_visit_to_date."' AND a.sales_work_plan_id = b.sales_work_plan_id");
				$data_tbl_sales_work_plan = mysql_fetch_array($tbl_sales_work_plan);
			
				$tbl_sales_visit_yes = mysql_query("SELECT COUNT(a.sales_visit_time_in) AS total_quantity FROM sales_visit a, sales_work_plan b, sales_work_plan_detail c WHERE b.sales_work_plan_active = '1' AND NOT a.sales_visit_time_in = '00:00:00' AND b.sales_work_plan_date BETWEEN '".$sales_visit_from_date."' AND '".$sales_visit_to_date."' AND a.sales_work_plan_detail_id = c.sales_work_plan_detail_id AND b.sales_work_plan_id = c.sales_work_plan_id");
				$data_tbl_sales_visit_yes = mysql_fetch_array($tbl_sales_visit_yes);
	
	$tbl_sales_visit_no = mysql_query("SELECT COUNT(a.sales_visit_time_in) AS total_quantity FROM sales_visit a, sales_work_plan b, sales_work_plan_detail c WHERE b.sales_work_plan_active = '1' AND a.sales_visit_time_in = '00:00:00' AND b.sales_work_plan_date BETWEEN '".$sales_visit_from_date."' AND '".$sales_visit_to_date."' AND a.sales_work_plan_detail_id = c.sales_work_plan_detail_id AND b.sales_work_plan_id = c.sales_work_plan_id");
				$data_tbl_sales_visit_no = mysql_fetch_array($tbl_sales_visit_no);
	
				$tbl_sales_visit_order = mysql_query("SELECT COUNT(a.sales_visit_status) AS total_quantity FROM sales_visit a, sales_work_plan b, sales_work_plan_detail c WHERE b.sales_work_plan_active = '1' AND b.sales_work_plan_date BETWEEN '".$sales_visit_from_date."' AND '".$sales_visit_to_date."' AND a.sales_visit_status = 'Order' AND a.sales_work_plan_detail_id = c.sales_work_plan_detail_id AND b.sales_work_plan_id = c.sales_work_plan_id");
				$data_tbl_sales_visit_order = mysql_fetch_array($tbl_sales_visit_order);
				
				$tbl_sales_visit_not_order = mysql_query("SELECT COUNT(a.sales_visit_status) AS total_quantity FROM sales_visit a, sales_work_plan b, sales_work_plan_detail c WHERE b.sales_work_plan_active = '1' AND b.sales_work_plan_date BETWEEN '".$sales_visit_from_date."' AND '".$sales_visit_to_date."' AND a.sales_visit_status = 'Not Order' AND a.sales_work_plan_detail_id = c.sales_work_plan_detail_id AND b.sales_work_plan_id = c.sales_work_plan_id");
				$data_tbl_sales_visit_not_order = mysql_fetch_array($tbl_sales_visit_not_order);
			?>
					<th>
						<?php echo $data_tbl_sales_work_plan['total_quantity'] ?>
					</th>
					<th>
						<?php echo $data_tbl_sales_visit_yes['total_quantity'] ?>
					</th>
					<th>
						<?php echo $data_tbl_sales_visit_no['total_quantity'] ?>
					</th>
					<th>
						<?php echo $data_tbl_sales_visit_order['total_quantity'] ?>
					</th>
					<th>
						<?php echo $data_tbl_sales_visit_not_order['total_quantity'] ?>
					</th>
				</tr>
			</thead>
		</table>
<?php
	}
	elseif ($_GET['tib'] == "form-print-by-salesman-in-time-sales-visit-report")
	{
?>
		<table id="header-table">
			<tbody>
				<tr>
					<td style="width: 50%;" rowspan="4"><img src="../../assets/admin/pages/media/invoice/walmart3.png"/></td>
				</tr>
				<tr>
					<td style="text-align: right;">LAPORAN KUNJUNGAN</td>
				</tr>
				<tr>
					<td style="text-align: right;">BY SALESMAN IN TIME</td>
				</tr>
				<tr>
					<td style="font-size: 11px; text-align: right;">Periode <?php echo $sales_visit_date_indo ?></td>
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
					<th colspan="2">
						Kunjungan
					</th>
					<th rowspan="2">
						Durasi Waktu
					</th>
					<th rowspan="2">
						Status
					</th>
				</tr>
				<tr>
					<th>
						Waktu Masuk
					</th>
					<th>
						Waktu Keluar
					</th>
				</tr>
			</thead>
			<tbody>
		<?php
			$tbl_sales_work_plan = mysql_query("SELECT d.user_id, d.user_name, d.user_no FROM sales_visit a, sales_work_plan b, sales_work_plan_detail c, user d WHERE b.sales_work_plan_active = '1' AND NOT a.sales_visit_time_in = '00:00:00' AND b.sales_work_plan_date = '".$sales_visit_date."' AND a.sales_work_plan_detail_id = c.sales_work_plan_detail_id AND b.sales_work_plan_id = c.sales_work_plan_id AND b.salesman_id = d.user_id GROUP BY d.user_id ORDER BY d.user_name");
			while ($data_tbl_sales_work_plan = mysql_fetch_array($tbl_sales_work_plan))
			{
		?>
				<tr>
					<td colspan="6" style="text-align: left;">
						<?php echo $data_tbl_sales_work_plan['user_no'] ?> - <?php echo $data_tbl_sales_work_plan['user_name'] ?>
					</td>
			<?php
				$no = 1;
				$tbl_sales_visit = mysql_query("SELECT timediff(a.sales_visit_time_out, a.sales_visit_time_in) AS time_duration, a.sales_visit_time_in, a.sales_visit_time_out, a.sales_visit_description, a.sales_visit_status, d.customer_code, d.customer_name, e.customer_category_name, f.customer_districts_name FROM sales_visit a, sales_work_plan b, sales_work_plan_detail c, customer d, customer_category e, customer_districts f WHERE b.sales_work_plan_active = '1' AND NOT a.sales_visit_time_in = '00:00:00' AND b.salesman_id = '".$data_tbl_sales_work_plan['user_id']."' AND b.sales_work_plan_date = '".$sales_visit_date."' AND a.sales_work_plan_detail_id = c.sales_work_plan_detail_id AND b.sales_work_plan_id = c.sales_work_plan_id AND c.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id ORDER BY a.sales_visit_time_in");
				while ($data_tbl_sales_visit = mysql_fetch_array($tbl_sales_visit))
				{
			?>
					<tr>
						<td style="width: 3%; text-align: center;">
							<?php echo $no ?>
						</td>
						<td>
							(<?php echo $data_tbl_sales_visit['customer_category_name'] ?>)<br />
								<?php echo $data_tbl_sales_visit['customer_code'] ?> - <?php echo $data_tbl_sales_visit['customer_name'] ?> (<?php echo $data_tbl_sales_visit['customer_districts_name'] ?>)
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_sales_visit['sales_visit_time_in'] ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_sales_visit['sales_visit_time_out'] ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_sales_visit['time_duration'] ?>
						</td>
						<td style="text-align: center;">
					<?php
						if ($data_tbl_sales_visit['sales_visit_status'] == "Call")
						{
					?>
							<font color="blue">Call</font>
					<?php
						}
						elseif ($data_tbl_sales_visit['sales_visit_status'] == "Not Order")
						{
					?>
							<font color="red">Not Order</font><br />
							<?php echo $data_tbl_sales_visit['sales_visit_description'] ?>
					<?php
						}
						else
						{
					?>
							<font color="green">Order</font>
					<?php
						}
					?>
						</td>
					</tr>
			<?php
				$no++;
				}
			?>
				</tr>
				<tr>
					<td colspan="4" style="font-weight: bold; text-align: center;">
						Total Durasi
					</td>
			<?php
				$tbl_sales_visit = mysql_query("SELECT SEC_TO_TIME(SUM((TIME_TO_SEC(TIMEDIFF(a.sales_visit_time_out, a.sales_visit_time_in))))) AS time_duration FROM sales_visit a, sales_work_plan b, sales_work_plan_detail c, customer d, customer_category e, customer_districts f WHERE b.sales_work_plan_active = '1' AND NOT a.sales_visit_time_in = '00:00:00' AND b.sales_work_plan_date = '".$sales_visit_date."' AND b.salesman_id = '".$data_tbl_sales_work_plan['user_id']."' AND a.sales_work_plan_detail_id = c.sales_work_plan_detail_id AND b.sales_work_plan_id = c.sales_work_plan_id AND c.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id");
				$data_tbl_sales_visit = mysql_fetch_array($tbl_sales_visit);
			?>
					<td style="font-weight: bold; text-align: center;">
						<?php echo $data_tbl_sales_visit['time_duration'] ?>
					</td>
					<td>
					</td>
				</tr>
		<?php
			}
		?>
			</tbody>
		</table>
<?php
	}
?>
	<small><i>Di Cetak Oleh : <?php echo $_SESSION['user_name'] ?> | <?php echo date("d-m-Y H:i:s") ?></i></small>
</body>
</html>