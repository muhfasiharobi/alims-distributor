<?php
	function default_user_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-user font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Pengguna
							</span>
						</div>
						<div class="actions">
							<div class="actions">
								<a class="btn blue btn-outline" href="?connect=user&execute=add-user-platform">
									<i class="icon-note"></i>
									Tambah
								</a>
							</div>
						</div>
					</div>
					<br><br><br>
					<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover order-column" id="sample_2">
							<thead>
								<tr>
									<th>
										No
									</th>
									<th>
										Kategori
									</th>
									<th>
										Nama
									</th>
									<th>
										No. Telpon
									</th>
									<th>
										Email
									</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$user_query = mysql_query("SELECT a.user_id, a.user_name, a.user_phone, a.user_email, a.user_username, a.user_original_password, b.user_category_name FROM user a, user_category b WHERE a.user_category_id = b.user_category_id AND a.user_active = '1' AND b.user_category_active = '1' AND b.user_category_name != 'Agen' ORDER BY a.user_id DESC");
								while ($user_fetch_array = mysql_fetch_array($user_query))
								{
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $user_fetch_array['user_category_name']; ?>
										</td>
										<td>
											<?php echo $user_fetch_array['user_name']; ?>
										</td>
										<td>
											<?php echo $user_fetch_array['user_phone']; ?>
										</td>
										<td>
											<?php echo $user_fetch_array['user_email']; ?>
										</td>
										<td>
											<a class="btn dark btn-outline" data-target="#view_user_id_<?php echo $user_fetch_array['user_id']; ?>" data-toggle="modal">
												<i class="icon-key"></i>
												Lihat
											</a>
											<a class="btn purple btn-outline" href="?connect=user&execute=edit-user-platform&user_id=<?php echo $user_fetch_array['user_id']; ?>">
												<i class="icon-pencil"></i>
												Ubah
											</a>
											<a class="btn red btn-outline" data-target="#delete_user_id_<?php echo $user_fetch_array['user_id']; ?>" data-toggle="modal">
												<i class="icon-trash"></i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="view_user_id_<?php echo $user_fetch_array['user_id']; ?>">
										<div class="modal-body">
											<div class="row">
												<div class="col-md-6">
													<label>
														Nama Akun
													</label>
													<input class="form-control" disabled type="text" value="<?php echo $user_fetch_array['user_username']; ?>">
												</div>
												<div class="col-md-6">
													<label>
														Kata Sandi
													</label>
													<input class="form-control" disabled type="text" value="<?php echo $user_fetch_array['user_original_password']; ?>">
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<button class="btn red btn-outline" data-dismiss="modal" type="button">
												<i class="icon-close"></i>
												Batal
											</button>
										</div>
									</div>
									<div class="modal fade" data-backdrop="static" id="delete_user_id_<?php echo $user_fetch_array['user_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=user&execute=delete-user&user_id=<?php echo $user_fetch_array['user_id']; ?>'" type="button">
												<i class="icon-check"></i>
												Simpan
											</button>
											<button class="btn red btn-outline" data-dismiss="modal" type="button">
												<i class="icon-close"></i>
												Batal
											</button>
										</div>
									</div>
							<?php
								$number++;
								}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	function add_user_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-user font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Pengguna
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=user&execute=add-user" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
								<h4 class="form-section">
									Informasi Pribadi
								</h4>
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
											<?php
												$user_category_query = mysql_query("SELECT user_category_id, user_category_name FROM user_category WHERE user_category_active = '1' ORDER BY user_category_name");
												while ($user_category_fetch_array = mysql_fetch_array($user_category_query))
												{
												    if($user_category_fetch_array['user_category_name'] == "Administrator")
												    {}else{
											?>
													<option value=""></option>
													<option value="<?php echo $user_category_fetch_array['user_category_id']; ?>"><?php echo $user_category_fetch_array['user_category_name']; ?></option>
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
												Nama
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="user_name" placeholder="Nama" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												No. Telpon
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="user_phone" placeholder="No. Telpon" type="text">
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
											<input autocomplete="off" class="form-control" name="user_email" placeholder="Email" type="text">
										</div>
									</div>
								</div>
								<h4 class="form-section">
									Informasi Akun
								</h4>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Nama Akun
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="user_username" placeholder="Nama Akun" type="text">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kata Sandi
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" id="user_password" name="user_password" placeholder="Kata Sandi" type="password">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Konfirmasi Kata Sandi
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="user_confirm_password" placeholder="Konfirmasi Kata Sandi" type="password">
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions right">
								<button class="btn blue btn-outline" type="submit">
									<i class="icon-check"></i>
									Simpan
								</button>
								&nbsp;
								<button class="btn red btn-outline" onclick="history.back()" type="button">
									<i class="icon-close"></i>
									Batal
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	function edit_user_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-user font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Pengguna
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=user&execute=edit-user" class="horizontal-form" id="form_sample_3" method="post">
						<?php
							$user_query = mysql_query("SELECT user_id, user_category_id, user_name, user_phone, user_email, user_username FROM user WHERE user_id = '".$_GET['user_id']."'");
							$user_fetch_array = mysql_fetch_array($user_query);
						?>
							<input class="form-control" name="user_id" type="hidden" value="<?php echo $user_fetch_array['user_id']; ?>">
							<div class="form-body">
								<h4 class="form-section">
									Informasi Pribadi
								</h4>
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
											<?php
												$user_category_query = mysql_query("SELECT user_category_id, user_category_name FROM user_category WHERE user_category_active = '1' ORDER BY user_category_name");
												while ($user_category_fetch_array = mysql_fetch_array($user_category_query))
												{
											?>
													<option value=""></option>
													<option <?php if ($user_category_fetch_array['user_category_id'] == $user_fetch_array['user_category_id']) { ?> selected="selected" <?php } ?> value="<?php echo $user_category_fetch_array['user_category_id']; ?>"><?php echo $user_category_fetch_array['user_category_name']; ?></option>
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
												Nama
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="user_name" placeholder="Nama" type="text" value="<?php echo $user_fetch_array['user_name']; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												No. Telpon
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="user_phone" placeholder="No. Telpon" type="text" value="<?php echo $user_fetch_array['user_phone']; ?>">
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
											<input autocomplete="off" class="form-control" name="user_email" placeholder="Email" type="text" value="<?php echo $user_fetch_array['user_email']; ?>">
										</div>
									</div>
								</div>
								<h4 class="form-section">
									Informasi Akun
								</h4>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Nama Akun
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="user_username" placeholder="Nama Akun" type="text" value="<?php echo $user_fetch_array['user_username']; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kata Sandi
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" id="user_new_password" name="user_new_password" placeholder="Kata Sandi" type="password">
											<span class="help-block font-red">
												Kosongkan Kata Sandi jika tidak ingin diganti
											</span>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Konfirmasi Kata Sandi
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="user_confirm_new_password" placeholder="Konfirmasi Kata Sandi" type="password">
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions right">
								<button class="btn blue btn-outline" type="submit">
									<i class="icon-check"></i>
									Simpan
								</button>
								&nbsp;
								<button class="btn red btn-outline" onclick="history.back()" type="button">
									<i class="icon-close"></i>
									Batal
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	function form_add_detail_user()
	{
		$maxID = mysql_fetch_array(mysql_query("SELECT MAX(reseller_id) as reseller_id FROM reseller"));
		$kode_reseller = mysql_fetch_array(mysql_query("SELECT * FROM reseller WHERE reseller_id = '".$maxID['reseller_id']."'"));
		
		$kode = substr($kode_reseller['reseller_code'],5,4);
		$kode_baru = $kode+1;
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-users font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Pengguna
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<div class="alert alert-info">
                            <strong>Identitas yang diisikan pada form berikut digunakan untuk ditampilkan di label pengiriman</strong>
                    	</div>
						<form action="?connect=user&execute=add-detail-user" class="horizontal-form" id="form_sample_3" method="post">
							<input type="hidden" name="user_id" value="<?php echo $_GET['user_id'] ?>" />
							<input type="hidden" name="kode_baru" value="Admin Penjualan" />
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>
												Barang
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#item_category_id" data-placeholder="Barang" name="item_category_id">
											<?php
												$item_category_query = mysql_query("SELECT * FROM item_category WHERE item_category_active = '1'");
												while ($item_category_fetch_array = mysql_fetch_array($item_category_query))
												{
											?>
													<option value=""></option>
													<option  value="<?php echo $item_category_fetch_array['item_category_id']; ?>"><?php echo $item_category_fetch_array['item_category_name']; ?></option>
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
												Nama
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="reseller_name" placeholder="Nama" type="text" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												No Telepon
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="reseller_phone" placeholder="No Telepon" type="text" required>
										</div>
									</div>
								</div>
								<hr/>
							</div>
							<div class="form-actions right">
								<button class="btn blue btn-outline" type="submit">
									<i class="icon-check"></i>
									Simpan
								</button>
								&nbsp;
								<button class="btn red btn-outline" onclick="history.back()" type="button">
									<i class="icon-close"></i>
									Batal
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
<?php
	}
?>