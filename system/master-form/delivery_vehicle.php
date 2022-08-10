<?php
	function form_initial_delivery_vehicle()
	{
?>
		<div class="page-fixed-main-content">	 
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Kendaraan Pengiriman
								</span>
							</div>
							<div class="actions">
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=delivery-vehicle&tib=form-add-delivery-vehicle">
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
											Plat Nomor
										</th>
										<th>
											Nama
										</th>
										<th>
											Kapasitas Muatan
										</th>
										<th>
											Status
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_delivery_vehicle = mysql_query("SELECT delivery_vehicle_id, delivery_vehicle_license_no, delivery_vehicle_name, delivery_vehicle_payload_capacity, delivery_vehicle_active FROM delivery_vehicle ORDER BY delivery_vehicle_license_no");
									while ($data_tbl_delivery_vehicle = mysql_fetch_array($tbl_delivery_vehicle))
									{
										$delivery_vehicle_payload_capacity_indo = format_angka($data_tbl_delivery_vehicle['delivery_vehicle_payload_capacity']);
								?>
									<tr class="odd gradeX">
										<td>
										<?php
											if ($data_tbl_delivery_vehicle['delivery_vehicle_active'] == 1)
											{
										?>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=delivery-vehicle&tib=form-edit-delivery-vehicle&delivery_vehicle_id=<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_delivery_vehicle_id_<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										<?php
											}
											else
											{
										?>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Aktif" data-toggle="modal" href="#active_delivery_vehicle_id_<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_id'] ?>">
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
											<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_license_no'] ?>
										</td>
										<td>
											<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_name'] ?>
										</td>
										<td>
											<?php echo $delivery_vehicle_payload_capacity_indo ?>
										</td>
										<td>
										<?php
											if ($data_tbl_delivery_vehicle['delivery_vehicle_active'] == 1)
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
									<div aria-hidden="true" class="fade modal" id="delete_delivery_vehicle_id_<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=delivery-vehicle&tib=delete-delivery-vehicle&delivery_vehicle_id=<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_id'] ?>">
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
									<div aria-hidden="true" class="fade modal" id="active_delivery_vehicle_id_<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=delivery-vehicle&tib=active-delivery-vehicle&delivery_vehicle_id=<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_id'] ?>">
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
	function form_add_delivery_vehicle()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Kendaraan Pengiriman
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=delivery-vehicle&tib=add-delivery-vehicle" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<h4 class="form-section">
										Kendaraan Pengiriman
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Plat Nomor
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="delivery_vehicle_license_no" placeholder="Plat Nomor" type="text">
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
												<input class="form-control" name="delivery_vehicle_name" placeholder="Nama" type="text">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kapasitas Muatan
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="delivery_vehicle_payload_capacity" placeholder="Kapasitas Muatan" type="text">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=delivery-vehicle'">
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
	function form_edit_delivery_vehicle()
	{
		$tbl_delivery_vehicle = mysql_query("SELECT delivery_vehicle_id, delivery_vehicle_license_no, delivery_vehicle_name, delivery_vehicle_payload_capacity FROM delivery_vehicle WHERE delivery_vehicle_id = '".$_GET['delivery_vehicle_id']."'");
		$data_tbl_delivery_vehicle = mysql_fetch_array($tbl_delivery_vehicle);
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Kendaraan Pengiriman
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=delivery-vehicle&tib=edit-delivery-vehicle" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="delivery_vehicle_id" type="hidden" value="<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Kendaraan Pengiriman
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Plat Nomor
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="delivery_vehicle_license_no" placeholder="Plat Nomor" type="text" value="<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_license_no'] ?>">
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
												<input class="form-control" name="delivery_vehicle_name" placeholder="Nama" type="text" value="<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_name'] ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kapasitas Muatan
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="delivery_vehicle_payload_capacity" placeholder="Kapasitas Muatan" type="text" value="<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_payload_capacity'] ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=delivery-vehicle'">
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