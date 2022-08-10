<?php
	function form_initial_payment_request()
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
									$tbl_sales_invoice = mysql_query("SELECT * FROM sales_invoice a, sales_order b, sales_request c, customer d, customer_category e, customer_districts f, user g WHERE a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.sales_request_payment_method = 'Credit' AND a.sales_invoice_status = 'Posted' AND c.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id AND c.salesman_id = g.user_id");
									while ($data_tbl_sales_invoice = mysql_fetch_array($tbl_sales_invoice))
									{
										$sales_invoice_date_indo = tanggal_indo($data_tbl_sales_invoice['sales_invoice_date']);
										
										$tbl_sales_order_detail = mysql_query("SELECT SUM((sales_order_detail_product_sell_quantity * (sales_order_detail_product_sell_price - sales_order_detail_piece_discount - sales_order_detail_cash_discount)) + ((sales_order_detail_product_sell_quantity + sales_order_detail_program_bonus) * sales_order_detail_delivery_cost_price)) AS product_sell_total FROM sales_order_detail WHERE sales_order_id = '".$data_tbl_sales_invoice['sales_order_id']."'");
										$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
										
										$product_sell_total_indo = format_angka($data_tbl_sales_order_detail['product_sell_total']);
										
										$tbl_payment_request_detail = mysql_query("SELECT SUM(b.payment_request_detail_payment_nominal) AS payment_request_detail_payment_nominal FROM payment_request a, payment_request_detail b WHERE a.payment_request_id = b.payment_request_id AND a.sales_invoice_id = '".$data_tbl_sales_invoice['sales_invoice_id']."'");
										$data_tbl_payment_request_detail = mysql_fetch_array($tbl_payment_request_detail);
										
										$payment_order_detail_payment_nominal_indo = format_angka($data_tbl_payment_request_detail['payment_request_detail_payment_nominal']);
										
										$tbl_payment_request = mysql_query("SELECT * FROM payment_request WHERE sales_invoice_id = '".$data_tbl_sales_invoice['sales_invoice_id']."'");
										$data_tbl_payment_request = mysql_fetch_array($tbl_payment_request);
								?>
									<tr class="odd gradeX">
										<td>
										<?php
											if ($data_tbl_payment_request['payment_request_status'] == "Paid")
											{
										?>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=payment-request&tib=form-view-payment-request&payment_request_id=<?php echo $data_tbl_payment_request['payment_request_id'] ?>">
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
											<a class="btn btn-icon-only btn-outline purple tooltips" data-original-title="Proses" data-toggle="modal" href="#add_payment_order_id_<?php echo $data_tbl_sales_invoice['sales_invoice_id'] ?>">
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
											<?php echo $data_tbl_sales_invoice['sales_invoice_no'] ?><br />
											<?php echo $sales_invoice_date_indo ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_invoice['user_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_invoice['customer_category_name'] ?> - 
											<?php echo $data_tbl_sales_invoice['customer_code'] ?> - <?php echo $data_tbl_sales_invoice['customer_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_invoice['customer_districts_name'] ?>
										</td>
										<td>
											<?php echo $product_sell_total_indo ?>
										</td>
										<td>
											<?php echo $payment_order_detail_payment_nominal_indo ?>
										</td>
										<td>
										<?php
											if ($data_tbl_payment_request['payment_request_status'] == "Paid")
											{
										?>
											<span class="label label-success label-sm">Paid</span>
											
										<?php
											}
											elseif ($data_tbl_payment_request['payment_request_status'] == "Unpaid")
											{
										?>
											<span class="label label-danger label-sm">Unpaid</span>
										<?php
											}
											else
											{
										?>
											<span class="label label-info label-sm">Call</span>
										<?php
											}
										?>
										</td>
									</tr>
									<div aria-hidden="true" class="modal fade" id="add_payment_order_id_<?php echo $data_tbl_sales_invoice['sales_invoice_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=payment-request&tib=form-add-payment-request&sales_invoice_id=<?php echo $data_tbl_sales_invoice['sales_invoice_id'] ?>">
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
	function form_add_payment_request()
	{
		$tbl_payment_order = mysql_query("SELECT a.payment_order_id, b.sales_invoice_no, b.sales_invoice_date, c.sales_order_overdue_day, d.sales_request_payment_method, d.sales_request_order_method, d.sales_request_product_sell_program_mix, e.user_name, f.customer_code, f.customer_name, g.customer_category_name, h.customer_districts_name FROM payment_order a, sales_invoice b, sales_order c, sales_request d, user e, customer f, customer_category g, customer_districts h WHERE a.payment_order_id = '".$_GET['payment_order_id']."' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id = c.sales_order_id AND c.sales_request_id = d.sales_request_id AND d.salesman_id = e.user_id AND d.customer_id = f.customer_id AND f.customer_category_id = g.customer_category_id AND f.customer_districts_id = h.customer_districts_id");
		$data_tbl_payment_order = mysql_fetch_array($tbl_payment_order);
		
		$sales_invoice_date_indo = tanggal_indo($data_tbl_payment_order['sales_invoice_date']);
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
						<div class="portlet-body form">
							<form action="?alimms=payment-request&tib=add-payment-request" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="sales_invoice_id" type="hidden" value="<?php echo $_GET['sales_invoice_id'] ?>">
								<div class="form-body">
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
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="payment_request_detail_payment_date" placeholder="Tanggal Dibayarkan" type="text" value="<?php echo $tgl_sekarang ?>">
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
	function form_paid_payment_request()
	{
		$tbl_payment_order = mysql_query("SELECT * FROM payment_request a, sales_invoice b, sales_order c, payment_request_detail d, payment_category e WHERE a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id = c.sales_order_id AND a.payment_request_id = d.payment_request_id AND d.payment_request_detail_id = '".$_GET['payment_request_detail_id']."' AND d.payment_category_id = e.payment_category_id");
		$data_tbl_payment_order = mysql_fetch_array($tbl_payment_order);
		
		$sales_invoice_date_indo = tanggal_indo($data_tbl_payment_order['sales_invoice_date']);
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
									$tbl_payment_order_detail = mysql_query("SELECT SUM(payment_request_detail_payment_nominal) AS payment_request_detail_payment_nominal FROM payment_request_detail WHERE payment_request_id = '".$data_tbl_payment_order['payment_request_id']."'");
									$data_tbl_payment_order_detail = mysql_fetch_array($tbl_payment_order_detail);
									
									$payment_order_detail_payment_nominal_indo = format_angka($data_tbl_payment_order_detail['payment_request_detail_payment_nominal']);
								?>
									<div class="col-md-4 bg-grey mt-step-col active">
										<div class="mt-step-number bg-white font-grey">Q</div>
										<div class="mt-step-title uppercase font-grey-cascade"><?php echo $payment_order_detail_payment_nominal_indo ?></div>
										<div class="mt-step-content font-grey-cascade">Jumlah Terbayar</div>
									</div>
								<?php
									$remaining_payment_nominal = $data_tbl_sales_order_detail['product_sell_total'] - $data_tbl_payment_order_detail['payment_request_detail_payment_nominal'];
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
							<form action="?alimms=payment-request&tib=paid-payment-request" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="payment_request_detail_id" type="hidden" value="<?php echo $_GET['payment_request_detail_id'] ?>">
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
												<input class="form-control" name="payment_request_detail_account_no" placeholder="No. BG" type="text">
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
												<input class="form-control" name="payment_request_detail_bank_name" placeholder="Nama Bank" type="text">
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
												<input class="form-control" name="payment_request_detail_account_name" placeholder="Atas Nama" type="text">
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
												<input class="form-control" name="payment_request_detail_payment_nominal" placeholder="Nominal" type="text" value="<?php echo $remaining_payment_nominal ?>">
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
												<input class="form-control" name="payment_request_detail_payment_nominal" placeholder="Nominal" type="text" value="<?php echo $remaining_payment_nominal ?>">
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
												<input class="form-control" name="payment_request_detail_account_no" placeholder="No. Rekening" type="text">
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
												<input class="form-control" name="payment_request_detail_bank_name" placeholder="Nama Bank" type="text">
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
												<input class="form-control" name="payment_request_detail_account_name" placeholder="Atas Nama" type="text">
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
												<input class="form-control" name="payment_request_detail_payment_nominal" placeholder="Nominal" type="text" value="<?php echo $remaining_payment_nominal ?>">
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
												<input class="form-control" name="payment_request_detail_payment_description" placeholder="Keterangan" type="text">
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
					</div>
				</div>
			</div>
		</div>
<?php
	}
	function form_edit_payment_request()
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
	function form_view_payment_request()
	{
		$tbl_payment_order = mysql_query("SELECT a.payment_order_id, b.sales_invoice_no, b.sales_invoice_date, c.sales_order_overdue_day, d.sales_request_payment_method, d.sales_request_order_method, d.sales_request_product_sell_program_mix, e.user_name, f.customer_code, f.customer_name, g.customer_category_name, h.customer_districts_name FROM payment_order a, sales_invoice b, sales_order c, sales_request d, user e, customer f, customer_category g, customer_districts h WHERE a.payment_order_id = '".$_GET['payment_order_id']."' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id = c.sales_order_id AND c.sales_request_id = d.sales_request_id AND d.salesman_id = e.user_id AND d.customer_id = f.customer_id AND f.customer_category_id = g.customer_category_id AND f.customer_districts_id = h.customer_districts_id");
		$data_tbl_payment_order = mysql_fetch_array($tbl_payment_order);
		
		$sales_invoice_date_indo = tanggal_indo($data_tbl_payment_order['sales_invoice_date']);
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
							<div class="actions">
								<a class="btn btn-outline btn-sm sbold yellow" href="?alimms=payment-request">
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
											Kategori Pembayaran
										</th>
										<th>
											Tanggal Pembayaran
										</th>
										<th>
											Nominal
										</th>
										<th>
											Keterangan
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_payment_request_detail = mysql_query("SELECT * FROM payment_request_detail a, payment_category b WHERE a.payment_category_id = b.payment_category_id AND a.payment_request_id = '".$_GET['payment_request_id']."'");
									while ($data_tbl_payment_request_detail = mysql_fetch_array($tbl_payment_request_detail))
									{
										$payment_request_detail_payment_date_indo = tanggal_indo($data_tbl_payment_request_detail['payment_request_detail_payment_date']);
										
										$payment_request_detail_payment_nominal_indo = format_angka($data_tbl_payment_request_detail['payment_request_detail_payment_nominal']);
								?>
									<tr class="odd gradeX">
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_payment_request_detail['payment_category_name'] ?>
										</td>
										<td>
										<?php
											echo $payment_request_detail_payment_date_indo;
										?>
										</td>
										<td>
											<?php echo $payment_request_detail_payment_nominal_indo ?>
										</td>
										<td>
										<?php
											echo $data_tbl_payment_request_detail['payment_request_detail_description'];
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