<?php
	function form_initial_billing_visit()
	{
		$tgl_sekarang = date("Y-m-d");
		
		$tbl_billing_work_plan_detail = mysql_query("SELECT SUM(a.billing_work_plan_detail_total_price) AS total_price FROM billing_work_plan_detail a, billing_work_plan b WHERE a.billing_work_plan_id = b.billing_work_plan_id AND b.billingman_id = '".$_SESSION['user_id']."' AND b.billing_work_plan_date = '".$tgl_sekarang."'");
		$data_tbl_billing_work_plan_detail = mysql_fetch_array($tbl_billing_work_plan_detail);
		
		$billing_work_plan_detail_total_price_all = format_angka($data_tbl_billing_work_plan_detail['total_price']);
		
		$tbl_billing_visit_detail = mysql_query("SELECT SUM(a.billing_visit_detail_total_price) AS total_price FROM billing_visit_detail a, billing_visit b, billing_work_plan_detail c, billing_work_plan d WHERE a.billing_visit_id = b.billing_visit_id AND b.billing_work_plan_detail_id = c.billing_work_plan_detail_id AND c.billing_work_plan_id = d.billing_work_plan_id AND d.billing_work_plan_date = '".$tgl_sekarang."' AND d.billingman_id = '".$_SESSION['user_id']."'");
		$data_tbl_billing_visit_detail = mysql_fetch_array($tbl_billing_visit_detail);
		
		$billing_visit_detail_total_price_all = format_angka($data_tbl_billing_visit_detail['total_price']);
		
		$prosentase = round(($data_tbl_billing_visit_detail['total_price'] / $data_tbl_billing_work_plan_detail['total_price']) * 100, 2);
		
		$tbl_billing_work_plan_detaila = mysql_query("SELECT COUNT(a.billing_work_plan_detail_id) AS total_quantity FROM billing_work_plan_detail a, billing_work_plan b WHERE a.billing_work_plan_id = b.billing_work_plan_id AND b.billingman_id = '".$_SESSION['user_id']."' AND b.billing_work_plan_date = '".$tgl_sekarang."'");
		$data_tbl_billing_work_plan_detaila = mysql_fetch_array($tbl_billing_work_plan_detaila);
		
		$tbl_billing_visit_yes = mysql_query("SELECT COUNT(a.billing_visit_time_in) AS total_quantity FROM billing_visit a, billing_work_plan b, billing_work_plan_detail c WHERE b.billing_work_plan_active = '1' AND NOT a.billing_visit_time_in = '00:00:00' AND b.billingman_id = '".$_SESSION['user_id']."' AND b.billing_work_plan_date = '".$tgl_sekarang."' AND a.billing_work_plan_detail_id = c.billing_work_plan_detail_id AND b.billing_work_plan_id = c.billing_work_plan_id");
		$data_tbl_billing_visit_yes = mysql_fetch_array($tbl_billing_visit_yes);
		
		$tbl_billing_visit_no = mysql_query("SELECT COUNT(a.billing_visit_time_in) AS total_quantity FROM billing_visit a, billing_work_plan b, billing_work_plan_detail c WHERE b.billing_work_plan_active = '1' AND a.billing_visit_time_in = '00:00:00' AND b.billingman_id = '".$_SESSION['user_id']."' AND b.billing_work_plan_date = '".$tgl_sekarang."' AND a.billing_work_plan_detail_id = c.billing_work_plan_detail_id AND b.billing_work_plan_id = c.billing_work_plan_id");
		$data_tbl_billing_visit_no = mysql_fetch_array($tbl_billing_visit_no);
		
		$tbl_billing_visit_order = mysql_query("SELECT COUNT(a.billing_visit_status) AS total_quantity FROM billing_visit a, billing_work_plan b, billing_work_plan_detail c WHERE b.billing_work_plan_active = '1' AND a.billing_visit_status = 'Paid' AND b.billingman_id = '".$_SESSION['user_id']."' AND b.billing_work_plan_date = '".$tgl_sekarang."' AND a.billing_work_plan_detail_id = c.billing_work_plan_detail_id AND b.billing_work_plan_id = c.billing_work_plan_id");
		$data_tbl_billing_visit_order = mysql_fetch_array($tbl_billing_visit_order);
		
		$tbl_billing_visit_not_order = mysql_query("SELECT COUNT(a.billing_visit_status) AS total_quantity FROM billing_visit a, billing_work_plan b, billing_work_plan_detail c WHERE b.billing_work_plan_active = '1' AND a.billing_visit_status = 'Unpaid' AND b.billingman_id = '".$_SESSION['user_id']."' AND b.billing_work_plan_date = '".$tgl_sekarang."' AND a.billing_work_plan_detail_id = c.billing_work_plan_detail_id AND b.billing_work_plan_id = c.billing_work_plan_id");
		$data_tbl_billing_visit_not_order = mysql_fetch_array($tbl_billing_visit_not_order);
?>
		<div class="row">
			<div class="col-md-6">
				<form class="horizontal-form" id="form_sample_3">
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue-madison bold uppercase">Rencana Penagihan</span>
						</div>
					</div>
					<div class="portlet-body">
						<table class="table table-bordered table-striped table-condensed table-hover" id="sample_3">
							<thead>
								<tr>
									<th>
									</th>
									<th>
										No
									</th>
									<th>
										Faktur
									</th>
									<th>
										Salesman
									</th>
									<th>
										Pelanggan
									</th>
									<th>
										Alamat
									</th>
									<th>
										Total
									</th>
									<th>
										Status
									</th>
								</tr>
							</thead>
							<tbody>
						<?php
							$no = 1;
							$tgl_sekarang = date("Y-m-d");
							$tbl_billing_work_plan_detail = mysql_query("SELECT a.billing_work_plan_detail_id, a.sales_invoice_no, a.sales_invoice_date, a.billing_work_plan_detail_total_price, b.billing_work_plan_date, c.user_name, d.customer_code, d.customer_name, d.customer_address, e.customer_category_name, f.customer_districts_name FROM billing_work_plan_detail a, billing_work_plan b, user c, customer d, customer_category e, customer_districts f WHERE b.billing_work_plan_date = '".$tgl_sekarang."' AND b.billingman_id = '".$_SESSION['user_id']."' AND a.billing_work_plan_id = b.billing_work_plan_id AND a.salesman_id = c.user_id AND a.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id ORDER BY a.billing_work_plan_detail_id");
							while ($data_tbl_billing_work_plan_detail = mysql_fetch_array($tbl_billing_work_plan_detail))
							{
								$sales_invoice_date = tanggal_indo($data_tbl_billing_work_plan_detail['sales_invoice_date']);
								$billing_work_plan_detail_total_price = format_angka($data_tbl_billing_work_plan_detail['billing_work_plan_detail_total_price']);
								
								$tbl_billing_visit = mysql_query("SELECT billing_visit_id, billing_visit_time_in, billing_visit_status, billing_visit_description FROM billing_visit WHERE billing_work_plan_detail_id = '".$data_tbl_billing_work_plan_detail['billing_work_plan_detail_id']."'");
								$data_tbl_billing_visit = mysql_fetch_array($tbl_billing_visit);
						?>
								<tr>
							<?php
								if ($data_tbl_billing_visit['billing_visit_time_in'] == "00:00:00")
								{
							?>
									<td style="width: 3%;">
										<a class="btn btn-icon-only grey-cascade tooltips" data-toggle="modal" data-original-title="Kunjungan" href="#billingvisitid<?php echo $data_tbl_billing_visit['billing_visit_id'] ?>">
										<i class="fa fa-book"></i></a>
									</td>
							<?php
								}
								else
								{
							?>
									<td style="width: 3%;">
										<a class="btn btn-icon-only grey-cascade tooltips" data-original-title="Ubah" href="?alimms=billing-visit&tib=form-view-billing-visit&billing_visit_id=<?php echo $data_tbl_billing_visit['billing_visit_id'] ?>">
										<i class="fa fa-search"></i></a>
									</td>
							<?php
								}								
							?>
									<td style="width: 3%;">
										<?php echo $no ?>
									</td>
									<td>
										<?php echo $data_tbl_billing_work_plan_detail['sales_invoice_no'] ?><br />
										<?php echo $sales_invoice_date ?>
									</td>
									<td>
										<?php echo $data_tbl_billing_work_plan_detail['user_name'] ?>
									</td>
									<td>
										(<?php echo $data_tbl_billing_work_plan_detail['customer_category_name'] ?>)<br />
										<?php echo $data_tbl_billing_work_plan_detail['customer_code'] ?> - <?php echo $data_tbl_billing_work_plan_detail['customer_name'] ?> (<?php echo $data_tbl_billing_work_plan_detail['customer_districts_name'] ?>)
									</td>
									<td>
										<?php echo $data_tbl_billing_work_plan_detail['customer_address'] ?>
									</td>
									<td>
										<?php echo $billing_work_plan_detail_total_price ?>
									</td>
									<td>
								<?php
									if ($data_tbl_billing_visit['billing_visit_status'] == "Call")
									{
								?>
										<span class="label label-primary label-sm">Call</span>
								<?php
									}
									elseif ($data_tbl_billing_visit['billing_visit_status'] == "Paid")
									{
								?>
										<span class="label label-success label-sm">Paid</span><br />
										<?php echo $data_tbl_billing_visit['billing_visit_description'] ?>
								<?php
									}
									else
									{
								?>
										<span class="label label-danger label-sm">Unpaid</span><br />
										<?php echo $data_tbl_billing_visit['billing_visit_description'] ?>
								<?php
									}
								?>
									</td>
								</tr>
								<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="billingvisitid<?php echo $data_tbl_billing_visit['billing_visit_id'] ?>">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h4 class="modal-title">Konfirmasi</h4>
											</div>
											<div class="modal-body">
												<p>
													Apakah Anda Yakin Ingin Memproses Data Ini ?
												</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn green-meadow btn-sm" onclick="location.href='?alimms=billing-visit&tib=form-question-billing-visit&billing_visit_id=<?php echo $data_tbl_billing_visit['billing_visit_id'] ?>'"><i class="fa fa-check"></i> Ya</button>
												<button type="button" class="btn red-sunglo btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
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
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-4">
						<a class="dashboard-stat dashboard-stat-light red-intense" href="javascript:;">
						<div class="visual">
							<i class="fa fa-briefcase fa-icon-medium"></i>
						</div>
						<div class="details">
							<div class="number">
								<?php echo $billing_work_plan_detail_total_price_all ?>
							</div>
							<div class="desc">
								Target (Rp)
							</div>
						</div>
						</a>
					</div>
					<div class="col-md-4">
						<a class="dashboard-stat dashboard-stat-light blue-madison" href="javascript:;">
						<div class="visual">
							<i class="fa fa-shopping-cart"></i>
						</div>
						<div class="details">
							<div class="number">
								<?php echo $billing_visit_detail_total_price_all ?>
							</div>
							<div class="desc">
								Pencapaian (Rp)
							</div>
						</div>
						</a>
					</div>
					<div class="col-md-4">
						<a class="dashboard-stat dashboard-stat-light green-haze" href="javascript:;">
						<div class="visual">
							<i class="fa fa-group fa-icon-medium"></i>
						</div>
						<div class="details">
							<div class="number">
								<?php echo $prosentase ?>
							</div>
							<div class="desc">
								Prosentase (Rp)
							</div>
						</div>
						</a>
					</div>
				</div>
				<div class="row">
					<div class="portlet-body form">
						<div class="form-body">
							<div class="col-md-12">
								<div class="alert alert-info no-margin">
									<h4 class="form-section">Informasi Penagihan</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Rencana Penagihan</label>
												<h4>
													<?php echo $data_tbl_billing_work_plan_detaila['total_quantity'] ?>
												</h4>	
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Total Penagihan Hari Ini</label>
												<h4>
													<?php echo $billing_visit_detail_total_price_all ?>
												</h4>	
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Pelanggan Yang Dikunjungi</label>
												<h4>
													<?php echo $data_tbl_billing_visit_yes['total_quantity'] ?>
												</h4>	
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Pelanggan Yang Belum Dikunjungi</label>
												<h4>
													<?php echo $data_tbl_billing_visit_no['total_quantity'] ?>
												</h4>	
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Pelangan Yang Membayar</label>
												<h4>
													<?php echo $data_tbl_billing_visit_order['total_quantity'] ?>
												</h4>	
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Pelanggan Yang Tidak Membayar</label>
												<h4>
													<?php echo $data_tbl_billing_visit_not_order['total_quantity'] ?>
												</h4>	
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				</form>
			</div>
		</div>
<?php
	}
	function form_question_billing_visit()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" id="form_sample_3" method="post" action="?alimms=billing-visit&tib=question-billing-visit">
				<input type="hidden" class="form-control" name="billing_visit_id" value="<?php echo $_GET['billing_visit_id'] ?>" />
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Kunjungan Penagihan</span>
							</div>
							<div class="actions btn-set">
								<button type="submit" class="btn green-meadow"><i class="fa fa-cogs"></i> Proses</button>
								<button type="button" class="btn red-sunglo" onclick="location.href='?alimms=billing-visit'"><i class="fa fa-times"></i> Keluar</button>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="alert alert-info no-margin">
											<h4 class="form-section">Informasi Kunjungan Penagihan</h4>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Penagihan <span class="required">*</span></label>
														<div class="radio-list">
															<label class="radio-inline">
																<input type="radio" name="billing_visit_status" value="Paid" checked="checked" />
																Membayar
															</label>
															<label class="radio-inline">
																<input type="radio" name="billing_visit_status" value="Unpaid" />
																Tidak Membayar
															</label>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Keterangan <span class="required">*</span></label>
														<input type="text" class="form-control" placeholder="Keterangan" name="billing_visit_description" />
														<span class="help-block">
															<i>Kolom Dikosongkan Jika Penagihan Membayar</i>
														</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
<?php
	}
	function form_payment_billing_visit()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" id="form_sample_3" enctype="multipart/form-data" method="post" action="?alimms=billing-visit&tib=payment-billing-visit">
				<input type="hidden" class="form-control" name="billing_visit_id" value="<?php echo $_GET['billing_visit_id'] ?>" />
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Kunjungan Penagihan</span>
							</div>
							<div class="actions btn-set">
								<button type="submit" class="btn green-meadow"><i class="fa fa-cogs"></i> Simpan</button>
								<button type="button" class="btn red-sunglo" onclick="location.href='?alimms=billing-visit'"><i class="fa fa-times"></i> Keluar</button>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="alert alert-info no-margin">
											<h4 class="form-section">Informasi Penagihan</h4>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Pembayaran <span class="required">*</span></label>
														<div class="radio-list">
													<?php
														$tbl_payment_type = mysql_query("SELECT payment_type_id, payment_type_name FROM payment_type WHERE payment_type_active = '1' ORDER BY payment_type_id");
														while($data_tbl_payment_type = mysql_fetch_array($tbl_payment_type))
														{
													?>
															<label class="radio-inline">
																<input type="radio" name="payment_type_id" value="<?php echo $data_tbl_payment_type['payment_type_id'] ?>" />
																<?php echo $data_tbl_payment_type['payment_type_name'] ?>
															</label>
													<?php
														}
													?>
														</div>
													</div>
												</div>
											</div>
											<h4 class="form-section">Informasi Pembayaran</h4>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Total Pembayaran <span class="required">*</span></label>
														<input type="text" class="form-control" placeholder="Total Pembayaran" name="billing_visit_detail_total_price" />
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Keterangan <span class="required">*</span></label>
														<input type="text" class="form-control" placeholder="Keterangan" name="billing_visit_detail_description" />
													</div>
												</div>
											</div>
											<div class="row">
												
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Tgl. Jatuh Tempo <span class="required">*</span></label>
														<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="Tgl. Jatuh Tempo" name="billing_visit_detail_due_date" />
														<span class="help-block">
															<i>Kolom Diisi Jika Pembayaran Melalui Giro</i>
														</span>
													</div>
												</div>
											</div>
											<h4 class="form-section">Informasi Foto Lampiran</h4>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Foto Lampiran <span class="required">*</span></label><br />
														<div class="fileinput fileinput-new" data-provides="fileinput">
															<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
																<img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
															</div>
															<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
															</div>
															<div>
																<span class="btn default btn-file">
																<span class="fileinput-new">
																Pilih Foto </span>
																<span class="fileinput-exists">
																Change </span>
																<input type="file" name="billing_visit_detail_photo">
																</span>
																<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">
																Remove </a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
