<?php
	function form_initial_galon_promo()
	{
?>
		<div class="page-fixed-main-content">	 
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Harga Galon & Refill
								</span>
							</div>
							<div class="actions">
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=galon-promo&tib=form-add-galon-promo">
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
											Kategori Pelanggan (Galon)			
										</th>
										<th>
											Produk
										</th>
										<th>
											Harga	
										</th>
										<th>
											Status
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_product_promo_galon = mysql_query("SELECT * FROM product_promo_galon a, product_sell b, customer_galon_category c WHERE a.customer_galon_category_id = c.customer_galon_category_id AND a.product_sell_id = b.product_sell_id");
									while ($data_tbl_product_promo_galon = mysql_fetch_array($tbl_product_promo_galon))
									{
										$price = format_angka($data_tbl_product_promo_galon['price']);
								?>
									<tr class="odd gradeX">
										<td>
										<?php
											if ($data_tbl_product_promo_galon['product_promo_galon_active'] == 1)
											{
										?>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=galon-promo&tib=form-edit-galon-promo&product_promo_galon_id=<?php echo $data_tbl_product_promo_galon['product_promo_galon_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_galon_promo_id_<?php echo $data_tbl_product_promo_galon['product_promo_galon_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										<?php
											}
											else
											{
										?>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Aktif" data-toggle="modal" href="#active_galon_promo_id_<?php echo $data_tbl_product_promo_galon['galon_promo_id'] ?>">
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
											<?php echo $data_tbl_product_promo_galon['customer_galon_category_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_product_promo_galon['product_sell_name'] ?>
										</td>
										<td>
											<?php echo $price ?> 
										</td>
										<td>
										<?php
											if ($data_tbl_product_promo_galon['product_promo_galon_active'] == 1)
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
									<div aria-hidden="true" class="fade modal" id="delete_galon_promo_id_<?php echo $data_tbl_product_promo_galon['product_promo_galon_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=galon-promo&tib=delete-galon-promo&product_promo_galon_id=<?php echo $data_tbl_product_promo_galon['product_promo_galon_id'] ?>">
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
									<div aria-hidden="true" class="fade modal" id="active_galon_promo_id_<?php echo $data_tbl_galon_promo['galon_promo_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=galon-promo&tib=active-galon-promo&galon_promo_id=<?php echo $data_tbl_galon_promo['galon_promo_id'] ?>">
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
	function form_add_galon_promo()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Harga Galon & Refill
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=galon-promo&tib=add-galon-promo" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="product_promo_galon_id" type="hidden" value="<?php echo $data_tbl_product_promo_galon['product_promo_galon_id'] ?>">
								<div class="form-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kategori Pelanggan (Galon)
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#customer_galon_category_id" data-placeholder="Kategori Pelanggan Galon" name="customer_galon_category_id">
													<option value=""></option>
													<?php
														$tbl_customer_galon_category = mysql_query("SELECT * FROM customer_galon_category WHERE customer_galon_category_active = '1'");
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
													Produk
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#product_sell_id" data-placeholder="Produk" name="product_sell_id">
													<option value=""></option>
													<?php
														$tbl_product_sell = mysql_query("SELECT * FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_id DESC");
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
													Harga
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="price" placeholder="Harga" type="text" >
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=galon-promo'">
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
	function form_edit_galon_promo()
	{
		$tbl_product_promo_galon = mysql_query("SELECT * FROM product_promo_galon WHERE product_promo_galon_id = '".$_GET['product_promo_galon_id']."'");
		$data_tbl_product_promo_galon = mysql_fetch_array($tbl_product_promo_galon);
		
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Harga Galon & Refill
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=galon-promo&tib=edit-galon-promo" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="product_promo_galon_id" type="hidden" value="<?php echo $data_tbl_product_promo_galon['product_promo_galon_id'] ?>">
								<div class="form-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kategori Pelanggan (Galon)
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#customer_galon_category_id" data-placeholder="Kategori Pelanggan Galon" name="customer_galon_category_id">
													<option value=""></option>
													<?php
														$tbl_customer_galon_category = mysql_query("SELECT * FROM customer_galon_category WHERE customer_galon_category_active = '1'");
														while($data_tbl_customer_galon_category = mysql_fetch_array($tbl_customer_galon_category))
														{
															if ($data_tbl_customer_galon_category['customer_galon_category_id'] == $data_tbl_product_promo_galon['customer_galon_category_id'])
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
													Produk
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#product_sell_id" data-placeholder="Produk" name="product_sell_id">
													<option value=""></option>
													<?php
														$tbl_product_sell = mysql_query("SELECT * FROM product_sell WHERE product_sell_active = '1'");
														while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
														{
															if ($data_tbl_product_sell['product_sell_id'] == $data_tbl_product_promo_galon['product_sell_id'])
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
													Harga
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="price" placeholder="Harga" type="text" value="<?php echo $data_tbl_product_promo_galon['price'] ?>" >
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=galon-promo'">
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