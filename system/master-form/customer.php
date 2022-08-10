<?php
	function form_initial_customer()
	{
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
							<div class="actions">
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=customer&tib=form-add-customer">
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
											Kategori
										</th>
										<th>
											Kategori Pelanggan Galon
										</th>
										<th>
											Program Galon
										</th>
										<th>
											Kelas
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
										<th>
											Kontak
										</th>
										<th>
											No. Telepon
										</th>
										<th>
											Harga Jual Produk
										</th>
										<th>
											Program Promo Produk
										</th>
										<th>
											Status
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_customer = mysql_query("SELECT a.customer_id, a.customer_code, a.customer_name, a.customer_address, a.customer_contact, a.customer_phone, a.customer_product_sell_program_promo, a.customer_active, b.customer_category_name, c.customer_class_name, d.customer_districts_name, e.product_sell_price_name, f.customer_galon_category_name, g.selling_program_galon_description FROM customer a, customer_category b, customer_class c, customer_districts d, product_sell_price e, customer_galon_category f, selling_program_galon g WHERE b.customer_category_active = '1' AND c.customer_class_active = '1' AND d.customer_districts_active = '1' AND e.product_sell_price_active = '1' AND a.customer_category_id = b.customer_category_id AND a.customer_class_id = c.customer_class_id AND a.customer_districts_id = d.customer_districts_id AND a.product_sell_price_id = e.product_sell_price_id AND a.customer_galon_category_id = f.customer_galon_category_id AND a.selling_program_galon_id = g.selling_program_galon_id ORDER BY a.customer_code");
									while ($data_tbl_customer = mysql_fetch_array($tbl_customer))
									{
								?>
									<tr class="odd gradeX">
										<td>
										<?php
											if ($data_tbl_customer['customer_active'] == 1)
											{
										?>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=customer&tib=form-edit-customer&customer_id=<?php echo $data_tbl_customer['customer_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_customer_id_<?php echo $data_tbl_customer['customer_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										<?php
											}
											else
											{
										?>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Aktif" data-toggle="modal" href="#active_customer_id_<?php echo $data_tbl_customer['customer_id'] ?>">
												<i class="fa fa-exchange"></i>
											</a>
										<?php
											}
										?>
										</td>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_customer['customer_category_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_customer['customer_galon_category_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_customer['selling_program_galon_description'] ?>
										</td>
										<td>
											<?php echo $data_tbl_customer['customer_class_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_customer['customer_code'] ?>
										</td>
										<td>
											<?php echo $data_tbl_customer['customer_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_customer['customer_address'] ?>
										</td>
										<td>
											<?php echo $data_tbl_customer['customer_districts_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_customer['customer_contact'] ?>
										</td>
										<td>
											<?php echo $data_tbl_customer['customer_phone'] ?>
										</td>
										<td>
											<?php echo $data_tbl_customer['product_sell_price_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_customer['customer_product_sell_program_promo'] ?>
										</td>
										<td>
										<?php
											if ($data_tbl_customer['customer_active'] == 1)
											{
										?>
											<span class="label label-info label-sm">Active</span>
										<?php
											}
											else
											{
										?>
											<span class="label label-danger label-sm">Non Active</span>
										<?php
											}
										?>
										</td>
									</tr>
									<div aria-hidden="true" class="fade modal" id="delete_customer_id_<?php echo $data_tbl_customer['customer_id'] ?>" role="basic" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" class="close" data-dismiss="modal" type="button"></button>
                                                    <h4 class="modal-title">
														Konfirmasi
													</h4>
                                                </div>
                                                <div class="modal-body">
													Apakah Anda Yakin Ingin Menghapus Data Ini ?
												</div>
                                                <div class="modal-footer">
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=customer&tib=delete-customer&customer_id=<?php echo $data_tbl_customer['customer_id'] ?>">
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
									<div aria-hidden="true" class="fade modal" id="active_customer_id_<?php echo $data_tbl_customer['customer_id'] ?>" role="basic" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" class="close" data-dismiss="modal" type="button"></button>
                                                    <h4 class="modal-title">
														Konfirmasi
													</h4>
                                                </div>
                                                <div class="modal-body">
													Apakah Anda Yakin Ingin Mengaktifkan Data Ini ?
												</div>
                                                <div class="modal-footer">
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=customer&tib=active-customer&customer_id=<?php echo $data_tbl_customer['customer_id'] ?>">
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
	function form_add_customer()
	{
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
						<div class="form portlet-body">
							<form action="?alimms=customer&tib=add-customer" class="horizontal-form" id="form_sample_3" method="post">
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
												<select class="form-control select2me" data-error-container="#customer_category_id" data-placeholder="Kategori" name="customer_category_id">
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
												<div id="customer_category_id"></div>
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
												<select class="form-control select2me" data-error-container="#customer_class_id" data-placeholder="Kelas" name="customer_class_id">
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
												<div id="customer_class_id"></div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kategori Pelanggan Galon
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#customer_galon_category_id" data-placeholder="Kategori Pelanggan Galon" name="customer_galon_category_id">
													<option value=""></option>
													<?php
														$tbl_customer_galon_category = mysql_query("SELECT customer_galon_category_id, customer_galon_category_name FROM customer_galon_category WHERE customer_galon_category_active = '1' ORDER BY customer_galon_category_id");
														while($data_tbl_customer_galon_category = mysql_fetch_array($tbl_customer_galon_category))
														{
													?>
														<option value="<?php echo $data_tbl_customer_galon_category['customer_galon_category_id'] ?>"><?php echo $data_tbl_customer_galon_category['customer_galon_category_name'] ?></option>
													<?php	
														}
													?>
												</select>
												<div id="customer_galon_category_id"></div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Program Promo Galon
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#selling_program_galon" data-placeholder="Program Promo Galon" name="selling_program_galon_id">
													<option value=""></option>
													<?php
														$tbl_selling_program_galon = mysql_query("SELECT selling_program_galon_id, selling_program_galon_description FROM selling_program_galon WHERE selling_program_galon_active = '1' ORDER BY selling_program_galon_id");
														while($data_tbl_selling_program_galon = mysql_fetch_array($tbl_selling_program_galon))
														{
													?>
														<option value="<?php echo $data_tbl_selling_program_galon['selling_program_galon_id'] ?>"><?php echo $data_tbl_selling_program_galon['selling_program_galon_description'] ?></option>
													<?php	
														}
													?>
												</select>
												<div id="selling_program_galon_id"></div>
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
												<input class="form-control" name="customer_code" placeholder="Kode" type="text">
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
												<input class="form-control" name="customer_name" placeholder="Nama" type="text">
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
												<input class="form-control" name="customer_address" placeholder="Alamat" type="text">
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
												<select class="form-control select2me" data-placeholder="Kecamatan" data-error-container="#customer_districts_id" name="customer_districts_id">
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
												<div id="customer_districts_id"></div>
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
												<input class="form-control" name="customer_contact" placeholder="Kontak" type="text">
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
												<input class="form-control" name="customer_phone" placeholder="No. Telepon" type="text">
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
													$tbl_product_sell_price = mysql_query("SELECT product_sell_price_id, product_sell_price_name FROM product_sell_price WHERE product_sell_price_active = '1' AND product_sell_price_name != 'End User' AND product_sell_price_name != 'Outlet' AND product_sell_price_name != 'Institusi' ORDER BY product_sell_price_name");
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
									<h4 class="form-section">
										Program Promo Produk
									</h4>
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
									<h4 class="form-section">
										Status Pelanggan
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Status Pelanggan
													<span class="required">
														*
													</span>
												</label>
												<div class="radio-list" data-error-container="#customer_active">
													<label class="radio-inline">
														<input name="customer_active" type="radio" value="1">
															Aktif
														</label>
													<label class="radio-inline">
														<input name="customer_active" type="radio" value="0">
															Tidak Aktif
													</label>
												</div>
												<div id="customer_active"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=customer'">
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
	function form_edit_customer()
	{
		$tbl_customer = mysql_query("SELECT customer_id, customer_category_id, customer_class_id, customer_code, customer_name, customer_address, customer_districts_id, customer_contact, customer_phone, product_sell_price_id, customer_product_sell_program_promo, customer_active,customer_galon_category_id,selling_program_galon_id FROM customer WHERE customer_id = '".$_GET['customer_id']."'");
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
						<div class="form portlet-body">
							<form action="?alimms=customer&tib=edit-customer" class="horizontal-form" id="form_sample_3" method="post">
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
												<select class="form-control select2me" data-error-container="#customer_category_id" data-placeholder="Kategori" name="customer_category_id">
													<option value=""></option>
													<?php
														$tbl_customer_category = mysql_query("SELECT customer_category_id, customer_category_name FROM customer_category WHERE customer_category_active = '1' ORDER BY customer_category_name");
														while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
														{
															if ($data_tbl_customer_category['customer_category_id'] == $data_tbl_customer['customer_category_id'])
															{
													?>
															<option selected="selected" value="<?php echo $data_tbl_customer_category['customer_category_id'] ?>"><?php echo $data_tbl_customer_category['customer_category_name'] ?></option>
													<?php
															} 
															else 
															{
													?>
															<option value="<?php echo $data_tbl_customer_category['customer_category_id'] ?>"><?php echo $data_tbl_customer_category['customer_category_name'] ?></option>
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
													Kelas
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#customer_class_id" data-placeholder="Kelas" name="customer_class_id">
													<option value=""></option>
													<?php
														$tbl_customer_class = mysql_query("SELECT customer_class_id, customer_class_name FROM customer_class WHERE customer_class_active = '1' ORDER BY customer_class_name");
														while($data_tbl_customer_class = mysql_fetch_array($tbl_customer_class))
														{
															if ($data_tbl_customer_class['customer_class_id'] == $data_tbl_customer['customer_class_id'])
															{
													?>
															<option selected="selected" value="<?php echo $data_tbl_customer_class['customer_class_id'] ?>"><?php echo $data_tbl_customer_class['customer_class_name'] ?></option>
													<?php
															} 
															else 
															{
													?>
															<option value="<?php echo $data_tbl_customer_class['customer_class_id'] ?>"><?php echo $data_tbl_customer_class['customer_class_name'] ?></option>
													<?php
															}
														}
													?>
												</select>
												<div id="customer_class_id"></div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kategori Pelanggan Galon
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#customer_galon_category_id" data-placeholder="Tipe" name="customer_galon_category_id">
													<option value=""></option>
													<?php
														$tbl_customer_galon_category = mysql_query("SELECT customer_galon_category_id, customer_galon_category_name FROM customer_galon_category WHERE customer_galon_category_active = '1' ORDER BY customer_galon_category_id");
														while($data_tbl_customer_galon_category = mysql_fetch_array($tbl_customer_galon_category))
														{
															if ($data_tbl_customer_galon_category['customer_galon_category_id'] == $data_tbl_customer['customer_galon_category_id'])
															{
													?>
																<option selected="selected" value="<?php echo $data_tbl_customer_galon_category['customer_galon_category_id'] ?>"><?php echo $data_tbl_customer_galon_category['customer_galon_category_name'] ?></option>
													<?php
															} 
															else 
															{
													?>
																<option value="<?php echo $data_tbl_customer_galon_category['customer_galon_category_id'] ?>"><?php echo $data_tbl_customer_galon_category['customer_galon_category_name'] ?></option>
													<?php	
															}
														}
													?>
												</select>
												<div id="customer_galon_category_id"></div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Program Promo Galon
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#selling_program_galon_id" data-placeholder="Tipe" name="selling_program_galon_id">
													<option value=""></option>
													<?php
														$tbl_selling_program_galon = mysql_query("SELECT selling_program_galon_id, selling_program_galon_description FROM selling_program_galon WHERE selling_program_galon_active = '1' ORDER BY selling_program_galon_id");
														while($data_tbl_selling_program_galon = mysql_fetch_array($tbl_selling_program_galon))
														{
															if ($data_tbl_selling_program_galon['selling_program_galon_id'] == $data_tbl_customer['selling_program_galon_id'])
															{
													?>
																<option selected="selected" value="<?php echo $data_tbl_selling_program_galon['selling_program_galon_id'] ?>"><?php echo $data_tbl_selling_program_galon['selling_program_galon_description'] ?></option>
													<?php
															} 
															else 
															{
													?>
																<option value="<?php echo $data_tbl_selling_program_galon['selling_program_galon_id'] ?>"><?php echo $data_tbl_selling_program_galon['selling_program_galon_description'] ?></option>
													<?php	
															}
														}
													?>
												</select>
												<div id="selling_program_galon_id"></div>
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
												<input class="form-control" name="customer_name" placeholder="Nama" type="text" value="<?php echo $data_tbl_customer['customer_name'] ?>">
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
												<input class="form-control" name="customer_address" placeholder="Alamat" type="text" value="<?php echo $data_tbl_customer['customer_address'] ?>">
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
												<select class="form-control select2me" data-error-container="#customer_districts_id" data-placeholder="Kecamatan" name="customer_districts_id">
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
												<div id="customer_districts_id"></div>
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
												<input class="form-control" name="customer_contact" placeholder="Kontak" type="text" value="<?php echo $data_tbl_customer['customer_contact'] ?>">
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
												<input class="form-control" name="customer_phone" placeholder="No. Telepon" type="text" value="<?php echo $data_tbl_customer['customer_phone'] ?>">
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
												</label>
												<div class="radio-list">
												<?php
													$tbl_product_sell_price = mysql_query("SELECT product_sell_price_id, product_sell_price_name FROM product_sell_price WHERE product_sell_price_active = '1' ORDER BY product_sell_price_name");
													while($data_tbl_product_sell_price = mysql_fetch_array($tbl_product_sell_price))
													{
														if ($data_tbl_product_sell_price['product_sell_price_id'] == $data_tbl_customer['product_sell_price_id'])
														{
												?>
														<label class="radio-inline">
															<input checked="checked" name="product_sell_price_id" type="radio" value="<?php echo $data_tbl_product_sell_price['product_sell_price_id'] ?>">
																<?php echo $data_tbl_product_sell_price['product_sell_price_name'] ?>
														</label>
												<?php
														}
														else
														{
												?>
														<label class="radio-inline">
															<input name="product_sell_price_id" type="radio" value="<?php echo $data_tbl_product_sell_price['product_sell_price_id'] ?>">
																<?php echo $data_tbl_product_sell_price['product_sell_price_name'] ?>
														</label>
												<?php
														}
													}
												?>
												</div>
											</div>
										</div>
									</div>
									<h4 class="form-section">
										Program Promo Produk
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Program Promo Produk
												</label>
												<div class="radio-list">
												<?php
													if ($data_tbl_customer['customer_product_sell_program_promo'] == "Ya")
													{
												?>
													<label class="radio-inline">
														<input checked="checked" name="customer_product_sell_program_promo" type="radio" value="Ya">
															Ya
													</label>
													<label class="radio-inline">
														<input name="customer_product_sell_program_promo" type="radio" value="Tidak">
															Tidak
													</label>
												<?php
													}
													else
													{
												?>
													<label class="radio-inline">
														<input name="customer_product_sell_program_promo" type="radio" value="Ya">
															Ya
													</label>
													<label class="radio-inline">
														<input checked="checked" name="customer_product_sell_program_promo" type="radio" value="Tidak">
															Tidak
													</label>
												<?php
													}
												?>
												</div>
											</div>
										</div>
									</div>
									<h4 class="form-section">
										Status Pelanggan
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Status Pelanggan
												</label>
												<div class="radio-list">
												<?php
													if ($data_tbl_customer['customer_active'] == "1")
													{
												?>
													<label class="radio-inline">
														<input checked="checked" name="customer_active" type="radio" value="1">
															Aktif
													</label>
													<label class="radio-inline">
														<input name="customer_active" type="radio" value="0">
															Tidak Aktif
													</label>
												<?php
													}
													else
													{
												?>
													<label class="radio-inline">
														<input name="customer_active" type="radio" value="1">
															Aktif
													</label>
													<label class="radio-inline">
														<input checked="checked" name="customer_active" type="radio" value="0">
															Tidak Aktif
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
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=customer'">
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