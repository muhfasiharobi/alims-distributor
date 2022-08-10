<?php
	function form_initial_sales_visit()
	{
		$tgl_pertama = date('Y-m-01', strtotime($tgl_sekarang));
		$tgl_terakhir = date('Y-m-t', strtotime($tgl_sekarang));
$tgl_sekarang = date('Y-m-d');
?>
		<div class="page-fixed-main-content">	 
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
						<div class="form portlet-body">
						<form action="?alimms=sales-visit" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
                                <div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>
												Salesman
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#salesman_id" data-placeholder="Salesman" name="salesman_id">
													<option value=""></option>
													<option value="all">Semua</option>
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
											Salesman
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
											Status
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									if($_POST['salesman_id'] == "all")
									{
										
										$tbl_sales_visit = mysql_query("SELECT a.sales_visit_id, a.sales_visit_status, a.sales_visit_description, b.sales_plan_date, d.customer_code, d.customer_name, d.customer_address, e.customer_category_name, e.customer_category_name, f.customer_districts_name, g.user_name FROM sales_visit a, sales_plan b, sales_plan_detail c, customer d, customer_category e, customer_districts f, user g WHERE b.sales_plan_active = '1' AND d.customer_active = '1' AND e.customer_category_active = '1' AND f.customer_districts_active = '1' AND g.user_active = '1' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id AND c.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id AND b.salesman_id = g.user_id AND b.sales_plan_date = '".$tgl_sekarang."' ORDER BY b.sales_plan_date DESC, g.user_name, a.sales_visit_status");
									
									}
									else
									{
										$tbl_sales_visit = mysql_query("SELECT a.sales_visit_id, a.sales_visit_status, a.sales_visit_description, b.sales_plan_date, d.customer_code, d.customer_name, d.customer_address, e.customer_category_name, e.customer_category_name, f.customer_districts_name, g.user_name FROM sales_visit a, sales_plan b, sales_plan_detail c, customer d, customer_category e, customer_districts f, user g WHERE b.salesman_id = '".$_POST['salesman_id']."' AND b.sales_plan_active = '1' AND d.customer_active = '1' AND e.customer_category_active = '1' AND f.customer_districts_active = '1' AND g.user_active = '1' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id AND c.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id AND b.salesman_id = g.user_id AND b.sales_plan_date = '".$tgl_sekarang."' ORDER BY b.sales_plan_date DESC, g.user_name, a.sales_visit_status");
									
									}
									$no = 1;
									while ($data_tbl_sales_visit = mysql_fetch_array($tbl_sales_visit))
									{
										$sales_plan_date_indo = tanggal_indo($data_tbl_sales_visit['sales_plan_date']);
								?>
									<tr class="odd gradeX">
										<td>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=sales-visit&tib=form-view-sales-visit&sales_visit_id=<?php echo $data_tbl_sales_visit['sales_visit_id'] ?>">
												<i class="fa fa-search"></i>
											</a>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=sales-visit&tib=form-edit-sales-visit&sales_visit_id=<?php echo $data_tbl_sales_visit['sales_visit_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
										</td>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_visit['user_name'] ?>
										</td>
										<td>
											<?php echo $sales_plan_date_indo ?>
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
	function form_edit_sales_visit()
	{
		$tbl_sales_visit = mysql_query("SELECT a.sales_visit_id, a.sales_visit_status, a.sales_visit_description, b.sales_plan_date, c.customer_id, d.customer_code, d.customer_name, d.customer_address, e.customer_category_name, f.customer_districts_name, g.user_id, g.user_name FROM sales_visit a, sales_plan b, sales_plan_detail c, customer d, customer_category e, customer_districts f, user g WHERE b.sales_plan_active = '1' AND d.customer_active = '1' AND e.customer_category_active = '1' AND f.customer_districts_active = '1' AND g.user_active = '1' AND a.sales_visit_id = '".$_GET['sales_visit_id']."' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id AND b.salesman_id = g.user_id AND c.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id");
		$data_tbl_sales_visit = mysql_fetch_array($tbl_sales_visit);
		
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
						</div>
						<div class="portlet-body form">
							<form action="?alimms=sales-visit&tib=edit-sales-visit" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="sales_visit_id" type="hidden" value="<?php echo $data_tbl_sales_visit['sales_visit_id'] ?>">
							<input class="form-control" name="sales_plan_date" type="hidden" value="<?php echo $data_tbl_sales_visit['sales_plan_date'] ?>">
							<input class="form-control" name="user_id" type="hidden" value="<?php echo $data_tbl_sales_visit['user_id'] ?>">
							<input class="form-control" name="customer_id" type="hidden" value="<?php echo $data_tbl_sales_visit['customer_id'] ?>">
							<input class="form-control" name="sales_request_order_method" type="hidden" value="By Visit">
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
												<input class="form-control" name="product_sell_id[]" type="hidden" value="<?php echo $data_tbl_product_sell['product_sell_id'] ?>">
												<input class="form-control" name="sales_visit_detail_product_sell_quantity[]" placeholder="<?php echo $data_tbl_product_sell['product_sell_name'] ?>" type="text" value="<?php echo $data_tbl_sales_visit_detail['sales_visit_detail_product_sell_quantity'] ?>">
											</div>
										</div>
									<?php
										}
									?>
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
												<div class="radio-list">
												<?php
													if ($data_tbl_sales_visit['sales_visit_status'] == "Not Order")
													{
												?>
													<label class="radio-inline">
														<input checked="checked" name="sales_visit_status" type="radio" value="Not Order">
															Not Order
													</label>
													<label class="radio-inline">
														<input name="sales_visit_status" type="radio" value="Order">
															Order
													</label>
												<?php
													}
													else
													{
												?>
													<label class="radio-inline">
														<input name="sales_visit_status" type="radio" value="Not Order">
															Not Order
													</label>
													<label class="radio-inline">
														<input checked="checked" name="sales_visit_status" type="radio" value="Order">
															Order
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
													if ($data_tbl_sales_visit['sales_visit_status'] == "Not Order")
													{
												?>
													<input class="form-control" name="sales_visit_description" placeholder="Keterangan" type="text" value="<?php echo $data_tbl_sales_visit['sales_visit_description'] ?>">
												<?php
													}
													else
													{
												?>
													<input class="form-control" name="sales_visit_description" placeholder="Keterangan" type="text">
												<?php
													}
												?>
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
	function form_order_sales_visit()
	{
		$tgl_besok = date("d-m-Y", mktime(0,0,0, date("m"), date("d") + 1, date("Y")));
		
		$tbl_sales_visit = mysql_query("SELECT a.sales_visit_id, b.sales_plan_date, d.customer_id, d.customer_code, d.customer_name, d.customer_address, e.customer_category_name, f.customer_districts_name, g.user_id, g.user_name FROM sales_visit a, sales_plan b, sales_plan_detail c, customer d, customer_category e, customer_districts f, user g WHERE b.sales_plan_active = '1' AND d.customer_active = '1' AND e.customer_category_active = '1' AND f.customer_districts_active = '1' AND g.user_active = '1' AND a.sales_visit_id = '".$_GET['sales_visit_id']."' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id AND b.salesman_id = g.user_id AND c.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id");
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
							<form action="?alimms=sales-visit&tib=order-sales-visit" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="user_id" type="hidden" value="<?php echo $data_tbl_sales_visit['user_id'] ?>">
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
	function form_product_sell_sales_visit()
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
						</div>
						<div class="portlet-body form">
							<form action="?alimms=sales-visit&tib=product-sell-sales-visit" class="horizontal-form" id="form_sample_3" method="post">
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
												<select class="form-control select2me" data-placeholder="Produk" name="product_sell_id" />
													<option value=""></option>
													<?php
														$tbl_product_sell = mysql_query("SELECT product_sell_id, product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
														while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
														{
													?>
														<option value="<?php echo $data_tbl_product_sell['product_sell_id'] ?>"><?php echo $data_tbl_product_sell['product_sell_name'] ?></option>
													<?php	
														}
													?>
												</select>
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
												<input type="text" class="form-control" name="sales_request_detail_product_sell_quantity" placeholder="Jumlah">
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
									<button type="button" class="btn btn-sm btn-outline green sbold" onclick="location.href='?alimms=sales-visit';">
										<i class="fa fa-check"></i>
										Selesai
									</button>
								<?php
									}
									else
									{
								?>
									<button type="submit" class="btn btn-sm btn-outline blue sbold">
										<i class="fa fa-plus"></i>
										Tambah
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
											<?php echo $sales_request_detail_cash_discount ?>
										</td>
										<td>
											<?php echo $sales_request_detail_delivery_cost_price_indo ?>
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
	function form_view_sales_visit()
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
								<a class="btn btn-outline btn-sm sbold yellow" href="?alimms=sales-visit">
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
?>