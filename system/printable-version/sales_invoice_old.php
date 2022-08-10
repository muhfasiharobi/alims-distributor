<?php 
	include "../../conn.php";
	include "../../library/currency.php";
	include "../../library/currency_calculated.php";
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
<link rel="shortcut icon" href="../../favicon.ico"/>
<style type="text/css">
	body
	{
		font-family: Courier New;
		letter-spacing: 6px;
		line-height: 12px;
		margin-top: 25px;
		margin-left: 22px;
	}
	table
	{ 
		width: 100%;
	}
</style>
</head>
<body onload="window.print(); history.back();">
<?php
	$tbl_sales_invoice = mysql_query("SELECT a.sales_invoice_id, a.sales_invoice_no, a.sales_invoice_date, b.sales_order_id, b.sales_order_due_date, c.sales_request_payment, d.user_name, e.customer_code, e.customer_name, e.customer_address, e.customer_phone, f.customer_districts_name FROM sales_invoice a, sales_order b, sales_request c, user d, customer e, customer_districts f WHERE a.sales_invoice_id = '".$_GET['sales_invoice_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.salesman_id = d.user_id AND c.customer_id = e.customer_id AND e.customer_districts_id = f.customer_districts_id");
	$data_tbl_sales_invoice = mysql_fetch_array($tbl_sales_invoice);
	
	$sales_invoice_date = date("d/m/Y", strtotime($data_tbl_sales_invoice['sales_invoice_date']));
?>
	<table border="0">
		<tbody style="font-size: 14px;">
			<tr>
				<td style="width: 21%"></td>
				<td style="width: 24%"><?php echo $sales_invoice_date ?></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td><?php echo $data_tbl_sales_invoice['sales_invoice_no'] ?></td>
				<td align="right">(<?php echo $data_tbl_sales_invoice['customer_districts_name'] ?>) <?php echo $data_tbl_sales_invoice['customer_code'] ?> - <?php echo $data_tbl_sales_invoice['customer_name'] ?></td>
			</tr>
			<tr>
				<td></td>
				<td><?php echo $data_tbl_sales_invoice['user_name'] ?></td>
				<td align="right"><?php echo $data_tbl_sales_invoice['customer_address'] ?></td>
			</tr>
			<tr>
				<td></td>
				<td><?php echo $data_tbl_sales_invoice['sales_order_due_date'] ?> Hari</td>
				<td align="right"><?php echo $data_tbl_sales_invoice['customer_phone'] ?></td>
			</tr>
		</tbody>
	</table>
	<br />
	<br />
	<br />
	<br />
	<table border="0"  cellpadding="2">
		<tbody style="font-size: 14px;">
	<?php
		$no = 1;
		$tbl_sales_order_detail = mysql_query("SELECT a.sales_order_detail_id, a.sales_order_detail_quantity, a.sales_order_detail_bonus, a.sales_order_detail_price, a.sales_order_detail_discount, a.sales_order_detail_discount_cash, a.sales_order_detail_delivery_charges_price, b.product_sell_code, b.product_sell_name, c.product_unit_name FROM sales_order_detail a, product_sell b, product_unit c WHERE a.sales_order_id = '".$data_tbl_sales_invoice['sales_order_id']."' AND a.product_sell_id = b.product_sell_id AND b.product_unit_id = c.product_unit_id ORDER BY b.product_sell_code, a.sales_order_detail_id");
		while ($data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail))
		{
			$sales_order_detail_quantity = format_angka($data_tbl_sales_order_detail['sales_order_detail_quantity']);
			$sales_order_detail_bonus = format_angka($data_tbl_sales_order_detail['sales_order_detail_bonus']);
			$sales_order_detail_price = format_angka($data_tbl_sales_order_detail['sales_order_detail_price']);
			$sales_order_detail_discount_cash = ($data_tbl_sales_order_detail['sales_order_detail_discount_cash'] / $data_tbl_sales_order_detail['sales_order_detail_price']) * 100;
			$sales_order_detail_delivery_charges_price = format_angka($data_tbl_sales_order_detail['sales_order_detail_delivery_charges_price']);
			$netto_price = format_angka($data_tbl_sales_order_detail['sales_order_detail_price'] - $data_tbl_sales_order_detail['sales_order_detail_discount'] - $data_tbl_sales_order_detail['sales_order_detail_discount_cash'] + $data_tbl_sales_order_detail['sales_order_detail_delivery_charges_price']);
			$sub_total_price = format_angka($data_tbl_sales_order_detail['sales_order_detail_quantity'] * ($data_tbl_sales_order_detail['sales_order_detail_price'] - $data_tbl_sales_order_detail['sales_order_detail_discount'] - $sales_order_detail_discount_cash + $data_tbl_sales_order_detail['sales_order_detail_delivery_charges_price']));
	?>
			<tr>
				<td style="width: 10%" align="center">
					<?php echo $data_tbl_sales_order_detail['product_sell_code'] ?>
				</td>
				<td style="width: 30%" align="left">
					Al Qodiri <?php echo $data_tbl_sales_order_detail['product_sell_name'] ?>
				</td>
				<td style="width: 12%" align="right">
					<?php echo $sales_order_detail_quantity ?> Crt<br />(<?php echo $sales_order_detail_bonus ?> Crt)
				</td>
				<td style="width: 16%" align="right">
					<?php echo $sales_order_detail_price ?>
				</td>
				<td style="width: 10%" align="center">
					<?php echo $data_tbl_sales_order_detail['sales_order_detail_discount_cash'] ?>
				</td>
				<td style="width: 8%" align="right">
					<?php echo $netto_price ?>
				</td>
				<td align="right">
					<?php echo $sub_total_price ?>
				</td>
			</tr>
	<?php
		$no++;
		}
	?>
		</tbody>
	</table>
<?php
	$tbl_sales_order_detail = mysql_query("SELECT product_sell_id FROM sales_order_detail WHERE sales_order_id = '".$data_tbl_sales_invoice['sales_order_id']."'");
	$jumlah_tbl_sales_order_detail = mysql_num_rows($tbl_sales_order_detail);

	if ($jumlah_tbl_sales_order_detail == '1')
	{
?>
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
<?php
	}
	elseif ($jumlah_tbl_sales_order_detail == '2')
	{
?>
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
<?php
	}
	else
	{
?>
	<br />
	<br />
	<br />
	<br />
<?php
	}
?>
	<table border="0">
		<tbody style="font-size: 16px;">
	<?php
		$tbl_sales_order_detail = mysql_query("SELECT SUM(sales_order_detail_quantity * (sales_order_detail_price - sales_order_detail_discount - sales_order_detail_discount_cash + sales_order_detail_delivery_charges_price)) AS total_price FROM sales_order_detail WHERE sales_order_id = '".$data_tbl_sales_invoice['sales_order_id']."'");
		$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
		
		$total_price = format_angka($data_tbl_sales_order_detail['total_price']);
		
		$total_price_calculated = terbilang($data_tbl_sales_order_detail['total_price']);
	?>
			<tr>
				<td align="right">
					<i>(<?php echo $data_tbl_sales_invoice['sales_request_payment'] ?>)</i> Rp. <?php echo $total_price ?>
				</td>
			</tr>
		</tbody>
	</table>
	<br />
	<table border="0">
		<tbody style="font-size: 14px;">
			<tr>
				<td style="width: 11%">
				</td>
				<td>
					<i><?php echo $total_price_calculated ?> Rupiah</i>
				</td>
			</tr>
		</tbody>
	</table>
<?php
	$tbl_sales_invoice = mysql_query("UPDATE sales_invoice SET sales_invoice_status_print = 'Close' WHERE sales_invoice_id = '".$data_tbl_sales_invoice['sales_invoice_id']."'");
?>
</body>
</html>