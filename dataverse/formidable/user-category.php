<?php
	function default_user_category_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-users font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Kategori Pengguna
							</span>
						</div>
						<div class="actions">
							<div class="actions">
								<a class="btn blue btn-outline" href="?connect=user-category&execute=add-user-category-platform">
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
										Nama
									</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$user_category_query = mysql_query("SELECT user_category_id, user_category_name FROM user_category WHERE user_category_active = '1' ORDER BY user_category_id DESC");
								while ($user_category_fetch_array = mysql_fetch_array($user_category_query))
								{
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $user_category_fetch_array['user_category_name']; ?>
										</td>
										<td>
											<a class="btn purple btn-outline" href="?connect=user-category&execute=edit-user-category-platform&user_category_id=<?php echo $user_category_fetch_array['user_category_id']; ?>">
												<i class="icon-pencil"></i>
												Ubah
											</a>
											<a class="btn red btn-outline" data-target="#delete_user_category_id_<?php echo $user_category_fetch_array['user_category_id']; ?>" data-toggle="modal">
												<i class="icon-trash"></i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_user_category_id_<?php echo $user_category_fetch_array['user_category_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=user-category&execute=delete-user-category&user_category_id=<?php echo $user_category_fetch_array['user_category_id']; ?>'" type="button">
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
	function add_user_category_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-users font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Kategori Pengguna
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=user-category&execute=add-user-category" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>
												Nama
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" autofocus class="form-control" name="user_category_name" placeholder="Nama" type="text">
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
	function edit_user_category_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-users font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Kategori Pengguna
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=user-category&execute=edit-user-category" class="horizontal-form" id="form_sample_3" method="post">
						<?php
							$user_category_query = mysql_query("SELECT user_category_id, user_category_name FROM user_category WHERE user_category_id = '".$_GET['user_category_id']."'");
							$user_category_fetch_array = mysql_fetch_array($user_category_query);
						?>
							<input class="form-control" name="user_category_id" type="hidden" value="<?php echo $user_category_fetch_array['user_category_id']; ?>">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>
												Nama
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" autofocus class="form-control" name="user_category_name" placeholder="Nama" type="text" value="<?php echo $user_category_fetch_array['user_category_name']; ?>">
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
?>