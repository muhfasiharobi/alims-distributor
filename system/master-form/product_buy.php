<?php
	function form_initial_product_buy()
	{
?>
		<div class="page-fixed-main-content">	 
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Produk Beli
								</span>
							</div>
							<div class="actions">
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=product-buy&tib=form-add-product-buy">
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
											Nama
										</th>
										<th>
											Kategori
										</th>
										<th>
											Status
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_product_buy = mysql_query("SELECT a.product_buy_id, a.product_buy_name, a.product_buy_active, b.product_category_name FROM product_buy a, product_category b WHERE b.product_category_active = '1' AND a.product_category_id = b.product_category_id ORDER BY a.product_buy_name");
									while ($data_tbl_product_buy = mysql_fetch_array($tbl_product_buy))
									{
								?>
									<tr class="odd gradeX">
										<td>
										<?php
											if ($data_tbl_product_buy['product_buy_active'] == 1)
											{
										?>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=product-buy&tib=form-edit-product-buy&product_buy_id=<?php echo $data_tbl_product_buy['product_buy_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_product_buy_id_<?php echo $data_tbl_product_buy['product_buy_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										<?php
											}
											else
											{
										?>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Aktif" data-toggle="modal" href="#active_product_buy_id_<?php echo $data_tbl_product_buy['product_buy_id'] ?>">
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
											<?php echo $data_tbl_product_buy['product_buy_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_product_buy['product_category_name'] ?>
										</td>
										<td>
										<?php
											if ($data_tbl_product_buy['product_buy_active'] == 1)
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
									<div aria-hidden="true" class="fade modal" id="delete_product_buy_id_<?php echo $data_tbl_product_buy['product_buy_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=product-buy&tib=delete-product-buy&product_buy_id=<?php echo $data_tbl_product_buy['product_buy_id'] ?>">
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
									<div aria-hidden="true" class="fade modal" id="active_product_buy_id_<?php echo $data_tbl_product_buy['product_buy_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=product-buy&tib=active-product-buy&product_buy_id=<?php echo $data_tbl_product_buy['product_buy_id'] ?>">
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
	function form_add_product_buy()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Produk Beli
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=product-buy&tib=add-product-buy" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<h4 class="form-section">
										Produk Beli
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Nama
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="product_buy_name" placeholder="Nama" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kategori
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#product_category_id" data-placeholder="Kategori" name="product_category_id">
													<option value=""></option>
													<?php
														$tbl_product_category = mysql_query("SELECT product_category_id, product_category_name FROM product_category WHERE product_category_active = '1' ORDER BY product_category_name");
														while($data_tbl_product_category = mysql_fetch_array($tbl_product_category))
														{
													?>
														<option value="<?php echo $data_tbl_product_category['product_category_id'] ?>"><?php echo $data_tbl_product_category['product_category_name'] ?></option>
													<?php	
														}
													?>
												</select>
												<div id="product_category_id"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=product-buy'">
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
	function form_edit_product_buy()
	{
		$tbl_product_buy = mysql_query("SELECT product_buy_id, product_buy_name, product_category_id FROM product_buy WHERE product_buy_id = '".$_GET['product_buy_id']."'");
		$data_tbl_product_buy = mysql_fetch_array($tbl_product_buy);
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Produk Beli
								</span>
							</div>
						</div>
						<div class="portlet-body form">
							<form action="?alimms=product-buy&tib=edit-product-buy" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="product_buy_id" type="hidden" value="<?php echo $data_tbl_product_buy['product_buy_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Produk Beli
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Nama
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="product_buy_name" placeholder="Nama" type="text" value="<?php echo $data_tbl_product_buy['product_buy_name'] ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kategori
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#product_category_id" data-placeholder="Kategori" name="product_category_id">
													<option value=""></option>
													<?php
														$tbl_product_category = mysql_query("SELECT product_category_id, product_category_name FROM product_category WHERE product_category_active = '1' ORDER BY product_category_name");
														while($data_tbl_product_category = mysql_fetch_array($tbl_product_category))
														{
															if ($data_tbl_product_category['product_category_id'] == $data_tbl_product_buy['product_category_id'])
															{
													?>
															<option selected="selected" value="<?php echo $data_tbl_product_category['product_category_id'] ?>"><?php echo $data_tbl_product_category['product_category_name'] ?></option>
													<?php
															} 
															else 
															{
													?>
															<option value="<?php echo $data_tbl_product_category['product_category_id'] ?>"><?php echo $data_tbl_product_category['product_category_name'] ?></option>
													<?php
															}
														}
													?>
												</select>
												<div id="product_category_id"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=product-buy'">
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