<?php
	function default_customer_report()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-basket font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Laporan Pelanggan
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=customer-report" class="horizontal-form" id="form_sample_3" method="post">
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
					<br><br><br>
					<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover order-column" id="sample_2">
							<thead>
								<tr>
									<th>
										No
									</th>
									<th>
										Pelanggan
									</th>
									<th>
										Jumlah Pembelian (Repeat Order)
									</th>
									<th>
										Jumlah Barang
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

								if($_SESSION['user_category_name'] == "Administrator")
								{
									$item_selling_query = mysql_query("SELECT * FROM item_selling a, reseller b WHERE a.reseller_id = b.reseller_id AND a.item_selling_date BETWEEN '".$selling_from_date."' AND '".$selling_to_date."' AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses' GROUP BY a.reseller_id");
								}
								else
								{
									$item_selling_query = mysql_query("SELECT * FROM item_selling a, reseller b, user c WHERE a.reseller_id = b.reseller_id AND b.user_id = c.user_id AND c.item_category_id = '".$_SESSION['item_category_id']."' AND a.item_selling_date BETWEEN '".$selling_from_date."' AND '".$selling_to_date."' AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses' GROUP BY a.reseller_id");
								}
								


								while ($item_selling_fetch_array = mysql_fetch_array($item_selling_query))
								{
									$order_item_selling = mysql_query("SELECT * FROM item_selling WHERE item_selling_active = '1' AND item_selling_status = 'Sudah Diproses' AND reseller_id = '".$item_selling_fetch_array['reseller_id']."'");	
									$jml_order = mysql_num_rows($order_item_selling);		

									$order_item_selling_query = mysql_query("SELECT SUM(order_item_selling_quantity) as order_item_selling_quantity FROM item_selling a, order_item_selling b WHERE a.item_selling_id = b.item_selling_id AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses' AND b.order_item_selling_active = '1' AND a.reseller_id = '".$item_selling_fetch_array['reseller_id']."' AND a.item_selling_date BETWEEN '".$selling_from_date."' AND '".$selling_to_date."'");
									$order_item_selling_fetch_array = mysql_fetch_array($order_item_selling_query);						
							?>
																		
											<tr>
												<td>
													<?php echo $number; ?>
												</td>
												<td>
													<?php echo $item_selling_fetch_array['reseller_code']; ?> | <?php echo $item_selling_fetch_array['reseller_name']; ?>
												</td>
												<td>
													<?php echo $jml_order; ?>
												</td>
												<td>
													<?php echo $order_item_selling_fetch_array['order_item_selling_quantity'] ?>
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