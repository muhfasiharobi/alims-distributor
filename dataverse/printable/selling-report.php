
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<html>
<head>
	<?php
	session_start();
	include "../../config/connection.php";
	include "../../library/datetime.php";
	include "../../library/currency.php";
?>
<meta charset="utf-8"/>
<title>Alimms | Art of Business Process Management</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<link rel="shortcut icon" href="../../favicon.ico"/>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
<link href="../../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
<link href="../../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css">
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="../../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css">
<link href="../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css">
<link href="../../assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css" rel="stylesheet" type="text/css">
<link href="../../assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css" rel="stylesheet" type="text/css">
<link href="../../assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css">
<link href="../../assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="../../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css">
<link href="../../assets/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css">
<link href="../../assets/global/plugins/bootstrap-markdown/css/bootstrap-markdown.min.css" rel="stylesheet" type="text/css">
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL STYLES -->
<link href="../../assets/global/css/components-rounded.min.css" id="style_components" rel="stylesheet" type="text/css">
<link href="../../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css">
<!-- END THEME GLOBAL STYLES -->
<!-- BEGIN THEME LAYOUT STYLES -->

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
								$selling_from_date = explode("-", $_GET['from']);
								$date = $selling_from_date[0];
								$month = $selling_from_date[1];
								$year = $selling_from_date[2];
								$selling_from_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
								
								$selling_to_date = explode("-", $_GET['to']);
								$date = $selling_to_date[0];
								$month = $selling_to_date[1];
								$year = $selling_to_date[2];
								$selling_to_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
	?>
	<h3 style="text-align: center;">Laporan Penjualan</h3>
	<p style="text-align: center;">Tanggal <?php echo indonesia_date_format($selling_from_date) ?> Sampai <?php echo indonesia_date_format($selling_to_date) ?></p>

	<table class="table table-striped table-bordered table-hover order-column" id="">
							<thead>
								<tr>
									<th>
										No
									</th>
									<th>
										Tanggal
									</th>
									<th>
										Agen
									</th>
									<th>
										Pelanggan
									</th>
									<th>
										Via
									</th>
									<th>
										Barang
									</th>
									<th>
										Diskon
									</th>
									<th>
										Pengiriman
									</th>
									<th>
										Biaya Kirim
									</th>
									<th>
										Total
									</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$ongkir = 0;
								$subtotal = 0;
								
								if($_SESSION['user_category_name'] == "Administrator")
								{
									$item_selling_query = mysql_query("SELECT * FROM item_selling WHERE item_selling_date BETWEEN '".$selling_from_date."' AND '".$selling_to_date."' AND item_selling_active = '1' AND item_selling_status = 'Sudah Diproses'");
								}
								else
								{
									$item_selling_query = mysql_query("SELECT * FROM item_selling a, reseller b, user c WHERE a.reseller_id = b.reseller_id AND b.user_id = c.user_id AND c.item_category_id = '".$_SESSION['item_category_id']."' AND a.item_selling_date BETWEEN '".$selling_from_date."' AND '".$selling_to_date."' AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses'");
								}
								
								while ($item_selling_fetch_array = mysql_fetch_array($item_selling_query))
								{
									
									$item_selling_delivery = mysql_fetch_array(mysql_query("SELECT * FROM item_selling_delivery WHERE item_selling_delivery_id = '".$item_selling_fetch_array['item_selling_delivery_id']."'"));
									
									$order_via = mysql_fetch_array(mysql_query("SELECT * FROM order_via WHERE order_via_id = '".$item_selling_fetch_array['order_via_id']."'"));
									
									if($ongkir == 0)
									{
										$ongkir = $item_selling_delivery['delivery_cost'];
									}
									else
									{
										$ongkir = $ongkir+$item_selling_delivery['delivery_cost'];
									}

									if($_SESSION['user_category_name'] == "Administrator")
									{
										$promo_prosentase = mysql_fetch_array(mysql_query("SELECT sum(((b.order_item_selling_quantity * b.item_price_value)* a.promo_value) / 100) AS promo_prosentase FROM item_selling a, order_item_selling b WHERE a.item_selling_date BETWEEN '".$selling_from_date."' AND '".$selling_to_date."' AND a.item_selling_id = b.item_selling_id AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses' AND a.kategori_promo = 'Prosentase' AND a.item_selling_id = '".$item_selling_fetch_array['item_selling_id']."'"));

							        	$promo_nominal = mysql_fetch_array(mysql_query("SELECT sum(a.promo_value) AS promo_nominal FROM item_selling a, order_item_selling b WHERE a.item_selling_date BETWEEN '".$selling_from_date."' AND '".$selling_to_date."' AND a.item_selling_id = b.item_selling_id AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses' AND a.kategori_promo = 'Nominal' AND a.item_selling_id = '".$item_selling_fetch_array['item_selling_id']."'"));
							        }
							        else
							        {
							        	$promo_prosentase = mysql_fetch_array(mysql_query("SELECT sum((b.order_item_selling_quantity * b.item_price_value) * a.promo_value)/100 AS promo_prosentase FROM item_selling a, order_item_selling b, item c WHERE a.item_selling_date BETWEEN '".$selling_from_date."' AND '".$selling_to_date."' AND a.item_selling_id = b.item_selling_id AND b.item_id = c.item_id AND c.item_category_id = '".$_SESSION['item_category_id']."' AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses' AND a.kategori_promo = 'Prosentase' AND a.item_selling_id = '".$item_selling_fetch_array['item_selling_id']."'"));

							        	$promo_nominal = mysql_fetch_array(mysql_query("SELECT sum(a.promo_value) AS promo_nominal FROM item_selling a, order_item_selling b, item c WHERE a.item_selling_date BETWEEN '".$selling_from_date."' AND '".$selling_to_date."' AND a.item_selling_id = b.item_selling_id AND b.item_id = c.item_id AND c.item_category_id = '".$_SESSION['item_category_id']."' AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses' AND a.kategori_promo = 'Nominal' AND a.item_selling_id = '".$item_selling_fetch_array['item_selling_id']."'"));
							        }
									
									
							?>
									
									
											<tr>
												<td>
													<?php echo $number; ?>
												</td>
												<td>
													<?php echo indonesia_date_format($item_selling_fetch_array['item_selling_date']); ?>
												</td>
												<td>
													<?php echo $item_selling_fetch_array['reseller_code']; ?> | <?php echo $item_selling_fetch_array['reseller_name']; ?>
												</td>
												<td>
													<?php echo $item_selling_fetch_array['customer_code']; ?> | <?php echo $item_selling_fetch_array['customer_name']; ?>
												</td>
												<td>
													<?php echo $order_via['order_via_name']; ?>
												</td>
												<td>
												<?php
													$total = 0;
													$order_item_selling_query = mysql_query("SELECT * FROM order_item_selling WHERE item_selling_id = '".$item_selling_fetch_array['item_selling_id']."' AND order_item_selling_active = '1'");
													while($data_order_item_selling_fetch_array = mysql_fetch_array($order_item_selling_query))
													{
														if($total == 0)
														{
															$total = $data_order_item_selling_fetch_array['item_price_value']*$data_order_item_selling_fetch_array['order_item_selling_quantity'];
														}
														else
														{
															$total = $total + ($data_order_item_selling_fetch_array['item_price_value']*$data_order_item_selling_fetch_array['order_item_selling_quantity']);
														}
												?>
														(<?php echo $data_order_item_selling_fetch_array['order_item_selling_quantity']; ?>) <?php echo $data_order_item_selling_fetch_array['item_name']; ?> x <?php echo currency_format($data_order_item_selling_fetch_array['item_price_value']); ?>,<br>
												<?php
													}
												?>
												</td>
												<td>
													<?php echo currency_format($promo_prosentase['promo_prosentase']+$promo_nominal['promo_nominal']) ?>
												</td>
												<td>
													<?php echo $item_selling_delivery['delivery_service_name'] ?>
												</td>
												<td>
													<?php echo currency_format($item_selling_delivery['delivery_cost']); ?>
												</td>
												<td>
													<?php echo currency_format(($total-($promo_prosentase['promo_prosentase']+$promo_nominal['promo_nominal']))+$item_selling_delivery['delivery_cost']); ?>
												</td>
											</tr>
											
									
							<?php
							
									if($subtotal == 0)
									{
										$subtotal = $total-($promo_prosentase['promo_prosentase']+$promo_nominal['promo_nominal'])+$item_selling_delivery['delivery_cost'];
									}
									else
									{
										$subtotal = ($subtotal+$total-($promo_prosentase['promo_prosentase']+$promo_nominal['promo_nominal']))+$item_selling_delivery['delivery_cost'];
									}
									
									$number++;
								}
							?>
											<tr>
												<td colspan="8" align="center">
													<b>Total</b>
												</td>
												<td><?php echo currency_format($ongkir) ?></td>
												<td><?php echo currency_format($subtotal) ?></td>
											</tr>
							</tbody>
	</table>

</body>
</html>