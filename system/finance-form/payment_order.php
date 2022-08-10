<?php
	function form_initial_payment_order()
	{
?>
		<div class="page-fixed-main-content">	 
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
											Salesman
										</th>
										<th>
											Pelanggan
										</th>
										<th>
											Kecamatan
										</th>
										<th>
											Cara Pembayaran
										</th>
										<th>
											Jatuh Tempo
										</th>
										<th>
											Jumlah Total
										</th>
										<th>
											Jumlah Terbayar
										</th>
										<th>
											Status
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_payment_order = mysql_query("SELECT a.payment_order_id, a.payment_order_status, b.sales_invoice_no, b.sales_invoice_date, b.sales_invoice_overdue_date, c.sales_order_id, c.sales_order_overdue_day, d.sales_request_payment_method, e.user_name, f.customer_code, f.customer_name, g.customer_category_name, h.customer_districts_name FROM payment_order a, sales_invoice b, sales_order c, sales_request d, user e, customer f, customer_category g, customer_districts h WHERE d.sales_request_active = '1' AND e.user_active = '1' AND f.customer_active = '1' AND g.customer_category_active = '1' AND h.customer_districts_active = '1' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id = c.sales_order_id AND c.sales_request_id = d.sales_request_id AND d.salesman_id = e.user_id AND d.customer_id = f.customer_id AND f.customer_category_id = g.customer_category_id AND f.customer_districts_id = h.customer_districts_id ORDER BY b.sales_invoice_no");
									while ($data_tbl_payment_order = mysql_fetch_array($tbl_payment_order))
									{
										$sales_invoice_date_indo = tanggal_indo($data_tbl_payment_order['sales_invoice_date']);
										$sales_invoice_overdue_date_indo = tanggal_indo($data_tbl_payment_order['sales_invoice_overdue_date']);
										
										$tbl_sales_order_detail = mysql_query("SELECT SUM((sales_order_detail_product_sell_quantity * (sales_order_detail_product_sell_price - sales_order_detail_piece_discount - sales_order_detail_cash_discount)) + ((sales_order_detail_product_sell_quantity + sales_order_detail_program_bonus) * sales_order_detail_delivery_cost_price)) AS product_sell_total FROM sales_order_detail WHERE sales_order_id = '".$data_tbl_payment_order['sales_order_id']."'");
										$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
										
										$product_sell_total_indo = format_angka($data_tbl_sales_order_detail['product_sell_total']);
										
										$tbl_payment_order_detail = mysql_query("SELECT SUM(payment_order_detail_payment_nominal) AS payment_order_detail_payment_nominal FROM payment_order_detail WHERE payment_order_id = '".$data_tbl_payment_order['payment_order_id']."'");
										$data_tbl_payment_order_detail = mysql_fetch_array($tbl_payment_order_detail);
										
										$payment_order_detail_payment_nominal_indo = format_angka($data_tbl_payment_order_detail['payment_order_detail_payment_nominal']);
								?>
									<tr class="odd gradeX">
										<td>
										<?php
											if ($data_tbl_payment_order['payment_order_status'] == "Paid")
											{
										?>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=payment-order&tib=form-view-payment-order&payment_order_id=<?php echo $data_tbl_payment_order['payment_order_id'] ?>">
												<i class="fa fa-search"></i>
											</a>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=payment-order&tib=form-edit-payment-order&payment_order_id=<?php echo $data_tbl_payment_order['payment_order_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
										<?php
											}
											else
											{
										?>
											<a class="btn btn-icon-only btn-outline purple tooltips" data-original-title="Proses" data-toggle="modal" href="#add_payment_order_id_<?php echo $data_tbl_payment_order['payment_order_id'] ?>">
												<i class="fa fa-rss"></i>
											</a>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=payment-order&tib=form-view-payment-order&payment_order_id=<?php echo $data_tbl_payment_order['payment_order_id'] ?>">
												<i class="fa fa-search"></i>
											</a>
										<?php
											}
										?>
										</td>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_payment_order['sales_invoice_no'] ?><br />
											<?php echo $sales_invoice_date_indo ?>
										</td>
										<td>
											<?php echo $data_tbl_payment_order['user_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_payment_order['customer_category_name'] ?> - 
											<?php echo $data_tbl_payment_order['customer_code'] ?> - <?php echo $data_tbl_payment_order['customer_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_payment_order['customer_districts_name'] ?>
										</td>
										<td>
										<?php
											if ($data_tbl_payment_order['sales_order_overdue_day'] == 0)
											{
										?>
											<?php echo $data_tbl_payment_order['sales_request_payment_method'] ?>
										<?php
											}
											else
											{
										?>
											<?php echo $data_tbl_payment_order['sales_request_payment_method'] ?> (<?php echo $data_tbl_payment_order['sales_order_overdue_day'] ?> Hari)
										<?php	
											}
										?>
										</td>
										<td>
											<?php echo $sales_invoice_overdue_date_indo ?>
										</td>
										<td>
											<?php echo $product_sell_total_indo ?>
										</td>
										<td>
											<?php echo $payment_order_detail_payment_nominal_indo ?>
										</td>
										<td>
										<?php
											if ($data_tbl_payment_order['payment_order_status'] == "Call")
											{
										?>
											<span class="label label-info label-sm">Call</span>
										<?php
											}
											elseif ($data_tbl_payment_order['payment_order_status'] == "Unpaid")
											{
										?>
											<span class="label label-danger label-sm">Unpaid</span>
										<?php
											}
											else
											{
										?>
											<span class="label label-success label-sm">Paid</span>
										<?php
											}
										?>
										</td>
									</tr>
									<div aria-hidden="true" class="modal fade" id="add_payment_order_id_<?php echo $data_tbl_payment_order['payment_order_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=payment-order&tib=form-add-payment-order&payment_order_id=<?php echo $data_tbl_payment_order['payment_order_id'] ?>">
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
	function form_add_payment_order()
	{
		$tbl_payment_order = mysql_query("SELECT a.payment_order_id, b.sales_invoice_no, b.sales_invoice_date, c.sales_order_overdue_day, d.sales_request_payment_method, d.sales_request_order_method, d.sales_request_product_sell_program_mix, e.user_name, f.customer_code, f.customer_name, g.customer_category_name, h.customer_districts_name FROM payment_order a, sales_invoice b, sales_order c, sales_request d, user e, customer f, customer_category g, customer_districts h WHERE a.payment_order_id = '".$_GET['payment_order_id']."' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id = c.sales_order_id AND c.sales_request_id = d.sales_request_id AND d.salesman_id = e.user_id AND d.customer_id = f.customer_id AND f.customer_category_id = g.customer_category_id AND f.customer_districts_id = h.customer_districts_id");
		$data_tbl_payment_order = mysql_fetch_array($tbl_payment_order);
		
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
							<?php echo $data_tbl_payment_order['user_name'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_payment_order['customer_category_name'] ?> - <?php echo $data_tbl_payment_order['customer_code'] ?> - <?php echo $data_tbl_payment_order['customer_name'] ?> (<?php echo $data_tbl_payment_order['customer_districts_name'] ?>)
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
						<?php
							if ($data_tbl_payment_order['sales_order_overdue_day'] == 0)
							{
						?>
							<?php echo $data_tbl_payment_order['sales_request_payment_method'] ?>
						<?php	
							}
							else
							{
						?>
							<?php echo $data_tbl_payment_order['sales_request_payment_method'] ?> (<?php echo $data_tbl_payment_order['sales_order_overdue_day'] ?> Hari)
						<?php	
							}
						?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_payment_order['sales_request_order_method'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							Program Mix Produk (<?php echo $data_tbl_payment_order['sales_request_product_sell_program_mix'] ?>)
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
						<div class="portlet-body form">
							<form action="?alimms=payment-order&tib=add-payment-order" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="payment_order_id" type="hidden" value="<?php echo $data_tbl_payment_order['payment_order_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Pesanan Pembayaran
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kategori Pembayaran
													<span class="required">
														*
													</span>
												</label>
												<div class="radio-list" data-error-container="#payment_category_id">
												<?php
													$tbl_payment_category = mysql_query("SELECT payment_category_id, payment_category_name FROM payment_category WHERE payment_category_active = '1' ORDER BY payment_category_name");
													while($data_tbl_payment_category = mysql_fetch_array($tbl_payment_category))
													{
												?>
													<label class="radio-inline">
														<input name="payment_category_id" type="radio" value="<?php echo $data_tbl_payment_category['payment_category_id'] ?>">
															<?php echo $data_tbl_payment_category['payment_category_name'] ?>
													</label>
												<?php
													}
												?>
												</div>
												<div id="payment_category_id"></div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Tanggal Dibayarkan
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="payment_order_detail_payment_date" placeholder="Tanggal Dibayarkan" type="text" value="<?php echo $tgl_sekarang ?>">
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
						<div class="portlet-body">
							<table class="table table-bordered table-checkable table-hover table-striped order-column" id="sample_2">
								<thead>
									<tr>
										<th>
											No
										</th>
										<th>
											Pembayaran
										</th>
										<th>
											No. BG/ Rekening
										</th>
										<th>
											Nama Bank
										</th>
										<th>
											Atas Nama
										</th>
										<th>
											Nominal
										</th>
										<th>
											Jatuh Tempo
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_payment_order_detail = mysql_query("SELECT a.payment_order_detail_payment_date, a.payment_order_detail_account_no, a.payment_order_detail_bank_name, a.payment_order_detail_account_name, a.payment_order_detail_payment_nominal, a.payment_order_detail_payment_due_date, b.payment_category_name FROM payment_order_detail a, payment_category b WHERE a.payment_order_id = '".$data_tbl_payment_order['payment_order_id']."' AND NOT a.payment_order_detail_payment_status = 'On Hold' AND a.payment_category_id = b.payment_category_id ORDER BY a.payment_order_detail_payment_date");
									while ($data_tbl_payment_order_detail = mysql_fetch_array($tbl_payment_order_detail))
									{
										$payment_order_detail_payment_date_indo = tanggal_indo($data_tbl_payment_order_detail['payment_order_detail_payment_date']);
										$payment_order_detail_payment_due_date_indo = tanggal_indo($data_tbl_payment_order_detail['payment_order_detail_payment_due_date']);
										
										$payment_order_detail_payment_nominal_indo = format_angka($data_tbl_payment_order_detail['payment_order_detail_payment_nominal']);
								?>
									<tr class="odd gradeX">
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_payment_order_detail['payment_category_name'] ?><br />
											<?php echo $payment_order_detail_payment_date_indo ?>
										</td>
										<td>
											<?php echo $data_tbl_payment_order_detail['payment_order_detail_account_no'] ?>
										</td>
										<td>
											<?php echo $data_tbl_payment_order_detail['payment_order_detail_bank_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_payment_order_detail['payment_order_detail_account_name'] ?>
										</td>
										<td>
											<?php echo $payment_order_detail_payment_nominal_indo ?>
										</td>
										<td>
										<?php
											if ($data_tbl_payment_order_detail['payment_order_detail_payment_due_date'] != "0000-00-00")
											{
										?>
											<?php echo $data_tbl_payment_order_detail['payment_order_detail_payment_due_date'] ?>
										<?php
											}
											else
											{
										?>
											-
										<?php
											}
										?>
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
	function form_paid_payment_order()
	{
		$tbl_payment_order = mysql_query("SELECT a.payment_order_id, b.payment_order_detail_id, c.payment_category_id, c.payment_category_name, d.sales_invoice_no, d.sales_invoice_date, e.sales_order_id, e.sales_order_overdue_day, f.sales_request_payment_method, f.sales_request_order_method, f.sales_request_product_sell_program_mix, g.user_name, h.customer_code, h.customer_name, i.customer_category_name, j.customer_districts_name FROM payment_order a, payment_order_detail b, payment_category c, sales_invoice d, sales_order e, sales_request f, user g, customer h, customer_category i, customer_districts j WHERE b.payment_order_detail_id = '".$_GET['payment_order_detail_id']."' AND a.payment_order_id = b.payment_order_id AND b.payment_category_id = c.payment_category_id AND a.sales_invoice_id = d.sales_invoice_id AND d.sales_order_id = e.sales_order_id AND e.sales_request_id = f.sales_request_id AND f.salesman_id = g.user_id AND f.customer_id = h.customer_id AND h.customer_category_id = i.customer_category_id AND h.customer_districts_id = j.customer_districts_id");
		$data_tbl_payment_order = mysql_fetch_array($tbl_payment_order);
		
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
							<?php echo $data_tbl_payment_order['user_name'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_payment_order['customer_category_name'] ?> - <?php echo $data_tbl_payment_order['customer_code'] ?> - <?php echo $data_tbl_payment_order['customer_name'] ?> (<?php echo $data_tbl_payment_order['customer_districts_name'] ?>)
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
						<?php
							if ($data_tbl_payment_order['sales_order_overdue_day'] == 0)
							{
						?>
							<?php echo $data_tbl_payment_order['sales_request_payment_method'] ?>
						<?php	
							}
							else
							{
						?>
							<?php echo $data_tbl_payment_order['sales_request_payment_method'] ?> (<?php echo $data_tbl_payment_order['sales_order_overdue_day'] ?> Hari)
						<?php	
							}
						?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_payment_order['sales_request_order_method'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							Program Mix Produk (<?php echo $data_tbl_payment_order['sales_request_product_sell_program_mix'] ?>)
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
							<form action="?alimms=payment-order&tib=paid-payment-order" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="payment_order_detail_id" type="hidden" value="<?php echo $data_tbl_payment_order['payment_order_detail_id'] ?>">
								<div class="form-body">
								<?php
									if ($data_tbl_payment_order['payment_category_name'] == "BG")
									{
								?>
									<h4 class="form-section">
										Transaksi Pembayaran - <?php echo $data_tbl_payment_order['payment_category_name'] ?>
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													No. BG
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="payment_order_detail_account_no" placeholder="No. BG" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Nama Bank
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="payment_order_detail_bank_name" placeholder="Nama Bank" type="text">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Atas Nama
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="payment_order_detail_account_name" placeholder="Atas Nama" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Nominal
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="payment_order_detail_payment_nominal" placeholder="Nominal" type="text" value="<?php echo $remaining_payment_nominal ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Jatuh Tempo
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="payment_order_detail_payment_due_date" placeholder="Jatuh Tempo" type="text">
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
								<?php
									}
									elseif ($data_tbl_payment_order['payment_category_name'] == "Cash")
									{
								?>
									<h4 class="form-section">
										Transaksi Pembayaran - <?php echo $data_tbl_payment_order['payment_category_name'] ?>
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
												<input class="form-control" name="payment_order_detail_payment_nominal" placeholder="Nominal" type="text" value="<?php echo $remaining_payment_nominal ?>">
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
								<?php
									}
									else
									{
								?>
									<h4 class="form-section">
										Transaksi Pembayaran - <?php echo $data_tbl_payment_order['payment_category_name'] ?>
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													No. Rekening
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="payment_order_detail_account_no" placeholder="No. Rekening" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Nama Bank
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="payment_order_detail_bank_name" placeholder="Nama Bank" type="text">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Atas Nama
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="payment_order_detail_account_name" placeholder="Atas Nama" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Nominal
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="payment_order_detail_payment_nominal" placeholder="Nominal" type="text" value="<?php echo $remaining_payment_nominal ?>">
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
								<?php
									}
								?>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=payment-order&tib=remove-payment-order&payment_order_detail_id=<?php echo $_GET['payment_order_detail_id'] ?>'">
										<i class="fa fa-times"></i>
										Batal
									</button>
								</div>
							</form>
						</div>
						<div class="portlet-body">
							<table class="table table-bordered table-checkable table-hover table-striped order-column" id="sample_2">
								<thead>
									<tr>
										<th>
											No
										</th>
										<th>
											Pembayaran
										</th>
										<th>
											No. BG/ Rekening
										</th>
										<th>
											Nama Bank
										</th>
										<th>
											Atas Nama
										</th>
										<th>
											Nominal
										</th>
										<th>
											Jatuh Tempo
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_payment_order_detail = mysql_query("SELECT a.payment_order_detail_payment_date, a.payment_order_detail_account_no, a.payment_order_detail_bank_name, a.payment_order_detail_account_name, a.payment_order_detail_payment_nominal, a.payment_order_detail_payment_due_date, b.payment_category_name FROM payment_order_detail a, payment_category b WHERE a.payment_order_id = '".$data_tbl_payment_order['payment_order_id']."' AND NOT a.payment_order_detail_payment_status = 'On Hold' AND a.payment_category_id = b.payment_category_id ORDER BY a.payment_order_detail_payment_date");
									while ($data_tbl_payment_order_detail = mysql_fetch_array($tbl_payment_order_detail))
									{
										$payment_order_detail_payment_date_indo = tanggal_indo($data_tbl_payment_order_detail['payment_order_detail_payment_date']);
										$payment_order_detail_payment_due_date_indo = tanggal_indo($data_tbl_payment_order_detail['payment_order_detail_payment_due_date']);
										$payment_order_detail_payment_nominal = format_angka($data_tbl_payment_order_detail['payment_order_detail_payment_nominal']);
								?>
									<tr class="odd gradeX">
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_payment_order_detail['payment_category_name'] ?><br />
											<?php echo $payment_order_detail_payment_date_indo ?>
										</td>
										<td>
											<?php echo $data_tbl_payment_order_detail['payment_order_detail_account_no'] ?>
										</td>
										<td>
											<?php echo $data_tbl_payment_order_detail['payment_order_detail_bank_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_payment_order_detail['payment_order_detail_account_name'] ?>
										</td>
										<td>
											<?php echo $payment_order_detail_payment_nominal ?>
										</td>
										<td>
										<?php
											if ($data_tbl_payment_order_detail['payment_order_detail_payment_due_date'] != "0000-00-00")
											{
										?>
											<?php echo $payment_order_detail_payment_due_date_indo ?>
										<?php
											}
											else
											{
										?>
											-
										<?php
											}
										?>
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
	function form_edit_payment_order()
	{
		$tbl_payment_order = mysql_query("SELECT payment_order_id, payment_order_date FROM payment_order WHERE payment_order_id = '".$_GET['payment_order_id']."'");
		$data_tbl_payment_order = mysql_fetch_array($tbl_payment_order);
		
		$salesinvoicedocumentDate = explode("-", $data_tbl_payment_order['payment_order_date']);
		$DatesalesinvoicedocumentDate = $salesinvoicedocumentDate[2];
		$MonthsalesinvoicedocumentDate = $salesinvoicedocumentDate[1];
		$YearsalesinvoicedocumentDate = $salesinvoicedocumentDate[0];
		$payment_order_date = date("d-m-Y", mktime(0, 0, 0, $MonthsalesinvoicedocumentDate, $DatesalesinvoicedocumentDate, $YearsalesinvoicedocumentDate));
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" id="form_sample_3" method="post" action="?alimms=payment-order&tib=edit-payment-order">
				<input type="hidden" class="form-control" name="payment_order_id" value="<?php echo $data_tbl_payment_order['payment_order_id'] ?>" />
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Dokumen Faktur Penjualan</span>
							</div>
							<div class="actions btn-set">
								<button type="submit" class="btn green-meadow"><i class="fa fa-pencil"></i> Ubah</button>
								<button type="button" class="btn red-sunglo" onclick="location.href='?alimms=payment-order'"><i class="fa fa-times"></i> Batal</button>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="alert alert-info no-margin">
											<h4 class="form-section">Informasi Dokumen Faktur Penjualan</h4>
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label">Tanggal <span class="required">*</span></label>
														<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="Tanggal" name="payment_order_date" value="<?php echo $payment_order_date ?>" />
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
<?php
	}
	function form_view_payment_order()
	{
		$tbl_payment_order = mysql_query("SELECT a.payment_order_id, b.sales_invoice_no, b.sales_invoice_date, c.sales_order_overdue_day, d.sales_request_payment_method, d.sales_request_order_method, d.sales_request_product_sell_program_mix, e.user_name, f.customer_code, f.customer_name, g.customer_category_name, h.customer_districts_name FROM payment_order a, sales_invoice b, sales_order c, sales_request d, user e, customer f, customer_category g, customer_districts h WHERE a.payment_order_id = '".$_GET['payment_order_id']."' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id = c.sales_order_id AND c.sales_request_id = d.sales_request_id AND d.salesman_id = e.user_id AND d.customer_id = f.customer_id AND f.customer_category_id = g.customer_category_id AND f.customer_districts_id = h.customer_districts_id");
		$data_tbl_payment_order = mysql_fetch_array($tbl_payment_order);
		
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
							<?php echo $data_tbl_payment_order['user_name'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_payment_order['customer_category_name'] ?> - <?php echo $data_tbl_payment_order['customer_code'] ?> - <?php echo $data_tbl_payment_order['customer_name'] ?> (<?php echo $data_tbl_payment_order['customer_districts_name'] ?>)
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
						<?php
							if ($data_tbl_payment_order['sales_order_overdue_day'] == 0)
							{
						?>
							<?php echo $data_tbl_payment_order['sales_request_payment_method'] ?>
						<?php	
							}
							else
							{
						?>
							<?php echo $data_tbl_payment_order['sales_request_payment_method'] ?> (<?php echo $data_tbl_payment_order['sales_order_overdue_day'] ?> Hari)
						<?php	
							}
						?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_payment_order['sales_request_order_method'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							Program Mix Produk (<?php echo $data_tbl_payment_order['sales_request_product_sell_program_mix'] ?>)
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
								<a class="btn btn-outline btn-sm sbold yellow" href="?alimms=payment-order">
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
											Pembayaran
										</th>
										<th>
											No. BG/ Rekening
										</th>
										<th>
											Nama Bank
										</th>
										<th>
											Atas Nama
										</th>
										<th>
											Nominal
										</th>
										<th>
											Jatuh Tempo
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_payment_order_detail = mysql_query("SELECT a.payment_order_detail_payment_date, a.payment_order_detail_account_no, a.payment_order_detail_bank_name, a.payment_order_detail_account_name, a.payment_order_detail_payment_nominal, a.payment_order_detail_payment_due_date, b.payment_category_name FROM payment_order_detail a, payment_category b WHERE a.payment_order_id = '".$data_tbl_payment_order['payment_order_id']."' AND NOT a.payment_order_detail_payment_status = 'On Hold' AND a.payment_category_id = b.payment_category_id ORDER BY a.payment_order_detail_payment_date");
									while ($data_tbl_payment_order_detail = mysql_fetch_array($tbl_payment_order_detail))
									{
										$payment_order_detail_payment_date_indo = tanggal_indo($data_tbl_payment_order_detail['payment_order_detail_payment_date']);
										$payment_order_detail_payment_due_date_indo = tanggal_indo($data_tbl_payment_order_detail['payment_order_detail_payment_due_date']);
										
										$payment_order_detail_payment_nominal_indo = format_angka($data_tbl_payment_order_detail['payment_order_detail_payment_nominal']);
								?>
									<tr class="odd gradeX">
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_payment_order_detail['payment_category_name'] ?><br />
											<?php echo $payment_order_detail_payment_date_indo ?>
										</td>
										<td>
										<?php
											if ($data_tbl_payment_order_detail['payment_order_detail_account_no'] != "")
											{
										?>
											<?php echo $data_tbl_payment_order_detail['payment_order_detail_account_no'] ?>
										<?php
											}
											else
											{
										?>
											-
										<?php
											}
										?>
										</td>
										<td>
										<?php
											if ($data_tbl_payment_order_detail['payment_order_detail_bank_name'] != "")
											{
										?>
											<?php echo $data_tbl_payment_order_detail['payment_order_detail_bank_name'] ?>
										<?php
											}
											else
											{
										?>
											-
										<?php
											}
										?>
										</td>
										<td>
										<?php
											if ($data_tbl_payment_order_detail['payment_order_detail_account_name'] != "")
											{
										?>
											<?php echo $data_tbl_payment_order_detail['payment_order_detail_account_name'] ?>
										<?php
											}
											else
											{
										?>
											-
										<?php
											}
										?>
										</td>
										<td>
											<?php echo $payment_order_detail_payment_nominal_indo ?>
										</td>
										<td>
										<?php
											if ($data_tbl_payment_order_detail['payment_order_detail_payment_due_date'] != "0000-00-00")
											{
										?>
											<?php echo $data_tbl_payment_order_detail['payment_order_detail_payment_due_date'] ?>
										<?php
											}
											else
											{
										?>
											-
										<?php
											}
										?>
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
?>