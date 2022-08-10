<?php
	function default_item_category_platform()
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
						<div class="actions">
							<div class="actions">
								<a class="btn blue btn-outline" href="?connect=item-category&execute=add-item-category-platform">
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
								$item_category_query = mysql_query("SELECT * FROM item_category WHERE item_category_active = '1'");
								while ($item_category_fetch_array = mysql_fetch_array($item_category_query))
								{
								    $label = mysql_fetch_array(mysql_query("SELECT * FROM label WHERE id_label = '".$item_category_fetch_array['id_label']."'"));
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
	function add_item_category_platform()
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
						<form action="?connect=item-category&execute=add-item-category" class="horizontal-form" id="form_sample_3" method="post">
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
											<input autocomplete="off" autofocus class="form-control" name="item_category_name" placeholder="Nama" type="text" required>
										</div>
									</div>
								</div>
								<?php
								    $label = mysql_query("SELECT * FROM label WHERE label_active = '1'");
								    while($data_label = mysql_fetch_array($label))
								    {
								?>
    								<div class="row">
    									<div class="col-md-12">
    										<div class="form-group">
    										    <input type="checkbox" class="checkboxes" value="<?php echo $data_label['id_label'] ?>" name="id_label"/>
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
	function edit_item_category_platform()
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
											<input autocomplete="off" autofocus class="form-control" name="item_category_name" placeholder="Nama" type="text" value="<?php echo $item_category_fetch_array['item_category_name']; ?>">
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
    										    <input type="checkbox" class="checkboxes" value="<?php echo $data_label['id_label'] ?>" name="id_label" checked/>
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