<?php
	function form_initial_product_sell_price()
	{
?>
		<div class="page-fixed-main-content">	 
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Harga Produk Jual
								</span>
							</div>
							<div class="actions">
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=product-sell-price&tib=form-add-product-sell-price">
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
										<?php
											$tbl_product_sell = mysql_query("SELECT product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
											while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
											{
										?>
											<th>
												<?php echo $data_tbl_product_sell['product_sell_name'] ?>
											</th>
										<?php
											}
										?>
										<th>
											Status
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_product_sell_price = mysql_query("SELECT product_sell_price_id, product_sell_price_name, product_sell_price_active FROM product_sell_price ORDER BY product_sell_price_name");
									while ($data_tbl_product_sell_price = mysql_fetch_array($tbl_product_sell_price))
									{
								?>
									<tr class="odd gradeX">
										<td>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=product-sell-price&tib=form-edit-product-sell-price&product_sell_price_id=<?php echo $data_tbl_product_sell_price['product_sell_price_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_product_sell_price_id_<?php echo $data_tbl_product_sell_price['product_sell_price_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										</td>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_product_sell_price['product_sell_price_name'] ?>
										</td>
										<?php
											$tbl_product_sell_price_detail = mysql_query("SELECT product_sell_price_detail_product_sell_price FROM product_sell_price_detail WHERE product_sell_price_id = '".$data_tbl_product_sell_price['product_sell_price_id']."'");
											while ($data_tbl_product_sell_price_detail = mysql_fetch_array($tbl_product_sell_price_detail))
											{
												$product_sell_price_detail_product_sell_price_indo = format_angka($data_tbl_product_sell_price_detail['product_sell_price_detail_product_sell_price']);
										?>
											<td>
												<?php echo $product_sell_price_detail_product_sell_price_indo ?>
											</td>
										<?php
											}
										?>
										<td>
										<?php
											if ($data_tbl_product_sell_price['product_sell_price_active'] == 1)
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
									<div aria-hidden="true" class="fade modal" id="delete_product_sell_price_id_<?php echo $data_tbl_product_sell_price['product_sell_price_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=product-sell-price&tib=delete-product-sell-price&product_sell_price_id=<?php echo $data_tbl_product_sell_price['product_sell_price_id'] ?>">
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
									<div aria-hidden="true" class="fade modal" id="active_product_sell_price_id_<?php echo $data_tbl_product_sell_price['product_sell_price_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=product-sell-price&tib=active-product-sell-price&product_sell_price_id=<?php echo $data_tbl_product_sell_price['product_sell_price_id'] ?>">
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
	function form_add_product_sell_price()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Harga Produk Jual
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=product-sell-price&tib=add-product-sell-price" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<h4 class="form-section">
										Harga Produk Jual
									</h4>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>
													Nama
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="product_sell_price_name" placeholder="Nama" type="text">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline purple sbold">
										<i class="fa fa-feed"></i>
										Proses
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=product-sell-price'">
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
	function form_product_sell_product_sell_price()
	{
		$tbl_product_sell_price = mysql_query("SELECT product_sell_price_id, product_sell_price_name FROM product_sell_price WHERE product_sell_price_id = '".$_GET['product_sell_price_id']."'");
		$data_tbl_product_sell_price = mysql_fetch_array($tbl_product_sell_price);
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_product_sell_price['product_sell_price_name'] ?>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo tanggal_sekarangindo() ?>
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
									Harga Jual Produk
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=product-sell-price&tib=product-sell-product-sell-price" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="product_sell_price_id" type="hidden" value="<?php echo $data_tbl_product_sell_price['product_sell_price_id'] ?>">
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
															$tbl_product_sell_price_detail = mysql_query("SELECT product_sell_price_detail_id FROM product_sell_price_detail WHERE product_sell_price_id = '".$data_tbl_product_sell_price['product_sell_price_id']."' AND product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
															$jumlah_tbl_product_sell_price_detail = mysql_num_rows($tbl_product_sell_price_detail);

															if ($jumlah_tbl_product_sell_price_detail < 1)
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
													Harga Satuan
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="product_sell_price_detail_product_sell_price" placeholder="Harga Satuan" type="text">
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
										$tbl_product_sell_price_detail = mysql_query("SELECT product_sell_price_id FROM product_sell_price_detail WHERE product_sell_price_id = '".$data_tbl_product_sell_price['product_sell_price_id']."'");
										$jumlah_tbl_product_sell_price_detail = mysql_num_rows($tbl_product_sell_price_detail);
										
										if ($jumlah_tbl_product_sell_price_detail >= 3)
										{
									?>
										<button type="button" class="btn btn-sm btn-outline green sbold" onclick="location.href='?alimms=product-sell-price'">
											<i class="fa fa-home"></i>
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
											Harga Satuan
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_product_sell_price_detail = mysql_query("SELECT a.product_sell_price_detail_id, a.product_sell_price_detail_product_sell_price, b.product_sell_name FROM product_sell_price_detail a, product_sell b WHERE a.product_sell_price_id = '".$data_tbl_product_sell_price['product_sell_price_id']."' AND a.product_sell_id = b.product_sell_id ORDER BY b.product_sell_code");
									while ($data_tbl_product_sell_price_detail = mysql_fetch_array($tbl_product_sell_price_detail))
									{
										$product_sell_price_detail_product_sell_price_indo = format_angka($data_tbl_product_sell_price_detail['product_sell_price_detail_product_sell_price']);
								?>
									<tr class="odd gradeX">
										<td>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#remove_product_sell_price_detail_id_<?php echo $data_tbl_product_sell_price_detail['product_sell_price_detail_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										</td>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_product_sell_price_detail['product_sell_name'] ?>
										</td>
										<td>
											<?php echo $product_sell_price_detail_product_sell_price_indo ?>
										</td>
									</tr>
									<div aria-hidden="true" class="fade modal" id="remove_product_sell_price_detail_id_<?php echo $data_tbl_product_sell_price_detail['product_sell_price_detail_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=product-sell-price&tib=remove-product-sell-price&product_sell_price_detail_id=<?php echo $data_tbl_product_sell_price_detail['product_sell_price_detail_id'] ?>">
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
	function form_edit_product_sell_price()
	{
		$tbl_product_sell_price = mysql_query("SELECT product_sell_price_id, product_sell_price_name FROM product_sell_price WHERE product_sell_price_id = '".$_GET['product_sell_price_id']."'");
		$data_tbl_product_sell_price = mysql_fetch_array($tbl_product_sell_price);
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Harga Produk Jual
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=product-sell-price&tib=edit-product-sell-price" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="product_sell_price_id" type="hidden" value="<?php echo $data_tbl_product_sell_price['product_sell_price_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Harga Produk Jual
									</h4>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>
													Nama
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="product_sell_price_name" placeholder="Nama" type="text" value="<?php echo $data_tbl_product_sell_price['product_sell_price_name'] ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline purple sbold">
										<i class="fa fa-feed"></i>
										Proses
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=product-sell-price'">
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