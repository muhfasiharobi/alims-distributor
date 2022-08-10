<?php
	function form_initial_user_department()
	{
?>
		<div class="page-fixed-main-content">	 
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Departemen Pengguna
								</span>
							</div>
							<div class="actions">
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=user-department&tib=form-add-user-department">
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
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_user_department = mysql_query("SELECT user_department_id, user_department_name FROM user_department WHERE user_department_active = '1' ORDER BY user_department_name");
									while ($data_tbl_user_department = mysql_fetch_array($tbl_user_department))
									{
								?>
									<tr class="odd gradeX">
										<td>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=user-department&tib=form-edit-user-department&user_department_id=<?php echo $data_tbl_user_department['user_department_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_user_department_id_<?php echo $data_tbl_user_department['user_department_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										</td>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_user_department['user_department_name'] ?>
										</td>
									</tr>
									<div aria-hidden="true" class="modal fade" id="delete_user_department_id_<?php echo $data_tbl_user_department['user_department_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=user-department&tib=delete-user-department&user_department_id=<?php echo $data_tbl_user_department['user_department_id'] ?>">
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
	function form_add_user_department()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Departemen Pengguna
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=user-department&tib=add-user-department" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<h4 class="form-section">
										Departemen Pengguna
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
												<input class="form-control" name="user_department_name" placeholder="Nama" type="text">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=user-department'">
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
	function form_edit_user_department()
	{
		$tbl_user_department = mysql_query("SELECT user_department_id, user_department_name FROM user_department WHERE user_department_id = '".$_GET['user_department_id']."'");
		$data_tbl_user_department = mysql_fetch_array($tbl_user_department);
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Departemen Pengguna
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=user-department&tib=edit-user-department" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="user_department_id" type="hidden" value="<?php echo $data_tbl_user_department['user_department_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Departemen
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
												<input class="form-control" name="user_department_name" placeholder="Nama" type="text" value="<?php echo $data_tbl_user_department['user_department_name'] ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=user-department'">
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