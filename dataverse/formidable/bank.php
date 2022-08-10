<?php
	function default_bank_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-social-dropbox font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Bank
							</span>
						</div>
						<div class="actions">
							<div class="actions">
								<a class="btn blue btn-outline" href="?connect=bank&execute=add-bank-platform">
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
								$bank_query = mysql_query("SELECT * FROM bank WHERE bank_active = '1'");
								while ($bank_fetch_array = mysql_fetch_array($bank_query))
								{
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $bank_fetch_array['bank_name']; ?>
										</td>
										<td>
											<a class="btn purple btn-outline" href="?connect=bank&execute=edit-bank-platform&bank_id=<?php echo $bank_fetch_array['bank_id']; ?>">
												<i class="icon-pencil"></i>
												Ubah
											</a>
											<a class="btn red btn-outline" data-target="#delete_bank_id_<?php echo $bank_fetch_array['bank_id']; ?>" data-toggle="modal">
												<i class="icon-trash"></i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_bank_id_<?php echo $bank_fetch_array['bank_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=bank&execute=delete-bank&bank_id=<?php echo $bank_fetch_array['bank_id']; ?>'" type="button">
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
	function add_bank_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-social-dropbox font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Bank
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=bank&execute=add-bank" class="horizontal-form" id="form_sample_3" method="post">
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
											<input autocomplete="off" autofocus class="form-control" name="bank_name" placeholder="Nama" type="text">
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
	function edit_bank_platform()
	{
		$bank = mysql_fetch_array(mysql_query("SELECT * FROM bank WHERE bank_id = '".$_GET['bank_id']."'"));
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-social-dropbox font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Bank
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=bank&execute=edit-bank" class="horizontal-form" id="form_sample_3" method="post">
							<input type="hidden" name="bank_id" value="<?php echo $bank['bank_id'] ?>">
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
											<input autocomplete="off" autofocus class="form-control" name="bank_name" placeholder="Nama" type="text" value="<?php echo $bank['bank_name'] ?>">
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