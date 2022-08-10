<?php
	function form_initial_visit_dashboard()
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
								$tbl_sales_plan = mysql_query("SELECT COUNT(b.customer_id) AS customer_sub_total FROM sales_plan a, sales_plan_detail b WHERE a.sales_plan_active = '1' AND a.salesman_id = '".$_SESSION['user_id']."' AND a.sales_plan_date = '".$tgl_sekarang."' AND a.sales_plan_id = b.sales_plan_id");
								$data_tbl_sales_plan = mysql_fetch_array($tbl_sales_plan);
							?>
								<div class="col-md-4">
									<div class="uppercase profile-stat-title">
										<?php echo $data_tbl_sales_plan['customer_sub_total'] ?>
									</div>
									<div class="uppercase profile-stat-text">
										Plan
									</div>
								</div>
							<?php
								$tbl_sales_visit_successful = mysql_query("SELECT COUNT(c.customer_id) AS customer_sub_total FROM sales_visit a, sales_plan b, sales_plan_detail c WHERE b.sales_plan_active = '1' AND NOT a.sales_visit_time_in = '0000-00-00 00:00:00' AND b.salesman_id = '".$_SESSION['user_id']."' AND b.sales_plan_date = '".$tgl_sekarang."' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id");
								$data_tbl_sales_visit_successful = mysql_fetch_array($tbl_sales_visit_successful);
							?>
								<div class="col-md-4">
									<div class="uppercase profile-stat-title">
										<?php echo $data_tbl_sales_visit_successful['customer_sub_total'] ?>
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
								$tbl_sales_visit_order = mysql_query("SELECT COUNT(c.customer_id) AS customer_sub_total FROM sales_visit a, sales_plan b, sales_plan_detail c WHERE b.sales_plan_active = '1' AND a.sales_visit_status = 'Order' AND b.salesman_id = '".$_SESSION['user_id']."' AND b.sales_plan_date = '".$tgl_sekarang."' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id");
								$data_tbl_sales_visit_order = mysql_fetch_array($tbl_sales_visit_order);
							?>
								<div class="col-md-6">
									<div class="uppercase profile-stat-title">
									<a href="?alimms=dashboard&tib=form-view-sales-visit-order">
										<?php echo $data_tbl_sales_visit_order['customer_sub_total'] ?>
									</a>
									</div>
									<div class="uppercase profile-stat-text">
										<a href="?alimms=dashboard&tib=form-view-sales-visit-order">
										Order
										</a>
									</div>
								</div>
							<?php
								$tbl_sales_visit_not_order = mysql_query("SELECT COUNT(c.customer_id) AS customer_sub_total FROM sales_visit a, sales_plan b, sales_plan_detail c WHERE b.sales_plan_active = '1' AND a.sales_visit_status = 'Not Order' AND b.salesman_id = '".$_SESSION['user_id']."' AND b.sales_plan_date = '".$tgl_sekarang."' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id");
								$data_tbl_sales_visit_not_order = mysql_fetch_array($tbl_sales_visit_not_order);
							?>
								<div class="col-md-6">
									<div class="uppercase profile-stat-title">
									<a href="?alimms=dashboard&tib=form-view-sales-visit-not-order">
										<?php echo $data_tbl_sales_visit_not_order['customer_sub_total'] ?>
									</a>
									</div>
									<div class="uppercase profile-stat-text">
									<a href="?alimms=dashboard&tib=form-view-sales-visit-not-order">
										Not Order
									</a>
									</div>
								</div>
							</div>
							<div>
								<h4 class="profile-desc-title">
									Sales Plan <?php echo tanggal_sekarangindo() ?>
								</h4>
								<span class="profile-desc-text">
									Rencana Penjualan Salesman <?php echo $_SESSION['user_name'] ?> Tanggal <?php echo tanggal_sekarangindo() ?>
								</span>
							</div>  
						</div>
					</div>
					<div class="profile-content">
						<div class="row">
							<div class="col-md-6">
								<div class="bordered light portlet">
									<div class="portlet-title">
										<div class="caption">
											<span class="caption-subject font-blue sbold uppercase">
												Sales Visit Activity
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
														<div id="sparkline_bar"></div>
													</div>
													<?php
														$tbl_sales_target = mysql_query("SELECT SUM(b.sales_target_detail_product_sell_quantity * d.product_sell_price_detail_product_sell_price) AS sales_target_sub_total FROM sales_target a, sales_target_detail b, product_sell_price c, product_sell_price_detail d WHERE a.sales_target_active = '1' AND c.product_sell_price_active = '1' AND a.salesman_id = '".$_SESSION['user_id']."' AND a.sales_target_period = '".$blnthn_sekarang."' AND c.product_sell_price_name = 'HJ Retail' AND a.sales_target_id = b.sales_target_id AND c.product_sell_price_id = d.product_sell_price_id AND b.product_sell_id = d.product_sell_id");
														$data_tbl_sales_target = mysql_fetch_array($tbl_sales_target);
				
														$sales_target_sub_total_indo = format_angka($data_tbl_sales_target['sales_target_sub_total']);
													?>
													<div class="stat-number">
														<div class="title">
															Target
														</div>
														<div class="number">
															<?php echo $sales_target_sub_total_indo ?>
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
														$tbl_sales_invoice = mysql_query("SELECT SUM((c.sales_order_detail_product_sell_quantity * (c.sales_order_detail_product_sell_price - c.sales_order_detail_piece_discount - c.sales_order_detail_cash_discount)) + ((c.sales_order_detail_product_sell_quantity + c.sales_order_detail_program_bonus) * c.sales_order_detail_delivery_cost_price)) AS product_sell_total FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE a.sales_invoice_status = 'Posted' AND d.sales_request_active = '1' AND a.sales_invoice_date BETWEEN '".$tgl_sekarang_awal."' AND '".$tgl_sekarang_akhir."' AND d.salesman_id = '".$_SESSION['user_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
														$data_tbl_sales_invoice = mysql_fetch_array($tbl_sales_invoice);
														
														$product_sell_total_indo = format_angka($data_tbl_sales_invoice['product_sell_total']);
													?>
													<div class="stat-number">
														<div class="title">
															Actual
														</div>
														<div class="number">
															<?php echo $product_sell_total_indo ?>
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
													$tbl_sales_visit = mysql_query("SELECT a.sales_visit_id, a.sales_visit_status, a.sales_visit_description, b.sales_plan_date, d.customer_code, d.customer_name, d.customer_address, e.customer_category_name, f.customer_districts_name FROM sales_visit a, sales_plan b, sales_plan_detail c, customer d, customer_category e, customer_districts f WHERE a.sales_visit_status = 'Call' AND b.sales_plan_active = '1' AND d.customer_active = '1' AND e.customer_category_active = '1' AND  f.customer_districts_active = '1' AND b.sales_plan_date = '".$tgl_sekarang."' AND b.salesman_id = '".$_SESSION['user_id']."' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id AND c.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id ORDER BY c.sales_plan_detail_id");
													while ($data_tbl_sales_visit = mysql_fetch_array($tbl_sales_visit))
													{
												?>
													<tr>
														<td>
														<?php
															if ($data_tbl_sales_visit['sales_plan_date'] == $tgl_sekarang)
															{
																if ($data_tbl_sales_visit['sales_visit_status'] == "Not Order" || $data_tbl_sales_visit['sales_visit_status'] == "Order")
																{
														?>
																<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=dashboard&tib=form-view-sales-visit-dashboard&sales_visit_id=<?php echo $data_tbl_sales_visit['sales_visit_id'] ?>">
																	<i class="fa fa-search"></i>
																</a>
														<?php
																}
																else
																{
														?>
																<a class="btn btn-icon-only btn-outline purple tooltips" data-original-title="Proses" data-toggle="modal" href="#add_sales_visit_id_<?php echo $data_tbl_sales_visit['sales_visit_id'] ?>">
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
															<?php echo $data_tbl_sales_visit['customer_category_name'] ?> - <?php echo $data_tbl_sales_visit['customer_code'] ?> - <?php echo $data_tbl_sales_visit['customer_name'] ?>
														</td>
														<td>
															<?php echo $data_tbl_sales_visit['customer_address'] ?>
														</td>
														<td>
															<?php echo $data_tbl_sales_visit['customer_districts_name'] ?>
														</td>
														<td>
														<?php
															if ($data_tbl_sales_visit['sales_visit_status'] == "Call")
															{
														?>
																<span class="label label-info label-sm">Call</span>
														<?php
															}
															elseif ($data_tbl_sales_visit['sales_visit_status'] == "Not Order")
															{
														?>
																<span class="label label-danger label-sm">Not Order</span><br />
																<?php echo $data_tbl_sales_visit['sales_visit_description'] ?>
														<?php
															}
															else
															{
														?>
																<span class="label label-success label-sm">Order</span>
														<?php
															}
														?>
														</td>
													</tr>
													<div aria-hidden="true" class="modal fade" id="add_sales_visit_id_<?php echo $data_tbl_sales_visit['sales_visit_id'] ?>" role="basic" tabindex="-1">
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
																	<a class="btn btn-outline btn-sm green sbold" href="?alimms=dashboard&tib=form-add-sales-visit-dashboard&sales_visit_id=<?php echo $data_tbl_sales_visit['sales_visit_id'] ?>">
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
							<div class="col-md-6">
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
																<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=dashboard&tib=form-view-billing-visit-dashboard&billing_visit_id=<?php echo $data_tbl_billing_visit['billing_visit_id'] ?>">
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
																	<a class="btn btn-outline btn-sm green sbold" href="?alimms=dashboard&tib=form-add-billing-visit-dashboard&billing_visit_id=<?php echo $data_tbl_billing_visit['billing_visit_id'] ?>">
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
	function form_add_sales_visit_dashboard()
	{
		$tbl_sales_visit = mysql_query("SELECT a.sales_visit_id, b.sales_plan_date, d.customer_id, d.customer_code, d.customer_name, d.customer_address, e.customer_category_name, f.customer_districts_name, g.user_name FROM sales_visit a, sales_plan b, sales_plan_detail c, customer d, customer_category e, customer_districts f, user g WHERE b.sales_plan_active = '1' AND d.customer_active = '1' AND e.customer_category_active = '1' AND f.customer_districts_active = '1' AND g.user_active = '1' AND a.sales_visit_id = '".$_GET['sales_visit_id']."' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id AND b.salesman_id = g.user_id AND c.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id");
		$data_tbl_sales_visit = mysql_fetch_array($tbl_sales_visit);
		
		$sales_plan_date_indo = tanggal_indo($data_tbl_sales_visit['sales_plan_date']);
		
		$tgl_sekarang = date('Y-m-d');
		$blnthn_sekarang = date('Y-m');
		$thn_sekarang = date('Y');
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_sales_visit['user_name'] ?>
					<small>
						<?php echo $sales_plan_date_indo ?>
					</small>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_visit['customer_category_name'] ?> - <?php echo $data_tbl_sales_visit['customer_code'] ?> - <?php echo $data_tbl_sales_visit['customer_name'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_visit['customer_address'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_visit['customer_districts_name'] ?>
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
									Kunjungan Penjualan
								</span>
							</div>
						</div>
						<div class="portlet-body form">
							<form action="?alimms=dashboard&tib=add-sales-visit-dashboard" class="horizontal-form" enctype="multipart/form-data" id="form_sample_3" method="post">
							<input class="form-control" name="sales_visit_id" type="hidden" value="<?php echo $data_tbl_sales_visit['sales_visit_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Stok Produk
									</h4>
									<div class="row">
									<?php
										$last_visit_date = mysql_query("SELECT max(a.sales_plan_date) as last_visit, max(c.sales_visit_id) as sales_visit_id FROM sales_plan a, sales_plan_detail b, sales_visit c WHERE a.sales_plan_id = b.sales_plan_id AND b.customer_id = '".$data_tbl_sales_visit['customer_id']."' AND a.sales_plan_date like '%".$thn_sekarang."%' AND a.sales_plan_active = '1' AND a.sales_plan_date < '".$tgl_sekarang."' AND b.sales_plan_detail_id = c.sales_plan_detail_id");
										$data_last_visit_date = mysql_fetch_array($last_visit_date);
										
										$last_order_date = mysql_query("SELECT max(a.sales_request_date) as sales_request_date, max(b.sales_order_id) as sales_order_id FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$data_tbl_sales_visit['customer_id']."' AND a.sales_request_date like '%".$thn_sekarang."%'");
										$data_last_order_date = mysql_fetch_array($last_order_date);
									
										$tbl_product_sell = mysql_query("SELECT product_sell_id, product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
										while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
										{
									?>
										<div class="col-md-4">
											<div class="form-group">
												<label>
													<?php echo $data_tbl_product_sell['product_sell_name'] ?>
												</label>
												<input class="form-control" name="product_sell_id[]" type="hidden" value="<?php echo $data_tbl_product_sell['product_sell_id'] ?>">
												<input class="form-control" name="sales_visit_detail_product_sell_quantity[]" placeholder="<?php echo $data_tbl_product_sell['product_sell_name'] ?>" type="text" value="0">
												<label> 
													<?php
														
														$tbl_sales_visit = mysql_query("SELECT sales_visit_detail_product_sell_quantity FROM sales_visit_detail WHERE sales_visit_id = '".$data_last_visit_date['sales_visit_id']."' AND product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
														$data_tbl_sales_visit = mysql_fetch_array($tbl_sales_visit);
														
														$tbl_sales_order_detail = mysql_query("SELECT sales_order_detail_product_sell_quantity FROM sales_order_detail WHERE sales_order_id = '".$data_last_order_date['sales_order_id']."' AND product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
														$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
														
														$last_visit = tanggal_indo($data_last_visit_date['last_visit']);
														$last_order = tanggal_indo($data_last_order_date['sales_request_date']);
														
													?>
													Stok terakhir (<?php echo $last_visit ?>)        : <?php 
													if($data_tbl_sales_visit['sales_visit_detail_product_sell_quantity'] == ""){
														echo "0";
													} else {
														echo $data_tbl_sales_visit['sales_visit_detail_product_sell_quantity'];
													}  
													?>
													</br>
													Order terakhir (<?php echo $last_order ?>)       : <?php 
													if($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity'] == ""){
														echo "0";
													} else {
														echo $data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity'];
													}
													?>
												</label>
											</div>
										</div>
									<?php
										}
									?>
									</div>
									<h4 class="form-section">
										Foto Produk
									</h4>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label>
													Foto 1
												</label>
												<br />
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
														<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image">
													</div>
													<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
													<div>
														<span class="btn default btn-file">
															<span class="fileinput-new">
																Pilih Foto
															</span>
															<span class="fileinput-exists">
																Ganti
															</span>
															<input type="file" name="product_display_photo[]">
														</span>
														<a class="btn red fileinput-exists" data-dismiss="fileinput" href="javascript:;">Hapus</a>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>
													Foto 2
												</label>
												<br />
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
														<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image">
													</div>
													<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
													<div>
														<span class="btn default btn-file">
															<span class="fileinput-new">
																Pilih Foto
															</span>
															<span class="fileinput-exists">
																Ganti
															</span>
															<input type="file" name="product_display_photo[]">
														</span>
														<a class="btn red fileinput-exists" data-dismiss="fileinput" href="javascript:;">Hapus</a>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>
													Foto 3
												</label>
												<br />
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
														<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image">
													</div>
													<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
													<div>
														<span class="btn default btn-file">
															<span class="fileinput-new">
																Pilih Foto
															</span>
															<span class="fileinput-exists">
																Ganti
															</span>
															<input type="file" name="product_display_photo[]">
														</span>
														<a class="btn red fileinput-exists" data-dismiss="fileinput" href="javascript:;">Hapus</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<h4 class="form-section">
										Status Kunjungan
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Status Kunjungan
													<span class="required">
														*
													</span>
												</label>
												<div class="radio-list" data-error-container="#sales_visit_status">
													<label class="radio-inline">
														<input name="sales_visit_status" type="radio" value="Not Order">
															Not Order
													</label>
													<label class="radio-inline">
														<input name="sales_visit_status" type="radio" value="Order">
															Order
													</label>
												</div>
												<div id="sales_visit_status"></div>
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
												<input class="form-control" name="sales_visit_description" placeholder="Keterangan" type="text">
												<span class="help-block">
													*) Jika Status Order, Keterangan Dikosongkan
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
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="history.go(-1);">
										<i class="fa fa-times"></i>
										Batal
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	function form_order_sales_visit_dashboard()
	{
		$tgl_besok = date("d-m-Y", mktime(0,0,0, date("m"), date("d") + 1, date("Y")));
		
		$tbl_sales_visit = mysql_query("SELECT a.sales_visit_id, b.sales_plan_date, d.customer_id, d.customer_code, d.customer_name, d.customer_address, e.customer_category_name, f.customer_districts_name, g.user_name FROM sales_visit a, sales_plan b, sales_plan_detail c, customer d, customer_category e, customer_districts f, user g WHERE b.sales_plan_active = '1' AND d.customer_active = '1' AND e.customer_category_active = '1' AND f.customer_districts_active = '1' AND g.user_active = '1' AND a.sales_visit_id = '".$_GET['sales_visit_id']."' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id AND b.salesman_id = g.user_id AND c.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id");
		$data_tbl_sales_visit = mysql_fetch_array($tbl_sales_visit);
		
		$sales_plan_date_indo = tanggal_indo($data_tbl_sales_visit['sales_plan_date'])
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_sales_visit['user_name'] ?>
					<small>
						<?php echo $sales_plan_date_indo ?>
					</small>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_visit['customer_category_name'] ?> - <?php echo $data_tbl_sales_visit['customer_code'] ?> - <?php echo $data_tbl_sales_visit['customer_name'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_visit['customer_address'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_visit['customer_districts_name'] ?>
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
									Permintaan Penjualan
								</span>
							</div>
						</div>
						<div class="portlet-body form">
							<form action="?alimms=dashboard&tib=order-sales-visit-dashboard" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="customer_id" type="hidden" value="<?php echo $data_tbl_sales_visit['customer_id'] ?>">
							<input class="form-control" name="sales_request_order_method" type="hidden" value="By Visit">
								<div class="form-body">
									<h4 class="form-section">
										Permintaan Penjualan
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Cara Pembayaran
													<span class="required">
														*
													</span>
												</label>
												<div class="radio-list" data-error-container="#sales_request_payment_method">
													<label class="radio-inline">
														<input name="sales_request_payment_method" type="radio" value="Cash">
															Cash
													</label>
													<label class="radio-inline">
														<input name="sales_request_payment_method" type="radio" value="Credit">
															Credit
													</label>
												</div>
												<div id="sales_request_payment_method"></div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Jadwal Pengiriman
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_request_delivery_schedule_date" placeholder="Jadwal Pengiriman" type="text" value="<?php echo $tgl_besok ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Program Mix Produk
													<span class="required">
														*
													</span>
												</label>
												<div class="radio-list" data-error-container="#sales_request_product_sell_program_mix">
													<label class="radio-inline">
														<input name="sales_request_product_sell_program_mix" type="radio" value="Ya">
															Ya
													</label>
													<label class="radio-inline">
														<input name="sales_request_product_sell_program_mix" type="radio" value="Tidak">
															Tidak
													</label>
												</div>
												<div id="sales_request_product_sell_program_mix"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-server"></i>
										Proses
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="history.go(-1);">
										<i class="fa fa-times"></i>
										Batal
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	function form_product_sell_sales_visit_dashboard()
	{
		if($_GET['customer_id'] == "")
		{
			$tbl_sales_request = mysql_query("SELECT * FROM customer a, customer_category b, customer_districts c, sales_request d WHERE a.customer_id = d.customer_id AND a.customer_category_id = b.customer_category_id AND a.customer_districts_id = c.customer_districts_id AND d.sales_request_id = '".$_GET['sales_request_id']."'");
			$data_tbl_sales_request = mysql_fetch_array($tbl_sales_request);
			
			$customer_name = $data_tbl_sales_request['customer_name'];
			$customer_category_name = $data_tbl_sales_request['customer_category_name'];
			$customer_code = $data_tbl_sales_request['customer_code'];
			$customer_address = $data_tbl_sales_request['customer_address'];
			$customer_districts_name = $data_tbl_sales_request['customer_districts_name'];
			$customer_id = $data_tbl_sales_request['customer_id'];
			
		}
		else
		{
			$tbl_customer = mysql_query("SELECT * FROM customer a, customer_category b, customer_districts c WHERE a.customer_id = '".$_GET['customer_id']."' AND a.customer_category_id = b.customer_category_id AND a.customer_districts_id = c.customer_districts_id");
			$data_tbl_customer = mysql_fetch_array($tbl_customer);
			
			$customer_name = $data_tbl_customer['customer_name'];
			$customer_category_name = $data_tbl_customer['customer_category_name'];
			$customer_code = $data_tbl_customer['customer_code'];
			$customer_address = $data_tbl_customer['customer_address'];
			$customer_districts_name = $data_tbl_customer['customer_districts_name'];
			$customer_id = $_GET['customer_id'];
		}
		
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $customer_name ?>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $customer_category_name ?> - <?php echo $customer_code ?> 
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $customer_address ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $customer_districts_name ?>
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
									Permintaan Penjualan
								</span>
							</div>
						</div>
						<div class="portlet-body form">
							<form action="?alimms=dashboard&tib=product-sell-sales-visit-dashboard" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="customer_id" type="hidden" value="<?php echo $customer_id ?>">
							<input class="form-control" name="get_sales_request_id" type="hidden" value="<?php echo $_GET['sales_request_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Produk
									</h4>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>
													Produk
													<span class="required">
														*
													</span>
												</label>
												<div class="row">
									<?php
										$tbl_product_sell = mysql_query("SELECT product_sell_id, product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
										while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
										{
									?>
										<div class="col-md-4">
											<div class="form-group">
												<label>
													<?php echo $data_tbl_product_sell['product_sell_name'] ?>
												</label>
												<input class="form-control" name="product_sell_id[]" type="hidden" value="<?php echo $data_tbl_product_sell['product_sell_id'] ?>">
												<input class="form-control" name="sales_request_detail_product_sell_quantity[]" placeholder="<?php echo $data_tbl_product_sell['product_sell_name'] ?>" type="text" value="0">
												</label>
											</div>
										</div>
									<?php
										}
									?>
									</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Cara Pembayaran
													<span class="required">
														*
													</span>
												</label>
												<div class="radio-list" data-error-container="#sales_request_payment_method">
													<label class="radio-inline">
														<input name="sales_request_payment_method" type="radio" value="Cash">
															Cash
													</label>
													<label class="radio-inline">
														<input name="sales_request_payment_method" type="radio" value="Credit">
															Credit
													</label>
												</div>
												<div id="sales_request_payment_method"></div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Program Mix Produk
													<span class="required">
														*
													</span>
												</label>
												<div class="radio-list" data-error-container="#sales_request_product_sell_program_mix">
													<label class="radio-inline">
														<input name="sales_request_product_sell_program_mix" type="radio" value="Ya">
															Ya
													</label>
													<label class="radio-inline">
														<input name="sales_request_product_sell_program_mix" type="radio" value="Tidak">
															Tidak
													</label>
												</div>
												<div id="sales_request_product_sell_program_mix"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
								<?php
									$tbl_sales_request_detail = mysql_query("SELECT sales_request_id FROM sales_request_detail WHERE sales_request_id = '".$data_tbl_sales_request['sales_request_id']."'");
									$jumlah_tbl_sales_request_detail = mysql_num_rows($tbl_sales_request_detail);
									
									if ($jumlah_tbl_sales_request_detail > 0)
									{
								?>
									<button type="submit" class="btn btn-sm btn-outline blue sbold">
										<i class="fa fa-plus"></i>
										Tambah
									</button>
									<button type="button" class="btn btn-sm btn-outline green sbold" onclick="location.href='?alimms=dashboard';">
										<i class="fa fa-check"></i>
										Selesai
									</button>
								<?php
									}
									else
									{
								?>
									<button type="submit" class="btn btn-sm btn-outline blue sbold">
										<i class="fa fa-cogs"></i>
										Simpan
									</button>
								<?php
									}
								?>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	function form_view_sales_visit_dashboard()
	{
		$tbl_sales_visit = mysql_query("SELECT a.sales_visit_id, b.sales_plan_date, d.customer_id, d.customer_code, d.customer_name, d.customer_address, e.customer_category_name, f.customer_districts_name, g.user_id, g.user_name FROM sales_visit a, sales_plan b, sales_plan_detail c, customer d, customer_category e, customer_districts f, user g WHERE b.sales_plan_active = '1' AND d.customer_active = '1' AND e.customer_category_active = '1' AND f.customer_districts_active = '1' AND g.user_active = '1' AND a.sales_visit_id = '".$_GET['sales_visit_id']."' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id AND b.salesman_id = g.user_id AND c.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id");
		$data_tbl_sales_visit = mysql_fetch_array($tbl_sales_visit);
		
		$tbl_sales_request = mysql_query("SELECT sales_request_id FROM sales_request WHERE sales_request_date = '".$data_tbl_sales_visit['sales_plan_date']."' AND salesman_id = '".$data_tbl_sales_visit['user_id']."' AND customer_id = '".$data_tbl_sales_visit['customer_id']."' AND sales_request_order_method = 'By Visit'");
		$data_tbl_sales_request = mysql_fetch_array($tbl_sales_request);
		
		$sales_plan_date_indo = tanggal_indo($data_tbl_sales_visit['sales_plan_date']);
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_sales_visit['user_name'] ?>
					<small>
						<?php echo $sales_plan_date_indo ?>
					</small>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_visit['customer_category_name'] ?> - <?php echo $data_tbl_sales_visit['customer_code'] ?> - <?php echo $data_tbl_sales_visit['customer_name'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_visit['customer_address'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_visit['customer_districts_name'] ?>
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
									Kunjungan Penjualan
								</span>
							</div>
							<div class="actions">
								<a class="btn btn-outline btn-sm sbold yellow" href="?alimms=dashboard">
									<i class="fa fa-sign-out"></i>
									Keluar
								</a>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<h4 class="form-section">
									Stok Produk
								</h4>
								<div class="row">
								<?php
									$tbl_product_sell = mysql_query("SELECT product_sell_id, product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
									while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
									{
										$tbl_sales_visit_detail = mysql_query("SELECT sales_visit_detail_product_sell_quantity FROM sales_visit_detail WHERE sales_visit_id = '".$data_tbl_sales_visit['sales_visit_id']."' AND product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
										$data_tbl_sales_visit_detail = mysql_fetch_array($tbl_sales_visit_detail);
								?>
									<div class="col-md-4">
										<div class="form-group">
											<label>
												<?php echo $data_tbl_product_sell['product_sell_name'] ?>
											</label>
											<h4>
												<?php echo $data_tbl_sales_visit_detail['sales_visit_detail_product_sell_quantity'] ?> Crt
											</h4>
										</div>
									</div>
								<?php
									}
								?>
								</div>
								<h4 class="form-section">
									Foto Produk
								</h4>
								<div class="row">
								<?php
									$no = 1;
									$tbl_product_display = mysql_query("SELECT product_display_photo FROM product_display WHERE sales_visit_id = '".$data_tbl_sales_visit['sales_visit_id']."'");
									$jumlah_tbl_product_display = mysql_num_rows($tbl_product_display);
									
									if ($jumlah_tbl_product_display > 0)
									{
										while ($data_tbl_product_display = mysql_fetch_array($tbl_product_display))
										{
								?>
										<div class="col-md-4">
											<div class="thumbnail">
												<a href="../assets/layouts/layout6/img/product-display/<?php echo $data_tbl_product_display['product_display_photo'] ?>" class="fancybox-button" data-rel="fancybox-button">
													<img class="img-responsive" src="../assets/layouts/layout6/img/product-display/<?php echo $data_tbl_product_display['product_display_photo'] ?>" style="width: 100%; height: 200px;">
												</a>
												<div class="caption">
												   <h3>Foto <?php echo $no ?></h3>
												</div>
											</div>
										</div>
								<?php
										$no++;
										}
									}
									else
									{
								?>
									<div class="col-md-4">
										<div class="thumbnail">
											<img class="img-responsive" src="../assets/layouts/layout6/img/product-display/no_photo.jpg" style="width: 100%; height: 200px;">
											<div class="caption">
											   <h3>Foto</h3>
											</div>
										</div>
									</div>
								<?php
									}
								?>
								</div>
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-bordered table-checkable table-hover table-striped order-column" id="sample_2">
								<thead>
									<tr>
										<th>
											No
										</th>
										<th>
											Produk
										</th>
										<th>
											Jumlah
										</th>
										<th>
											Harga Satuan
										</th>
										<th>
											Program Bonus
										</th>
										<th>
											Potongan Diskon (Rp)
										</th>
										<th>
											Diskon Pembelian Tunai (%)
										</th>
										<th>
											Biaya Pengiriman
										</th>
										<th>
											Sub Total
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_sales_request_detail = mysql_query("SELECT a.sales_request_detail_id, a.sales_request_detail_product_sell_quantity, a.sales_request_detail_product_sell_price, a.sales_request_detail_program_bonus, a.sales_request_detail_piece_discount, a.sales_request_detail_cash_discount, a.sales_request_detail_delivery_cost_price, b.product_sell_name FROM sales_request_detail a, product_sell b WHERE a.sales_request_id = '".$data_tbl_sales_request['sales_request_id']."' AND a.product_sell_id = b.product_sell_id ORDER BY b.product_sell_code");
									while ($data_tbl_sales_request_detail = mysql_fetch_array($tbl_sales_request_detail))
									{
										$sales_request_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity']);
										$sales_request_detail_product_sell_price_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_product_sell_price']);
										$sales_request_detail_piece_discount_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_piece_discount']);
										$sales_request_detail_cash_discount = ($data_tbl_sales_request_detail['sales_request_detail_cash_discount'] / $data_tbl_sales_request_detail['sales_request_detail_product_sell_price']) * 100;
										$sales_request_detail_delivery_cost_price_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_delivery_cost_price']);
										$product_sell_sub_total_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] * ($data_tbl_sales_request_detail['sales_request_detail_product_sell_price'] - $data_tbl_sales_request_detail['sales_request_detail_piece_discount'] - $data_tbl_sales_request_detail['sales_request_detail_cash_discount'] + $data_tbl_sales_request_detail['sales_request_detail_delivery_cost_price']));
								?>
									<tr class="odd gradeX">
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_request_detail['product_sell_name'] ?>
										</td>
										<td>
											<?php echo $sales_request_detail_product_sell_quantity_indo ?>
										</td>
										<td>
											<?php echo $sales_request_detail_product_sell_price_indo ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_request_detail['sales_request_detail_program_bonus'] ?>
										</td>
										<td>
											<?php echo $sales_request_detail_piece_discount_indo ?>
										</td>
										<td>
											<?php echo $sales_request_detail_cash_discount ?>
										</td>
										<td>
											<?php echo $sales_request_detail_delivery_cost_price_indo ?>
										</td>
										<td>
											<?php echo $product_sell_sub_total_indo ?>
										</td>
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
	function form_view_customer_request_dashboard()
	{
		$tgl_sekarang = date("Y-m-d");
?>
		<div class="page-fixed-main-content">	 
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Permintaan Pelanggan
								</span>
							</div>
							<div class="actions">
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=dashboard&tib=form-add-customer-request-dashboard">
									<i class="fa fa-plus"></i>
									Tambah
								</a>
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
											Tanggal
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
											Kontak
										</th>
										<th>
											No. Telepon
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_customer_request = mysql_query("SELECT a.customer_request_id, a.customer_request_date, a.customer_request_name, a.customer_request_address, a.customer_request_contact, a.customer_request_phone, b.customer_districts_name FROM customer_request a, customer_districts b WHERE a.customer_request_active = '1' AND b.customer_districts_active = '1' AND a.customer_request_date = '".$tgl_sekarang."' AND a.customer_districts_id = b.customer_districts_id ORDER BY a.customer_request_date DESC");
									while ($data_tbl_customer_request = mysql_fetch_array($tbl_customer_request))
									{
										$customer_request_date_indo = tanggal_indo($data_tbl_customer_request['customer_request_date']);
										$sales_request_id = mysql_fetch_array(mysql_query("SELECT sales_request_id FROM sales_request WHERE sales_request_date = '".$tgl_sekarang."' AND customer_id = '".$data_tbl_customer_request['customer_id']."' AND salesman_id = '".$_SESSION['user_id']."'"));
								?>
									<tr class="odd gradeX">
										<td>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=dashboard&tib=form-edit-customer-request-dashboard&customer_request_id=<?php echo $data_tbl_customer_request['customer_request_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_customer_request_id_<?php echo $data_tbl_customer_request['customer_request_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										</td>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $customer_request_date_indo ?>
										</td>
										<td>
											<?php echo $data_tbl_customer_request['customer_request_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_customer_request['customer_request_address'] ?>
										</td>
										<td>
											<?php echo $data_tbl_customer_request['customer_districts_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_customer_request['customer_request_contact'] ?>
										</td>
										<td>
											<?php echo $data_tbl_customer_request['customer_request_phone'] ?>
										</td>
									</tr>
									<div aria-hidden="true" class="modal fade" id="delete_customer_request_id_<?php echo $data_tbl_customer_request['customer_request_id'] ?>" role="basic" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">
														Konfirmasi
													</h4>
                                                </div>
                                                <div class="modal-body">
													Apakah Anda Yakin Ingin Menghapus Data Ini ?
												</div>
                                                <div class="modal-footer">
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=dashboard&tib=delete-customer-request-dashboard&customer_request_id=<?php echo $data_tbl_customer_request['customer_request_id'] ?>">
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
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	function form_add_customer_request_dashboard()
	{
		$tgl_sekarang_indo = date("d-m-Y");
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Permintaan Pelanggan
								</span>
							</div>
						</div>
						<div class="portlet-body form">
							<form action="?alimms=dashboard&tib=add-customer-request-dashboard" enctype="multipart/form-data" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<h4 class="form-section">
										Permintaan Pelanggan
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Tanggal
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d" name="customer_request_date" placeholder="Tanggal" type="text" value="<?php echo $tgl_sekarang_indo ?>">
											</div>
										</div>
									</div>
									<h4 class="form-section">
										Pelanggan
									</h4>
									<div class="row">
										
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Nama
													<span class="required">
														*
													</span>
												</label>
												<input type="text" class="form-control" name="customer_request_name" placeholder="Nama">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Alamat
													<span class="required">
														*
													</span>
												</label>
												<input type="text" class="form-control" name="customer_request_address" placeholder="Alamat">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kecamatan
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-placeholder="Kecamatan" name="customer_districts_id">
													<option value=""></option>
													<?php
														$tbl_customer_districts = mysql_query("SELECT customer_districts_id, customer_districts_name FROM customer_districts WHERE customer_districts_active = '1' ORDER BY customer_districts_name");
														while($data_tbl_customer_districts = mysql_fetch_array($tbl_customer_districts))
														{
													?>
														<option value="<?php echo $data_tbl_customer_districts['customer_districts_id'] ?>"><?php echo $data_tbl_customer_districts['customer_districts_name'] ?></option>
													<?php	
														}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kontak
													<span class="required">
														*
													</span>
												</label>
												<input type="text" class="form-control" name="customer_request_contact" placeholder="Kontak">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													No. Telepon
													<span class="required">
														*
													</span>
												</label>
												<input type="text" class="form-control" name="customer_request_phone" placeholder="No. Telepon">
											</div>
										</div>
									</div>
								</div>
								<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label>
													Foto 1
												</label>
												<br />
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
														<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image">
													</div>
													<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
													<div>
														<span class="btn default btn-file">
															<span class="fileinput-new">
																Pilih Foto
															</span>
															<span class="fileinput-exists">
																Ganti
															</span>
															<input type="file" name="customer_display_photo[]">
														</span>
														<a class="btn red fileinput-exists" data-dismiss="fileinput" href="javascript:;">Hapus</a>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>
													Foto 2
												</label>
												<br />
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
														<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image">
													</div>
													<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
													<div>
														<span class="btn default btn-file">
															<span class="fileinput-new">
																Pilih Foto
															</span>
															<span class="fileinput-exists">
																Ganti
															</span>
															<input type="file" name="customer_display_photo[]">
														</span>
														<a class="btn red fileinput-exists" data-dismiss="fileinput" href="javascript:;">Hapus</a>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>
													Foto 3
												</label>
												<br />
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
														<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image">
													</div>
													<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
													<div>
														<span class="btn default btn-file">
															<span class="fileinput-new">
																Pilih Foto
															</span>
															<span class="fileinput-exists">
																Ganti
															</span>
															<input type="file" name="customer_display_photo[]">
														</span>
														<a class="btn red fileinput-exists" data-dismiss="fileinput" href="javascript:;">Hapus</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="history.go(-1);">
										<i class="fa fa-times"></i>
										Batal
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	function form_edit_customer_request_dashboard()
	{
		$tbl_customer_request = mysql_query("SELECT customer_request_id, customer_id, customer_request_date, customer_request_name, customer_request_address, customer_districts_id, customer_request_contact, customer_request_phone FROM customer_request WHERE customer_request_id = '".$_GET['customer_request_id']."'");
		$data_tbl_customer_request = mysql_fetch_array($tbl_customer_request);
		
		$customer_request_date = explode("-", $data_tbl_customer_request['customer_request_date']);
		$date_customer_request = $customer_request_date[2];
		$month_customer_request = $customer_request_date[1];
		$year_customer_request = $customer_request_date[0];
		$customer_request_date = date("d-m-Y", mktime(0, 0, 0, $month_customer_request, $date_customer_request, $year_customer_request));
		$customer = mysql_fetch_array(mysql_query("SELECT customer_category_id FROM customer WHERE customer_id = '".$data_tbl_customer_request['customer_id']."'"));
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Permintaan Pelanggan
								</span>
							</div>
						</div>
						<div class="portlet-body form">
							<form action="?alimms=dashboard&tib=edit-customer-request-dashboard" enctype="multipart/form-data" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="customer_request_id" type="hidden" value="<?php echo $data_tbl_customer_request['customer_request_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Permintaan Pelanggan
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Tanggal
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d" name="customer_request_date" placeholder="Tanggal" type="text" value="<?php echo $customer_request_date ?>">
											</div>
										</div>
									</div>
									<h4 class="form-section">
										Pelanggan
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kategori
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#customer_category_id" data-placeholder="Kategori" name="customer_category_id">
													<option value=""></option>
													<?php
														$tbl_customer_category = mysql_query("SELECT customer_category_id, customer_category_name FROM customer_category WHERE customer_category_active = '1' ORDER BY customer_category_name");
														while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
														{
															if ($data_tbl_customer_category['customer_category_id'] == $customer['customer_category_id'])
															{
													?>
																<option selected="selected" value="<?php echo $data_tbl_customer_category['customer_category_id'] ?>"><?php echo $data_tbl_customer_category['customer_category_name'] ?></option>
													<?php
															} 
															else 
															{
													?>
															<option value="<?php echo $data_tbl_customer_districts['customer_districts_id'] ?>"><?php echo $data_tbl_customer_districts['customer_districts_name'] ?></option>
													<?php
															}
														}
													?>
												</select>
												<div id="customer_category_id"></div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Nama
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="customer_request_name" placeholder="Nama" type="text" value="<?php echo $data_tbl_customer_request['customer_request_name'] ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Alamat
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="customer_request_address" placeholder="Alamat" type="text" value="<?php echo $data_tbl_customer_request['customer_request_address'] ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kecamatan
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-placeholder="Kecamatan" name="customer_districts_id">
													<option value=""></option>
													<?php
														$tbl_customer_districts = mysql_query("SELECT customer_districts_id, customer_districts_name FROM customer_districts WHERE customer_districts_active = '1' ORDER BY customer_districts_name");
														while($data_tbl_customer_districts = mysql_fetch_array($tbl_customer_districts))
														{
															if ($data_tbl_customer_districts['customer_districts_id'] == $data_tbl_customer_request['customer_districts_id'])
															{
													?>
															<option selected="selected" value="<?php echo $data_tbl_customer_districts['customer_districts_id'] ?>"><?php echo $data_tbl_customer_districts['customer_districts_name'] ?></option>
													<?php
															} 
															else 
															{
													?>
															<option value="<?php echo $data_tbl_customer_districts['customer_districts_id'] ?>"><?php echo $data_tbl_customer_districts['customer_districts_name'] ?></option>
													<?php
															}
														}
													?>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kontak
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="customer_request_contact" placeholder="Kontak" type="text" value="<?php echo $data_tbl_customer_request['customer_request_contact'] ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													No. Telepon
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="customer_request_phone" placeholder="No. Telepon" type="text" value="<?php echo $data_tbl_customer_request['customer_request_phone'] ?>">
											</div>
										</div>
									</div>
									<?php 
										
										$customer_display = mysql_query("SELECT customer_display_id FROM customer_display WHERE customer_request_id = '".$_GET['customer_request_id']."'"); 
										$a=0;
										while ($data_customer_display = mysql_fetch_array($customer_display))
										{
											$data_customer_display_id[$a] = $data_customer_display['customer_display_id'];
											$a++; ?>
											<input type="hidden" name="data_customer_display[]" value="<?php echo $data_customer_display['customer_display_id']; ?>" />
									<?php
										}
									?>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label>
													Foto 1
												</label>
												<br />
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
														<img src="../assets/layouts/layout6/img/customer-display/<?php $customer_display_photo = mysql_fetch_array(mysql_query("SELECT customer_display_photo FROM customer_display WHERE customer_display_id = '".$data_customer_display_id[0]."' ")); echo $customer_display_photo['customer_display_photo'] ?>">
													</div>
													<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
													<div>
														<span class="btn default btn-file">
															<span class="fileinput-new">
																Ganti Foto
															</span>
															<span class="fileinput-exists">
																Ganti
															</span>
															<input type="file" name="customer_display_photo[]">
														</span>
														<a class="btn red fileinput-exists" data-dismiss="fileinput" href="javascript:;">Hapus</a>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>
													Foto 2
												</label>
												<br />
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
														<img src="../assets/layouts/layout6/img/customer-display/<?php $customer_display_photo = mysql_fetch_array(mysql_query("SELECT customer_display_photo FROM customer_display WHERE customer_display_id = '".$data_customer_display_id[1]."' ")); echo $customer_display_photo['customer_display_photo'] ?>">
													</div>
													<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
													<div>
														<span class="btn default btn-file">
															<span class="fileinput-new">
																Ganti Foto
															</span>
															<span class="fileinput-exists">
																Ganti
															</span>
															<input type="file" name="customer_display_photo[]">
														</span>
														<a class="btn red fileinput-exists" data-dismiss="fileinput" href="javascript:;">Hapus</a>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>
													Foto 3
												</label>
												<br />
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
														<img src="../assets/layouts/layout6/img/customer-display/<?php $customer_display_photo = mysql_fetch_array(mysql_query("SELECT customer_display_photo FROM customer_display WHERE customer_display_id = '".$data_customer_display_id[2]."' ")); echo $customer_display_photo['customer_display_photo'] ?>">
													</div>
													<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
													<div>
														<span class="btn default btn-file">
															<span class="fileinput-new">
																Ganti Foto
															</span>
															<span class="fileinput-exists">
																Ganti
															</span>
															<input type="file" name="customer_display_photo[]">
														</span>
														<a class="btn red fileinput-exists" data-dismiss="fileinput" href="javascript:;">Hapus</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Ubah
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="history.go(-1);">
										<i class="fa fa-times"></i>
										Batal
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>		
		
<?php
	}
	function form_order_customer_request_dashboard()
	{
		$tgl_besok = date("d-m-Y", mktime(0,0,0, date("m"), date("d") + 1, date("Y")));
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Permintaan Penjualan
								</span>
							</div>
						</div>
						<div class="portlet-body form">
							<form action="?alimms=dashboard&tib=order-sales-visit-dashboard" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="customer_id" type="hidden" value="<?php echo $_GET['customer_id'] ?>">
							<input class="form-control" name="sales_request_order_method" type="hidden" value="By Visit">
								<div class="form-body">
									<h4 class="form-section">
										Permintaan Penjualan
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Cara Pembayaran
													<span class="required">
														*
													</span>
												</label>
												<div class="radio-list" data-error-container="#sales_request_payment_method">
													<label class="radio-inline">
														<input name="sales_request_payment_method" type="radio" value="Cash">
															Cash
													</label>
													<label class="radio-inline">
														<input name="sales_request_payment_method" type="radio" value="Credit">
															Credit
													</label>
												</div>
												<div id="sales_request_payment_method"></div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Jadwal Pengiriman
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_request_delivery_schedule_date" placeholder="Jadwal Pengiriman" type="text" value="<?php echo $tgl_besok ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Program Mix Produk
													<span class="required">
														*
													</span>
												</label>
												<div class="radio-list" data-error-container="#sales_request_product_sell_program_mix">
													<label class="radio-inline">
														<input name="sales_request_product_sell_program_mix" type="radio" value="Ya">
															Ya
													</label>
													<label class="radio-inline">
														<input name="sales_request_product_sell_program_mix" type="radio" value="Tidak">
															Tidak
													</label>
												</div>
												<div id="sales_request_product_sell_program_mix"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-server"></i>
										Proses
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="history.go(-1);">
										<i class="fa fa-times"></i>
										Batal
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	function form_view_customer_request_detail_dashboard()
	{
		$tbl_sales_request = mysql_fetch_array(mysql_query("SELECT * FROM sales_request a, customer b, customer_category c, user d, customer_districts e WHERE a.customer_id = b.customer_id AND b.customer_category_id = c.customer_category_id AND a.salesman_id = d.user_id AND b.customer_districts_id = e.customer_districts_id AND a.sales_request_id = '".$_GET['sales_request_id']."'"));
		$sales_request_date_indo = $tbl_sales_request['sales_request_date'];
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $tbl_sales_request['user_name'] ?>
					<small>
						<?php echo $sales_request_date_indo ?>
					</small>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $tbl_sales_request['customer_category_name'] ?> 
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $tbl_sales_request['customer_code'] ?> - <?php echo $tbl_sales_request['customer_name'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $tbl_sales_request['customer_address'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $tbl_sales_request['customer_districts_name'] ?>
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
									Kunjungan Penjualan
								</span>
							</div>
							<div class="actions">
								<a class="btn btn-outline btn-sm sbold yellow" href="?alimms=dashboard&tib=form-view-customer-request-dashboard">
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
											No
										</th>
										<th>
											Produk
										</th>
										<th>
											Jumlah
										</th>
										<th>
											Harga Satuan
										</th>
										<th>
											Program Bonus
										</th>
										<th>
											Potongan Diskon (Rp)
										</th>
										<th>
											Diskon Pembelian Tunai (%)
										</th>
										<th>
											Biaya Pengiriman
										</th>
										<th>
											Sub Total
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_sales_request_detail = mysql_query("SELECT a.sales_request_detail_id, a.sales_request_detail_product_sell_quantity, a.sales_request_detail_product_sell_price, a.sales_request_detail_program_bonus, a.sales_request_detail_piece_discount, a.sales_request_detail_cash_discount, a.sales_request_detail_delivery_cost_price, b.product_sell_name FROM sales_request_detail a, product_sell b WHERE a.sales_request_id = '".$_GET['sales_request_id']."' AND a.product_sell_id = b.product_sell_id ORDER BY b.product_sell_code");
									while ($data_tbl_sales_request_detail = mysql_fetch_array($tbl_sales_request_detail))
									{
										$sales_request_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity']);
										$sales_request_detail_product_sell_price_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_product_sell_price']);
										$sales_request_detail_piece_discount_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_piece_discount']);
										$sales_request_detail_cash_discount = ($data_tbl_sales_request_detail['sales_request_detail_cash_discount'] / $data_tbl_sales_request_detail['sales_request_detail_product_sell_price']) * 100;
										$sales_request_detail_delivery_cost_price_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_delivery_cost_price']);
										$product_sell_sub_total_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] * ($data_tbl_sales_request_detail['sales_request_detail_product_sell_price'] - $data_tbl_sales_request_detail['sales_request_detail_piece_discount'] - $data_tbl_sales_request_detail['sales_request_detail_cash_discount'] + $data_tbl_sales_request_detail['sales_request_detail_delivery_cost_price']));
								?>
									<tr class="odd gradeX">
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_request_detail['product_sell_name'] ?>
										</td>
										<td>
											<?php echo $sales_request_detail_product_sell_quantity_indo ?>
										</td>
										<td>
											<?php echo $sales_request_detail_product_sell_price_indo ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_request_detail['sales_request_detail_program_bonus'] ?>
										</td>
										<td>
											<?php echo $sales_request_detail_piece_discount_indo ?>
										</td>
										<td>
											<?php echo $sales_request_detail_cash_discount ?>
										</td>
										<td>
											<?php echo $sales_request_detail_delivery_cost_price_indo ?>
										</td>
										<td>
											<?php echo $product_sell_sub_total_indo ?>
										</td>
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
	function form_edit_customer_request_detail_dashboard()
	{
		$tbl_customer_request = mysql_query("SELECT customer_request_id, customer_id, customer_request_date, customer_request_name, customer_request_address, customer_districts_id, customer_request_contact, customer_request_phone FROM customer_request WHERE customer_request_id = '".$_GET['customer_request_id']."'");
		$data_tbl_customer_request = mysql_fetch_array($tbl_customer_request);
		
		$customer_request_date = explode("-", $data_tbl_customer_request['customer_request_date']);
		$date_customer_request = $customer_request_date[2];
		$month_customer_request = $customer_request_date[1];
		$year_customer_request = $customer_request_date[0];
		$customer_request_date = date("d-m-Y", mktime(0, 0, 0, $month_customer_request, $date_customer_request, $year_customer_request));
		$customer = mysql_fetch_array(mysql_query("SELECT customer_category_id FROM customer WHERE customer_id = '".$data_tbl_customer_request['customer_id']."'"));
		
		$tgl_sekarang = date('Y-m-d');
		
		$sales_request = mysql_fetch_array(mysql_query("SELECT * FROM sales_request a, user b, customer c, customer_districts d, customer_category e WHERE a.sales_request_date = '".$tgl_sekarang."' AND a.salesman_id = '".$_SESSION['user_id']."' AND a.customer_id = '".$data_tbl_customer_request['customer_id']."' AND a.salesman_id = b.user_id AND a.customer_id = c.customer_id AND c.customer_districts_id = d.customer_districts_id AND c.customer_category_id = e.customer_category_id"));
		$sales_request_delivery_schedule_date = tanggal_indo($sales_request['sales_request_delivery_schedule_date']);
		$sales_request_date = tanggal_indo($sales_request['sales_request_date']);
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $sales_request['user_name'] ?>
					<small>
						<?php echo $sales_request_date ?>
					</small>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $sales_request['customer_category_name'] ?> 
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
						<?php echo $sales_request['customer_code'] ?> - <?php echo $sales_request['customer_name'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $sales_request['customer_address'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $sales_request['customer_districts_name'] ?>
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
									Permintaan Penjualan
								</span>
							</div>
						</div>
						<div class="portlet-body form">
							<form action="?alimms=dashboard&tib=edit-customer-request-detail-dashboard" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="customer_id" type="hidden" value="<?php echo $data_tbl_sales_visit['customer_id'] ?>">
							<input class="form-control" name="sales_request_id" type="hidden" value="<?php echo $sales_request['sales_request_id'] ?>">
							<input class="form-control" name="sales_request_order_method" type="hidden" value="By Visit">
								<div class="form-body">
									<h4 class="form-section">
										Permintaan Penjualan
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Cara Pembayaran
													<span class="required">
														*
													</span>
												</label>
												<div class="radio-list" data-error-container="#sales_request_payment_method">
														<?php
														if ($sales_request['sales_request_payment_method'] == "Cash")
															{
														?>
														<label class="radio-inline">
																<input checked="checked" name="sales_request_payment_method" type="radio" value="Cash">
																	Cash
															</label>
															<label class="radio-inline">
																<input name="sales_request_payment_method" type="radio" value="Credit">
																	Credit
															</label>
														<?php
															}
															else
															{
														?>
															<label class="radio-inline">
																<input name="sales_request_payment_method" type="radio" value="Cash">
																	Cash
															</label>
															<label class="radio-inline">
																<input checked="checked" name="sales_request_payment_method" type="radio" value="Credit">
																	Credit
															</label>
														<?php
															}
														?>
												</div>
												<div id="sales_request_payment_method"></div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Jadwal Pengiriman
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_request_delivery_schedule_date" placeholder="Jadwal Pengiriman" type="text" value="<?php echo $sales_request_delivery_schedule_date; ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Program Mix Produk
													<span class="required">
														*
													</span>
												</label>
												<div class="radio-list" data-error-container="#sales_request_product_sell_program_mix">
													<?php
													if ($sales_request['sales_request_order_method'] == "By Phone")
													{
													?>
														<label class="radio-inline">
															<input checked="checked" name="sales_request_order_method" type="radio" value="By Phone">
																By Phone
														</label>
														<label class="radio-inline">
															<input name="sales_request_order_method" type="radio" value="By Visit">
																By Visit
														</label>
													<?php
														}
														else
														{
													?>
														<label class="radio-inline">
															<input name="sales_request_order_method" type="radio" value="By Phone">
																By Phone
														</label>
														<label class="radio-inline">
															<input checked="checked" name="sales_request_order_method" type="radio" value="By Visit">
																By Visit
														</label>
													<?php
														}
													?>
												</div>
												<div id="sales_request_product_sell_program_mix"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-server"></i>
										Proses
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="history.go(-1);">
										<i class="fa fa-times"></i>
										Batal
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

<?php
	}
	function form_edit_product_sell_customer_request_dashboard()
	{
		$tbl_sales_request = mysql_fetch_array(mysql_query("SELECT * FROM sales_request a, customer b, customer_category c, user d, customer_districts e WHERE a.customer_id = b.customer_id AND b.customer_category_id = c.customer_category_id AND a.salesman_id = d.user_id AND b.customer_districts_id = e.customer_districts_id AND a.sales_request_id = '".$_GET['sales_request_id']."'"));
		$sales_request_date_indo = $tbl_sales_request['sales_request_date'];
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $tbl_sales_request['user_name'] ?>
					<small>
						<?php echo $sales_request_date_indo ?>
					</small>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $tbl_sales_request['customer_category_name'] ?> 
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $tbl_sales_request['customer_code'] ?> - <?php echo $tbl_sales_request['customer_name'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $tbl_sales_request['customer_address'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $tbl_sales_request['customer_districts_name'] ?>
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
									Kunjungan Penjualan
								</span>
							</div>
							<div class="actions">
								<a class="btn btn-outline btn-sm sbold yellow" href="?alimms=dashboard&tib=form-view-customer-request-dashboard">
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
											No
										</th>
										<th>
											Produk
										</th>
										<th>
											Jumlah
										</th>
										<th>
											Harga Satuan
										</th>
										<th>
											Program Bonus
										</th>
										<th>
											Potongan Diskon (Rp)
										</th>
										<th>
											Diskon Pembelian Tunai (%)
										</th>
										<th>
											Biaya Pengiriman
										</th>
										<th>
											Sub Total
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_sales_request_detail = mysql_query("SELECT a.sales_request_detail_id, a.sales_request_detail_product_sell_quantity, a.sales_request_detail_product_sell_price, a.sales_request_detail_program_bonus, a.sales_request_detail_piece_discount, a.sales_request_detail_cash_discount, a.sales_request_detail_delivery_cost_price, b.product_sell_name FROM sales_request_detail a, product_sell b WHERE a.sales_request_id = '".$_GET['sales_request_id']."' AND a.product_sell_id = b.product_sell_id ORDER BY b.product_sell_code");
									while ($data_tbl_sales_request_detail = mysql_fetch_array($tbl_sales_request_detail))
									{
										$sales_request_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity']);
										$sales_request_detail_product_sell_price_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_product_sell_price']);
										$sales_request_detail_piece_discount_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_piece_discount']);
										$sales_request_detail_cash_discount = ($data_tbl_sales_request_detail['sales_request_detail_cash_discount'] / $data_tbl_sales_request_detail['sales_request_detail_product_sell_price']) * 100;
										$sales_request_detail_delivery_cost_price_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_delivery_cost_price']);
										$product_sell_sub_total_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] * ($data_tbl_sales_request_detail['sales_request_detail_product_sell_price'] - $data_tbl_sales_request_detail['sales_request_detail_piece_discount'] - $data_tbl_sales_request_detail['sales_request_detail_cash_discount'] + $data_tbl_sales_request_detail['sales_request_detail_delivery_cost_price']));
								?>
									<tr class="odd gradeX">
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_request_detail['product_sell_name'] ?>
										</td>
										<td>
											<?php echo $sales_request_detail_product_sell_quantity_indo ?>
										</td>
										<td>
											<?php echo $sales_request_detail_product_sell_price_indo ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_request_detail['sales_request_detail_program_bonus'] ?>
										</td>
										<td>
											<?php echo $sales_request_detail_piece_discount_indo ?>
										</td>
										<td>
											<?php echo $sales_request_detail_cash_discount ?>
										</td>
										<td>
											<?php echo $sales_request_detail_delivery_cost_price_indo ?>
										</td>
										<td>
											<?php echo $product_sell_sub_total_indo ?>
										</td>
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
	function form_view_sales_schedule_by_sales()
	{
		$tbl_sales_schedule_user = mysql_query("SELECT b.user_name FROM sales_schedule_user a, user b WHERE a.salesman_id = b.user_id AND a.salesman_id = '".$_SESSION['user_id']."'");
		$data_tbl_sales_schedule_user = mysql_fetch_array($tbl_sales_schedule_user);
?>
		<div class="page-fixed-main-content">	
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Rencana Kerja
								</span>
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-bordered table-checkable table-hover table-striped order-column" id="sample_2">
								<thead>
									<tr>
										<th>
										</th>
										<th width="3%">
											No
										</th>
										<th>
											Hari
										</th>
                                        <th>
											Minggu Ke
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_sales_schedule = mysql_query("SELECT * FROM sales_schedule  WHERE salesman_id = '".$_SESSION['user_id']."' AND sales_schedule_active = '1' order by sales_schedule_week, sales_schedule_id");
									while ($data_tbl_sales_schedule = mysql_fetch_array($tbl_sales_schedule))
									{
										
								?>
									<tr class="odd gradeX">
										<td>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=dashboard&tib=form-view-sales-schedule-entry-by-sales&sales_schedule_id=<?php echo $data_tbl_sales_schedule['sales_schedule_id'] ?>">
												<i class="fa fa-search"></i>
											</a>
										</td>
										<td width="3%">
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_schedule['sales_schedule_day'] ?>
										</td>
                                        <td>
											<?php echo $data_tbl_sales_schedule['sales_schedule_week'] ?>
										</td>
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
	function form_view_sales_schedule_entry_by_sales()
	{
		$tbl_sales_schedule = mysql_query("SELECT * FROM sales_schedule a, user b WHERE a.sales_schedule_id = '".$_GET['sales_schedule_id']."' AND a.salesman_id = b.user_id");
		$data_tbl_sales_schedule = mysql_fetch_array($tbl_sales_schedule);
		
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_sales_schedule['user_name'] ?>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascrip:;">
							<?php echo $data_tbl_sales_schedule['sales_schedule_day'] ?>
						</a>
					</li>
                    <li>
						<a class="todo-active" href="javascrip:;">
							<?php echo "Minggu Ke - ".' '.$data_tbl_sales_schedule['sales_schedule_week'] ?>
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
									Jadwal Penjualan
								</span>
							</div>
							<div class="actions">
								<a class="btn btn-outline btn-sm sbold yellow" href="?alimms=dashboard&tib=form-view-sales-schedule-by-sales">
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
											Ubah
										</th>
										<th>
											No
										</th>
										<th>
											Kategori
										</th>
										<th>
											Kode
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
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_sales_schedule_detail = mysql_query("SELECT b.customer_id, b.customer_code, b.customer_name, b.customer_address, c.customer_category_name, d.customer_districts_name, a.sales_schedule_no, a.sales_schedule_detail_id FROM sales_schedule_detail a, customer b, customer_category c, customer_districts d WHERE a.sales_schedule_id = '".$data_tbl_sales_schedule['sales_schedule_id']."' AND a.customer_id = b.customer_id AND b.customer_category_id = c.customer_category_id AND b.customer_districts_id = d.customer_districts_id ORDER BY a.sales_schedule_no");
									while ($data_tbl_sales_schedule_detail = mysql_fetch_array($tbl_sales_schedule_detail))
									{
								?>
									<tr class="odd gradeX">
										<td>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" data-toggle="modal" href="#move_sales_schedule_detail<?php echo $data_tbl_sales_schedule_detail['sales_schedule_no'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
										</td>
										<td>
											<?php echo $data_tbl_sales_schedule_detail['sales_schedule_no'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_schedule_detail['customer_category_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_schedule_detail['customer_code'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_schedule_detail['customer_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_schedule_detail['customer_address'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_schedule_detail['customer_districts_name'] ?>
										</td>
									</tr>
								<div aria-hidden="true" class="modal fade" id="move_sales_schedule_detail<?php echo $data_tbl_sales_schedule_detail['sales_schedule_no'] ?>" role="basic" tabindex="-1">
								<form action="?alimms=dashboard&tib=move-sales-schedule-no" class="horizontal-form" enctype="multipart/form-data" id="form_sample_3" method="post">
								<input type="hidden" name="sales_schedule_detail_id" value="<?php echo $data_tbl_sales_schedule_detail['sales_schedule_detail_id'] ?>"/>
								<input type="hidden" name="sales_schedule_id" value="<?php echo $_GET['sales_schedule_id'] ?>"/>
								<input type="hidden" name="sales_schedule_no_awal" value="<?php echo $data_tbl_sales_schedule_detail['sales_schedule_no'] ?>"/>
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">
														Pindahkan ke nomer
													</h4>
                                                </div>
                                                <div class="modal-body">
													<select class="form-control select2me" data-error-container="#customer_id" data-placeholder="Nomer" name="sales_schedule_no_akhir">
													<option value=""></option>
													<?php
														$tbl_sales_schedule = mysql_query("SELECT sales_schedule_no FROM sales_schedule_detail WHERE sales_schedule_id = '".$_GET['sales_schedule_id']."' order by sales_schedule_no");
														while($data_tbl_sales_schedule = mysql_fetch_array($tbl_sales_schedule))
														{
													?>
															<option value="<?php echo $data_tbl_sales_schedule['sales_schedule_no'] ?>"><?php echo $data_tbl_sales_schedule['sales_schedule_no'] ?> </option>
													<?php
														}
													?>
											</select>
												</div>
                                                <div class="modal-footer">
													<button type="submit" class="btn btn-sm btn-outline green sbold">
														<i class="fa fa-check"></i>
														Simpan
													</button>
													<a class="btn btn-outline btn-sm red sbold" data-dismiss="modal">
														<i class="fa fa-times"></i>
														Batal
													</a>
                                                </div>
                                            </div>
                                        </div>
										</form>
                                    </div>
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
	function form_add_billing_visit_dashboard()
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
							<form action="?alimms=dashboard&tib=add-billing-visit-payment" class="horizontal-form" id="form_sample_3" method="post">
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
	function form_view_billing_visit_dashboard()
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
	function form_view_sales_visit_not_order()
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
								$tbl_sales_plan = mysql_query("SELECT COUNT(b.customer_id) AS customer_sub_total FROM sales_plan a, sales_plan_detail b WHERE a.sales_plan_active = '1' AND a.salesman_id = '".$_SESSION['user_id']."' AND a.sales_plan_date = '".$tgl_sekarang."' AND a.sales_plan_id = b.sales_plan_id");
								$data_tbl_sales_plan = mysql_fetch_array($tbl_sales_plan);
							?>
								<div class="col-md-4">
									<div class="uppercase profile-stat-title">
										<a href="?alimms=dashboard">
										<?php echo $data_tbl_sales_plan['customer_sub_total'] ?>
										</a>
									</div>
									<div class="uppercase profile-stat-text">
										<a href="?alimms=dashboard">
											Plan
										</a>
									</div>
								</div>
							<?php
								$tbl_sales_visit_successful = mysql_query("SELECT COUNT(c.customer_id) AS customer_sub_total FROM sales_visit a, sales_plan b, sales_plan_detail c WHERE b.sales_plan_active = '1' AND NOT a.sales_visit_datetime = '0000-00-00 00:00:00' AND b.salesman_id = '".$_SESSION['user_id']."' AND b.sales_plan_date = '".$tgl_sekarang."' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id");
								$data_tbl_sales_visit_successful = mysql_fetch_array($tbl_sales_visit_successful);
							?>
								<div class="col-md-4">
									<div class="uppercase profile-stat-title">
										<?php echo $data_tbl_sales_visit_successful['customer_sub_total'] ?>
									</div>
									<div class="uppercase profile-stat-text">
										Actual
									</div>
								</div>
							<?php
								$tbl_sales_visit_unsuccessful = mysql_query("SELECT COUNT(c.customer_id) AS customer_sub_total FROM sales_visit a, sales_plan b, sales_plan_detail c WHERE b.sales_plan_active = '1' AND a.sales_visit_datetime = '0000-00-00 00:00:00' AND b.salesman_id = '".$_SESSION['user_id']."' AND b.sales_plan_date = '".$tgl_sekarang."' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id");
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
								$tbl_sales_visit_order = mysql_query("SELECT COUNT(c.customer_id) AS customer_sub_total FROM sales_visit a, sales_plan b, sales_plan_detail c WHERE b.sales_plan_active = '1' AND a.sales_visit_status = 'Order' AND b.salesman_id = '".$_SESSION['user_id']."' AND b.sales_plan_date = '".$tgl_sekarang."' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id");
								$data_tbl_sales_visit_order = mysql_fetch_array($tbl_sales_visit_order);
							?>
								<div class="col-md-6">
									<div class="uppercase profile-stat-title">
									<a href="?alimms=dashboard&tib=form-view-sales-visit-order">
										<?php echo $data_tbl_sales_visit_order['customer_sub_total'] ?>
									</a>
									</div>
									<div class="uppercase profile-stat-text">
										<a href="?alimms=dashboard&tib=form-view-sales-visit-order">
										Order
										</a>
									</div>
								</div>
							<?php
								$tbl_sales_visit_not_order = mysql_query("SELECT COUNT(c.customer_id) AS customer_sub_total FROM sales_visit a, sales_plan b, sales_plan_detail c WHERE b.sales_plan_active = '1' AND a.sales_visit_status = 'Not Order' AND b.salesman_id = '".$_SESSION['user_id']."' AND b.sales_plan_date = '".$tgl_sekarang."' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id");
								$data_tbl_sales_visit_not_order = mysql_fetch_array($tbl_sales_visit_not_order);
							?>
								<div class="col-md-6">
									<div class="uppercase profile-stat-title">
										<?php echo $data_tbl_sales_visit_not_order['customer_sub_total'] ?>
									</div>
									<div class="uppercase profile-stat-text">
										Not Order
									</div>
								</div>
							</div>
							<div>
								<h4 class="profile-desc-title">
									Sales Plan <?php echo tanggal_sekarangindo() ?>
								</h4>
								<span class="profile-desc-text">
									Rencana Penjualan Salesman <?php echo $_SESSION['user_name'] ?> Tanggal <?php echo tanggal_sekarangindo() ?>
								</span>
							</div>  
						</div>
					</div>
					<div class="profile-content">
						<div class="row">
							<div class="col-md-6">
								<div class="bordered light portlet">
									<div class="portlet-title">
										<div class="caption">
											<span class="caption-subject font-blue sbold uppercase">
												Sales Visit Activity
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
														<div id="sparkline_bar"></div>
													</div>
													<?php
														$tbl_sales_target = mysql_query("SELECT SUM(b.sales_target_detail_product_sell_quantity * d.product_sell_price_detail_product_sell_price) AS sales_target_sub_total FROM sales_target a, sales_target_detail b, product_sell_price c, product_sell_price_detail d WHERE a.sales_target_active = '1' AND c.product_sell_price_active = '1' AND a.salesman_id = '".$_SESSION['user_id']."' AND a.sales_target_period = '".$blnthn_sekarang."' AND c.product_sell_price_name = 'HJ Retail' AND a.sales_target_id = b.sales_target_id AND c.product_sell_price_id = d.product_sell_price_id AND b.product_sell_id = d.product_sell_id");
														$data_tbl_sales_target = mysql_fetch_array($tbl_sales_target);
				
														$sales_target_sub_total_indo = format_angka($data_tbl_sales_target['sales_target_sub_total']);
													?>
													<div class="stat-number">
														<div class="title">
															Target
														</div>
														<div class="number">
															<?php echo $sales_target_sub_total_indo ?>
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
														$tbl_sales_invoice = mysql_query("SELECT SUM((c.sales_order_detail_product_sell_quantity * (c.sales_order_detail_product_sell_price - c.sales_order_detail_piece_discount - c.sales_order_detail_cash_discount)) + ((c.sales_order_detail_product_sell_quantity + c.sales_order_detail_program_bonus) * c.sales_order_detail_delivery_cost_price)) AS product_sell_total FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE a.sales_invoice_status = 'Posted' AND d.sales_request_active = '1' AND a.sales_invoice_date BETWEEN '".$tgl_sekarang_awal."' AND '".$tgl_sekarang_akhir."' AND d.salesman_id = '".$_SESSION['user_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
														$data_tbl_sales_invoice = mysql_fetch_array($tbl_sales_invoice);
														
														$product_sell_total_indo = format_angka($data_tbl_sales_invoice['product_sell_total']);
													?>
													<div class="stat-number">
														<div class="title">
															Actual
														</div>
														<div class="number">
															<?php echo $product_sell_total_indo ?>
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
													$tbl_sales_visit = mysql_query("SELECT a.sales_visit_id, a.sales_visit_status, a.sales_visit_description, b.sales_plan_date, d.customer_code, d.customer_name, d.customer_address, e.customer_category_name, f.customer_districts_name FROM sales_visit a, sales_plan b, sales_plan_detail c, customer d, customer_category e, customer_districts f WHERE a.sales_visit_status = 'Not Order' AND b.sales_plan_active = '1' AND d.customer_active = '1' AND e.customer_category_active = '1' AND  f.customer_districts_active = '1' AND b.sales_plan_date = '".$tgl_sekarang."' AND b.salesman_id = '".$_SESSION['user_id']."' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id AND c.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id ORDER BY c.sales_plan_detail_id");
													while ($data_tbl_sales_visit = mysql_fetch_array($tbl_sales_visit))
													{
												?>
													<tr>
														<td>
														<?php
															if ($data_tbl_sales_visit['sales_plan_date'] == $tgl_sekarang)
															{
																if ($data_tbl_sales_visit['sales_visit_status'] == "Not Order" || $data_tbl_sales_visit['sales_visit_status'] == "Order")
																{
														?>
																<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=dashboard&tib=form-view-sales-visit-dashboard&sales_visit_id=<?php echo $data_tbl_sales_visit['sales_visit_id'] ?>">
																	<i class="fa fa-search"></i>
																</a>
														<?php
																}
																else
																{
														?>
																<a class="btn btn-icon-only btn-outline purple tooltips" data-original-title="Proses" data-toggle="modal" href="#add_sales_visit_id_<?php echo $data_tbl_sales_visit['sales_visit_id'] ?>">
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
															<?php echo $data_tbl_sales_visit['customer_category_name'] ?> - <?php echo $data_tbl_sales_visit['customer_code'] ?> - <?php echo $data_tbl_sales_visit['customer_name'] ?>
														</td>
														<td>
															<?php echo $data_tbl_sales_visit['customer_address'] ?>
														</td>
														<td>
															<?php echo $data_tbl_sales_visit['customer_districts_name'] ?>
														</td>
														<td>
														<?php
															if ($data_tbl_sales_visit['sales_visit_status'] == "Call")
															{
														?>
																<span class="label label-info label-sm">Call</span>
														<?php
															}
															elseif ($data_tbl_sales_visit['sales_visit_status'] == "Not Order")
															{
														?>
																<span class="label label-danger label-sm">Not Order</span><br />
																<?php echo $data_tbl_sales_visit['sales_visit_description'] ?>
														<?php
															}
															else
															{
														?>
																<span class="label label-success label-sm">Order</span>
														<?php
															}
														?>
														</td>
													</tr>
													<div aria-hidden="true" class="modal fade" id="add_sales_visit_id_<?php echo $data_tbl_sales_visit['sales_visit_id'] ?>" role="basic" tabindex="-1">
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
																	<a class="btn btn-outline btn-sm green sbold" href="?alimms=dashboard&tib=form-add-sales-visit-dashboard&sales_visit_id=<?php echo $data_tbl_sales_visit['sales_visit_id'] ?>">
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
							<div class="col-md-6">
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
														$tbl_payment_order_detail = mysql_query("SELECT SUM(b.payment_order_detail_payment_nominal) AS payment_order_detail_payment_nominal FROM payment_order a, payment_order_detail b, sales_invoice c, sales_order d, sales_request e WHERE e.sales_request_active = '1' AND b.payment_order_detail_payment_date BETWEEN '".$tgl_sekarang_awal."' AND '".$tgl_sekarang_akhir."' AND e.salesman_id = '".$_SESSION['user_id']."' AND a.payment_order_id = b.payment_order_id AND a.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id AND d.sales_request_id = e.sales_request_id");
														$data_tbl_payment_order_detail = mysql_fetch_array($tbl_payment_order_detail);
														
														$payment_order_detail_payment_nominal_indo = format_angka($data_tbl_payment_order_detail['payment_order_detail_payment_nominal']);
													?>
													<div class="stat-number">
														<div class="title">
															Actual
														</div>
														<div class="number">
															<?php echo $payment_order_detail_payment_nominal_indo ?>
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
																<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=dashboard&tib=form-view-billing-visit-dashboard&billing_visit_id=<?php echo $data_tbl_billing_visit['billing_visit_id'] ?>">
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
																	<a class="btn btn-outline btn-sm green sbold" href="?alimms=dashboard&tib=form-add-billing-visit-dashboard&billing_visit_id=<?php echo $data_tbl_billing_visit['billing_visit_id'] ?>">
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
	function form_view_sales_visit_order()
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
								$tbl_sales_plan = mysql_query("SELECT COUNT(b.customer_id) AS customer_sub_total FROM sales_plan a, sales_plan_detail b WHERE a.sales_plan_active = '1' AND a.salesman_id = '".$_SESSION['user_id']."' AND a.sales_plan_date = '".$tgl_sekarang."' AND a.sales_plan_id = b.sales_plan_id");
								$data_tbl_sales_plan = mysql_fetch_array($tbl_sales_plan);
							?>
								<div class="col-md-4">
									<div class="uppercase profile-stat-title">
									<a href="?alimms=dashboard">
										<?php echo $data_tbl_sales_plan['customer_sub_total'] ?>
									</a>
									</div>
									<div class="uppercase profile-stat-text">
										<a href="?alimms=dashboard">
											Plan
										</a>
									</div>
								</div>
							<?php
								$tbl_sales_visit_successful = mysql_query("SELECT COUNT(c.customer_id) AS customer_sub_total FROM sales_visit a, sales_plan b, sales_plan_detail c WHERE b.sales_plan_active = '1' AND NOT a.sales_visit_datetime = '0000-00-00 00:00:00' AND b.salesman_id = '".$_SESSION['user_id']."' AND b.sales_plan_date = '".$tgl_sekarang."' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id");
								$data_tbl_sales_visit_successful = mysql_fetch_array($tbl_sales_visit_successful);
							?>
								<div class="col-md-4">
									<div class="uppercase profile-stat-title">
										<?php echo $data_tbl_sales_visit_successful['customer_sub_total'] ?>
									</div>
									<div class="uppercase profile-stat-text">
										Actual
									</div>
								</div>
							<?php
								$tbl_sales_visit_unsuccessful = mysql_query("SELECT COUNT(c.customer_id) AS customer_sub_total FROM sales_visit a, sales_plan b, sales_plan_detail c WHERE b.sales_plan_active = '1' AND a.sales_visit_datetime = '0000-00-00 00:00:00' AND b.salesman_id = '".$_SESSION['user_id']."' AND b.sales_plan_date = '".$tgl_sekarang."' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id");
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
								$tbl_sales_visit_order = mysql_query("SELECT COUNT(c.customer_id) AS customer_sub_total FROM sales_visit a, sales_plan b, sales_plan_detail c WHERE b.sales_plan_active = '1' AND a.sales_visit_status = 'Order' AND b.salesman_id = '".$_SESSION['user_id']."' AND b.sales_plan_date = '".$tgl_sekarang."' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id");
								$data_tbl_sales_visit_order = mysql_fetch_array($tbl_sales_visit_order);
							?>
								<div class="col-md-6">
									<div class="uppercase profile-stat-title">
										<?php echo $data_tbl_sales_visit_order['customer_sub_total'] ?>
									</div>
									<div class="uppercase profile-stat-text">
										Order
									</div>
								</div>
							<?php
								$tbl_sales_visit_not_order = mysql_query("SELECT COUNT(c.customer_id) AS customer_sub_total FROM sales_visit a, sales_plan b, sales_plan_detail c WHERE b.sales_plan_active = '1' AND a.sales_visit_status = 'Not Order' AND b.salesman_id = '".$_SESSION['user_id']."' AND b.sales_plan_date = '".$tgl_sekarang."' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id");
								$data_tbl_sales_visit_not_order = mysql_fetch_array($tbl_sales_visit_not_order);
							?>
								<div class="col-md-6">
									<div class="uppercase profile-stat-title">
									<a href="?alimms=dashboard&tib=form-view-sales-visit-not-order">
										<?php echo $data_tbl_sales_visit_not_order['customer_sub_total'] ?>
									</a>
									</div>
									<div class="uppercase profile-stat-text">
									<a href="?alimms=dashboard&tib=form-view-sales-visit-not-order">
										Not Order
									</a>
									</div>
								</div>
							</div>
							<div>
								<h4 class="profile-desc-title">
									Sales Plan <?php echo tanggal_sekarangindo() ?>
								</h4>
								<span class="profile-desc-text">
									Rencana Penjualan Salesman <?php echo $_SESSION['user_name'] ?> Tanggal <?php echo tanggal_sekarangindo() ?>
								</span>
							</div>  
						</div>
					</div>
					<div class="profile-content">
						<div class="row">
							<div class="col-md-6">
								<div class="bordered light portlet">
									<div class="portlet-title">
										<div class="caption">
											<span class="caption-subject font-blue sbold uppercase">
												Sales Visit Activity
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
														<div id="sparkline_bar"></div>
													</div>
													<?php
														$tbl_sales_target = mysql_query("SELECT SUM(b.sales_target_detail_product_sell_quantity * d.product_sell_price_detail_product_sell_price) AS sales_target_sub_total FROM sales_target a, sales_target_detail b, product_sell_price c, product_sell_price_detail d WHERE a.sales_target_active = '1' AND c.product_sell_price_active = '1' AND a.salesman_id = '".$_SESSION['user_id']."' AND a.sales_target_period = '".$blnthn_sekarang."' AND c.product_sell_price_name = 'HJ Retail' AND a.sales_target_id = b.sales_target_id AND c.product_sell_price_id = d.product_sell_price_id AND b.product_sell_id = d.product_sell_id");
														$data_tbl_sales_target = mysql_fetch_array($tbl_sales_target);
				
														$sales_target_sub_total_indo = format_angka($data_tbl_sales_target['sales_target_sub_total']);
													?>
													<div class="stat-number">
														<div class="title">
															Target
														</div>
														<div class="number">
															<?php echo $sales_target_sub_total_indo ?>
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
														$tbl_sales_invoice = mysql_query("SELECT SUM((c.sales_order_detail_product_sell_quantity * (c.sales_order_detail_product_sell_price - c.sales_order_detail_piece_discount - c.sales_order_detail_cash_discount)) + ((c.sales_order_detail_product_sell_quantity + c.sales_order_detail_program_bonus) * c.sales_order_detail_delivery_cost_price)) AS product_sell_total FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE a.sales_invoice_status = 'Posted' AND d.sales_request_active = '1' AND a.sales_invoice_date BETWEEN '".$tgl_sekarang_awal."' AND '".$tgl_sekarang_akhir."' AND d.salesman_id = '".$_SESSION['user_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
														$data_tbl_sales_invoice = mysql_fetch_array($tbl_sales_invoice);
														
														$product_sell_total_indo = format_angka($data_tbl_sales_invoice['product_sell_total']);
													?>
													<div class="stat-number">
														<div class="title">
															Actual
														</div>
														<div class="number">
															<?php echo $product_sell_total_indo ?>
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
													$tbl_sales_visit = mysql_query("SELECT a.sales_visit_id, a.sales_visit_status, a.sales_visit_description, b.sales_plan_date, d.customer_code, d.customer_name, d.customer_address, e.customer_category_name, f.customer_districts_name FROM sales_visit a, sales_plan b, sales_plan_detail c, customer d, customer_category e, customer_districts f WHERE a.sales_visit_status = 'Order' AND b.sales_plan_active = '1' AND d.customer_active = '1' AND e.customer_category_active = '1' AND  f.customer_districts_active = '1' AND b.sales_plan_date = '".$tgl_sekarang."' AND b.salesman_id = '".$_SESSION['user_id']."' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id AND c.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id ORDER BY c.sales_plan_detail_id");
													while ($data_tbl_sales_visit = mysql_fetch_array($tbl_sales_visit))
													{
												?>
													<tr>
														<td>
														<?php
															if ($data_tbl_sales_visit['sales_plan_date'] == $tgl_sekarang)
															{
																if ($data_tbl_sales_visit['sales_visit_status'] == "Not Order" || $data_tbl_sales_visit['sales_visit_status'] == "Order")
																{
														?>
																<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=dashboard&tib=form-view-sales-visit-dashboard&sales_visit_id=<?php echo $data_tbl_sales_visit['sales_visit_id'] ?>">
																	<i class="fa fa-search"></i>
																</a>
														<?php
																}
																else
																{
														?>
																<a class="btn btn-icon-only btn-outline purple tooltips" data-original-title="Proses" data-toggle="modal" href="#add_sales_visit_id_<?php echo $data_tbl_sales_visit['sales_visit_id'] ?>">
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
															<?php echo $data_tbl_sales_visit['customer_category_name'] ?> - <?php echo $data_tbl_sales_visit['customer_code'] ?> - <?php echo $data_tbl_sales_visit['customer_name'] ?>
														</td>
														<td>
															<?php echo $data_tbl_sales_visit['customer_address'] ?>
														</td>
														<td>
															<?php echo $data_tbl_sales_visit['customer_districts_name'] ?>
														</td>
														<td>
														<?php
															if ($data_tbl_sales_visit['sales_visit_status'] == "Call")
															{
														?>
																<span class="label label-info label-sm">Call</span>
														<?php
															}
															elseif ($data_tbl_sales_visit['sales_visit_status'] == "Not Order")
															{
														?>
																<span class="label label-danger label-sm">Not Order</span><br />
																<?php echo $data_tbl_sales_visit['sales_visit_description'] ?>
														<?php
															}
															else
															{
														?>
																<span class="label label-success label-sm">Order</span>
														<?php
															}
														?>
														</td>
													</tr>
													<div aria-hidden="true" class="modal fade" id="add_sales_visit_id_<?php echo $data_tbl_sales_visit['sales_visit_id'] ?>" role="basic" tabindex="-1">
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
																	<a class="btn btn-outline btn-sm green sbold" href="?alimms=dashboard&tib=form-add-sales-visit-dashboard&sales_visit_id=<?php echo $data_tbl_sales_visit['sales_visit_id'] ?>">
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
							<div class="col-md-6">
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
														$tbl_payment_order_detail = mysql_query("SELECT SUM(b.payment_order_detail_payment_nominal) AS payment_order_detail_payment_nominal FROM payment_order a, payment_order_detail b, sales_invoice c, sales_order d, sales_request e WHERE e.sales_request_active = '1' AND b.payment_order_detail_payment_date BETWEEN '".$tgl_sekarang_awal."' AND '".$tgl_sekarang_akhir."' AND e.salesman_id = '".$_SESSION['user_id']."' AND a.payment_order_id = b.payment_order_id AND a.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id AND d.sales_request_id = e.sales_request_id");
														$data_tbl_payment_order_detail = mysql_fetch_array($tbl_payment_order_detail);
														
														$payment_order_detail_payment_nominal_indo = format_angka($data_tbl_payment_order_detail['payment_order_detail_payment_nominal']);
													?>
													<div class="stat-number">
														<div class="title">
															Actual
														</div>
														<div class="number">
															<?php echo $payment_order_detail_payment_nominal_indo ?>
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
																<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=dashboard&tib=form-view-billing-visit-dashboard&billing_visit_id=<?php echo $data_tbl_billing_visit['billing_visit_id'] ?>">
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
																	<a class="btn btn-outline btn-sm green sbold" href="?alimms=dashboard&tib=form-add-billing-visit-dashboard&billing_visit_id=<?php echo $data_tbl_billing_visit['billing_visit_id'] ?>">
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
	function form_search_call_book_salesman_dashboard()
	{
		$tgl_sekarang = date('Y-m-d');
		$blnthn_sekarang_indo = date("m-Y");
?>
	<div class="page-fixed-main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">
								CALL BOOK SALESMAN
							</span>
						</div>
					</div>
					<div class="form portlet-body">
						<form action="?alimms=dashboard&tib=form-result-call-book-salesman-dashboard" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>
												Pelanggan
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#customer_id" data-placeholder="Pelanggan" name="customer_id">
													<option value=""></option>
													<?php
														
														$tbl_customer = mysql_query("SELECT a.customer_id, a.customer_code, a.customer_name, a.customer_address, b.customer_category_name, c.customer_districts_name FROM customer a, customer_category b, customer_districts c, sales_plan d, sales_plan_detail e WHERE a.customer_active = '1' AND b.customer_category_active = '1' AND c.customer_districts_active = '1' AND a.customer_category_id = b.customer_category_id AND a.customer_districts_id = c.customer_districts_id AND d.sales_plan_id = e.sales_plan_id AND e.customer_id = a.customer_id AND d.salesman_id = '".$_SESSION['user_id']."' AND d.sales_plan_date = '".$tgl_sekarang."' ORDER BY a.customer_code ");
														while($data_tbl_customer = mysql_fetch_array($tbl_customer))
														{
													?>
															<option value="<?php echo $data_tbl_customer['customer_id'] ?>"><?php echo $data_tbl_customer['customer_category_name'] ?> - <?php echo $data_tbl_customer['customer_code'] ?> - <?php echo $data_tbl_customer['customer_name'] ?> - <?php echo $data_tbl_customer['customer_address'] ?> (<?php echo $data_tbl_customer['customer_districts_name'] ?>)</option>
													<?php
														}
													?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Dari Tanggal
												<span class="required">
													*
												</span>
											</label>
											<input class="form-control date-picker" data-date-format="mm-yyyy" data-date-minviewmode="months" data-date-viewmode="years" name="call_book_from_date" placeholder="Periode" type="text" >
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
											<input class="form-control date-picker" data-date-format="mm-yyyy" data-date-minviewmode="months" data-date-viewmode="years" name="call_book_to_date" placeholder="Periode" type="text">
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions right">
								<button type="submit" class="btn btn-sm btn-outline purple sbold">
									<i class="fa fa-rss"></i>
									Proses
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>	
	
<?php
	}
	function form_result_call_book_salesman_dashboard()
	{
		
			$call_book_date = explode("-", $_POST['call_book_date']);
			$date_call_book_date = $call_book_date[0];
			$month_call_book_date = $call_book_date[1];
			$year_call_book_date = $call_book_date[2];
			$call_book_date = date("Y-m", mktime(0, 0, 0, $month_call_book_date, $date_call_book_date, $year_call_book_date));
		
		$tbl_pelanggan = mysql_query("SELECT * FROM customer a, customer_districts b WHERE a.customer_districts_id = b.customer_districts_id AND a.customer_id = '".$_POST['customer_id']."'");
		$data_tbl_pelanggan = mysql_fetch_array($tbl_pelanggan);
		
		$call_book_from_date = explode("-", $_POST['call_book_from_date']);
		$month_call_book_from = $call_book_from_date[0];
		$year_call_book_from = $call_book_from_date[1];
		$call_book_from_date = $year_call_book_from.'-'.$month_call_book_from.'-'.'01';
		
		
		$call_book_to_date = explode("-", $_POST['call_book_to_date']);
		$month_call_book_to = $call_book_to_date[0];
		$year_call_book_to = $call_book_to_date[1];
		$call_book_to_date = $year_call_book_to.'-'.$month_call_book_to.'-'.'31';
		
		$tgl_sekarang = date('Y-m-d');
		
?>
	<div class="page-fixed-main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">
								CALL BOOK SALESMAN
							</span>
						</div>
					</div>
					<div class="form portlet-body">
						<form action="?alimms=dashboard&tib=form-result-call-book-salesman-dashboard" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>
												Pelanggan
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#customer_id" data-placeholder="Pelanggan" name="customer_id">
													<option value=""></option>
													<?php
														$tbl_customer = mysql_query("SELECT a.customer_id, a.customer_code, a.customer_name, a.customer_address, b.customer_category_name, c.customer_districts_name FROM customer a, customer_category b, customer_districts c, sales_plan d, sales_plan_detail e WHERE a.customer_active = '1' AND b.customer_category_active = '1' AND c.customer_districts_active = '1' AND a.customer_category_id = b.customer_category_id AND a.customer_districts_id = c.customer_districts_id AND d.sales_plan_id = e.sales_plan_id AND e.customer_id = a.customer_id AND d.salesman_id = '".$_SESSION['user_id']."' AND d.sales_plan_date = '".$tgl_sekarang."' ORDER BY a.customer_code ");
														while($data_tbl_customer = mysql_fetch_array($tbl_customer))
														{
													?>
															<option value="<?php echo $data_tbl_customer['customer_id'] ?>"><?php echo $data_tbl_customer['customer_category_name'] ?> - <?php echo $data_tbl_customer['customer_code'] ?> - <?php echo $data_tbl_customer['customer_name'] ?> - <?php echo $data_tbl_customer['customer_address'] ?> (<?php echo $data_tbl_customer['customer_districts_name'] ?>)</option>
													<?php
														}
													?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Dari Tanggal
												<span class="required">
													*
												</span>
											</label>
											<input class="form-control date-picker" data-date-format="mm-yyyy" data-date-minviewmode="months" data-date-viewmode="years" name="call_book_from_date" placeholder="Periode" type="text" >
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
											<input class="form-control date-picker" data-date-format="mm-yyyy" data-date-minviewmode="months" data-date-viewmode="years" name="call_book_to_date" placeholder="Periode" type="text">
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions right">
								<button type="submit" class="btn btn-sm btn-outline purple sbold">
									<i class="fa fa-rss"></i>
									Proses
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="todo-main-header">
						<h3>
							<?php echo $data_tbl_pelanggan['customer_name'] ?>
						</h3>
						<ul class="todo-breadcrumb">
							<li>
								<a class="todo-active" href="javascript:;">
									<?php echo $data_tbl_pelanggan['customer_address'] ?>
								</a>
							</li>
							<li>
								<a class="todo-active" href="javascript:;">
									<?php echo $data_tbl_pelanggan['customer_districts_name'] ?> 
								</a>
							</li>
						</ul>
					</div>
					
					<div class="portlet-body">
						<div class="table-responsive">
						<?php
							
							$call_book_month = mysql_query("SELECT a.sales_plan_date FROM sales_plan a, sales_plan_detail b WHERE a.sales_plan_id = b.sales_plan_id AND b.customer_id = '".$_POST['customer_id']."' AND a.sales_plan_date between '".$call_book_from_date."' AND '".$call_book_to_date."' AND a.sales_plan_active = '1' group by MONTH(a.sales_plan_date)");
							while($data_call_book_month = mysql_fetch_array($call_book_month)){
								$call_book_on_month = explode("-", $data_call_book_month['sales_plan_date']);
								$year_call_book_on_month = $call_book_on_month[0];
								$month_call_book_on_month = $call_book_on_month[1];
								$date_call_book_on_month = $call_book_on_month[2];
								$data_call_book_on_month = date("Y-m", mktime(0, 0, 0, $month_call_book_on_month, $date_call_book_on_month, $year_call_book_on_month)); 
							
						?>
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th rowspan="2">
											Produk
										</th>
										<?php
											$n = 0;
											$tbl_sales_request = mysql_query("SELECT a.sales_plan_date FROM sales_plan a, sales_plan_detail b WHERE a.sales_plan_id = b.sales_plan_id AND b.customer_id = '".$_POST['customer_id']."' AND a.sales_plan_date like '%".$data_call_book_on_month."%' AND a.sales_plan_active = '1' AND NOT EXISTS(SELECT a.sales_request_date FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date = a.sales_plan_date) group by a.sales_plan_date
																				union all
																			  SELECT a.sales_request_date FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date like '%".$data_call_book_on_month."%' group by a.sales_request_date order by sales_plan_date ");
											while($data_tbl_sales_request = mysql_fetch_array($tbl_sales_request)){ 
												$n++;
												$sales_plan_date_indo = tanggal_indo($data_tbl_sales_request['sales_plan_date']);
											?>
												
												<th colspan="2">
													Tanggal <?php echo $sales_plan_date_indo ?>
												</th>
												
										
										<?php		
											}
										?>
										<th colspan="2">
											1 Bulan
										</th>
									</tr>
									<tr>
										<?php
											$n = 0;
											$tbl_sales_request = mysql_query("SELECT a.sales_plan_date FROM sales_plan a, sales_plan_detail b WHERE a.sales_plan_id = b.sales_plan_id AND b.customer_id = '".$_POST['customer_id']."' AND a.sales_plan_date like '%".$data_call_book_on_month."%' AND a.sales_plan_active = '1' AND NOT EXISTS(SELECT a.sales_request_date FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date = a.sales_plan_date) group by a.sales_plan_date
																				union all
																			  SELECT a.sales_request_date FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date like '%".$data_call_book_on_month."%' group by a.sales_request_date order by sales_plan_date ");
											while($data_tbl_sales_request = mysql_fetch_array($tbl_sales_request)){ 
												$n++;
												$sales_plan_date_indo = tanggal_indo($data_tbl_sales_request['sales_plan_date']);
											?>
												
												<th>
													Stok 
												</th>
												<th>
													Order 
												</th>
										
										<?php		
											}
										?>
										
										<th>
											Total
										</th>
										<th>
											AVG
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_product_sell = mysql_query("SELECT product_sell_id, product_sell_name FROM product_sell WHERE product_sell_active = '1'");
									while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
									{
								?>
									<tr>
										<td>
											<?php echo $data_tbl_product_sell['product_sell_name'] ?>
										</td>
										<?php
											$n = 0;
											$tbl_sales_request = mysql_query("SELECT a.sales_plan_date FROM sales_plan a, sales_plan_detail b WHERE a.sales_plan_id = b.sales_plan_id AND b.customer_id = '".$_POST['customer_id']."' AND a.sales_plan_date like '%".$data_call_book_on_month."%' AND a.sales_plan_active = '1' AND NOT EXISTS(SELECT a.sales_request_date FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date = a.sales_plan_date) group by a.sales_plan_date
																				union all
																			  SELECT a.sales_request_date FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date like '%".$data_call_book_on_month."%' group by a.sales_request_date order by sales_plan_date ");
											while($data_tbl_sales_request = mysql_fetch_array($tbl_sales_request)){ 
												$n++;
												$sales_plan_date_indo = tanggal_indo($data_tbl_sales_request['sales_plan_date']);
												
												$tbl_sales_plan = mysql_query("SELECT * FROM sales_plan a, sales_plan_detail b WHERE a.sales_plan_active = '1' AND a.sales_plan_id = b.sales_plan_id AND b.customer_id = '".$_POST['customer_id']."' AND a.sales_plan_date = '".$data_tbl_sales_request['sales_plan_date']."'");
												$data_tbl_sales_plan = mysql_fetch_array($tbl_sales_plan);
												
												$tbl_sales_visit = mysql_query("SELECT * FROM sales_visit a, sales_visit_detail b WHERE a.sales_plan_detail_id = '".$data_tbl_sales_plan['sales_plan_detail_id']."' AND a.sales_visit_id = b.sales_visit_id AND b.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
												$data_tbl_sales_visit = mysql_fetch_array($tbl_sales_visit);
												
												$tbl_sales_request_detail = mysql_query("SELECT * FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date = '".$data_tbl_sales_request['sales_plan_date']."' AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
												$data_tbl_sales_request_detail = mysql_fetch_array($tbl_sales_request_detail);
											?>
												
												<td align="center">
													 <?php 
														if($data_tbl_sales_visit['sales_visit_detail_product_sell_quantity'] == ""){
															echo "0";
														} else {
															echo $data_tbl_sales_visit['sales_visit_detail_product_sell_quantity'];
														}
														 
													 ?>
												</td>
												<td align="center">
													 <?php 
														if($data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] == ""){
															echo "0"; 
														} else {
															echo $data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'];
														}
													?>
												</td>
										
										<?php		
											}
											
											$tbl_sum_sales_request_detail = mysql_query("SELECT sum(d.sales_request_detail_product_sell_quantity) as sales_request_detail_product_sell_quantity FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date like '%".$data_call_book_on_month."%' AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
											$data_tbl_sum_sales_request_detail = mysql_fetch_array($tbl_sum_sales_request_detail);
											
											$tbl_count_sales_request_detail = mysql_query("SELECT a.sales_request_id FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date like '%".$data_call_book_on_month."%' AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
											$data_tbl_count_sales_request_detail = mysql_num_rows($tbl_count_sales_request_detail);
											
											$avg_sales_request_detail = round($data_tbl_sum_sales_request_detail['sales_request_detail_product_sell_quantity'] / $data_tbl_count_sales_request_detail);
											
											$sum_avg_sales_request_detail = $sum_avg_sales_request_detail + $avg_sales_request_detail;
												
											?>
												<td align="center">
													<?php 
													if($data_tbl_sum_sales_request_detail['sales_request_detail_product_sell_quantity'] == ""){
														echo "0";
													} else {
														echo $data_tbl_sum_sales_request_detail['sales_request_detail_product_sell_quantity'];
													}
														 
													?>
												</td>
												<td align="center">
													<?php 
														if($avg_sales_request_detail == ""){
															echo "0";
														} else {
															echo $avg_sales_request_detail; 
														}
													?>
												</td>
									</tr>
								<?php
									}
								?>
									<tr>
										<td>
											Total
										</td>
										<?php
											$n = 0;
											
											$tbl_sales_request = mysql_query("SELECT a.sales_plan_date FROM sales_plan a, sales_plan_detail b WHERE a.sales_plan_id = b.sales_plan_id AND b.customer_id = '".$_POST['customer_id']."' AND a.sales_plan_date like '%".$data_call_book_on_month."%' AND a.sales_plan_active = '1' AND NOT EXISTS(SELECT a.sales_request_date FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date = a.sales_plan_date) group by a.sales_plan_date
																				union all
																			  SELECT a.sales_request_date FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date like '%".$data_call_book_on_month."%' group by a.sales_request_date order by sales_plan_date ");
											while($data_tbl_sales_request = mysql_fetch_array($tbl_sales_request)){ 
												$n++;
												$sales_plan_date_indo = tanggal_indo($data_tbl_sales_request['sales_plan_date']);
												
												$tbl_sales_plan = mysql_query("SELECT * FROM sales_plan a, sales_plan_detail b WHERE a.sales_plan_active = '1' AND a.sales_plan_id = b.sales_plan_id AND b.customer_id = '".$_POST['customer_id']."' AND a.sales_plan_date = '".$data_tbl_sales_request['sales_plan_date']."'");
												$data_tbl_sales_plan = mysql_fetch_array($tbl_sales_plan);
												
												$tbl_sales_visit = mysql_query("SELECT *, sum(b.sales_visit_detail_product_sell_quantity) as sum_sales_visit_detail_product_sell_quantity FROM sales_visit a, sales_visit_detail b WHERE a.sales_plan_detail_id = '".$data_tbl_sales_plan['sales_plan_detail_id']."' AND a.sales_visit_id = b.sales_visit_id");
												$data_tbl_sales_visit = mysql_fetch_array($tbl_sales_visit);
												
												$tbl_sales_request_detail = mysql_query("SELECT *, sum(d.sales_request_detail_product_sell_quantity) as sum_sales_request_detail_product_sell_quantity FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date = '".$data_tbl_sales_request['sales_plan_date']."'");
												$data_tbl_sales_request_detail = mysql_fetch_array($tbl_sales_request_detail);
											?>
												
												<td align="center">
													 <?php echo $data_tbl_sales_visit['sum_sales_visit_detail_product_sell_quantity'] ?>
												</td>
												<td align="center">
													 <?php echo $data_tbl_sales_request_detail['sum_sales_request_detail_product_sell_quantity'] ?>
												</td>
										
										<?php		
											}
											
											$tbl_sum_sales_request_detail = mysql_query("SELECT sum(d.sales_request_detail_product_sell_quantity) as sales_request_detail_product_sell_quantity FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date like '%".$data_call_book_on_month."%'");
											$data_tbl_sum_sales_request_detail = mysql_fetch_array($tbl_sum_sales_request_detail);
											
											
											?>
												<td align="center">
													<?php echo $data_tbl_sum_sales_request_detail['sales_request_detail_product_sell_quantity'] ?>
												</td>
												<td align="center">
													<?php 
														if($sum_avg_sales_request_detail == "")
														{
															
														} else {
															echo $sum_avg_sales_request_detail;
														}
														 
													?>
												</td>
									</tr>
									
								</tbody>
							</table>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
<?php
	}
?>