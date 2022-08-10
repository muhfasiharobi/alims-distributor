<?php
	function default_paket_produk_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-notebook font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Paket Produk
							</span>
						</div>
						<div class="actions">
							<div class="actions">
								<a class="btn blue btn-outline" href="?connect=paket-produk&execute=add-paket-produk-platform">
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
									<th>
										Label
									</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$paket_produk_query = mysql_query("");
								while ($paket_produk_fetch_array = mysql_fetch_array($paket_produk_query))
								{
								    
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $item_category_fetch_array['item_category_name']; ?>
										</td>
										<td>
											<img src="../lib/<?php echo $label['gambar_label'] ?>" width="35%"/>
										</td>
										<td>
											<a class="btn purple btn-outline" href="?connect=item-category&execute=edit-item-category-platform&item_category_id=<?php echo $item_category_fetch_array['item_category_id']; ?>">
												<i class="icon-pencil"> </i>
												Ubah
											</a>
											<a class="btn red btn-outline" data-target="#delete_item_category_id_<?php echo $item_category_fetch_array['item_category_id']; ?>" data-toggle="modal">
												<i class="icon-trash"> </i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_item_category_id_<?php echo $item_category_fetch_array['item_category_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=item-category&execute=delete-item-category&item_category_id=<?php echo $item_category_fetch_array['item_category_id']; ?>'" type="button">
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
	function add_paket_produk_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-notebook font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Paket Produk
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=paket-produk&execute=add-paket-produk" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Nama Paket
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" autofocus class="form-control" name="nama_paket" placeholder="Nama Paket" type="text" required>
										</div>
									</div>
									<?php
										if($_SESSION['user_category_name'] == "Administrator")
										{
									?>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kategori Produk
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control" name="item_category_id" required>
												<?php
													$item_category = mysql_query("SELECT * FROM item_category WHERE item_category_active = '1'");
													while($data_item_category = mysql_fetch_array($item_category))
													{
												?>
													<option value="<?php echo $data_item_category['item_category_id'] ?>"><?php echo $data_item_category['item_category_name'] ?></option>
												<?php
													}
												?>
											</select>
										</div>
									</div>
									<?php
										}
									?>
								</div>
							</div>
							<div class="form-actions right">
								<button class="btn blue btn-outline" type="submit">
									<i class="icon-check"></i>
									Proses
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
	function add_item_paket_produk_platform()
	{
		$paket_produk = mysql_fetch_array(mysql_query("SELECT * FROM paket_produk WHERE paket_produk_id = '".$_GET['paket_produk_id']."'"));
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-layers font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Paket Produk
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=paket-produk&execute=add-item-paket-produk" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="id_paket_produk" type="hidden" value="<?php echo $_GET['id_paket_produk']; ?>">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Barang
											</label>
											<select class="form-control" name="item_id" id="item_id">
												<?php
												if($_SESSION['user_category_name'] == "Administrator")
												{
													$item = mysql_query("SELECT * FROM item WHERE item_active = '1'");
												}
												else
												{
													$item = mysql_query("SELECT * FROM reseller_item_sell a, reseller b, user c, item d WHERE a.reseller_id = b.reseller_id AND b.user_id = c.user_id AND c.user_id = '".$_SESSION['user_id']."' AND a.item_id = d.item_id AND a.reseller_item_sell_active = '1' AND d.item_active = '1'");
												}
													
													while($data_item = mysql_fetch_array($item))
													{
												?>
														<option value="<?php echo $data_item['item_id'] ?>"><?php echo $data_item['item_name'] ?></option>
												<?php
													}
												?>
											</select>
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
											<input autocomplete="off" class="form-control" name="jumlah" placeholder="Jumlah" type="text">
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions right">
								<button class="btn blue btn-outline" type="submit">
									<i class="icon-check"></i>
									Tambah
								</button>
								&nbsp;
								<button class="btn green btn-outline" onclick="location.href='?connect=reseller-item-sell'" type="button">
									<i class="icon-logout"></i>
									Selesai
								</button>
							</div>
						</form>
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
										Produk
									</th>
									<th>
										Jumlah
									</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$paket_produk_detail_query = mysql_query("SELECT * FROM paket_produk_detail a, item b WHERE a.item_id = b.item_id AND a.id_paket_produk = '".$_GET['id_paket_produk']."'");
								while ($paket_produk_detail_fetch_array = mysql_fetch_array($paket_produk_detail_query))
								{
									
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $paket_produk_detail_fetch_array['item_name']; ?>
										</td>
										<td>
											<?php echo $paket_produk_detail_fetch_array['item_quantity']; ?>
										</td>
										<td>
											<a class="btn red btn-outline" href="?connect=paket-produk&execute=hapus-paket-produk-detail&id_paket_produk_detail=<?php echo $paket_produk_detail_fetch_array['id_paket_produk_detail']; ?>">
												<i class="icon-trash"></i>
													Hapus
											</a>
										</td>
									</tr>
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
	function edit_paket_produk_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-notebook font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Kategori Barang
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=item-category&execute=edit-item-category" class="horizontal-form" id="form_sample_3" method="post">
						<?php
							$item_category_query = mysql_query("SELECT item_category_id, item_category_name, id_label FROM item_category WHERE item_category_id = '".$_GET['item_category_id']."'");
							$item_category_fetch_array = mysql_fetch_array($item_category_query);
						?>
							<input class="form-control" name="item_category_id" type="hidden" value="<?php echo $item_category_fetch_array['item_category_id']; ?>">
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
											<input autocomplete="off" autofocus class="form-control" name="item_category_name" placeholder="Nama" type="text" value="<?php echo $item_category_fetch_array['item_category_name']; ?>" required>
										</div>
									</div>
								</div>
								<?php
								    $label = mysql_query("SELECT * FROM label WHERE label_active = '1'");
								    while($data_label = mysql_fetch_array($label))
								    {
								        if($data_label['id_label'] == $item_category_fetch_array['id_label'])
								        {
								?>
    								<div class="row">
    									<div class="col-md-12">
    										<div class="form-group">
    										    <input type="checkbox" class="checkboxes" value="<?php echo $data_label['id_label'] ?>" name="id_label" checked />
    											<label>
    												<?php echo $data_label['nama_label'] ?>
    												<span class="required">
    													*
    												</span>
    											</label>
    											
    											<img src="../lib/<?php echo $data_label['gambar_label'] ?>" width="35%"/>
    										</div>
    									</div>
    								</div>
    							<?php
								        }
								        else
								        {
    							?>
    							    <div class="row">
    									<div class="col-md-12">
    										<div class="form-group">
    										    <input type="checkbox" class="checkboxes" value="<?php echo $data_label['id_label'] ?>" name="id_label" />
    											<label>
    												<?php echo $data_label['nama_label'] ?>
    												<span class="required">
    													*
    												</span>
    											</label>
    											
    											<img src="../lib/<?php echo $data_label['gambar_label'] ?>" width="35%"/>
    										</div>
    									</div>
    								</div>
    							<?php
								        }
								    }
    							?>
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