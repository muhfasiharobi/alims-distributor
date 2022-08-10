<?php 
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
<link rel="shortcut icon" href="../../favicon.ico"/>
<style type="text/css">
	body
	{
		font-family: Tahoma;
		letter-spacing: 3px;
		line-height: 8px;
		margin-top: 25px;
	}
	table
	{ 
		width: 100%;
	}
</style>
</head>
<body>
<?php
	$tbl_sales_invoice = mysql_query("SELECT a.sales_invoice_id, a.sales_invoice_no, a.sales_invoice_date, b.sales_order_id, b.sales_order_due_date, c.sales_request_no, c.sales_request_payment_method, d.user_name, e.customer_code, e.customer_name, e.customer_address, e.customer_contact, e.customer_phone, f.customer_districts_name FROM sales_invoice a, sales_order b, sales_request c, user d, customer e, customer_districts f WHERE a.sales_invoice_id = '".$_GET['sales_invoice_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.salesman_id = d.user_id AND c.customer_id = e.customer_id AND e.customer_districts_id = f.customer_districts_id");
	$data_tbl_sales_invoice = mysql_fetch_array($tbl_sales_invoice);
	
	$sales_invoice_date = date("d/m/Y", strtotime($data_tbl_sales_invoice['sales_invoice_date']));
?>
	<table border="0">
		<tbody style="font-size: 10px;">
			<tr>
				<td style="width: 10%"></td>
				<td style="width: 60%"></td>
				<td style="text-align: right;"><?php echo $data_tbl_sales_invoice['sales_invoice_no'] ?></td>
			</tr>
			<tr>
				<td></td>
				<td><?php echo $data_tbl_sales_invoice['customer_code'] ?> - <?php echo $data_tbl_sales_invoice['customer_name'] ?></td>
				<td style="text-align: right;"><?php echo $sales_invoice_date ?></td>
			</tr>
			<tr>
				<td></td>
				<td><?php echo $data_tbl_sales_invoice['customer_address'] ?></td>
				<td style="text-align: right;"><?php echo $data_tbl_sales_invoice['sales_order_due_date'] ?> Hari</td>
			</tr>
			<tr>
				<td></td>
				<td><?php echo $data_tbl_sales_invoice['customer_districts_name'] ?></td>
				<td style="text-align: right;"><?php echo $data_tbl_sales_invoice['sales_request_no'] ?></td>
			</tr>
			<tr>
				<td></td>
				<td><?php echo $data_tbl_sales_invoice['customer_contact'] ?> - <?php echo $data_tbl_sales_invoice['customer_phone'] ?></td>
				<td style="text-align: right;"><?php echo $data_tbl_sales_invoice['user_name'] ?></td>
			</tr>
		</tbody>
	</table>
	<br />
	<br />
	<br />
	<br />
	<table>
		<tbody style="font-size: 14px;">
		<?php
			$tbl_sales_order_detail = mysql_query("SELECT a.sales_order_detail_product_sell_quantity, a.sales_order_detail_product_sell_price, a.sales_order_detail_program_bonus, a.sales_order_detail_product_sell_discount, a.sales_order_detail_cash_discount, a.sales_order_detail_delivery_cost_price, b.product_sell_code, b.product_sell_name, c.product_unit_name FROM sales_order_detail a, product_sell b, product_unit c WHERE a.sales_order_id = '".$data_tbl_sales_invoice['sales_order_id']."' AND a.product_sell_id = b.product_sell_id AND b.product_unit_id = c.product_unit_id ORDER BY b.product_sell_id, a.sales_order_detail_id");
			while ($data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail))
			{
				$sales_order_detail_product_sell_quantity = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity']);
				$sales_order_detail_product_sell_price = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_price']);
				$sales_order_detail_program_bonus = format_angka($data_tbl_sales_order_detail['sales_order_detail_program_bonus']);
				$sales_order_detail_product_sell_discount = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_discount']);
				$sales_order_detail_cash_discount = ($data_tbl_sales_order_detail['sales_order_detail_cash_discount'] / $data_tbl_sales_order_detail['sales_order_detail_product_sell_price']) * 100;
				$sales_order_detail_delivery_cost_price = format_angka($data_tbl_sales_order_detail['sales_order_detail_delivery_cost_price']);
				$sub_total_price = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity'] * ($data_tbl_sales_order_detail['sales_order_detail_product_sell_price'] - $data_tbl_sales_order_detail['sales_order_detail_product_sell_discount'] - $data_tbl_sales_order_detail['sales_order_detail_cash_discount'] + $data_tbl_sales_order_detail['sales_order_detail_delivery_cost_price']));
		?>
			<tr>
				<td>
					<?php echo $data_tbl_sales_order_detail['product_sell_code'] ?>
				</td>
				<td>
					<?php echo $data_tbl_sales_order_detail['product_sell_name'] ?>
				</td>
				<td>
					<?php echo $sales_order_detail_product_sell_quantity ?> <?php echo $data_tbl_sales_order_detail['product_unit_name'] ?>
				</td>
				<td>
					<?php echo $sales_order_detail_product_sell_price ?>
				</td>
				<td>
					<?php echo $sales_order_detail_cash_discount ?>
				</td>
				<td>
					<?php echo $sub_total_price ?>
				</td>
				<?php
					if ($data_tbl_sales_order_detail['sales_order_detail_program_bonus'] != "0")
					{
				?>
					<tr>
						<td>
							<?php echo $data_tbl_sales_order_detail['product_sell_code'] ?>
						</td>
						<td>
							(Bonus) <?php echo $data_tbl_sales_order_detail['product_sell_name'] ?>
						</td>
						<td>
							<?php echo $sales_order_detail_program_bonus ?> <?php echo $data_tbl_sales_order_detail['product_unit_name'] ?>
						</td>
						<td>
							0
						</td>
						<td>
							0
						</td>
						<td>
							0
						</td>
					</tr>
				<?php
					}
				?>
			</tr>
	<?php
		}
	?>
		</tbody>
	</table>
	<table>
		<tbody style="font-size: 16px;">
	<?php
		$tbl_sales_order_detail = mysql_query("SELECT SUM(sales_order_detail_product_sell_quantity * (sales_order_detail_product_sell_price - sales_order_detail_product_sell_discount - sales_order_detail_cash_discount)) AS total_price, SUM(sales_order_detail_product_sell_quantity + sales_order_detail_program_bonus) * (sales_order_detail_delivery_cost_price) AS total_delivery_cost_price, sales_order_detail_delivery_cost_price FROM sales_order_detail WHERE sales_order_id = '".$data_tbl_sales_invoice['sales_order_id']."'");
		$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
		
		$total_price = format_angka($data_tbl_sales_order_detail['total_price']);
		$total_delivery_charges_price = format_angka($data_tbl_sales_order_detail['total_delivery_cost_price']);
		$sub_total_price = format_angka($data_tbl_sales_order_detail['total_price'] + $data_tbl_sales_order_detail['total_delivery_cost_price']);
	?>
			<tr>
				<td style="width: 10%">
				</td>
				<td style="width: 70%">
					<small> Rupiah</i></small>
				</td>
				<td align="right">
					<?php echo $total_price ?>
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td rowspan="3">
					<i>(<?php echo $data_tbl_sales_invoice['sales_request_payment_method'] ?>)</i><br /><br />
					Biaya Pengiriman : <?php echo $data_tbl_sales_order_detail['sales_order_detail_delivery_cost_price'] ?> / Crt
				</td>
				<td align="right">
					0
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td align="right">
					<?php echo $total_delivery_charges_price ?>
				</td>
			</tr>
			<tr>
				<td>
				</td>
				<td align="right">
					<?php echo $sub_total_price ?>
				</td>
			</tr>
		</tbody>
	</table>
</body>
</html>