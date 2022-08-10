<?php
	function form_initial_user_category()
	{
?>
		<div class="page-fixed-main-content">	 
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Kategori Pengguna
								</span>
							</div>
							<div class="actions">
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=user-category&tib=form-add-user-category">
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
											Departemen
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_user_category = mysql_query("SELECT a.user_category_id, a.user_category_name, b.user_department_name FROM user_category a, user_department b WHERE a.user_category_active = '1' AND b.user_department_active = '1' AND a.user_department_id = b.user_department_id ORDER BY a.user_category_name");
									while ($data_tbl_user_category = mysql_fetch_array($tbl_user_category))
									{
								?>
									<tr class="odd gradeX">
										<td>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=user-category&tib=form-edit-user-category&user_category_id=<?php echo $data_tbl_user_category['user_category_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_user_category_id_<?php echo $data_tbl_user_category['user_category_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										</td>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_user_category['user_category_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_user_category['user_department_name'] ?>
										</td>
									</tr>
									<div aria-hidden="true" class="modal fade" id="delete_user_category_id_<?php echo $data_tbl_user_category['user_category_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=user-category&tib=delete-user-category&user_category_id=<?php echo $data_tbl_user_category['user_category_id'] ?>">
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
	function form_add_user_category()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Kategori Pengguna
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=user-category&tib=add-user-category" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<h4 class="form-section">
										Kategori Pengguna
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
												<input class="form-control" name="user_category_name" placeholder="Nama" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Departemen
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#user_department_id" data-placeholder="Departemen" name="user_department_id">
													<option value=""></option>
													<?php
														$tbl_user_department = mysql_query("SELECT user_department_id, user_department_name FROM user_department WHERE user_department_active = '1' ORDER BY user_department_name");
														while($data_tbl_user_department = mysql_fetch_array($tbl_user_department))
														{
													?>
														<option value="<?php echo $data_tbl_user_department['user_department_id'] ?>"><?php echo $data_tbl_user_department['user_department_name'] ?></option>
													<?php	
														}
													?>
												</select>
												<div id="user_department_id"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=user-category'">
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
	function form_edit_user_category()
	{
		$tbl_user_category = mysql_query("SELECT user_category_id, user_category_name, user_department_id FROM user_category WHERE user_category_id = '".$_GET['user_category_id']."'");
		$data_tbl_user_category = mysql_fetch_array($tbl_user_category);
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Kategori Pengguna
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=user-category&tib=edit-user-category" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="user_category_id" type="hidden" value="<?php echo $data_tbl_user_category['user_category_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Kategori Pengguna
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
												<input class="form-control" name="user_category_name" placeholder="Nama" type="text" value="<?php echo $data_tbl_user_category['user_category_name'] ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Departemen
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#user_department_id" data-placeholder="Departemen" name="user_department_id">
													<option value=""></option>
													<?php
														$tbl_user_department = mysql_query("SELECT user_department_id, user_department_name FROM user_department WHERE user_department_active = '1' ORDER BY user_department_name");
														while($data_tbl_user_department = mysql_fetch_array($tbl_user_department))
														{
															if ($data_tbl_user_department['user_department_id'] == $data_tbl_user_category['user_department_id'])
															{
													?>
															<option selected="selected" value="<?php echo $data_tbl_user_department['user_department_id'] ?>"><?php echo $data_tbl_user_department['user_department_name'] ?></option>
													<?php
															} 
															else 
															{
													?>
															<option value="<?php echo $data_tbl_user_department['user_department_id'] ?>"><?php echo $data_tbl_user_department['user_department_name'] ?></option>
													<?php
															}
														}
													?>
												</select>
												<div id="user_department_id"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=user-category'">
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