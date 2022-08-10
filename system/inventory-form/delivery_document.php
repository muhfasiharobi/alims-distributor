<?php
	function form_initial_delivery_document()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue-madison bold uppercase">Dokumen Pengiriman</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="row">
							<div class="col-md-12">
								<div class="portlet light bordered">
									<div class="portlet-body">
										<table class="table table-bordered table-striped table-condensed table-hover" id="sample_3">
											<thead>
												<tr>
													<th>
													</th>
													<th>
														No
													</th>
													<th>
														Dokumen
													</th>
													<th>
														Pengiriman
													</th>
													<th>
														Kecamatan
													</th>
											<?php
												$tbl_product_sell = mysql_query("SELECT product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
												while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
												{
											?>
													<th>
														<?php echo $data_tbl_product_sell['product_sell_name'] ?>
													</th>
											<?php
												}
											?>
													<th>
														Buffer
													</th>
													<th>
														Sub Total
													</th>
													<th>
														Status
													</th>
												</tr>
											</thead>
											<tbody>
										<?php
											$no = 1;
											$tbl_delivery_distribution = mysql_query("SELECT * FROM delivery_distribution a, delivery_schedule b, delivery_vehicle c WHERE b.delivery_schedule_active = '1' AND c.delivery_vehicle_active = '1' AND a.delivery_distribution_status = 'Closed' AND a.delivery_schedule_id = b.delivery_schedule_id AND b.delivery_vehicle_id = c.delivery_vehicle_id GROUP BY c.delivery_vehicle_id ORDER BY c.delivery_vehicle_license");
											while ($data_tbl_delivery_distribution = mysql_fetch_array($tbl_delivery_distribution))
											{
												$tbl_delivery_document = mysql_query("SELECT * FROM delivery_document WHERE delivery_document_id = '".$data_tbl_delivery_distribution['delivery_document_id']."'");
												$data_tbl_delivery_document = mysql_fetch_array($tbl_delivery_document);
												
												$delivery_document_date_indo = tanggal_indo($data_tbl_delivery_document['delivery_document_date']);
												
												$tbl_sales_order_detail = mysql_query("SELECT SUM(e.sales_order_detail_quantity + e.sales_order_detail_bonus) AS sub_total_quantity FROM delivery_distribution a, sales_invoice_document_detail b, sales_invoice c, sales_order d, sales_order_detail e WHERE a.delivery_schedule_id = '".$data_tbl_delivery_distribution['delivery_schedule_id']."' AND a.delivery_distribution_status = 'Closed' AND a.sales_invoice_document_detail_id = b.sales_invoice_document_detail_id AND b.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id AND d.sales_order_id = e.sales_order_id");
												$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
												
												$sub_total_quantity = format_angka($data_tbl_sales_order_detail['sub_total_quantity'] + $data_tbl_delivery_document['delivery_document_buffer_in']);
										?>
												<tr>
											<?php
												if ($data_tbl_delivery_document['delivery_document_no'] == "")
												{
											?>
													<td style="width: 3%;">
														<a class="btn btn-icon-only grey-cascade tooltips" data-toggle="modal" data-original-title="Proses" href="#bufferdeliverydocument<?php echo $data_tbl_delivery_distribution['delivery_schedule_id'] ?>">
														<i class="fa fa-cogs"></i></a>
													</td>
											<?php
												}
												else
												{
											?>
													<td style="width: 10%;">
														<a class="btn btn-icon-only grey-cascade tooltips" data-toggle="modal" data-original-title="Cetak" href="#formprintbillingworkplanid<?php echo $data_tbl_delivery_document['delivery_document_id'] ?>">
														<i class="fa fa-print"></i></a>
														<a class="btn btn-icon-only grey-cascade tooltips" data-original-title="Ubah" href="?alimms=delivery-document&tib=form-edit-delivery-document&delivery_document_id=<?php echo $data_tbl_delivery_document['delivery_document_id'] ?>">
														<i class="fa fa-pencil"></i></a>
														<a class="btn btn-icon-only grey-cascade tooltips" data-toggle="modal" data-original-title="Hapus" href="#deletedeliverydocument<?php echo $data_tbl_delivery_document['delivery_document_id'] ?>">
														<i class="fa fa-trash"></i></a>
													</td>
											<?php
												}
											?>
													<td style="width: 3%;">
														<?php echo $no ?>
													</td>
													<td>
												<?php
													if ($data_tbl_delivery_document['delivery_document_no'] == "")
													{
												?>
														<span class="label label-primary label-sm">On Hold</span>
												<?php
													}
													else
													{
												?>
														<?php echo $data_tbl_delivery_document['delivery_document_no'] ?><br />
														<?php echo $delivery_document_date_indo ?>
												<?php
													}
												?>
													</td>
													<td>
														(<?php echo $data_tbl_delivery_distribution['delivery_vehicle_license'] ?>)<br />
														<?php echo $data_tbl_delivery_distribution['delivery_vehicle_name'] ?>
													</td>
													<td>
												<?php
													$tbl_customer_districts = mysql_query("SELECT g.customer_districts_name FROM delivery_distribution a, sales_invoice_document_detail b, sales_invoice c, sales_order d, sales_request e, customer f, customer_districts g WHERE a.delivery_schedule_id = '".$data_tbl_delivery_distribution['delivery_schedule_id']."' AND a.delivery_distribution_status = 'Closed' AND a.sales_invoice_document_detail_id = b.sales_invoice_document_detail_id AND b.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id AND d.sales_request_id = e.sales_request_id AND e.customer_id = f.customer_id AND f.customer_districts_id = g.customer_districts_id");
													while ($data_tbl_customer_districts = mysql_fetch_array($tbl_customer_districts))
													{
												?>
														(<?php echo $data_tbl_customer_districts['customer_districts_name'] ?>)
												<?php
													}
												?>
													</td>
										<?php
											$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
											while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
											{
												$tbl_sales_order_detail = mysql_query("SELECT SUM(e.sales_order_detail_quantity) AS total_quantity, SUM(e.sales_order_detail_bonus) AS total_bonus FROM delivery_distribution a, sales_invoice_document_detail b, sales_invoice c, sales_order d, sales_order_detail e WHERE a.delivery_schedule_id = '".$data_tbl_delivery_distribution['delivery_schedule_id']."' AND a.delivery_distribution_status = 'Closed' AND a.sales_invoice_document_detail_id = b.sales_invoice_document_detail_id AND b.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id AND d.sales_order_id = e.sales_order_id AND e.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
												$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
												
												$total_quantity = format_angka($data_tbl_sales_order_detail['total_quantity']);
												$total_bonus = format_angka($data_tbl_sales_order_detail['total_bonus']);
										?>
													<td>
														<?php echo $total_quantity ?> Crt +<br />
														Bonus (<?php echo $total_bonus ?>) Crt
													</td>
										<?php
											}
										?>
													<td>
												<?php
													if ($data_tbl_delivery_document['delivery_document_buffer_in'] == "")
													{
												?>
														0 Crt
												<?php
													}
													else
													{
												?>
														<?php echo $data_tbl_delivery_document['delivery_document_buffer_in'] ?> Crt
												<?php
													}
												?>
													</td>
													<td>
														<?php echo $sub_total_quantity ?> Crt
													</td>
													<td>
												<?php
													if ($data_tbl_delivery_document['delivery_document_status'] == "Loading")
													{
												?>
														<span class="label label-warning label-sm">Loading</span>
												<?php
													}
													elseif ($data_tbl_delivery_document['delivery_document_status'] == "Handling")
													{
												?>
														<span class="label label-info label-sm">Handling</span>
												<?php
													}
													elseif ($data_tbl_delivery_document['delivery_document_status'] == "Delivered")
													{
												?>
														<span class="label label-success label-sm">Delivered</span>
												<?php
													}
													else
													{
												?>
														<span class="label label-primary label-sm">On Hold</span>
												<?php
													}
												?>
													</td>
												</tr>
												<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="bufferdeliverydocument<?php echo $data_tbl_delivery_distribution['delivery_schedule_id'] ?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																<h4 class="modal-title">Konfirmasi</h4>
															</div>
															<div class="modal-body">
																<p>
																	Apakah Anda Yakin Ingin Memproses Data Ini ?
																</p>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn green-meadow btn-sm" onclick="location.href='?alimms=delivery-document&tib=form-buffer-delivery-document&delivery_schedule_id=<?php echo $data_tbl_delivery_distribution['delivery_schedule_id'] ?>'"><i class="fa fa-check"></i> Ya</button>
																<button type="button" class="btn red-sunglo btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
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
				</div>
			</div>
		</div>
<?php
	}
	function form_buffer_delivery_document()
	{
		$tbl_delivery_distribution = mysql_query("SELECT delivery_schedule_id FROM delivery_distribution WHERE delivery_schedule_id = '".$_GET['delivery_schedule_id']."'");
		$data_tbl_delivery_distribution = mysql_fetch_array($tbl_delivery_distribution);
		
		$tgl_sekarang = date("Y-m-d");
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" id="form_sample_3" method="post" action="?alimms=delivery-document&tib=buffer-delivery-document">
				<input type="hidden" class="form-control" name="delivery_schedule_id" value="<?php echo $data_tbl_delivery_distribution['delivery_schedule_id'] ?>" />
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Dokumen Pesanan Pengiriman</span>
							</div>
							<div class="actions btn-set">
								<button type="submit" class="btn green-meadow"><i class="fa fa-check"></i> Simpan</button>
								<button type="button" class="btn red-sunglo" onclick="location.href='?alimms=delivery-document'"><i class="fa fa-times"></i> Batal</button>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="alert alert-info no-margin">
											<h4 class="form-section">Informasi Dokumen Pengiriman</h4>
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label">Buffer <span class="required">*</span></label>
														<input type="text" class="form-control" placeholder="Buffer" autofocus="autofocus" name="delivery_document_buffer_in" />
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
	function form_print_delivery_document()
	{
		$tbl_delivery_document = mysql_query("SELECT a.delivery_document_id, a.delivery_document_no, a.delivery_document_date, a.delivery_document_status_print, b.sales_order_id, b.sales_order_due_date, c.sales_request_no, c.sales_request_payment, d.user_name, e.customer_code, e.customer_name, e.customer_address, e.customer_phone, f.customer_districts_name FROM delivery_document a, sales_order b, sales_request c, user d, customer e, customer_districts f WHERE a.delivery_document_id = '".$_GET['delivery_document_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.salesman_id = d.user_id AND c.customer_id = e.customer_id AND e.customer_districts_id = f.customer_districts_id");
		$data_tbl_delivery_document = mysql_fetch_array($tbl_delivery_document);
		
		$delivery_document_date_indo = tanggal_indo($data_tbl_delivery_document['delivery_document_date']);
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light">
					<div class="portlet-body">
						<div class="invoice">
							<div class="row invoice-logo">
								<div class="col-xs-6 invoice-logo-space">
									<img src="../assets/admin/pages/media/invoice/walmart.png" class="img-responsive" alt=""/>
								</div>
								<div class="col-xs-6">
									<p>
										Faktur Penjualan
										<span class="muted"><?php echo $data_tbl_delivery_document['delivery_document_no'] ?>, <?php echo $delivery_document_date_indo ?></span>
									</p>
								</div>
							</div>
							<hr/>
							<div class="row">
								<div class="col-xs-4">
									<h3>Kepada Yang Terhormat:</h3>
									<ul class="list-unstyled">
										<li>
											<?php echo $data_tbl_delivery_document['customer_code'] ?>
										</li>
										<li>
											<?php echo $data_tbl_delivery_document['customer_name'] ?>
										</li>
										<li>
											<?php echo $data_tbl_delivery_document['customer_address'] ?>
										</li>
										<li>
											<?php echo $data_tbl_delivery_document['customer_districts_name'] ?>, <?php echo $data_tbl_delivery_document['customer_city_name'] ?>
										</li>
										<li>
											<?php echo $data_tbl_delivery_document['customer_phone'] ?>
										</li>
									</ul>
								</div>
								<div class="col-xs-4">
									<h3>Pengirim:</h3>
									<ul class="list-unstyled">
										<li>
											Al Qodiri
										</li>
										<li>
											Jl. Cendrawasih No. 9
										</li>
										<li>
											68131
										</li>
										<li>
											Jember - Jawa Timur
										</li>
										<li>
											0331-413589
										</li>
									</ul>
								</div>
								<div class="col-xs-4 invoice-payment">
									<h3>Rincian Pesanan:</h3>
									<ul class="list-unstyled">
										<li>
											<strong>No. Faktur:</strong> <?php echo $data_tbl_delivery_document['delivery_document_no'] ?>
										</li>
										<li>
											<strong>Tgl. Faktur:</strong> <?php echo $delivery_document_date_indo ?>
										</li>
										<li>
											<strong>No. Referensi:</strong> <?php echo $data_tbl_delivery_document['sales_request_no'] ?>
										</li>
										<li>
											<strong>Salesman:</strong> <?php echo $data_tbl_delivery_document['user_name'] ?>
										</li>
										<li>
											<strong>Jatuh Tempo:</strong> <?php echo $data_tbl_delivery_document['sales_order_due_date'] ?> Hari
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
													No
												</th>
												<th>
													Produk
												</th>
												<th>
													Satuan
												</th>
												<th>
													Jumlah
												</th>
												<th>
													Bonus
												</th>
												<th>
													Harga
												</th>
												<th>
													Diskon (Rp)
												</th>
												<th>
													Cash Diskon (%)
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
										$tbl_sales_order_detail = mysql_query("SELECT a.sales_order_detail_id, a.sales_order_detail_quantity, a.sales_order_detail_bonus, a.sales_order_detail_price, a.sales_order_detail_discount, a.sales_order_detail_discount_cash, a.sales_order_detail_delivery_charges_price, b.product_sell_name, c.product_unit_name FROM sales_order_detail a, product_sell b, product_unit c WHERE a.sales_order_id = '".$data_tbl_delivery_document['sales_order_id']."' AND a.product_sell_id = b.product_sell_id AND b.product_unit_id = c.product_unit_id ORDER BY b.product_sell_code, a.sales_order_detail_id");
										while ($data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail))
										{
											$sales_order_detail_quantity = format_angka($data_tbl_sales_order_detail['sales_order_detail_quantity']);
											$sales_order_detail_bonus = format_angka($data_tbl_sales_order_detail['sales_order_detail_bonus']);
											$sales_order_detail_price = format_angka($data_tbl_sales_order_detail['sales_order_detail_price']);
											$sales_order_detail_discount = format_angka($data_tbl_sales_order_detail['sales_order_detail_discount']);
											$sales_order_detail_discount_cash = ($data_tbl_sales_order_detail['sales_order_detail_discount_cash'] / $data_tbl_sales_order_detail['sales_order_detail_price']) * 100;
											$sales_order_detail_delivery_charges_price = format_angka($data_tbl_sales_order_detail['sales_order_detail_delivery_charges_price']);
											$sub_total_price = format_angka($data_tbl_sales_order_detail['sales_order_detail_quantity'] * ($data_tbl_sales_order_detail['sales_order_detail_price'] - $data_tbl_sales_order_detail['sales_order_detail_discount'] - $data_tbl_sales_order_detail['sales_order_detail_discount_cash'] + $data_tbl_sales_order_detail['sales_order_detail_delivery_charges_price']));
									?>
											<tr>
												<td style="width: 3%;">
													<?php echo $no ?>
												</td>
												<td>
													<?php echo $data_tbl_sales_order_detail['product_sell_name'] ?>
												</td>
												<td>
													<?php echo $data_tbl_sales_order_detail['product_unit_name'] ?>
												</td>
												<td>
													<?php echo $sales_order_detail_quantity ?>
												</td>
												<td>
													<?php echo $sales_order_detail_bonus ?>
												</td>
												<td>
													<?php echo $sales_order_detail_price ?>
												</td>
												<td>
													<?php echo $sales_order_detail_discount ?>
												</td>
												<td>
													<?php echo $sales_order_detail_discount_cash ?>
												</td>
												<td>
													<?php echo $sales_order_detail_delivery_charges_price ?>
												</td>
												<td>
													<?php echo $sub_total_price ?>
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
							<div class="row">
							<?php
								$tbl_sales_order_detail = mysql_query("SELECT SUM(sales_order_detail_quantity * (sales_order_detail_price - sales_order_detail_discount - ((sales_order_detail_discount_cash / sales_order_detail_price) * 100) + sales_order_detail_delivery_charges_price)) AS total_price FROM sales_order_detail WHERE sales_order_id = '".$data_tbl_delivery_document['sales_order_id']."'");
								$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
								
								$total_price = format_rupiah($data_tbl_sales_order_detail['total_price']);
								
								$total_price_calculated = terbilang($data_tbl_sales_order_detail['total_price']);
							?>
								<div class="col-xs-12 invoice-block">
									<ul class="list-unstyled amounts">
										<li>
											<strong>Total:</strong> Rp. <?php echo $total_price ?>
										</li>
										<li>
											<strong>Terbilang:</strong> <?php echo $total_price_calculated ?> Rupiah
										</li>
									</ul>
									<br/>
							<?php
								if ($_SESSION['user_category_name'] == "Manager Accounting and Finance")
								{
							?>
									<a class="btn btn-lg blue hidden-print margin-bottom-5" href="printable-version/delivery_document.php?delivery_document_id=<?php echo $data_tbl_delivery_document['delivery_document_id'] ?>">
									Cetak <i class="fa fa-print"></i>
									</a>
							<?php
								}
								else
								{
									if ($data_tbl_delivery_document['delivery_document_status_print'] == "Open")
									{
							?>
									<a class="btn btn-lg blue hidden-print margin-bottom-5" href="printable-version/delivery_document.php?delivery_document_id=<?php echo $data_tbl_delivery_document['delivery_document_id'] ?>">
									Cetak <i class="fa fa-print"></i>
									</a>
							<?php
									}
									else
									{
									}
								}
							?>
									<a class="btn btn-lg red hidden-print margin-bottom-5" href="?alimms=delivery-order">
									Keluar <i class="fa fa-check"></i>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	function form_view_delivery_document()
	{
		$tbl_delivery_document = mysql_query("SELECT a.delivery_document_date, a.delivery_document_status, a.delivery_document_description, b.sales_order_id, b.sales_order_status, b.sales_order_description, b.sales_order_due_date, c.sales_request_no, c.sales_request_date, c.sales_request_payment, c.sales_request_order, c.sales_request_delivery_date, c.sales_request_description, d.user_name, e.customer_code, e.customer_name, e.customer_address, e.customer_contact, e.customer_phone, f.customer_category_name, g.customer_districts_name FROM delivery_document a, sales_order b, sales_request c, user d, customer e, customer_category f, customer_districts g WHERE a.delivery_document_id = '".$_GET['delivery_document_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.salesman_id = d.user_id AND c.customer_id = e.customer_id AND e.customer_category_id = f.customer_category_id AND e.customer_districts_id = g.customer_districts_id");
		$data_tbl_delivery_document = mysql_fetch_array($tbl_delivery_document);
		
		$delivery_document_date_indo = tanggal_indo($data_tbl_delivery_document['delivery_document_date']);
		$sales_request_date_indo = tanggal_indo($data_tbl_delivery_document['sales_request_date']);
		$sales_request_delivery_date_indo = tanggal_indo($data_tbl_delivery_document['sales_request_delivery_date']);
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" id="form_sample_3">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Faktur Penjualan</span>
							</div>
							<div class="actions btn-set">
								<button type="button" class="btn red-sunglo" onclick="location.href='?alimms=delivery-order'"><i class="fa fa-sign-out"></i> Keluar</button>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="alert alert-success no-margin">
											<h4 class="form-section">Informasi Permintaan Penjualan</h4>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Salesman</label>
														<h4>
															<?php echo $data_tbl_delivery_document['user_name'] ?>
														</h4>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Nomor</label>
														<h4>
															<?php echo $data_tbl_delivery_document['sales_request_no'] ?>
														</h4>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Tanggal</label>
														<h4>
															<?php echo $sales_request_date_indo ?>
														</h4>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Pembayaran</label>
														<h4>
															<?php echo $data_tbl_delivery_document['sales_request_payment'] ?>
														</h4>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Pesanan</label>
														<h4>
															<?php echo $data_tbl_delivery_document['sales_request_order'] ?>
														</h4>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Tanggal Pengiriman</label>
														<h4>
															<?php echo $sales_request_delivery_date_indo ?>
														</h4>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Keterangan</label>
														<h4>
															<?php echo $data_tbl_delivery_document['sales_request_description'] ?>
														</h4>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="alert alert-warning no-margin">
											<h4 class="form-section">Informasi Pelanggan</h4>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Kategori</label>
														<h4>
															<?php echo $data_tbl_delivery_document['customer_category_name'] ?>
														</h4>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Kode</label>
														<h4>
															<?php echo $data_tbl_delivery_document['customer_code'] ?>
														</h4>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Nama</label>
														<h4>
															<?php echo $data_tbl_delivery_document['customer_name'] ?>
														</h4>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Alamat</label>
														<h4>
															<?php echo $data_tbl_delivery_document['customer_address'] ?>
														</h4>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Kecamatan</label>
														<h4>
															<?php echo $data_tbl_delivery_document['customer_districts_name'] ?>
														</h4>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Kontak</label>
														<h4>
															<?php echo $data_tbl_delivery_document['customer_contact'] ?>
														</h4>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">No. Telepon</label>
														<h4>
															<?php echo $data_tbl_delivery_document['customer_phone'] ?>
														</h4>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="alert alert-danger">
											<h4 class="form-section">Informasi Pesanan Penjualan</h4>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Pesanan</label>
														<h4>
														<?php
															if ($data_tbl_delivery_document['sales_order_status'] == "On Hold")
															{
																echo "-";
															}
															else
															{
																echo $data_tbl_delivery_document['sales_order_status'];
															}
														?>
														</h4>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Keterangan</label>
														<h4>
														<?php
															if ($data_tbl_delivery_document['sales_order_description'] == "")
															{
																echo "-";
															}
															else
															{
																echo $data_tbl_delivery_document['sales_order_description'];
															}
														?>
														</h4>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Jatuh Tempo</label>
														<h4>
														<?php
															if ($data_tbl_delivery_document['sales_order_due_date'] == "0")
															{
																echo "-";
															}
															else
															{
																echo $data_tbl_delivery_document['sales_order_due_date'].' Hari';
															}
														?>
														</h4>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="alert alert-info">
											<h4 class="form-section">Informasi Faktur Penjualan</h4>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Pesanan</label>
														<h4>
														<?php
															if ($data_tbl_delivery_document['delivery_document_status'] == "On Hold")
															{
																echo "On Hold";
															}
															else
															{
																echo $data_tbl_delivery_document['delivery_document_status'];
															}
														?>
														</h4>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Keterangan</label>
														<h4>
														<?php
															if ($data_tbl_delivery_document['delivery_document_description'] == "")
															{
																echo "On Hold";
															}
															else
															{
																echo $data_tbl_delivery_document['delivery_document_description'];
															}
														?>
														</h4>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Tanggal</label>
														<h4>
														<?php
															if ($data_tbl_delivery_document['delivery_document_date'] == "0000-00-00")
															{
																echo "On Hold";
															}
															else
															{
																echo $delivery_document_date_indo;
															}
														?>
														</h4>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="portlet-body">
							<div class="row">
								<div class="col-md-12">
									<div class="portlet light bordered">
										<div class="portlet-body">
											<table class="table table-binvoiceed table-striped table-condensed table-hover" id="sample_2">
												<thead>
													<tr>
														<th>
															No
														</th>
														<th>
															Produk 
														</th>
														<th>
															Satuan 
														</th>
														<th>
															Jumlah
														</th>
														<th>
															Bonus
														</th>
														<th>
															Harga
														</th>
														<th>
															Diskon (Rp)
														</th>
														<th>
															Cash Diskon (%)
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
												$tbl_sales_order_detail = mysql_query("SELECT a.sales_order_detail_id, a.sales_order_detail_quantity, a.sales_order_detail_bonus, a.sales_order_detail_price, a.sales_order_detail_discount, a.sales_order_detail_discount_cash, a.sales_order_detail_delivery_charges_price, b.product_sell_name, c.product_unit_name FROM sales_order_detail a, product_sell b, product_unit c WHERE a.sales_order_id = '".$data_tbl_delivery_document['sales_order_id']."' AND a.product_sell_id = b.product_sell_id AND b.product_unit_id = c.product_unit_id ORDER BY b.product_sell_code, a.sales_order_detail_id");
												while ($data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail))
												{
													$sales_order_detail_quantity = format_angka($data_tbl_sales_order_detail['sales_order_detail_quantity']);
													$sales_order_detail_bonus = format_angka($data_tbl_sales_order_detail['sales_order_detail_bonus']);
													$sales_order_detail_price = format_angka($data_tbl_sales_order_detail['sales_order_detail_price']);
													$sales_order_detail_discount = format_angka($data_tbl_sales_order_detail['sales_order_detail_discount']);
													$sales_order_detail_discount_cash = ($data_tbl_sales_order_detail['sales_order_detail_discount_cash'] / $data_tbl_sales_order_detail['sales_order_detail_price']) * 100;
													$sales_order_detail_delivery_charges_price = format_angka($data_tbl_sales_order_detail['sales_order_detail_delivery_charges_price']);
													$sub_total_price = format_angka($data_tbl_sales_order_detail['sales_order_detail_quantity'] * ($data_tbl_sales_order_detail['sales_order_detail_price'] - $data_tbl_sales_order_detail['sales_order_detail_discount'] - $sales_order_detail_discount_cash + $data_tbl_sales_order_detail['sales_order_detail_delivery_charges_price']));
											?>
													<tr>
														<td style="width: 3%;">
															<?php echo $no ?>
														</td>
														<td>
															<?php echo $data_tbl_sales_order_detail['product_sell_name'] ?>
														</td>
														<td>
															<?php echo $data_tbl_sales_order_detail['product_unit_name'] ?>
														</td>
														<td>
															<?php echo $sales_order_detail_quantity ?>
														</td>
														<td>
															<?php echo $sales_order_detail_bonus ?>
														</td>
														<td>
															<?php echo $sales_order_detail_price ?>
														</td>
														<td>
															<?php echo $sales_order_detail_discount ?>
														</td>
														<td>
															<?php echo $sales_order_detail_discount_cash ?>
														</td>
														<td>
															<?php echo $sales_order_detail_delivery_charges_price ?>
														</td>
														<td>
															<?php echo $sub_total_price ?>
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
				</form>
			</div>
		</div>
<?php
	}
	function form_edit_delivery_document()
	{
		$tbl_delivery_document = mysql_query("SELECT delivery_schedule_id, delivery_document_buffer_in FROM delivery_document a, delivery_distribution b WHERE a.delivery_document_id = b.delivery_document_id AND b.delivery_schedule_id = '".$_GET['delivery_schedule_id']."'");
		$data_tbl_delivery_document = mysql_fetch_array($tbl_delivery_document);
		
		$salesinvoiceDate = explode("-", $data_tbl_delivery_document['delivery_document_date']);
		$DatesalesinvoiceDate = $salesinvoiceDate[2];
		$MonthsalesinvoiceDate = $salesinvoiceDate[1];
		$YearsalesinvoiceDate = $salesinvoiceDate[0];
		$delivery_document_date = date("d-m-Y", mktime(0, 0, 0, $MonthsalesinvoiceDate, $DatesalesinvoiceDate, $YearsalesinvoiceDate));
?>
		<div class="row">
			<div class="col-md-12">
				<form class="form-horizontal" id="form_sample_3" method="post" action="?alimms=delivery-order&tib=edit-delivery-order">
				<input type="hidden" class="form-control" name="delivery_document_id" value="<?php echo $data_tbl_delivery_document['delivery_document_id'] ?>" />
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Pesanan Penjualan</span>
							</div>
							<div class="actions btn-set">
								<button type="submit" class="btn green-meadow"><i class="fa fa-cogs"></i> Proses</button>
								<button type="button" class="btn red-sunglo" onclick="location.href='?alimms=delivery-order'"><i class="fa fa-times"></i> Batal</button>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="alert alert-info no-margin">
									<h4 class="form-section">Informasi Persetujuan</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-3">Tanggal <span class="required">*</span></label>
												<div class="col-md-8">
													<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="Tanggal" name="delivery_document_date" value="<?php echo $delivery_document_date ?>" />
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-2">Keterangan <span class="required">*</span></label>
												<div class="col-md-8">
													<input type="text" class="form-control" placeholder="Keterangan" name="delivery_document_description" value="<?php echo $data_tbl_delivery_document['delivery_document_description'] ?>" />
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-3">Persetujuan <span class="required">*</span></label>
												<div class="col-md-8">
													<div class="radio-list">
												<?php
													if ($data_tbl_delivery_document['delivery_document_status'] == "Approved")
													{
												?>
														<label class="radio-inline">
														<input type="radio" name="delivery_document_status" value="Approved" checked="checked" />
														Approved</label>
														<label class="radio-inline">
														<input type="radio" name="delivery_document_status" value="Not Approved" />
														Not Approved</label>
												<?php
													}
													elseif ($data_tbl_delivery_document['delivery_document_status'] == "Not Approved")
													{
												?>
														<label class="radio-inline">
														<input type="radio" name="delivery_document_status" value="Approved" />
														Approved</label>
														<label class="radio-inline">
														<input type="radio" name="delivery_document_status" value="Not Approved" checked="checked" />
														Not Approved</label>
												<?php
													}
												?>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label col-md-2">Jatuh Tempo <span class="required">*</span></label>
												<div class="col-md-8">
													<div class="radio-list">
												<?php
													if ($data_tbl_delivery_document['delivery_document_due_date'] == "0" || $data_tbl_delivery_document['delivery_document_due_date'] == "2")
													{
												?>
														<label class="radio-inline">
														<input type="radio" name="delivery_document_due_date" value="2" checked="checked" />
														2 Hari</label>
														<label class="radio-inline">
														<input type="radio" name="delivery_document_due_date" value="7" />
														7 Hari</label>
														<label class="radio-inline">
														<input type="radio" name="delivery_document_due_date" value="14" />
														14 Hari</label>
														<label class="radio-inline">
														<input type="radio" name="delivery_document_due_date" value="21" />
														21 Hari</label>
												<?php
													}
													elseif ($data_tbl_delivery_document['delivery_document_due_date'] == "7")
													{
												?>
														<label class="radio-inline">
														<input type="radio" name="delivery_document_due_date" value="2" />
														2 Hari</label>
														<label class="radio-inline">
														<input type="radio" name="delivery_document_due_date" value="7" checked="checked" />
														7 Hari</label>
														<label class="radio-inline">
														<input type="radio" name="delivery_document_due_date" value="14" />
														14 Hari</label>
														<label class="radio-inline">
														<input type="radio" name="delivery_document_due_date" value="21" />
														21 Hari</label>
												<?php
													}
													elseif ($data_tbl_delivery_document['delivery_document_due_date'] == "14")
													{
												?>
														<label class="radio-inline">
														<input type="radio" name="delivery_document_due_date" value="2" />
														2 Hari</label>
														<label class="radio-inline">
														<input type="radio" name="delivery_document_due_date" value="7" />
														7 Hari</label>
														<label class="radio-inline">
														<input type="radio" name="delivery_document_due_date" value="14" checked="checked" />
														14 Hari</label>
														<label class="radio-inline">
														<input type="radio" name="delivery_document_due_date" value="21" />
														21 Hari</label>
												<?php
													}
													elseif ($data_tbl_delivery_document['delivery_document_due_date'] == "21")
													{
												?>
														<label class="radio-inline">
														<input type="radio" name="delivery_document_due_date" value="2" />
														2 Hari</label>
														<label class="radio-inline">
														<input type="radio" name="delivery_document_due_date" value="7" />
														7 Hari</label>
														<label class="radio-inline">
														<input type="radio" name="delivery_document_due_date" value="14" />
														14 Hari</label>
														<label class="radio-inline">
														<input type="radio" name="delivery_document_due_date" value="21" checked="checked" />
														21 Hari</label>
												<?php
													}
												?>
														<span class="help-block">
														Jatuh Tempo Dihitung Setelah Produk Terkirim
														</span>
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
?>