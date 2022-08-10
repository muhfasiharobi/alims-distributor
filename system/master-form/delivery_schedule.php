<?php
	function form_initial_delivery_schedule()
	{
?>
		<div class="page-fixed-main-content">	 
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Jadwal Pengiriman
								</span>
							</div>
							<div class="actions">
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=delivery-schedule&tib=form-add-delivery-schedule">
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
											Kendaraan
										</th>
										<th>
											Tanggal
										</th>
										<th>
											Sopir
										</th>
										<th>
											Status
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_delivery_schedule = mysql_query("SELECT a.delivery_schedule_id, a.delivery_schedule_date, a.delivery_schedule_driver_name, a.delivery_schedule_active, b.delivery_vehicle_license_no, b.delivery_vehicle_name FROM delivery_schedule a, delivery_vehicle b WHERE b.delivery_vehicle_active = '1' AND a.delivery_vehicle_id = b.delivery_vehicle_id ORDER BY a.delivery_schedule_date DESC");
									while ($data_tbl_delivery_schedule = mysql_fetch_array($tbl_delivery_schedule))
									{
										$delivery_schedule_date_indo = tanggal_indo($data_tbl_delivery_schedule['delivery_schedule_date']);
								?>
									<tr class="odd gradeX">
										<td>
										<?php
											if ($data_tbl_delivery_schedule['delivery_schedule_active'] == 1)
											{
										?>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=delivery-schedule&tib=form-view-delivery-schedule&delivery_schedule_id=<?php echo $data_tbl_delivery_schedule['delivery_schedule_id'] ?>">
												<i class="fa fa-search"></i></a>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=delivery-schedule&tib=form-edit-delivery-schedule&delivery_schedule_id=<?php echo $data_tbl_delivery_schedule['delivery_schedule_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_delivery_schedule_id_<?php echo $data_tbl_delivery_schedule['delivery_schedule_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										<?php
											}
											else
											{
										?>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Aktif" data-toggle="modal" href="#active_delivery_schedule_id_<?php echo $data_tbl_delivery_schedule['delivery_schedule_id'] ?>">
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
											<?php echo $data_tbl_delivery_schedule['delivery_vehicle_license_no'] ?> - <?php echo $data_tbl_delivery_schedule['delivery_vehicle_name'] ?>
										</td>
										<td>
											<?php echo $delivery_schedule_date_indo ?>
										</td>
										<td>
											<?php echo $data_tbl_delivery_schedule['delivery_schedule_driver_name'] ?>
										</td>
										<td>
										<?php
											if ($data_tbl_delivery_schedule['delivery_schedule_active'] == 1)
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
									<div aria-hidden="true" class="modal fade" id="delete_delivery_schedule_id_<?php echo $data_tbl_delivery_schedule['delivery_schedule_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=delivery-schedule&tib=delete-delivery-schedule&delivery_schedule_id=<?php echo $data_tbl_delivery_schedule['delivery_schedule_id'] ?>">
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
									<div aria-hidden="true" class="modal fade" id="active_delivery_schedule_id_<?php echo $data_tbl_delivery_schedule['delivery_schedule_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=delivery-schedule&tib=active-delivery-schedule&delivery_schedule_id=<?php echo $data_tbl_delivery_schedule['delivery_schedule_id'] ?>">
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
	function form_add_delivery_schedule()
	{
		$tgl_sekarang_indo = date("d-m-Y");
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Jadwal Pengiriman
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=delivery-schedule&tib=add-delivery-schedule" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<h4 class="form-section">
										Jadwal Pengiriman
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kendaraan
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#delivery_vehicle_id" data-placeholder="Kendaraan" name="delivery_vehicle_id">
													<option value=""></option>
													<?php
														$tbl_user = mysql_query("SELECT delivery_vehicle_id, delivery_vehicle_license_no, delivery_vehicle_name FROM delivery_vehicle WHERE delivery_vehicle_active = '1' ORDER BY delivery_vehicle_license_no");
														while($data_tbl_user = mysql_fetch_array($tbl_user))
														{
													?>
														<option value="<?php echo $data_tbl_user['delivery_vehicle_id'] ?>"><?php echo $data_tbl_user['delivery_vehicle_license_no'] ?> - <?php echo $data_tbl_user['delivery_vehicle_name'] ?></option>
													<?php	
														}
													?>
												</select>
												<div id="delivery_vehicle_id"></div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Tanggal
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d" name="delivery_schedule_date" placeholder="Tanggal" type="text" value="<?php echo $tgl_sekarang_indo ?>">
											</div>
										</div>
									</div>
									<h4 class="form-section">
										Sopir Pengiriman
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Sopir
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#delivery_schedule_driver_name" data-placeholder="Sopir" name="delivery_schedule_driver_name">
													<option value=""></option>
													<?php
														$tbl_user = mysql_query("SELECT a.user_id, a.user_name FROM user a, user_category b WHERE a.user_active = '1' AND b.user_category_active = '1' AND b.user_category_name = 'Driver' AND a.user_category_id = b.user_category_id ORDER BY a.user_name");
														while($data_tbl_user = mysql_fetch_array($tbl_user))
														{
													?>
														<option value="<?php echo $data_tbl_user['user_name'] ?>"><?php echo $data_tbl_user['user_name'] ?></option>
													<?php	
														}
													?>
												</select>
												<div id="delivery_schedule_driver_name"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline purple sbold">
										<i class="fa fa-feed"></i>
										Proses
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=delivery-schedule'">
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
	function form_helper_delivery_schedule()
	{
		$tbl_delivery_schedule = mysql_query("SELECT a.delivery_schedule_id, a.delivery_schedule_date, a.delivery_schedule_driver_name, b.delivery_vehicle_license_no, b.delivery_vehicle_name FROM delivery_schedule a, delivery_vehicle b WHERE a.delivery_schedule_id = '".$_GET['delivery_schedule_id']."' AND a.delivery_vehicle_id = b.delivery_vehicle_id");
		$data_tbl_delivery_schedule = mysql_fetch_array($tbl_delivery_schedule);
		
		$delivery_schedule_date_indo = tanggal_indo($data_tbl_delivery_schedule['delivery_schedule_date']);
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_delivery_schedule['delivery_vehicle_license_no'] ?> - <?php echo $data_tbl_delivery_schedule['delivery_vehicle_name'] ?>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascrip:;">
							<?php echo $delivery_schedule_date_indo ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascrip:;">
							<?php echo $data_tbl_delivery_schedule['delivery_schedule_driver_name'] ?>
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
									Jadwal Pengiriman
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=delivery-schedule&tib=helper-delivery-schedule" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="delivery_schedule_id" type="hidden" value="<?php echo $data_tbl_delivery_schedule['delivery_schedule_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Helper Pengiriman
									</h4>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>
													Helper
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#delivery_schedule_detail_helper_name" data-placeholder="Helper" name="delivery_schedule_detail_helper_name">
													<option value=""></option>
													<?php
														$tbl_user = mysql_query("SELECT a.user_id, a.user_name FROM user a, user_category b WHERE a.user_active = '1' AND b.user_category_active = '1' AND b.user_category_name = 'Helper' AND a.user_category_id = b.user_category_id ORDER BY a.user_name");
														while($data_tbl_user = mysql_fetch_array($tbl_user))
														{
															$tbl_delivery_schedule_detail = mysql_query("SELECT b.delivery_schedule_detail_helper_name FROM delivery_schedule a, delivery_schedule_detail b WHERE a.delivery_schedule_date = '".$data_tbl_delivery_schedule['delivery_schedule_date']."' AND b.delivery_schedule_detail_helper_name  = '".$data_tbl_user['user_name']."' AND a.delivery_schedule_id = b.delivery_schedule_id");
															$jumlah_tbl_delivery_schedule_detail = mysql_num_rows($tbl_delivery_schedule_detail);
															
															if ($jumlah_tbl_delivery_schedule_detail < 1)
															{
													?>
															<option value="<?php echo $data_tbl_user['user_name'] ?>"><?php echo $data_tbl_user['user_name'] ?></option>
													<?php	
															}
														}
													?>
												</select>
												<div id="delivery_schedule_detail_helper_name"></div>
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
									$tbl_delivery_schedule_detail = mysql_query("SELECT delivery_schedule_id FROM delivery_schedule_detail WHERE delivery_schedule_id = '".$data_tbl_delivery_schedule['delivery_schedule_id']."'");
									$jumlah_tbl_delivery_schedule_detail = mysql_num_rows($tbl_delivery_schedule_detail);
									
									if ($jumlah_tbl_delivery_schedule_detail > 0)
									{
								?>
									<button type="button" class="btn btn-sm btn-outline green sbold" onclick="location.href='?alimms=delivery-schedule'">
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
											Nama
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_delivery_schedule_detail = mysql_query("SELECT delivery_schedule_detail_id, delivery_schedule_detail_helper_name FROM delivery_schedule_detail WHERE delivery_schedule_id = '".$data_tbl_delivery_schedule['delivery_schedule_id']."' ORDER BY delivery_schedule_detail_helper_name");
									while ($data_tbl_delivery_schedule_detail = mysql_fetch_array($tbl_delivery_schedule_detail))
									{
								?>
									<tr class="odd gradeX">
										<td>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#remove_delivery_schedule_detail_id_<?php echo $data_tbl_delivery_schedule_detail['delivery_schedule_detail_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										</td>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_delivery_schedule_detail['delivery_schedule_detail_helper_name'] ?>
										</td>
									</tr>
									<div aria-hidden="true" class="modal fade" id="remove_delivery_schedule_detail_id_<?php echo $data_tbl_delivery_schedule_detail['delivery_schedule_detail_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=delivery-schedule&tib=remove-delivery-schedule&delivery_schedule_detail_id=<?php echo $data_tbl_delivery_schedule_detail['delivery_schedule_detail_id'] ?>">
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
	function form_edit_delivery_schedule()
	{
		$tbl_delivery_schedule = mysql_query("SELECT delivery_schedule_id, delivery_vehicle_id, delivery_schedule_date,  delivery_schedule_driver_name FROM delivery_schedule WHERE delivery_schedule_id = '".$_GET['delivery_schedule_id']."'");
		$data_tbl_delivery_schedule = mysql_fetch_array($tbl_delivery_schedule);
		
		$delivery_schedule_date = explode("-", $data_tbl_delivery_schedule['delivery_schedule_date']);
		$date_delivery_schedule = $delivery_schedule_date[2];
		$month_delivery_schedule = $delivery_schedule_date[1];
		$year_delivery_schedule = $delivery_schedule_date[0];
		$delivery_schedule_date = date("d-m-Y", mktime(0, 0, 0, $month_delivery_schedule, $date_delivery_schedule, $year_delivery_schedule));
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Jadwal Pengiriman
								</span>
							</div>
						</div>
						<div class="portlet-body form">
							<form action="?alimms=delivery-schedule&tib=edit-delivery-schedule" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="delivery_schedule_id" type="hidden" value="<?php echo $data_tbl_delivery_schedule['delivery_schedule_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Jadwal Pengiriman
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kendaraan
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-placeholder="Kendaraan" name="delivery_vehicle_id">
													<option value=""></option>
													<?php
														$tbl_delivery_vehicle = mysql_query("SELECT delivery_vehicle_id, delivery_vehicle_license_no, delivery_vehicle_name FROM delivery_vehicle WHERE delivery_vehicle_active = '1' ORDER BY delivery_vehicle_license_no");
														while($data_tbl_delivery_vehicle = mysql_fetch_array($tbl_delivery_vehicle))
														{
															if ($data_tbl_delivery_vehicle['delivery_vehicle_id'] == $data_tbl_delivery_schedule['delivery_vehicle_id'])
															{
													?>
															<option selected="selected" value="<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_id'] ?>"><?php echo $data_tbl_delivery_vehicle['delivery_vehicle_license_no'] ?> - <?php echo $data_tbl_delivery_vehicle['delivery_vehicle_name'] ?></option>
													<?php
															} 
															else 
															{
													?>
															<option value="<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_id'] ?>"><?php echo $data_tbl_delivery_vehicle['delivery_vehicle_license_no'] ?> - <?php echo $data_tbl_delivery_vehicle['delivery_vehicle_name'] ?></option>
													<?php
															}
														}
													?>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Tanggal
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="delivery_schedule_date" placeholder="Tanggal" type="text" value="<?php echo $delivery_schedule_date ?>">
											</div>
										</div>
									</div>
									<h4 class="form-section">
										Pengemudi Pengiriman
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Sopir
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-placeholder="Sopir" name="delivery_schedule_driver_name">
													<option value=""></option>
													<?php
														$tbl_user = mysql_query("SELECT a.user_id, a.user_name FROM user a, user_category b WHERE a.user_active = '1' AND b.user_category_active = '1' AND b.user_category_name = 'Driver' AND a.user_category_id = b.user_category_id ORDER BY a.user_name");
														while($data_tbl_user = mysql_fetch_array($tbl_user))
														{
															if ($data_tbl_user['user_name'] == $data_tbl_delivery_schedule['delivery_schedule_driver_name'])
															{
													?>
															<option selected="selected" value="<?php echo $data_tbl_user['user_name'] ?>"><?php echo $data_tbl_user['user_name'] ?></option>
													<?php
															} 
															else 
															{
													?>
															<option value="<?php echo $data_tbl_user['user_name'] ?>"><?php echo $data_tbl_user['user_name'] ?></option>
													<?php
															}	
														}
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=delivery-schedule'">
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
	function form_view_delivery_schedule()
	{
		$tbl_delivery_schedule = mysql_query("SELECT a.delivery_schedule_id, a.delivery_schedule_date, a.delivery_schedule_driver_name, b.delivery_vehicle_license_no, b.delivery_vehicle_name FROM delivery_schedule a, delivery_vehicle b WHERE a.delivery_schedule_id = '".$_GET['delivery_schedule_id']."' AND a.delivery_vehicle_id = b.delivery_vehicle_id");
		$data_tbl_delivery_schedule = mysql_fetch_array($tbl_delivery_schedule);
		
		$delivery_schedule_date_indo = tanggal_indo($data_tbl_delivery_schedule['delivery_schedule_date']);
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_delivery_schedule['delivery_vehicle_license_no'] ?> - <?php echo $data_tbl_delivery_schedule['delivery_vehicle_name'] ?>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascrip:;">
							<?php echo $delivery_schedule_date_indo ?>
						</a>
					</li>
					<li>
						<a class="todo-active" href="javascrip:;">
							<?php echo $data_tbl_delivery_schedule['delivery_schedule_driver_name'] ?>
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
									Jadwal Pengiriman
								</span>
							</div>
							<div class="actions">
								<a class="btn btn-outline btn-sm sbold yellow" href="?alimms=delivery-schedule">
									<i class="fa fa-sign-out"></i>
									Keluar
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-bordered table-checkable table-hover table-striped order-column" id="sample_2">
								<thead>
									<tr>
										<th>
											No
										</th>
										<th>
											Nama
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_delivery_schedule_detail = mysql_query("SELECT delivery_schedule_detail_helper_name FROM delivery_schedule_detail WHERE delivery_schedule_id = '".$data_tbl_delivery_schedule['delivery_schedule_id']."' ORDER BY delivery_schedule_detail_helper_name");
									while ($data_tbl_delivery_schedule_detail = mysql_fetch_array($tbl_delivery_schedule_detail))
									{
								?>
									<tr class="odd gradeX">
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_delivery_schedule_detail['delivery_schedule_detail_helper_name'] ?>
										</td>
									</tr>
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
?>