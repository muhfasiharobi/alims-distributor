<?php
	function default_barang_keluar_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-bag font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Free Produk
							</span>
						</div>
						<div class="actions">
							<div class="actions">
								<a class="btn blue btn-outline" href="?connect=barang-keluar&execute=add-barang-keluar-platform">
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
										Tanggal
									</th>
									<th>
										Nama Barang
									</th>
									<th>
										Jumlah 
									</th>
									<th>
										Keterangan
									</th>
									<th>
									</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								if($_SESSION['user_category_name'] == "Administrator")
								{
									$barang_keluar_query = mysql_query("SELECT * FROM barang_keluar a, item b WHERE a.item_id = b.item_id AND a.barang_keluar_active = '1'");
								}
								else
								{
									$barang_keluar_query = mysql_query("SELECT * FROM barang_keluar a, item b WHERE a.item_id = b.item_id AND a.barang_keluar_active = '1' AND b.item_category_id = '".$_SESSION['item_category_id']."'");
								}
								
								while ($barang_keluar_fetch_array = mysql_fetch_array($barang_keluar_query))
								{
									
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo indonesia_date_format($barang_keluar_fetch_array['barang_keluar_date']); ?>
										</td>
										<td>
											<?php echo $barang_keluar_fetch_array['item_name']; ?>
										</td>
										<td>
											<?php echo $barang_keluar_fetch_array['barang_keluar_quantity']; ?>
										</td>
										<td>
											<?php echo $barang_keluar_fetch_array['barang_keluar_description']; ?>
										</td>
										<td>
											<a class="btn purple btn-outline" href="?connect=barang-keluar&execute=edit-barang-keluar-platform&barang_keluar_id=<?php echo $barang_keluar_fetch_array['barang_keluar_id']; ?>">
												<i class="icon-pencil"></i>
												Ubah
											</a>
											<a class="btn red btn-outline" data-target="#delete_barang_keluar_id_<?php echo $barang_keluar_fetch_array['barang_keluar_id']; ?>" data-toggle="modal">
												<i class="icon-trash"></i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_barang_keluar_id_<?php echo $barang_keluar_fetch_array['barang_keluar_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=barang-keluar&execute=delete-barang-keluar&barang_keluar_id=<?php echo $barang_keluar_fetch_array['barang_keluar_id']; ?>'" type="button">
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
	function add_barang_keluar_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-bag font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Free Produk
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=barang-keluar&execute=add-barang-keluar" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Barang
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#item_id" data-placeholder="Barang" name="item_id">
											<?php
											if($_SESSION['user_category_name'] == "Administrator")
											{
												$item_query = mysql_query("SELECT * FROM item WHERE item_active = '1' ORDER BY item_name");
											}
											else
											{
												$item_query = mysql_query("SELECT * FROM item WHERE item_active = '1' AND item_category_id = '".$_SESSION['item_category_id']."' ORDER BY item_name");
											}
												
												while ($item_fetch_array = mysql_fetch_array($item_query))
												{
											?>
													<option value=""></option>
													<option value="<?php echo $item_fetch_array['item_id']; ?>"><?php echo $item_fetch_array['item_name']; ?></option>
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
												Jumlah
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="barang_keluar_quantity" placeholder="Jumlah" type="text">
										</div>
									</div>
								</div>
								<div class="row">
								    <div class="col-md-6">
										<div class="form-group">
											<label>
												Tanggal
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="barang_keluar_date" placeholder="Tanggal" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Keterangan
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="barang_keluar_description" placeholder="Keterangan" type="text">
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
	function edit_barang_keluar_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-bag font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Free Produk
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=barang-keluar&execute=edit-barang-keluar" class="horizontal-form" id="form_sample_3" method="post">
						<?php
							$barang_keluar_query = mysql_query("SELECT * FROM barang_keluar WHERE barang_keluar_id = '".$_GET['barang_keluar_id']."'");
							$barang_keluar_fetch_array = mysql_fetch_array($barang_keluar_query);
						?>
							<input class="form-control" name="barang_keluar_id" type="hidden" value="<?php echo $barang_keluar_fetch_array['barang_keluar_id']; ?>">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Barang
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#item_id" data-placeholder="Barang" name="item_id">
											<?php
											if($_SESSION['user_category_name'] == "Administrator")
											{
												$item_query = mysql_query("SELECT * FROM item WHERE item_active = '1' ORDER BY item_name");
											}
											else
											{
												$item_query = mysql_query("SELECT * FROM item WHERE item_active = '1' AND item_category_id = '".$_SESSION['item_category_id']."' ORDER BY item_name");
											}
												while ($item_fetch_array = mysql_fetch_array($item_query))
												{
													if($item_fetch_array['item_id'] == $barang_keluar_fetch_array['item_id'])
													{
											?>
												
													<option value="<?php echo $item_fetch_array['item_id']; ?>" selected><?php echo $item_fetch_array['item_name']; ?></option>
											<?php
													}
													else
													{
											?>
													<option value="<?php echo $item_fetch_array['item_id']; ?>"><?php echo $item_fetch_array['item_name']; ?></option>
											<?php
													}
												}
											?>
											</select>
											<div id="item_category_id"></div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Jumlah
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="barang_keluar_quantity" placeholder="Jumlah" type="text" value="<?php echo $barang_keluar_fetch_array['barang_keluar_quantity'] ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Keterangan
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="barang_keluar_description" placeholder="Keterangan" type="text" value="<?php echo $barang_keluar_fetch_array['barang_keluar_description'] ?>">
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