<?php
	function form_initial_delivery_damage()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue-madison bold uppercase">Kerusakan Pengiriman</span>
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
													<th rowspan="2">
													</th>
													<th rowspan="2">
														No
													</th>
													<th rowspan="2">
														Pengiriman
													</th>
													<th rowspan="2">
														Sopir
													</th>
													<th rowspan="2">
														Helper
													</th>
													<th rowspan="2">
														Kecamatan
													</th>
													<th colspan="3">
														Kerusakan Loading
													</th>
													<th colspan="3">
														Kerusakan Pengiriman
													</th>
													<th rowspan="2">
														Status
													</th>
												</tr>
												<tr>
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
												</tr>
											</thead>
											<tbody>
										<?php
											$no = 1;
											$tbl_delivery_damage = mysql_query("SELECT a.delivery_damage_status, b.delivery_cheque_id, j.delivery_schedule_id, j.delivery_schedule_date, j.driver_name, j.helper_one_name, j.helper_two_name, j.helper_three_name, k.delivery_vehicle_license, k.delivery_vehicle_name, l.delivery_session_id, l.delivery_session_name FROM delivery_damage a, delivery_cheque b, delivery_distribution c, delivery_plan d, sales_invoice e, sales_order f, sales_request g, customer h, customer_districts i, delivery_schedule j, delivery_vehicle k, delivery_session l WHERE g.sales_request_active = '1' AND h.customer_active = '1' AND i.customer_districts_active = '1' AND j.delivery_schedule_active = '1' AND k.delivery_vehicle_active = '1' AND l.delivery_session_active = '1' AND a.delivery_cheque_id = b.delivery_cheque_id AND b.delivery_distribution_id = c.delivery_distribution_id AND c.delivery_schedule_id = d.delivery_schedule_id AND c.delivery_session_id = d.delivery_session_id AND d.sales_invoice_id = e.sales_invoice_id AND e.sales_order_id = f.sales_order_id AND f.sales_request_id = g.sales_request_id AND g.customer_id = h.customer_id AND h.customer_districts_id = i.customer_districts_id AND d.delivery_schedule_id = j.delivery_schedule_id AND j.delivery_vehicle_id = k.delivery_vehicle_id AND d.delivery_session_id = l.delivery_session_id GROUP BY j.delivery_schedule_id, l.delivery_session_id ORDER BY k.delivery_vehicle_id");
											while ($data_tbl_delivery_damage = mysql_fetch_array($tbl_delivery_damage))
											{
												$delivery_schedule_date_indo = tanggal_indo($data_tbl_delivery_damage['delivery_schedule_date']);
										?>
												<tr>
											<?php
												if ($data_tbl_delivery_damage['delivery_damage_status'] == "On Hold")
												{
											?>
													<td style="width: 3%;">
														<a class="btn btn-icon-only grey-cascade tooltips" data-toggle="modal" data-original-title="Proses" href="#handlingdeliverydamage<?php echo $data_tbl_delivery_damage['delivery_cheque_id'] ?>">
														<i class="fa fa-cogs"></i></a>
													</td>
											<?php
												}
												else
												{
											?>
													<td style="width: 3%;">
														<a class="btn btn-icon-only grey-cascade tooltips" data-original-title="Ubah" href="?alimms=delivery-damage&tib=form-edit-delivery-damage&delivery_cheque_id=<?php echo $data_tbl_delivery_damage['delivery_cheque_id'] ?>">
														<i class="fa fa-pencil"></i></a>
													</td>
											<?php
												}
											?>
													<td style="width: 3%;">
														<?php echo $no ?>
													</td>
													<td>
														(<?php echo $data_tbl_delivery_damage['delivery_vehicle_license'] ?>) <?php echo $data_tbl_delivery_damage['delivery_vehicle_name'] ?><br />
														<?php echo $delivery_schedule_date_indo ?> - <?php echo $data_tbl_delivery_damage['delivery_session_name'] ?>
													</td>
													<td>
														<?php echo $data_tbl_delivery_damage['driver_name'] ?>
													</td>
													<td>
														<?php echo $data_tbl_delivery_damage['helper_one_name'] ?>
												<?php
													if ($data_tbl_delivery_damage['helper_two_name'] == "")
													{
												?>
												<?php
													}
													else
													{
												?>
														<br /><?php echo $data_tbl_delivery_damage['helper_two_name'] ?>
												<?php
													}
												?>
												<?php
													if ($data_tbl_delivery_damage['helper_three_name'] == "")
													{
												?>
												<?php
													}
													else
													{
												?>
														<br /><?php echo $data_tbl_delivery_damage['helper_three_name'] ?>
												<?php
													}
												?>
													</td>
													<td>
												<?php
													$tbl_customer_districts = mysql_query("SELECT f.customer_districts_name FROM delivery_plan a, sales_invoice b, sales_order c, sales_request d, customer e, customer_districts f WHERE a.delivery_schedule_id = '".$data_tbl_delivery_damage['delivery_schedule_id']."' AND a.delivery_session_id = '".$data_tbl_delivery_damage['delivery_session_id']."' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id = c.sales_order_id AND c.sales_request_id = d.sales_request_id AND d.customer_id = e.customer_id AND e.customer_districts_id = f.customer_districts_id");
													while ($data_tbl_customer_districts = mysql_fetch_array($tbl_customer_districts))
													{
												?>
														(<?php echo $data_tbl_customer_districts['customer_districts_name'] ?>)
												<?php
													}
												?>
													</td>
										<?php
											$tbl_product_sell = mysql_query("SELECT product_sell_id, product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
											while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
											{
												$tbl_delivery_damage_loading = mysql_query("SELECT delivery_damage_loading FROM delivery_damage WHERE delivery_cheque_id = '".$data_tbl_delivery_damage['delivery_cheque_id']."' AND product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
												$data_tbl_delivery_damage_loading = mysql_fetch_array($tbl_delivery_damage_loading);
												
												$delivery_damage_loading = format_angka($data_tbl_delivery_damage_loading['delivery_damage_loading']);
										?>
													<td>
												<?php
													if ($data_tbl_delivery_damage_loading['delivery_damage_loading'] == "0")
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
											$tbl_product_sell = mysql_query("SELECT product_sell_id, product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
											while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
											{
												$tbl_delivery_damage_handling = mysql_query("SELECT delivery_damage_handling FROM delivery_damage WHERE delivery_cheque_id = '".$data_tbl_delivery_damage['delivery_cheque_id']."' AND product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
												$data_tbl_delivery_damage_handling = mysql_fetch_array($tbl_delivery_damage_handling);
												
												$delivery_damage_handling = format_angka($data_tbl_delivery_damage_handling['delivery_damage_handling']);
										?>
													<td>
												<?php
													if ($data_tbl_delivery_damage_handling['delivery_damage_handling'] == "0")
													{
												?>
														<span class="label label-primary label-sm">On Hold</span>
												<?php
													}
													else
													{
													if ($data_tbl_delivery_damage_handling['delivery_damage_handling'] == "0")
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
													}
												?>
													</td>
										<?php
											}
										?>
													<td>
												<?php
													if ($data_tbl_delivery_damage['delivery_damage_status'] == "On Hold")
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
												<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="handlingdeliverydamage<?php echo $data_tbl_delivery_damage['delivery_cheque_id'] ?>">
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
																<button type="button" class="btn green-meadow btn-sm" onclick="location.href='?alimms=delivery-damage&tib=form-handling-delivery-damage&delivery_cheque_id=<?php echo $data_tbl_delivery_damage['delivery_cheque_id'] ?>'"><i class="fa fa-check"></i> Ya</button>
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
	function form_handling_delivery_damage()
	{
		$tbl_delivery_damage = mysql_query("SELECT delivery_cheque_id FROM delivery_damage WHERE delivery_cheque_id = '".$_GET['delivery_cheque_id']."'");
		$data_tbl_delivery_damage = mysql_fetch_array($tbl_delivery_damage);
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" id="form_sample_3" method="post" action="?alimms=delivery-damage&tib=handling-delivery-damage">
				<input type="hidden" class="form-control" name="delivery_cheque_id" value="<?php echo $data_tbl_delivery_damage['delivery_cheque_id'] ?>" />
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Kerusakan Pengiriman</span>
							</div>
							<div class="actions btn-set">
								<button type="submit" class="btn green-meadow"><i class="fa fa-check"></i> Simpan</button>
								<button type="button" class="btn red-sunglo" onclick="location.href='?alimms=delivery-damage'"><i class="fa fa-times"></i> Batal</button>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="alert alert-info no-margin">
											<h4 class="form-section">Informasi Kerusakan Pengiriman</h4>
											<div class="row">
										<?php
											$tbl_product_sell = mysql_query("SELECT product_sell_id, product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
											while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
											{
										?>
												<div class="col-md-4">
													<div class="form-group">
														<label class="control-label">Kerusakan <?php echo $data_tbl_product_sell['product_sell_name'] ?> <span class="required">*</span></label>
														<input type="hidden" class="form-control" name="product_sell_id[]" value="<?php echo $data_tbl_product_sell['product_sell_id'] ?>" />
														<input type="text" class="form-control" placeholder="<?php echo $data_tbl_product_sell['product_sell_name'] ?>" name="delivery_damage_handling[]" value="0" />
													</div>
												</div>	
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
				</form>
			</div>
		</div>
<?php
	}
	function form_edit_delivery_damage()
	{
		$tbl_delivery_damage = mysql_query("SELECT delivery_cheque_id FROM delivery_damage WHERE delivery_cheque_id = '".$_GET['delivery_cheque_id']."'");
		$data_tbl_delivery_damage = mysql_fetch_array($tbl_delivery_damage);
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" id="form_sample_3" method="post" action="?alimms=delivery-damage&tib=handling-delivery-damage">
				<input type="hidden" class="form-control" name="delivery_cheque_id" value="<?php echo $data_tbl_delivery_damage['delivery_cheque_id'] ?>" />
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Kerusakan Pengiriman</span>
							</div>
							<div class="actions btn-set">
								<button type="submit" class="btn green-meadow"><i class="fa fa-check"></i> Simpan</button>
								<button type="button" class="btn red-sunglo" onclick="location.href='?alimms=delivery-damage'"><i class="fa fa-times"></i> Batal</button>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="alert alert-info no-margin">
											<h4 class="form-section">Informasi Kerusakan Pengiriman</h4>
											<div class="row">
										<?php
											$tbl_product_sell = mysql_query("SELECT product_sell_id, product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
											while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
											{
												$tbl_delivery_damage_handling = mysql_query("SELECT delivery_damage_handling FROM delivery_damage WHERE delivery_cheque_id = '".$data_tbl_delivery_damage['delivery_cheque_id']."' AND product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
												$data_tbl_delivery_damage_handling = mysql_fetch_array($tbl_delivery_damage_handling);
										?>
												<div class="col-md-4">
													<div class="form-group">
														<label class="control-label">Kerusakan <?php echo $data_tbl_product_sell['product_sell_name'] ?> <span class="required">*</span></label>
														<input type="hidden" class="form-control" name="product_sell_id[]" value="<?php echo $data_tbl_product_sell['product_sell_id'] ?>" />
														<input type="text" class="form-control" placeholder="<?php echo $data_tbl_product_sell['product_sell_name'] ?>" name="delivery_damage_handling[]" value="<?php echo $data_tbl_delivery_damage_handling['delivery_damage_handling'] ?>" />
													</div>
												</div>	
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
				</form>
			</div>
		</div>
<?php
	}
?>