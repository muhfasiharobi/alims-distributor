<?php
	function form_initial_customer_districts()
	{
?>
		<div class="page-fixed-main-content">	 
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Kecamatan Pelanggan
								</span>
							</div>
							<div class="actions">
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=customer-districts&tib=form-add-customer-districts">
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
											Kota/ Kabupaten
										</th>
										<th>
											Rayon
										</th>
										<th>
											Status
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_customer_districts = mysql_query("SELECT a.customer_districts_id, a.customer_districts_name, a.customer_districts_active, b.customer_city_name, c.customer_area_name FROM customer_districts a, customer_city b, customer_area c WHERE b.customer_city_active = '1' AND c.customer_area_active = '1' AND a.customer_city_id = b.customer_city_id AND a.customer_area_id = c.customer_area_id ORDER BY a.customer_districts_name");
									while ($data_tbl_customer_districts = mysql_fetch_array($tbl_customer_districts))
									{
								?>
									<tr class="odd gradeX">
										<td>
										<?php
											if ($data_tbl_customer_districts['customer_districts_active'] == 1)
											{
										?>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=customer-districts&tib=form-edit-customer-districts&customer_districts_id=<?php echo $data_tbl_customer_districts['customer_districts_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_customer_districts_id_<?php echo $data_tbl_customer_districts['customer_districts_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										<?php
											}
											else
											{
										?>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Aktif" data-toggle="modal" href="#active_customer_districts_id_<?php echo $data_tbl_customer_districts['customer_districts_id'] ?>">
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
											<?php echo $data_tbl_customer_districts['customer_districts_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_customer_districts['customer_city_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_customer_districts['customer_area_name'] ?>
										</td>
										<td>
										<?php
											if ($data_tbl_customer_districts['customer_districts_active'] == 1)
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
									<div aria-hidden="true" class="fade modal" id="delete_customer_districts_id_<?php echo $data_tbl_customer_districts['customer_districts_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=customer-districts&tib=delete-customer-districts&customer_districts_id=<?php echo $data_tbl_customer_districts['customer_districts_id'] ?>">
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
									<div aria-hidden="true" class="fade modal" id="active_customer_districts_id_<?php echo $data_tbl_customer_districts['customer_districts_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=customer-districts&tib=active-customer-districts&customer_districts_id=<?php echo $data_tbl_customer_districts['customer_districts_id'] ?>">
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
	function form_add_customer_districts()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Kecamatan Pelanggan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=customer-districts&tib=add-customer-districts" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<h4 class="form-section">
										Kecamatan Pelanggan
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
												<input class="form-control" name="customer_districts_name" placeholder="Nama" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kota/ Kabupaten
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#customer_city_id" data-placeholder="Kota/ Kabupaten" name="customer_city_id">
													<option value=""></option>
													<?php
														$tbl_customer_city = mysql_query("SELECT customer_city_id, customer_city_name FROM customer_city WHERE customer_city_active = '1' ORDER BY customer_city_name");
														while($data_tbl_customer_city = mysql_fetch_array($tbl_customer_city))
														{
													?>
														<option value="<?php echo $data_tbl_customer_city['customer_city_id'] ?>"><?php echo $data_tbl_customer_city['customer_city_name'] ?></option>
													<?php	
														}
													?>
												</select>
												<div id="customer_city_id"></div>
											</div>
										</div>
									</div>
									<h4 class="form-section">
										Rayon Pelanggan
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Rayon
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#customer_area_id" data-placeholder="Rayon" name="customer_area_id">
													<option value=""></option>
													<?php
														$tbl_customer_area = mysql_query("SELECT customer_area_id, customer_area_name FROM customer_area WHERE customer_area_active = '1' ORDER BY customer_area_name");
														while($data_tbl_customer_area = mysql_fetch_array($tbl_customer_area))
														{
													?>
														<option value="<?php echo $data_tbl_customer_area['customer_area_id'] ?>"><?php echo $data_tbl_customer_area['customer_area_name'] ?></option>
													<?php	
														}
													?>
												</select>
												<div id="customer_area_id"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=customer-districts'">
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
	function form_edit_customer_districts()
	{
		$tbl_customer_districts = mysql_query("SELECT customer_districts_id, customer_districts_name, customer_city_id, customer_area_id FROM customer_districts WHERE customer_districts_id = '".$_GET['customer_districts_id']."'");
		$data_tbl_customer_districts = mysql_fetch_array($tbl_customer_districts);
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Kecamatan Pelanggan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=customer-districts&tib=edit-customer-districts" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="customer_districts_id" type="hidden" value="<?php echo $data_tbl_customer_districts['customer_districts_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Kecamatan Pelanggan
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
												<input class="form-control" name="customer_districts_name" placeholder="Nama" type="text" value="<?php echo $data_tbl_customer_districts['customer_districts_name'] ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kota/ Kabupaten
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#customer_city_id" data-placeholder="Kota/ Kabupaten" name="customer_city_id">
													<option value=""></option>
													<?php
														$tbl_customer_city = mysql_query("SELECT customer_city_id, customer_city_name FROM customer_city WHERE customer_city_active = '1' ORDER BY customer_city_name");
														while($data_tbl_customer_city = mysql_fetch_array($tbl_customer_city))
														{
															if ($data_tbl_customer_city['customer_city_id'] == $data_tbl_customer_districts['customer_city_id'])
															{
													?>
															<option selected="selected" value="<?php echo $data_tbl_customer_city['customer_city_id'] ?>"><?php echo $data_tbl_customer_city['customer_city_name'] ?></option>
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
												<div id="customer_city_id"></div>
											</div>
										</div>
									</div>
									<h4 class="form-section">
										Rayon Pelanggan
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Rayon
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#customer_area_id" data-placeholder="Rayon" name="customer_area_id">
													<option value=""></option>
													<?php
														$tbl_customer_area = mysql_query("SELECT customer_area_id, customer_area_name FROM customer_area WHERE customer_area_active = '1' ORDER BY customer_area_name");
														while($data_tbl_customer_area = mysql_fetch_array($tbl_customer_area))
														{
															if ($data_tbl_customer_area['customer_area_id'] == $data_tbl_customer_districts['customer_area_id'])
															{
													?>
															<option selected="selected" value="<?php echo $data_tbl_customer_area['customer_area_id'] ?>"><?php echo $data_tbl_customer_area['customer_area_name'] ?></option>
													<?php
															} 
															else 
															{
													?>
															<option value="<?php echo $data_tbl_customer_area['customer_area_id'] ?>"><?php echo $data_tbl_customer_area['customer_area_name'] ?></option>
													<?php
															}
														}
													?>
												</select>
												<div id="customer_area_id"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=customer-districts'">
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