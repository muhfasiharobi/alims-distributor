<?php
	function default_selling_report()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-basket font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Laporan Penjualan
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=selling-report&execute=form-report-selling" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Dari Tanggal
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="selling_from_date" placeholder="Tgl. Penjualan" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Sampai Tanggal
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="selling_to_date" placeholder="Tgl. Penjualan" type="text">
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions right">
								<button class="btn yellow btn-outline" type="submit">
									<i class="icon-action-redo"></i>
									Proses
								</button>
								&nbsp;
								<button class="btn red btn-outline" onclick="history.back()" type="button">
									<i class="icon-close"></i>
									Batal
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		
<?php
	}
	function form_report_selling()
	{
?>	
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-basket font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Laporan Penjualan
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=selling-report&execute=form-report-selling" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Dari Tanggal
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="selling_from_date" placeholder="Tgl. Penjualan" type="text" value="<?php echo $_POST['selling_from_date'] ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Sampai Tanggal
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="selling_to_date" placeholder="Tgl. Penjualan" type="text" value="<?php echo $_POST['selling_to_date'] ?>">
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions right">
								<button class="btn yellow btn-outline" type="submit">
									<i class="icon-action-redo"></i>
									Proses
								</button>
								&nbsp;
								<button class="btn red btn-outline" onclick="history.back()" type="button">
									<i class="icon-close"></i>
									Batal
								</button>
							</div>
						</form>
					</div>
					<br><br><br>

					<div class="portlet-body">
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
										Total Penjualan
									</th>
									<th>
										Pengiriman
									</th>
									<th>
										Biaya Kirim
									</th>
									<th>
										SubTotal
									</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$selling_from_date = explode("-", $_POST['selling_from_date']);
								$date = $selling_from_date[0];
								$month = $selling_from_date[1];
								$year = $selling_from_date[2];
								$selling_from_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
								
								$selling_to_date = explode("-", $_POST['selling_to_date']);
								$date = $selling_to_date[0];
								$month = $selling_to_date[1];
								$year = $selling_to_date[2];
								$selling_to_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
							
								$number = 1;
								$ongkir = 0;
								$subtotal = 0;
								$total_penjualan = 0;

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
													
													if($subtotal == 0)
                									{
                										$subtotal = ($total-($promo_prosentase['promo_prosentase']+$promo_nominal['promo_nominal']))+$item_selling_delivery['delivery_cost'];
                									}
                									else
                									{
                										$subtotal = ((($subtotal+$total)-($promo_prosentase['promo_prosentase']+$promo_nominal['promo_nominal']))+$item_selling_delivery['delivery_cost']);
                									}
                									
                									if($total_penjualan == 0)
                									{
                									    $total_penjualan = $total - ($promo_prosentase['promo_prosentase']+$promo_nominal['promo_nominal']);
                									}
                									else
                									{
                									    $total_penjualan = $total_penjualan+$total - ($promo_prosentase['promo_prosentase']+$promo_nominal['promo_nominal']);
                									}
												?>
												</td>
												<td>
													<?php echo currency_format($promo_prosentase['promo_prosentase']+$promo_nominal['promo_nominal']) ?>
												</td>
												<td>
													<?php echo currency_format($total-($promo_prosentase['promo_prosentase']+$promo_nominal['promo_nominal'])) ?>
												</td>
												<td>
													<?php echo $item_selling_delivery['delivery_service_name'] ?>
												</td>
												<td>
													<?php echo currency_format($item_selling_delivery['delivery_cost']); ?>
												</td>
												<td>
													<?php echo currency_format($total-($promo_prosentase['promo_prosentase']+$promo_nominal['promo_nominal'])+$item_selling_delivery['delivery_cost']); ?>
												</td>
											</tr>
											
									
							<?php
									
									$number++;
								}
							?>
											<tr>
												<td colspan="7" align="center">
													<b>Total</b>
												</td>
												<td><?php echo currency_format($total_penjualan) ?></td>
												<td></td>
												<td><?php echo currency_format($ongkir) ?></td>
												<td><?php echo currency_format($subtotal) ?></td>
											</tr>
							</tbody>
						</table>
					</div>
					<div class="portlet-body form">
							<div class="form-actions right">
								<a class="btn purple btn-outline" target="_BLANK" href="printable/selling-report.php?from=<?php echo $_POST['selling_from_date'] ?>&to=<?php echo $_POST['selling_to_date'] ?>">
									<i class="fa fa-print"></i>
										Cetak
								</a>
								<a class="btn purple btn-outline" target="_BLANK" href="export/selling-report.php?selling_from_date=<?php echo $_POST['selling_from_date'] ?>&selling_to_date=<?php echo $_POST['selling_to_date'] ?>">
									<i class="fa fa-file-excel-o"></i>
										Download Excel
								</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

<?php
	}
?>