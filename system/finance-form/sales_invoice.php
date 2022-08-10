<?php
	function form_initial_sales_invoice()
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
									Faktur Penjualan
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
											Permintaan
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
											Jadwal Pengiriman
										</th>
										<th>
											Cara Pembayaran
										</th>
										<th>
											Cara Pesanan
										</th>
										<th>
											Program Mix Produk
										</th>
										<th>
											Status
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_sales_invoice = mysql_query("SELECT a.sales_invoice_id, a.sales_invoice_no, a.sales_invoice_date, a.sales_invoice_status, a.sales_invoice_description, b.sales_order_overdue_day, c.sales_request_no, c.sales_request_date, c.sales_request_delivery_schedule_date, c.sales_request_payment_method, c.sales_request_order_method, c.sales_request_product_sell_program_mix, d.user_name, e.customer_code, e.customer_name, f.customer_category_name, g.customer_districts_name FROM sales_invoice a, sales_order b, sales_request c, user d, customer e, customer_category f, customer_districts g WHERE a.sales_invoice_status = 'On Hold' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.salesman_id = d.user_id AND c.customer_id = e.customer_id AND e.customer_category_id = f.customer_category_id AND e.customer_districts_id = g.customer_districts_id ORDER BY c.sales_request_date desc");
									while ($data_tbl_sales_invoice = mysql_fetch_array($tbl_sales_invoice))
									{
										$sales_request_date_indo = tanggal_indo($data_tbl_sales_invoice['sales_request_date']);
										$sales_request_delivery_schedule_date_indo = tanggal_indo($data_tbl_sales_invoice['sales_request_delivery_schedule_date']);
										$sales_invoice_date_indo = tanggal_indo($data_tbl_sales_invoice['sales_invoice_date']);
								?>
									<tr class="odd gradeX">
										<td>
										<?php
											if ($data_tbl_sales_invoice['sales_invoice_status'] == "Posted" || $data_tbl_sales_invoice['sales_invoice_status'] == "Canceled")
											{
										?>
											<a class="btn btn-icon-only btn-outline purple tooltips" data-original-title="Cetak" data-toggle="modal" href="#print_sales_invoice_id_<?php echo $data_tbl_sales_invoice['sales_invoice_id'] ?>">
												<i class="fa fa-print"></i>
											</a>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=sales-invoice&tib=form-view-sales-invoice&sales_invoice_id=<?php echo $data_tbl_sales_invoice['sales_invoice_id'] ?>">
												<i class="fa fa-search"></i>
											</a>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=sales-invoice&tib=form-edit-sales-invoice&sales_invoice_id=<?php echo $data_tbl_sales_invoice['sales_invoice_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
										<?php
											}
											else
											{
										?>
											<a class="btn btn-icon-only btn-outline purple tooltips" data-original-title="Proses" data-toggle="modal" href="#invoicing_sales_invoice_id_<?php echo $data_tbl_sales_invoice['sales_invoice_id'] ?>">
												<i class="fa fa-rss"></i>
											</a>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=sales-invoice&tib=form-view-sales-invoice&sales_invoice_id=<?php echo $data_tbl_sales_invoice['sales_invoice_id'] ?>">
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
										<?php
											if ($data_tbl_sales_invoice['sales_invoice_status'] == "On Hold")
											{
										?>
											<span class="label label-info label-sm">On Hold</span>
										<?php
											}
											elseif ($data_tbl_sales_invoice['sales_invoice_status'] == "Posted")
											{
										?>
											<?php echo $data_tbl_sales_invoice['sales_invoice_no'] ?><br />
											<?php echo $sales_invoice_date_indo ?>
										<?php
											}
											else
											{
												if ($data_tbl_sales_invoice['sales_invoice_no'] != "")
												{
										?>
												<?php echo $data_tbl_sales_invoice['sales_invoice_no'] ?><br />
												<?php echo $sales_invoice_date_indo ?>
										<?php
												}
												else
												{
										?>
												-
										<?php
												}
											}
										?>
										</td>
										<td>
											<?php echo $data_tbl_sales_invoice['sales_request_no'] ?><br />
											<?php echo $sales_request_date_indo ?>
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
											<?php echo $sales_request_delivery_schedule_date_indo ?>
										</td>
										<td>
										<?php
											if ($data_tbl_sales_invoice['sales_order_overdue_day'] == 0)
											{
										?>
											<?php echo $data_tbl_sales_invoice['sales_request_payment_method'] ?>
										<?php
											}
											else
											{
										?>
											<?php echo $data_tbl_sales_invoice['sales_request_payment_method'] ?> (<?php echo $data_tbl_sales_invoice['sales_order_overdue_day'] ?> Hari)
										<?php	
											}
										?>
										</td>
										<td>
											<?php echo $data_tbl_sales_invoice['sales_request_order_method'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_invoice['sales_request_product_sell_program_mix'] ?>
										</td>
										<td>
										<?php
											if ($data_tbl_sales_invoice['sales_invoice_status'] == "On Hold")
											{
										?>
											<span class="label label-info label-sm">On Hold</span>
										<?php
											}
											elseif ($data_tbl_sales_invoice['sales_invoice_status'] == "Posted")
											{
										?>
											<span class="label label-success label-sm">Posted</span>
										<?php
											}
											else
											{
										?>
											<span class="label label-danger label-sm">Canceled</span><br />
											<?php echo $data_tbl_sales_invoice['sales_invoice_description'] ?>
										<?php
											}
										?>
										</td>
									</tr>
									<div aria-hidden="true" class="modal fade" id="invoicing_sales_invoice_id_<?php echo $data_tbl_sales_invoice['sales_invoice_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=sales-invoice&tib=form-invoicing-sales-invoice&sales_invoice_id=<?php echo $data_tbl_sales_invoice['sales_invoice_id'] ?>">
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
									<div aria-hidden="true" class="modal fade" id="print_sales_invoice_id_<?php echo $data_tbl_sales_invoice['sales_invoice_id'] ?>" role="basic" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">
														Konfirmasi
													</h4>
                                                </div>
                                                <div class="modal-body">
													Apakah Anda Yakin Ingin Mencetak Data Ini ?
												</div>
                                                <div class="modal-footer">
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=sales-invoice&tib=form-print-sales-invoice&sales_invoice_id=<?php echo $data_tbl_sales_invoice['sales_invoice_id'] ?>">
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
	function form_invoicing_sales_invoice()
	{
		$tgl_sekarang = date("d-m-Y");
		
		$tbl_sales_invoice = mysql_query("SELECT a.sales_invoice_id, b.sales_order_id, b.sales_order_overdue_day, c.sales_request_no, c.sales_request_date, c.sales_request_payment_method, c.sales_request_order_method, c.sales_request_product_sell_program_mix, d.user_name, e.customer_id, e.customer_code, e.customer_name, f.customer_category_name, g.customer_districts_name FROM sales_invoice a, sales_order b, sales_request c, user d, customer e, customer_category f, customer_districts g WHERE a.sales_invoice_id = '".$_GET['sales_invoice_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.salesman_id = d.user_id AND c.customer_id = e.customer_id AND e.customer_category_id = f.customer_category_id AND e.customer_districts_id = g.customer_districts_id");
		$data_tbl_sales_invoice = mysql_fetch_array($tbl_sales_invoice);
		
		$sales_request_date_indo = tanggal_indo($data_tbl_sales_invoice['sales_request_date']);
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_sales_invoice['sales_request_no'] ?>
					<small>
						<?php echo $sales_request_date_indo ?>
					</small>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_invoice['user_name'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_invoice['customer_category_name'] ?> - <?php echo $data_tbl_sales_invoice['customer_code'] ?> - <?php echo $data_tbl_sales_invoice['customer_name'] ?> (<?php echo $data_tbl_sales_invoice['customer_districts_name'] ?>)
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
						<?php
							if ($data_tbl_sales_invoice['sales_order_overdue_day'] == 0)
							{
						?>
							<?php echo $data_tbl_sales_invoice['sales_request_payment_method'] ?>
						<?php	
							}
							else
							{
						?>
							<?php echo $data_tbl_sales_invoice['sales_request_payment_method'] ?> (<?php echo $data_tbl_sales_invoice['sales_order_overdue_day'] ?> Hari)
						<?php	
							}
						?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_invoice['sales_request_order_method'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							Program Mix Produk (<?php echo $data_tbl_sales_invoice['sales_request_product_sell_program_mix'] ?>)
						</a>
					</li>
				</ul>
			</div>
			<div class="row">
			<?php
				$tbl_product_sell = mysql_query("SELECT product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
				while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
				{
			?>
				<div class="col-lg-4">
					<div class="bordered dashboard-stat2">
						<div class="display">
							<div class="number">
								<small class="font-red">
									STOK <?php echo $data_tbl_product_sell['product_sell_name'] ?>
								</small>
								<h3 class="font-red">
									<span>
										777
									</span>
								</h3>
							</div>
							<div class="icon">
								<i class="icon-briefcase"></i>
							</div>
						</div>
					</div>
				</div>
			<?php
				}
			?>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Faktur Penjualan
								</span>
							</div>
						</div>
						<div class="portlet-body form">
							<form action="?alimms=sales-invoice&tib=invoicing-sales-invoice" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="sales_invoice_id" type="hidden" value="<?php echo $data_tbl_sales_invoice['sales_invoice_id'] ?>">
							<input class="form-control" name="sales_order_overdue_day" type="hidden" value="<?php echo $data_tbl_sales_invoice['sales_order_overdue_day'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Status Faktur
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Status Faktur
													<span class="required">
														*
													</span>
												</label>
												<div class="radio-list" data-error-container="#sales_invoice_status">
													<label class="radio-inline">
														<input name="sales_invoice_status" type="radio" value="Posted">
															Posted
													</label>
													<label class="radio-inline">
														<input name="sales_invoice_status" type="radio" value="Canceled">
															Canceled
													</label>
												</div>
												<div id="sales_invoice_status"></div>
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
												<input class="form-control" name="sales_invoice_description" placeholder="Keterangan" type="text">
												<span class="help-block">
													*) Jika Status Posted, Keterangan Dikosongkan
												</span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Tanggal Difakturkan
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_date" placeholder="Tanggal Difakturkan" type="text" value="<?php echo $tgl_sekarang ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=sales-invoice'">
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
									$tbl_sales_order_detail = mysql_query("SELECT a.sales_order_detail_product_sell_quantity, a.sales_order_detail_product_sell_price, a.sales_order_detail_program_bonus, a.sales_order_detail_piece_discount, a.sales_order_detail_cash_discount, a.sales_order_detail_delivery_cost_price, b.product_sell_name FROM sales_order_detail a, product_sell b WHERE a.sales_order_id = '".$data_tbl_sales_invoice['sales_order_id']."' AND a.product_sell_id = b.product_sell_id ORDER BY b.product_sell_code");
									while ($data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail))
									{
										$sales_order_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity']);
										$sales_order_detail_product_sell_price_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_price']);
										$sales_order_detail_piece_discount_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_piece_discount']);
										$sales_order_detail_cash_discount = ($data_tbl_sales_order_detail['sales_order_detail_cash_discount'] / $data_tbl_sales_order_detail['sales_order_detail_product_sell_price']) * 100;
										$sales_order_detail_delivery_cost_price_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_delivery_cost_price']);
										$product_sell_sub_total_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity'] * ($data_tbl_sales_order_detail['sales_order_detail_product_sell_price'] - $data_tbl_sales_order_detail['sales_order_detail_piece_discount'] - $data_tbl_sales_order_detail['sales_order_detail_cash_discount'] + $data_tbl_sales_order_detail['sales_order_detail_delivery_cost_price']));
								?>
									<tr class="odd gradeX">
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_order_detail['product_sell_name'] ?>
										</td>
										<td>
											<?php echo $sales_order_detail_product_sell_quantity_indo ?>
										</td>
										<td>
											<?php echo $sales_order_detail_product_sell_price_indo ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_order_detail['sales_order_detail_program_bonus'] ?>
										</td>
										<td>
											<?php echo $sales_order_detail_piece_discount_indo ?>
										</td>
										<td>
											<?php echo $sales_order_detail_cash_discount ?>
										</td>
										<td>
											<?php echo $sales_order_detail_delivery_cost_price_indo ?>
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
				<div class="col-md-4">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Pesanan Pembayaran
								</span>
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-responsive">
								<table class="table table-bordered table-hover table-striped">
									<thead>
										<tr>
											<th>
												No
											</th>
											<th>
												Faktur
											</th>
											<th>
												Sisa Pembayaran
											</th>
											<th>
												Status
											</th>
										</tr>
									</thead>
									<tbody>
									<?php
										$no = 1;
										$tbl_payment_order = mysql_query("SELECT a.payment_order_id, a.payment_order_status, b.sales_invoice_no, b.sales_invoice_date, c.sales_order_id FROM payment_order a, sales_invoice b, sales_order c, sales_request d WHERE a.payment_order_status = 'Unpaid' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id= c.sales_order_id AND c.sales_request_id = d.sales_request_id AND b.sales_invoice_status = 'Posted' AND d.sales_request_active = '1' AND d.customer_id = '".$data_tbl_sales_invoice['customer_id']."' ORDER BY b.sales_invoice_no");
										while ($data_tbl_payment_order = mysql_fetch_array($tbl_payment_order))
										{
											$sales_invoice_date_indo = tanggal_indo($data_tbl_payment_order['sales_invoice_date']);
											
											$tbl_sales_order_detail = mysql_query("SELECT SUM((sales_order_detail_product_sell_quantity * (sales_order_detail_product_sell_price - sales_order_detail_piece_discount - sales_order_detail_cash_discount)) + ((sales_order_detail_product_sell_quantity + sales_order_detail_program_bonus) * sales_order_detail_delivery_cost_price)) AS product_sell_total FROM sales_order_detail WHERE sales_order_id = '".$data_tbl_payment_order['sales_order_id']."'");
											$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
										
											$product_sell_total_indo = format_angka($data_tbl_sales_order_detail['product_sell_total']);
	
											$tbl_payment_order_detail = mysql_query("SELECT SUM(payment_order_detail_payment_nominal) AS payment_order_detail_payment_nominal FROM payment_order_detail WHERE payment_order_id = '".$data_tbl_payment_order['payment_order_id']."'");
											$data_tbl_payment_order_detail = mysql_fetch_array($tbl_payment_order_detail);
											
											$payment_order_detail_payment_nominal_indo = format_angka($data_tbl_payment_order_detail['payment_order_detail_payment_nominal']);
																		
											$remaining_payment_nominal = $data_tbl_sales_order_detail['product_sell_total'] - $data_tbl_payment_order_detail['payment_order_detail_payment_nominal'];
											$remaining_payment_nominal_rupiah_indo = format_angka($remaining_payment_nominal);
									?>
										<tr>
											<td>
												<?php echo $no ?>
											</td>
											<td>
												<?php echo $data_tbl_payment_order['sales_invoice_no'] ?><br />
												<?php echo $sales_invoice_date_indo ?>
											</td>
											<td>
												<?php echo $remaining_payment_nominal_rupiah_indo ?>
											</td>
											<td>
											<?php
												if ($data_tbl_payment_order['payment_order_status'] == "Paid")
												{
											?>
												<span class="label label-success label-sm">
													Paid
												</span>
											<?php
												}
												else
												{
											?>
												<span class="label label-danger label-sm">
													Unpaid
												</span>
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
		</div>
<?php
	}
	function form_print_sales_invoice()
	{
		$tbl_sales_invoice = mysql_query("SELECT a.sales_invoice_id, a.sales_invoice_no, a.sales_invoice_date, a.sales_invoice_overdue_date, b.sales_order_id, c.sales_request_no, c.sales_request_payment_method, d.user_name, e.customer_code, e.customer_name, e.customer_address, e.customer_contact, e.customer_phone, f.customer_districts_name FROM sales_invoice a, sales_order b, sales_request c, user d, customer e, customer_districts f WHERE a.sales_invoice_id = '".$_GET['sales_invoice_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.salesman_id = d.user_id AND c.customer_id = e.customer_id AND e.customer_districts_id = f.customer_districts_id");
		$data_tbl_sales_invoice = mysql_fetch_array($tbl_sales_invoice);
		
		$sales_invoice_date_indo = tanggal_indo($data_tbl_sales_invoice['sales_invoice_date']);
		$sales_invoice_overdue_date_indo = tanggal_indo($data_tbl_sales_invoice['sales_invoice_overdue_date']);
?>
		<div class="page-fixed-main-content">
			<div class="invoice">
				<div class="row invoice-logo">
					<div class="col-xs-6 invoice-logo-space">
						<img src="../assets/pages/media/invoice/walmart.png" class="img-responsive" alt=""/>
					</div>
					<div class="col-xs-6">
						<p>
							FAKTUR PENJUALAN
						</p>
					</div>
				</div>
				<hr/>
				<div class="row">
					<div class="col-xs-4">
						<h3>
							Kepada Yth :
						</h3>
						<ul class="list-unstyled">
							<li>
								<?php echo $data_tbl_sales_invoice['customer_code'] ?> - <?php echo $data_tbl_sales_invoice['customer_name'] ?>
							</li>
							<li>
								<?php echo $data_tbl_sales_invoice['customer_address'] ?>
							</li>
							<li>
								<?php echo $data_tbl_sales_invoice['customer_districts_name'] ?>
							</li>
							<li>
								Kontak : <?php echo $data_tbl_sales_invoice['customer_contact'] ?>
							</li>
							<li>
								No. Telepon : <?php echo $data_tbl_sales_invoice['customer_phone'] ?>
							</li>
						</ul>
					</div>
					<div class="col-xs-4">
						<h3>
							Pengirim :
						</h3>
						<ul class="list-unstyled">
							<li>
								Al Qodiri
							</li>
							<li>
								Jl. Cendrawasih No. 9
							</li>
							<li>
								Jember
							</li>
							<li>
								Jawa Timur 68131
							</li>
							<li>
								Telp. / Fax : 0331-413589
							</li>
						</ul>
					</div>
					<div class="col-xs-4 invoice-payment">
						<h3>
							Pesanan :
						</h3>
						<ul class="list-unstyled">
							<li>
								<strong>
									No. Faktur :
								</strong>
								<?php echo $data_tbl_sales_invoice['sales_invoice_no'] ?>
							</li>
							<li>
								<strong>
									Tgl. Faktur :
								</strong>
								<?php echo $sales_invoice_date_indo ?>
							</li>
							<li>
								<strong>
									Tgl. Jatuh Tempo :
								</strong>
								<?php echo $sales_invoice_overdue_date_indo ?>
							</li>
							<li>
								<strong>
									No. Referensi :
								</strong>
								<?php echo $data_tbl_sales_invoice['sales_request_no'] ?>
							</li>
							<li>
								<strong>
									Salesman :
								</strong>
								<?php echo $data_tbl_sales_invoice['user_name'] ?>
							</li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th>
										Kode
									</th>
									<th>
										Nama Barang
									</th>
									<th>
										Qty
									</th>
									<th>
										Harga Satuan
									</th>
									<th>
										Diskon
									</th>
									<th>
										Jumlah
									</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$tbl_sales_order_detail = mysql_query("SELECT a.sales_order_detail_product_sell_quantity, a.sales_order_detail_product_sell_price, a.sales_order_detail_program_bonus, a.sales_order_detail_cash_discount, a.sales_order_detail_delivery_cost_price, b.product_sell_code, b.product_sell_name, c.product_unit_name FROM sales_order_detail a, product_sell b, product_unit c WHERE a.sales_order_id = '".$data_tbl_sales_invoice['sales_order_id']."' AND a.product_sell_id = b.product_sell_id AND b.product_unit_id = c.product_unit_id ORDER BY b.product_sell_code");
								while ($data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail))
								{
									$sales_order_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity']);
									$sales_order_detail_product_sell_price_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_price']);
									$sales_order_detail_program_bonus_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_program_bonus']);
									$sales_order_detail_cash_discount = ($data_tbl_sales_order_detail['sales_order_detail_cash_discount'] / $data_tbl_sales_order_detail['sales_order_detail_product_sell_price']) * 100;
									$sales_order_detail_delivery_cost_price_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_delivery_cost_price']);
									$product_sell_sub_total_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity'] * ($data_tbl_sales_order_detail['sales_order_detail_product_sell_price'] - $data_tbl_sales_order_detail['sales_order_detail_piece_discount'] - $data_tbl_sales_order_detail['sales_order_detail_cash_discount'] + $data_tbl_sales_order_detail['sales_order_detail_delivery_cost_price']));
							?>
								<tr>
									<td>
										<?php echo $data_tbl_sales_order_detail['product_sell_code'] ?>
									</td>
									<td>
										<?php echo $data_tbl_sales_order_detail['product_sell_name'] ?>
									</td>
									<td>
										<?php echo $sales_order_detail_product_sell_quantity_indo ?> <?php echo $data_tbl_sales_order_detail['product_unit_name'] ?>
									</td>
									<td>
										<?php echo $sales_order_detail_product_sell_price_indo ?>
									</td>
									<td>
										<?php echo $sales_order_detail_cash_discount ?>
									</td>
									<td>
										<?php echo $product_sell_sub_total_indo ?>
									</td>
									<?php
										if ($data_tbl_sales_order_detail['sales_order_detail_program_bonus'] != "0")
										{
									?>
										<tr>
											<td>
												<?php echo $data_tbl_sales_order_detail['product_sell_code'] ?>
											</td>
											<td>
												(Bonus) <?php echo $data_tbl_sales_order_detail['product_sell_name'] ?> <?php echo $data_tbl_sales_order_detail['product_unit_name'] ?>
											</td>
											<td>
												<?php echo $sales_order_detail_program_bonus_indo ?>
											</td>
											<td>
												0
											</td>
											<td>
												0
											</td>
											<td>
												0
											</td>
										</tr>
									<?php
										}
									?>
								</tr>
							<?php
								}
							?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<div class="well">
							<address>
								<strong>
									Harga Netto
								</strong>
								<br/>
								<br/>
								<?php
									$tbl_sales_order_detail = mysql_query("SELECT a.sales_order_detail_product_sell_quantity, a.sales_order_detail_product_sell_price, a.sales_order_detail_program_bonus, a.sales_order_detail_cash_discount, b.product_sell_name FROM sales_order_detail a, product_sell b WHERE a.sales_order_id = '".$data_tbl_sales_invoice['sales_order_id']."' AND a.product_sell_id = b.product_sell_id ORDER BY b.product_sell_code");
									while ($data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail))
									{
										$sales_order_detail_cash_discount = ($data_tbl_sales_order_detail['sales_order_detail_cash_discount'] / $data_tbl_sales_order_detail['sales_order_detail_product_sell_price']) * 100;
										$product_sell_netto_indo = format_angka(($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity'] * $data_tbl_sales_order_detail['sales_order_detail_product_sell_price']) / ($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity'] + $data_tbl_sales_order_detail['sales_order_detail_program_bonus']));
								?>
									<?php echo $data_tbl_sales_order_detail['product_sell_name'] ?> : <strong><?php echo $product_sell_netto_indo ?></strong>
									<br />
								<?php
									}
								?>
							</address>
						</div>
					</div>
					<div class="col-xs-8 invoice-block">
						<ul class="list-unstyled amounts">
						<?php
							$tbl_sales_order_detail = mysql_query("SELECT SUM(sales_order_detail_product_sell_quantity * (sales_order_detail_product_sell_price - sales_order_detail_piece_discount - sales_order_detail_cash_discount)) AS product_sell_sub_total, SUM((sales_order_detail_product_sell_quantity + sales_order_detail_program_bonus) * sales_order_detail_delivery_cost_price) AS delivery_cost_price, SUM((sales_order_detail_product_sell_quantity * (sales_order_detail_product_sell_price - sales_order_detail_piece_discount - sales_order_detail_cash_discount)) + ((sales_order_detail_product_sell_quantity + sales_order_detail_program_bonus) * sales_order_detail_delivery_cost_price)) AS product_sell_total FROM sales_order_detail WHERE sales_order_id = '".$data_tbl_sales_invoice['sales_order_id']."'");
							$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
							
							$sub_total_price_indo = format_angka($data_tbl_sales_order_detail['product_sell_sub_total']);
							$delivery_cost_price_indo = format_angka($data_tbl_sales_order_detail['delivery_cost_price']);
							$total_price_indo = format_angka($data_tbl_sales_order_detail['product_sell_total']);
						?>
							<li>
								<strong>
									Sub Total :
								</strong>
								<?php echo $sub_total_price_indo ?>
							</li>
							<li>
								<strong>
									Discount:
								</strong>
								0
							</li>
							<li>
								<strong>
									Ongkos Kirim :
								</strong>
								<?php echo $delivery_cost_price_indo ?>
							</li>
							<li>
								<strong>
									Jumlah Total :
								</strong>
								<?php echo $total_price_indo ?>
							</li>
						</ul>
						<br/>
						<a class="blue btn btn-outline btn-lg sbold margin-bottom-5" href="printable-version/sales_invoice.php?sales_invoice_id=<?php echo $data_tbl_sales_invoice['sales_invoice_id'] ?>">
							<i class="fa fa-print"></i>
							Cetak
						</a>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	function form_edit_sales_invoice()
	{
		$tgl_sekarang = date("d-m-Y");
		
		$tbl_sales_invoice = mysql_query("SELECT a.sales_invoice_id, a.sales_invoice_no, a.sales_invoice_date, a.sales_invoice_status, a.sales_invoice_description, b.sales_order_id, b.sales_order_overdue_day, c.sales_request_payment_method, c.sales_request_order_method, c.sales_request_product_sell_program_mix, d.user_name, e.customer_code, e.customer_name, f.customer_category_name, g.customer_districts_name FROM sales_invoice a, sales_order b, sales_request c, user d, customer e, customer_category f, customer_districts g WHERE a.sales_invoice_id = '".$_GET['sales_invoice_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.salesman_id = d.user_id AND c.customer_id = e.customer_id AND e.customer_category_id = f.customer_category_id AND e.customer_districts_id = g.customer_districts_id");
		$data_tbl_sales_invoice = mysql_fetch_array($tbl_sales_invoice);
		
		$sales_invoice_date = explode("-", $data_tbl_sales_invoice['sales_invoice_date']);
		$date_sales_invoice = $sales_invoice_date[2];
		$month_sales_invoice = $sales_invoice_date[1];
		$year_sales_invoice = $sales_invoice_date[0];
		$sales_invoice_date = date("d-m-Y", mktime(0, 0, 0, $month_sales_invoice, $date_sales_invoice, $year_sales_invoice));
		
		$sales_invoice_date_indo = tanggal_indo($data_tbl_sales_invoice['sales_invoice_date']);
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_sales_invoice['sales_invoice_no'] ?>
					<small>
						<?php echo $sales_invoice_date_indo ?>
					</small>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_invoice['user_name'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_invoice['customer_category_name'] ?> - <?php echo $data_tbl_sales_invoice['customer_code'] ?> - <?php echo $data_tbl_sales_invoice['customer_name'] ?> (<?php echo $data_tbl_sales_invoice['customer_districts_name'] ?>)
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
						<?php
							if ($data_tbl_sales_invoice['sales_order_overdue_day'] == 0)
							{
						?>
							<?php echo $data_tbl_sales_invoice['sales_request_payment_method'] ?>
						<?php	
							}
							else
							{
						?>
							<?php echo $data_tbl_sales_invoice['sales_request_payment_method'] ?> (<?php echo $data_tbl_sales_invoice['sales_order_overdue_day'] ?> Hari)
						<?php	
							}
						?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_invoice['sales_request_order_method'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							Program Mix Produk (<?php echo $data_tbl_sales_invoice['sales_request_product_sell_program_mix'] ?>)
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
									Faktur Penjualan
								</span>
							</div>
						</div>
						<div class="portlet-body form">
							<form action="?alimms=sales-invoice&tib=edit-sales-invoice" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="sales_invoice_id" type="hidden" value="<?php echo $data_tbl_sales_invoice['sales_invoice_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Status Faktur
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Status Faktur
													<span class="required">
														*
													</span>
												</label>
												<div class="radio-list">
												<?php
													if ($data_tbl_sales_invoice['sales_invoice_status'] == "Posted")
													{
												?>
													<label class="radio-inline">
														<input checked="checked" name="sales_invoice_status" type="radio" value="Approved">
															Posted
													</label>
													<label class="radio-inline">
														<input name="sales_invoice_status" type="radio" value="Canceled">
															Canceled
													</label>
												<?php
													}
													else
													{
												?>
													<label class="radio-inline">
														<input name="sales_invoice_status" type="radio" value="Posted">
															Posted
													</label>
													<label class="radio-inline">
														<input checked="checked" name="sales_invoice_status" type="radio" value="Canceled">
															Canceled
													</label>
												<?php
													}
												?>
												</div>
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
												<?php
													if ($data_tbl_sales_invoice['sales_invoice_status'] == "Posted")
													{
												?>
													<input class="form-control" name="sales_invoice_description" placeholder="Keterangan" type="text">
												<?php
													}
													else
													{
												?>
													<input class="form-control" name="sales_invoice_description" placeholder="Keterangan" type="text" value="<?php echo $data_tbl_sales_invoice['sales_invoice_description'] ?>">
												<?php
													}
												?>
												<span class="help-block">
													*) Jika Status Posted, Keterangan Dikosongkan
												</span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Tanggal Difakturkan
													<span class="required">
														*
													</span>
												</label>
												<?php
													if ($data_tbl_sales_invoice['sales_invoice_date'] == "0000-00-00")
													{
												?>
													<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_date" placeholder="Tanggal Difakturkan" type="text" value="<?php echo $tgl_sekarang ?>">
												<?php
													}
													else
													{
												?>
													<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_date" placeholder="Tanggal Difakturkan" type="text" value="<?php echo $sales_invoice_date ?>">
												<?php
													}
												?>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=sales-invoice'">
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
									$tbl_sales_order_detail = mysql_query("SELECT a.sales_order_detail_product_sell_quantity, a.sales_order_detail_product_sell_price, a.sales_order_detail_program_bonus, a.sales_order_detail_piece_discount, a.sales_order_detail_cash_discount, a.sales_order_detail_delivery_cost_price, b.product_sell_name FROM sales_order_detail a, product_sell b WHERE a.sales_order_id = '".$data_tbl_sales_invoice['sales_order_id']."' AND a.product_sell_id = b.product_sell_id ORDER BY b.product_sell_code");
									while ($data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail))
									{
										$sales_order_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity']);
										$sales_order_detail_product_sell_price_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_price']);
										$sales_order_detail_piece_discount_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_piece_discount']);
										$sales_order_detail_cash_discount = ($data_tbl_sales_order_detail['sales_order_detail_cash_discount'] / $data_tbl_sales_order_detail['sales_order_detail_product_sell_price']) * 100;
										$sales_order_detail_delivery_cost_price_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_delivery_cost_price']);
										$product_sell_sub_total_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity'] * ($data_tbl_sales_order_detail['sales_order_detail_product_sell_price'] - $data_tbl_sales_order_detail['sales_order_detail_piece_discount'] - $data_tbl_sales_order_detail['sales_order_detail_cash_discount'] + $data_tbl_sales_order_detail['sales_order_detail_delivery_cost_price']));
								?>
									<tr class="odd gradeX">
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_order_detail['product_sell_name'] ?>
										</td>
										<td>
											<?php echo $sales_order_detail_product_sell_quantity_indo ?>
										</td>
										<td>
											<?php echo $sales_order_detail_product_sell_price_indo ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_order_detail['sales_order_detail_program_bonus'] ?>
										</td>
										<td>
											<?php echo $sales_order_detail_piece_discount_indo ?>
										</td>
										<td>
											<?php echo $sales_order_detail_cash_discount ?>
										</td>
										<td>
											<?php echo $sales_order_detail_delivery_cost_price_indo ?>
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
	function form_view_sales_invoice()
	{
		$tbl_sales_invoice = mysql_query("SELECT a.sales_invoice_no, a.sales_invoice_date, b.sales_order_id, b.sales_order_overdue_day, c.sales_request_no, c.sales_request_date, c.sales_request_payment_method, c.sales_request_order_method, c.sales_request_product_sell_program_mix, d.user_name, e.customer_code, e.customer_name, f.customer_category_name, g.customer_districts_name FROM sales_invoice a, sales_order b, sales_request c, user d, customer e, customer_category f, customer_districts g WHERE a.sales_invoice_id = '".$_GET['sales_invoice_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.salesman_id = d.user_id AND c.customer_id = e.customer_id AND e.customer_category_id = f.customer_category_id AND e.customer_districts_id = g.customer_districts_id");
		$data_tbl_sales_invoice = mysql_fetch_array($tbl_sales_invoice);
		
		$sales_invoice_date_indo = tanggal_indo($data_tbl_sales_invoice['sales_invoice_date']);
		$sales_request_date_indo = tanggal_indo($data_tbl_sales_invoice['sales_request_date']);
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
			<?php
				if ($data_tbl_sales_invoice['sales_invoice_no'] != "" || $data_tbl_sales_invoice['sales_invoice_date'] != "0000-00-00")
				{
			?>
				<h3>
					<?php echo $data_tbl_sales_invoice['sales_invoice_no'] ?>
					<small>
						<?php echo $sales_invoice_date_indo ?>
					</small>
				</h3>
			<?php
				}
				else
				{
			?>
				<h3>
					<?php echo $data_tbl_sales_invoice['sales_request_no'] ?>
					<small>
						<?php echo $sales_request_date_indo ?>
					</small>
				</h3>
			<?php
				}
			?>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_invoice['user_name'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_invoice['customer_category_name'] ?> - <?php echo $data_tbl_sales_invoice['customer_code'] ?> - <?php echo $data_tbl_sales_invoice['customer_name'] ?> (<?php echo $data_tbl_sales_invoice['customer_districts_name'] ?>)
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
						<?php
							if ($data_tbl_sales_invoice['sales_order_overdue_day'] == 0)
							{
						?>
							<?php echo $data_tbl_sales_invoice['sales_request_payment_method'] ?>
						<?php	
							}
							else
							{
						?>
							<?php echo $data_tbl_sales_invoice['sales_request_payment_method'] ?> (<?php echo $data_tbl_sales_invoice['sales_order_overdue_day'] ?> Hari)
						<?php	
							}
						?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_invoice['sales_request_order_method'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							Program Mix Produk (<?php echo $data_tbl_sales_invoice['sales_request_product_sell_program_mix'] ?>)
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
									Faktur Penjualan
								</span>
							</div>
							<div class="actions">
								<a class="btn btn-outline btn-sm sbold yellow" href="?alimms=sales-invoice">
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
									$tbl_sales_order_detail = mysql_query("SELECT a.sales_order_detail_product_sell_quantity, a.sales_order_detail_product_sell_price, a.sales_order_detail_program_bonus, a.sales_order_detail_piece_discount, a.sales_order_detail_cash_discount, a.sales_order_detail_delivery_cost_price, b.product_sell_name FROM sales_order_detail a, product_sell b WHERE a.sales_order_id = '".$data_tbl_sales_invoice['sales_order_id']."' AND a.product_sell_id = b.product_sell_id ORDER BY b.product_sell_code");
									while ($data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail))
									{
										$sales_order_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity']);
										$sales_order_detail_product_sell_price_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_price']);
										$sales_order_detail_piece_discount_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_piece_discount']);
										$sales_order_detail_cash_discount = ($data_tbl_sales_order_detail['sales_order_detail_cash_discount'] / $data_tbl_sales_order_detail['sales_order_detail_product_sell_price']) * 100;
										$sales_order_detail_delivery_cost_price_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_delivery_cost_price']);
										$product_sell_sub_total_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity'] * ($data_tbl_sales_order_detail['sales_order_detail_product_sell_price'] - $data_tbl_sales_order_detail['sales_order_detail_piece_discount'] - $data_tbl_sales_order_detail['sales_order_detail_cash_discount'] + $data_tbl_sales_order_detail['sales_order_detail_delivery_cost_price']));
								?>
									<tr class="odd gradeX">
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_order_detail['product_sell_name'] ?>
										</td>
										<td>
											<?php echo $sales_order_detail_product_sell_quantity_indo ?>
										</td>
										<td>
											<?php echo $sales_order_detail_product_sell_price_indo ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_order_detail['sales_order_detail_program_bonus'] ?>
										</td>
										<td>
											<?php echo $sales_order_detail_piece_discount_indo ?>
										</td>
										<td>
											<?php echo $sales_order_detail_cash_discount ?>
										</td>
										<td>
											<?php echo $sales_order_detail_delivery_cost_price_indo ?>
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
?>