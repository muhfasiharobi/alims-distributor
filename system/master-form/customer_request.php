<?php
	function form_initial_customer_request()
	{
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
										<th>
											Status
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_customer_request = mysql_query("SELECT a.customer_request_id, a.customer_request_date, a.customer_request_name, a.customer_request_address, a.customer_request_contact, a.customer_request_phone, a.customer_request_status, a.customer_request_description, b.customer_districts_name FROM customer_request a, customer_districts b WHERE a.customer_request_active = '1' AND b.customer_districts_active = '1' AND a.customer_districts_id = b.customer_districts_id ORDER BY a.customer_request_date DESC");
									while ($data_tbl_customer_request = mysql_fetch_array($tbl_customer_request))
									{
										$customer_request_date_indo = tanggal_indo($data_tbl_customer_request['customer_request_date']);
								?>
									<tr class="odd gradeX">
										<td>
										<?php
											
											if ($data_tbl_customer_request['customer_request_status'] == "Approved" || $data_tbl_customer_request['customer_request_status'] == "Not Approved")
											{
											}
											else
											{
										?>
											<a class="btn btn-icon-only btn-outline purple tooltips" data-original-title="Proses" data-toggle="modal" href="#approval_customer_request_id_<?php echo $data_tbl_customer_request['customer_request_id'] ?>">
												<i class="fa fa-map"></i>
											</a>
										<?php
											}
										?>
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
										<td>
										<?php
											if ($data_tbl_customer_request['customer_request_status'] == "On Hold")
											{
										?>
											<span class="label label-info label-sm">On Hold</span>
										<?php
											}
											elseif ($data_tbl_customer_request['customer_request_status'] == "Approved")
											{
										?>
											<span class="label label-success label-sm">Approved</span>
										<?php
											}
											else
											{
										?>
											<span class="label label-danger label-sm">Not Approved</span><br />
											<?php echo $data_tbl_customer_request['customer_request_description'] ?>
										<?php
											}
										?>
										</td>
									</tr>
									<div aria-hidden="true" class="modal fade" id="approval_customer_request_id_<?php echo $data_tbl_customer_request['customer_request_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=customer-request&tib=form-approval-customer-request&customer_request_id=<?php echo $data_tbl_customer_request['customer_request_id'] ?>">
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
	function form_approval_customer_request()
	{
		$tbl_customer_request = mysql_query("SELECT a.customer_request_id, a.customer_request_date, a.customer_request_name, a.customer_request_address, a.customer_request_contact, a.customer_request_phone, b.customer_districts_name FROM customer_request a, customer_districts b WHERE a.customer_request_id = '".$_GET['customer_request_id']."' AND a.customer_districts_id = b.customer_districts_id");
		$data_tbl_customer_request = mysql_fetch_array($tbl_customer_request);
		
		$customer_request_date_indo = tanggal_indo($data_tbl_customer_request['customer_request_date']);
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_customer_request['customer_request_name'] ?>
					<small>
						<?php echo $customer_request_date_indo ?>
					</small>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_customer_request['customer_request_address'] ?> (<?php echo $data_tbl_customer_request['customer_districts_name'] ?>)
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $data_tbl_customer_request['customer_request_contact'] ?> (<?php echo $data_tbl_customer_request['customer_request_phone'] ?>)
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
									Permintaan Pelanggan
								</span>
							</div>
						</div>
						<div class="portlet-body form">
							<form action="?alimms=customer-request&tib=approval-customer-request" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="customer_request_id" type="hidden" value="<?php echo $data_tbl_customer_request['customer_request_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Status Permintaan
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Status Permintaan
													<span class="required">
														*
													</span>
												</label>
												<div class="radio-list" data-error-container="#sales_order_status">
													<label class="radio-inline">
														<input name="customer_request_status" type="radio" value="Approved">
															Approved
													</label>
													<label class="radio-inline">
														<input name="customer_request_status" type="radio" value="Not Approved">
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
												<input class="form-control" name="customer_request_description" placeholder="Keterangan" type="text">
												<span class="help-block">
													*) Jika Status Approved, Keterangan Dikosongkan
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
	function form_registration_customer_request()
	{
		$tbl_customer = mysql_query("SELECT customer_id, customer_code, customer_name, customer_address, customer_districts_id, customer_contact, customer_phone FROM customer WHERE customer_id = '".$_GET['customer_id']."'");
		$data_tbl_customer = mysql_fetch_array($tbl_customer);
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Pelanggan
								</span>
							</div>
						</div>
						<div class="portlet-body form">
							<form action="?alimms=customer-request&tib=registration-customer-request" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="customer_id" type="hidden" value="<?php echo $data_tbl_customer['customer_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Klasifikasi Pelanggan
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
												<select class="form-control select2me" data-placeholder="Kategori" name="customer_category_id">
													<option value=""></option>
													<?php
														$tbl_customer_category = mysql_query("SELECT customer_category_id, customer_category_name FROM customer_category WHERE customer_category_active = '1' ORDER BY customer_category_name");
														while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
														{
													?>
														<option value="<?php echo $data_tbl_customer_category['customer_category_id'] ?>"><?php echo $data_tbl_customer_category['customer_category_name'] ?></option>
													<?php	
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kelas
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-placeholder="Kelas" name="customer_class_id">
													<option value=""></option>
													<?php
														$tbl_customer_class = mysql_query("SELECT customer_class_id, customer_class_name FROM customer_class WHERE customer_class_active = '1' ORDER BY customer_class_name");
														while($data_tbl_customer_class = mysql_fetch_array($tbl_customer_class))
														{
													?>
														<option value="<?php echo $data_tbl_customer_class['customer_class_id'] ?>"><?php echo $data_tbl_customer_class['customer_class_name'] ?></option>
													<?php	
														}
													?>
												</select>
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
													Kode
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="customer_code" placeholder="Kode" type="text" value="<?php echo $data_tbl_customer['customer_code'] ?>">
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
												<input class="form-control" disabled="disabled" name="customer_name" placeholder="Nama" type="text" value="<?php echo $data_tbl_customer['customer_name'] ?>">
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
												<input class="form-control" disabled="disabled" name="customer_address" placeholder="Alamat" type="text" value="<?php echo $data_tbl_customer['customer_address'] ?>">
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
												<select class="form-control select2me" data-placeholder="Kecamatan" disabled="disabled" name="customer_districts_id">
													<option value=""></option>
													<?php
														$tbl_customer_districts = mysql_query("SELECT customer_districts_id, customer_districts_name FROM customer_districts WHERE customer_districts_active = '1' ORDER BY customer_districts_name");
														while($data_tbl_customer_districts = mysql_fetch_array($tbl_customer_districts))
														{
															if ($data_tbl_customer_districts['customer_districts_id'] == $data_tbl_customer['customer_districts_id'])
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
												<input class="form-control" disabled="disabled" name="customer_contact" placeholder="Kontak" type="text" value="<?php echo $data_tbl_customer['customer_contact'] ?>">
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
												<input class="form-control" disabled="disabled" name="customer_phone" placeholder="No. Telepon" type="text" value="<?php echo $data_tbl_customer['customer_phone'] ?>">
											</div>
										</div>
									</div>
									<h4 class="form-section">
										Harga Jual Produk
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Harga Jual Produk
													<span class="required">
														*
													</span>
												</label>
												<div class="radio-list" data-error-container="#product_sell_price">
												<?php
													$tbl_product_sell_price = mysql_query("SELECT product_sell_price_id, product_sell_price_name FROM product_sell_price WHERE product_sell_price_active = '1' ORDER BY product_sell_price_name");
													while($data_tbl_product_sell_price = mysql_fetch_array($tbl_product_sell_price))
													{
												?>
													<label class="radio-inline">
														<input name="product_sell_price_id" type="radio" value="<?php echo $data_tbl_product_sell_price['product_sell_price_id'] ?>">
															<?php echo $data_tbl_product_sell_price['product_sell_price_name'] ?>
													</label>
												<?php
													}
												?>
												</div>
												<div id="product_sell_price"></div>
											</div>
										</div>
									</div>
									<h4 class="form-section">Program Promo Produk</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Program Promo Produk
													<span class="required">
														*
													</span>
												</label>
												<div class="radio-list" data-error-container="#customer_product_sell_program_promo">
													<label class="radio-inline">
														<input name="customer_product_sell_program_promo" type="radio" value="Ya">
															Ya
														</label>
													<label class="radio-inline">
														<input name="customer_product_sell_program_promo" type="radio" value="Tidak">
															Tidak
													</label>
												</div>
												<div id="customer_product_sell_program_promo"></div>
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
?>