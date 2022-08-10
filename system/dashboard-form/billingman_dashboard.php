<?php
	function form_initial_billing_dashboard()
	{
		$tgl_sekarang = date("Y-m-d");
		$blnthn_sekarang = date("Y-m");
		$tgl_sekarang_awal = date('Y-m-01', strtotime($tgl_sekarang));
		$tgl_sekarang_akhir = date('Y-m-t', strtotime($tgl_sekarang));
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="profile-sidebar">
						<div class="bordered light portlet">
							<div class="list-separated profile-stat row">
							<?php
								$tbl_billing_plan = mysql_query("SELECT COUNT(b.sales_invoice_id) AS invoice_sub_total FROM billing_plan a, billing_plan_detail b WHERE a.billing_plan_active = '1' AND a.salesman_id = '".$_SESSION['user_id']."' AND a.billing_plan_date = '".$tgl_sekarang."' AND a.billing_plan_id = b.billing_plan_id");
								$data_tbl_billing_plan = mysql_fetch_array($tbl_billing_plan);
							?>
								<div class="col-md-4">
									<div class="uppercase profile-stat-title">
										<?php echo $data_tbl_billing_plan['invoice_sub_total'] ?>
									</div>
									<div class="uppercase profile-stat-text">
										Plan
									</div>
								</div>
							<?php
								$tbl_billing_visit_successful = mysql_query("SELECT COUNT(c.sales_invoice_id) AS invoice_sub_total FROM billing_visit a, billing_plan b, billing_plan_detail c WHERE b.billing_plan_active = '1' AND NOT a.billing_visit_time_in = '0000-00-00 00:00:00' AND b.salesman_id = '".$_SESSION['user_id']."' AND b.billing_plan_date = '".$tgl_sekarang."' AND a.billing_plan_detail_id = c.billing_plan_detail_id AND b.billing_plan_id = c.billing_plan_id");
								$data_tbl_billing_visit_successful = mysql_fetch_array($tbl_billing_visit_successful);
							?>
								<div class="col-md-4">
									<div class="uppercase profile-stat-title">
										<?php echo $data_tbl_billing_visit_successful['invoice_sub_total'] ?>
									</div>
									<div class="uppercase profile-stat-text">
										Actual
									</div>
								</div>
							<?php
								$tbl_sales_visit_unsuccessful = mysql_query("SELECT COUNT(c.customer_id) AS customer_sub_total FROM sales_visit a, sales_plan b, sales_plan_detail c WHERE b.sales_plan_active = '1' AND a.sales_visit_time_in = '0000-00-00 00:00:00' AND b.salesman_id = '".$_SESSION['user_id']."' AND b.sales_plan_date = '".$tgl_sekarang."' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id");
								$data_tbl_sales_visit_unsuccessful = mysql_fetch_array($tbl_sales_visit_unsuccessful);
							?>
								<div class="col-md-4">
									<div class="uppercase profile-stat-title">
										<?php echo $data_tbl_sales_visit_unsuccessful['customer_sub_total'] ?>
									</div>
									<div class="uppercase profile-stat-text">
										Lost
									</div>
								</div>
							</div>
							<div class="list-separated profile-stat row">
							<?php
								$tbl_billing_visit_paid = mysql_query("SELECT COUNT(c.sales_invoice_id) AS invoice_sub_total FROM billing_visit a, billing_plan b, billing_plan_detail c WHERE b.billing_plan_active = '1' AND a.billing_visit_status = 'Paid' AND b.salesman_id = '".$_SESSION['user_id']."' AND b.billing_plan_date = '".$tgl_sekarang."' AND a.billing_plan_detail_id = c.billing_plan_detail_id AND b.billing_plan_id = c.billing_plan_id");
								$data_tbl_billing_visit_paid = mysql_fetch_array($tbl_billing_visit_paid);
							?>
								<div class="col-md-6">
									<div class="uppercase profile-stat-title">
									<a href="?alimms=dashboard&tib=form-view-sales-visit-order">
										<?php echo $data_tbl_billing_visit_paid['invoice_sub_total'] ?>
									</a>
									</div>
									<div class="uppercase profile-stat-text">
										<a href="?alimms=dashboard&tib=form-view-sales-visit-order">
										Paid
										</a>
									</div>
								</div>
							<?php
								$tbl_billing_visit_unpaid = mysql_query("SELECT COUNT(c.sales_invoice_id) AS invoice_sub_total FROM billing_visit a, billing_plan b, billing_plan_detail c WHERE b.billing_plan_active = '1' AND a.billing_visit_status = 'Unpaid' AND b.salesman_id = '".$_SESSION['user_id']."' AND b.billing_plan_date = '".$tgl_sekarang."' AND a.billing_plan_detail_id = c.billing_plan_detail_id AND b.billing_plan_id = c.billing_plan_id");
								$data_tbl_billing_visit_unpaid = mysql_fetch_array($tbl_billing_visit_unpaid);
							?>
								<div class="col-md-6">
									<div class="uppercase profile-stat-title">
									<a href="?alimms=dashboard&tib=form-view-sales-visit-not-order">
										<?php echo $data_tbl_billing_visit_unpaid['invoice_sub_total'] ?>
									</a>
									</div>
									<div class="uppercase profile-stat-text">
									<a href="?alimms=dashboard&tib=form-view-sales-visit-not-order">
										Unpaid
									</a>
									</div>
								</div>
							</div>
							<div>
								<h4 class="profile-desc-title">
									Billing Plan <?php echo tanggal_sekarangindo() ?>
								</h4>
								<span class="profile-desc-text">
									Rencana Penagihan <?php echo $_SESSION['user_name'] ?> Tanggal <?php echo tanggal_sekarangindo() ?>
								</span>
							</div>  
						</div>
					</div>
					<div class="profile-content">
						<div class="row">
							<div class="col-md-12">
								<div class="bordered light portlet">
									<div class="portlet-title">
										<div class="caption">
											<span class="caption-subject font-blue sbold uppercase">
												Billing Visit Activity
											</span>
											<span class="caption-helper sbold uppercase">
												Periode <?php echo bulan_tahunsekarangindo() ?>
											</span>
										</div>
									</div>
									<div class="portlet-body">
										<div class="row number-stats margin-bottom-30">
											<div class="col-md-6 col-sm-6 col-xs-6">
												<div class="stat-left">
													<div class="stat-chart">
														<!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
														<div class="number" id="sparkline_bar5"></div>
													</div>
													<?php
														$tbl_sales_order_detail = mysql_query("SELECT a.billing_plan_id, SUM((d.sales_order_detail_product_sell_quantity * (d.sales_order_detail_product_sell_price - d.sales_order_detail_piece_discount - d.sales_order_detail_cash_discount)) + ((d.sales_order_detail_product_sell_quantity + d.sales_order_detail_program_bonus) * d.sales_order_detail_delivery_cost_price)) AS product_sell_total FROM billing_plan a, billing_plan_detail b, sales_invoice c, sales_order_detail d WHERE a.billing_plan_active = '1' AND a.salesman_id = '".$_SESSION['user_id']."' AND a.billing_plan_date = '".$tgl_sekarang."' AND c.sales_invoice_status = 'Posted' AND a.billing_plan_id = b.billing_plan_id AND b.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id");
														$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
				
														$tbl_payment_order_detail = mysql_query("SELECT SUM(c.payment_order_detail_payment_nominal) AS payment_order_detail_payment_nominal FROM billing_plan_detail a, payment_order b, payment_order_detail c WHERE a.billing_plan_id = '".$data_tbl_sales_order_detail['billing_plan_id']."' AND a.sales_invoice_id = b.sales_invoice_id AND b.payment_order_id = c.payment_order_id");
														$data_tbl_payment_order_detail = mysql_fetch_array($tbl_payment_order_detail);
														
														$remaining_payment_nominal = $data_tbl_sales_order_detail['product_sell_total'] - $data_tbl_payment_order_detail['payment_order_detail_payment_nominal'];
														$remaining_payment_nominal_rupiah_indo = format_angka($remaining_payment_nominal);
													?>
													<div class="stat-number">
														<div class="title">
															Target
														</div>
														<div class="number">
															<?php echo $remaining_payment_nominal_rupiah_indo ?>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-6">
												<div class="stat-right">
													<div class="stat-chart">
														<!-- do not line break "sparkline_bar" div. sparkline chart has an issue when the container div has line break -->
														<div id="sparkline_bar2"></div>
													</div>
													<?php
														$tbl_billing_visit_on_day = mysql_query("SELECT SUM(d.billing_visit_detail_nominal) AS billing_visit_on_day FROM billing_plan a, billing_plan_detail b, billing_visit c, billing_visit_detail d WHERE a.billing_plan_active = '1' AND a.billing_plan_id = b.billing_plan_id AND b.billing_plan_detail_id = c.billing_plan_detail_id AND c.billing_visit_id = d.billing_visit_id AND a.salesman_id = '".$_SESSION['user_id']."'");
														$data_tbl_billing_visit_on_day = mysql_fetch_array($tbl_billing_visit_on_day);
														
														$data_tbl_billing_visit_on_day_indo = format_angka($data_tbl_billing_visit_on_day['billing_visit_on_day']);
													?>
													<div class="stat-number">
														<div class="title">
															Actual
														</div>
														<div class="number">
															<?php echo $data_tbl_billing_visit_on_day_indo ?>
														</div>
													</div>
												</div>
											</div>
									  </div>
									  <div class="table-scrollable table-scrollable-borderless">
										 <table class="table table-hover table-light">
												<thead>
													<tr class="uppercase">
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
												<?php
													$no = 1;
													$tbl_billing_visit = mysql_query("SELECT a.billing_visit_id, a.billing_visit_status, a.billing_visit_description, b.billing_plan_date, d.sales_invoice_no, d.sales_invoice_date, g.customer_code, g.customer_name, g.customer_address, h.customer_category_name, i.customer_districts_name FROM billing_visit a, billing_plan b, billing_plan_detail c, sales_invoice d, sales_order e, sales_request f, customer g, customer_category h, customer_districts i WHERE b.billing_plan_active = '1' AND f.sales_request_active = '1' AND g.customer_active = '1' AND h.customer_category_active = '1' AND i.customer_districts_active = '1' AND b.salesman_id = '".$_SESSION['user_id']."' AND b.billing_plan_date = '".$tgl_sekarang."' AND d.sales_invoice_status = 'Posted' AND a.billing_plan_detail_id = c.billing_plan_detail_id AND b.billing_plan_id = c.billing_plan_id AND c.sales_invoice_id = d.sales_invoice_id AND d.sales_order_id = e.sales_order_id AND e.sales_request_id = f.sales_request_id AND f.customer_id = g.customer_id AND g.customer_category_id = h.customer_category_id AND g.customer_districts_id = i.customer_districts_id ORDER BY c.billing_plan_detail_id");
													while ($data_tbl_billing_visit = mysql_fetch_array($tbl_billing_visit))
													{
														$sales_invoice_date_indo = tanggal_indo($data_tbl_billing_visit['sales_invoice_date']);
												?>
													<tr>
														<td>
														<?php
															if ($data_tbl_billing_visit['billing_plan_date'] == $tgl_sekarang)
															{
																if ($data_tbl_billing_visit['billing_visit_status'] == "Paid" || $data_tbl_billing_visit['billing_visit_status'] == "Unpaid")
																{
														?>
																<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=dashboard&tib=form-view-billingman-visit-dashboard&billing_visit_id=<?php echo $data_tbl_billing_visit['billing_visit_id'] ?>">
																	<i class="fa fa-search"></i>
																</a>
														<?php
																}
																else
																{
														?>
																<a class="btn btn-icon-only btn-outline purple tooltips" data-original-title="Proses" data-toggle="modal" href="#add_billing_visit_id_<?php echo $data_tbl_billing_visit['billing_visit_id'] ?>">
																	<i class="fa fa-map"></i>
																</a>
														<?php
																}
															}
														?>
														</td>
														<td>
															<?php echo $no ?>
														</td>
														<td>
															<?php echo $data_tbl_billing_visit['sales_invoice_no'] ?><br />
															<?php echo $sales_invoice_date_indo ?>
														</td>
														<td>
															<?php echo $data_tbl_billing_visit['customer_category_name'] ?> - <?php echo $data_tbl_billing_visit['customer_code'] ?> - <?php echo $data_tbl_billing_visit['customer_name'] ?>
														</td>
														<td>
															<?php echo $data_tbl_billing_visit['customer_address'] ?>
														</td>
														<td>
															<?php echo $data_tbl_billing_visit['customer_districts_name'] ?>
														</td>
														<td>
														<?php
															if ($data_tbl_billing_visit['billing_visit_status'] == "Call")
															{
														?>
																<span class="label label-info label-sm">Call</span>
														<?php
															}
															elseif ($data_tbl_billing_visit['billing_visit_status'] == "Paid")
															{
														?>
																<span class="label label-success label-sm">Paid</span>
														<?php
															}
															else
															{
														?>
																<span class="label label-danger label-sm">Unpaid</span><br />
																<?php echo $data_tbl_billing_visit['billing_visit_description'] ?>
														<?php
															}
														?>
														</td>
													</tr>
													<div aria-hidden="true" class="modal fade" id="add_billing_visit_id_<?php echo $data_tbl_billing_visit['billing_visit_id'] ?>" role="basic" tabindex="-1">
														<div class="modal-dialog">
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																	<h4 class="modal-title">
																		Konfirmasi
																	</h4>
																</div>
																<div class="modal-body">
																	Apakah Anda Yakin Ingin Memproses Data Ini ?
																</div>
																<div class="modal-footer">
																	<a class="btn btn-outline btn-sm green sbold" href="?alimms=dashboard&tib=form-add-billingman-visit-dashboard&billing_visit_id=<?php echo $data_tbl_billing_visit['billing_visit_id'] ?>">
																		<i class="fa fa-check"></i>
																		Ya
																	</a>
																	<a class="btn btn-outline btn-sm red sbold" data-dismiss="modal">
																		<i class="fa fa-times"></i>
																		Batal
																	</a>
																</div>
															</div>
														</div>
													</div>
												<?php
													$no++;
													}
												?>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	function form_add_billingman_visit_dashboard()
	{
		$tbl_payment_order = mysql_query("SELECT * FROM billing_visit a, billing_plan_detail b, sales_invoice c, sales_order d WHERE a.billing_visit_id = '".$_GET['billing_visit_id']."' AND a.billing_plan_detail_id = b.billing_plan_detail_id AND b.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id");
		$data_tbl_payment_order = mysql_fetch_array($tbl_payment_order);
		
		$tbl_customer = mysql_query("SELECT * FROM sales_request a, customer b, customer_districts c, customer_category d, user e WHERE a.sales_request_id = '".$data_tbl_payment_order['sales_request_id']."' AND a.customer_id = b.customer_id AND b.customer_districts_id = c.customer_districts_id AND b.customer_category_id = d.customer_category_id AND a.salesman_id = e.user_id");
		$data_tbl_customer = mysql_fetch_array($tbl_customer);
		
		$tbl_payment_request = mysql_query("SELECT * FROM payment_request WHERE sales_invoice_id = '".$data_tbl_payment_order['sales_invoice_id']."'");
		$data_tbl_payment_request = mysql_fetch_array($tbl_payment_request);
		
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
									$tbl_payment_request_detail = mysql_query("SELECT SUM(payment_request_detail_payment_nominal) AS payment_request_detail_payment_nominal FROM payment_request_detail WHERE payment_request_id = '".$data_tbl_payment_request['payment_request_id']."'");
									$data_tbl_payment_request_detail = mysql_fetch_array($tbl_payment_request_detail);
									
									$payment_request_detail_payment_nominal_indo = format_angka($data_tbl_payment_request_detail['payment_request_detail_payment_nominal']);
								?>
									<div class="col-md-4 bg-grey mt-step-col active">
										<div class="mt-step-number bg-white font-grey">Q</div>
										<div class="mt-step-title uppercase font-grey-cascade"><?php echo $payment_request_detail_payment_nominal_indo ?></div>
										<div class="mt-step-content font-grey-cascade">Jumlah Terbayar</div>
									</div>
								<?php
									$remaining_payment_nominal = $data_tbl_sales_order_detail['product_sell_total'] - $data_tbl_payment_request_detail['payment_request_detail_payment_nominal'];
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
							<form action="?alimms=dashboard&tib=add-billingman-visit-payment" class="horizontal-form" id="form_sample_3" method="post">
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
												<input class="form-control" name="billing_visit_detail_payment_nominal" placeholder="Nominal" type="text">
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
													<label class="radio-inline">
														<input name="payment_order_detail_payment_status" type="radio" value="Paid">
															Paid
													</label>
													<label class="radio-inline">
														<input name="payment_order_detail_payment_status" type="radio" value="Unpaid">
															Unpaid
													</label>
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
												<input class="form-control" name="payment_order_detail_payment_description" placeholder="Keterangan" type="text">
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
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=dashboard'">
										<i class="fa fa-times"></i>
										Batal
									</button>
								</div>
							</form>
						</div>
	</div>
<?php
	}
	function form_view_billingman_visit_dashboard()
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
								<a class="btn btn-outline btn-sm sbold yellow" href="?alimms=dashboard">
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
											<?php echo $data_tbl_billing_visit_detail['billing_visit_description'] ?>
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
?>