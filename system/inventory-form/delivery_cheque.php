<?php
	function form_initial_delivery_cheque()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue-madison bold uppercase">Pengecekan Pengiriman</span>
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
											$tbl_delivery_cheque = mysql_query("SELECT a.delivery_cheque_id, a.delivery_cheque_status, b.delivery_distribution_id, i.delivery_schedule_id, i.delivery_schedule_date, i.driver_name, i.helper_one_name, i.helper_two_name, i.helper_three_name, j.delivery_vehicle_license, j.delivery_vehicle_name, k.delivery_session_id, k.delivery_session_name FROM delivery_cheque a, delivery_distribution b, delivery_plan c, sales_invoice d, sales_order e, sales_request f, customer g, customer_districts h, delivery_schedule i, delivery_vehicle j, delivery_session k WHERE f.sales_request_active = '1' AND g.customer_active = '1' AND h.customer_districts_active = '1' AND i.delivery_schedule_active = '1' AND j.delivery_vehicle_active = '1' AND k.delivery_session_active = '1' AND a.delivery_distribution_id = b.delivery_distribution_id AND b.delivery_schedule_id = c.delivery_schedule_id AND b.delivery_session_id = c.delivery_session_id AND c.sales_invoice_id = d.sales_invoice_id AND d.sales_order_id = e.sales_order_id AND e.sales_request_id = f.sales_request_id AND f.customer_id = g.customer_id AND g.customer_districts_id = h.customer_districts_id AND c.delivery_schedule_id = i.delivery_schedule_id AND i.delivery_vehicle_id = j.delivery_vehicle_id AND c.delivery_session_id = k.delivery_session_id GROUP BY i.delivery_schedule_id, k.delivery_session_id ORDER BY j.delivery_vehicle_id");
											while ($data_tbl_delivery_cheque = mysql_fetch_array($tbl_delivery_cheque))
											{
												$delivery_schedule_date_indo = tanggal_indo($data_tbl_delivery_cheque['delivery_schedule_date']);
												
												$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity + c.sales_order_detail_bonus) AS sub_total_quantity FROM delivery_plan a, sales_invoice b, sales_order_detail c WHERE a.delivery_schedule_id = '".$data_tbl_delivery_cheque['delivery_schedule_id']."' AND a.delivery_session_id = '".$data_tbl_delivery_cheque['delivery_session_id']."' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id = c.sales_order_id");
												$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
												
												$tbl_delivery_buffer = mysql_query("SELECT SUM(delivery_buffer_stock) AS total_buffer_stock FROM delivery_buffer WHERE delivery_distribution_id = '".$data_tbl_delivery_cheque['delivery_distribution_id']."'");
												$data_tbl_delivery_buffer = mysql_fetch_array($tbl_delivery_buffer);
											
												$sub_total_quantity = format_angka($data_tbl_sales_order_detail['sub_total_quantity'] + $data_tbl_delivery_buffer['total_buffer_stock']);
										?>
												<tr>
											<?php
												if ($data_tbl_delivery_cheque['delivery_cheque_status'] == "On Hold")
												{
											?>
													<td style="width: 3%;">
														<a class="btn btn-icon-only grey-cascade tooltips" data-toggle="modal" data-original-title="Proses" href="#faultyloadingdeliverycheque<?php echo $data_tbl_delivery_cheque['delivery_cheque_id'] ?>">
														<i class="fa fa-cogs"></i></a>
													</td>
											<?php
												}
												else
												{
											?>
													<td style="width: 3%;">
														<a class="btn btn-icon-only grey-cascade tooltips" data-original-title="Ubah" href="?alimms=delivery-cheque&tib=form-edit-delivery-cheque&delivery_cheque_id=<?php echo $data_tbl_delivery_cheque['delivery_cheque_id'] ?>">
														<i class="fa fa-pencil"></i></a>
													</td>
											<?php
												}
											?>
													<td style="width: 3%;">
														<?php echo $no ?>
													</td>
													<td>
														(<?php echo $data_tbl_delivery_cheque['delivery_vehicle_license'] ?>) <?php echo $data_tbl_delivery_cheque['delivery_vehicle_name'] ?><br />
														<?php echo $delivery_schedule_date_indo ?> - <?php echo $data_tbl_delivery_cheque['delivery_session_name'] ?>
													</td>
													<td>
														<?php echo $data_tbl_delivery_cheque['driver_name'] ?>
													</td>
													<td>
														<?php echo $data_tbl_delivery_cheque['helper_one_name'] ?>
												<?php
													if ($data_tbl_delivery_cheque['helper_two_name'] == "")
													{
												?>
												<?php
													}
													else
													{
												?>
														<br /><?php echo $data_tbl_delivery_cheque['helper_two_name'] ?>
												<?php
													}
												?>
												<?php
													if ($data_tbl_delivery_cheque['helper_three_name'] == "")
													{
												?>
												<?php
													}
													else
													{
												?>
														<br /><?php echo $data_tbl_delivery_cheque['helper_three_name'] ?>
												<?php
													}
												?>
													</td>
													<td>
												<?php
													$tbl_customer_districts = mysql_query("SELECT f.customer_districts_name FROM delivery_plan a, sales_invoice b, sales_order c, sales_request d, customer e, customer_districts f WHERE a.delivery_schedule_id = '".$data_tbl_delivery_cheque['delivery_schedule_id']."' AND a.delivery_session_id = '".$data_tbl_delivery_cheque['delivery_session_id']."' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id = c.sales_order_id AND c.sales_request_id = d.sales_request_id AND d.customer_id = e.customer_id AND e.customer_districts_id = f.customer_districts_id");
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
												$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_quantity) AS total_quantity, SUM(c.sales_order_detail_bonus) AS total_bonus FROM delivery_plan a, sales_invoice b, sales_order_detail c WHERE a.delivery_schedule_id = '".$data_tbl_delivery_cheque['delivery_schedule_id']."' AND a.delivery_session_id = '".$data_tbl_delivery_cheque['delivery_session_id']."' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id = c.sales_order_id AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
												$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
												
												$total_quantity = format_angka($data_tbl_sales_order_detail['total_quantity']);
												$total_bonus = format_angka($data_tbl_sales_order_detail['total_bonus']);
												
												$tbl_delivery_buffer = mysql_query("SELECT delivery_buffer_stock FROM delivery_buffer WHERE delivery_distribution_id = '".$data_tbl_delivery_cheque['delivery_distribution_id']."' AND product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
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
													if ($data_tbl_delivery_cheque['delivery_cheque_status'] == "On Hold")
													{
												?>
														<span class="label label-primary label-sm">On Hold</span>
												<?php
													}
													elseif ($data_tbl_delivery_cheque['delivery_cheque_status'] == "Loading")
													{
												?>
														<span class="label label-info label-sm">Loading</span>
												<?php
													}
													elseif ($data_tbl_delivery_cheque['delivery_cheque_status'] == "Handling")
													{
												?>
														<span class="label label-warning label-sm">Handling</span>
												<?php
													}
													else
													{
														$tbl_delivery_visit_delivered = mysql_query("SELECT COUNT(b.sales_invoice_id) AS total_quantity FROM delivery_visit a, delivery_plan b, delivery_distribution c, delivery_cheque d WHERE a.delivery_visit_status = 'Delivered' AND d.delivery_cheque_id = '".$data_tbl_delivery_cheque['delivery_cheque_id']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.delivery_schedule_id = c.delivery_schedule_id AND b.delivery_session_id = c.delivery_session_id AND c.delivery_distribution_id = d.delivery_distribution_id");
														$data_tbl_delivery_visit_delivered = mysql_fetch_array($tbl_delivery_visit_delivered);
				
														$tbl_delivery_visit_not_delivered = mysql_query("SELECT COUNT(b.sales_invoice_id) AS total_quantity FROM delivery_visit a, delivery_plan b, delivery_distribution c, delivery_cheque d WHERE a.delivery_visit_status = 'Not Delivered' AND d.delivery_cheque_id = '".$data_tbl_delivery_cheque['delivery_cheque_id']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.delivery_schedule_id = c.delivery_schedule_id AND b.delivery_session_id = c.delivery_session_id AND c.delivery_distribution_id = d.delivery_distribution_id");
														$data_tbl_delivery_visit_not_delivered = mysql_fetch_array($tbl_delivery_visit_not_delivered);
												?>
														<span class="label label-success label-sm">Delivered : <?php echo $data_tbl_delivery_visit_delivered['total_quantity'] ?></span><br />
														<span class="label label-danger label-sm">Not Delivered : <?php echo $data_tbl_delivery_visit_not_delivered['total_quantity'] ?></span>
												<?php
													}
												?>
													</td>
												</tr>
												<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="faultyloadingdeliverycheque<?php echo $data_tbl_delivery_cheque['delivery_cheque_id'] ?>">
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
																<button type="button" class="btn green-meadow btn-sm" onclick="location.href='?alimms=delivery-cheque&tib=form-faulty-loading-delivery-cheque&delivery_cheque_id=<?php echo $data_tbl_delivery_cheque['delivery_cheque_id'] ?>'"><i class="fa fa-check"></i> Ya</button>
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
	function form_faulty_loading_delivery_cheque()
	{
		$tbl_delivery_cheque = mysql_query("SELECT delivery_cheque_id, delivery_distribution_id FROM delivery_cheque WHERE delivery_cheque_id = '".$_GET['delivery_cheque_id']."'");
		$data_tbl_delivery_cheque = mysql_fetch_array($tbl_delivery_cheque);
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" id="form_sample_3" method="post" action="?alimms=delivery-cheque&tib=faulty-loading-delivery-cheque">
				<input type="hidden" class="form-control" name="delivery_cheque_id" value="<?php echo $data_tbl_delivery_cheque['delivery_cheque_id'] ?>" />
				<input type="hidden" class="form-control" name="delivery_distribution_id" value="<?php echo $data_tbl_delivery_cheque['delivery_distribution_id'] ?>" />
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Pengecekan Pengiriman</span>
							</div>
							<div class="actions btn-set">
								<button type="submit" class="btn green-meadow"><i class="fa fa-check"></i> Simpan</button>
								<button type="button" class="btn red-sunglo" onclick="location.href='?alimms=delivery-cheque'"><i class="fa fa-times"></i> Batal</button>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="alert alert-info no-margin">
											<h4 class="form-section">Informasi Pengecekan Pengiriman</h4>
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
														<input type="text" class="form-control" placeholder="<?php echo $data_tbl_product_sell['product_sell_name'] ?>" name="delivery_damage_loading[]" value="0" />
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