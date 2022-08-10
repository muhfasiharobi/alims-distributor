<?php
	function default_marketplace_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-social-dropbox font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Marketplace
							</span>
						</div>
						<div class="actions">
							<div class="actions">
								<a class="btn blue btn-outline" href="?connect=marketplace&execute=add-marketplace-platform">
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
								$order_via_query = mysql_query("SELECT * FROM order_via WHERE order_via_active = '1'");
								while ($order_via_fetch_array = mysql_fetch_array($order_via_query))
								{
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $order_via_fetch_array['order_via_name']; ?>
										</td>
										<td>
											<a class="btn purple btn-outline" href="?connect=marketplace&execute=edit-marketplace-platform&order_via_id=<?php echo $order_via_fetch_array['order_via_id']; ?>">
												<i class="icon-pencil"></i>
												Ubah
											</a>
											<a class="btn red btn-outline" data-target="#delete_marketplace_id_<?php echo $order_via_fetch_array['order_via_id']; ?>" data-toggle="modal">
												<i class="icon-trash"></i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_marketplace_id_<?php echo $order_via_fetch_array['order_via_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=marketplace&execute=delete-marketplace&order_via_id=<?php echo $order_via_fetch_array['order_via_id']; ?>'" type="button">
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
	function add_marketplace_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-social-dropbox font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Marketplace
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=marketplace&execute=add-marketplace" class="horizontal-form" id="form_sample_3" method="post">
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
											<input autocomplete="off" autofocus class="form-control" name="order_via_name" placeholder="Nama" type="text">
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
	function edit_marketplace_platform()
	{
		$order_via = mysql_fetch_array(mysql_query("SELECT * FROM order_via WHERE order_via_id = '".$_GET['order_via_id']."'"));
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-social-dropbox font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Jasa Pengiriman
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=marketplace&execute=edit-marketplace" class="horizontal-form" id="form_sample_3" method="post">
							<input type="hidden" name="order_via_id" value="<?php echo $order_via['order_via_id'] ?>">
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
											<input autocomplete="off" autofocus class="form-control" name="order_via_name" placeholder="Nama" type="text" value="<?php echo $order_via['order_via_name'] ?>">
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