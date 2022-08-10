<?php
	function form_search_by_vehicle_in_quantity_delivery_damage_report()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" id="form_sample_3" method="post" action="?alimms=delivery-damage-report&tib=form-result-by-vehicle-in-quantity-delivery-damage-report">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Laporan Kerusakan Pengiriman</span>
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
	function form_result_by_vehicle_in_quantity_delivery_damage_report()
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
				<form class="horizontal-form" role="form" id="form_sample_3" method="post" action="?alimms=delivery-damage-report&tib=form-result-by-vehicle-in-quantity-delivery-damage-report">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Laporan Kerusakan Pengiriman</span>
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
															Laporan Kerusakan Pengiriman<br />
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
																	<th colspan=3>
																		Rencana Pengiriman
																	</th>
																	<th colspan=3>
																		Buffer Pengiriman
																	</th>
																	<th colspan=3>
																		Kerusakan Loading
																	</th>
																	<th colspan=3>
																		Kerusakan Pengiriman
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
																	<td colspan="14">
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
																		<td>
																			<?php echo $data_tbl_delivery_session['delivery_session_name'] ?>
																		</td>
																<?php
																	$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
																	while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
																	{
																		$tbl_sales_order_detail = mysql_query("SELECT SUM(d.sales_order_detail_quantity) AS total_quantity, SUM(d.sales_order_detail_bonus) AS total_bonus FROM delivery_plan a, delivery_schedule b, sales_invoice c, sales_order_detail d WHERE a.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND b.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
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
																<?php
																	$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
																	while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
																	{
																		$tbl_sales_order_detail = mysql_query("SELECT a.delivery_buffer_stock FROM delivery_buffer a, delivery_distribution b, delivery_plan c, delivery_schedule d WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND c.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND d.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_distribution_id = b.delivery_distribution_id AND b.delivery_schedule_id = c.delivery_schedule_id AND b.delivery_session_id = c.delivery_session_id AND c.delivery_schedule_id = d.delivery_schedule_id");
																		$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
																		
																		$delivery_buffer_stock = format_angka($data_tbl_sales_order_detail['delivery_buffer_stock']);
																?>
																		<td>
																	<?php
																		if ($data_tbl_sales_order_detail['delivery_buffer_stock'] == "0")
																		{
																	?>
																			0
																	<?php
																		}
																		else
																		{
																	?>
																			<?php echo $delivery_buffer_stock ?> Crt
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
																		$tbl_sales_order_detail = mysql_query("SELECT a.delivery_damage_loading FROM delivery_damage a, delivery_cheque b, delivery_distribution c, delivery_plan d, delivery_schedule e WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND e.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_cheque_id = b.delivery_cheque_id AND b.delivery_distribution_id = c.delivery_distribution_id AND c.delivery_schedule_id = d.delivery_schedule_id AND c.delivery_session_id = d.delivery_session_id AND d.delivery_schedule_id = e.delivery_schedule_id");
																		$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
																		
																		$delivery_damage_loading = format_angka($data_tbl_sales_order_detail['delivery_damage_loading']);
																?>
																		<td>
																	<?php
																		if ($data_tbl_sales_order_detail['delivery_damage_loading'] == "0")
																		{
																	?>
																			0
																	<?php
																		}
																		else
																		{
																	?>
																			<?php echo $delivery_damage_loading ?> Crt
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
																		$tbl_sales_order_detail = mysql_query("SELECT a.delivery_damage_handling FROM delivery_damage a, delivery_cheque b, delivery_distribution c, delivery_plan d, delivery_schedule e WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND e.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_cheque_id = b.delivery_cheque_id AND b.delivery_distribution_id = c.delivery_distribution_id AND c.delivery_schedule_id = d.delivery_schedule_id AND c.delivery_session_id = d.delivery_session_id AND d.delivery_schedule_id = e.delivery_schedule_id");
																		$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
																		
																		$delivery_damage_handling = format_angka($data_tbl_sales_order_detail['delivery_damage_handling']);
																?>
																		<td>
																	<?php
																		if ($data_tbl_sales_order_detail['delivery_damage_handling'] == "0")
																		{
																	?>
																			0
																	<?php
																		}
																		else
																		{
																	?>
																			<?php echo $delivery_damage_handling ?> Crt
																	<?php
																		}
																	?>
																		</td>
																<?php
																	}
																?>
																	</tr>
															<?php
																}
															?>
																</tr>
																<tr style="font-size: 14px; font-weight: 600;">
																	<td colspan="3">
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
																	$tbl_delivery_buffer = mysql_query("SELECT SUM(a.delivery_buffer_stock) AS total_buffer_stock FROM delivery_buffer a, delivery_distribution b, delivery_schedule c WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND c.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_distribution_id = b.delivery_distribution_id AND b.delivery_schedule_id = c.delivery_schedule_id");
																	$data_tbl_delivery_buffer = mysql_fetch_array($tbl_delivery_buffer);
																	
																	$total_buffer_stock = format_angka($data_tbl_delivery_buffer['total_buffer_stock']);
															?>
																	<td>
																<?php
																	if ($data_tbl_delivery_buffer['total_buffer_stock'] == "0")
																	{
																?>
																		0
																<?php
																	}
																	else
																	{
																?>
																		<?php echo $total_buffer_stock ?> Crt
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
																	$tbl_delivery_damage_loading = mysql_query("SELECT SUM(a.delivery_damage_loading) AS total_damage_loading FROM delivery_damage a, delivery_cheque b, delivery_distribution c, delivery_schedule d WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_cheque_id = b.delivery_cheque_id AND b.delivery_distribution_id = c.delivery_distribution_id AND c.delivery_schedule_id = d.delivery_schedule_id");
																	$data_tbl_delivery_damage_loading = mysql_fetch_array($tbl_delivery_damage_loading);
																	
																	$total_damage_loading = format_angka($data_tbl_delivery_damage_loading['total_damage_loading']);
															?>
																	<td>
																<?php
																	if ($data_tbl_delivery_damage_loading['total_damage_loading'] == "0")
																	{
																?>
																		0
																<?php
																	}
																	else
																	{
																?>
																		<?php echo $total_damage_loading ?> Crt
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
																	$tbl_delivery_damage_handling = mysql_query("SELECT SUM(a.delivery_damage_handling) AS total_damage_handling FROM delivery_damage a, delivery_cheque b, delivery_distribution c, delivery_schedule d WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_cheque_id = b.delivery_cheque_id AND b.delivery_distribution_id = c.delivery_distribution_id AND c.delivery_schedule_id = d.delivery_schedule_id");
																	$data_tbl_delivery_damage_handling = mysql_fetch_array($tbl_delivery_damage_handling);
																	
																	$total_damage_handling = format_angka($data_tbl_delivery_damage_handling['total_damage_handling']);
															?>
																	<td>
																<?php
																	if ($data_tbl_delivery_damage_handling['total_damage_handling'] == "0")
																	{
																?>
																		0
																<?php
																	}
																	else
																	{
																?>
																		<?php echo $total_damage_handling ?> Crt
																<?php
																	}
																?>
																	</td>
															<?php
																}
															?>
																</tr>
														<?php
															$no++;
															}
														?>
															</tbody>
															<thead>
																<tr>
																	<th colspan="3">
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
																	$tbl_delivery_buffer = mysql_query("SELECT SUM(a.delivery_buffer_stock) AS total_buffer_stock FROM delivery_buffer a, delivery_distribution b, delivery_schedule c WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND c.delivery_schedule_date = '".$delivery_date."' AND a.delivery_distribution_id = b.delivery_distribution_id AND b.delivery_schedule_id = c.delivery_schedule_id");
																	$data_tbl_delivery_buffer = mysql_fetch_array($tbl_delivery_buffer);
																	
																	$total_buffer_stock = format_angka($data_tbl_delivery_buffer['total_buffer_stock']);
															?>
																	<th>
																<?php
																	if ($data_tbl_delivery_buffer['total_buffer_stock'] == "0")
																	{
																?>
																		0
																<?php
																	}
																	else
																	{
																?>
																		<?php echo $total_buffer_stock ?> Crt
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
																	$tbl_delivery_damage_loading = mysql_query("SELECT SUM(a.delivery_damage_loading) AS total_damage_loading FROM delivery_damage a, delivery_cheque b, delivery_distribution c, delivery_schedule d WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.delivery_schedule_date = '".$delivery_date."' AND a.delivery_cheque_id = b.delivery_cheque_id AND b.delivery_distribution_id = c.delivery_distribution_id AND c.delivery_schedule_id = d.delivery_schedule_id");
																	$data_tbl_delivery_damage_loading = mysql_fetch_array($tbl_delivery_damage_loading);
																	
																	$total_damage_loading = format_angka($data_tbl_delivery_damage_loading['total_damage_loading']);
															?>
																	<th>
																<?php
																	if ($data_tbl_delivery_damage_loading['total_damage_loading'] == "0")
																	{
																?>
																		0
																<?php
																	}
																	else
																	{
																?>
																		<?php echo $total_damage_loading ?> Crt
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
																	$tbl_delivery_damage_handling = mysql_query("SELECT SUM(a.delivery_damage_handling) AS total_damage_handling FROM delivery_damage a, delivery_cheque b, delivery_distribution c, delivery_schedule d WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.delivery_schedule_date = '".$delivery_date."' AND a.delivery_cheque_id = b.delivery_cheque_id AND b.delivery_distribution_id = c.delivery_distribution_id AND c.delivery_schedule_id = d.delivery_schedule_id");
																	$data_tbl_delivery_damage_handling = mysql_fetch_array($tbl_delivery_damage_handling);
																	
																	$total_damage_handling = format_angka($data_tbl_delivery_damage_handling['total_damage_handling']);
															?>
																	<th>
																<?php
																	if ($data_tbl_delivery_damage_handling['total_damage_handling'] == "0")
																	{
																?>
																		0
																<?php
																	}
																	else
																	{
																?>
																		<?php echo $total_damage_handling ?> Crt
																<?php
																	}
																?>
																	</th>
															<?php
																}
															?>
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
																	<th colspan=3>
																		Rencana Pengiriman
																	</th>
																	<th colspan=3>
																		Buffer Pengiriman
																	</th>
																	<th colspan=3>
																		Kerusakan Loading
																	</th>
																	<th colspan=3>
																		Kerusakan Pengiriman
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
															$tbl_delivery_vehicle = mysql_query("SELECT c.delivery_vehicle_id, c.delivery_vehicle_license, c.delivery_vehicle_name FROM delivery_plan a, delivery_schedule b, delivery_vehicle c WHERE c.delivery_vehicle_active = '1' AND b.delivery_schedule_date = '".$delivery_date."' AND c.delivery_vehicle_id = '".$_POST['delivery_vehicle_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND b.delivery_vehicle_id = c.delivery_vehicle_id GROUP BY c.delivery_vehicle_id ORDER BY c.delivery_vehicle_license");
															while($data_tbl_delivery_vehicle = mysql_fetch_array($tbl_delivery_vehicle))
															{
														?>
																<tr>
																	<td style="width: 3%;">
																		<?php echo $no ?>
																	</td>
																	<td colspan="14">
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
																		<td>
																			<?php echo $data_tbl_delivery_session['delivery_session_name'] ?>
																		</td>
																<?php
																	$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
																	while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
																	{
																		$tbl_sales_order_detail = mysql_query("SELECT SUM(d.sales_order_detail_quantity) AS total_quantity, SUM(d.sales_order_detail_bonus) AS total_bonus FROM delivery_plan a, delivery_schedule b, sales_invoice c, sales_order_detail d WHERE a.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND b.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
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
																<?php
																	$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
																	while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
																	{
																		$tbl_sales_order_detail = mysql_query("SELECT a.delivery_buffer_stock FROM delivery_buffer a, delivery_distribution b, delivery_plan c, delivery_schedule d WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND c.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND d.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_distribution_id = b.delivery_distribution_id AND b.delivery_schedule_id = c.delivery_schedule_id AND b.delivery_session_id = c.delivery_session_id AND c.delivery_schedule_id = d.delivery_schedule_id");
																		$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
																		
																		$delivery_buffer_stock = format_angka($data_tbl_sales_order_detail['delivery_buffer_stock']);
																?>
																		<td>
																	<?php
																		if ($data_tbl_sales_order_detail['delivery_buffer_stock'] == "0")
																		{
																	?>
																			0
																	<?php
																		}
																		else
																		{
																	?>
																			<?php echo $delivery_buffer_stock ?> Crt
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
																		$tbl_sales_order_detail = mysql_query("SELECT a.delivery_damage_loading FROM delivery_damage a, delivery_cheque b, delivery_distribution c, delivery_plan d, delivery_schedule e WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND e.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_cheque_id = b.delivery_cheque_id AND b.delivery_distribution_id = c.delivery_distribution_id AND c.delivery_schedule_id = d.delivery_schedule_id AND c.delivery_session_id = d.delivery_session_id AND d.delivery_schedule_id = e.delivery_schedule_id");
																		$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
																		
																		$delivery_damage_loading = format_angka($data_tbl_sales_order_detail['delivery_damage_loading']);
																?>
																		<td>
																	<?php
																		if ($data_tbl_sales_order_detail['delivery_damage_loading'] == "0")
																		{
																	?>
																			0
																	<?php
																		}
																		else
																		{
																	?>
																			<?php echo $delivery_damage_loading ?> Crt
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
																		$tbl_sales_order_detail = mysql_query("SELECT a.delivery_damage_handling FROM delivery_damage a, delivery_cheque b, delivery_distribution c, delivery_plan d, delivery_schedule e WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.delivery_session_id = '".$data_tbl_delivery_session['delivery_session_id']."' AND e.delivery_vehicle_id = '".$data_tbl_delivery_vehicle['delivery_vehicle_id']."' AND a.delivery_cheque_id = b.delivery_cheque_id AND b.delivery_distribution_id = c.delivery_distribution_id AND c.delivery_schedule_id = d.delivery_schedule_id AND c.delivery_session_id = d.delivery_session_id AND d.delivery_schedule_id = e.delivery_schedule_id");
																		$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
																		
																		$delivery_damage_handling = format_angka($data_tbl_sales_order_detail['delivery_damage_handling']);
																?>
																		<td>
																	<?php
																		if ($data_tbl_sales_order_detail['delivery_damage_handling'] == "0")
																		{
																	?>
																			0
																	<?php
																		}
																		else
																		{
																	?>
																			<?php echo $delivery_damage_handling ?> Crt
																	<?php
																		}
																	?>
																		</td>
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
															<thead>
																<tr>
																	<th colspan="3">
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
																	$tbl_delivery_buffer = mysql_query("SELECT SUM(a.delivery_buffer_stock) AS total_buffer_stock FROM delivery_buffer a, delivery_distribution b, delivery_schedule c WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND c.delivery_schedule_date = '".$delivery_date."' AND c.delivery_vehicle_id = '".$_POST['delivery_vehicle_id']."' AND a.delivery_distribution_id = b.delivery_distribution_id AND b.delivery_schedule_id = c.delivery_schedule_id");
																	$data_tbl_delivery_buffer = mysql_fetch_array($tbl_delivery_buffer);
																	
																	$total_buffer_stock = format_angka($data_tbl_delivery_buffer['total_buffer_stock']);
															?>
																	<th>
																<?php
																	if ($data_tbl_delivery_buffer['total_buffer_stock'] == "0")
																	{
																?>
																		0
																<?php
																	}
																	else
																	{
																?>
																		<?php echo $total_buffer_stock ?> Crt
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
																	$tbl_delivery_damage_loading = mysql_query("SELECT SUM(a.delivery_damage_loading) AS total_damage_loading FROM delivery_damage a, delivery_cheque b, delivery_distribution c, delivery_schedule d WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.delivery_schedule_date = '".$delivery_date."' AND d.delivery_vehicle_id = '".$_POST['delivery_vehicle_id']."' AND a.delivery_cheque_id = b.delivery_cheque_id AND b.delivery_distribution_id = c.delivery_distribution_id AND c.delivery_schedule_id = d.delivery_schedule_id");
																	$data_tbl_delivery_damage_loading = mysql_fetch_array($tbl_delivery_damage_loading);
																	
																	$total_damage_loading = format_angka($data_tbl_delivery_damage_loading['total_damage_loading']);
															?>
																	<th>
																<?php
																	if ($data_tbl_delivery_damage_loading['total_damage_loading'] == "0")
																	{
																?>
																		0
																<?php
																	}
																	else
																	{
																?>
																		<?php echo $total_damage_loading ?> Crt
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
																	$tbl_delivery_damage_handling = mysql_query("SELECT SUM(a.delivery_damage_handling) AS total_damage_handling FROM delivery_damage a, delivery_cheque b, delivery_distribution c, delivery_schedule d WHERE a.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.delivery_schedule_date = '".$delivery_date."' AND d.delivery_vehicle_id = '".$_POST['delivery_vehicle_id']."' AND a.delivery_cheque_id = b.delivery_cheque_id AND b.delivery_distribution_id = c.delivery_distribution_id AND c.delivery_schedule_id = d.delivery_schedule_id");
																	$data_tbl_delivery_damage_handling = mysql_fetch_array($tbl_delivery_damage_handling);
																	
																	$total_damage_handling = format_angka($data_tbl_delivery_damage_handling['total_damage_handling']);
															?>
																	<th>
																<?php
																	if ($data_tbl_delivery_damage_handling['total_damage_handling'] == "0")
																	{
																?>
																		0
																<?php
																	}
																	else
																	{
																?>
																		<?php echo $total_damage_handling ?> Crt
																<?php
																	}
																?>
																	</th>
															<?php
																}
															?>
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
														<a class="btn green-meadow btn-sm" data-toggle="modal" href="#printbyvehicleinquantitydeliverydamagereport">
														<i class="fa fa-print"></i> Cetak
														</a>
													</div>
												</div>
												<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="printbyvehicleinquantitydeliverydamagereport">
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
																<button type="button" class="btn green-meadow btn-sm" data-dismiss="modal" onclick="location.href='../system/printable-version/delivery_damage_report.php?alimms=delivery-damage-report&tib=form-print-by-vehicle-in-quantity-delivery-damage-report&delivery_vehicle_id=<?php echo $_POST['delivery_vehicle_id'] ?>&delivery_date=<?php echo $_POST['delivery_date'] ?>'"><i class="fa fa-check"></i> Ya</button>
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