<?php
	}
	function form_view_billing_visit()
	{
		$tbl_billing_visit = mysql_query("SELECT a.billing_visit_id, a.billing_visit_time_in, a.billing_visit_time_out, a.billing_visit_description, a.billing_visit_status, b.customer_id FROM billing_visit a, billing_work_plan_detail b WHERE a.billing_visit_id = '".$_GET['billing_visit_id']."' AND a.billing_work_plan_detail_id = b.billing_work_plan_detail_id");
		$data_tbl_billing_visit = mysql_fetch_array($tbl_billing_visit);
		
		$tbl_customer = mysql_query("SELECT a.customer_code, a.customer_name, a.customer_address, a.customer_contact, a.customer_phone, b.customer_category_name, c.customer_type_name, d.customer_districts_name FROM customer a, customer_category b, customer_type c, customer_districts d WHERE a.customer_id = '".$data_tbl_billing_visit['customer_id']."' AND a.customer_category_id = b.customer_category_id AND a.customer_type_id = c.customer_type_id AND a.customer_districts_id = d.customer_districts_id");
		$data_tbl_customer = mysql_fetch_array($tbl_customer);
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" id="form_sample_3">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Kunjungan Penjualan</span>
							</div>
							<div class="actions btn-set">
								<button type="button" class="btn red-sunglo" onclick="location.href='?alimms=billing-visit'"><i class="fa fa-sign-out"></i> Keluar</button>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="alert alert-success no-margin">
											<h4 class="form-section">Informasi Permintaan Penjualan</h4>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Waktu Masuk</label>
														<h4>
															<?php echo $data_tbl_billing_visit['billing_visit_time_in'] ?>
														</h4>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Waktu Keluar</label>
														<h4>
															<?php echo $data_tbl_billing_visit['billing_visit_time_out'] ?>
														</h4>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Status</label>
														<h4>
															<?php echo $data_tbl_billing_visit['billing_visit_status'] ?>
														</h4>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Keterangan</label>
														<h4>
															<?php echo $data_tbl_billing_visit['billing_visit_description'] ?>
														</h4>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="alert alert-warning no-margin">
											<h4 class="form-section">Informasi Pelanggan</h4>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Kategori</label>
														<h4>
															<?php echo $data_tbl_customer['customer_category_name'] ?>
														</h4>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Jenis</label>
														<h4>
															<?php echo $data_tbl_customer['customer_type_name'] ?>
														</h4>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Kode</label>
														<h4>
															<?php echo $data_tbl_customer['customer_code'] ?>
														</h4>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Nama</label>
														<h4>
															<?php echo $data_tbl_customer['customer_name'] ?>
														</h4>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Alamat</label>
														<h4>
															<?php echo $data_tbl_customer['customer_address'] ?>
														</h4>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Kecamatan</label>
														<h4>
															<?php echo $data_tbl_customer['customer_districts_name'] ?>
														</h4>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Kontak</label>
														<h4>
															<?php echo $data_tbl_customer['customer_contact'] ?>
														</h4>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">No. Telepon</label>
														<h4>
															<?php echo $data_tbl_customer['customer_phone'] ?>
														</h4>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="portlet-body">
							<div class="row">
								<div class="col-md-12">
									<div class="portlet light bordered">
										<div class="portlet-body">
											<table class="table table-bordered table-hover">
												<thead>
													<tr role="row" class="heading">
														<th width="8%">
															Foto
														</th>
														<th width="25%">
															Nama
														</th>
													</tr>
												</thead>
												<tbody>
											<?php
												$tbl_billing_visit_detail = mysql_query("SELECT billing_visit_detail_photo FROM billing_visit_detail WHERE billing_visit_id = '".$data_tbl_billing_visit['billing_visit_id']."'");
												while ($data_tbl_billing_visit_detail = mysql_fetch_array($tbl_billing_visit_detail))
												{
											?>
													<tr>
														<td>
															<a href="../img-billing/<?php echo $data_tbl_billing_visit_detail['billing_visit_detail_photo'] ?>" class="fancybox-button" data-rel="fancybox-button">
															<img class="img-responsive" src="../img-billing/<?php echo $data_tbl_billing_visit_detail['billing_visit_detail_photo'] ?>" alt="">
															</a>
														</td>
														<td>
															<?php echo $data_tbl_product_display['billing_visit_detail_photo'] ?>
														</td>
													</tr>
											<?php
												}
											?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
<?php
	}
?>