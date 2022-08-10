<?php
	function default_reseller_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-users font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Agen
							</span>
						</div>
						<div class="actions">
							<div class="actions">
								<a class="btn blue btn-outline" href="?connect=reseller&execute=add-reseller-platform">
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
										No. Telepon
									</th>
									<th>
										Rekening
									</th>
									<th>
										Username
									</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								if($_SESSION['user_category_name'] == "Administrator")
								{
									$reseller_query = mysql_query("SELECT * FROM reseller WHERE reseller_active = '1' ORDER BY reseller_id DESC");
								}
								else
								{
									$reseller_query = mysql_query("SELECT * FROM reseller a, user b WHERE a.reseller_active = '1' AND a.user_id = b.user_id AND b.item_category_id = '".$_SESSION['item_category_id']."' ORDER BY a.reseller_id DESC");
								}
								
								while ($reseller_fetch_array = mysql_fetch_array($reseller_query))
								{
									
									if($reseller_fetch_array['reseller_code'] == "Admin Penjualan")
									{
									}
									else
									{

										$user = mysql_fetch_array(mysql_query("SELECT * FROM user WHERE user_id = '".$reseller_fetch_array['user_id']."'"));
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $reseller_fetch_array['reseller_code']; ?>
										</td>
										<td>
											<?php echo $reseller_fetch_array['reseller_name']; ?>
										</td>
										<td>
											<?php echo $reseller_fetch_array['reseller_address']; ?>, Kel. <?php echo $reseller_fetch_array['reseller_village']; ?>, Kec. <?php echo $reseller_fetch_array['reseller_districts']; ?>, <?php echo $reseller_fetch_array['reseller_city']; ?>
										</td>
										<td>
											<?php echo $reseller_fetch_array['reseller_phone']; ?>
										</td>
										<td>
											<?php echo $reseller_fetch_array['reseller_account_bank']; ?> </br> <?php echo $reseller_fetch_array['reseller_account_number']; ?> / <?php echo $reseller_fetch_array['reseller_account_name']; ?>
										</td>
										<td>
											<?php echo $user['user_username']; ?>
										</td>
										<td>
											<a class="btn purple btn-outline" href="?connect=reseller&execute=edit-reseller-platform&reseller_id=<?php echo $reseller_fetch_array['reseller_id']; ?>">
												<i class="icon-pencil"></i>
												Ubah
											</a>
											<a class="btn red btn-outline" data-target="#delete_reseller_id_<?php echo $reseller_fetch_array['reseller_id']; ?>" data-toggle="modal">
												<i class="icon-trash"></i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_reseller_id_<?php echo $reseller_fetch_array['reseller_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=reseller&execute=delete-reseller&reseller_id=<?php echo $reseller_fetch_array['reseller_id']; ?>'" type="button">
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
	function add_reseller_platform()
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
								Agen
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=reseller&execute=add-reseller" class="horizontal-form" id="form_sample_3" method="post">
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
											<input autocomplete="off" autofocus class="form-control" name="reseller_code" placeholder="Kode" type="text" value="AGT-0<?php echo $kode_baru ?>" required>
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
											<input autocomplete="off" class="form-control" name="reseller_name" placeholder="Nama" type="text" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Alamat
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="reseller_address" placeholder="Alamat" type="text" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kelurahan
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="reseller_village" placeholder="Kelurahan" type="text" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kecamatan
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="reseller_districts" placeholder="Kecamatan" type="text" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kota
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="reseller_city" placeholder="Kota" type="text" required>
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
											<input autocomplete="off" class="form-control" name="reseller_email" placeholder="Email" type="text" required>
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
											<input autocomplete="off" class="form-control" name="reseller_phone" placeholder="No. Telpon" type="text" required>
										</div>
									</div>
								</div>
								<hr/>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Bank Rekening
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#bank_id" data-placeholder="Bank Rekening" name="bank_id" required>
												<option value=""></option>
											<?php
												$bank = mysql_query("SELECT * FROM bank WHERE bank_active = '1'");
												while($data_bank = mysql_fetch_array($bank))
												{
											?>
													<option value="<?php echo $data_bank['bank_id'] ?>"><?php echo $data_bank['bank_name'] ?></option>
											<?php
												}
											?>
											</select>
											<div id="bank_id"></div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												No. Rekening
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="reseller_account_number" placeholder="No. Rekening" type="text" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Nama Rekening
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="reseller_account_name" placeholder="Nama Rekening" type="text" required>
										</div>
									</div>
								</div>
								<hr/>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Username
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="reseller_username" placeholder="Username" type="text" value="AGT-0<?php echo $kode_baru ?>" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Password
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="reseller_password" placeholder="Password" type="text" required>
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
	function edit_reseller_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-users font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Agen
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=reseller&execute=edit-reseller" class="horizontal-form" id="form_sample_3" method="post">
						<?php
							$reseller_query = mysql_query("SELECT * FROM reseller WHERE reseller_id = '".$_GET['reseller_id']."'");
							$reseller_fetch_array = mysql_fetch_array($reseller_query);
							
							$user = mysql_fetch_array(mysql_query("SELECT * FROM user WHERE user_id = '".$reseller_fetch_array['user_id']."'"));
						?>
							<input class="form-control" name="reseller_id" type="hidden" value="<?php echo $reseller_fetch_array['reseller_id']; ?>">
							<input class="form-control" name="user_id" type="hidden" value="<?php echo $reseller_fetch_array['user_id']; ?>">
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
											<input autocomplete="off" autofocus class="form-control" name="reseller_code" placeholder="Kode" type="text" value="<?php echo $reseller_fetch_array['reseller_code']; ?>">
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
											<input autocomplete="off" class="form-control" name="reseller_name" placeholder="Nama" type="text" value="<?php echo $reseller_fetch_array['reseller_name']; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Alamat
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="reseller_address" placeholder="Alamat" type="text" value="<?php echo $reseller_fetch_array['reseller_address']; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kelurahan
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="reseller_village" placeholder="Kelurahan" type="text" value="<?php echo $reseller_fetch_array['reseller_village']; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kecamatan
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="reseller_districts" placeholder="Kecamatan" type="text" value="<?php echo $reseller_fetch_array['reseller_districts']; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kota
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="reseller_city" placeholder="Kota" type="text" value="<?php echo $reseller_fetch_array['reseller_city']; ?>">
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
											<input autocomplete="off" class="form-control" name="reseller_email" placeholder="Email" type="text" value="<?php echo $user['user_email'] ?>">
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
											<input autocomplete="off" class="form-control" name="reseller_phone" placeholder="No. Telpon" type="text" value="<?php echo $reseller_fetch_array['reseller_phone']; ?>">
										</div>
									</div>
								</div>
								<hr/>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Bank Rekening
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#bank_id" data-placeholder="Bank Rekening" name="bank_id">
												<option value=""></option>
											<?php
												$bank = mysql_query("SELECT * FROM bank WHERE bank_active = '1'");
												while($data_bank = mysql_fetch_array($bank))
												{
													if($data_bank['bank_id'] == $reseller_fetch_array['bank_id'])
													{
											?>
													<option value="<?php echo $data_bank['bank_id'] ?>" selected><?php echo $data_bank['bank_name'] ?></option>
											<?php
													}
													else
													{
											?>
													<option value="<?php echo $data_bank['bank_id'] ?>"><?php echo $data_bank['bank_name'] ?></option>
											<?php
													}
												}
											?>
											</select>
											<div id="reseller_account_bank"></div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												No. Rekening
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="reseller_account_number" placeholder="No. Rekening" type="text" value="<?php echo $reseller_fetch_array['reseller_account_number']; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Nama Rekening
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="reseller_account_name" placeholder="Nama Rekening" type="text" value="<?php echo $reseller_fetch_array['reseller_account_name']; ?>">
										</div>
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Username
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="reseller_username" placeholder="Username" type="text" value="<?php echo $user['user_username'] ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Password
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="reseller_password" placeholder="Password" type="text" value="<?php echo $user['user_original_password'] ?>">
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