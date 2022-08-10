<?php
	function default_delivery_service_platform()
	{
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
						<div class="actions">
							<div class="actions">
								<a class="btn blue btn-outline" href="?connect=delivery-service&execute=add-delivery-service-platform">
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
								$delivery_service_query = mysql_query("SELECT * FROM delivery_service WHERE delivery_service_active = '1'");
								while ($delivery_service_fetch_array = mysql_fetch_array($delivery_service_query))
								{
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $delivery_service_fetch_array['delivery_service_name']; ?>
										</td>
										<td>
											<a class="btn purple btn-outline" href="?connect=delivery-service&execute=edit-delivery-service-platform&delivery_service_id=<?php echo $delivery_service_fetch_array['delivery_service_id']; ?>">
												<i class="icon-pencil"></i>
												Ubah
											</a>
											<a class="btn red btn-outline" data-target="#delete_delivery_service_id_<?php echo $delivery_service_fetch_array['delivery_service_id']; ?>" data-toggle="modal">
												<i class="icon-trash"></i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_delivery_service_id_<?php echo $delivery_service_fetch_array['delivery_service_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=delivery-service&execute=delete-delivery-service&delivery_service_id=<?php echo $delivery_service_fetch_array['delivery_service_id']; ?>'" type="button">
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
	function add_delivery_service_platform()
	{
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
						<form action="?connect=delivery-service&execute=add-delivery-service" class="horizontal-form" id="form_sample_3" method="post">
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
											<input autocomplete="off" autofocus class="form-control" name="delivery_service_name" placeholder="Nama" type="text">
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
	function edit_delivery_service_platform()
	{
		$delivery_service = mysql_fetch_array(mysql_query("SELECT * FROM delivery_service WHERE delivery_service_id = '".$_GET['delivery_service_id']."'"));
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
						<form action="?connect=delivery-service&execute=edit-delivery-service" class="horizontal-form" id="form_sample_3" method="post">
							<input type="hidden" name="delivery_service_id" value="<?php echo $delivery_service['delivery_service_id'] ?>">
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
											<input autocomplete="off" autofocus class="form-control" name="delivery_service_name" placeholder="Nama" type="text" value="<?php echo $delivery_service['delivery_service_name'] ?>">
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