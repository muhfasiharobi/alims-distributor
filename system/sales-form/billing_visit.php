<?php
	function form_initial_billing_visit()
	{
		$tgl_pertama = date('Y-m-01', strtotime($tgl_sekarang));
		$tgl_terakhir = date('Y-m-t', strtotime($tgl_sekarang));
?>
		<div class="page-fixed-main-content">	 
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Kunjungan Penagihan
								</span>
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-bordered table-checkable table-hover table-striped order-column" id="sample_2">
								<thead>
									<tr>
										<th>
										</th>
										<th>
											No
										</th>
										<th>
											Faktur
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
											Status
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_billing_visit = mysql_query("SELECT * FROM billing_plan a, billing_plan_detail b, billing_visit c, billing_visit_detail d, sales_invoice e WHERE a.billing_plan_id = b.billing_plan_id AND c.billing_visit_id = d.billing_visit_id AND b.billing_plan_detail_id = c.billing_plan_detail_id AND b.sales_invoice_id = e.sales_invoice_id");
									while ($data_tbl_billing_visit = mysql_fetch_array($tbl_billing_visit))
									{
										$sales_plan_date_indo = tanggal_indo($data_tbl_sales_visit['sales_plan_date']);
										$tbl_customer = mysql_query("SELECT * FROM sales_invoice a, sales_order b, sales_request c, customer d, customer_districts e where a.sales_invoice_id = '".$data_tbl_billing_visit['sales_invoice_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.customer_id = d.customer_id AND d.customer_districts_id = e.customer_districts_id");
										$data_tbl_customer = mysql_fetch_array($tbl_customer);
								?>
									<tr class="odd gradeX">
										<td>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=billing-visit&tib=form-view-billing-visit&billing_visit_id=<?php echo $data_tbl_billing_visit['billing_visit_id'] ?>">
												<i class="fa fa-search"></i>
											</a>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=billing-visit&tib=form-edit-billing-visit&billing_visit_id=<?php echo $data_tbl_billing_visit['billing_visit_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
										</td>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_billing_visit['sales_invoice_no'] ?>
										</td>
										<td>
											<?php echo $data_tbl_customer['customer_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_customer['customer_address'] ?>
										</td>
										<td>
											<?php echo $data_tbl_customer['customer_districts_name'] ?>
										</td>
										<td>
										<?php
											if ($data_tbl_billing_visit['billing_visit_status'] == "Call")
											{
										?>
												<span class="label label-info label-sm">Call</span>
										<?php
											}
											elseif ($data_tbl_billing_visit['billing_visit_status'] == "Unpaid")
											{
										?>
												<span class="label label-danger label-sm">Unpaid</span><br />
												<?php echo $data_tbl_billing_visit['billing_visit_description'] ?>
										<?php
											}
											else
											{
										?>
												<span class="label label-success label-sm">Paid</span>
										<?php
											}
										?>
									</tr>
								<?php
									$no++;
									}
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	function form_view_billing_visit()
	{
		$tbl_payment_order = mysql_query("SELECT * FROM billing_visit a, billing_plan_detail b, sales_invoice c, sales_order d WHERE a.billing_visit_id = '".$_GET['billing_visit_id']."' AND a.billing_plan_detail_id = b.billing_plan_detail_id AND b.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id");
		$data_tbl_payment_order = mysql_fetch_array($tbl_payment_order);
		
		$tbl_customer = mysql_query("SELECT * FROM sales_request a, customer b, customer_districts c, customer_category d, user e WHERE a.sales_request_id = '".$data_tbl_payment_order['sales_request_id']."' AND a.customer_id = b.customer_id AND b.customer_districts_id = c.customer_districts_id AND b.customer_category_id = d.customer_category_id AND a.salesman_id = e.user_id");
		$data_tbl_customer = mysql_fetch_array($tbl_customer);
		
		$sales_request_date_indo = tanggal_indo($data_tbl_customer['sales_request_date']);
		$sales_invoice_date_indo = tanggal_indo($data_tbl_payment_order['sales_invoice_date']);
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_payment_order['sales_invoice_no'] ?>
					<small>
						<?php echo $sales_invoice_date_indo ?>
					</small>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_customer['user_name'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_customer['customer_category_name'] ?> - <?php echo $data_tbl_customer['customer_code'] ?> - <?php echo $data_tbl_customer['customer_name'] ?> (<?php echo $data_tbl_customer['customer_districts_name'] ?>)
						</a>
					</li>
				</ul>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Pesanan Pembayaran
								</span>
							</div>
							<div class="actions">
								<a class="btn btn-outline btn-sm sbold yellow" href="?alimms=billing-visit">
									<i class="fa fa-sign-out"></i>
									Keluar
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-bordered table-checkable table-hover table-striped order-column" id="sample_2">
								<thead>
									<tr>
										<th>
											Jumlah Total
										</th>
										<th>
											Jumlah terbayar
										</th>
										<th>
											Keterangan
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$tbl_sales_order_detail = mysql_query("SELECT SUM((sales_order_detail_product_sell_quantity * (sales_order_detail_product_sell_price - sales_order_detail_piece_discount - sales_order_detail_cash_discount)) + ((sales_order_detail_product_sell_quantity + sales_order_detail_program_bonus) * sales_order_detail_delivery_cost_price)) AS product_sell_total FROM sales_order_detail WHERE sales_order_id = '".$data_tbl_payment_order['sales_order_id']."'");
									$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
									
									$product_sell_total_indo = format_angka($data_tbl_sales_order_detail['product_sell_total']);
									
									$tbl_payment_order_detail = mysql_query("SELECT SUM(payment_order_detail_payment_nominal) AS payment_order_detail_payment_nominal FROM payment_order_detail WHERE payment_order_id = '".$data_tbl_payment_order['payment_order_id']."'");
									$data_tbl_payment_order_detail = mysql_fetch_array($tbl_payment_order_detail);
									
									$payment_order_detail_payment_nominal_indo = format_angka($data_tbl_payment_order_detail['payment_order_detail_payment_nominal']);
									
									$tbl_billing_visit_detail = mysql_query("SELECT * FROM billing_visit a, billing_visit_detail b WHERE a.billing_visit_id = b.billing_visit_id AND a.billing_visit_id = '".$_GET['billing_visit_id']."'");
									$data_tbl_billing_visit_detail = mysql_fetch_array($tbl_billing_visit_detail);
									
									$billing_visit_detail_nominal_indo = format_angka($data_tbl_billing_visit_detail['billing_visit_detail_nominal']);
								?>
									<tr class="odd gradeX">
										<td align="center">
											<?php echo $product_sell_total_indo ?>
										</td>
										<td align="center">
											<?php echo $billing_visit_detail_nominal_indo ?>
										</td>
										<td align="center">
											<?php echo $data_tbl_billing_visit_detail['billing_visit_detail_description'] ?>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	function form_edit_billing_visit()
	{
		$tbl_payment_order = mysql_query("SELECT * FROM billing_visit a, billing_plan_detail b, sales_invoice c, sales_order d WHERE a.billing_visit_id = '".$_GET['billing_visit_id']."' AND a.billing_plan_detail_id = b.billing_plan_detail_id AND b.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id");
		$data_tbl_payment_order = mysql_fetch_array($tbl_payment_order);
		
		$tbl_customer = mysql_query("SELECT * FROM sales_request a, customer b, customer_districts c, customer_category d, user e WHERE a.sales_request_id = '".$data_tbl_payment_order['sales_request_id']."' AND a.customer_id = b.customer_id AND b.customer_districts_id = c.customer_districts_id AND b.customer_category_id = d.customer_category_id AND a.salesman_id = e.user_id");
		$data_tbl_customer = mysql_fetch_array($tbl_customer);
		
		$sales_request_date_indo = tanggal_indo($data_tbl_customer['sales_request_date']);
		?>
	<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_customer['user_name'] ?>
					<small>
						<?php echo $sales_request_date_indo ?>
					</small>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_customer['customer_category_name'] ?> - <?php echo $data_tbl_customer['customer_code'] ?> - <?php echo $data_tbl_customer['customer_name'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_customer['customer_address'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_customer['customer_districts_name'] ?>
						</a>
					</li>
				</ul>
			</div>
		<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Pesanan Pembayaran
								</span>
							</div>
						</div>
						<div class="portlet-body">
							<div class="mt-element-step">
								<div class="row step-thin">
								<?php
									$tbl_sales_order_detail = mysql_query("SELECT SUM((sales_order_detail_product_sell_quantity * (sales_order_detail_product_sell_price - sales_order_detail_piece_discount - sales_order_detail_cash_discount)) + ((sales_order_detail_product_sell_quantity + sales_order_detail_program_bonus) * sales_order_detail_delivery_cost_price)) AS product_sell_total FROM sales_order_detail WHERE sales_order_id = '".$data_tbl_payment_order['sales_order_id']."'");
									$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
									
									$product_sell_total_indo = format_angka($data_tbl_sales_order_detail['product_sell_total']);
								?>
									<div class="col-md-4 bg-grey mt-step-col done">
										<div class="mt-step-number bg-white font-grey">Q</div>
										<div class="mt-step-title uppercase font-grey-cascade"><?php echo $product_sell_total_indo ?></div>
										<div class="mt-step-content font-grey-cascade">Jumlah Total</div>
									</div>
								<?php
									$tbl_payment_order_detail = mysql_query("SELECT SUM(payment_order_detail_payment_nominal) AS payment_order_detail_payment_nominal FROM payment_order_detail WHERE payment_order_id = '".$data_tbl_payment_order['payment_order_id']."'");
									$data_tbl_payment_order_detail = mysql_fetch_array($tbl_payment_order_detail);
									
									$payment_order_detail_payment_nominal_indo = format_angka($data_tbl_payment_order_detail['payment_order_detail_payment_nominal']);
								?>
									<div class="col-md-4 bg-grey mt-step-col active">
										<div class="mt-step-number bg-white font-grey">Q</div>
										<div class="mt-step-title uppercase font-grey-cascade"><?php echo $payment_order_detail_payment_nominal_indo ?></div>
										<div class="mt-step-content font-grey-cascade">Jumlah Terbayar</div>
									</div>
								<?php
									$remaining_payment_nominal = $data_tbl_sales_order_detail['product_sell_total'] - $data_tbl_payment_order_detail['payment_order_detail_payment_nominal'];
									$remaining_payment_nominal_rupiah_indo = format_angka($remaining_payment_nominal);
								?>
									<div class="col-md-4 bg-grey mt-step-col error">
										<div class="mt-step-number bg-white font-grey">Q</div>
										<div class="mt-step-title uppercase font-grey-cascade"><?php echo $remaining_payment_nominal_rupiah_indo ?></div>
										<div class="mt-step-content font-grey-cascade">Sisa Pembayaran</div>
									</div>
								</div>
							</div>
						</div>
						<div class="portlet-body form">
							<form action="?alimms=billing-visit&tib=edit-billing-visit" class="horizontal-form" id="form_sample_3" method="post">
							<?php
								$tbl_billing_visit_detail = mysql_query("SELECT * FROM billing_visit_detail WHERE billing_visit_id = '".$_GET['billing_visit_id']."'");
								$data_tbl_billing_visit_detail = mysql_fetch_array($tbl_billing_visit_detail);
							?>
							<input class="form-control" name="billing_visit_id" type="hidden" value="<?php echo $_GET['billing_visit_id'] ?>">
								<div class="form-body">
								
								<h4 class="form-section">
										Transaksi Pembayaran 
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Nominal
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="billing_visit_detail_payment_nominal" placeholder="Nominal" type="text" value="<?php echo $data_tbl_billing_visit_detail['billing_visit_detail_nominal'] ?>">
											</div>
										</div>
									</div>
									<h4 class="form-section">
										Status Pembayaran
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Status Pembayaran
													<span class="required">
														*
													</span>
												</label>
												<div class="radio-list" data-error-container="#payment_order_detail_payment_status">
												<?php 
													if($data_tbl_payment_order['billing_visit_status'] == 'Paid'){
												?>
													<label class="radio-inline">
														<input name="payment_order_detail_payment_status" type="radio" value="Paid" checked="checked">
															Paid
													</label>
													<label class="radio-inline">
														<input name="payment_order_detail_payment_status" type="radio" value="Unpaid">
															Unpaid
													</label>
												<?php } else { ?>
													<label class="radio-inline">
														<input name="payment_order_detail_payment_status" type="radio" value="Paid" >
															Paid
													</label>
													<label class="radio-inline">
														<input name="payment_order_detail_payment_status" type="radio" value="Unpaid" checked="checked">
															Unpaid
													</label>
												<?php } ?>
												</div>
												<div id="payment_order_detail_payment_status"></div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Keterangan
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="payment_order_detail_payment_description" placeholder="Keterangan" type="text" value="<?php echo $data_tbl_billing_visit_detail['billing_visit_detail_description'] ?>">
												<span class="help-block">
													*) Jika Status Paid, Keterangan Dikosongkan
												</span>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Ubah
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=billing-visit'">
										<i class="fa fa-times"></i>
										Batal
									</button>
								</div>
							</form>
						</div>
	</div>
<?php
	}
?>