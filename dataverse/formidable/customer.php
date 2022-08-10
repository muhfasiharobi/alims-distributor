<?php
	function default_customer_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-user font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Pelanggan
							</span>
						</div>
						<div class="actions">
							<div class="actions">
								<a class="btn blue btn-outline" href="?connect=customer&execute=add-customer-platform">
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
										Kode
									</th>
									<th>
										Nama
									</th>
									<th>
										Alamat
									</th>
									<th>
										No Telepon
									</th>
									<th>
										Agen
									</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
					<?php
						if($_SESSION['user_category_name'] == "Agen")
						{
					?>
							<?php
								$number = 1;
								$customer_query = mysql_query("SELECT * FROM customer a, reseller b WHERE a.reseller_id = b.reseller_id AND a.customer_active = '1' AND b.user_id = '".$_SESSION['user_id']."' ORDER BY a.customer_id DESC");
								while ($customer_fetch_array = mysql_fetch_array($customer_query))
								{
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $customer_fetch_array['customer_code']; ?>
										</td>
										<td>
											<?php echo $customer_fetch_array['customer_name']; ?>
										</td>
										<td>
											<?php echo $customer_fetch_array['customer_address']; ?>, <?php echo $customer_fetch_array['customer_village']; ?> - <?php echo $customer_fetch_array['customer_districts']; ?> - <?php echo $customer_fetch_array['customer_city']; ?>
										</td>
										<td>
											<?php echo $customer_fetch_array['customer_phone']; ?>
										</td>
										
											<td>
												 <?php echo $customer_fetch_array['reseller_code']; ?> / <?php echo $customer_fetch_array['reseller_name']; ?>
											</td>
										<td>
											<a class="btn purple btn-outline" href="?connect=customer&execute=edit-customer-platform&customer_id=<?php echo $customer_fetch_array['customer_id']; ?>">
												<i class="icon-pencil"></i>
												Ubah
											</a>
											<a class="btn red btn-outline" data-target="#delete_customer_id_<?php echo $customer_fetch_array['customer_id']; ?>" data-toggle="modal">
												<i class="icon-trash"></i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_customer_id_<?php echo $customer_fetch_array['customer_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=customer&execute=delete-customer&customer_id=<?php echo $customer_fetch_array['customer_id']; ?>'" type="button">
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
							
					<?php
						}
						else
						{
					?>
					
					        <?php
								$number = 1;

								if($_SESSION['user_category_name'] == "Administrator")
								{
									$customer_query = mysql_query("SELECT * FROM customer a, reseller b, user c WHERE a.reseller_id = b.reseller_id AND b.user_id = c.user_id AND a.customer_active = '1' ORDER BY a.customer_id DESC");
								}
								else
								{
									$customer_query = mysql_query("SELECT * FROM customer a, reseller b, user c WHERE a.reseller_id = b.reseller_id AND b.user_id = c.user_id AND c.item_category_id = '".$_SESSION['item_category_id']."' AND a.customer_active = '1' ORDER BY a.customer_id DESC");
								}


								while ($customer_fetch_array = mysql_fetch_array($customer_query))
								{
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $customer_fetch_array['customer_code']; ?>
										</td>
										<td>
											<?php echo $customer_fetch_array['customer_name']; ?>
										</td>
										<td>
											<?php echo $customer_fetch_array['customer_address']; ?>, <?php echo $customer_fetch_array['customer_village']; ?> - <?php echo $customer_fetch_array['customer_districts']; ?> - <?php echo $customer_fetch_array['customer_city']; ?>
										</td>
										<td>
											<?php echo $customer_fetch_array['customer_phone']; ?>
										</td>
										
											<td>
												 <?php echo $customer_fetch_array['reseller_code']; ?> / <?php echo $customer_fetch_array['reseller_name']; ?>
											</td>
										<td>
											<a class="btn purple btn-outline" href="?connect=customer&execute=edit-customer-platform&customer_id=<?php echo $customer_fetch_array['customer_id']; ?>">
												<i class="icon-pencil"></i>
												Ubah
											</a>
											<a class="btn red btn-outline" data-target="#delete_customer_id_<?php echo $customer_fetch_array['customer_id']; ?>" data-toggle="modal">
												<i class="icon-trash"></i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_customer_id_<?php echo $customer_fetch_array['customer_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=customer&execute=delete-customer&customer_id=<?php echo $customer_fetch_array['customer_id']; ?>'" type="button">
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
							
					<?php
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
	function add_customer_platform()
	{
		$maxID = mysql_fetch_array(mysql_query("SELECT MAX(customer_id) as customer_id FROM customer"));
		$customer_code = mysql_fetch_array(mysql_query("SELECT * FROM customer WHERE customer_id = '".$maxID['customer_id']."'"));
		
		$code = substr($customer_code['customer_code'],3,4);
		$new_code = $code+1;
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-user font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Pelanggan
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=customer&execute=add-customer" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kode
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="customer_code" placeholder="Kode" type="text" value="C00<?php echo $new_code ?>">
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
											<input autocomplete="off" class="form-control" name="customer_name" placeholder="Nama" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Alamat
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="customer_address" placeholder="Alamat" type="text">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kelurahan
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="customer_village" placeholder="Kelurahan" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kecamatan
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="customer_districts" placeholder="Kecamatan" type="text">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kota
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="customer_city" placeholder="Kota" type="text">
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
											<input autocomplete="off" class="form-control" name="customer_phone" placeholder="No. Telpon" type="text">
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
	function edit_customer_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-user font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Pelanggan
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=customer&execute=edit-customer" class="horizontal-form" id="form_sample_3" method="post">
						<?php
							$customer_query = mysql_query("SELECT * FROM customer WHERE customer_id = '".$_GET['customer_id']."'");
							$customer_fetch_array = mysql_fetch_array($customer_query);
						?>
							<input class="form-control" name="customer_id" type="hidden" value="<?php echo $customer_fetch_array['customer_id']; ?>">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Nama
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="customer_name" placeholder="Nama" type="text" value="<?php echo $customer_fetch_array['customer_name'] ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Alamat
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="customer_address" placeholder="Alamat" type="text" value="<?php echo $customer_fetch_array['customer_address'] ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kelurahan
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="customer_village" placeholder="Kelurahan" type="text" value="<?php echo $customer_fetch_array['customer_village'] ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kecamatan
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="customer_districts" placeholder="Kecamatan" type="text" value="<?php echo $customer_fetch_array['customer_districts'] ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kota
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="customer_city" placeholder="Kota" type="text" value="<?php echo $customer_fetch_array['customer_city'] ?>">
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
											<input autocomplete="off" class="form-control" name="customer_phone" placeholder="No. Telpon" type="text" value="<?php echo $customer_fetch_array['customer_phone'] ?>">
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