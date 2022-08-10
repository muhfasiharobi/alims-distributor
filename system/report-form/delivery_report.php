<?php
	function form_search_by_vehicle_in_time_delivery_report()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" id="form_sample_3" method="post" action="?alimms=delivery-report&tib=form-result-by-vehicle-in-time-delivery-report">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Laporan Pengiriman</span>
								<span class="caption-helper">By Kendaraan In Time</span>
							</div>
							<div class="actions btn-set">
								<button type="submit" class="btn green-meadow"><i class="fa fa-cogs"></i> Proses</button>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="alert alert-info no-margin">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label">Tanggal</label>
														<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="Tanggal" name="delivery_date" />
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
	function form_result_by_vehicle_in_time_delivery_report()
	{
		$deliveryDate = explode("-", $_POST['delivery_date']);
		$DatedeliveryDate = $deliveryDate[0];
		$MonthdeliveryDate = $deliveryDate[1];
		$YeardeliveryDate = $deliveryDate[2];
		$delivery_date = date("Y-m-d", mktime(0, 0, 0, $MonthdeliveryDate, $DatedeliveryDate, $YeardeliveryDate));
		
		$delivery_date_indo = tanggal_indo($delivery_date);
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" role="form" id="form_sample_3" method="post" action="?alimms=delivery-report&tib=form-result-by-vehicle-in-time-delivery-report">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Laporan Pengiriman</span>
								<span class="caption-helper">By Kendaraan In Time</span>
							</div>
							<div class="actions btn-set">
								<button type="submit" class="btn green-meadow"><i class="fa fa-cogs"></i> Proses</button>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="alert alert-info no-margin">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label class="control-label">Tanggal</label>
														<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="Tanggal" name="delivery_date" value="<?php echo $_POST['delivery_date'] ?>" />
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
											<div class="invoice">
												<div class="row invoice-logo">
													<div class="col-xs-6 invoice-logo-space">
														<img src="../assets/admin/pages/media/invoice/walmart.png" class="img-responsive" alt=""/>
													</div>
													<div class="col-xs-6">
														<p>
															Laporan Pengiriman<br />
															By Kendaraan In Time 
															<span class="muted">Periode <?php echo $delivery_date_indo ?></span>
														</p>
													</div>
												</div>
												<hr/>
												<div class="row">
													<div class="col-xs-12">
														<table class="table table-striped table-hover">
															<thead>
																<tr>
																	<th rowspan=2>
																		No
																	</th>
																	<th rowspan=2>
																		Kendaraan
																	</th>
																	<th rowspan=2>
																		Sesi
																	</th>
																	<th rowspan=2>
																		Faktur
																	</th>
																	<th rowspan=2>
																		Pelanggan
																	</th>
																	<th rowspan=2>
																		Kecamatan
																	</th>
																	<th colspan="2">
																		Kunjungan
																	</th>
																	<th rowspan="2">
																		Durasi Waktu
																	</th>
																	<th rowspan="2">
																		Status
																	</th>
																</tr>
																<tr>
																	<th>
																		Waktu Masuk
																	</th>
																	<th>
																		Waktu Keluar
																	</th>
																</tr>
															</thead>
															<tbody>
														<?php
															$no = 1;
															$tbl_delivery_vehicle = mysql_query("SELECT c.delivery_vehicle_id, c.delivery_vehicle_license, c.delivery_vehicle_name FROM delivery_plan a, delivery_schedule b, delivery_vehicle c WHERE c.delivery_vehicle_active = '1' AND b.delivery_schedule_date = '".$delivery_date."' AND a.delivery_schedule_id = b.delivery_schedule_id AND b.delivery_vehicle_id = c.delivery_vehicle_id GROUP BY c.delivery_vehicle_id ORDER BY c.delivery_vehicle_license");
															while($data_tbl_delivery_vehicle = mysql_fetch_array($tbl_delivery_vehicle))
															{
														?>
																<tr>
																	<td style="width: 3%;">
																		<?php echo $no ?>
																	</td>
																	<td colspan="12">
																		(<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_license'] ?>)<br />
																		<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_name'] ?>
																	</td>
															<?php
																$tbl_delivery_session = mysql_query("SELECT c.delivery_session_id, c.delivery_session_name FROM delivery_plan a, delivery_schedule b, delivery_session c WHERE c.delivery_session_active = '1' AND b.delivery_schedule_date = '".$delivery_date."' AND b.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.delivery_session_id = c.delivery_session_id GROUP BY c.delivery_session_id ORDER BY c.delivery_session_name");
																while($data_tbl_delivery_session = mysql_fetch_array($tbl_delivery_session))
																{
															?>
																	<tr>
																		<td colspan="2">
																		</td>
																		<td colspan="11">
																			<?php echo $data_tbl_delivery_session['delivery_session_name'] ?>
																		</td>
																<?php
																	$tbl_delivery_plan = mysql_query("SELECT a.delivery_plan_id, c.sales_invoice_no, c.sales_invoice_date, d.sales_order_id, f.customer_code, f.customer_name, g.customer_type_name, h.customer_districts_name FROM delivery_plan a, delivery_schedule b, sales_invoice c, sales_order d, sales_request e, customer f, customer_type g, customer_districts h WHERE b.delivery_schedule_date = '".$delivery_date."' AND a.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND b.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id AND d.sales_request_id = e.sales_request_id AND e.customer_id = f.customer_id AND f.customer_type_id = g.customer_type_id AND f.customer_districts_id = h.customer_districts_id ORDER BY c.sales_invoice_no");
																	while($data_tbl_delivery_plan = mysql_fetch_array($tbl_delivery_plan))
																	{
																		$sales_invoice_date_indo = tanggal_indo($data_tbl_delivery_plan['sales_invoice_date']);
																		
																		$tbl_delivery_visit = mysql_query("SELECT timediff(delivery_visit_time_out, delivery_visit_time_in) AS time_duration, delivery_visit_time_in, delivery_visit_time_out, delivery_visit_description, delivery_visit_status FROM delivery_visit WHERE delivery_plan_id = '".$data_tbl_delivery_plan['delivery_plan_id']."'");
																		$data_tbl_delivery_visit = mysql_fetch_array($tbl_delivery_visit);
																?>
																		<tr>
																			<td colspan="3">
																			</td>
																			<td>
																				<?php echo $data_tbl_delivery_plan['sales_invoice_no'] ?><br />
																				<?php echo $sales_invoice_date_indo ?>
																			</td>
																			<td>
																				<?php echo $data_tbl_delivery_plan['customer_type_name'] ?><br />
																				<?php echo $data_tbl_delivery_plan['customer_code'] ?> - <?php echo $data_tbl_delivery_plan['customer_name'] ?>
																			</td>
																			<td>
																				<?php echo $data_tbl_delivery_plan['customer_districts_name'] ?>
																			</td>
																			<td>
																				<?php echo $data_tbl_delivery_visit['delivery_visit_time_in'] ?>
																			</td>
																			<td>
																				<?php echo $data_tbl_delivery_visit['delivery_visit_time_out'] ?>
																			</td>
																			<td>
																				<?php echo $data_tbl_delivery_visit['time_duration'] ?>
																			</td>
																			<td>
																		<?php
																			if ($data_tbl_delivery_visit['delivery_visit_status'] == "Call")
																			{
																		?>
																				<span class="label label-primary label-sm">Call</span>
																		<?php
																			}
																			elseif ($data_tbl_delivery_visit['delivery_visit_status'] == "Delivered")
																			{
																		?>
																				<span class="label label-success label-sm">Delivered</span>
																		<?php
																			}
																			else
																			{
																		?>
																				<span class="label label-danger label-sm">Not Delivered</span><br />
																				<?php echo $data_tbl_delivery_visit['delivery_visit_description'] ?>
																				
																		<?php
																			}
																		?>
																			</td>
																		</tr>
																<?php
																	}
																?>
																	</tr>
															<?php
																}
															?>
																</tr>
														<?php
															$no++;
															}
														?>
															</tbody>
														</table>
													</div>
												</div>
												<div class="row">
													<div class="col-xs-12 invoice-block">
														<a class="btn green-meadow btn-sm" data-toggle="modal" href="#printbysalesmanintimesalesvisitreport">
														<i class="fa fa-print"></i> Cetak
														</a>
													</div>
												</div>
												<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="printbysalesmanintimesalesvisitreport">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																<h4 class="modal-title">Konfirmasi</h4>
															</div>
															<div class="modal-body">
																<p>
																	Apakah Anda Yakin Ingin Mencetak Data Ini ?
																</p>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn green-meadow btn-sm" data-dismiss="modal" onclick="location.href='../system/printable-version/sales_visit_report.php?alimms=sales-visit-report&tib=form-print-by-salesman-in-time-sales-visit-report&sales_visit_date=<?php echo $_POST['sales_visit_date'] ?>'"><i class="fa fa-check"></i> Ya</button>
																<button type="button" class="btn red-sunglo btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
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
	function form_search_by_vehicle_in_quantity_delivery_report()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" id="form_sample_3" method="post" action="?alimms=delivery-report&tib=form-result-by-vehicle-in-quantity-delivery-report">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Laporan Pengiriman</span>
								<span class="caption-helper">By Kendaraan In Quantity</span>
							</div>
							<div class="actions btn-set">
								<button type="submit" class="btn green-meadow"><i class="fa fa-cogs"></i> Proses</button>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="alert alert-info no-margin">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Kendaraan</label>
														<select class="form-control select2me" placeholder="Kendaraan" name="delivery_vehicle_id" />
															<option value=""></option>
															<option value="0">Semua Kendaraan</option>
													<?php
														$tbl_delivery_vehicle = mysql_query("SELECT delivery_vehicle_id, delivery_vehicle_license, delivery_vehicle_name FROM delivery_vehicle WHERE delivery_vehicle_active = '1' ORDER BY delivery_vehicle_license");
														while($data_tbl_delivery_vehicle = mysql_fetch_array($tbl_delivery_vehicle))
														{
													?>
															<option value="<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_id'] ?>">(<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_license'] ?>) <?php echo $data_tbl_delivery_vehicle['delivery_vehicle_name'] ?></option>
													<?php	
														}
													?>
														</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Tanggal</label>
														<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="Tanggal" name="delivery_date" />
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
	function form_result_by_vehicle_in_quantity_delivery_report()
	{
		$deliveryDate = explode("-", $_POST['delivery_date']);
		$DatedeliveryDate = $deliveryDate[0];
		$MonthdeliveryDate = $deliveryDate[1];
		$YeardeliveryDate = $deliveryDate[2];
		$delivery_date = date("Y-m-d", mktime(0, 0, 0, $MonthdeliveryDate, $DatedeliveryDate, $YeardeliveryDate));
		
		$delivery_date_indo = tanggal_indo($delivery_date);
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" role="form" id="form_sample_3" method="post" action="?alimms=delivery-report&tib=form-result-by-vehicle-in-quantity-delivery-report">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Laporan Pengiriman</span>
								<span class="caption-helper">By Kendaraan In Quantity</span>
							</div>
							<div class="actions btn-set">
								<button type="submit" class="btn green-meadow"><i class="fa fa-cogs"></i> Proses</button>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="alert alert-info no-margin">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Kendaraan</label>
														<select class="form-control select2me" placeholder="Kendaraan" name="delivery_vehicle_id" />
															<option value=""></option>
													<?php
														if ($_POST['delivery_vehicle_id'] == '0')
														{
													?>
															<option value="0" selected="selected">Semua Kendaraan</option>
													<?php
														}
														else
														{
													?>
															<option value="0">Semua Kendaraan</option>
													<?php
														}
													?>
												<?php
													$tbl_delivery_vehicle = mysql_query("SELECT delivery_vehicle_id, delivery_vehicle_license, delivery_vehicle_name FROM delivery_vehicle WHERE delivery_vehicle_active = '1' ORDER BY delivery_vehicle_license");
													while($data_tbl_delivery_vehicle = mysql_fetch_array($tbl_delivery_vehicle))
													{
														if ($data_tbl_delivery_vehicle['delivery_vehicle_id'] == $_POST['delivery_vehicle_id'])
														{
												?>
															<option value="<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_id'] ?>" selected="selected">(<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_license'] ?>) <?php echo $data_tbl_delivery_vehicle['delivery_vehicle_name'] ?></option>
												<?php
														} 
														else
														{
												?>
															<option value="<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_id'] ?>">(<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_license'] ?>) <?php echo $data_tbl_delivery_vehicle['delivery_vehicle_name'] ?></option>
												<?php
														}
													}
												?>
														</select>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Tanggal</label>
														<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="Tanggal" name="delivery_date" value="<?php echo $_POST['delivery_date'] ?>" />
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
											<div class="invoice">
												<div class="row invoice-logo">
													<div class="col-xs-6 invoice-logo-space">
														<img src="../assets/admin/pages/media/invoice/walmart.png" class="img-responsive" alt=""/>
													</div>
													<div class="col-xs-6">
														<p>
															Laporan Pengiriman<br />
															By Kendaraan In Quantity 
															<span class="muted">Periode <?php echo $delivery_date_indo ?></span>
														</p>
													</div>
												</div>
												<hr/>
										<?php
											if ($_POST['delivery_vehicle_id'] == '0')
											{
										?>
												<div class="row">
													<div class="col-xs-12">
														<table class="table table-striped table-hover">
															<thead>
																<tr>
																	<th rowspan=2>
																		No
																	</th>
																	<th rowspan=2>
																		Kendaraan
																	</th>
																	<th rowspan=2>
																		Sesi
																	</th>
																	<th rowspan=2>
																		Faktur
																	</th>
																	<th rowspan=2>
																		Pelanggan
																	</th>
																	<th rowspan=2>
																		Kecamatan
																	</th>
																	<th colspan=3>
																		Rencana Pengiriman
																	</th>
																	<th colspan=3>
																		Realisasi Pengiriman
																	</th>
																	<th rowspan=2>
																		Status
																	</th>
																</tr>
																<tr>
															<?php
																$tbl_product_sell = mysql_query("SELECT product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
																while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
																{
															?>
																	<th>
																		<?php echo $data_tbl_product_sell['product_sell_name'] ?>
																	</th>
															<?php
																}
															?>
															<?php
																$tbl_product_sell = mysql_query("SELECT product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
																while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
																{
															?>
																	<th>
																		<?php echo $data_tbl_product_sell['product_sell_name'] ?>
																	</th>
															<?php
																}
															?>
																</tr>
															</thead>
															<tbody>
														<?php
															$no = 1;
															$tbl_delivery_vehicle = mysql_query("SELECT c.delivery_vehicle_id, c.delivery_vehicle_license, c.delivery_vehicle_name FROM delivery_plan a, delivery_schedule b, delivery_vehicle c WHERE c.delivery_vehicle_active = '1' AND b.delivery_schedule_date = '".$delivery_date."' AND a.delivery_schedule_id = b.delivery_schedule_id AND b.delivery_vehicle_id = c.delivery_vehicle_id GROUP BY c.delivery_vehicle_id ORDER BY c.delivery_vehicle_license");
															while($data_tbl_delivery_vehicle = mysql_fetch_array($tbl_delivery_vehicle))
															{
														?>
																<tr>
																	<td style="width: 3%;">
																		<?php echo $no ?>
																	</td>
																	<td colspan="12">
																		(<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_license'] ?>)<br />
																		<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_name'] ?>
																	</td>
															<?php
																$tbl_delivery_session = mysql_query("SELECT c.delivery_session_id, c.delivery_session_name FROM delivery_plan a, delivery_schedule b, delivery_session c WHERE c.delivery_session_active = '1' AND b.delivery_schedule_date = '".$delivery_date."' AND b.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.delivery_session_id = c.delivery_session_id GROUP BY c.delivery_session_id ORDER BY c.delivery_session_name");
																while($data_tbl_delivery_session = mysql_fetch_array($tbl_delivery_session))
																{
															?>
																	<tr>
																		<td colspan="2">
																		</td>
																		<td colspan="11">
																			<?php echo $data_tbl_delivery_session['delivery_session_name'] ?>
																		</td>
																<?php
																	$tbl_delivery_plan = mysql_query("SELECT a.delivery_plan_id, c.sales_invoice_no, c.sales_invoice_date, d.sales_order_id, f.customer_code, f.customer_name, g.customer_type_name, h.customer_districts_name FROM delivery_plan a, delivery_schedule b, sales_invoice c, sales_order d, sales_request e, customer f, customer_type g, customer_districts h WHERE b.delivery_schedule_date = '".$delivery_date."' AND a.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND b.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id AND d.sales_request_id = e.sales_request_id AND e.customer_id = f.customer_id AND f.customer_type_id = g.customer_type_id AND f.customer_districts_id = h.customer_districts_id ORDER BY c.sales_invoice_no");
																	while($data_tbl_delivery_plan = mysql_fetch_array($tbl_delivery_plan))
																	{
																		$sales_invoice_date_indo = tanggal_indo($data_tbl_delivery_plan['sales_invoice_date']);
																		
																		$tbl_delivery_visit = mysql_query("SELECT delivery_visit_description, delivery_visit_status FROM delivery_visit WHERE delivery_plan_id = '".$data_tbl_delivery_plan['delivery_plan_id']."'");
																		$data_tbl_delivery_visit = mysql_fetch_array($tbl_delivery_visit);
																?>
																		<tr>
																			<td colspan="3">
																			</td>
																			<td>
																				<?php echo $data_tbl_delivery_plan['sales_invoice_no'] ?><br />
																				<?php echo $sales_invoice_date_indo ?>
																			</td>
																			<td>
																				<?php echo $data_tbl_delivery_plan['customer_type_name'] ?><br />
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
																	<?php
																		$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
																		while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
																		{
																			$tbl_sales_order_detail = mysql_query("SELECT a.delivery_visit_status, d.sales_order_detail_quantity, d.sales_order_detail_bonus FROM delivery_visit a, delivery_plan b, sales_invoice c, sales_order_detail d WHERE d.sales_order_id = '".$data_tbl_delivery_plan['sales_order_id']."' AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id");
																			$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
																			
																			$sales_order_detail_quantity = format_angka($data_tbl_sales_order_detail['sales_order_detail_quantity']);
																			$sales_order_detail_bonus = format_angka($data_tbl_sales_order_detail['sales_order_detail_bonus']);
																	?>
																			<td>
																		<?php
																			if ($data_tbl_sales_order_detail['delivery_visit_status'] == "Not Delivered")
																			{
																		?>
																				0
																		<?php
																			}
																			elseif ($data_tbl_sales_order_detail['delivery_visit_status'] == "Delivered")
																			{
																		?>
																				<?php echo $sales_order_detail_quantity ?> Crt +<br />
																				Bonus (<?php echo $sales_order_detail_bonus ?>) Crt
																		<?php
																			}
																			else
																			{
																		?>
																				0
																		<?php
																			}
																		?>
																			</td>
																	<?php
																		}
																	?>
																			<td>
																		<?php
																			if ($data_tbl_delivery_visit['delivery_visit_status'] == "Call")
																			{
																		?>
																				<span class="label label-primary label-sm">Call</span>
																		<?php
																			}
																			elseif ($data_tbl_delivery_visit['delivery_visit_status'] == "Delivered")
																			{
																		?>
																				<span class="label label-success label-sm">Delivered</span>
																		<?php
																			}
																			else
																			{
																		?>
																				<span class="label label-danger label-sm">Not Delivered</span><br />
																				<?php echo $data_tbl_delivery_visit['delivery_visit_description'] ?>
																				
																		<?php
																			}
																		?>
																			</td>
																		</tr>
																<?php
																	}
																?>
																	</tr>
																	<tr style="font-size: 14px; font-weight: 600;">
																		<td colspan="6">
																			Sub Total
																		</td>
																<?php
																	$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
																	while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
																	{
																		$tbl_sales_order_detail = mysql_query("SELECT SUM(d.sales_order_detail_quantity) AS total_quantity, SUM(d.sales_order_detail_bonus) AS total_bonus FROM delivery_plan a, delivery_schedule b, sales_invoice c, sales_order_detail d WHERE a.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND b.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id");
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
																			<?php echo $total_quantity?> Crt +<br />
																			Bonus (<?php echo $total_bonus ?>) Crt
																	<?php
																		}
																	?>
																		</td>
																<?php
																	}
																?>
																<?php
																	$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
																	while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
																	{
																		$tbl_sales_order_detail = mysql_query("SELECT a.delivery_visit_status, SUM(e.sales_order_detail_quantity) AS total_quantity, SUM(e.sales_order_detail_bonus) AS total_bonus FROM delivery_visit a, delivery_plan b, delivery_schedule c, sales_invoice d, sales_order_detail e WHERE a.delivery_visit_status = 'Delivered' AND b.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND c.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND e.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.delivery_schedule_id = c.delivery_schedule_id AND b.sales_invoice_id = d.sales_invoice_id AND d.sales_order_id = e.sales_order_id");
																		$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
																		
																		$total_quantity = format_angka($data_tbl_sales_order_detail['total_quantity']);
																		$total_bonus = format_angka($data_tbl_sales_order_detail['total_bonus']);
																?>
																		<td>
																	<?php
																		if ($data_tbl_sales_order_detail['delivery_visit_status'] == "Not Delivered")
																		{
																	?>
																			0
																	<?php
																		}
																		elseif ($data_tbl_sales_order_detail['delivery_visit_status'] == "Delivered")
																		{
																	?>
																			<?php echo $total_quantity ?> Crt +<br />
																			Bonus (<?php echo $total_bonus ?>) Crt
																	<?php
																		}
																		else
																		{
																	?>
																			0
																	<?php
																		}
																	?>
																		</td>
																<?php
																	}
																?>
																		<td>
																		</td>
																	</tr>
															<?php
																}
															?>
																</tr>
																<tr style="font-size: 14px; font-weight: 600;">
																	<td colspan="6">
																		Total
																	</td>
															<?php
																$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
																while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
																{
																	$tbl_sales_order_detail = mysql_query("SELECT SUM(d.sales_order_detail_quantity) AS total_quantity, SUM(d.sales_order_detail_bonus) AS total_bonus FROM delivery_plan a, delivery_schedule b, sales_invoice c, sales_order_detail d WHERE b.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id");
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
																		<?php echo $total_quantity?> Crt +<br />
																		Bonus (<?php echo $total_bonus ?>) Crt
																<?php
																	}
																?>
																	</td>
															<?php
																}
															?>
															<?php
																$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
																while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
																{
																	$tbl_sales_order_detail = mysql_query("SELECT SUM(e.sales_order_detail_quantity) AS total_quantity, SUM(e.sales_order_detail_bonus) AS total_bonus FROM delivery_visit a, delivery_plan b, delivery_schedule c, sales_invoice d, sales_order_detail e WHERE a.delivery_visit_status = 'Delivered' AND c.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND e.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.delivery_schedule_id = c.delivery_schedule_id AND b.sales_invoice_id = d.sales_invoice_id AND d.sales_order_id = e.sales_order_id");
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
																		<?php echo $total_quantity?> Crt +<br />
																		Bonus (<?php echo $total_bonus ?>) Crt
																<?php
																	}
																?>
																	</td>
															<?php
																}
															?>
																	<td>
																	</td>
																</tr>
														<?php
															$no++;
															}
														?>
															</tbody>
															<thead>
																<tr>
																	<th colspan="6">
																		Grand Total
																	</th>
															<?php
																$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
																while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
																{
																	$tbl_sales_order_detail = mysql_query("SELECT SUM(d.sales_order_detail_quantity) AS total_quantity, SUM(d.sales_order_detail_bonus) AS total_bonus FROM delivery_plan a, delivery_schedule b, sales_invoice c, sales_order_detail d WHERE b.delivery_schedule_date = '".$delivery_date."' AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id");
																	$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
																	
																	$total_quantity = format_angka($data_tbl_sales_order_detail['total_quantity']);
																	$total_bonus = format_angka($data_tbl_sales_order_detail['total_bonus']);
															?>
																	<th>
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
																		<?php echo $total_quantity?> Crt +<br />
																		Bonus (<?php echo $total_bonus ?>) Crt
																<?php
																	}
																?>
																	</th>
															<?php
																}
															?>
															<?php
																$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
																while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
																{
																	$tbl_sales_order_detail = mysql_query("SELECT SUM(e.sales_order_detail_quantity) AS total_quantity, SUM(e.sales_order_detail_bonus) AS total_bonus FROM delivery_visit a, delivery_plan b, delivery_schedule c, sales_invoice d, sales_order_detail e WHERE a.delivery_visit_status = 'Delivered' AND c.delivery_schedule_date = '".$delivery_date."' AND e.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.delivery_schedule_id = c.delivery_schedule_id AND b.sales_invoice_id = d.sales_invoice_id AND d.sales_order_id = e.sales_order_id");
																	$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
																	
																	$total_quantity = format_angka($data_tbl_sales_order_detail['total_quantity']);
																	$total_bonus = format_angka($data_tbl_sales_order_detail['total_bonus']);
															?>
																	<th>
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
																		<?php echo $total_quantity?> Crt +<br />
																		Bonus (<?php echo $total_bonus ?>) Crt
																<?php
																	}
																?>
																	</th>
															<?php
																}
															?>
																	<th>
																	</th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
										<?php
											}
											else
											{
										?>
												<div class="row">
													<div class="col-xs-12">
														<table class="table table-striped table-hover">
															<thead>
																<tr>
																	<th rowspan=2>
																		No
																	</th>
																	<th rowspan=2>
																		Kendaraan
																	</th>
																	<th rowspan=2>
																		Sesi
																	</th>
																	<th rowspan=2>
																		Faktur
																	</th>
																	<th rowspan=2>
																		Pelanggan
																	</th>
																	<th rowspan=2>
																		Kecamatan
																	</th>
																	<th colspan=3>
																		Rencana Pengiriman
																	</th>
																	<th colspan=3>
																		Realisasi Pengiriman
																	</th>
																	<th rowspan=2>
																		Status
																	</th>
																</tr>
																<tr>
															<?php
																$tbl_product_sell = mysql_query("SELECT product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
																while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
																{
															?>
																	<th>
																		<?php echo $data_tbl_product_sell['product_sell_name'] ?>
																	</th>
															<?php
																}
															?>
															<?php
																$tbl_product_sell = mysql_query("SELECT product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
																while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
																{
															?>
																	<th>
																		<?php echo $data_tbl_product_sell['product_sell_name'] ?>
																	</th>
															<?php
																}
															?>
																</tr>
															</thead>
															<tbody>
														<?php
															$no = 1;
															$tbl_delivery_vehicle = mysql_query("SELECT c.delivery_vehicle_id, c.delivery_vehicle_license, c.delivery_vehicle_name FROM delivery_plan a, delivery_schedule b, delivery_vehicle c WHERE c.delivery_vehicle_active = '1' AND b.delivery_schedule_date = '".$delivery_date."' AND b.delivery_vehicle_id = '".$_POST['delivery_vehicle_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND b.delivery_vehicle_id = c.delivery_vehicle_id GROUP BY c.delivery_vehicle_id ORDER BY c.delivery_vehicle_license");
															while($data_tbl_delivery_vehicle = mysql_fetch_array($tbl_delivery_vehicle))
															{
														?>
																<tr>
																	<td style="width: 3%;">
																		<?php echo $no ?>
																	</td>
																	<td colspan="12">
																		(<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_license'] ?>)<br />
																		<?php echo $data_tbl_delivery_vehicle['delivery_vehicle_name'] ?>
																	</td>
															<?php
																$tbl_delivery_session = mysql_query("SELECT c.delivery_session_id, c.delivery_session_name FROM delivery_plan a, delivery_schedule b, delivery_session c WHERE c.delivery_session_active = '1' AND b.delivery_schedule_date = '".$delivery_date."' AND b.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.delivery_session_id = c.delivery_session_id GROUP BY c.delivery_session_id ORDER BY c.delivery_session_name");
																while($data_tbl_delivery_session = mysql_fetch_array($tbl_delivery_session))
																{
															?>
																	<tr>
																		<td colspan="2">
																		</td>
																		<td colspan="11">
																			<?php echo $data_tbl_delivery_session['delivery_session_name'] ?>
																		</td>
																<?php
																	$tbl_delivery_plan = mysql_query("SELECT a.delivery_plan_id, c.sales_invoice_no, c.sales_invoice_date, d.sales_order_id, f.customer_code, f.customer_name, g.customer_type_name, h.customer_districts_name FROM delivery_plan a, delivery_schedule b, sales_invoice c, sales_order d, sales_request e, customer f, customer_type g, customer_districts h WHERE b.delivery_schedule_date = '".$delivery_date."' AND a.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND b.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id AND d.sales_request_id = e.sales_request_id AND e.customer_id = f.customer_id AND f.customer_type_id = g.customer_type_id AND f.customer_districts_id = h.customer_districts_id ORDER BY c.sales_invoice_no");
																	while($data_tbl_delivery_plan = mysql_fetch_array($tbl_delivery_plan))
																	{
																		$sales_invoice_date_indo = tanggal_indo($data_tbl_delivery_plan['sales_invoice_date']);
																		
																		$tbl_delivery_visit = mysql_query("SELECT delivery_visit_description, delivery_visit_status FROM delivery_visit WHERE delivery_plan_id = '".$data_tbl_delivery_plan['delivery_plan_id']."'");
																		$data_tbl_delivery_visit = mysql_fetch_array($tbl_delivery_visit);
																?>
																		<tr>
																			<td colspan="3">
																			</td>
																			<td>
																				<?php echo $data_tbl_delivery_plan['sales_invoice_no'] ?><br />
																				<?php echo $sales_invoice_date_indo ?>
																			</td>
																			<td>
																				<?php echo $data_tbl_delivery_plan['customer_type_name'] ?><br />
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
																	<?php
																		$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
																		while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
																		{
																			$tbl_sales_order_detail = mysql_query("SELECT a.delivery_visit_status, d.sales_order_detail_quantity, d.sales_order_detail_bonus FROM delivery_visit a, delivery_plan b, sales_invoice c, sales_order_detail d WHERE d.sales_order_id = '".$data_tbl_delivery_plan['sales_order_id']."' AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id");
																			$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
																			
																			$sales_order_detail_quantity = format_angka($data_tbl_sales_order_detail['sales_order_detail_quantity']);
																			$sales_order_detail_bonus = format_angka($data_tbl_sales_order_detail['sales_order_detail_bonus']);
																	?>
																			<td>
																		<?php
																			if ($data_tbl_sales_order_detail['delivery_visit_status'] == "Not Delivered")
																			{
																		?>
																				0
																		<?php
																			}
																			elseif ($data_tbl_sales_order_detail['delivery_visit_status'] == "Delivered")
																			{
																		?>
																				<?php echo $sales_order_detail_quantity ?> Crt +<br />
																				Bonus (<?php echo $sales_order_detail_bonus ?>) Crt
																		<?php
																			}
																			else
																			{
																		?>
																				0
																		<?php
																			}
																		?>
																			</td>
																	<?php
																		}
																	?>
																			<td>
																		<?php
																			if ($data_tbl_delivery_visit['delivery_visit_status'] == "Call")
																			{
																		?>
																				<span class="label label-primary label-sm">Call</span>
																		<?php
																			}
																			elseif ($data_tbl_delivery_visit['delivery_visit_status'] == "Delivered")
																			{
																		?>
																				<span class="label label-success label-sm">Delivered</span>
																		<?php
																			}
																			else
																			{
																		?>
																				<span class="label label-danger label-sm">Not Delivered</span><br />
																				<?php echo $data_tbl_delivery_visit['delivery_visit_description'] ?>
																				
																		<?php
																			}
																		?>
																			</td>
																		</tr>
																<?php
																	}
																?>
																	</tr>
																	<tr style="font-size: 14px; font-weight: 600;">
																		<td colspan="6">
																			Sub Total
																		</td>
																<?php
																	$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
																	while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
																	{
																		$tbl_sales_order_detail = mysql_query("SELECT SUM(d.sales_order_detail_quantity) AS total_quantity, SUM(d.sales_order_detail_bonus) AS total_bonus FROM delivery_plan a, delivery_schedule b, sales_invoice c, sales_order_detail d WHERE a.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND b.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id");
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
																			<?php echo $total_quantity?> Crt +<br />
																			Bonus (<?php echo $total_bonus ?>) Crt
																	<?php
																		}
																	?>
																		</td>
																<?php
																	}
																?>
																<?php
																	$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
																	while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
																	{
																		$tbl_sales_order_detail = mysql_query("SELECT a.delivery_visit_status, SUM(e.sales_order_detail_quantity) AS total_quantity, SUM(e.sales_order_detail_bonus) AS total_bonus FROM delivery_visit a, delivery_plan b, delivery_schedule c, sales_invoice d, sales_order_detail e WHERE a.delivery_visit_status = 'Delivered' AND b.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND c.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND e.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.delivery_schedule_id = c.delivery_schedule_id AND b.sales_invoice_id = d.sales_invoice_id AND d.sales_order_id = e.sales_order_id");
																		$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
																		
																		$total_quantity = format_angka($data_tbl_sales_order_detail['total_quantity']);
																		$total_bonus = format_angka($data_tbl_sales_order_detail['total_bonus']);
																?>
																		<td>
																	<?php
																		if ($data_tbl_sales_order_detail['delivery_visit_status'] == "Not Delivered")
																		{
																	?>
																			0
																	<?php
																		}
																		elseif ($data_tbl_sales_order_detail['delivery_visit_status'] == "Delivered")
																		{
																	?>
																			<?php echo $total_quantity ?> Crt +<br />
																			Bonus (<?php echo $total_bonus ?>) Crt
																	<?php
																		}
																		else
																		{
																	?>
																			0
																	<?php
																		}
																	?>
																		</td>
																<?php
																	}
																?>
																		<td>
																		</td>
																	</tr>
															<?php
																}
															?>
																</tr>
																<tr style="font-size: 14px; font-weight: 600;">
																	<td colspan="6">
																		Total
																	</td>
															<?php
																$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
																while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
																{
																	$tbl_sales_order_detail = mysql_query("SELECT SUM(d.sales_order_detail_quantity) AS total_quantity, SUM(d.sales_order_detail_bonus) AS total_bonus FROM delivery_plan a, delivery_schedule b, sales_invoice c, sales_order_detail d WHERE b.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id");
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
																		<?php echo $total_quantity?> Crt +<br />
																		Bonus (<?php echo $total_bonus ?>) Crt
																<?php
																	}
																?>
																	</td>
															<?php
																}
															?>
															<?php
																$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
																while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
																{
																	$tbl_sales_order_detail = mysql_query("SELECT SUM(e.sales_order_detail_quantity) AS total_quantity, SUM(e.sales_order_detail_bonus) AS total_bonus FROM delivery_visit a, delivery_plan b, delivery_schedule c, sales_invoice d, sales_order_detail e WHERE a.delivery_visit_status = 'Delivered' AND c.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND e.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.delivery_schedule_id = c.delivery_schedule_id AND b.sales_invoice_id = d.sales_invoice_id AND d.sales_order_id = e.sales_order_id");
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
																		<?php echo $total_quantity?> Crt +<br />
																		Bonus (<?php echo $total_bonus ?>) Crt
																<?php
																	}
																?>
																	</td>
															<?php
																}
															?>
																	<td>
																	</td>
																</tr>
														<?php
															$no++;
															}
														?>
															</tbody>
															<thead>
																<tr>
																	<th colspan="6">
																		Grand Total
																	</th>
															<?php
																$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
																while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
																{
																	$tbl_sales_order_detail = mysql_query("SELECT SUM(d.sales_order_detail_quantity) AS total_quantity, SUM(d.sales_order_detail_bonus) AS total_bonus FROM delivery_plan a, delivery_schedule b, sales_invoice c, sales_order_detail d WHERE b.delivery_schedule_date = '".$delivery_date."' AND b.delivery_vehicle_id = '".$_POST['delivery_vehicle_id']."' AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id");
																	$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
																	
																	$total_quantity = format_angka($data_tbl_sales_order_detail['total_quantity']);
																	$total_bonus = format_angka($data_tbl_sales_order_detail['total_bonus']);
															?>
																	<th>
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
																		<?php echo $total_quantity?> Crt +<br />
																		Bonus (<?php echo $total_bonus ?>) Crt
																<?php
																	}
																?>
																	</th>
															<?php
																}
															?>
															<?php
																$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
																while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
																{
																	$tbl_sales_order_detail = mysql_query("SELECT SUM(e.sales_order_detail_quantity) AS total_quantity, SUM(e.sales_order_detail_bonus) AS total_bonus FROM delivery_visit a, delivery_plan b, delivery_schedule c, sales_invoice d, sales_order_detail e WHERE a.delivery_visit_status = 'Delivered' AND c.delivery_schedule_date = '".$delivery_date."' AND c.delivery_vehicle_id = '".$_POST['delivery_vehicle_id']."' AND e.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.delivery_schedule_id = c.delivery_schedule_id AND b.sales_invoice_id = d.sales_invoice_id AND d.sales_order_id = e.sales_order_id");
																	$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
																	
																	$total_quantity = format_angka($data_tbl_sales_order_detail['total_quantity']);
																	$total_bonus = format_angka($data_tbl_sales_order_detail['total_bonus']);
															?>
																	<th>
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
																		<?php echo $total_quantity?> Crt +<br />
																		Bonus (<?php echo $total_bonus ?>) Crt
																<?php
																	}
																?>
																	</th>
															<?php
																}
															?>
																	<th>
																	</th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
										<?php
											}
										?>
												<div class="row">
													<div class="col-xs-12 invoice-block">
														<a class="btn green-meadow btn-sm" data-toggle="modal" href="#printbyvehicleinquantitydeliveryreport">
														<i class="fa fa-print"></i> Cetak
														</a>
													</div>
												</div>
												<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="printbyvehicleinquantitydeliveryreport">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
																<h4 class="modal-title">Konfirmasi</h4>
															</div>
															<div class="modal-body">
																<p>
																	Apakah Anda Yakin Ingin Mencetak Data Ini ?
																</p>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn green-meadow btn-sm" data-dismiss="modal" onclick="location.href='../system/printable-version/delivery_report.php?alimms=delivery-report&tib=form-print-by-vehicle-in-quantity-delivery-report&delivery_vehicle_id=<?php echo $_POST['delivery_vehicle_id'] ?>&delivery_date=<?php echo $_POST['delivery_date'] ?>'"><i class="fa fa-check"></i> Ya</button>
																<button type="button" class="btn red-sunglo btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Tidak</button>
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
?>