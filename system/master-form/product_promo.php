<?php
	function form_initial_product_promo()
	{
?>
		<div class="page-fixed-main-content">	 
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Promo Produk
								</span>
							</div>
							<div class="actions">
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=product-promo&tib=form-add-product-promo">
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
											Kategori Pelanggan (Galon)
										</th>
										<th>
											Produk
										</th>
										<th>
											Pembelian
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
											Masa Berlaku
										</th>
										<th>
											Status
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_product_promo = mysql_query("SELECT a.product_promo_id, a.product_promo_purchase_minimum, a.product_promo_purchase_maximum, a.product_promo_program_bonus, a.product_promo_piece_discount, a.product_promo_cash_discount, a.product_promo_expiry_from_date, a.product_promo_expiry_to_date, a.product_promo_active, b.customer_category_name, c.product_sell_name, d.customer_galon_category_name FROM product_promo a, customer_category b, product_sell c, customer_galon_category d WHERE b.customer_category_active = '1' AND c.product_sell_active = '1' AND a.customer_category_id = b.customer_category_id AND a.product_sell_id = c.product_sell_id AND a.customer_galon_category_id = d.customer_galon_category_id ORDER BY a.product_promo_id");
									while ($data_tbl_product_promo = mysql_fetch_array($tbl_product_promo))
									{
										$product_promo_piece_discount_indo = format_angka($data_tbl_product_promo['product_promo_piece_discount']);
										
										$product_promo_expiry_from_date_indo = tanggal_indo($data_tbl_product_promo['product_promo_expiry_from_date']);
										$product_promo_expiry_to_date_indo = tanggal_indo($data_tbl_product_promo['product_promo_expiry_to_date']);
								?>
									<tr class="odd gradeX">
										<td>
										<?php
											if ($data_tbl_product_promo['product_promo_active'] == 1)
											{
										?>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=product-promo&tib=form-edit-product-promo&product_promo_id=<?php echo $data_tbl_product_promo['product_promo_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_product_promo_id_<?php echo $data_tbl_product_promo['product_promo_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										<?php
											}
											else
											{
										?>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Aktif" data-toggle="modal" href="#active_product_promo_id_<?php echo $data_tbl_product_promo['product_promo_id'] ?>">
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
											<?php echo $data_tbl_product_promo['customer_category_name'] ?>
										</td>
										<td>
											
										</td>
										<td>
											<?php echo $data_tbl_product_promo['product_sell_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_product_promo['product_promo_purchase_minimum'] ?> Crt - <?php echo $data_tbl_product_promo['product_promo_purchase_maximum'] ?> Crt
										</td>
										<td>
										<?php
											if ($data_tbl_product_promo['product_promo_program_bonus'] == "0")
											{
										?>
											-
										<?php
											}
											else
											{
										?>
											Setiap Pembelian <?php echo $data_tbl_product_promo['product_promo_program_bonus'] ?> Crt, Bonus 1 Crt
										<?php
											}
										?>
										</td>
										<td>
											<?php echo $product_promo_piece_discount_indo ?>
										</td>
										<td>
											<?php echo $data_tbl_product_promo['product_promo_cash_discount'] ?>
										</td>
										<td>
											<?php echo $product_promo_expiry_from_date_indo ?> - <?php echo $product_promo_expiry_to_date_indo ?>
										</td>
										<td>
										<?php
											if ($data_tbl_product_promo['product_promo_active'] == 1)
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
									<div aria-hidden="true" class="fade modal" id="delete_product_promo_id_<?php echo $data_tbl_product_promo['product_promo_id'] ?>" role="basic" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" aria-hidden="true" class="close" data-dismiss="modal"></button>
                                                    <h4 class="modal-title">
														Konfirmasi
													</h4>
                                                </div>
                                                <div class="modal-body">
													Apakah Anda Yakin Ingin Menghapus Data Ini ?
												</div>
                                                <div class="modal-footer">
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=product-promo&tib=delete-product-promo&product_promo_id=<?php echo $data_tbl_product_promo['product_promo_id'] ?>">
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
									<div aria-hidden="true" class="fade modal" id="active_product_promo_id_<?php echo $data_tbl_product_promo['product_promo_id'] ?>" role="basic" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" aria-hidden="true" class="close" data-dismiss="modal"></button>
                                                    <h4 class="modal-title">
														Konfirmasi
													</h4>
                                                </div>
                                                <div class="modal-body">
													Apakah Anda Yakin Ingin Mengaktifkan Data Ini ?
												</div>
                                                <div class="modal-footer">
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=product-promo&tib=active-product-promo&product_promo_id=<?php echo $data_tbl_product_promo['product_promo_id'] ?>">
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
	function form_add_product_promo()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Promo Produk
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=product-promo&tib=add-product-promo" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<h4 class="form-section">
										Promo Produk
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
													Kategori Pelanggan (Galon)
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#customer_galon_category_id" data-placeholder="Kategori Pelanggan (Galon)" name="customer_galon_category_id">
													<option value=""></option>
													<?php
														$tbl_customer_galon_category = mysql_query("SELECT * FROM customer_galon_category WHERE customer_galon_category_active = '1' ORDER BY customer_galon_category_name");
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
									</div>
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
													?>
														<option value="<?php echo $data_tbl_product_sell['product_sell_id'] ?>"><?php echo $data_tbl_product_sell['product_sell_name'] ?></option>
													<?php	
														}
													?>
												</select>
												<div id="product_sell_id"></div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Minimal Pembelian
													<span class="required">
														*
													</span>
												</label>
												<input type="text" class="form-control" name="product_promo_purchase_minimum" placeholder="Minimal Pembelian">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Maksimal Pembelian
													<span class="required">
														*
													</span>
												</label>
												<input type="text" class="form-control" name="product_promo_purchase_maximum" placeholder="Maksimal Pembelian">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Program Bonus
													<span class="required">
														*
													</span>
												</label>
												<input type="text" class="form-control" name="product_promo_program_bonus" placeholder="Program Bonus">
												<span class="help-block">
													*) Setiap Pembelian (Program Bonus), Bonus 1 Crt
												</span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Potongan Diskon (Rp)
													<span class="required">
														*
													</span>
												</label>
												<input type="text" class="form-control" name="product_promo_piece_discount" placeholder="Potongan Diskon">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Diskon Pembelian Tunai (%)
													<span class="required">
														*
													</span>
												</label>
												<input type="text" class="form-control" name="product_promo_cash_discount" placeholder="Diskon Pembelian Tunai">
											</div>
										</div>
									</div>
									<h4 class="form-section">
										Masa Berlaku Promo Produk
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Dari Tanggal
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="product_promo_expiry_from_date" placeholder="Dari Tanggal" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Sampai Tanggal
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="product_promo_expiry_to_date" placeholder="Sampai Tanggal" type="text">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=product-promo'">
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
	function form_edit_product_promo()
	{
		$tbl_product_promo = mysql_query("SELECT product_promo_id, customer_category_id, product_sell_id, product_promo_purchase_minimum, product_promo_purchase_maximum, product_promo_program_bonus, product_promo_piece_discount, product_promo_cash_discount, product_promo_expiry_from_date, product_promo_expiry_to_date FROM product_promo WHERE product_promo_id = '".$_GET['product_promo_id']."'");
		$data_tbl_product_promo = mysql_fetch_array($tbl_product_promo);
		
		$product_promo_expiry_from_date = explode("-", $data_tbl_product_promo['product_promo_expiry_from_date']);
		$date_product_promo_expiry_from = $product_promo_expiry_from_date[2];
		$month_product_promo_expiry_from = $product_promo_expiry_from_date[1];
		$year_product_promo_expiry_from = $product_promo_expiry_from_date[0];
		$product_promo_expiry_from_date = date("d-m-Y", mktime(0, 0, 0, $month_product_promo_expiry_from, $date_product_promo_expiry_from, $year_product_promo_expiry_from));
		
		$product_promo_expiry_to_date = explode("-", $data_tbl_product_promo['product_promo_expiry_to_date']);
		$date_product_promo_expiry_to = $product_promo_expiry_to_date[2];
		$month_product_promo_expiry_to = $product_promo_expiry_to_date[1];
		$year_product_promo_expiry_to = $product_promo_expiry_to_date[0];
		$product_promo_expiry_to_date = date("d-m-Y", mktime(0, 0, 0, $month_product_promo_expiry_to, $date_product_promo_expiry_to, $year_product_promo_expiry_to));
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Promo Produk
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=product-promo&tib=edit-product-promo" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="product_promo_id" type="hidden" value="<?php echo $data_tbl_product_promo['product_promo_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Promo Produk
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
															if ($data_tbl_customer_category['customer_category_id'] == $data_tbl_product_promo['customer_category_id'])
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
									</div>
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
															if ($data_tbl_product_sell['product_sell_id'] == $data_tbl_product_promo['product_sell_id'])
															{
													?>
															<option selected="selected" value="<?php echo $data_tbl_product_sell['product_sell_id'] ?>"><?php echo $data_tbl_product_sell['product_sell_name'] ?></option>
													<?php
															} 
															else 
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
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Minimal Pembelian
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="product_promo_purchase_minimum" placeholder="Minimal Pembelian" type="text" value="<?php echo $data_tbl_product_promo['product_promo_purchase_minimum'] ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Maksimal Pembelian
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="product_promo_purchase_maximum" placeholder="Maksimal Pembelian" type="text" value="<?php echo $data_tbl_product_promo['product_promo_purchase_maximum'] ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Program Bonus
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="product_promo_program_bonus" placeholder="Program Bonus" type="text" value="<?php echo $data_tbl_product_promo['product_promo_program_bonus'] ?>">
												<span class="help-block">
													*) Setiap Pembelian (Program Bonus), Bonus 1 Crt
												</span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Potongan Diskon (Rp)
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="product_promo_piece_discount" placeholder="Potongan Diskon" type="text" value="<?php echo $data_tbl_product_promo['product_promo_piece_discount'] ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Diskon Pembelian Tunai (%)
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="product_promo_cash_discount" placeholder="Diskon Pembelian Tunai" type="text" value="<?php echo $data_tbl_product_promo['product_promo_cash_discount'] ?>">
											</div>
										</div>
									</div>
									<h4 class="form-section">
										Masa Berlaku Promo Produk
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Dari Tanggal
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="product_promo_expiry_from_date" placeholder="Masa Berlaku Dari Tanggal" type="text" value="<?php echo $product_promo_expiry_from_date ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Sampai Tanggal
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="product_promo_expiry_to_date" placeholder="Masa Berlaku Sampai Tanggal" type="text" value="<?php echo $product_promo_expiry_to_date ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=product-promo'">
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