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
	$tbl_billing_work_plan = mysql_query("SELECT a.billing_work_plan_id, a.billing_work_plan_no, a.billing_work_plan_date, b.user_name FROM billing_work_plan a, user b WHERE a.billing_work_plan_id = '".$_GET['billing_work_plan_id']."' AND a.billingman_id = b.user_id");
	$data_tbl_billing_work_plan = mysql_fetch_array($tbl_billing_work_plan);
	
	$billing_work_plan_date_indo = tanggal_indo($data_tbl_billing_work_plan['billing_work_plan_date']);
?>
	<table id="header-table">
		<tbody>
			<tr>
				<td style="width: 50%;" rowspan="4"><img src="../../assets/admin/pages/media/invoice/walmart3.png"/></td>
			</tr>
			<tr>
				<td style="text-align: right;">RENCANA KERJA PENAGIHAN</td>
			</tr>
			<tr>
				<td style="font-size: 11px; text-align: right;"><?php echo $data_tbl_billing_work_plan['billing_work_plan_no'] ?>, <?php echo $billing_work_plan_date_indo ?></td>
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
					Faktur
				</th>
				<th>
					Salesman
				</th>
				<th>
					Pelanggan
				</th>
				<th>
					Alamat
				</th>
				<th>
					Total Faktur
				</th>
				<th>
					Pembayaran
				</th>
				<th>
					Keterangan
				</th>
				<th>
					Paraf
				</th>
			</tr>
		</thead>
		<tbody>
	<?php
		$no = 1;
		$tbl_billing_work_plan_detail = mysql_query("SELECT a.sales_invoice_no, a.sales_invoice_date, a.billing_work_plan_detail_total_price, b.user_name, c.customer_code, c.customer_name, c.customer_address, d.customer_category_name, e.customer_districts_name FROM billing_work_plan_detail a, user b, customer c, customer_category d, customer_districts e WHERE a.billing_work_plan_id = '".$data_tbl_billing_work_plan['billing_work_plan_id']."' AND a.salesman_id = b.user_id AND a.customer_id = c.customer_id AND c.customer_category_id = d.customer_category_id AND c.customer_districts_id = e.customer_districts_id ORDER BY a.billing_work_plan_detail_id");
		while ($data_tbl_billing_work_plan_detail = mysql_fetch_array($tbl_billing_work_plan_detail))
		{
			$sales_invoice_date_indo = tanggal_indo($data_tbl_billing_work_plan_detail['sales_invoice_date']);
			$billing_work_plan_detail_total_price = format_angka($data_tbl_billing_work_plan_detail['billing_work_plan_detail_total_price']);
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
				<td style="text-align: right;">
					<?php echo $billing_work_plan_detail_total_price ?>
				</td>
				<td>
				</td>
				<td>
				</td>
				<td>
				</td>
			</tr>
	<?php
		$no++;
		}
	?>
		</tbody>
	</table>
	<small><i>Di Cetak Oleh : <?php echo $_SESSION['user_name'] ?> | <?php echo date("d-m-Y H:i:s") ?></i></small>
	<br />
	<br />
	<table id="header-table">
		<tbody>
			<tr>
				<td style="font-size: 12px; text-align: center; width: 25%;">Yang Menyerahkan</td>
				<td style="font-size: 12px; text-align: center; width: 25%;">Yang Menerima</td>
				<td style="font-size: 12px; text-align: center; width: 25%;">Yang Menyerahkan</td>
				<td style="font-size: 12px; text-align: center; width: 25%;">Yang Menerima</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td style="font-size: 12px; text-align: center;"><?php echo $_SESSION['user_name'] ?></td>
				<td style="font-size: 12px; text-align: center;"><?php echo $data_tbl_billing_work_plan['user_name'] ?></td>
				<td style="font-size: 12px; text-align: center;"><?php echo $data_tbl_billing_work_plan['user_name'] ?></td>
				<td style="font-size: 12px; text-align: center;"><?php echo $_SESSION['user_name'] ?></td>
			</tr>
		</tbody>
	</table>
</body>
</html>