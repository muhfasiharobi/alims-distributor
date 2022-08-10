<?php
	function form_initial_delivery_visit()
	{
		$tgl_sekarang = date("Y-m-d");
		
		$tbl_delivery_visit_target = mysql_query("SELECT COUNT(b.sales_invoice_id) AS total_quantity FROM delivery_visit a, delivery_plan b, delivery_schedule c WHERE c.delivery_schedule_date = '".$tgl_sekarang."' AND c.driver_name = '".$_SESSION['user_name']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.delivery_schedule_id = c.delivery_schedule_id");
		$data_tbl_delivery_visit_target = mysql_fetch_array($tbl_delivery_visit_target);
		
		$tbl_delivery_visit_pencapaian = mysql_query("SELECT COUNT(b.sales_invoice_id) AS total_quantity FROM delivery_visit a, delivery_plan b, delivery_schedule c WHERE NOT a.delivery_visit_time_in = '00:00:00' AND NOT a.delivery_visit_time_out = '00:00:00' AND c.delivery_schedule_date = '".$tgl_sekarang."' AND c.driver_name = '".$_SESSION['user_name']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.delivery_schedule_id = c.delivery_schedule_id");
		$data_tbl_delivery_visit_pencapaian = mysql_fetch_array($tbl_delivery_visit_pencapaian);
		
		$prosentase = round(($data_tbl_delivery_visit_pencapaian['total_quantity'] / $data_tbl_delivery_visit_target['total_quantity']) * 100, 2);
?>
		<div class="row">
			<div class="col-md-6">
				<form class="horizontal-form" id="form_sample_3">
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue-madison bold uppercase">Rencana Pengiriman</span>
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
										Kecamatan
									</th>
								<?php
									$tbl_product_sell = mysql_query("SELECT product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
									while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
									{
								?>
										<th>
											<?php echo $data_tbl_product_sell['product_sell_name'] ?>
										</th>
								<?php
									}
								?>
									<th>
										Status
									</th>
								</tr>
							</thead>
							<tbody>
						<?php
							$no = 1;
							$tgl_sekarang = date("Y-m-d");
							$tbl_delivery_cheque = mysql_query("SELECT a.delivery_visit_id, a.delivery_visit_time_in, a.delivery_visit_time_out, a.delivery_visit_status, a.delivery_visit_description, b.delivery_schedule_id, b.delivery_session_id, c.sales_invoice_no, c.sales_invoice_date, f.customer_code, f.customer_name, f.customer_address, g.customer_type_name, h.customer_districts_name, i.user_name FROM delivery_visit a, delivery_plan b, sales_invoice c, sales_order d, sales_request e, customer f, customer_type g, customer_districts h, user i, delivery_schedule j WHERE j.delivery_schedule_date = '".$tgl_sekarang."' AND j.driver_name = '".$_SESSION['user_name']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id AND d.sales_request_id = e.sales_request_id AND e.customer_id = f.customer_id AND f.customer_type_id = g.customer_type_id AND f.customer_districts_id = h.customer_districts_id AND e.salesman_id = i.user_id AND b.delivery_schedule_id = j.delivery_schedule_id ORDER BY a.delivery_visit_id");
							while ($data_tbl_delivery_cheque = mysql_fetch_array($tbl_delivery_cheque))
							{
								$sales_invoice_date = tanggal_indo($data_tbl_delivery_cheque['sales_invoice_date']);
						?>
								<tr>
							<?php
								if ($data_tbl_delivery_cheque['delivery_visit_time_in'] == "00:00:00" OR $data_tbl_delivery_cheque['delivery_visit_time_out'] == "00:00:00")
								{
							?>
									<td style="width: 3%;">
										<a class="btn btn-icon-only grey-cascade tooltips" data-toggle="modal" data-original-title="Kunjungan" href="#deliveryvisit<?php echo $data_tbl_delivery_cheque['delivery_visit_id'] ?>">
										<i class="fa fa-book"></i></a>
									</td>
							<?php
								}
								else
								{
							?>
									<td style="width: 3%;">
										<a class="btn btn-icon-only grey-cascade tooltips" data-original-title="Lihat" href="?alimms=delivery-visit&tib=form-view-delivery-visit&delivery_visit_id=<?php echo $data_tbl_delivery_cheque['delivery_visit_id'] ?>">
										<i class="fa fa-search"></i></a>
									</td>
							<?php
								}								
							?>
									<td style="width: 3%;">
										<?php echo $no ?>
									</td>
									<td>
										<?php echo $data_tbl_delivery_cheque['sales_invoice_no'] ?><br />
										<?php echo $sales_invoice_date ?>
									</td>
									<td>
										<?php echo $data_tbl_delivery_cheque['user_name'] ?>
									</td>
									<td>
										(<?php echo $data_tbl_delivery_cheque['customer_type_name'] ?>)<br />
										<?php echo $data_tbl_delivery_cheque['customer_code'] ?> - <?php echo $data_tbl_delivery_cheque['customer_name'] ?>
									</td>
									<td>
										<?php echo $data_tbl_delivery_cheque['customer_address'] ?>
									</td>
									<td>
										<?php echo $data_tbl_delivery_cheque['customer_districts_name'] ?>
									</td>
						<?php
							$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
							while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
							{
								$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity) AS total_quantity, SUM(c.sales_order_detail_bonus) AS total_bonus FROM delivery_plan a, sales_invoice b, sales_order_detail c WHERE a.delivery_schedule_id = '".$data_tbl_delivery_cheque['delivery_schedule_id']."' AND a.delivery_session_id = '".$data_tbl_delivery_cheque['delivery_session_id']."' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id = c.sales_order_id AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
								$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
								
								$total_quantity = format_angka($data_tbl_sales_order_detail['total_quantity']);
								$total_bonus = format_angka($data_tbl_sales_order_detail['total_bonus']);
						?>
									<td>
								<?php
									if ($data_tbl_sales_order_detail['total_quantity'] == "")
									{
								?>
										0
								<?php
									}
									else
									{
								?>
										<?php echo $total_quantity ?> Crt +<br />
										Bonus (<?php echo $total_bonus ?>) Crt
								<?php
									}
								?>
									</td>
						<?php
							}
						?>
									<td>
								<?php
									if ($data_tbl_delivery_cheque['delivery_visit_status'] == "Call")
									{
								?>
										<span class="label label-primary label-sm">Call</span>
								<?php
									}
									elseif ($data_tbl_delivery_cheque['delivery_visit_status'] == "Delivered")
									{
								?>
										<span class="label label-success label-sm">Delivered</span><br />
										<?php echo $data_tbl_delivery_cheque['delivery_visit_description'] ?>
								<?php
									}
									else
									{
								?>
										<span class="label label-danger label-sm">Not Delivered</span><br />
										<?php echo $data_tbl_delivery_cheque['delivery_visit_description'] ?>
								<?php
									}
								?>
									</td>
								</tr>
								<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="deliveryvisit<?php echo $data_tbl_delivery_cheque['delivery_visit_id'] ?>">
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
												<button type="button" class="btn green-meadow btn-sm" onclick="location.href='?alimms=delivery-visit&tib=form-question-delivery-visit&delivery_visit_id=<?php echo $data_tbl_delivery_cheque['delivery_visit_id'] ?>'"><i class="fa fa-check"></i> Ya</button>
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
								<?php echo $data_tbl_delivery_visit_target['total_quantity'] ?>
							</div>
							<div class="desc">
								Target (Count)
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
								<?php echo $data_tbl_delivery_visit_pencapaian['total_quantity'] ?>
							</div>
							<div class="desc">
								Pencapaian (Count)
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
								Prosentase (Count)
							</div>
						</div>
						</a>
					</div>
				</div>
			<?php
				$tbl_delivery_visit_yes = mysql_query("SELECT COUNT(b.sales_invoice_id) AS total_quantity FROM delivery_visit a, delivery_plan b, delivery_schedule c WHERE NOT a.delivery_visit_status = 'Call' AND c.delivery_schedule_date = '".$tgl_sekarang."' AND c.driver_name = '".$_SESSION['user_name']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.delivery_schedule_id = c.delivery_schedule_id");
				$data_tbl_delivery_visit_yes = mysql_fetch_array($tbl_delivery_visit_yes);
		
				$tbl_delivery_visit_no = mysql_query("SELECT COUNT(b.sales_invoice_id) AS total_quantity FROM delivery_visit a, delivery_plan b, delivery_schedule c WHERE a.delivery_visit_status = 'Call' AND c.delivery_schedule_date = '".$tgl_sekarang."' AND c.driver_name = '".$_SESSION['user_name']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.delivery_schedule_id = c.delivery_schedule_id");
				$data_tbl_delivery_visit_no = mysql_fetch_array($tbl_delivery_visit_no);
					
				$tbl_delivery_visit_delivered = mysql_query("SELECT COUNT(b.sales_invoice_id) AS total_quantity FROM delivery_visit a, delivery_plan b, delivery_schedule c WHERE a.delivery_visit_status = 'Delivered' AND c.delivery_schedule_date = '".$tgl_sekarang."' AND c.driver_name = '".$_SESSION['user_name']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.delivery_schedule_id = c.delivery_schedule_id");
				$data_tbl_delivery_visit_delivered = mysql_fetch_array($tbl_delivery_visit_delivered);
				
				$tbl_delivery_visit_not_delivered = mysql_query("SELECT COUNT(b.sales_invoice_id) AS total_quantity FROM delivery_visit a, delivery_plan b, delivery_schedule c WHERE a.delivery_visit_status = 'Not Delivered' AND c.delivery_schedule_date = '".$tgl_sekarang."' AND c.driver_name = '".$_SESSION['user_name']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.delivery_schedule_id = c.delivery_schedule_id");
				$data_tbl_delivery_visit_not_delivered = mysql_fetch_array($tbl_delivery_visit_not_delivered);
			?>
				<div class="row">
					<div class="portlet-body form">
						<div class="form-body">
							<div class="col-md-12">
								<div class="alert alert-info no-margin">
									<h4 class="form-section">Informasi Pengiriman</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Pelanggan Yang Dikunjungi</label>
												<h4>
													<?php echo $data_tbl_delivery_visit_yes['total_quantity'] ?>
												</h4>	
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Pelanggan Yang Belum Dikunjungi</label>
												<h4>
													<?php echo $data_tbl_delivery_visit_no['total_quantity'] ?>
												</h4>	
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Pelangan Yang Terkirim</label>
												<h4>
													<?php echo $data_tbl_delivery_visit_delivered['total_quantity'] ?>
												</h4>	
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Pelanggan Yang Tidak Terkirim</label>
												<h4>
													<?php echo $data_tbl_delivery_visit_not_delivered['total_quantity'] ?>
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
	function form_question_delivery_visit()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" id="form_sample_3" enctype="multipart/form-data" method="post" action="?alimms=delivery-visit&tib=question-delivery-visit">
				<input type="hidden" class="form-control" name="delivery_visit_id" value="<?php echo $_GET['delivery_visit_id'] ?>" />
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Kunjungan Pengiriman</span>
							</div>
							<div class="actions btn-set">
								<button type="submit" class="btn green-meadow"><i class="fa fa-check"></i> Simpan</button>
								<button type="button" class="btn red-sunglo" onclick="location.href='?alimms=delivery-visit'"><i class="fa fa-times"></i> Keluar</button>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="alert alert-info no-margin">
											<h4 class="form-section">Informasi Foto Produk</h4>
											<div class="row">
												<div class="col-md-3">
													<div class="form-group">
														<label class="control-label">Foto 1 <span class="required">*</span></label><br />
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
																<input type="file" name="delivery_display_photo[]">
																</span>
																<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">
																Remove </a>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label class="control-label">Foto 2 <span class="required">*</span></label><br />
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
																<input type="file" name="delivery_display_photo[]">
																</span>
																<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">
																Remove </a>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label class="control-label">Foto 3 <span class="required">*</span></label><br />
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
																<input type="file" name="delivery_display_photo[]">
																</span>
																<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">
																Remove </a>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label class="control-label">Foto 4 <span class="required">*</span></label><br />
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
																<input type="file" name="delivery_display_photo[]">
																</span>
																<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">
																Remove </a>
															</div>
														</div>
													</div>
												</div>
											</div>
											<h4 class="form-section">Informasi Kunjungan Pengiriman</h4>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Pengiriman <span class="required">*</span></label>
														<div class="radio-list">
															<label class="radio-inline">
																<input type="radio" name="delivery_visit_status" value="Delivered" checked="checked" />
																Terkirim
															</label>
															<label class="radio-inline">
																<input type="radio" name="delivery_visit_status" value="Not Delivered" />
																Tidak Terkirim
															</label>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Keterangan <span class="required">*</span></label>
														<input type="text" class="form-control" placeholder="Keterangan" name="delivery_visit_description" />
														<span class="help-block">
															<i>Kolom Dikosongkan Jika Pengiriman Terkirim</i>
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
	function form_view_delivery_visit()
	{
		$tbl_delivery_visit = mysql_query("SELECT a.delivery_visit_id, a.delivery_visit_time_in, a.delivery_visit_time_out, a.delivery_visit_description, a.delivery_visit_status, f.customer_code, f.customer_name, f.customer_address, f.customer_contact, f.customer_phone, g.customer_type_name, h.customer_districts_name FROM delivery_visit a, delivery_plan b, sales_invoice c, sales_order d, sales_request e, customer f, customer_type g, customer_districts h WHERE a.delivery_visit_id = '".$_GET['delivery_visit_id']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id AND d.sales_request_id = e.sales_request_id AND e.customer_id = f.customer_id AND f.customer_type_id = g.customer_type_id AND f.customer_districts_id = h.customer_districts_id");
		$data_tbl_delivery_visit = mysql_fetch_array($tbl_delivery_visit);
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" id="form_sample_3">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Kunjungan Pengiriman</span>
							</div>
							<div class="actions btn-set">
								<button type="button" class="btn red-sunglo" onclick="location.href='?alimms=delivery-visit'"><i class="fa fa-sign-out"></i> Keluar</button>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="alert alert-success no-margin">
											<h4 class="form-section">Informasi Kunjungan Pengiriman</h4>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Waktu Masuk</label>
														<h4>
															<?php echo $data_tbl_delivery_visit['delivery_visit_time_in'] ?>
														</h4>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Waktu Keluar</label>
														<h4>
															<?php echo $data_tbl_delivery_visit['delivery_visit_time_out'] ?>
														</h4>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Status</label>
														<h4>
															<?php echo $data_tbl_delivery_visit['delivery_visit_status'] ?>
														</h4>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Keterangan</label>
														<h4>
															<?php echo $data_tbl_delivery_visit['delivery_visit_description'] ?>
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
														<label class="control-label">Jenis</label>
														<h4>
															<?php echo $data_tbl_delivery_visit['customer_type_name'] ?>
														</h4>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Kode</label>
														<h4>
															<?php echo $data_tbl_delivery_visit['customer_code'] ?>
														</h4>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Nama</label>
														<h4>
															<?php echo $data_tbl_delivery_visit['customer_name'] ?>
														</h4>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Alamat</label>
														<h4>
															<?php echo $data_tbl_delivery_visit['customer_address'] ?>
														</h4>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Kecamatan</label>
														<h4>
															<?php echo $data_tbl_delivery_visit['customer_districts_name'] ?>
														</h4>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Kontak</label>
														<h4>
															<?php echo $data_tbl_delivery_visit['customer_contact'] ?>
														</h4>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">No. Telepon</label>
														<h4>
															<?php echo $data_tbl_delivery_visit['customer_phone'] ?>
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
												$tbl_delivery_display = mysql_query("SELECT delivery_display_photo FROM delivery_display WHERE delivery_visit_id = '".$data_tbl_delivery_visit['delivery_visit_id']."'");
												while ($data_tbl_delivery_display = mysql_fetch_array($tbl_delivery_display))
												{
											?>
													<tr>
														<td>
															<a href="../img-delivery/<?php echo $data_tbl_delivery_display['delivery_display_photo'] ?>" class="fancybox-button" data-rel="fancybox-button">
															<img class="img-responsive" src="../img-delivery/<?php echo $data_tbl_delivery_display['delivery_display_photo'] ?>" alt="">
															</a>
														</td>
														<td>
															<?php echo $data_tbl_delivery_display['delivery_display_photo'] ?>
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