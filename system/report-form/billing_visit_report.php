<?php
	function form_search_by_billingman_in_value_billing_visit_report()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" id="form_sample_3" method="post" action="?alimms=billing-visit-report&tib=form-result-by-billingman-in-value-billing-visit-report">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Laporan Penagihan</span>
								<span class="caption-helper">By Billingman In Value</span>
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
														<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="Tanggal" name="billing_visit_date" />
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
	function form_result_by_billingman_in_value_billing_visit_report()
	{
		$billingvisitDate = explode("-", $_POST['billing_visit_date']);
		$DatebillingvisitDate = $billingvisitDate[0];
		$MonthbillingvisitDate = $billingvisitDate[1];
		$YearbillingvisitDate = $billingvisitDate[2];
		$billing_visit_date = date("Y-m-d", mktime(0, 0, 0, $MonthbillingvisitDate, $DatebillingvisitDate, $YearbillingvisitDate));
		
		$billing_visit_date_indo = tanggal_indo($billing_visit_date);
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" id="form_sample_3" method="post" action="?alimms=billing-visit-report&tib=form-result-by-billingman-in-value-billing-visit-report">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Laporan Penagihan</span>
								<span class="caption-helper">By Billingman In Value</span>
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
														<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="Tanggal" name="billing_visit_date" value="<?php echo $_POST['billing_visit_date'] ?>" />
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
															Laporan Penagihan<br />
															By Billingman In Value 
															<span class="muted">Periode <?php echo $billing_visit_date_indo ?></span>
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
																		Faktur
																	</th>
																	<th rowspan=2>
																		Salesman
																	</th>
																	<th rowspan=2>
																		Pelanggan
																	</th>
																	<th rowspan=2>
																		Alamat
																	</th>
																	<th colspan="2">
																		Kunjungan
																	</th>
																	<th rowspan="2">
																		Durasi Waktu
																	</th>
																	<th rowspan=2>
																		Total Faktur
																	</th>
																	<th colspan=3>
																		Pembayaran
																	</th>
																	<th rowspan=2>
																		Keterangan
																	</th>
																	<th rowspan=2>
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
															<?php
																$tbl_payment_type = mysql_query("SELECT payment_type_id, payment_type_name FROM payment_type WHERE payment_type_active = '1' ORDER BY payment_type_id");
																while($data_tbl_payment_type = mysql_fetch_array($tbl_payment_type))
																{
															?>
																	<th>
																		<?php echo $data_tbl_payment_type['payment_type_name'] ?>
																	</th>
															<?php
																}
															?>
																</tr>
															</thead>
															<tbody>
														<?php
															$no = 1;
															$tbl_billing_work_plan_detail = mysql_query("SELECT a.billing_work_plan_detail_id, a.sales_invoice_no, a.sales_invoice_date, a.billing_work_plan_detail_total_price, c.user_name, d.customer_code, d.customer_name, d.customer_address, e.customer_category_name, f.customer_districts_name FROM billing_work_plan_detail a, billing_work_plan b, user c, customer d, customer_category e, customer_districts f WHERE b.billing_work_plan_date = '".$billing_visit_date."' AND a.billing_work_plan_id = b.billing_work_plan_id AND a.salesman_id = c.user_id AND a.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id ORDER BY a.billing_work_plan_detail_id");
															while ($data_tbl_billing_work_plan_detail = mysql_fetch_array($tbl_billing_work_plan_detail))
															{
																$sales_invoice_date_indo = tanggal_indo($data_tbl_billing_work_plan_detail['sales_invoice_date']);
																$billing_work_plan_detail_total_price = format_angka($data_tbl_billing_work_plan_detail['billing_work_plan_detail_total_price']);
																
																$tbl_billing_visit = mysql_query("SELECT timediff(billing_visit_time_out, billing_visit_time_in) AS time_duration, billing_visit_time_in, billing_visit_time_out, billing_visit_description, billing_visit_status FROM billing_visit WHERE billing_work_plan_detail_id = '".$data_tbl_billing_work_plan_detail['billing_work_plan_detail_id']."'");
																$data_tbl_billing_visit = mysql_fetch_array($tbl_billing_visit);
				
																$tbl_billing_visit_detail = mysql_query("SELECT a.billing_visit_detail_description FROM billing_visit_detail a, billing_visit b WHERE a.billing_visit_id = b.billing_visit_id AND b.billing_work_plan_detail_id = '".$data_tbl_billing_work_plan_detail['billing_work_plan_detail_id']."'");
																$data_tbl_billing_visit_detail = mysql_fetch_array($tbl_billing_visit_detail);
														?>
																<tr>
																	<td style="width: 3%;">
																		<?php echo $no ?>
																	</td>
																	<td>
																		<?php echo $data_tbl_billing_work_plan_detail['sales_invoice_no'] ?><br />
																		<?php echo $sales_invoice_date_indo ?>
																	</td>
																	<td>
																		<?php echo $data_tbl_billing_work_plan_detail['user_name'] ?>
																	</td>
																	<td>
																		<?php echo $data_tbl_billing_work_plan_detail['customer_category_name'] ?><br /> 
																		<?php echo $data_tbl_billing_work_plan_detail['customer_code'] ?> - <?php echo $data_tbl_billing_work_plan_detail['customer_name'] ?> (<?php echo $data_tbl_billing_work_plan_detail['customer_districts_name'] ?>)
																	</td>
																	<td>
																		<?php echo $data_tbl_billing_work_plan_detail['customer_address'] ?>
																	</td>
																	<td>
																		<?php echo $data_tbl_billing_visit['billing_visit_time_in'] ?>
																	</td>
																	<td>
																		<?php echo $data_tbl_billing_visit['billing_visit_time_out'] ?>
																	</td>
																	<td>
																		<?php echo $data_tbl_billing_visit['time_duration'] ?>
																	</td>
																	<td>
																		<?php echo $billing_work_plan_detail_total_price ?>
																	</td>
															<?php
																$tbl_payment_type = mysql_query("SELECT payment_type_id, payment_type_name FROM payment_type WHERE payment_type_active = '1' ORDER BY payment_type_id");
																while($data_tbl_payment_type = mysql_fetch_array($tbl_payment_type))
																{
																	$tbl_billing_visit_detaila = mysql_query("SELECT SUM(a.billing_visit_detail_total_price) AS total_price FROM billing_visit_detail a, billing_visit b WHERE a.billing_visit_id = b.billing_visit_id AND b.billing_work_plan_detail_id = '".$data_tbl_billing_work_plan_detail['billing_work_plan_detail_id']."' AND a.payment_type_id = '".$data_tbl_payment_type['payment_type_id']."'");
																	$data_tbl_billing_visit_detaila = mysql_fetch_array($tbl_billing_visit_detaila);
																	$billing_visit_detail_total_price = format_angka($data_tbl_billing_visit_detaila['total_price']);
															?>
																	<td>
																		<?php echo $billing_visit_detail_total_price ?>
																	</td>
															<?php
																}
															?>
																	<td>
																		<?php echo $data_tbl_billing_visit_detail['billing_visit_detail_description'] ?>
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
																		<span class="label label-success label-sm">Paid</span>
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
														<?php
															$no++;
															}
														?>
															</tbody>
															<thead>
																<tr>
																	<th colspan="7">
																		Grand Total
																	</th>
																<?php
																	$tbl_billing_visit = mysql_query("SELECT SEC_TO_TIME(SUM((TIME_TO_SEC(TIMEDIFF(a.billing_visit_time_out, a.billing_visit_time_in))))) AS time_duration FROM billing_visit a, billing_work_plan_detail b, billing_work_plan c WHERE c.billing_work_plan_active = '1' AND c.billing_work_plan_date = '".$billing_visit_date."' AND a.billing_work_plan_detail_id = b.billing_work_plan_detail_id AND b.billing_work_plan_id = c.billing_work_plan_id");
																	$data_tbl_billing_visit = mysql_fetch_array($tbl_billing_visit);
																?>
																	<th>
																		<?php echo $data_tbl_billing_visit['time_duration'] ?>
																	</th>
																<?php
																	$tbl_billing_work_plan_detail = mysql_query("SELECT SUM(a.billing_work_plan_detail_total_price) AS total_price FROM billing_work_plan_detail a, billing_work_plan b WHERE a.billing_work_plan_id = b.billing_work_plan_id AND b.billing_work_plan_date = '".$billing_visit_date."'");
																	$data_tbl_billing_work_plan_detail = mysql_fetch_array($tbl_billing_work_plan_detail);
																	$billing_work_plan_detail_total_price_all = format_angka($data_tbl_billing_work_plan_detail['total_price']);
																?>
																	<th>
																		<?php echo $billing_work_plan_detail_total_price_all ?>
																	</th>
															<?php
																$tbl_payment_type = mysql_query("SELECT payment_type_id, payment_type_name FROM payment_type WHERE payment_type_active = '1' ORDER BY payment_type_id");
																while($data_tbl_payment_type = mysql_fetch_array($tbl_payment_type))
																{
																	$tbl_billing_visit_detail = mysql_query("SELECT SUM(a.billing_visit_detail_total_price) AS total_price FROM billing_visit_detail a, billing_visit b, billing_work_plan_detail c, billing_work_plan d WHERE a.billing_visit_id = b.billing_visit_id AND b.billing_work_plan_detail_id = c.billing_work_plan_detail_id AND c.billing_work_plan_id = d.billing_work_plan_id AND a.payment_type_id = '".$data_tbl_payment_type['payment_type_id']."' AND d.billing_work_plan_date = '".$billing_visit_date."'");
																	$data_tbl_billing_visit_detail = mysql_fetch_array($tbl_billing_visit_detail);
																	$billing_visit_detail_total_price_all = format_angka($data_tbl_billing_visit_detail['total_price']);
															?>
																	<th>
																		<?php echo $billing_visit_detail_total_price_all ?>
																	</th>
															<?php
																}
															?>
																	<th colspan="2">
																	</th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
												<div class="row">
													<div class="col-xs-12 invoice-block">
														<a class="btn green-meadow btn-sm" data-toggle="modal" href="#printbybillingmaninvaluebillingvisitreport">
														<i class="fa fa-print"></i> Cetak
														</a>
													</div>
												</div>
												<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="printbybillingmaninvaluebillingvisitreport">
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
																<button type="button" class="btn green-meadow btn-sm" data-dismiss="modal" onclick="location.href='../system/printable-version/billing_visit_report.php?alimms=billing-visit-report&tib=form-print-by-billingman-in-value-billing-visit-report&billing_visit_date=<?php echo $_POST['billing_visit_date'] ?>'"><i class="fa fa-check"></i> Ya</button>
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