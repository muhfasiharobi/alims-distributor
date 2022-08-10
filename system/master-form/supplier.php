<?php
	function form_initial_supplier()
	{
?>
		<div class="page-fixed-main-content">	 
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Pemasok
								</span>
							</div>
							<div class="actions">
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=supplier&tib=form-add-supplier">
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
											Alamat
										</th>
										<th>
											Kota/ Kabupaten
										</th>
										<th>
											Kontak
										</th>
										<th>
											No. Telepon
										</th>
										<th>
											Email
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_supplier = mysql_query("SELECT supplier_id, supplier_name, supplier_address, supplier_city, supplier_contact, supplier_phone, supplier_email FROM supplier WHERE supplier_active = '1' ORDER BY supplier_name");
									while ($data_tbl_supplier = mysql_fetch_array($tbl_supplier))
									{
								?>
									<tr class="odd gradeX">
										<td>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=supplier&tib=form-edit-supplier&supplier_id=<?php echo $data_tbl_supplier['supplier_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_supplier_id_<?php echo $data_tbl_supplier['supplier_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										</td>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_supplier['supplier_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_supplier['supplier_address'] ?>
										</td>
										<td>
											<?php echo $data_tbl_supplier['supplier_city'] ?>
										</td>
										<td>
											<?php echo $data_tbl_supplier['supplier_contact'] ?>
										</td>
										<td>
											<?php echo $data_tbl_supplier['supplier_phone'] ?>
										</td>
										<td>
											<?php echo $data_tbl_supplier['supplier_email'] ?>
										</td>
									</tr>
									<div aria-hidden="true" class="modal fade" id="delete_supplier_id_<?php echo $data_tbl_supplier['supplier_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=supplier&tib=delete-supplier&supplier_id=<?php echo $data_tbl_supplier['supplier_id'] ?>">
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
	function form_add_supplier()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Pemasok
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=supplier&tib=add-supplier" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<h4 class="form-section">
										Pemasok
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
												<input class="form-control" name="supplier_name" placeholder="Nama" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Alamat
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="supplier_address" placeholder="Alamat" type="text">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kota/ Kabupaten
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="supplier_city" placeholder="Kota/ Kabupaten" type="text">
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
												<input class="form-control" name="supplier_contact" placeholder="Kontak" type="text">
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
												<input class="form-control" name="supplier_phone" placeholder="No. Telepon" type="text">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Email
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="supplier_email" placeholder="Email" type="text">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=supplier'">
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
	function form_edit_supplier()
	{
		$tbl_supplier = mysql_query("SELECT supplier_id, supplier_name, supplier_address, supplier_city, supplier_contact, supplier_phone, supplier_email FROM supplier WHERE supplier_id = '".$_GET['supplier_id']."'");
		$data_tbl_supplier = mysql_fetch_array($tbl_supplier);
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Pemasok
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=supplier&tib=edit-supplier" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="supplier_id" type="hidden" value="<?php echo $data_tbl_supplier['supplier_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Pemasok
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
												<input class="form-control" name="supplier_name" placeholder="Nama" type="text" value="<?php echo $data_tbl_supplier['supplier_name'] ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Alamat
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="supplier_address" placeholder="Alamat" type="text" value="<?php echo $data_tbl_supplier['supplier_address'] ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kota/ Kabupaten
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="supplier_city" placeholder="Kota/ Kabupaten" type="text" value="<?php echo $data_tbl_supplier['supplier_city'] ?>">
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
												<input class="form-control" name="supplier_contact" placeholder="Kontak" type="text" value="<?php echo $data_tbl_supplier['supplier_contact'] ?>">
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
												<input class="form-control" name="supplier_phone" placeholder="No. Telepon" type="text" value="<?php echo $data_tbl_supplier['supplier_phone'] ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Email
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="supplier_email" placeholder="Email" type="text" value="<?php echo $data_tbl_supplier['supplier_email'] ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=supplier'">
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