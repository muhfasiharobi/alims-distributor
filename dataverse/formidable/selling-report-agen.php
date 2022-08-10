<?php
	function default_selling_report_agen()
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
						<form action="?connect=selling-report-agen&execute=form-report-selling-agen" class="horizontal-form" id="form_sample_3" method="post">
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
	function form_report_selling_agen()
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
						<form action="?connect=selling-report-agen&execute=form-report-selling-agen" class="horizontal-form" id="form_sample_3" method="post">
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
						<table class="table table-striped table-bordered table-hover order-column" id="sample_2">
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
										Barang
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
								$item_selling_query = mysql_query("SELECT a.item_selling_date, a.item_selling_id, a.reseller_code, a.reseller_name, a.customer_code, a.customer_name, a.item_selling_delivery_id FROM item_selling a, reseller b WHERE a.reseller_id = b.reseller_id AND b.user_id = '".$_SESSION['user_id']."' AND a.item_selling_date BETWEEN '".$selling_from_date."' AND '".$selling_to_date."' AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses'");
								while ($item_selling_fetch_array = mysql_fetch_array($item_selling_query))
								{
									
									$item_selling_delivery = mysql_fetch_array(mysql_query("SELECT * FROM item_selling_delivery WHERE item_selling_delivery_id = '".$item_selling_fetch_array['item_selling_delivery_id']."'"));
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
													<?php echo $item_selling_delivery['delivery_service_name'] ?>
												</td>
												<td>
													<?php echo currency_format($item_selling_delivery['delivery_cost']); ?>
												</td>
												<td>
													<?php echo currency_format($total+$item_selling_delivery['delivery_cost']); ?>
												</td>
											</tr>
											
									
							<?php
									$number++;
								}
							?>
							</tbody>
						</table>

					</div>
				</div>
			</div>
		</div>

<?php
	}
?>