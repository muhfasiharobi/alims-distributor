<?php
	function form_initial_customer_class()
	{
?>
		<div class="page-fixed-main-content">	 
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Kelas Pelanggan
								</span>
							</div>
							<div class="actions">
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=customer-class&tib=form-add-customer-class">
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
											Batasan Harga Pembelian
										</th>
										<th>
											Status
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_customer_class = mysql_query("SELECT customer_class_id, customer_class_name, customer_class_purchase_price_limit, customer_class_active FROM customer_class ORDER BY customer_class_name");
									while ($data_tbl_customer_class = mysql_fetch_array($tbl_customer_class))
									{
										$customer_class_purchase_price_limit_indo = format_angka($data_tbl_customer_class['customer_class_purchase_price_limit']);
								?>
									<tr class="odd gradeX">
										<td>
										<?php
											if ($data_tbl_customer_class['customer_class_active'] == 1)
											{
										?>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=customer-class&tib=form-edit-customer-class&customer_class_id=<?php echo $data_tbl_customer_class['customer_class_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_customer_class_id_<?php echo $data_tbl_customer_class['customer_class_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										<?php
											}
											else
											{
										?>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Aktif" data-toggle="modal" href="#active_customer_class_id_<?php echo $data_tbl_customer_class['customer_class_id'] ?>">
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
											<?php echo $data_tbl_customer_class['customer_class_name'] ?>
										</td>
										<td>
											<?php echo $customer_class_purchase_price_limit_indo ?>
										</td>
										<td>
										<?php
											if ($data_tbl_customer_class['customer_class_active'] == 1)
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
									<div aria-hidden="true" class="fade modal" id="delete_customer_class_id_<?php echo $data_tbl_customer_class['customer_class_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=customer-class&tib=delete-customer-class&customer_class_id=<?php echo $data_tbl_customer_class['customer_class_id'] ?>">
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
									<div aria-hidden="true" class="fade modal" id="active_customer_class_id_<?php echo $data_tbl_customer_class['customer_class_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=customer-class&tib=active-customer-class&customer_class_id=<?php echo $data_tbl_customer_class['customer_class_id'] ?>">
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
	function form_add_customer_class()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Kelas Pelanggan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=customer-class&tib=add-customer-class" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<h4 class="form-section">
										Kelas Pelanggan
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
												<input class="form-control" name="customer_class_name" placeholder="Nama" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Batasan Harga Pembelian
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="customer_class_purchase_price_limit" placeholder="Batasan Harga Pembelian" type="text">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=customer-class'">
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
	function form_edit_customer_class()
	{
		$tbl_customer_class = mysql_query("SELECT customer_class_id, customer_class_name, customer_class_purchase_price_limit FROM customer_class WHERE customer_class_id = '".$_GET['customer_class_id']."'");
		$data_tbl_customer_class = mysql_fetch_array($tbl_customer_class);
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Kelas Pelanggan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=customer-class&tib=edit-customer-class" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="customer_class_id" type="hidden" value="<?php echo $data_tbl_customer_class['customer_class_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Kelas Pelanggan
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
												<input class="form-control" name="customer_class_name" placeholder="Nama" type="text" value="<?php echo $data_tbl_customer_class['customer_class_name'] ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Batasan Harga Pembelian
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="customer_class_purchase_price_limit" placeholder="Batasan Harga Pembelian" type="text" value="<?php echo $data_tbl_customer_class['customer_class_purchase_price_limit'] ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=customer-class'">
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