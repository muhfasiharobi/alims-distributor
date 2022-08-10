<?php
	function form_initial_sales_request()
	{
		$tgl_sekarang = date("Y-m-d");
//$tgl_sekarang = "2017-01-12";
		$tgl_sekarang_awal = date('Y-m-01', strtotime($tgl_sekarang));
		$tgl_sekarang_akhir = date('Y-m-t', strtotime($tgl_sekarang));
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
							<div class="actions">
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=sales-request&tib=form-add-sales-request">
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
									$tbl_sales_request = mysql_query("SELECT a.sales_request_id, a.sales_request_no, a.sales_request_date, a.sales_request_delivery_schedule_date, a.sales_request_payment_method, a.sales_request_order_method, a.sales_request_product_sell_program_mix, a.sales_request_status, b.user_name, c.customer_code, c.customer_name, d.customer_category_name, e.customer_districts_name FROM sales_request a, user b, customer c, customer_category d, customer_districts e WHERE a.sales_request_date = '".$tgl_sekarang."' AND a.salesman_id = b.user_id AND a.customer_id = c.customer_id AND c.customer_category_id = d.customer_category_id AND c.customer_districts_id = e.customer_districts_id ORDER BY a.sales_request_date desc, a.sales_request_no");
									while ($data_tbl_sales_request = mysql_fetch_array($tbl_sales_request))
									{
										$sales_request_date_indo = tanggal_indo($data_tbl_sales_request['sales_request_date']);
										$sales_request_delivery_schedule_date_indo = tanggal_indo($data_tbl_sales_request['sales_request_delivery_schedule_date']);
								?>
									<tr class="odd gradeX">
										<td>
										<?php
											if ($data_tbl_sales_request['sales_request_date'] == $tgl_sekarang)
											{
												if ($data_tbl_sales_request['sales_request_status'] == "Canceled" || $data_tbl_sales_request['sales_request_status'] == "Closed")
												{
										?>
												<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=sales-request&tib=form-view-sales-request&sales_request_id=<?php echo $data_tbl_sales_request['sales_request_id'] ?>">
													<i class="fa fa-search"></i>
												</a>
										<?php
												}
												else
												{
										?>
												<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=sales-request&tib=form-view-sales-request&sales_request_id=<?php echo $data_tbl_sales_request['sales_request_id'] ?>">
													<i class="fa fa-search"></i>
												</a>
												<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=sales-request&tib=form-edit-sales-request&sales_request_id=<?php echo $data_tbl_sales_request['sales_request_id'] ?>">
													<i class="fa fa-pencil"></i>
												</a>
												<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_sales_request_id_<?php echo $data_tbl_sales_request['sales_request_id'] ?>">
													<i class="fa fa-trash"></i>
												</a>
										<?php
												}
											}
											else
											{
										?>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=sales-request&tib=form-view-sales-request&sales_request_id=<?php echo $data_tbl_sales_request['sales_request_id'] ?>">
												<i class="fa fa-search"></i>
											</a>
                                                                                        <a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=sales-request&tib=form-edit-sales-request&sales_request_id=<?php echo $data_tbl_sales_request['sales_request_id'] ?>">
											   <i class="fa fa-pencil"></i>
											</a>
										<?php
											}
										?>
										</td>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_request['sales_request_no'] ?><br />
											<?php echo $sales_request_date_indo ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_request['user_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_request['customer_category_name'] ?> - <?php echo $data_tbl_sales_request['customer_code'] ?> - <?php echo $data_tbl_sales_request['customer_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_request['customer_districts_name'] ?>
										</td>
										<td>
											<?php echo $sales_request_delivery_schedule_date_indo ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_request['sales_request_payment_method'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_request['sales_request_order_method'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_request['sales_request_product_sell_program_mix'] ?>
										</td>
										<td>
										<?php
											if ($data_tbl_sales_request['sales_request_status'] == "On Hold")
											{
										?>
											<span class="label label-info label-sm">On Hold</span>
										<?php
											}
											elseif ($data_tbl_sales_request['sales_request_status'] == "Canceled")
											{
										?>
											<span class="label label-danger label-sm">Canceled</span>
										<?php
											}
											else
											{
										?>
											<span class="label label-success label-sm">Closed</span>
										<?php
											}
										?>
										</td>
									</tr>
									<div aria-hidden="true" class="modal fade" id="delete_sales_request_id_<?php echo $data_tbl_sales_request['sales_request_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=sales-request&tib=delete-sales-request&sales_request_id=<?php echo $data_tbl_sales_request['sales_request_id'] ?>">
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
	function form_add_sales_request()
	{
		$tgl_besok_indo = date("d-m-Y", mktime(0,0,0, date("m"), date("d") + 1, date("Y")));
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
						<div class="form portlet-body">
							<form action="?alimms=sales-request&tib=add-sales-request" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<h4 class="form-section">
										Permintaan Penjualan
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Salesman
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#salesman_id" data-placeholder="Salesman" name="salesman_id">
													<option value=""></option>
													<?php
														$tbl_user = mysql_query("SELECT a.user_id, a.user_name FROM user a, user_category b WHERE a.user_active = '1' AND b.user_category_active = '1' AND a.user_category_id = b.user_category_id AND b.user_category_name LIKE 'Salesman%' ORDER BY a.user_name");
														while($data_tbl_user = mysql_fetch_array($tbl_user))
														{
													?>
														<option value="<?php echo $data_tbl_user['user_id'] ?>"><?php echo $data_tbl_user['user_name'] ?></option>
													<?php	
														}
													?>
												</select>
												<div id="salesman_id"></div>
											</div>
										</div>
										<div class="col-md-6">
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
														$tbl_customer = mysql_query("SELECT a.customer_id, a.customer_code, a.customer_name, a.customer_address, b.customer_category_name, c.customer_districts_name FROM customer a, customer_category b, customer_districts c WHERE a.customer_active = '1' AND b.customer_category_active = '1' AND c.customer_districts_active = '1' AND a.customer_category_id = b.customer_category_id AND a.customer_districts_id = c.customer_districts_id ORDER BY a.customer_code");
														while($data_tbl_customer = mysql_fetch_array($tbl_customer))
														{
													?>
														<option value="<?php echo $data_tbl_customer['customer_id'] ?>"><?php echo $data_tbl_customer['customer_category_name'] ?> - <?php echo $data_tbl_customer['customer_code'] ?> - <?php echo $data_tbl_customer['customer_name'] ?> - <?php echo $data_tbl_customer['customer_address'] ?> (<?php echo $data_tbl_customer['customer_districts_name'] ?>)</option>
													<?php	
														}
													?>
												</select>
												<div id="customer_id"></div>
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
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Cara Pesanan
													<span class="required">
														*
													</span>
												</label>
												<div class="radio-list" data-error-container="#sales_request_order_method">
													<label class="radio-inline">
														<input name="sales_request_order_method" type="radio" value="By Phone">
															By Phone
													</label>
													<label class="radio-inline">
														<input name="sales_request_order_method" type="radio" value="By Visit">
															By Visit
													</label>
												</div>
												<div id="sales_request_order_method"></div>
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
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d" name="sales_request_delivery_schedule_date" placeholder="Jadwal Pengiriman" type="text" value="<?php echo $tgl_besok_indo ?>">
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
									<button type="submit" class="btn btn-sm btn-outline purple sbold">
										<i class="fa fa-rss"></i>
										Proses
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=sales-request'">
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
	function form_product_sell_sales_request()
	{
		$tbl_sales_request = mysql_query("SELECT a.sales_request_id, a.sales_request_no, a.sales_request_date, a.sales_request_payment_method, a.sales_request_order_method, a.sales_request_product_sell_program_mix, b.user_name, c.customer_code, c.customer_name, d.customer_category_name, e.customer_districts_name, c.customer_id FROM sales_request a, user b, customer c, customer_category d, customer_districts e WHERE a.sales_request_id = '".$_GET['sales_request_id']."' AND a.salesman_id = b.user_id AND a.customer_id = c.customer_id AND c.customer_category_id = d.customer_category_id AND c.customer_districts_id = e.customer_districts_id");
		$data_tbl_sales_request = mysql_fetch_array($tbl_sales_request);
		
		$sales_request_date_indo = tanggal_indo($data_tbl_sales_request['sales_request_date']);
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_sales_request['sales_request_no'] ?>
					<small>
						<?php echo $sales_request_date_indo ?>
					</small>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_request['user_name'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_request['customer_category_name'] ?> - <?php echo $data_tbl_sales_request['customer_code'] ?> - <?php echo $data_tbl_sales_request['customer_name'] ?> (<?php echo $data_tbl_sales_request['customer_districts_name'] ?>)
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_request['sales_request_payment_method'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_request['sales_request_order_method'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							Program Mix Produk (<?php echo $data_tbl_sales_request['sales_request_product_sell_program_mix'] ?>)
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
						<div class="form portlet-body">
							<form action="?alimms=sales-request&tib=product-sell-sales-request" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="sales_request_id" type="hidden" value="<?php echo $data_tbl_sales_request['sales_request_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Produk
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Produk
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#product_sell_id" data-placeholder="Produk" name="product_sell_id">
													<option value=""></option>
													<?php
														$tbl_product_sell = mysql_query("SELECT product_sell_id, product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
														while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
														{
															$tbl_sales_request_detail = mysql_query("SELECT sales_request_detail_id FROM sales_request_detail WHERE sales_request_id = '".$data_tbl_sales_request['sales_request_id']."' AND product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
															$jumlah_tbl_sales_request_detail = mysql_num_rows($tbl_sales_request_detail);

															if ($jumlah_tbl_sales_request_detail < 1)
															{
													?>
															<option value="<?php echo $data_tbl_product_sell['product_sell_id'] ?>"><?php echo $data_tbl_product_sell['product_sell_name'] ?></option>
													<?php
															}
														}
													?>
												</select>
												<div id="product_sell_id"></div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Jumlah
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="sales_request_detail_product_sell_quantity" placeholder="Jumlah" type="text">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline blue sbold">
										<i class="fa fa-plus"></i>
										Tambah
									</button>
								<?php
									$tbl_sales_request_detail = mysql_query("SELECT sales_request_detail_id FROM sales_request_detail WHERE sales_request_id = '".$data_tbl_sales_request['sales_request_id']."'");
									$jumlah_tbl_sales_request_detail = mysql_num_rows($tbl_sales_request_detail);
									
									if ($jumlah_tbl_sales_request_detail > 0)
									{
								?>
									<button type="button" class="btn btn-sm btn-outline green sbold" onclick="location.href='?alimms=sales-request&tib=update-program-customer&customer_id=<?php echo $data_tbl_sales_request['customer_id'] ?>'">
										<i class="fa fa-check"></i>
										Selesai
									</button>
								<?php
									}
								?>
								</div>
							</form>
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
											Produk
										</th>
										<th>
											Jumlah
										</th>
										<th>
											Harga Satuan
										</th>
										<th>
											Extra
										</th>
										<th>
											Potongan Diskon (Rp)
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
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#remove_product_sell_sales_request_detail_id_<?php echo $data_tbl_sales_request_detail['sales_request_detail_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										</td>
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
											<?php echo $product_sell_sub_total_indo ?>
										</td>
									</tr>
									<div aria-hidden="true" class="modal fade" id="remove_product_sell_sales_request_detail_id_<?php echo $data_tbl_sales_request_detail['sales_request_detail_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=sales-request&tib=remove-product-sell-sales-request&sales_request_detail_id=<?php echo $data_tbl_sales_request_detail['sales_request_detail_id'] ?>">
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
	function form_edit_sales_request()
	{
		$tbl_sales_request = mysql_query("SELECT sales_request_id, salesman_id, customer_id, sales_request_payment_method, sales_request_order_method, sales_request_delivery_schedule_date, sales_request_product_sell_program_mix FROM sales_request WHERE sales_request_id = '".$_GET['sales_request_id']."'");
		$data_tbl_sales_request = mysql_fetch_array($tbl_sales_request);
		
		$sales_request_delivery_schedule_date = explode("-", $data_tbl_sales_request['sales_request_delivery_schedule_date']);
		$date_sales_request_delivery_schedule = $sales_request_delivery_schedule_date[2];
		$month_sales_request_delivery_schedule = $sales_request_delivery_schedule_date[1];
		$year_sales_request_delivery_schedule = $sales_request_delivery_schedule_date[0];
		$sales_request_delivery_schedule_date = date("d-m-Y", mktime(0, 0, 0, $month_sales_request_delivery_schedule, $date_sales_request_delivery_schedule, $year_sales_request_delivery_schedule));
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
						<div class="form portlet-body">
							<form action="?alimms=sales-request&tib=edit-sales-request" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="sales_request_id" type="hidden" value="<?php echo $data_tbl_sales_request['sales_request_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Permintaan Penjualan
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Salesman
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#salesman_id" data-placeholder="Salesman" name="salesman_id">
													<option value=""></option>
													<?php
														$tbl_user = mysql_query("SELECT a.user_id, a.user_name FROM user a, user_category b WHERE a.user_active = '1' AND b.user_category_active = '1' AND a.user_category_id = b.user_category_id AND b.user_category_name LIKE 'Salesman%' ORDER BY a.user_name");
														while($data_tbl_user = mysql_fetch_array($tbl_user))
														{
															if ($data_tbl_user['user_id'] == $data_tbl_sales_request['salesman_id'])
															{
													?>
															<option selected="selected" value="<?php echo $data_tbl_user['user_id'] ?>"><?php echo $data_tbl_user['user_name'] ?></option>
													<?php
															} 
															else 
															{
													?>
															<option value="<?php echo $data_tbl_user['user_id'] ?>"><?php echo $data_tbl_user['user_name'] ?></option>
													<?php
															}
														}
													?>
												</select>
												<div id="salesman_id"></div>
											</div>
										</div>
										<div class="col-md-6">
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
														$tbl_customer = mysql_query("SELECT a.customer_id, a.customer_code, a.customer_name, a.customer_address, b.customer_category_name, c.customer_districts_name FROM customer a, customer_category b, customer_districts c WHERE a.customer_active = '1' AND b.customer_category_active = '1' AND c.customer_districts_active = '1' AND a.customer_category_id = b.customer_category_id AND a.customer_districts_id = c.customer_districts_id ORDER BY a.customer_code");
														while($data_tbl_customer = mysql_fetch_array($tbl_customer))
														{
															if ($data_tbl_customer['customer_id'] == $data_tbl_sales_request['customer_id'])
															{
													?>
															<option selected="selected" value="<?php echo $data_tbl_customer['customer_id'] ?>"><?php echo $data_tbl_customer['customer_category_name'] ?> - <?php echo $data_tbl_customer['customer_code'] ?> - <?php echo $data_tbl_customer['customer_name'] ?> - <?php echo $data_tbl_customer['customer_address'] ?> (<?php echo $data_tbl_customer['customer_districts_name'] ?>)</option>
													<?php
															} 
															else 
															{
													?>
															<option value="<?php echo $data_tbl_customer['customer_id'] ?>"><?php echo $data_tbl_customer['customer_category_name'] ?> - <?php echo $data_tbl_customer['customer_code'] ?> - <?php echo $data_tbl_customer['customer_name'] ?> - <?php echo $data_tbl_customer['customer_address'] ?> (<?php echo $data_tbl_customer['customer_districts_name'] ?>)</option>
													<?php
															}
														}
													?>
												</select>
												<div id="customer_id"></div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Cara Pembayaran
												</label>
												<div class="radio-list">
												<?php
													if ($data_tbl_sales_request['sales_request_payment_method'] == "Cash")
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
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Cara Pesanan
												</label>
												<div class="radio-list">
												<?php
													if ($data_tbl_sales_request['sales_request_order_method'] == "By Phone")
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
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d" name="sales_request_delivery_schedule_date" placeholder="Jadwal Pengiriman" type="text" value="<?php echo $sales_request_delivery_schedule_date ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Program Mix Produk
												</label>
												<div class="radio-list">
												<?php
													if ($data_tbl_sales_request['sales_request_product_sell_program_mix'] == "Ya")
													{
												?>
													<label class="radio-inline">
														<input checked="checked" name="sales_request_product_sell_program_mix" type="radio" value="Ya">
															Ya
													</label>
													<label class="radio-inline">
														<input name="sales_request_product_sell_program_mix" type="radio" value="Tidak">
															Tidak
													</label>
												<?php
													}
													else
													{
												?>
													<label class="radio-inline">
														<input name="sales_request_product_sell_program_mix" type="radio" value="Ya">
															Ya
													</label>
													<label class="radio-inline">
														<input checked="checked" name="sales_request_product_sell_program_mix" type="radio" value="Tidak">
															Tidak
													</label>
												<?php
													}
												?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline purple sbold">
										<i class="fa fa-rss"></i>
										Proses
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=sales-request'">
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
	function form_view_sales_request()
	{
		$tbl_sales_request = mysql_query("SELECT a.sales_request_id, a.sales_request_no, a.sales_request_date, a.sales_request_payment_method, a.sales_request_order_method, a.sales_request_product_sell_program_mix, b.user_name, c.customer_code, c.customer_name, d.customer_category_name, e.customer_districts_name FROM sales_request a, user b, customer c, customer_category d, customer_districts e WHERE a.sales_request_id = '".$_GET['sales_request_id']."' AND a.salesman_id = b.user_id AND a.customer_id = c.customer_id AND c.customer_category_id = d.customer_category_id AND c.customer_districts_id = e.customer_districts_id");
		$data_tbl_sales_request = mysql_fetch_array($tbl_sales_request);
		
		$sales_request_date_indo = tanggal_indo($data_tbl_sales_request['sales_request_date']);
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_sales_request['sales_request_no'] ?>
					<small>
						<?php echo $sales_request_date_indo ?>
					</small>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_request['user_name'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_request['customer_category_name'] ?> - <?php echo $data_tbl_sales_request['customer_code'] ?> - <?php echo $data_tbl_sales_request['customer_name'] ?> (<?php echo $data_tbl_sales_request['customer_districts_name'] ?>)
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_request['sales_request_payment_method'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_request['sales_request_order_method'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							Program Mix Produk (<?php echo $data_tbl_sales_request['sales_request_product_sell_program_mix'] ?>)
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
							<div class="actions">
								<a class="btn btn-outline btn-sm sbold yellow" href="?alimms=sales-request">
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
											Extra
										</th>
										<th>
											Potongan Diskon (Rp)
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
											<?php echo $sales_request_detail_cash_discount ?>
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