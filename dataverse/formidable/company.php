<?php
	function default_company_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-home font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Perusahaan
							</span>
						</div>
						<?php
							$company = mysql_num_rows(mysql_query("SELECT * FROM company WHERE company_active = '1'"));
							if($company > 0)
							{}
							else
							{
						?>
							<div class="actions">
								<div class="actions">
									<a class="btn blue btn-outline" href="?connect=company&execute=add-company-platform">
										<i class="icon-note"></i>
										Tambah
									</a>
								</div>
							</div>
						<?php
							}
						?>
					</div>
					<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover order-column" id="sample_1">
							<thead>
								<tr>
									<th>
										No
									</th>
									<th>
										Nama Perusahaan
									</th>
									<th>
										Alamat
									</th>
									<th>
										No. Telpon
									</th>
									<th>
										Email
									</th>
									<th>
										Rekening Bank
									</th>
									<th>
										Logo
									</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$company_query = mysql_query("SELECT * FROM company WHERE company_active = '1'");
								while ($company_fetch_array = mysql_fetch_array($company_query))
								{
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $company_fetch_array['company_name']; ?>
										</td>
										<td>
											<?php echo $company_fetch_array['company_address']; ?>, Kel. <?php echo $company_fetch_array['company_village']; ?>, Kec. <?php echo $company_fetch_array['company_districts']; ?>, <?php echo $company_fetch_array['company_city']; ?>
										</td>
										<td>
											<?php echo $company_fetch_array['company_phone']; ?>
										</td>
										<td>
											<?php echo $company_fetch_array['company_email']; ?>
										</td>
										<td>
											<?php echo $company_fetch_array['company_account_bank']; ?> - <?php echo $company_fetch_array['company_account_number']; ?> Atas Nama <?php echo $company_fetch_array['company_account_name']; ?>
										</td>
										<td>
										    <img src="../assets/global/img/<?php echo $company_fetch_array['company_logo'] ?>" width="50px"/>
										</td>
										<td>
											<a class="btn purple btn-outline" href="?connect=company&execute=edit-company-platform&company_id=<?php echo $company_fetch_array['company_id']; ?>">
												<i class="icon-pencil"></i>
												Ubah
											</a>
											<a class="btn red btn-outline" data-target="#delete_company_id_<?php echo $company_fetch_array['company_id']; ?>" data-toggle="modal">
												<i class="icon-trash"></i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_company_id_<?php echo $company_fetch_array['company_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=company&execute=delete-company&company_id=<?php echo $company_fetch_array['company_id']; ?>'" type="button">
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
	function add_company_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-home font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Agen
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=company&execute=add-company" class="horizontal-form" id="form_sample_3" method="post" enctype="multipart/form-data">
							<div class="form-body">
							    <div class="row">
							        <div class="col-md-6">
							            <div class="form-group ">
                                                    <label class="control-label col-md-3">Logo</label>
                                                    <div class="col-md-9">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"> </div>
                                                            <div>
                                                                <span class="btn red btn-outline btn-file">
                                                                    <span class="fileinput-new"> Select image </span>
                                                                    <span class="fileinput-exists"> Change </span>
                                                                    <input type="file" name="logo"> </span>
                                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix margin-top-10">
                                                             </div>
                                                    </div>
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
											<input autocomplete="off" class="form-control" name="company_name" placeholder="Nama" type="text">
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
											<input autocomplete="off" class="form-control" name="company_address" placeholder="Alamat" type="text">
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
											<input autocomplete="off" class="form-control" name="company_village" placeholder="Kelurahan" type="text">
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
											<input autocomplete="off" class="form-control" name="company_districts" placeholder="Kecamatan" type="text">
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
											<input autocomplete="off" class="form-control" name="company_city" placeholder="Kota" type="text">
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
											<input autocomplete="off" class="form-control" name="company_phone" placeholder="No. Telpon" type="text">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>
												Email
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="company_email" placeholder="Email" type="text">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Bank Rekening
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#company_account_bank" data-placeholder="Bank Rekening" name="company_account_bank">
												<option value=""></option>
												<option value="Bank Jatim">Bank Jatim</option>
												<option value="BCA">BCA</option>
												<option value="BNI">BNI</option>
												<option value="BRI">BRI</option>
												<option value="BNI Syariah">BNI Syariah</option>
											</select>
											<div id="company_account_bank"></div>
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
											<input autocomplete="off" class="form-control" name="company_account_number" placeholder="No. Rekening" type="text">
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
											<input autocomplete="off" class="form-control" name="company_account_name" placeholder="Nama Rekening" type="text">
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
	function edit_company_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-home font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Perusahaan
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=company&execute=edit-company" class="horizontal-form" id="form_sample_3" method="post" enctype="multipart/form-data">
						<?php
							$company_query = mysql_query("SELECT * FROM company WHERE company_id = '".$_GET['company_id']."'");
							$company_fetch_array = mysql_fetch_array($company_query);
						?>
							<input class="form-control" name="company_id" type="hidden" value="<?php echo $company_fetch_array['company_id']; ?>">
							<div class="form-body">
							    <div class="row">
							        <div class="col-md-6">
							            <div class="form-group ">
                                                    <label class="control-label col-md-3">Logo</label>
                                                    <div class="col-md-9">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"> 
                                                                <img src="../assets/global/img/<?php echo $company_fetch_array['company_logo'] ?>">
                                                            </div>
                                                            <div>
                                                                <span class="btn red btn-outline btn-file">
                                                                    <span class="fileinput-new"> Select image </span>
                                                                    <span class="fileinput-exists"> Change </span>
                                                                    <input type="file" name="logo"> </span>
                                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix margin-top-10">
                                                            </div>
                                            </div>
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
											<input autocomplete="off" class="form-control" name="company_name" placeholder="Nama" type="text" value="<?php echo $company_fetch_array['company_name']; ?>">
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
											<input autocomplete="off" class="form-control" name="company_address" placeholder="Alamat" type="text" value="<?php echo $company_fetch_array['company_address']; ?>">
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
											<input autocomplete="off" class="form-control" name="company_village" placeholder="Kelurahan" type="text" value="<?php echo $company_fetch_array['company_village']; ?>">
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
											<input autocomplete="off" class="form-control" name="company_districts" placeholder="Kecamatan" type="text" value="<?php echo $company_fetch_array['company_districts']; ?>">
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
											<input autocomplete="off" class="form-control" name="company_city" placeholder="Kota" type="text" value="<?php echo $company_fetch_array['company_city']; ?>">
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
											<input autocomplete="off" class="form-control" name="company_phone" placeholder="No. Telpon" type="text" value="<?php echo $company_fetch_array['company_phone']; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>
												Email
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="company_email" placeholder="Email" type="text" value="<?php echo $company_fetch_array['company_email']; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Bank Rekening
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#company_account_bank" data-placeholder="Bank Rekening" name="company_account_bank">
												<option value=""></option>
												<option <?php if ($company_fetch_array['company_account_bank'] == "Bank Jatim") { ?> selected="selected" <?php } ?> value="Bank Jatim">Bank Jatim</option>
												<option <?php if ($company_fetch_array['company_account_bank'] == "BCA") { ?> selected="selected" <?php } ?> value="BCA">BCA</option>
												<option <?php if ($company_fetch_array['company_account_bank'] == "BNI") { ?> selected="selected" <?php } ?> value="BNI">BNI</option>
												<option <?php if ($company_fetch_array['company_account_bank'] == "BRi") { ?> selected="selected" <?php } ?> value="BRI">BRI</option>
												<option <?php if ($company_fetch_array['company_account_bank'] == "BNI Syariah") { ?> selected="selected" <?php } ?> value="BNI Syariah">BNI Syariah</option>
											</select>
											<div id="company_account_bank"></div>
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
											<input autocomplete="off" class="form-control" name="company_account_number" placeholder="No. Rekening" type="text" value="<?php echo $company_fetch_array['company_account_number']; ?>">
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
											<input autocomplete="off" class="form-control" name="company_account_name" placeholder="Nama Rekening" type="text" value="<?php echo $company_fetch_array['company_account_name']; ?>">
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