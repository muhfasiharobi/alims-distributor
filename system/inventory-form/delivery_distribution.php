<?php
	function form_initial_delivery_distribution()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue-madison bold uppercase">Distribusi Pengiriman</span>
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
														Sopir
													</th>
													<th>
														Helper
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
														Sub Total
													</th>
													<th>
														Status
													</th>
												</tr>
											</thead>
											<tbody>
										<?php
											$no = 1;
											$tbl_delivery_distribution = mysql_query("SELECT a.delivery_distribution_id, a.delivery_distribution_status, h.delivery_schedule_id, h.delivery_schedule_date, h.driver_name, h.helper_one_name, h.helper_two_name, h.helper_three_name, i.delivery_vehicle_license, i.delivery_vehicle_name, j.delivery_session_id, j.delivery_session_name FROM delivery_distribution a, delivery_plan b, sales_invoice c, sales_order d, sales_request e, customer f, customer_districts g, delivery_schedule h, delivery_vehicle i, delivery_session j WHERE e.sales_request_active = '1' AND f.customer_active = '1' AND g.customer_districts_active = '1' AND h.delivery_schedule_active = '1' AND i.delivery_vehicle_active = '1' AND j.delivery_session_active = '1' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.delivery_session_id = b.delivery_session_id AND b.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id AND d.sales_request_id = e.sales_request_id AND e.customer_id = f.customer_id AND f.customer_districts_id = g.customer_districts_id AND b.delivery_schedule_id = h.delivery_schedule_id AND h.delivery_vehicle_id = i.delivery_vehicle_id AND b.delivery_session_id = j.delivery_session_id GROUP BY h.delivery_schedule_id, j.delivery_session_id ORDER BY i.delivery_vehicle_id");
											while ($data_tbl_delivery_distribution = mysql_fetch_array($tbl_delivery_distribution))
											{
												$delivery_schedule_date_indo = tanggal_indo($data_tbl_delivery_distribution['delivery_schedule_date']);
												
												$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity + c.sales_order_detail_bonus) AS sub_total_quantity FROM delivery_plan a, sales_invoice b, sales_order_detail c WHERE a.delivery_schedule_id = '".$data_tbl_delivery_distribution['delivery_schedule_id']."' AND a.delivery_session_id = '".$data_tbl_delivery_distribution['delivery_session_id']."' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id = c.sales_order_id");
												$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
												
												$tbl_delivery_buffer = mysql_query("SELECT SUM(delivery_buffer_stock) AS total_buffer_stock FROM delivery_buffer WHERE delivery_distribution_id = '".$data_tbl_delivery_distribution['delivery_distribution_id']."'");
												$data_tbl_delivery_buffer = mysql_fetch_array($tbl_delivery_buffer);
											
												$sub_total_quantity = format_angka($data_tbl_sales_order_detail['sub_total_quantity'] + $data_tbl_delivery_buffer['total_buffer_stock']);
										?>
												<tr>
											<?php
												if ($data_tbl_delivery_distribution['delivery_distribution_status'] == "On Hold")
												{
											?>
													<td style="width: 3%;">
														<a class="btn btn-icon-only grey-cascade tooltips" data-toggle="modal" data-original-title="Proses" href="#bufferdeliveryschedule<?php echo $data_tbl_delivery_distribution['delivery_distribution_id'] ?>">
														<i class="fa fa-cogs"></i></a>
													</td>
											<?php
												}
												elseif ($data_tbl_delivery_distribution['delivery_distribution_status'] == "On Site")
												{
											?>
													<td style="width: 3%;">
														<a class="btn btn-icon-only grey-cascade tooltips" data-original-title="Ubah" href="?alimms=delivery-distribution&tib=form-view-delivery-distribution&delivery_distribution_id=<?php echo $data_tbl_delivery_distribution['delivery_distribution_id'] ?>">
														<i class="fa fa-search"></i></a>
													</td>
											<?php
												}
												else
												{
											?>
													<td style="width: 3%;">
														<a class="btn btn-icon-only grey-cascade tooltips" data-original-title="Ubah" href="?alimms=delivery-distribution&tib=form-edit-delivery-distribution&delivery_distribution_id=<?php echo $data_tbl_delivery_distribution['delivery_distribution_id'] ?>">
														<i class="fa fa-pencil"></i></a>
													</td>
											<?php
												}
											?>
													<td style="width: 3%;">
														<?php echo $no ?>
													</td>
													<td>
														(<?php echo $data_tbl_delivery_distribution['delivery_vehicle_license'] ?>) <?php echo $data_tbl_delivery_distribution['delivery_vehicle_name'] ?><br />
														<?php echo $delivery_schedule_date_indo ?> - <?php echo $data_tbl_delivery_distribution['delivery_session_name'] ?>
													</td>
													<td>
														<?php echo $data_tbl_delivery_distribution['driver_name'] ?>
													</td>
													<td>
														<?php echo $data_tbl_delivery_distribution['helper_one_name'] ?>
												<?php
													if ($data_tbl_delivery_distribution['helper_two_name'] == "")
													{
												?>
												<?php
													}
													else
													{
												?>
														<br /><?php echo $data_tbl_delivery_distribution['helper_two_name'] ?>
												<?php
													}
												?>
												<?php
													if ($data_tbl_delivery_distribution['helper_three_name'] == "")
													{
												?>
												<?php
													}
													else
													{
												?>
														<br /><?php echo $data_tbl_delivery_distribution['helper_three_name'] ?>
												<?php
													}
												?>
													</td>
													<td>
												<?php
													$tbl_customer_districts = mysql_query("SELECT f.customer_districts_name FROM delivery_plan a, sales_invoice b, sales_order c, sales_request d, customer e, customer_districts f WHERE a.delivery_schedule_id = '".$data_tbl_delivery_distribution['delivery_schedule_id']."' AND a.delivery_session_id = '".$data_tbl_delivery_distribution['delivery_session_id']."' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id = c.sales_order_id AND c.sales_request_id = d.sales_request_id AND d.customer_id = e.customer_id AND e.customer_districts_id = f.customer_districts_id");
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
												$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity) AS total_quantity, SUM(c.sales_order_detail_bonus) AS total_bonus FROM delivery_plan a, sales_invoice b, sales_order_detail c WHERE a.delivery_schedule_id = '".$data_tbl_delivery_distribution['delivery_schedule_id']."' AND a.delivery_session_id = '".$data_tbl_delivery_distribution['delivery_session_id']."' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id = c.sales_order_id AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
												$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
												
												$total_quantity = format_angka($data_tbl_sales_order_detail['total_quantity']);
												$total_bonus = format_angka($data_tbl_sales_order_detail['total_bonus']);
												
												$tbl_delivery_buffer = mysql_query("SELECT delivery_buffer_stock FROM delivery_buffer WHERE delivery_distribution_id = '".$data_tbl_delivery_distribution['delivery_distribution_id']."' AND product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
												$data_tbl_delivery_buffer = mysql_fetch_array($tbl_delivery_buffer);
												
												$delivery_buffer_stock = format_angka($data_tbl_delivery_buffer['delivery_buffer_stock']);
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
														Bonus (<?php echo $total_bonus ?>) Crt +<br />
												<?php
													if ($data_tbl_delivery_buffer['delivery_buffer_stock'] == "")
													{
												?>
														Buffer <span class="label label-primary label-sm">On Hold</span>
												<?php
													}
													else
													{
												?>
														Buffer (<?php echo $delivery_buffer_stock ?>) Crt
												<?php
													}
												?>
												<?php
													}
												?>
													</td>
										<?php
											}
										?>
													<td>
														<?php echo $sub_total_quantity ?> Crt
													</td>
													<td>
												<?php
													if ($data_tbl_delivery_distribution['delivery_distribution_status'] == "On Hold")
													{
												?>
														<span class="label label-primary label-sm">On Hold</span>
												<?php
													}
													elseif ($data_tbl_delivery_distribution['delivery_distribution_status'] == "Loading")
													{
												?>
														<span class="label label-info label-sm">Loading</span>
												<?php
													}
													elseif ($data_tbl_delivery_distribution['delivery_distribution_status'] == "Handling")
													{
												?>
														<span class="label label-warning label-sm">Handling</span>
												<?php
													}
													else
													{
														$tbl_delivery_visit_delivered = mysql_query("SELECT COUNT(b.sales_invoice_id) AS total_quantity FROM delivery_visit a, delivery_plan b, delivery_distribution c, delivery_cheque d WHERE a.delivery_visit_status = 'Delivered' AND c.delivery_distribution_id = '".$data_tbl_delivery_distribution['delivery_distribution_id']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.delivery_schedule_id = c.delivery_schedule_id AND b.delivery_session_id = c.delivery_session_id AND c.delivery_distribution_id = d.delivery_distribution_id");
														$data_tbl_delivery_visit_delivered = mysql_fetch_array($tbl_delivery_visit_delivered);
				
														$tbl_delivery_visit_not_delivered = mysql_query("SELECT COUNT(b.sales_invoice_id) AS total_quantity FROM delivery_visit a, delivery_plan b, delivery_distribution c, delivery_cheque d WHERE a.delivery_visit_status = 'Not Delivered' AND c.delivery_distribution_id = '".$data_tbl_delivery_distribution['delivery_distribution_id']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.delivery_schedule_id = c.delivery_schedule_id AND b.delivery_session_id = c.delivery_session_id AND c.delivery_distribution_id = d.delivery_distribution_id");
														$data_tbl_delivery_visit_not_delivered = mysql_fetch_array($tbl_delivery_visit_not_delivered);
												?>
														<span class="label label-success label-sm">Delivered : <?php echo $data_tbl_delivery_visit_delivered['total_quantity'] ?></span><br />
														<span class="label label-danger label-sm">Not Delivered : <?php echo $data_tbl_delivery_visit_not_delivered['total_quantity'] ?></span>
												<?php
													}
												?>
													</td>
												</tr>
												<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="bufferdeliveryschedule<?php echo $data_tbl_delivery_distribution['delivery_distribution_id'] ?>">
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
																<button type="button" class="btn green-meadow btn-sm" onclick="location.href='?alimms=delivery-distribution&tib=form-buffer-delivery-distribution&delivery_distribution_id=<?php echo $data_tbl_delivery_distribution['delivery_distribution_id'] ?>'"><i class="fa fa-check"></i> Ya</button>
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
	function form_buffer_delivery_distribution()
	{
		$tbl_delivery_distribution = mysql_query("SELECT delivery_distribution_id FROM delivery_distribution WHERE delivery_distribution_id = '".$_GET['delivery_distribution_id']."'");
		$data_tbl_delivery_distribution = mysql_fetch_array($tbl_delivery_distribution);
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" id="form_sample_3" method="post" action="?alimms=delivery-distribution&tib=buffer-delivery-distribution">
				<input type="hidden" class="form-control" name="delivery_distribution_id" value="<?php echo $data_tbl_delivery_distribution['delivery_distribution_id'] ?>" />
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Distribusi Pengiriman</span>
							</div>
							<div class="actions btn-set">
								<button type="submit" class="btn green-meadow"><i class="fa fa-check"></i> Simpan</button>
								<button type="button" class="btn red-sunglo" onclick="location.href='?alimms=delivery-distribution'"><i class="fa fa-times"></i> Batal</button>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="alert alert-info no-margin">
											<h4 class="form-section">Informasi Distribusi Pengiriman</h4>
											<div class="row">
										<?php
											$tbl_product_sell = mysql_query("SELECT product_sell_id, product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
											while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
											{
										?>
												<div class="col-md-4">
													<div class="form-group">
														<label class="control-label">Buffer Stok <?php echo $data_tbl_product_sell['product_sell_name'] ?> <span class="required">*</span></label>
														<input type="hidden" class="form-control" name="product_sell_id[]" value="<?php echo $data_tbl_product_sell['product_sell_id'] ?>" />
														<input type="text" class="form-control" placeholder="<?php echo $data_tbl_product_sell['product_sell_name'] ?>" name="delivery_buffer_stock[]" value="0" />
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
	function form_edit_delivery_distribution()
	{
		$tbl_delivery_distribution = mysql_query("SELECT delivery_distribution_id FROM delivery_distribution WHERE delivery_distribution_id = '".$_GET['delivery_distribution_id']."'");
		$data_tbl_delivery_distribution = mysql_fetch_array($tbl_delivery_distribution);
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" id="form_sample_3" method="post" action="?alimms=delivery-distribution&tib=edit-delivery-distribution">
				<input type="hidden" class="form-control" name="delivery_distribution_id" value="<?php echo $data_tbl_delivery_distribution['delivery_distribution_id'] ?>" />
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Distribusi Pengiriman</span>
							</div>
							<div class="actions btn-set">
								<button type="submit" class="btn green-meadow"><i class="fa fa-check"></i> Simpan</button>
								<button type="button" class="btn red-sunglo" onclick="location.href='?alimms=delivery-distribution'"><i class="fa fa-times"></i> Batal</button>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="alert alert-info no-margin">
											<h4 class="form-section">Informasi Distribusi Pengiriman</h4>
											<div class="row">
										<?php
											$tbl_product_sell = mysql_query("SELECT product_sell_id, product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
											while ($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
											{
												$tbl_delivery_buffer = mysql_query("SELECT delivery_buffer_stock FROM delivery_buffer WHERE delivery_distribution_id = '".$data_tbl_delivery_distribution['delivery_distribution_id']."' AND product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
												$data_tbl_delivery_buffer = mysql_fetch_array($tbl_delivery_buffer);
										?>
												<div class="col-md-4">
													<div class="form-group">
														<label class="control-label">Buffer Stok <?php echo $data_tbl_product_sell['product_sell_name'] ?> <span class="required">*</span></label>
														<input type="hidden" class="form-control" name="product_sell_id[]" value="<?php echo $data_tbl_product_sell['product_sell_id'] ?>" />
														<input type="text" class="form-control" placeholder="<?php echo $data_tbl_product_sell['product_sell_name'] ?>" name="delivery_buffer_stock[]" value="<?php echo $data_tbl_delivery_buffer['delivery_buffer_stock'] ?>" />
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
	function form_view_delivery_distribution()
	{
		$tbl_delivery_distribution = mysql_query("SELECT delivery_distribution_id FROM delivery_distribution WHERE delivery_distribution_id = '".$_GET['delivery_distribution_id']."'");
		$data_tbl_delivery_distribution = mysql_fetch_array($tbl_delivery_distribution);
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" id="form_sample_3">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Distribusi Pengiriman</span>
							</div>
							<div class="actions btn-set">
								<button type="button" class="btn red-sunglo" onclick="location.href='?alimms=delivery-distribution'"><i class="fa fa-sign-out"></i> Keluar</button>
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
												$tbl_delivery_plan = mysql_query("SELECT * FROM delivery_distribution a, delivery_plan b, sales_invoice c, sales_order d, sales_request e, customer f, customer_type g, customer_districts h WHERE e.sales_request_active = '1' AND f.customer_active = '1' AND g.customer_type_active = '1' AND h.customer_districts_active = '1' AND a.delivery_distribution_id = '".$data_tbl_delivery_distribution['delivery_distribution_id']."' AND a.delivery_schedule_id = b.delivery_schedule_id AND a.delivery_session_id = b.delivery_session_id AND b.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id AND d.sales_request_id = e.sales_request_id AND e.customer_id = f.customer_id AND f.customer_type_id = g.customer_type_id AND f.customer_districts_id = h.customer_districts_id ORDER BY c.sales_invoice_date DESC, c.sales_invoice_no");
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
														if ($data_tbl_delivery_plan['sales_invoice_status'] == "Delivered")
														{
													?>
															<span class="label label-success label-sm">Delivered</span>
													<?php
														}
														else
														{
													?>
															<span class="label label-danger label-sm">Pending</span>
													<?php
														}
													?>
														</td>
													</tr>
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
				</form>
			</div>
		</div>
<?php
	}
?>