<?php
	function form_initial_user()
	{
?>
		<div class="page-fixed-main-content">	 
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Pengguna
								</span>
							</div>
							<div class="actions">
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=user&tib=form-add-user">
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
											Foto
										</th>
										<th>
											Kategori
										</th>
										<th>
											NPP
										</th>
										<th>
											Nama
										</th>
										<th>
											No. Telepon
										</th>
										<th>
											Email
										</th>
										<th>
											Username
										</th>
										<th>
											Password
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_user = mysql_query("SELECT a.user_id, a.user_photo, a.user_npp, a.user_name, a.user_phone, a.user_email, a.user_username, a.user_password, b.user_category_name FROM user a, user_category b WHERE a.user_active = '1' AND b.user_category_active = '1' AND a.user_category_id = b.user_category_id ORDER BY a.user_name");
									while ($data_tbl_user = mysql_fetch_array($tbl_user))
									{
								?>
									<tr class="odd gradeX">
										<td>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=user&tib=form-edit-user&user_id=<?php echo $data_tbl_user['user_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_user_id_<?php echo $data_tbl_user['user_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										</td>
										<td>
											<?php echo $no ?>
										</td>
										<td>
										<?php
											if($data_tbl_user['user_photo'] != "")
											{
										?>
											<a href="../assets/layouts/layout6/img/user-photo/<?php echo $data_tbl_user['user_photo'] ?>" class="fancybox-button" data-rel="fancybox-button">
												<img class="img-responsive" src="../assets/layouts/layout6/img/user-photo/<?php echo $data_tbl_user['user_photo'] ?>" alt="">
											</a>
										<?php
											}
											else
											{
										?>
											<a href="../assets/layouts/layout6/img/user-photo/no_photo.jpg" class="fancybox-button" data-rel="fancybox-button">
												<img class="img-responsive" src="../assets/layouts/layout6/img/user-photo/no_photo.jpg">
											</a>
										<?php
											}
										?>
										</td>
										<td>
											<?php echo $data_tbl_user['user_category_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_user['user_npp'] ?>
										</td>
										<td>
											<?php echo $data_tbl_user['user_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_user['user_email'] ?>
										</td>
										<td>
											<?php echo $data_tbl_user['user_phone'] ?>
										</td>
										<td>
											<?php echo $data_tbl_user['user_username'] ?>
										</td>
										<td>
											*******
										</td>
									</tr>
									<div aria-hidden="true" class="modal fade" id="delete_user_id_<?php echo $data_tbl_user['user_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=user&tib=delete-user&user_id=<?php echo $data_tbl_user['user_id'] ?>">
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
	function form_add_user()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Pengguna
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=user&tib=add-user" class="horizontal-form" enctype="multipart/form-data" id="form_sample_3" method="post">
								<div class="form-body">
									<h4 class="form-section">
										Pengguna
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Foto
												</label>
												<br />
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
														<img src="../assets/layouts/layout6/img/user-photo/no_photo.jpg">
													</div>
													<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
													<div>
														<span class="btn default btn-file">
															<span class="fileinput-new">
																Pilih Foto
															</span>
															<span class="fileinput-exists">
																Ganti
															</span>
															<input type="file" name="user_photo">
														</span>
														<a class="btn red fileinput-exists" data-dismiss="fileinput" href="javascript:;">Hapus</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kategori
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#user_category_id" data-placeholder="Kategori" name="user_category_id">
													<option value=""></option>
													<?php
														$tbl_user_category = mysql_query("SELECT user_category_id, user_category_name FROM user_category WHERE user_category_active = '1' ORDER BY user_category_name");
														while($data_tbl_user_category = mysql_fetch_array($tbl_user_category))
														{
													?>
														<option value="<?php echo $data_tbl_user_category['user_category_id'] ?>"><?php echo $data_tbl_user_category['user_category_name'] ?></option>
													<?php	
														}
													?>
												</select>
												<div id="user_category_id"></div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													NPP
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="user_npp" placeholder="NPP" type="text">
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
												<input class="form-control" name="user_name" placeholder="Nama" type="text">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													No. Telepon
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="user_phone" placeholder="No. Telepon" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Email
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="user_email" placeholder="Email" type="text">
											</div>
										</div>
									</div>
									<h4 class="form-section">
										Akun Pengguna
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Username
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="user_username" placeholder="Username" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Password
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="user_password" placeholder="Password" type="password">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=user'">
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
	function form_edit_user()
	{
		$tbl_user = mysql_query("SELECT user_id, user_category_id, user_npp, user_name, user_phone, user_email, user_username FROM user WHERE user_id = '".$_GET['user_id']."'");
		$data_tbl_user = mysql_fetch_array($tbl_user);
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Pengguna
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=user&tib=edit-user" class="horizontal-form" enctype="multipart/form-data" id="form_sample_3" method="post">
							<input class="form-control" name="user_id" type="hidden" value="<?php echo $data_tbl_user['user_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Pengguna
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Foto
												</label>
												<br />
												<div class="fileinput fileinput-new" data-provides="fileinput">
													<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
														<img src="../assets/layouts/layout6/img/user-photo/no_photo.jpg">
													</div>
													<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
													<div>
														<span class="btn default btn-file">
															<span class="fileinput-new">
																Pilih Foto
															</span>
															<span class="fileinput-exists">
																Ganti
															</span>
															<input type="file" name="user_photo">
														</span>
														<a class="btn red fileinput-exists" data-dismiss="fileinput" href="javascript:;">Hapus</a>
													</div>
													<span class="help-block">
														*) Jika Foto Tidak Ingin Diubah, Foto Dikosongkan 
													</span>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Kategori
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#user_category_id" data-placeholder="Kategori" name="user_category_id">
													<option value=""></option>
													<?php
														$tbl_user_category = mysql_query("SELECT user_category_id, user_category_name FROM user_category WHERE user_category_active = '1' ORDER BY user_category_name");
														while($data_tbl_user_category = mysql_fetch_array($tbl_user_category))
														{
															if ($data_tbl_user_category['user_category_id'] == $data_tbl_user['user_category_id'])
															{
													?>
															<option selected="selected" value="<?php echo $data_tbl_user_category['user_category_id'] ?>"><?php echo $data_tbl_user_category['user_category_name'] ?></option>
													<?php
															} 
															else 
															{
													?>
															<option value="<?php echo $data_tbl_user_category['user_category_id'] ?>"><?php echo $data_tbl_user_category['user_category_name'] ?></option>
													<?php
															}
														}
													?>
												</select>
												<div id="user_category_id"></div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													NPP
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="user_npp" placeholder="NPP" type="text" value="<?php echo $data_tbl_user['user_npp'] ?>">
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
												<input class="form-control" name="user_name" placeholder="Nama" type="text" value="<?php echo $data_tbl_user['user_name'] ?>">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													No. Telepon
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="user_phone" placeholder="No. Telepon" type="text" value="<?php echo $data_tbl_user['user_phone'] ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Email
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="user_email" placeholder="Email" type="text" value="<?php echo $data_tbl_user['user_email'] ?>">
											</div>
										</div>
									</div>
									<h4 class="form-section">
										Akun Pengguna
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Username
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="user_username" placeholder="Username" type="text" value="<?php echo $data_tbl_user['user_username'] ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Password
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="user_new_password" placeholder="Password" type="password">
												<span class="help-block">
													*) Jika Password Tidak Ingin Diubah, Password Dikosongkan 
												</span>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=user'">
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