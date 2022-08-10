<?php
	function form_initial_sales_request_galon()
	{
		$tgl_sekarang = date("Y-m-d");
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
									Permintaan Penjualan Galon
								</span>
							</div>
							<div class="actions">
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=sales-request-galon&tib=form-add-sales-request-galon">
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
											Cara Pesanan
										</th>
										<th>
											Kategori Pelanggan
										</th>
										<th>
											Program
										</th>
										<th>
											Status
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_sales_request = mysql_query("SELECT a.sales_request_id, a.sales_request_no, a.sales_request_date,  a.sales_request_order_method, a.sales_request_status, b.user_name, c.customer_code, c.customer_name, d.customer_category_name, e.customer_districts_name, f.customer_galon_category_name, g.selling_program_galon_description FROM sales_request a, user b, customer c, customer_category d, customer_districts e, customer_galon_category f, selling_program_galon g WHERE a.sales_request_date = '".$tgl_sekarang."' AND a.salesman_id = b.user_id AND a.customer_id = c.customer_id AND c.customer_category_id = d.customer_category_id AND c.customer_districts_id = e.customer_districts_id AND c.customer_galon_category_id = f.customer_galon_category_id AND c.selling_program_galon_id = g.selling_program_galon_id ORDER BY a.sales_request_date desc, a.sales_request_no");
									while ($data_tbl_sales_request = mysql_fetch_array($tbl_sales_request))
									{
										$sales_request_date_indo = tanggal_indo($data_tbl_sales_request['sales_request_date']);
										
								?>
									<tr class="odd gradeX">
										<td>
										<?php
											if ($data_tbl_sales_request['sales_request_date'] == $tgl_sekarang)
											{
												if ($data_tbl_sales_request['sales_request_status'] == "Canceled" || $data_tbl_sales_request['sales_request_status'] == "Closed")
												{
										?>
												<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=sales-request-galon&tib=form-view-sales-request-galon&sales_request_id=<?php echo $data_tbl_sales_request['sales_request_id'] ?>">
													<i class="fa fa-search"></i>
												</a>
										<?php
												}
												else
												{
										?>
												<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=sales-request-galon&tib=form-view-sales-request-galon&sales_request_id=<?php echo $data_tbl_sales_request['sales_request_id'] ?>">
													<i class="fa fa-search"></i>
												</a>
												<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=sales-request-galon&tib=form-edit-sales-request-galon&sales_request_id=<?php echo $data_tbl_sales_request['sales_request_id'] ?>">
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
											<?php echo $data_tbl_sales_request['sales_request_order_method'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_request['customer_galon_category_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_request['selling_program_galon_description'] ?>
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=sales-request-galon&tib=delete-sales-request-galon&sales_request_id=<?php echo $data_tbl_sales_request['sales_request_id'] ?>">
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
	function form_add_sales_request_galon()
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
									Permintaan Penjualan Galon
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=sales-request-galon&tib=add-sales-request-galon" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<h4 class="form-section">
										Permintaan Penjualan Galon
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
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline purple sbold">
										<i class="fa fa-rss"></i>
										Proses
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=sales-request-galon'">
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
	function form_product_sell_sales_request_galon()
	{
		$tbl_sales_request = mysql_query("SELECT a.sales_request_id, a.sales_request_no, a.sales_request_date, a.sales_request_payment_method, a.sales_request_order_method, a.sales_request_product_sell_program_mix, b.user_name, c.customer_code, c.customer_name, d.customer_category_name, e.customer_districts_name, f.customer_galon_category_name, g.selling_program_galon_description, g.selling_program_galon_name, c.customer_id FROM sales_request a, user b, customer c, customer_category d, customer_districts e, customer_galon_category f, selling_program_galon g WHERE a.sales_request_id = '".$_GET['sales_request_id']."' AND a.salesman_id = b.user_id AND a.customer_id = c.customer_id AND c.customer_category_id = d.customer_category_id AND c.customer_districts_id = e.customer_districts_id AND c.customer_galon_category_id = f.customer_galon_category_id AND c.selling_program_galon_id = g.selling_program_galon_id");
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
							<?php echo $data_tbl_sales_request['customer_galon_category_name'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_request['sales_request_order_method'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_request['selling_program_galon_description'] ?>
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
							<form action="?alimms=sales-request-galon&tib=product-sell-sales-request-galon" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="sales_request_id" type="hidden" value="<?php echo $data_tbl_sales_request['sales_request_id'] ?>">
								<div class="form-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Jenis Transaksi
													<span class="required">
														*
													</span>
												</label>
												<div class="radio-list" data-error-container="#sales_request_payment_method">
												<?php if($data_tbl_sales_request['selling_program_galon_name'] == '0'){ ?>
												
													<label class="radio-inline">
														<input name="sales_request_payment_method" type="radio" value="RO">
															RO
													</label>
													
												<?php } else { ?>
												
													<label class="radio-inline">
														<input name="sales_request_payment_method" type="radio" value="N">
															N
													</label>
													
												<?php } ?>
												
													<label class="radio-inline">
														<input name="sales_request_payment_method" type="radio" value="TG">
															TG
													</label>
												</div>
												<div id="sales_request_payment_method"></div>
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
									<button type="button" class="btn btn-sm btn-outline green sbold" onclick="location.href='?alimms=sales-request-galon&tib=update-program-customer&customer_id=<?php echo $data_tbl_sales_request['customer_id'] ?>'">
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
											Jenis Transaksi
										</th>
										<th>
											Jumlah
										</th>
										<th>
											Extra Galon
										</th>
										<th>
											Galon Keluar
										</th>
										<th>
											HPP Galon
										</th>
										<th>
											Harga Air
										</th>
										<th>
											Value Galon
										</th>
										<th>
											Value Air
										</th>
										<th>
											Total value
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_sales_request_detail = mysql_query("SELECT a.sales_request_detail_id, a.sales_request_detail_product_sell_quantity, a.sales_request_detail_product_sell_price, a.sales_request_detail_program_bonus, a.sales_request_detail_piece_discount, a.sales_request_detail_cash_discount, a.sales_request_detail_delivery_cost_price, b.product_sell_name, d.transaction_galon_name, c.galon_price, c.refill_price FROM sales_request_detail a, product_sell b, product_promo_galon c, transaction_galon d WHERE a.sales_request_id = '".$data_tbl_sales_request['sales_request_id']."' AND a.product_sell_id = b.product_sell_id AND a.product_promo_galon_id = c.product_promo_galon_id AND c.transaction_galon_id = d.transaction_galon_id ORDER BY b.product_sell_code");
									while ($data_tbl_sales_request_detail = mysql_fetch_array($tbl_sales_request_detail))
									{
										$sales_request_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity']);
										$sales_request_detail_product_sell_price_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_product_sell_price']);
										$sales_request_detail_piece_discount_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_piece_discount']);
										$sales_request_detail_cash_discount = ($data_tbl_sales_request_detail['sales_request_detail_cash_discount'] / $data_tbl_sales_request_detail['sales_request_detail_product_sell_price']) * 100;
										$sales_request_detail_delivery_cost_price_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_delivery_cost_price']);
										
										
										$galon_price_indo = format_angka($data_tbl_sales_request_detail['galon_price']);
										$refill_price_indo = format_angka($data_tbl_sales_request_detail['refill_price']);
										
										$value_galon_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] * $data_tbl_sales_request_detail['galon_price']);
										
										$value_refill_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] * $data_tbl_sales_request_detail['refill_price']);
										
										$product_sell_sub_total_indo = format_angka(($data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] * $data_tbl_sales_request_detail['refill_price']) + ($data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] * $data_tbl_sales_request_detail['galon_price']));
										
										$product_out_total = $sales_request_detail_product_sell_quantity_indo + $data_tbl_sales_request_detail['sales_request_detail_program_bonus'];
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
											<?php echo $data_tbl_sales_request_detail['transaction_galon_name'] ?>
										</td>
										<td>
											<?php echo $sales_request_detail_product_sell_quantity_indo ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_request_detail['sales_request_detail_program_bonus'] ?>
										</td>
										<td>
											<?php echo $product_out_total ?>
										</td>
										<td>
											<?php echo $galon_price_indo ?>
										</td>
										<td>
											<?php echo $refill_price_indo ?>
										</td>
										<td>
											<?php echo $value_galon_indo ?>
										</td>
										<td>
											<?php echo $value_refill_indo ?>
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=sales-request-galon&tib=remove-product-sell-sales-request-galon&sales_request_detail_id=<?php echo $data_tbl_sales_request_detail['sales_request_detail_id'] ?>">
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
	function form_edit_sales_request_galon()
	{
		$tbl_sales_request = mysql_query("SELECT sales_request_id, salesman_id, customer_id, sales_request_order_method FROM sales_request WHERE sales_request_id = '".$_GET['sales_request_id']."'");
		$data_tbl_sales_request = mysql_fetch_array($tbl_sales_request);
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Permintaan Penjualan Galon
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=sales-request-galon&tib=edit-sales-request-galon" class="horizontal-form" id="form_sample_3" method="post">
							<input type="hidden" name="sales_request_id" value="<?php echo $_GET['sales_request_id'] ?>" />
								<div class="form-body">
									<h4 class="form-section">
										Permintaan Penjualan Galon
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
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline purple sbold">
										<i class="fa fa-rss"></i>
										Proses
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=sales-request-galon'">
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
	function form_view_sales_request_galon()
	{
		$tbl_sales_request = mysql_query("SELECT a.sales_request_id, a.sales_request_no, a.sales_request_date, a.sales_request_payment_method, a.sales_request_order_method, a.sales_request_product_sell_program_mix, b.user_name, c.customer_code, c.customer_name, d.customer_category_name, e.customer_districts_name, f.customer_galon_category_name, g.selling_program_galon_description, g.selling_program_galon_name FROM sales_request a, user b, customer c, customer_category d, customer_districts e, customer_galon_category f, selling_program_galon g WHERE a.sales_request_id = '".$_GET['sales_request_id']."' AND a.salesman_id = b.user_id AND a.customer_id = c.customer_id AND c.customer_category_id = d.customer_category_id AND c.customer_districts_id = e.customer_districts_id AND c.customer_galon_category_id = f.customer_galon_category_id AND c.selling_program_galon_id = g.selling_program_galon_id");
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
							<?php echo $data_tbl_sales_request['customer_galon_category_name'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_request['sales_request_order_method'] ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_sales_request['selling_program_galon_description'] ?>
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
								<a class="btn btn-outline btn-sm sbold yellow" href="?alimms=sales-request-galon">
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
										</th>
										<th>
											No
										</th>
										<th>
											Jenis Transaksi
										</th>
										<th>
											Jumlah
										</th>
										<th>
											Extra Galon
										</th>
										<th>
											Galon Keluar
										</th>
										<th>
											HPP Galon
										</th>
										<th>
											Harga Air
										</th>
										<th>
											Value Galon
										</th>
										<th>
											Value Air
										</th>
										<th>
											Total value
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_sales_request_detail = mysql_query("SELECT a.sales_request_detail_id, a.sales_request_detail_product_sell_quantity, a.sales_request_detail_product_sell_price, a.sales_request_detail_program_bonus, a.sales_request_detail_piece_discount, a.sales_request_detail_cash_discount, a.sales_request_detail_delivery_cost_price, b.product_sell_name, d.transaction_galon_name, c.galon_price, c.refill_price FROM sales_request_detail a, product_sell b, product_promo_galon c, transaction_galon d WHERE a.sales_request_id = '".$data_tbl_sales_request['sales_request_id']."' AND a.product_sell_id = b.product_sell_id AND a.product_promo_galon_id = c.product_promo_galon_id AND c.transaction_galon_id = d.transaction_galon_id ORDER BY b.product_sell_code");
									while ($data_tbl_sales_request_detail = mysql_fetch_array($tbl_sales_request_detail))
									{
										$sales_request_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity']);
										$sales_request_detail_product_sell_price_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_product_sell_price']);
										$sales_request_detail_piece_discount_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_piece_discount']);
										$sales_request_detail_cash_discount = ($data_tbl_sales_request_detail['sales_request_detail_cash_discount'] / $data_tbl_sales_request_detail['sales_request_detail_product_sell_price']) * 100;
										$sales_request_detail_delivery_cost_price_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_delivery_cost_price']);
										
										
										$galon_price_indo = format_angka($data_tbl_sales_request_detail['galon_price']);
										$refill_price_indo = format_angka($data_tbl_sales_request_detail['refill_price']);
										
										$value_galon_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] * $data_tbl_sales_request_detail['galon_price']);
										
										$value_refill_indo = format_angka($data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] * $data_tbl_sales_request_detail['refill_price']);
										
										$product_sell_sub_total_indo = format_angka(($data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] * $data_tbl_sales_request_detail['refill_price']) + ($data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] * $data_tbl_sales_request_detail['galon_price']));
										
										$product_out_total = $sales_request_detail_product_sell_quantity_indo + $data_tbl_sales_request_detail['sales_request_detail_program_bonus'];
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
											<?php echo $data_tbl_sales_request_detail['transaction_galon_name'] ?>
										</td>
										<td>
											<?php echo $sales_request_detail_product_sell_quantity_indo ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_request_detail['sales_request_detail_program_bonus'] ?>
										</td>
										<td>
											<?php echo $product_out_total ?>
										</td>
										<td>
											<?php echo $galon_price_indo ?>
										</td>
										<td>
											<?php echo $refill_price_indo ?>
										</td>
										<td>
											<?php echo $value_galon_indo ?>
										</td>
										<td>
											<?php echo $value_refill_indo ?>
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