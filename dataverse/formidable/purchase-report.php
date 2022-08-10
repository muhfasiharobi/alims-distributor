<?php
	function default_purchase_report()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-basket font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Laporan Pembelian
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=purchase-report&execute=form-report-purchase" class="horizontal-form" id="form_sample_3" method="post">
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
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="purchase_from_date" placeholder="Tgl. Pembelian" type="text">
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
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="purchase_to_date" placeholder="Tgl. Pembelian" type="text">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>
												Pemasok
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#supplier_id" data-placeholder="Supplier" name="supplier_id">
											<?php
												$supplier_query = mysql_query("SELECT * FROM supplier WHERE supplier_active = '1'");
												while ($supplier_fetch_array = mysql_fetch_array($supplier_query))
												{
											?>
													<option value=""></option>
													<option value="<?php echo $supplier_fetch_array['supplier_id']; ?>"><?php echo $supplier_fetch_array['supplier_name']; ?></option>
											<?php
												}
											?>
											</select>
											<div id="supplier_id"></div>
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
	function form_report_purchase()
	{
?>	
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-basket font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Laporan Pembelian
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=purchase-report&execute=form-report-purchase" class="horizontal-form" id="form_sample_3" method="post">
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
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="purchase_from_date" placeholder="Tgl. Pembelian" type="text" value="<?php echo $_POST['purchase_from_date'] ?>">
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
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="purchase_to_date" placeholder="Tgl. Pembelian" type="text" value="<?php echo $_POST['purchase_to_date'] ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>
												Pemasok
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#supplier_id" data-placeholder="Supplier" name="supplier_id">
											<?php
												$supplier_query = mysql_query("SELECT * FROM supplier WHERE supplier_active = '1'");
												while ($supplier_fetch_array = mysql_fetch_array($supplier_query))
												{
											?>
													<option value=""></option>
													<option value="<?php echo $supplier_fetch_array['supplier_id']; ?>"><?php echo $supplier_fetch_array['supplier_name']; ?></option>
											<?php
												}
											?>
											</select>
											<div id="supplier_id"></div>
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
										Barang
									</th>
									<th>
										Jumlah
									</th>
									<th>
										Harga
									</th>
									<th>
										Total
									</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$purchase_from_date = explode("-", $_POST['purchase_from_date']);
								$date = $purchase_from_date[0];
								$month = $purchase_from_date[1];
								$year = $purchase_from_date[2];
								$purchase_from_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
								
								$purchase_to_date = explode("-", $_POST['purchase_to_date']);
								$date = $purchase_to_date[0];
								$month = $purchase_to_date[1];
								$year = $purchase_to_date[2];
								$purchase_to_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
							
								$number = 1;
								$order_purchase_query = mysql_query("SELECT * FROM item_purchase a, order_item_purchase b, item c WHERE a.supplier_id = '".$_POST['supplier_id']."' AND a.item_purchase_id = b.item_purchase_id AND b.item_id = c.item_id AND a.item_purchase_date BETWEEN '".$purchase_from_date."' AND '".$purchase_to_date."'");
								while ($order_purchase_fetch_array = mysql_fetch_array($order_purchase_query))
								{
									
							?>
									
									
											<tr>
												<td>
													<?php echo $number; ?>
												</td>
												<td>
													<?php echo indonesia_date_format($order_purchase_fetch_array['item_purchase_date']); ?>
												</td>
												<td>
													<?php echo $order_purchase_fetch_array['item_name']; ?>
												</td>
												<td>
													<?php echo $order_purchase_fetch_array['order_item_purchase_quantity']; ?>
												</td>
												<td>
													<?php echo currency_format($order_purchase_fetch_array['order_item_purchase_price']); ?>
												</td>
												<td>
													<?php echo currency_format($order_purchase_fetch_array['order_item_purchase_quantity'] * $order_purchase_fetch_array['order_item_purchase_price']); ?>
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