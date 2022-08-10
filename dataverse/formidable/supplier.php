<?php
	function default_supplier_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-social-dropbox font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Pemasok
							</span>
						</div>
						<div class="actions">
							<div class="actions">
								<a class="btn blue btn-outline" href="?connect=supplier&execute=add-supplier-platform">
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
								$supplier_query = mysql_query("SELECT supplier_id, supplier_name FROM supplier WHERE supplier_active = '1' ORDER BY supplier_id DESC");
								while ($supplier_fetch_array = mysql_fetch_array($supplier_query))
								{
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $supplier_fetch_array['supplier_name']; ?>
										</td>
										<td>
											<a class="btn purple btn-outline" href="?connect=supplier&execute=edit-supplier-platform&supplier_id=<?php echo $supplier_fetch_array['supplier_id']; ?>">
												<i class="icon-pencil"></i>
												Ubah
											</a>
											<a class="btn red btn-outline" data-target="#delete_supplier_id_<?php echo $supplier_fetch_array['supplier_id']; ?>" data-toggle="modal">
												<i class="icon-trash"></i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_supplier_id_<?php echo $supplier_fetch_array['supplier_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=supplier&execute=delete-supplier&supplier_id=<?php echo $supplier_fetch_array['supplier_id']; ?>'" type="button">
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
	function add_supplier_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-social-dropbox font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Pemasok
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=supplier&execute=add-supplier" class="horizontal-form" id="form_sample_3" method="post">
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
											<input autocomplete="off" autofocus class="form-control" name="supplier_name" placeholder="Nama" type="text">
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
	function edit_supplier_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-social-dropbox font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Pemasok
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=supplier&execute=edit-supplier" class="horizontal-form" id="form_sample_3" method="post">
						<?php
							$supplier_query = mysql_query("SELECT supplier_id, supplier_name FROM supplier WHERE supplier_id = '".$_GET['supplier_id']."'");
							$supplier_fetch_array = mysql_fetch_array($supplier_query);
						?>
							<input class="form-control" name="supplier_id" type="hidden" value="<?php echo $supplier_fetch_array['supplier_id']; ?>">
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
											<input autocomplete="off" autofocus class="form-control" name="supplier_name" placeholder="Nama" type="text" value="<?php echo $supplier_fetch_array['supplier_name']; ?>">
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