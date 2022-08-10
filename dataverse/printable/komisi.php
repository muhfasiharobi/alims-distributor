
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<html>
<head>
	<?php
	session_start();
	error_reporting(0);
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
		$invoice = mysql_fetch_array(mysql_query("SELECT * FROM invoice a, reseller b WHERE a.reseller_id = b.reseller_id AND a.invoice_id = '".$_GET['invoice_id']."'"));
	?>
	<h5><?php echo $invoice['no_invoice'] ?></h5>
	<p>Tanggal : <?php echo indonesia_date_format($invoice['invoice_date']) ?></p>
	<p>Status : <span style="font-weight: bold">Lunas</span></p>
	<br>
	<p><?php echo $invoice['reseller_code'] ?> | <?php echo $invoice['reseller_name'] ?></p>
	<p><?php echo $invoice['reseller_phone'] ?></p>
	<p><?php echo $invoice['reseller_address'] ?>, <?php echo $invoice['reseller_village'] ?> - <?php echo $invoice['reseller_districts'] ?></p>
	<p><?php echo $invoice['reseller_city'] ?> - Indonesia</p>

	<br>
	<p>Penjualan <?php echo indonesia_date_format($invoice['selling_date_from']) ?> Sampai <?php echo indonesia_date_format($invoice['selling_date_to']) ?></p>

	<table class="table table-striped table-bordered table-hover order-column" id="">
							<thead>
								<tr>
									<th>
										No
									</th>
									<th>
										Nomor Penjualan
									</th>
									<th>
										Tanggal Penjualan
									</th>
									<th>
										Jumlah Komisi (Jumlah barang * Komisi barang)
									</th>
									<th>
										Total
									</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$total_quantity = 0;
								$total_komisi = 0;
								$komisi = 0;

									$item_selling_query = mysql_query("SELECT * FROM item_selling a, invoice_detail b WHERE a.item_selling_id = b.item_selling_id AND b.invoice_id = '".$_GET['invoice_id']."' AND a.invoice_status = 'Cair' AND a.item_selling_active = '1' GROUP BY a.item_selling_id");
								
								
								while ($item_selling_fetch_array = mysql_fetch_array($item_selling_query))
								{
									
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $item_selling_fetch_array['item_selling_code']; ?>
										</td>
										<td>
											<?php echo indonesia_date_format($item_selling_fetch_array['item_selling_date']); ?>
										</td>
										<td>
											<?php
										        $komisi = 0;
										        $order_item_selling = mysql_query("SELECT * FROM order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling_fetch_array['item_selling_id']."' AND a.order_item_selling_active = '1'");
										        while($data_order_item_selling = mysql_fetch_array($order_item_selling))
										        {
										            if($komisi == 0)
										            {
										                $komisi = $data_order_item_selling['order_item_selling_quantity']*$data_order_item_selling['item_commission_value'];
										            }
										            else
										            {
										                $komisi = $komisi+$data_order_item_selling['order_item_selling_quantity']*$data_order_item_selling['item_commission_value'];
										            }
										            
										            if($total_quantity == 0)
										            {
										                $total_quantity = $data_order_item_selling['order_item_selling_quantity'];
										            }
										            else
										            {
										                $total_quantity = $total_quantity+$data_order_item_selling['order_item_selling_quantity'];
										            }
										            
										            echo "(".$data_order_item_selling['order_item_selling_quantity'].') '.$data_order_item_selling['item_name'].' x '.currency_format($data_order_item_selling['item_commission_value']);
										            echo "<br>";
										        }
										    ?>
										</td>
										<td>
											<?php echo currency_format($komisi); ?>
										</td>
									</tr>
							<?php
							        if($total_komisi == 0)
							        {
							            $total_komisi = $komisi;
							        }
							        else
							        {
							            $total_komisi = $total_komisi+$komisi;
							        }
							
								$number++;
								}
							?>
									<tr>
										<td colspan="3" align="center">Reward</td>
										<td><?php echo $total_quantity; ?></td>
										<td>
											<?php
											    $total_reward = 0;
												$reward = mysql_fetch_array(mysql_query("SELECT * FROM reward WHERE reward_active = '1'"));
                                                if($total_quantity >= $reward['selling_quantity'])
                                                {
                                                    $total_reward = (round($total_quantity/$reward['selling_quantity']))* $reward['reward_value'];
                                                }
												
											?>
											<?php echo currency_format($total_reward) ?>
										</td>
										
									</tr>
									<tr>
										<td colspan="4" align="center">Total</td>
										<td><?php echo currency_format($total_reward + $total_komisi) ?></td>
										
									</tr>

							</tbody>
						</table>
						<br>
			<h5>Pembayaran</h5>
			<br>
			<table class="table table-striped table-bordered table-hover order-column" id="">
							<thead>
								<tr>
									<th>
										Tanggal Transfer
									</th>
									<th>
										Bank 
									</th>
									<th>
										No Rekening
									</th>
									<th>
										Atas Nama
									</th>
									<th>
										Jumlah
									</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$invoice_transfer = mysql_query("SELECT * FROM invoice_transfer a, bank b WHERE a.bank_id = b.bank_id AND a.invoice_id = '".$_GET['invoice_id']."'");
									while($data_invoice_transfer = mysql_fetch_array($invoice_transfer))
									{
								?>
										<tr>
											<td><?php echo indonesia_date_format($data_invoice_transfer['transfer_date']) ?></td>
											<td><?php echo $data_invoice_transfer['bank_name'] ?></td>
											<td><?php echo $data_invoice_transfer['account_number'] ?></td>
											<td><?php echo $data_invoice_transfer['account_name'] ?></td>
											<td><?php echo currency_format($data_invoice_transfer['transfer_value']) ?></td>
										</tr>
								<?php
									}
								?>
							</tbody>
						</table>
</body>
</html>