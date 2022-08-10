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
	$tbl_sales_invoice_document = mysql_query("SELECT sales_invoice_document_id, sales_invoice_document_no, sales_invoice_document_date FROM sales_invoice_document WHERE sales_invoice_document_id = '".$_GET['sales_invoice_document_id']."'");
	$data_tbl_sales_invoice_document = mysql_fetch_array($tbl_sales_invoice_document);
	
	$sales_invoice_document_date_indo = tanggal_indo($data_tbl_sales_invoice_document['sales_invoice_document_date']);
?>
	<table id="header-table">
		<tbody>
			<tr>
				<td style="width: 50%;" rowspan="4"><img src="../../assets/admin/pages/media/invoice/walmart3.png"/></td>
			</tr>
			<tr>
				<td style="text-align: right;">DOKUMEN FAKTUR PENJUALAN</td>
			</tr>
			<tr>
				<td style="font-size: 11px; text-align: right;"><?php echo $data_tbl_sales_invoice_document['sales_invoice_document_no'] ?>, <?php echo $sales_invoice_document_date_indo ?></td>
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
					Kecamatan
				</th>
				<th>
					Total Faktur
				</th>
				<th>
					Checklist
				</th>
			</tr>
		</thead>
		<tbody>
	<?php
		$tbl_customer_districts = mysql_query("SELECT f.customer_districts_id, f.customer_districts_name FROM sales_invoice_document_detail a, sales_invoice b, sales_order c, sales_request d, customer e, customer_districts f WHERE a.sales_invoice_document_id = '".$data_tbl_sales_invoice_document['sales_invoice_document_id']."' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id = c.sales_order_id AND c.sales_request_id = d.sales_request_id AND d.customer_id = e.customer_id AND e.customer_districts_id = f.customer_districts_id GROUP BY f.customer_districts_name ORDER BY f.customer_districts_name");
		while ($data_tbl_customer_districts = mysql_fetch_array($tbl_customer_districts))
		{
	?>
			<tr>
				<td colspan="8">
					Kec. <?php echo $data_tbl_customer_districts['customer_districts_name'] ?>
				</td>
		<?php
			$no = 1;
			$tbl_sales_invoice = mysql_query("SELECT b.sales_invoice_no, b.sales_invoice_date, c.sales_order_id, e.user_name, f.customer_code, f.customer_name, f.customer_address, g.customer_category_name, h.customer_districts_name FROM sales_invoice_document_detail a, sales_invoice b, sales_order c, sales_request d, user e, customer f, customer_category g, customer_districts h WHERE a.sales_invoice_document_id = '".$data_tbl_sales_invoice_document['sales_invoice_document_id']."' AND f.customer_districts_id = '".$data_tbl_customer_districts['customer_districts_id']."' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id = c.sales_order_id AND c.sales_request_id = d.sales_request_id AND d.salesman_id = e.user_id AND d.customer_id = f.customer_id AND f.customer_category_id = g.customer_category_id AND f.customer_districts_id = h.customer_districts_id ORDER BY a.sales_invoice_document_detail_id");
			while ($data_tbl_sales_invoice = mysql_fetch_array($tbl_sales_invoice))
			{
				$sales_invoice_date_indo = tanggal_indo($data_tbl_sales_invoice['sales_invoice_date']);
				
				$tbl_sales_order_detail = mysql_query("SELECT SUM(sales_order_detail_quantity * (sales_order_detail_price - sales_order_detail_discount - sales_order_detail_discount_cash)) AS sub_total_sales_order_detail FROM sales_order_detail WHERE sales_order_id = '".$data_tbl_sales_invoice['sales_order_id']."'");
				$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
				
				$sub_total_sales_order_detail = format_angka($data_tbl_sales_order_detail['sub_total_sales_order_detail']);
		?>
				<tr>
					<td style="width: 3%; text-align: center;">
						<?php echo $no ?>
					</td>
					<td style="text-align: left;">
						<?php echo $data_tbl_sales_invoice['sales_invoice_no'] ?><br />
						<?php echo $sales_invoice_date_indo ?>
					</td>
					<td style="text-align: center;">
						<?php echo $data_tbl_sales_invoice['user_name'] ?>
					</td>
					<td style="text-align: left;">
						(<?php echo $data_tbl_sales_invoice['customer_category_name'] ?>)<br /> 
						<?php echo $data_tbl_sales_invoice['customer_code'] ?> - <?php echo $data_tbl_sales_invoice['customer_name'] ?>
					</td>
					<td style="text-align: left;">
						<?php echo $data_tbl_sales_invoice['customer_address'] ?>
					</td>
					<td style="text-align: center;">
						<?php echo $data_tbl_sales_invoice['customer_districts_name'] ?>
					</td>
					<td style="text-align: right;">
						<?php echo $sub_total_sales_order_detail ?>
					</td>
					<td>
					</td>
				</tr>
		<?php
			$no++;
			}
		?>
			</tr>
			<tr>
				<td colspan="6" style="font-weight: bold;">
					Total
				</td>
				<?php
					$tbl_sales_order_detail = mysql_query("SELECT SUM(d.sales_order_detail_quantity * (d.sales_order_detail_price - d.sales_order_detail_discount - d.sales_order_detail_discount_cash)) AS total_sales_order_detail FROM sales_invoice_document_detail a, sales_invoice b, sales_order c, sales_order_detail d, sales_request e, customer f WHERE a.sales_invoice_document_id = '".$data_tbl_sales_invoice_document['sales_invoice_document_id']."' AND f.customer_districts_id = '".$data_tbl_customer_districts['customer_districts_id']."' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id = c.sales_order_id AND c.sales_order_id = d.sales_order_id AND c.sales_request_id = e.sales_request_id AND e.customer_id = f.customer_id");
					$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
						
					$total_sales_order_detail = format_angka($data_tbl_sales_order_detail['total_sales_order_detail']);
				?>
				<td style="font-weight: bold; text-align: right;">
					<?php echo $total_sales_order_detail ?>
				</td>
				<td>
				</td>
			</tr>
	<?php
		}
	?>
		</tbody>
		<thead>
			<tr>
				<th colspan="6">
					Grand Total
				</th>
				<?php
					$tbl_sales_order_detail = mysql_query("SELECT SUM(sales_order_detail_quantity * (sales_order_detail_price - sales_order_detail_discount - sales_order_detail_discount_cash)) AS grand_total_sales_order_detail FROM sales_invoice_document_detail a, sales_invoice b, sales_order_detail c WHERE a.sales_invoice_document_id = '".$data_tbl_sales_invoice_document['sales_invoice_document_id']."' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id = c.sales_order_id");
					$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
					
					$grand_total_sales_order_detail = format_angka($data_tbl_sales_order_detail['grand_total_sales_order_detail']);
				?>
				<th style="text-align: right;">
					<?php echo $grand_total_sales_order_detail ?>
				</th>
				<th>
				</th>
			</tr>
		</thead>
	</table>
	<small><i>Di Cetak Oleh : <?php echo $_SESSION['user_name'] ?> | <?php echo date("d-m-Y H:i:s") ?></i></small>
	<br />
	<br />
	<table id="header-table">
		<tbody>
			<tr>
				<td style="font-size: 12px; text-align: center; width: 50%;">Yang Menyerahkan</td>
				<td style="font-size: 12px; text-align: center; width: 50%;">Yang Menerima</td>
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
		<?php
			$tbl_user = mysql_query("SELECT a.user_name FROM user a, user_category b WHERE b.user_category_name = 'Manager Logistic and Delivery' AND a.user_category_id = b.user_category_id");
			$data_tbl_user = mysql_fetch_array($tbl_user);
		?>
			<tr>
				<td style="font-size: 12px; text-align: center;"><?php echo $_SESSION['user_name'] ?></td>
				<td style="font-size: 12px; text-align: center;"><?php echo $data_tbl_user['user_name'] ?></td>
			</tr>
		</tbody>
	</table>
</body>
</html>