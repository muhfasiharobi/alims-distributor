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
	$billingvisitDate = explode("-", $_GET['billing_visit_date']);
	$DatebillingvisitDate = $billingvisitDate[0];
	$MonthbillingvisitDate = $billingvisitDate[1];
	$YearbillingvisitDate = $billingvisitDate[2];
	$billing_visit_date = date("Y-m-d", mktime(0, 0, 0, $MonthbillingvisitDate, $DatebillingvisitDate, $YearbillingvisitDate));
	
	$billing_visit_date_indo = tanggal_indo($billing_visit_date);
	
	if ($_GET['tib'] == "form-print-by-billingman-in-value-billing-visit-report")
	{
?>
	<table id="header-table">
		<tbody>
			<tr>
				<td style="width: 50%;" rowspan="4"><img src="../../assets/admin/pages/media/invoice/walmart3.png"/></td>
			</tr>
			<tr>
				<td style="text-align: right;">LAPORAN PENAGIHAN</td>
			</tr>
			<tr>
				<td style="text-align: right;">BY BILLINGMAN IN VALUE</td>
			</tr>
			<tr>
				<td style="font-size: 11px; text-align: right;">Periode <?php echo $billing_visit_date_indo ?></td>
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
					Faktur
				</th>
				<th rowspan=2>
					Salesman
				</th>
				<th rowspan=2>
					Pelanggan
				</th>
				<th rowspan=2>
					Alamat
				</th>
				<th colspan="2">
					Kunjungan
				</th>
				<th rowspan="2">
					Durasi Waktu
				</th>
				<th rowspan=2>
					Total Faktur
				</th>
				<th colspan=3>
					Pembayaran
				</th>
				<th rowspan=2>
					Keterangan
				</th>
				<th rowspan=2>
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
		<?php
			$tbl_payment_type = mysql_query("SELECT payment_type_id, payment_type_name FROM payment_type WHERE payment_type_active = '1' ORDER BY payment_type_id");
			while($data_tbl_payment_type = mysql_fetch_array($tbl_payment_type))
			{
		?>
				<th>
					<?php echo $data_tbl_payment_type['payment_type_name'] ?>
				</th>
		<?php
			}
		?>
			</tr>
		</thead>
		<tbody>
	<?php
		$no = 1;
		$tbl_billing_work_plan_detail = mysql_query("SELECT a.billing_work_plan_detail_id, a.sales_invoice_no, a.sales_invoice_date, a.billing_work_plan_detail_total_price, c.user_name, d.customer_code, d.customer_name, d.customer_address, e.customer_category_name, f.customer_districts_name FROM billing_work_plan_detail a, billing_work_plan b, user c, customer d, customer_category e, customer_districts f WHERE b.billing_work_plan_date = '".$billing_visit_date."' AND a.billing_work_plan_id = b.billing_work_plan_id AND a.salesman_id = c.user_id AND a.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id ORDER BY a.billing_work_plan_detail_id");
		while ($data_tbl_billing_work_plan_detail = mysql_fetch_array($tbl_billing_work_plan_detail))
		{
			$sales_invoice_date_indo = tanggal_indo($data_tbl_billing_work_plan_detail['sales_invoice_date']);
			$billing_work_plan_detail_total_price = format_angka($data_tbl_billing_work_plan_detail['billing_work_plan_detail_total_price']);
			
			$tbl_billing_visit = mysql_query("SELECT timediff(billing_visit_time_out, billing_visit_time_in) AS time_duration, billing_visit_time_in, billing_visit_time_out, billing_visit_description, billing_visit_status FROM billing_visit WHERE billing_work_plan_detail_id = '".$data_tbl_billing_work_plan_detail['billing_work_plan_detail_id']."'");
			$data_tbl_billing_visit = mysql_fetch_array($tbl_billing_visit);
			
			$tbl_billing_visit_detail = mysql_query("SELECT a.billing_visit_detail_description FROM billing_visit_detail a, billing_visit b WHERE a.billing_visit_id = b.billing_visit_id AND b.billing_work_plan_detail_id = '".$data_tbl_billing_work_plan_detail['billing_work_plan_detail_id']."'");
			$data_tbl_billing_visit_detail = mysql_fetch_array($tbl_billing_visit_detail);
	?>
			<tr>
				<td style="width: 3%; text-align: center;">
					<?php echo $no ?>
				</td>
				<td style="text-align: left;">
					<?php echo $data_tbl_billing_work_plan_detail['sales_invoice_no'] ?><br />
					<?php echo $sales_invoice_date_indo ?>
				</td>
				<td style="text-align: center;">
					<?php echo $data_tbl_billing_work_plan_detail['user_name'] ?>
				</td>
				<td style="text-align: left;">
					<?php echo $data_tbl_billing_work_plan_detail['customer_category_name'] ?><br /> 
					<?php echo $data_tbl_billing_work_plan_detail['customer_code'] ?> - <?php echo $data_tbl_billing_work_plan_detail['customer_name'] ?> (<?php echo $data_tbl_billing_work_plan_detail['customer_districts_name'] ?>)
				</td>
				<td style="text-align: left;">
					<?php echo $data_tbl_billing_work_plan_detail['customer_address'] ?>
				</td>
				<td style="text-align: center;">
					<?php echo $data_tbl_billing_visit['billing_visit_time_in'] ?>
				</td>
				<td style="text-align: center;">
					<?php echo $data_tbl_billing_visit['billing_visit_time_out'] ?>
				</td>
				<td style="text-align: center;">
					<?php echo $data_tbl_billing_visit['time_duration'] ?>
				</td>
				<td style="text-align: right;">
					<?php echo $billing_work_plan_detail_total_price ?>
				</td>
		<?php
			$tbl_payment_type = mysql_query("SELECT payment_type_id, payment_type_name FROM payment_type WHERE payment_type_active = '1' ORDER BY payment_type_id");
			while($data_tbl_payment_type = mysql_fetch_array($tbl_payment_type))
			{
				$tbl_billing_visit_detaila = mysql_query("SELECT SUM(a.billing_visit_detail_total_price) AS total_price FROM billing_visit_detail a, billing_visit b WHERE a.billing_visit_id = b.billing_visit_id AND b.billing_work_plan_detail_id = '".$data_tbl_billing_work_plan_detail['billing_work_plan_detail_id']."' AND a.payment_type_id = '".$data_tbl_payment_type['payment_type_id']."'");
				$data_tbl_billing_visit_detaila = mysql_fetch_array($tbl_billing_visit_detaila);
				$billing_visit_detail_total_price = format_angka($data_tbl_billing_visit_detaila['total_price']);
		?>
				<td style="text-align: right;">
					<?php echo $billing_visit_detail_total_price ?>
				</td>
		<?php
			}
		?>
				<td style="text-align: left;">
					<?php echo $data_tbl_billing_visit_detail['billing_visit_detail_description'] ?>
				</td>
				<td style="text-align: center;">
			<?php
				if ($data_tbl_billing_visit['billing_visit_status'] == "Call")
				{
			?>
					<font color="blue">Call</font>
			<?php
				}
				elseif ($data_tbl_billing_visit['billing_visit_status'] == "Paid")
				{
			?>
					<font color="green">Paid</font>
			<?php
				}
				else
				{
			?>
					<font color="red">Unpaid</font><br />
					<?php echo $data_tbl_billing_visit['billing_visit_description'] ?>
			<?php
				}
			?>
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
				$tbl_billing_visit = mysql_query("SELECT SEC_TO_TIME(SUM((TIME_TO_SEC(TIMEDIFF(a.billing_visit_time_out, a.billing_visit_time_in))))) AS time_duration FROM billing_visit a, billing_work_plan_detail b, billing_work_plan c WHERE c.billing_work_plan_active = '1' AND c.billing_work_plan_date = '".$billing_visit_date."' AND a.billing_work_plan_detail_id = b.billing_work_plan_detail_id AND b.billing_work_plan_id = c.billing_work_plan_id");
				$data_tbl_billing_visit = mysql_fetch_array($tbl_billing_visit);
			?>
				<th style="text-align: center;">
					<?php echo $data_tbl_billing_visit['time_duration'] ?>
				</th>
			<?php
				$tbl_billing_work_plan_detail = mysql_query("SELECT SUM(a.billing_work_plan_detail_total_price) AS total_price FROM billing_work_plan_detail a, billing_work_plan b WHERE a.billing_work_plan_id = b.billing_work_plan_id AND b.billing_work_plan_date = '".$billing_visit_date."'");
				$data_tbl_billing_work_plan_detail = mysql_fetch_array($tbl_billing_work_plan_detail);
				$billing_work_plan_detail_total_price_all = format_angka($data_tbl_billing_work_plan_detail['total_price']);
			?>
				<th style="text-align: right;">
					<?php echo $billing_work_plan_detail_total_price_all ?>
				</th>
		<?php
			$tbl_payment_type = mysql_query("SELECT payment_type_id, payment_type_name FROM payment_type WHERE payment_type_active = '1' ORDER BY payment_type_id");
			while($data_tbl_payment_type = mysql_fetch_array($tbl_payment_type))
			{
				$tbl_billing_visit_detail = mysql_query("SELECT SUM(a.billing_visit_detail_total_price) AS total_price FROM billing_visit_detail a, billing_visit b, billing_work_plan_detail c, billing_work_plan d WHERE a.billing_visit_id = b.billing_visit_id AND b.billing_work_plan_detail_id = c.billing_work_plan_detail_id AND c.billing_work_plan_id = d.billing_work_plan_id AND a.payment_type_id = '".$data_tbl_payment_type['payment_type_id']."' AND d.billing_work_plan_date = '".$billing_visit_date."'");
				$data_tbl_billing_visit_detail = mysql_fetch_array($tbl_billing_visit_detail);
				$billing_visit_detail_total_price_all = format_angka($data_tbl_billing_visit_detail['total_price']);
		?>
				<th style="text-align: right;">
					<?php echo $billing_visit_detail_total_price_all ?>
				</th>
		<?php
			}
		?>
				<th colspan="2">
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