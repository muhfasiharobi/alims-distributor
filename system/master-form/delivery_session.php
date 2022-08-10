<?php
	function form_initial_delivery_session()
	{
?>
		<div class="page-fixed-main-content">	 
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Sesi Pengiriman
								</span>
							</div>
							<div class="actions">
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=delivery-session&tib=form-add-delivery-session">
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
											Status
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_delivery_session = mysql_query("SELECT delivery_session_id, delivery_session_name, delivery_session_active FROM delivery_session ORDER BY delivery_session_name");
									while ($data_tbl_delivery_session = mysql_fetch_array($tbl_delivery_session))
									{
								?>
									<tr class="odd gradeX">
										<td>
										<?php
											if ($data_tbl_delivery_session['delivery_session_active'] == 1)
											{
										?>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=delivery-session&tib=form-edit-delivery-session&delivery_session_id=<?php echo $data_tbl_delivery_session['delivery_session_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_delivery_session_id_<?php echo $data_tbl_delivery_session['delivery_session_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										<?php
											}
											else
											{
										?>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Aktif" data-toggle="modal" href="#active_delivery_session_id_<?php echo $data_tbl_delivery_session['delivery_session_id'] ?>">
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
											<?php echo $data_tbl_delivery_session['delivery_session_name'] ?>
										</td>
										<td>
										<?php
											if ($data_tbl_delivery_session['delivery_session_active'] == 1)
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
									<div aria-hidden="true" class="fade modal" id="delete_delivery_session_id_<?php echo $data_tbl_delivery_session['delivery_session_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=delivery-session&tib=delete-delivery-session&delivery_session_id=<?php echo $data_tbl_delivery_session['delivery_session_id'] ?>">
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
									<div aria-hidden="true" class="fade modal" id="active_delivery_session_id_<?php echo $data_tbl_delivery_session['delivery_session_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=delivery-session&tib=active-delivery-session&delivery_session_id=<?php echo $data_tbl_delivery_session['delivery_session_id'] ?>">
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
	function form_add_delivery_session()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Sesi Pengiriman
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=delivery-session&tib=add-delivery-session" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<h4 class="form-section">
										Sesi Pengiriman
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
												<input class="form-control" name="delivery_session_name" placeholder="Nama" type="text">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=delivery-session'">
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
	function form_edit_delivery_session()
	{
		$tbl_delivery_session = mysql_query("SELECT delivery_session_id, delivery_session_name FROM delivery_session WHERE delivery_session_id = '".$_GET['delivery_session_id']."'");
		$data_tbl_delivery_session = mysql_fetch_array($tbl_delivery_session);
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Sesi Pengiriman
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=delivery-session&tib=edit-delivery-session" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="delivery_session_id" type="hidden" value="<?php echo $data_tbl_delivery_session['delivery_session_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Sesi Pengiriman
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
												<input class="form-control" name="delivery_session_name" placeholder="Nama" type="text" value="<?php echo $data_tbl_delivery_session['delivery_session_name'] ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=delivery-session'">
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