<?php
	function form_initial_product_sell()
	{
?>
		<div class="page-fixed-main-content">	 
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Produk Jual
								</span>
							</div>
							<div class="actions">
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=product-sell&tib=form-add-product-sell">
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
											Kode
										</th>
										<th>
											Nama
										</th>
										<th>
											Satuan
										</th>
										<th>
											Status
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_product_sell = mysql_query("SELECT a.product_sell_id, a.product_sell_code, a.product_sell_name, a.product_sell_active, b.product_unit_name FROM product_sell a, product_unit b WHERE b.product_unit_active = '1' AND a.product_unit_id = b.product_unit_id ORDER BY a.product_sell_code");
									while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
									{
								?>
									<tr class="odd gradeX">
										<td>
										<?php
											if ($data_tbl_product_sell['product_sell_active'] == 1)
											{
										?>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=product-sell&tib=form-edit-product-sell&product_sell_id=<?php echo $data_tbl_product_sell['product_sell_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_product_sell_id_<?php echo $data_tbl_product_sell['product_sell_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										<?php
											}
											else
											{
										?>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Aktif" data-toggle="modal" href="#active_product_sell_id_<?php echo $data_tbl_product_sell['product_sell_id'] ?>">
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
											<?php echo $data_tbl_product_sell['product_sell_code'] ?>
										</td>
										<td>
											<?php echo $data_tbl_product_sell['product_sell_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_product_sell['product_unit_name'] ?>
										</td>
										<td>
										<?php
											if ($data_tbl_product_sell['product_sell_active'] == 1)
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
									<div aria-hidden="true" class="fade modal" id="delete_product_sell_id_<?php echo $data_tbl_product_sell['product_sell_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=product-sell&tib=delete-product-sell&product_sell_id=<?php echo $data_tbl_product_sell['product_sell_id'] ?>">
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
									<div aria-hidden="true" class="fade modal" id="active_product_sell_id_<?php echo $data_tbl_product_sell['product_sell_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=product-sell&tib=active-product-sell&product_sell_id=<?php echo $data_tbl_product_sell['product_sell_id'] ?>">
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
	function form_add_product_sell()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Produk Jual
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=product-sell&tib=add-product-sell" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<h4 class="form-section">
										Produk Jual
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
												<input class="form-control" name="product_sell_code" placeholder="Kode" type="text">
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
												<input class="form-control" name="product_sell_name" placeholder="Nama" type="text">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Satuan
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#product_unit_id" data-placeholder="Satuan" name="product_unit_id">
													<option value=""></option>
													<?php
														$tbl_product_unit = mysql_query("SELECT product_unit_id, product_unit_name FROM product_unit WHERE product_unit_active = '1' ORDER BY product_unit_name");
														while($data_tbl_product_unit = mysql_fetch_array($tbl_product_unit))
														{
													?>
														<option value="<?php echo $data_tbl_product_unit['product_unit_id'] ?>"><?php echo $data_tbl_product_unit['product_unit_name'] ?></option>
													<?php	
														}
													?>
												</select>
												<div id="product_unit_id"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=product-sell'">
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
	function form_edit_product_sell()
	{
		$tbl_product_sell = mysql_query("SELECT product_sell_id, product_sell_code, product_sell_name, product_unit_id FROM product_sell WHERE product_sell_id = '".$_GET['product_sell_id']."'");
		$data_tbl_product_sell = mysql_fetch_array($tbl_product_sell);
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Produk Jual
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=product-sell&tib=edit-product-sell" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="product_sell_id" type="hidden" value="<?php echo $data_tbl_product_sell['product_sell_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Produk Jual
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
												<input class="form-control" name="product_sell_code" placeholder="Kode" type="text" value="<?php echo $data_tbl_product_sell['product_sell_code'] ?>">
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
												<input class="form-control" name="product_sell_name" placeholder="Nama" type="text" value="<?php echo $data_tbl_product_sell['product_sell_name'] ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Satuan
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#product_unit_id" data-placeholder="Satuan" name="product_unit_id">
													<option value=""></option>
													<?php
														$tbl_product_unit = mysql_query("SELECT product_unit_id, product_unit_name FROM product_unit WHERE product_unit_active = '1' ORDER BY product_unit_name");
														while($data_tbl_product_unit = mysql_fetch_array($tbl_product_unit))
														{
															if ($data_tbl_product_unit['product_unit_id'] == $data_tbl_product_sell['product_unit_id'])
															{
													?>
															<option selected="selected" value="<?php echo $data_tbl_product_unit['product_unit_id'] ?>"><?php echo $data_tbl_product_unit['product_unit_name'] ?></option>
													<?php
															} 
															else
															{
													?>
															<option value="<?php echo $data_tbl_customer_city['customer_city_id'] ?>"><?php echo $data_tbl_customer_city['customer_city_name'] ?></option>
													<?php
															}
														}
													?>
												</select>
												<div id="product_unit_id"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=product-sell'">
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