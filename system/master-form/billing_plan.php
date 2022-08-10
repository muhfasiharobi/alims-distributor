<?php
	function form_initial_billing_plan()
	{
?>
		<div class="page-fixed-main-content">	 
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Rencana Penagihan
								</span>
							</div>
							<div class="actions">
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=billing-plan&tib=form-add-billing-plan">
									<i class="fa fa-plus"></i>
									Tambah
								</a>
							</div>
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
											Salesman
										</th>
										<th>
											Tanggal
										</th>
										<th>
											Belum Terbayar
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_billing_plan = mysql_query("SELECT a.billing_plan_id, a.billing_plan_date, b.user_name FROM billing_plan a, user b WHERE a.billing_plan_active = '1' AND b.user_active = '1' AND a.salesman_id = b.user_id ORDER BY a.billing_plan_date DESC");
									while ($data_tbl_billing_plan = mysql_fetch_array($tbl_billing_plan))
									{
										$billing_plan_date_indo = tanggal_indo($data_tbl_billing_plan['billing_plan_date']);
										
										$tbl_sales_order_detail = mysql_query("SELECT SUM((c.sales_order_detail_product_sell_quantity * (c.sales_order_detail_product_sell_price - c.sales_order_detail_piece_discount - c.sales_order_detail_cash_discount)) + ((c.sales_order_detail_product_sell_quantity + c.sales_order_detail_program_bonus) * c.sales_order_detail_delivery_cost_price)) AS product_sell_total FROM billing_plan_detail a, sales_invoice b, sales_order_detail c WHERE a.billing_plan_id = '".$data_tbl_billing_plan['billing_plan_id']."' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id = c.sales_order_id");
										$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
										
										$tbl_payment_order_detail = mysql_query("SELECT SUM(c.payment_order_detail_payment_nominal) AS payment_order_detail_payment_nominal FROM billing_plan_detail a, payment_order b, payment_order_detail c WHERE a.billing_plan_id = '".$data_tbl_billing_plan['billing_plan_id']."' AND a.sales_invoice_id = b.sales_invoice_id AND b.payment_order_id = c.payment_order_id");
										$data_tbl_payment_order_detail = mysql_fetch_array($tbl_payment_order_detail);
										
										$remaining_payment_nominal = $data_tbl_sales_order_detail['product_sell_total'] - $data_tbl_payment_order_detail['payment_order_detail_payment_nominal'];
										$remaining_payment_nominal_rupiah_indo = format_angka($remaining_payment_nominal);
								?>
									<tr class="odd gradeX">
										<td>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=billing-plan&tib=form-view-billing-plan&billing_plan_id=<?php echo $data_tbl_billing_plan['billing_plan_id'] ?>">
												<i class="fa fa-search"></i>
											</a>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=billing-plan&tib=form-edit-billing-plan&billing_plan_id=<?php echo $data_tbl_billing_plan['billing_plan_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_billing_plan_id_<?php echo $data_tbl_billing_plan['billing_plan_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										</td>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_billing_plan['user_name'] ?>
										</td>
										<td>
											<?php echo $billing_plan_date_indo ?>
										</td>
										<td>
											<?php echo $remaining_payment_nominal_rupiah_indo ?>
										</td>
									</tr>
									<div aria-hidden="true" class="modal fade" id="delete_billing_plan_id_<?php echo $data_tbl_billing_plan['billing_plan_id'] ?>" role="basic" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">
														Konfirmasi
													</h4>
                                                </div>
                                                <div class="modal-body">
													Apakah Anda Yakin Ingin Menghapus Data Ini ?
												</div>
                                                <div class="modal-footer">
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=billing-plan&tib=delete-billing-plan&billing_plan_id=<?php echo $data_tbl_billing_plan['billing_plan_id'] ?>">
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
	function form_add_billing_plan()
	{
		$tgl_sekarang_indo = date("d-m-Y");
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Rencana Penagihan
								</span>
							</div>
						</div>
						<div class="portlet-body form">
							<form action="?alimms=billing-plan&tib=add-billing-plan" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<h4 class="form-section">
										Rencana Penagihan
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Salesman
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-placeholder="Salesman" name="salesman_id">
													<option value=""></option>
													<?php
														$tbl_user = mysql_query("SELECT a.user_id, a.user_name FROM user a, user_category b WHERE a.user_active = '1' AND b.user_category_active = '1' AND a.user_category_id = b.user_category_id AND b.user_category_name LIKE 'Billingman%' ORDER BY a.user_name");
														while($data_tbl_user = mysql_fetch_array($tbl_user))
														{
													?>
														<option value="<?php echo $data_tbl_user['user_id'] ?>"><?php echo $data_tbl_user['user_name'] ?></option>
													<?php	
														}
													?>
												</select>
												<div id="salesman_id"></div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Tanggal
													<span class="required">
														*
													</span>
												</label>
												<input class="date-picker form-control" data-date-format="dd-mm-yyyy" name="billing_plan_date" data-date-start-date="+0d" placeholder="Tanggal" type="text" value="<?php echo $tgl_sekarang_indo ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-feed"></i>
										Proses
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=billing-plan'">
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
	function form_invoice_billing_plan()
	{
		$tbl_billing_plan = mysql_query("SELECT a.billing_plan_id, a.billing_plan_date, b.user_name FROM billing_plan a, user b WHERE a.billing_plan_id = '".$_GET['billing_plan_id']."' AND a.salesman_id = b.user_id");
		$data_tbl_billing_plan = mysql_fetch_array($tbl_billing_plan);
		
		$billing_plan_date_indo = tanggal_indo($data_tbl_billing_plan['billing_plan_date']);
		
		$tbl_payment_overdue = mysql_query("SELECT payment_overdue_day FROM payment_overdue WHERE payment_overdue_active = '1'");
		$data_tbl_payment_overdue = mysql_fetch_array($tbl_payment_overdue);
		
		$payment_overdue_day = date("Y-m-d", mktime(0,0,0, date("m"), date("d") + $data_tbl_payment_overdue['payment_overdue_day'], date("Y")));
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_billing_plan['user_name'] ?>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $billing_plan_date_indo ?>
						</a>
					</li>
				</ul>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Rencana Penagihan
								</span>
							</div>
						</div>
						<div class="portlet-body form">
							<form action="?alimms=billing-plan&tib=invoice-billing-plan" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="billing_plan_id" type="hidden" value="<?php echo $data_tbl_billing_plan['billing_plan_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Faktur <?php echo $tgl_besok ?>
									</h4>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>
													Faktur
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-placeholder="Faktur" name="sales_invoice_id">
													<option value=""></option>
													<?php
														$tbl_sales_invoice = mysql_query("SELECT a.sales_invoice_id, a.sales_invoice_no, a.sales_invoice_date, a.sales_invoice_overdue_date, d.user_name, e.customer_code, e.customer_name, e.customer_address, f.customer_category_name, g.customer_districts_name FROM sales_invoice a, sales_order b, sales_request c, user d, customer e, customer_category f, customer_districts g WHERE a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.salesman_id = d.user_id AND c.customer_id = e.customer_id AND e.customer_category_id = f.customer_category_id AND e.customer_districts_id = g.customer_districts_id ORDER BY a.sales_invoice_no");
														while($data_tbl_sales_invoice = mysql_fetch_array($tbl_sales_invoice))
														{
															$sales_invoice_date_indo = tanggal_indo($data_tbl_sales_invoice['sales_invoice_date']);
															$sales_invoice_overdue_date_indo = tanggal_indo($data_tbl_sales_invoice['sales_invoice_overdue_date']);
													?>
														<option value="<?php echo $data_tbl_sales_invoice['sales_invoice_id'] ?>"><?php echo $data_tbl_sales_invoice['sales_invoice_no'] ?> - <?php echo $sales_invoice_date_indo ?> | <?php echo $data_tbl_sales_invoice['user_name'] ?> | <?php echo $data_tbl_sales_invoice['customer_category_name'] ?> - <?php echo $data_tbl_sales_invoice['customer_code'] ?> - <?php echo $data_tbl_sales_invoice['customer_name'] ?> - <?php echo $data_tbl_sales_invoice['customer_address'] ?> (<?php echo $data_tbl_sales_invoice['customer_districts_name'] ?>) | Jatuh Tempo <?php echo $sales_invoice_overdue_date_indo ?></option>
													<?php	
														}
													?>
												</select>
												<div id="sales_invoice_id"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
								<?php
									$tbl_billing_plan_detail = mysql_query("SELECT billing_plan_id FROM billing_plan_detail WHERE billing_plan_id = '".$data_tbl_billing_plan['billing_plan_id']."'");
									$jumlah_tbl_billing_plan_detail = mysql_num_rows($tbl_billing_plan_detail);
									
									if ($jumlah_tbl_billing_plan_detail > 0)
									{
								?>
									<button type="submit" class="btn btn-sm btn-outline blue sbold">
										<i class="fa fa-plus"></i>
										Tambah
									</button>
									<button type="button" class="btn btn-sm btn-outline green sbold" onclick="location.href='?alimms=billing-plan'">
										<i class="fa fa-check"></i>
										Selesai
									</button>
								<?php
									}
									else
									{
								?>
									<button type="submit" class="btn btn-sm btn-outline blue sbold">
										<i class="fa fa-plus"></i>
										Tambah
									</button>
								<?php
									}
								?>
								</div>
							</form>
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
											Faktur
										</th>
										<th>
											Salesman
										</th>
										<th>
											Pelanggan
										</th>
										<th>
											Kecamatan
										</th>
										<th>
											Cara Pembayaran
										</th>
										<th>
											Jatuh Tempo
										</th>
										<th>
											Belum Terbayar
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_billing_plan_detail = mysql_query("SELECT a.billing_plan_detail_id, b.sales_invoice_id, b.sales_invoice_no, b.sales_invoice_date, b.sales_invoice_overdue_date, c.sales_order_id, c.sales_order_overdue_day, d.sales_request_payment_method, e.user_name, f.customer_code, f.customer_name, g.customer_category_name, h.customer_districts_name FROM billing_plan_detail a, sales_invoice b, sales_order c, sales_request d, user e, customer f, customer_category g, customer_districts h WHERE d.sales_request_active = '1' AND e.user_active = '1' AND f.customer_active = '1' AND g.customer_category_active = '1' AND h.customer_districts_active = '1' AND a.billing_plan_id = '".$data_tbl_billing_plan['billing_plan_id']."' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id = c.sales_order_id AND c.sales_request_id = d.sales_request_id AND d.salesman_id = e.user_id AND d.customer_id = f.customer_id AND f.customer_category_id = g.customer_category_id AND f.customer_districts_id = h.customer_districts_id ORDER BY b.sales_invoice_no");
									while ($data_tbl_billing_plan_detail = mysql_fetch_array($tbl_billing_plan_detail))
									{
										$sales_invoice_date_indo = tanggal_indo($data_tbl_billing_plan_detail['sales_invoice_date']);
										$sales_invoice_overdue_date_indo = tanggal_indo($data_tbl_billing_plan_detail['sales_invoice_overdue_date']);
										
										$tbl_sales_order_detail = mysql_query("SELECT SUM((sales_order_detail_product_sell_quantity * (sales_order_detail_product_sell_price - sales_order_detail_piece_discount - sales_order_detail_cash_discount)) + ((sales_order_detail_product_sell_quantity + sales_order_detail_program_bonus) * sales_order_detail_delivery_cost_price)) AS product_sell_total FROM sales_order_detail WHERE sales_order_id = '".$data_tbl_billing_plan_detail['sales_order_id']."'");
										$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
										
										$tbl_payment_order_detail = mysql_query("SELECT SUM(b.payment_order_detail_payment_nominal) AS payment_order_detail_payment_nominal FROM payment_order a, payment_order_detail b WHERE a.payment_order_id = '".$data_tbl_billing_plan_detail['sales_invoice_id']."' AND a.payment_order_id = b.payment_order_id");
										$data_tbl_payment_order_detail = mysql_fetch_array($tbl_payment_order_detail);
										
										$remaining_payment_nominal = $data_tbl_sales_order_detail['product_sell_total'] - $data_tbl_payment_order_detail['payment_order_detail_payment_nominal'];
										$remaining_payment_nominal_rupiah_indo = format_angka($remaining_payment_nominal);
								?>
									<tr class="odd gradeX">
										<td>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#remove_billing_plan_detail_id_<?php echo $data_tbl_billing_plan_detail['billing_plan_detail_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										</td>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_billing_plan_detail['sales_invoice_no'] ?><br />
											<?php echo $sales_invoice_date_indo ?>
										</td>
										<td>
											<?php echo $data_tbl_billing_plan_detail['user_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_billing_plan_detail['customer_category_name'] ?> - 
											<?php echo $data_tbl_billing_plan_detail['customer_code'] ?> - <?php echo $data_tbl_billing_plan_detail['customer_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_billing_plan_detail['customer_districts_name'] ?>
										</td>
										<td>
										<?php
											if ($data_tbl_billing_plan_detail['sales_order_overdue_day'] == 0)
											{
										?>
											<?php echo $data_tbl_billing_plan_detail['sales_request_payment_method'] ?>
										<?php
											}
											else
											{
										?>
											<?php echo $data_tbl_billing_plan_detail['sales_request_payment_method'] ?> (<?php echo $data_tbl_billing_plan_detail['sales_order_overdue_day'] ?> Hari)
										<?php	
											}
										?>
										</td>
										<td>
											<?php echo $sales_invoice_overdue_date_indo ?>
										</td>
										<td>
											<?php echo $remaining_payment_nominal_rupiah_indo ?>
										</td>
									</tr>
									<div aria-hidden="true" class="modal fade" id="remove_billing_plan_detail_id_<?php echo $data_tbl_billing_plan_detail['billing_plan_detail_id'] ?>" role="basic" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">
														Konfirmasi
													</h4>
                                                </div>
                                                <div class="modal-body">
													Apakah Anda Yakin Ingin Menghapus Data Ini ?
												</div>
                                                <div class="modal-footer">
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=billing-plan&tib=remove-billing-plan&billing_plan_detail_id=<?php echo $data_tbl_billing_plan_detail['billing_plan_detail_id'] ?>">
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
	function form_edit_billing_plan()
	{
		$tbl_billing_plan = mysql_query("SELECT billing_plan_id, salesman_id, billing_plan_date FROM billing_plan WHERE billing_plan_id = '".$_GET['billing_plan_id']."'");
		$data_tbl_billing_plan = mysql_fetch_array($tbl_billing_plan);
		
		$billing_plan_date = explode("-", $data_tbl_billing_plan['billing_plan_date']);
		$date_billing_plan = $billing_plan_date[2];
		$month_billing_plan = $billing_plan_date[1];
		$year_billing_plan = $billing_plan_date[0];
		$billing_plan_date = date("d-m-Y", mktime(0, 0, 0, $month_billing_plan, $date_billing_plan, $year_billing_plan));
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Rencana Penagihan
								</span>
							</div>
						</div>
						<div class="portlet-body form">
							<form action="?alimms=billing-plan&tib=edit-billing-plan" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="billing_plan_id" type="hidden" value="<?php echo $data_tbl_billing_plan['billing_plan_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Rencana Penagihan
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Salesman
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-placeholder="Salesman" name="salesman_id">
													<option value=""></option>
													<?php
														$tbl_user = mysql_query("SELECT a.user_id, a.user_name FROM user a, user_category b WHERE a.user_active = '1' AND b.user_category_active = '1' AND a.user_category_id = b.user_category_id AND b.user_category_name LIKE 'Billingman%' ORDER BY a.user_name");
														while($data_tbl_user = mysql_fetch_array($tbl_user))
														{
															if ($data_tbl_user['user_id'] == $data_tbl_billing_plan['salesman_id'])
														{
													?>
															<option selected="selected" value="<?php echo $data_tbl_user['user_id'] ?>"><?php echo $data_tbl_user['user_name'] ?></option>
													<?php
															} 
															else 
															{
													?>
															<option value="<?php echo $data_tbl_user['user_id'] ?>"><?php echo $data_tbl_user['user_name'] ?></option>
													<?php
															}
														}
													?>
												</select>
												<div id="salesman_id"></div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Tanggal
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="billing_plan_date" placeholder="Tanggal" type="text" value="<?php echo $billing_plan_date ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-server"></i>
										Proses
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=billing-plan'">
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
	function form_view_billing_plan()
	{
		$tbl_billing_plan = mysql_query("SELECT a.billing_plan_id, a.billing_plan_date, b.user_name FROM billing_plan a, user b WHERE a.billing_plan_id = '".$_GET['billing_plan_id']."' AND a.salesman_id = b.user_id");
		$data_tbl_billing_plan = mysql_fetch_array($tbl_billing_plan);
		
		$billing_plan_date_indo = tanggal_indo($data_tbl_billing_plan['billing_plan_date']);
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_billing_plan['user_name'] ?>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascrip:;">
							<?php echo $billing_plan_date_indo ?>
						</a>
					</li>
				</ul>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Rencana Penagihan
								</span>
							</div>
							<div class="actions">
								<a class="btn btn-outline btn-sm sbold yellow" href="?alimms=billing-plan">
									<i class="fa fa-sign-out"></i>
									Keluar
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-bordered table-checkable table-hover table-striped order-column" id="sample_2">
								<thead>
									<tr>
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
											Kecamatan
										</th>
										<th>
											Cara Pembayaran
										</th>
										<th>
											Jatuh Tempo
										</th>
										<th>
											Belum Terbayar
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_billing_plan_detail = mysql_query("SELECT a.billing_plan_detail_id, b.sales_invoice_id, b.sales_invoice_no, b.sales_invoice_date, b.sales_invoice_overdue_date, c.sales_order_id, c.sales_order_overdue_day, d.sales_request_payment_method, e.user_name, f.customer_code, f.customer_name, g.customer_category_name, h.customer_districts_name FROM billing_plan_detail a, sales_invoice b, sales_order c, sales_request d, user e, customer f, customer_category g, customer_districts h WHERE d.sales_request_active = '1' AND e.user_active = '1' AND f.customer_active = '1' AND g.customer_category_active = '1' AND h.customer_districts_active = '1' AND a.billing_plan_id = '".$data_tbl_billing_plan['billing_plan_id']."' AND a.sales_invoice_id = b.sales_invoice_id AND b.sales_order_id = c.sales_order_id AND c.sales_request_id = d.sales_request_id AND d.salesman_id = e.user_id AND d.customer_id = f.customer_id AND f.customer_category_id = g.customer_category_id AND f.customer_districts_id = h.customer_districts_id ORDER BY b.sales_invoice_no");
									while ($data_tbl_billing_plan_detail = mysql_fetch_array($tbl_billing_plan_detail))
									{
										$sales_invoice_date_indo = tanggal_indo($data_tbl_billing_plan_detail['sales_invoice_date']);
										$sales_invoice_overdue_date_indo = tanggal_indo($data_tbl_billing_plan_detail['sales_invoice_overdue_date']);
										
										$tbl_sales_order_detail = mysql_query("SELECT SUM((sales_order_detail_product_sell_quantity * (sales_order_detail_product_sell_price - sales_order_detail_piece_discount - sales_order_detail_cash_discount)) + ((sales_order_detail_product_sell_quantity + sales_order_detail_program_bonus) * sales_order_detail_delivery_cost_price)) AS product_sell_total FROM sales_order_detail WHERE sales_order_id = '".$data_tbl_billing_plan_detail['sales_order_id']."'");
										$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
										
										$tbl_payment_order_detail = mysql_query("SELECT SUM(b.payment_order_detail_payment_nominal) AS payment_order_detail_payment_nominal FROM payment_order a, payment_order_detail b WHERE a.payment_order_id = '".$data_tbl_billing_plan_detail['sales_invoice_id']."' AND a.payment_order_id = b.payment_order_id");
										$data_tbl_payment_order_detail = mysql_fetch_array($tbl_payment_order_detail);
										
										$remaining_payment_nominal = $data_tbl_sales_order_detail['product_sell_total'] - $data_tbl_payment_order_detail['payment_order_detail_payment_nominal'];
										$remaining_payment_nominal_rupiah_indo = format_angka($remaining_payment_nominal);
								?>
									<tr class="odd gradeX">
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_billing_plan_detail['sales_invoice_no'] ?><br />
											<?php echo $sales_invoice_date_indo ?>
										</td>
										<td>
											<?php echo $data_tbl_billing_plan_detail['user_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_billing_plan_detail['customer_category_name'] ?> - 
											<?php echo $data_tbl_billing_plan_detail['customer_code'] ?> - <?php echo $data_tbl_billing_plan_detail['customer_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_billing_plan_detail['customer_districts_name'] ?>
										</td>
										<td>
										<?php
											if ($data_tbl_billing_plan_detail['sales_order_overdue_day'] == 0)
											{
										?>
											<?php echo $data_tbl_billing_plan_detail['sales_request_payment_method'] ?>
										<?php
											}
											else
											{
										?>
											<?php echo $data_tbl_billing_plan_detail['sales_request_payment_method'] ?> (<?php echo $data_tbl_billing_plan_detail['sales_order_overdue_day'] ?> Hari)
										<?php	
											}
										?>
										</td>
										<td>
											<?php echo $sales_invoice_overdue_date_indo ?>
										</td>
										<td>
											<?php echo $remaining_payment_nominal_rupiah_indo ?>
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
<?php
	}
?>