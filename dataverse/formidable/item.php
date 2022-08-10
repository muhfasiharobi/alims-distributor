<?php
	function default_item_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-bag font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Barang
							</span>
						</div>
						<div class="actions">
							<div class="actions">
								<a class="btn blue btn-outline" href="?connect=item&execute=add-item-platform">
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
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$item_query = mysql_query("SELECT a.item_id, a.item_name, b.item_category_name FROM item a, item_category b WHERE a.item_category_id = b.item_category_id AND a.item_active = '1' AND b.item_category_active = '1' ORDER BY a.item_id DESC");
								while ($item_fetch_array = mysql_fetch_array($item_query))
								{
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $item_fetch_array['item_category_name']; ?>
										</td>
										<td>
											<?php echo $item_fetch_array['item_name']; ?>
										</td>
										<td>
											<a class="btn purple btn-outline" href="?connect=item&execute=edit-item-platform&item_id=<?php echo $item_fetch_array['item_id']; ?>">
												<i class="icon-pencil"></i>
												Ubah
											</a>
											<a class="btn red btn-outline" data-target="#delete_item_id_<?php echo $item_fetch_array['item_id']; ?>" data-toggle="modal">
												<i class="icon-trash"></i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_item_id_<?php echo $item_fetch_array['item_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=item&execute=delete-item&item_id=<?php echo $item_fetch_array['item_id']; ?>'" type="button">
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
	function add_item_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-bag font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Barang
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=item&execute=add-item" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kategori
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#item_category_id" data-placeholder="Kategori" name="item_category_id" required>
											<?php
												$item_category_query = mysql_query("SELECT item_category_id, item_category_name FROM item_category WHERE item_category_active = '1' ORDER BY item_category_name");
												while ($item_category_fetch_array = mysql_fetch_array($item_category_query))
												{
											?>
													<option value=""></option>
													<option value="<?php echo $item_category_fetch_array['item_category_id']; ?>"><?php echo $item_category_fetch_array['item_category_name']; ?></option>
											<?php
												}
											?>
											</select>
											<div id="item_category_id"></div>
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
											<input autocomplete="off" class="form-control" name="item_name" placeholder="Nama" type="text" required>
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
	function edit_item_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-bag font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Barang
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=item&execute=edit-item" class="horizontal-form" id="form_sample_3" method="post">
						<?php
							$item_query = mysql_query("SELECT item_id, item_category_id, item_name FROM item WHERE item_id = '".$_GET['item_id']."'");
							$item_fetch_array = mysql_fetch_array($item_query);
						?>
							<input class="form-control" name="item_id" type="hidden" value="<?php echo $item_fetch_array['item_id']; ?>">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kategori
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#item_category_id" data-placeholder="Kategori" name="item_category_id">
											<?php
												$item_category_query = mysql_query("SELECT item_category_id, item_category_name FROM item_category WHERE item_category_active = '1' ORDER BY item_category_name");
												while ($item_category_fetch_array = mysql_fetch_array($item_category_query))
												{
											?>
													<option value=""></option>
													<option <?php if ($item_category_fetch_array['item_category_id'] == $item_fetch_array['item_category_id']) { ?> selected="selected" <?php } ?> value="<?php echo $item_category_fetch_array['item_category_id']; ?>"><?php echo $item_category_fetch_array['item_category_name']; ?></option>
											<?php
												}
											?>
											</select>
											<div id="item_category_id"></div>
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
											<input autocomplete="off" class="form-control" name="item_name" placeholder="Nama" type="text" value="<?php echo $item_fetch_array['item_name']; ?>">
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