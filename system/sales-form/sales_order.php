<?php
	function form_initial_sales_order()
	{
		$tgl_sekarang = date("Y-m-d");
//$tgl_sekarang = "2016-01-25";
		$tgl_sekarang_awal = date('Y-m-01', strtotime($tgl_sekarang));
		$tgl_sekarang_akhir = date('Y-m-t', strtotime($tgl_sekarang));
?>
		<div class="page-fixed-main-content">
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
								<small class="font-blue">
									STOK <?php echo $data_tbl_product_sell['product_sell_name'] ?>
								</small>
								<h3 class="font-blue">
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
			<?php
				$tbl_product_sell = mysql_query("SELECT product_sell_id, product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
				while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
				{
					$tbl_sales_order_detail = mysql_query("SELECT SUM(b.sales_order_detail_product_sell_quantity) AS sales_order_detail_product_sell_quantity FROM sales_order a, sales_order_detail b WHERE a.sales_order_status = 'Approved' AND b.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.sales_order_id = b.sales_order_id");
					$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
					
					$sales_order_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity']);
			?>
				<div class="col-lg-4">
					<div class="bordered dashboard-stat2">
						<div class="display">
							<div class="number">
								<small class="font-red">
									PERMINTAAN <?php echo $data_tbl_product_sell['product_sell_name'] ?>
								</small>
								<h3 class="font-red">
									<span>
										<?php echo $sales_order_detail_product_sell_quantity_indo ?>
									</span>
								</h3>
							</div>
							<div class="icon">
								<i class="icon-basket-loaded"></i>
							</div>
						</div>
					</div>
				</div>
			<?php
				}
			?>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Pesanan Penjualan
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
									$tbl_sales_order = mysql_query("SELECT a.sales_order_id, a.sales_order_status, a.sales_order_description, a.sales_order_overdue_day, b.sales_request_no, b.sales_request_date, b.sales_request_delivery_schedule_date, b.sales_request_payment_method, b.sales_request_order_method, b.sales_request_product_sell_program_mix, c.user_name, d.customer_code, d.customer_name, e.customer_category_name, f.customer_districts_name FROM sales_order a, sales_request b, user c, customer d, customer_category e, customer_districts f WHERE b.sales_request_date BETWEEN '".$tgl_sekarang_awal."' AND '".$tgl_sekarang_akhir."' AND a.sales_request_id = b.sales_request_id AND b.salesman_id = c.user_id AND b.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id ORDER BY b.sales_request_date desc, b.sales_request_no");
									while ($data_tbl_sales_order = mysql_fetch_array($tbl_sales_order))
									{
										$sales_request_date_indo = tanggal_indo($data_tbl_sales_order['sales_request_date']);
										$sales_request_delivery_schedule_date_indo = tanggal_indo($data_tbl_sales_order['sales_request_delivery_schedule_date']);
										
								?>
									<tr class="odd gradeX">
										<td>
										<?php
											if ($data_tbl_sales_order['sales_request_date'] == $tgl_sekarang)
											{
												if ($data_tbl_sales_order['sales_order_status'] == "Approved" || $data_tbl_sales_order['sales_order_status'] == "Not Approved")
												{
										?>
												<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=sales-order&tib=form-view-sales-order&sales_order_id=<?php echo $data_tbl_sales_order['sales_order_id'] ?>">
													<i class="fa fa-search"></i>
												</a>
												<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=sales-order&tib=form-edit-sales-order&sales_order_id=<?php echo $data_tbl_sales_order['sales_order_id'] ?>">
													<i class="fa fa-pencil"></i>
												</a>
										<?php
												}
												elseif ($data_tbl_sales_order['sales_order_status'] == "Canceled")
												{
										?>
												<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=sales-order&tib=form-view-sales-order&sales_order_id=<?php echo $data_tbl_sales_order['sales_order_id'] ?>">
													<i class="fa fa-search"></i>
												</a>
										<?php
												}
												else
												{
										?>
												<a class="btn btn-icon-only btn-outline purple tooltips" data-original-title="Proses" data-toggle="modal" href="#approval_sales_order_id_<?php echo $data_tbl_sales_order['sales_order_id'] ?>">
													<i class="fa fa-rss"></i>
												</a>
												<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=sales-order&tib=form-view-sales-order&sales_order_id=<?php echo $data_tbl_sales_order['sales_order_id'] ?>">
													<i class="fa fa-search"></i>
												</a>
										<?php
												}
											}
											else
											{
										?>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=sales-order&tib=form-view-sales-order&sales_order_id=<?php echo $data_tbl_sales_order['sales_order_id'] ?>">
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
											<?php echo $data_tbl_sales_order['sales_request_no'] ?><br />
											<?php echo $sales_request_date_indo ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_order['user_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_order['customer_category_name'] ?> - 
											<?php echo $data_tbl_sales_order['customer_code'] ?> - <?php echo $data_tbl_sales_order['customer_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_order['customer_districts_name'] ?>
										</td>
										<td>
											<?php echo $sales_request_delivery_schedule_date_indo ?>
										</td>
										<td>
										<?php
											if ($data_tbl_sales_order['sales_order_overdue_day'] == 0)
											{
										?>
											<?php echo $data_tbl_sales_order['sales_request_payment_method'] ?>
										<?php
											}
											else
											{
										?>
											<?php echo $data_tbl_sales_order['sales_request_payment_method'] ?> (<?php echo $data_tbl_sales_order['sales_order_overdue_day'] ?> Hari)
										<?php	
											}
										?>
										</td>
										<td>
											<?php echo $data_tbl_sales_order['sales_request_order_method'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_order['sales_request_product_sell_program_mix'] ?>
										</td>
										<td>
										<?php
											if ($data_tbl_sales_order['sales_order_status'] == "On Hold")
											{
										?>
											<span class="label label-info label-sm">On Hold</span>
										<?php
											}
											elseif ($data_tbl_sales_order['sales_order_status'] == "Approved")
											{
										?>
											<span class="label label-success label-sm">Approved</span>
										<?php
											}
											elseif ($data_tbl_sales_order['sales_order_status'] == "Canceled")
											{
										?>
											<span class="label label-danger label-sm">Canceled</span><br />
											<?php echo $data_tbl_sales_order['sales_order_description'] ?>
										<?php
											}
											else
											{
										?>
											<span class="label label-danger label-sm">Not Approved</span><br />
											<?php echo $data_tbl_sales_order['sales_order_description'] ?>
										<?php
											}
										?>
										</td>
									</tr>
									<div aria-hidden="true" class="modal fade" id="approval_sales_order_id_<?php echo $data_tbl_sales_order['sales_order_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=sales-order&tib=form-approval-sales-order&sales_order_id=<?php echo $data_tbl_sales_order['sales_order_id'] ?>">
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
	function form_approval_sales_order()
	{
		$tbl_sales_order = mysql_query("SELECT a.sales_order_id, a.sales_order_overdue_day, b.sales_request_no, b.sales_request_date, b.sales_request_payment_method, b.sales_request_order_method, b.sales_request_product_sell_program_mix, c.user_name, d.customer_id, d.customer_code, d.customer_name, e.customer_category_name, f.customer_districts_name FROM sales_order a, sales_request b, user c, customer d, customer_category e, customer_districts f WHERE a.sales_order_id = '".$_GET['sales_order_id']."' AND a.sales_request_id = b.sales_request_id AND b.salesman_id = c.user_id AND b.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id");
		$data_tbl_sales_order = mysql_fetch_array($tbl_sales_order);
		
		$sales_request_date_indo = tanggal_indo($data_tbl_sales_order['sales_request_date']);
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_sales_order['sales_request_no'] ?>
					<small>
						<?php echo $sales_request_date_indo ?>
					</small>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_order['user_name'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_order['customer_category_name'] ?> - <?php echo $data_tbl_sales_order['customer_code'] ?> - <?php echo $data_tbl_sales_order['customer_name'] ?> (<?php echo $data_tbl_sales_order['customer_districts_name'] ?>)
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
						<?php
							if ($data_tbl_sales_order['sales_order_overdue_day'] == 0)
							{
						?>
							<?php echo $data_tbl_sales_order['sales_request_payment_method'] ?>
						<?php	
							}
							else
							{
						?>
							<?php echo $data_tbl_sales_order['sales_request_payment_method'] ?> (<?php echo $data_tbl_sales_order['sales_order_overdue_day'] ?> Hari)
						<?php	
							}
						?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_order['sales_request_order_method'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							Program Mix Produk (<?php echo $data_tbl_sales_order['sales_request_product_sell_program_mix'] ?>)
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
								<small class="font-blue">
									STOK <?php echo $data_tbl_product_sell['product_sell_name'] ?>
								</small>
								<h3 class="font-blue">
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
			<?php
				$tbl_product_sell = mysql_query("SELECT product_sell_id, product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
				while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
				{
					$tbl_sales_request_detail = mysql_query("SELECT SUM(b.sales_request_detail_product_sell_quantity) AS sales_request_detail_product_sell_quantity FROM sales_request a, sales_request_detail b WHERE a.sales_request_status = 'Closed' AND a.sales_request_active = '1' AND b.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.sales_request_id = b.sales_request_id");
					$data_tbl_sales_request_detail = mysql_fetch_array($tbl_sales_request_detail);
					
					$sales_request_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity']);
			?>
				<div class="col-lg-4">
					<div class="bordered dashboard-stat2">
						<div class="display">
							<div class="number">
								<small class="font-red">
									PERMINTAAN <?php echo $data_tbl_product_sell['product_sell_name'] ?>
								</small>
								<h3 class="font-red">
									<span>
										<?php echo $sales_request_detail_product_sell_quantity_indo ?>
									</span>
								</h3>
							</div>
							<div class="icon">
								<i class="icon-basket-loaded"></i>
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
									Pesanan Penjualan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=sales-order&tib=approval-sales-order" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="sales_order_id" type="hidden" value="<?php echo $data_tbl_sales_order['sales_order_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Status Pesanan
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Status Pesanan
													<span class="required">
														*
													</span>
												</label>
												<div class="radio-list" data-error-container="#sales_order_status">
													<label class="radio-inline">
														<input name="sales_order_status" type="radio" value="Approved">
															Approved
													</label>
													<label class="radio-inline">
														<input name="sales_order_status" type="radio" value="Not Approved">
															Not Approved
													</label>
												</div>
												<div id="sales_order_status"></div>
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
												<input class="form-control" name="sales_order_description" placeholder="Keterangan" type="text">
												<span class="help-block">
													*) Jika Status Pesanan Approved, Keterangan Dikosongkan
												</span>
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
												<div class="radio-list" data-error-container="#sales_order_overdue_day">
												<?php
													if ($data_tbl_sales_order['sales_request_payment_method'] == "Cash")
													{
												?>
													<label class="radio-inline">
														<input checked="checked" name="sales_order_overdue_day" type="radio" value="2">
															2 Hari
													</label>
												<?php
													}
													else
													{
												?>
													<label class="radio-inline">
														<input name="sales_order_overdue_day" type="radio" value="7">
															7 Hari
													</label>
													<label class="radio-inline">
														<input name="sales_order_overdue_day" type="radio" value="14">
															14 Hari
													</label>
													<label class="radio-inline">
														<input name="sales_order_overdue_day" type="radio" value="21">
															21 Hari
													</label>
												<?php
													}
												?>
												</div>
												<div id="sales_order_overdue_day"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=sales-order'">
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
									$tbl_sales_order_detail = mysql_query("SELECT a.sales_order_detail_product_sell_quantity, a.sales_order_detail_product_sell_price, a.sales_order_detail_program_bonus, a.sales_order_detail_piece_discount, a.sales_order_detail_cash_discount, a.sales_order_detail_delivery_cost_price, b.product_sell_name FROM sales_order_detail a, product_sell b WHERE a.sales_order_id = '".$data_tbl_sales_order['sales_order_id']."' AND a.product_sell_id = b.product_sell_id ORDER BY b.product_sell_code");
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
										$tbl_payment_order = mysql_query("SELECT a.payment_order_id, a.payment_order_status, b.sales_invoice_no, b.sales_invoice_date, c.sales_order_id FROM payment_order a, sales_invoice b, sales_order c, sales_request d WHERE a.payment_order_status = 'Unpaid' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id= c.sales_order_id AND c.sales_request_id = d.sales_request_id AND b.sales_invoice_status = 'Posted' AND d.sales_request_active = '1' AND d.customer_id = '".$data_tbl_sales_order['customer_id']."' ORDER BY b.sales_invoice_no");
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
	function form_edit_sales_order()
	{
		$tbl_sales_order = mysql_query("SELECT a.sales_order_id, a.sales_order_status, a.sales_order_description, a.sales_order_overdue_day, b.sales_request_no, b.sales_request_date, b.sales_request_payment_method, b.sales_request_order_method, b.sales_request_product_sell_program_mix, c.user_name, d.customer_code, d.customer_name, e.customer_category_name, f.customer_districts_name FROM sales_order a, sales_request b, user c, customer d, customer_category e, customer_districts f WHERE a.sales_order_id = '".$_GET['sales_order_id']."' AND a.sales_request_id = b.sales_request_id AND b.salesman_id = c.user_id AND b.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id");
		$data_tbl_sales_order = mysql_fetch_array($tbl_sales_order);
		
		$sales_request_date_indo = tanggal_indo($data_tbl_sales_order['sales_request_date']);
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_sales_order['sales_request_no'] ?>
					<small>
						<?php echo $sales_request_date_indo ?>
					</small>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_order['user_name'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_order['customer_category_name'] ?> - <?php echo $data_tbl_sales_order['customer_code'] ?> - <?php echo $data_tbl_sales_order['customer_name'] ?> (<?php echo $data_tbl_sales_order['customer_districts_name'] ?>)
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
						<?php
							if ($data_tbl_sales_order['sales_order_overdue_day'] == 0)
							{
						?>
							<?php echo $data_tbl_sales_order['sales_request_payment_method'] ?>
						<?php	
							}
							else
							{
						?>
							<?php echo $data_tbl_sales_order['sales_request_payment_method'] ?> (<?php echo $data_tbl_sales_order['sales_order_overdue_day'] ?> Hari)
						<?php	
							}
						?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_order['sales_request_order_method'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							Program Mix Produk (<?php echo $data_tbl_sales_order['sales_request_product_sell_program_mix'] ?>)
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
									Pesanan Penjualan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=sales-order&tib=edit-sales-order" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="sales_order_id" type="hidden" value="<?php echo $data_tbl_sales_order['sales_order_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Status Pesanan
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Status Pesanan
												</label>
												<div class="radio-list">
												<?php
													if ($data_tbl_sales_order['sales_order_status'] == "Approved")
													{
												?>
													<label class="radio-inline">
														<input checked="checked" name="sales_order_status" type="radio" value="Approved">
															Approved
													</label>
													<label class="radio-inline">
														<input name="sales_order_status" type="radio" value="Not Approved">
															Not Approved
													</label>
												<?php
													}
													else
													{
												?>
													<label class="radio-inline">
														<input name="sales_order_status" type="radio" value="Approved">
															Approved
													</label>
													<label class="radio-inline">
														<input checked="checked" name="sales_order_status" type="radio" value="Not Approved">
															Not Approved
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
													if ($data_tbl_sales_order['sales_order_status'] == "Approved")
													{
												?>
													<input class="form-control" name="sales_order_description" placeholder="Keterangan" type="text">
												<?php
													}
													else
													{
												?>
													<input class="form-control" name="sales_order_description" placeholder="Keterangan" type="text" value="<?php echo $data_tbl_sales_order['sales_order_description'] ?>">
												<?php
													}
												?>
												<span class="help-block">
													*) Jika Status Approved, Keterangan Dikosongkan
												</span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Jatuh Tempo
												</label>
												<div class="radio-list">
												<?php
													if ($data_tbl_sales_order['sales_request_payment_method'] == "Cash")
													{
												?>
													<label class="radio-inline">
														<input checked="checked" name="sales_order_overdue_day" type="radio" value="2">
															2 Hari
													</label>
												<?php
													}
													else
													{
														if ($data_tbl_sales_order['sales_order_overdue_day'] == "7")
														{
												?>
														<label class="radio-inline">
															<input checked="checked" name="sales_order_overdue_day" type="radio" value="7">
																7 Hari
														</label>
														<label class="radio-inline">
															<input name="sales_order_overdue_day" type="radio" value="14">
																14 Hari
														</label>
														<label class="radio-inline">
															<input name="sales_order_overdue_day" type="radio" value="21">
																21 Hari
														</label>
													<?php
														}
														elseif ($data_tbl_sales_order['sales_order_overdue_day'] == "14")
														{
													?>
														<label class="radio-inline">
															<input name="sales_order_overdue_day" type="radio" value="7">
																7 Hari
														</label>
														<label class="radio-inline">
															<input checked="checked" name="sales_order_overdue_day" type="radio" value="14">
																14 Hari
														</label>
														<label class="radio-inline">
															<input name="sales_order_overdue_day" type="radio" value="21">
																21 Hari
														</label>
													<?php
														}
														else
														{
													?>
														<label class="radio-inline">
															<input name="sales_order_overdue_day" type="radio" value="7">
																7 Hari
														</label>
														<label class="radio-inline">
															<input name="sales_order_overdue_day" type="radio" value="14">
																14 Hari
														</label>
														<label class="radio-inline">
															<input checked="checked" name="sales_order_overdue_day" type="radio" value="21">
																21 Hari
														</label>
												<?php
														}
													}
												?>
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
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=sales-order'">
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
									$tbl_sales_order_detail = mysql_query("SELECT a.sales_order_detail_product_sell_quantity, a.sales_order_detail_product_sell_price, a.sales_order_detail_program_bonus, a.sales_order_detail_piece_discount, a.sales_order_detail_cash_discount, a.sales_order_detail_delivery_cost_price, b.product_sell_name FROM sales_order_detail a, product_sell b WHERE a.sales_order_id = '".$data_tbl_sales_order['sales_order_id']."' AND a.product_sell_id = b.product_sell_id ORDER BY b.product_sell_code");
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
	function form_view_sales_order()
	{
		$tbl_sales_order = mysql_query("SELECT a.sales_order_id, a.sales_order_overdue_day, b.sales_request_no, b.sales_request_date, b.sales_request_payment_method, b.sales_request_order_method, b.sales_request_product_sell_program_mix, c.user_name, d.customer_code, d.customer_name, e.customer_category_name, f.customer_districts_name FROM sales_order a, sales_request b, user c, customer d, customer_category e, customer_districts f WHERE a.sales_order_id = '".$_GET['sales_order_id']."' AND a.sales_request_id = b.sales_request_id AND b.salesman_id = c.user_id AND b.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id");
		$data_tbl_sales_order = mysql_fetch_array($tbl_sales_order);
		
		$sales_request_date_indo = tanggal_indo($data_tbl_sales_order['sales_request_date']);
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_sales_order['sales_request_no'] ?>
					<small>
						<?php echo $sales_request_date_indo ?>
					</small>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_order['user_name'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_order['customer_category_name'] ?> - <?php echo $data_tbl_sales_order['customer_code'] ?> - <?php echo $data_tbl_sales_order['customer_name'] ?> (<?php echo $data_tbl_sales_order['customer_districts_name'] ?>)
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
						<?php
							if ($data_tbl_sales_order['sales_order_overdue_day'] == 0)
							{
						?>
							<?php echo $data_tbl_sales_order['sales_request_payment_method'] ?>
						<?php	
							}
							else
							{
						?>
							<?php echo $data_tbl_sales_order['sales_request_payment_method'] ?> (<?php echo $data_tbl_sales_order['sales_order_overdue_day'] ?> Hari)
						<?php	
							}
						?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_order['sales_request_order_method'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							Program Mix Produk (<?php echo $data_tbl_sales_order['sales_request_product_sell_program_mix'] ?>)
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
									Pesanan Penjualan
								</span>
							</div>
							<div class="actions">
								<a class="btn btn-outline btn-sm sbold yellow" href="?alimms=sales-order">
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
									$tbl_sales_order_detail = mysql_query("SELECT a.sales_order_detail_product_sell_quantity, a.sales_order_detail_product_sell_price, a.sales_order_detail_program_bonus, a.sales_order_detail_piece_discount, a.sales_order_detail_cash_discount, a.sales_order_detail_delivery_cost_price, b.product_sell_name FROM sales_order_detail a, product_sell b WHERE a.sales_order_id = '".$data_tbl_sales_order['sales_order_id']."' AND a.product_sell_id = b.product_sell_id ORDER BY b.product_sell_id");
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