<?php
	function form_initial_payment_overdue()
	{
?>
		<div class="page-fixed-main-content">	 
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Jatuh Tempo Pembayaran
								</span>
							</div>
							<?php
								$tbl_payment_overdue = mysql_query("SELECT payment_overdue_day FROM payment_overdue WHERE payment_overdue_active = '1'");
								$jumlah_tbl_payment_overdue = mysql_num_rows($tbl_payment_overdue);
								
								if ($jumlah_tbl_payment_overdue < 1)
								{
							?>
								<div class="actions">
									<a class="blue btn btn-outline btn-sm sbold" href="?alimms=payment-overdue&tib=form-add-payment-overdue">
										<i class="fa fa-plus"></i>
										Tambah
									</a>
								</div>
							<?php
								}
							?>
						</div>
						<div class="portlet-body">
							<table class="table table-bordered table-checkable table-hover table-striped order-column" id="sample_2">
								<thead>
									<tr>
										<th>
										</th>
										<th>
											No
										</th>
										<th>
											Hari
										</th>
										<th>
											Status
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_payment_overdue = mysql_query("SELECT payment_overdue_id, payment_overdue_day, payment_overdue_active FROM payment_overdue ORDER BY payment_overdue_day");
									while ($data_tbl_payment_overdue = mysql_fetch_array($tbl_payment_overdue))
									{
								?>
									<tr class="odd gradeX">
										<td>
										<?php
											if ($data_tbl_payment_overdue['payment_overdue_active'] == 1)
											{
										?>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=payment-overdue&tib=form-edit-payment-overdue&payment_overdue_id=<?php echo $data_tbl_payment_overdue['payment_overdue_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_payment_overdue_id_<?php echo $data_tbl_payment_overdue['payment_overdue_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										<?php
											}
											else
											{
										?>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Aktif" data-toggle="modal" href="#active_payment_overdue_id_<?php echo $data_tbl_payment_overdue['payment_overdue_id'] ?>">
												<i class="fa fa-exchange"></i>
											</a>
										<?php
											}
										?>
										</td>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_payment_overdue['payment_overdue_day'] ?>
										</td>
										<td>
										<?php
											if ($data_tbl_payment_overdue['payment_overdue_active'] == 1)
											{
										?>
											<span class="label label-info label-sm">Active</span>
										<?php
											}
											else
											{
										?>
											<span class="label label-danger label-sm">Non Active</span>
										<?php
											}
										?>
										</td>
									</tr>
									<div aria-hidden="true" class="fade modal" id="delete_payment_overdue_id_<?php echo $data_tbl_payment_overdue['payment_overdue_id'] ?>" role="basic" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" class="close" data-dismiss="modal" type="button"></button>
                                                    <h4 class="modal-title">
														Konfirmasi
													</h4>
                                                </div>
                                                <div class="modal-body">
													Apakah Anda Yakin Ingin Menghapus Data Ini ?
												</div>
                                                <div class="modal-footer">
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=payment-overdue&tib=delete-payment-overdue&payment_overdue_id=<?php echo $data_tbl_payment_overdue['payment_overdue_id'] ?>">
														<i class="fa fa-check"></i>
														Ya
													</a>
													<a class="btn btn-outline btn-sm red sbold" data-dismiss="modal">
														<i class="fa fa-times"></i>
														Batal
													</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<div aria-hidden="true" class="fade modal" id="active_payment_overdue_id_<?php echo $data_tbl_payment_overdue['payment_overdue_id'] ?>" role="basic" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" class="close" data-dismiss="modal" type="button"></button>
                                                    <h4 class="modal-title">
														Konfirmasi
													</h4>
                                                </div>
                                                <div class="modal-body">
													Apakah Anda Yakin Ingin Mengaktifkan Data Ini ?
												</div>
                                                <div class="modal-footer">
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=payment-overdue&tib=active-payment-overdue&payment_overdue_id=<?php echo $data_tbl_payment_overdue['payment_overdue_id'] ?>">
														<i class="fa fa-check"></i>
														Ya
													</a>
													<a class="btn btn-outline btn-sm red sbold" data-dismiss="modal">
														<i class="fa fa-times"></i>
														Batal
													</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
								<?php
									$no++;
									}
								?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	function form_add_payment_overdue()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Jatuh Tempo Pembayaran
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=payment-overdue&tib=add-payment-overdue" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<h4 class="form-section">
										Jatuh Tempo Pembayaran
									</h4>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>
													Hari
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="payment_overdue_day" placeholder="Hari" type="text">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=payment-overdue'">
										<i class="fa fa-times"></i>
										Batal
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	function form_edit_payment_overdue()
	{
		$tbl_payment_overdue = mysql_query("SELECT payment_overdue_id, payment_overdue_day FROM payment_overdue WHERE payment_overdue_id = '".$_GET['payment_overdue_id']."'");
		$data_tbl_payment_overdue = mysql_fetch_array($tbl_payment_overdue);
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Jatuh Tempo Pembayaran
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=payment-overdue&tib=edit-payment-overdue" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="payment_overdue_id" type="hidden" value="<?php echo $data_tbl_payment_overdue['payment_overdue_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Jatuh Tempo Pembayaran
									</h4>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>
													Hari
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="payment_overdue_day" placeholder="Hari" type="text" value="<?php echo $data_tbl_payment_overdue['payment_overdue_day'] ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=payment-overdue'">
										<i class="fa fa-times"></i>
										Batal
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
?>