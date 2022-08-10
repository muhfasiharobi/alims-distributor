<?php
	function form_initial_delivery_plan()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue-madison bold uppercase">Rencana Pengiriman</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="row">
							<div class="col-md-12">
								<div class="portlet light bordered">
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
														Pengiriman
													</th>
													<th>
														Faktur
													</th>
													<th>
														Pelanggan
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
											$tbl_delivery_plan = mysql_query("SELECT a.delivery_plan_id, a.delivery_schedule_id, a.delivery_session_id, a.delivery_plan_status, b.sales_invoice_no, b.sales_invoice_date, c.sales_order_id, e.customer_code, e.customer_name, f.customer_type_name, g.customer_districts_name FROM delivery_plan a, sales_invoice b, sales_order c, sales_request d, customer e, customer_type f, customer_districts g WHERE d.sales_request_active = '1' AND e.customer_active = '1' AND f.customer_type_active = '1' AND g.customer_districts_active = '1' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id = c.sales_order_id AND c.sales_request_id = d.sales_request_id AND d.customer_id = e.customer_id AND e.customer_type_id = f.customer_type_id AND e.customer_districts_id = g.customer_districts_id ORDER BY b.sales_invoice_date DESC, b.sales_invoice_no");
											while ($data_tbl_delivery_plan = mysql_fetch_array($tbl_delivery_plan))
											{
												$sales_invoice_date_indo = tanggal_indo($data_tbl_delivery_plan['sales_invoice_date']);
												
												$tbl_delivery_schedule = mysql_query("SELECT a.delivery_schedule_date, b.delivery_vehicle_license, b.delivery_vehicle_name FROM delivery_schedule a, delivery_vehicle b WHERE a.delivery_schedule_active = '1' AND b.delivery_vehicle_active = '1' AND a.delivery_schedule_id = '".$data_tbl_delivery_plan['delivery_schedule_id']."' AND a.delivery_vehicle_id = b.delivery_vehicle_id");
												$data_tbl_delivery_schedule = mysql_fetch_array($tbl_delivery_schedule);
												
												$delivery_schedule_date_indo = tanggal_indo($data_tbl_delivery_schedule['delivery_schedule_date']);
												
												$tbl_delivery_session = mysql_query("SELECT delivery_session_name FROM delivery_session WHERE delivery_session_active = '1' AND delivery_session_id = '".$data_tbl_delivery_plan['delivery_session_id']."'");
												$data_tbl_delivery_session = mysql_fetch_array($tbl_delivery_session);
										?>
												<tr>
											<?php
												if ($data_tbl_delivery_plan['delivery_plan_status'] == "On Hold")
												{
											?>
													<td style="width: 3%;">
														<a class="btn btn-icon-only grey-cascade tooltips" data-toggle="modal" data-original-title="Proses" href="#scheduledeliveryplan<?php echo $data_tbl_delivery_plan['delivery_plan_id'] ?>">
														<i class="fa fa-cogs"></i></a>
													</td>
											<?php
												}
												else
												{
											?>
													<td style="width: 3%;">
														<a class="btn btn-icon-only grey-cascade tooltips" data-original-title="Ubah" href="?alimms=delivery-plan&tib=form-edit-delivery-plan&delivery_plan_id=<?php echo $data_tbl_delivery_plan['delivery_plan_id'] ?>">
														<i class="fa fa-pencil"></i></a>
													</td>
											<?php
												}
											?>
													<td style="width: 3%;">
														<?php echo $no ?>
													</td>
													<td>
												<?php
													if ($data_tbl_delivery_plan['delivery_schedule_id'] == "0")
													{
												?>
														<span class="label label-primary label-sm">On Hold</span>
												<?php
													}
													else
													{
												?>
														(<?php echo $data_tbl_delivery_schedule['delivery_vehicle_license'] ?>) <?php echo $data_tbl_delivery_schedule['delivery_vehicle_name'] ?><br />
														<?php echo $delivery_schedule_date_indo ?> - <?php echo $data_tbl_delivery_session['delivery_session_name'] ?>
												<?php
													}
												?>
													</td>
													<td>
														<?php echo $data_tbl_delivery_plan['sales_invoice_no'] ?><br />
														<?php echo $sales_invoice_date_indo ?>
													</td>
													<td>
														(<?php echo $data_tbl_delivery_plan['customer_type_name'] ?>)<br/>
														<?php echo $data_tbl_delivery_plan['customer_code'] ?> - <?php echo $data_tbl_delivery_plan['customer_name'] ?>
													</td>
													<td>
														<?php echo $data_tbl_delivery_plan['customer_districts_name'] ?>
													</td>
										<?php
											$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
											while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
											{
												$tbl_sales_order_detail = mysql_query("SELECT sales_order_detail_quantity, sales_order_detail_bonus FROM sales_order_detail WHERE sales_order_id = '".$data_tbl_delivery_plan['sales_order_id']."' AND product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
												$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
												
												$sales_order_detail_quantity = format_angka($data_tbl_sales_order_detail['sales_order_detail_quantity']);
												$sales_order_detail_bonus = format_angka($data_tbl_sales_order_detail['sales_order_detail_bonus']);
										?>
													<td>
												<?php
													if ($data_tbl_sales_order_detail['sales_order_detail_quantity'] == "")
													{
												?>
														0
												<?php
													}
													else
													{
												?>
														<?php echo $sales_order_detail_quantity ?> Crt +<br />
														Bonus (<?php echo $sales_order_detail_bonus ?>) Crt
												<?php
													}
												?>
													</td>
										<?php
											}
										?>
													<td>
												<?php
													if ($data_tbl_delivery_plan['delivery_plan_status'] == "On Hold")
													{
												?>
														<span class="label label-primary label-sm">On Hold</span>
												<?php
													}
													else
													{
												?>
														<span class="label label-success label-sm">Closed</span>
												<?php
													}
												?>
													</td>
												</tr>
												<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="scheduledeliveryplan<?php echo $data_tbl_delivery_plan['delivery_plan_id'] ?>">
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
																<button type="button" class="btn green-meadow btn-sm" onclick="location.href='?alimms=delivery-plan&tib=form-schedule-delivery-plan&delivery_plan_id=<?php echo $data_tbl_delivery_plan['delivery_plan_id'] ?>'"><i class="fa fa-check"></i> Ya</button>
																<button type="button" class="btn red-sunglo btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
															</div>
														</div>
													</div>
												</div>
												<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="deletedeliveryplan<?php echo $data_tbl_delivery_plan['delivery_plan_id'] ?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																<h4 class="modal-title">Konfirmasi</h4>
															</div>
															<div class="modal-body">
																<p>
																	Apakah Anda Yakin Ingin Menghapus Data Ini ?
																</p>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn green-meadow btn-sm" onclick="location.href='?alimms=delivery-plan&tib=delete-delivery-plan&delivery_plan_id=<?php echo $data_tbl_delivery_plan['delivery_plan_id'] ?>'"><i class="fa fa-check"></i> Ya</button>
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
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	function form_schedule_delivery_plan()
	{
		$tbl_delivery_plan = mysql_query("SELECT delivery_plan_id FROM delivery_plan WHERE delivery_plan_id = '".$_GET['delivery_plan_id']."'");
		$data_tbl_delivery_plan = mysql_fetch_array($tbl_delivery_plan);
		
		$tgl_sekarang = date("Y-m-d");
		$tgl_besok = date('Y-m-d', strtotime('+1 day', strtotime(date("Y-m-d"))));
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" id="form_sample_3" method="post" action="?alimms=delivery-plan&tib=schedule-delivery-plan">
				<input type="hidden" class="form-control" name="delivery_plan_id" value="<?php echo $data_tbl_delivery_plan['delivery_plan_id'] ?>" />
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Rencana Pengiriman</span>
							</div>
							<div class="actions btn-set">
								<button type="submit" class="btn green-meadow"><i class="fa fa-check"></i> Simpan</button>
								<button type="button" class="btn red-sunglo" onclick="location.href='?alimms=delivery-plan'"><i class="fa fa-times"></i> Batal</button>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="alert alert-info no-margin">
											<h4 class="form-section">Informasi Rencana Pengiriman</h4>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Jadwal Pengiriman <span class="required">*</span></label>
														<select class="form-control select2me" placeholder="Pengiriman" name="delivery_schedule_id" />
															<option value=""></option>
													<?php
														$tbl_delivery_schedule = mysql_query("SELECT a.delivery_schedule_id, a.delivery_schedule_date, b.delivery_vehicle_license, b.delivery_vehicle_name FROM delivery_schedule a, delivery_vehicle b WHERE a.delivery_schedule_active = '1' AND a.delivery_schedule_date BETWEEN '".$tgl_sekarang."' AND '".$tgl_besok."' AND a.delivery_vehicle_id = b.delivery_vehicle_id ORDER BY delivery_schedule_id");
														while($data_tbl_delivery_schedule = mysql_fetch_array($tbl_delivery_schedule))
														{
															$delivery_schedule_date_indo = tanggal_indo($data_tbl_delivery_schedule['delivery_schedule_date']);
													?>
															<option value="<?php echo $data_tbl_delivery_schedule['delivery_schedule_id'] ?>"><?php echo $delivery_schedule_date_indo ?> - (<?php echo $data_tbl_delivery_schedule['delivery_vehicle_license'] ?>) <?php echo $data_tbl_delivery_schedule['delivery_vehicle_name'] ?></option>
													<?php	
														}
													?>
														</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Sesi Pengiriman <span class="required">*</span></label>
														<div class="radio-list">
													<?php
														$tbl_delivery_session = mysql_query("SELECT delivery_session_id, delivery_session_name FROM delivery_session WHERE delivery_session_active = '1' ORDER BY delivery_session_id");
														while($data_tbl_delivery_session = mysql_fetch_array($tbl_delivery_session))
														{
													?>
															<label class="radio-inline">
																<input type="radio" name="delivery_session_id" value="<?php echo $data_tbl_delivery_session['delivery_session_id'] ?>" />
																<?php echo $data_tbl_delivery_session['delivery_session_name'] ?>
															</label>
													<?php
														}
													?>
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
	function form_edit_delivery_plan()
	{
		$tbl_delivery_plan = mysql_query("SELECT delivery_plan_id, delivery_schedule_id, delivery_session_id FROM delivery_plan WHERE delivery_plan_id = '".$_GET['delivery_plan_id']."'");
		$data_tbl_delivery_plan = mysql_fetch_array($tbl_delivery_plan);
		
		$tgl_sekarang = date("Y-m-d");
		$tgl_besok = date('Y-m-d', strtotime('+1 day', strtotime(date("Y-m-d"))));
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" id="form_sample_3" method="post" action="?alimms=delivery-plan&tib=edit-delivery-plan">
				<input type="hidden" class="form-control" name="delivery_plan_id" value="<?php echo $data_tbl_delivery_plan['delivery_plan_id'] ?>" />
				<input type="text" class="form-control" name="delivery_schedule_delete_id" value="<?php echo $data_tbl_delivery_plan['delivery_schedule_id'] ?>" />
				<input type="text" class="form-control" name="delivery_session_delete_id" value="<?php echo $data_tbl_delivery_plan['delivery_session_id'] ?>" />
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Rencana Pengiriman</span>
							</div>
							<div class="actions btn-set">
								<button type="submit" class="btn green-meadow"><i class="fa fa-check"></i> Simpan</button>
								<button type="button" class="btn red-sunglo" onclick="location.href='?alimms=delivery-plan'"><i class="fa fa-times"></i> Batal</button>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="alert alert-info no-margin">
									<h4 class="form-section">Informasi Rencana Pengiriman</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Jadwal Pengiriman <span class="required">*</span></label>
												<select class="form-control select2me" placeholder="Pengiriman" name="delivery_schedule_id" />
													<option value=""></option>
											<?php
												$tbl_delivery_schedule = mysql_query("SELECT a.delivery_schedule_id, a.delivery_schedule_date, b.delivery_vehicle_license, b.delivery_vehicle_name FROM delivery_schedule a, delivery_vehicle b WHERE a.delivery_schedule_active = '1' AND a.delivery_schedule_date BETWEEN '".$tgl_sekarang."' AND '".$tgl_besok."' AND a.delivery_vehicle_id = b.delivery_vehicle_id ORDER BY delivery_schedule_id");
												while($data_tbl_delivery_schedule = mysql_fetch_array($tbl_delivery_schedule))
												{
													$delivery_schedule_date_indo = tanggal_indo($data_tbl_delivery_schedule['delivery_schedule_date']);
													if ($data_tbl_delivery_schedule['delivery_schedule_id'] == $data_tbl_delivery_plan['delivery_schedule_id'])
													{
											?>
														<option value="<?php echo $data_tbl_delivery_schedule['delivery_schedule_id'] ?>" selected="selected"><?php echo $delivery_schedule_date_indo ?> - (<?php echo $data_tbl_delivery_schedule['delivery_vehicle_license'] ?>) <?php echo $data_tbl_delivery_schedule['delivery_vehicle_name'] ?></option>
											<?php
													} 
													else 
													{
											?>
														<option value="<?php echo $data_tbl_delivery_schedule['delivery_schedule_id'] ?>"><?php echo $delivery_schedule_date_indo ?> - (<?php echo $data_tbl_delivery_schedule['delivery_vehicle_license'] ?>) <?php echo $data_tbl_delivery_schedule['delivery_vehicle_name'] ?></option>
											<?php
													}
												}
											?>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label">Sesi Pengiriman <span class="required">*</span></label>
												<div class="radio-list">
											<?php
												$tbl_delivery_session = mysql_query("SELECT delivery_session_id, delivery_session_name FROM delivery_session WHERE delivery_session_active = '1' ORDER BY delivery_session_id");
												while($data_tbl_delivery_session = mysql_fetch_array($tbl_delivery_session))
												{
													if ($data_tbl_delivery_session['delivery_session_id'] == $data_tbl_delivery_plan['delivery_session_id'])
													{
											?>
														<label class="radio-inline">
															<input type="radio" name="delivery_session_id" value="<?php echo $data_tbl_delivery_session['delivery_session_id'] ?>" checked="checked" />
															<?php echo $data_tbl_delivery_session['delivery_session_name'] ?>
														</label>
											<?php
													}
													else
													{
											?>
														<label class="radio-inline">
															<input type="radio" name="delivery_session_id" value="<?php echo $data_tbl_delivery_session['delivery_session_id'] ?>" />
															<?php echo $data_tbl_delivery_session['delivery_session_name'] ?>
														</label>
											<?php
													}
												}
											?>
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
?>