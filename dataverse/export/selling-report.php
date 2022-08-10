<?php
// Skrip berikut ini adalah skrip yang bertugas untuk meng-export data tadi ke excell
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=nama_filenya.xls");
include("../../config/connection.php");
include("../../library/datetime.php");
include("../../library/currency.php");
session_start();
?>

<table>
	<tr>
		<td>Laporan Penjualan</td>
	</tr>
	<tr>
		<td>Tanggal <?php echo indonesia_date_format($_GET['selling_from_date']) ?> Sampai <?php echo indonesia_date_format($_GET['selling_to_date']) ?></td>
	</tr>
</table>
<table border="1">
  <tr>
    <th>No</th>
    <th>Tanggal</th>
    <th>Agen</th>
    <th>Pelanggan</th>
    <th>Via</th>
    <th>Barang</th>
    <th>Diskon</th>
    <th>Pengiriman</th>
    <th>Biaya Kirim</th>
    <th>Total</th>
  </tr>
  <?php
								$selling_from_date = explode("-", $_GET['selling_from_date']);
								$date = $selling_from_date[0];
								$month = $selling_from_date[1];
								$year = $selling_from_date[2];
								$selling_from_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
								
								$selling_to_date = explode("-", $_GET['selling_to_date']);
								$date = $selling_to_date[0];
								$month = $selling_to_date[1];
								$year = $selling_to_date[2];
								$selling_to_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
							
								$number = 1;
								$ongkir = 0;
								$subtotal = 0;
								$item_selling_query = mysql_query("SELECT * FROM item_selling WHERE item_selling_date BETWEEN '".$selling_from_date."' AND '".$selling_to_date."' AND item_selling_active = '1' AND item_selling_status = 'Sudah Diproses'");
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
													<?php echo $promo_prosentase['promo_prosentase']+$promo_nominal['promo_nominal'] ?>
												</td>
												<td>
													<?php echo $item_selling_delivery['delivery_service_name'] ?>
												</td>
												<td>
													<?php echo $item_selling_delivery['delivery_cost']; ?>
												</td>
												<td>
													<?php echo ($total-($promo_prosentase['promo_prosentase']+$promo_nominal['promo_nominal']))+$item_selling_delivery['delivery_cost']; ?>
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
												<td><?php echo $ongkir ?></td>
												<td><?php echo $subtotal ?></td>
											</tr>

  
</table>