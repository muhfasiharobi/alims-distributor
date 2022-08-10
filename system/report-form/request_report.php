<?php
	function form_search_customer_city_by_customer_category_request_report()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Laporan Permintaan
								</span>
								<span class="caption-helper sbold uppercase">
									Per Kota/ Kabupaten Berdasarkan Kategori Pelanggan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=request-report&tib=form-view-customer-city-by-customer-category-request-report" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Dari Tanggal
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_request_from_date" placeholder="Dari Tanggal" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Sampai Tanggal
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_request_to_date" placeholder="Sampai Tanggal" type="text">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline purple sbold">
										<i class="fa fa-rss"></i>
										Proses
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
	function form_view_customer_city_by_customer_category_request_report()
	{
		$sales_request_from_date = explode("-", $_POST['sales_request_from_date']);
		$date_sales_request_from = $sales_request_from_date[0];
		$month_sales_request_from = $sales_request_from_date[1];
		$year_sales_request_from = $sales_request_from_date[2];
		$sales_request_from_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_request_from, $date_sales_request_from, $year_sales_request_from));
		
		$sales_request_from_date_indo = tanggal_indo($sales_request_from_date);
		
		$sales_request_to_date = explode("-", $_POST['sales_request_to_date']);
		$date_sales_request_to = $sales_request_to_date[0];
		$month_sales_request_to = $sales_request_to_date[1];
		$year_sales_request_to = $sales_request_to_date[2];
		$sales_request_to_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_request_to, $date_sales_request_to, $year_sales_request_to));
		
		$sales_request_to_date_indo = tanggal_indo($sales_request_to_date);
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Laporan Permintaan
								</span>
								<span class="caption-helper sbold uppercase">
									Per Kota/ Kabupaten Berdasarkan Kategori Pelanggan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=request-report&tib=form-view-customer-city-by-customer-category-request-report" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Dari Tanggal
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_request_from_date" placeholder="Dari Tanggal" type="text" value="<?php echo $_POST['sales_request_from_date'] ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Sampai Tanggal
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_request_to_date" placeholder="Sampai Tanggal" type="text" value="<?php echo $_POST['sales_request_to_date'] ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline purple sbold">
										<i class="fa fa-rss"></i>
										Proses
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
								<?php
									if ($_POST['sales_request_from_date'] == $_POST['sales_request_to_date'])
									{
								?>
									Tanggal <?php echo $sales_request_from_date_indo ?>
								<?php
									}
									else
									{
								?>
									Dari Tanggal <?php echo $sales_request_from_date_indo ?> Sampai Tanggal <?php echo $sales_request_to_date_indo ?>
								<?php
									}
								?>
								</span>
							</div>
						</div>
						<?php
							$tbl_customer_city = mysql_query("SELECT d.customer_city_id, d.customer_city_name FROM sales_request a, customer b, customer_districts c, customer_city d WHERE a.sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND a.sales_request_active = '1' AND b.customer_active = '1' AND c.customer_districts_active = '1' AND d.customer_city_active = '1' AND a.customer_id = b.customer_id AND b.customer_districts_id = c.customer_districts_id AND c.customer_city_id = d.customer_city_id GROUP BY d.customer_city_id ORDER BY d.customer_city_name");
							while($data_tbl_customer_city = mysql_fetch_array($tbl_customer_city))
							{
						?>
							<h5 class="font-red sbold uppercase">
								<?php echo $data_tbl_customer_city['customer_city_name'] ?>
							</h5>
							<div class="portlet-body">
								<div class="table-responsive">
									<table class="table table-bordered table-hover table-striped">
										<thead>
											<tr>
												<th>
													No
												</th>
												<th>
													Kecamatan
												</th>
												<?php
													$tbl_customer_category = mysql_query("SELECT customer_category_name FROM customer_category WHERE customer_category_active = '1' ORDER BY customer_category_name");
													while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
													{
												?>
													<th>
														<?php echo $data_tbl_customer_category['customer_category_name'] ?>
													</th>
												<?php
													}
												?>
											</tr>
										</thead>
										<tbody>
										<?php
											$no = 1;
											$tbl_customer_districts = mysql_query("SELECT c.customer_districts_id, c.customer_districts_name FROM sales_request a, customer b, customer_districts c WHERE a.sales_request_active = '1' AND b.customer_active = '1' AND c.customer_city_id = '".$data_tbl_customer_city['customer_city_id']."' AND c.customer_districts_active = '1' AND a.customer_id = b.customer_id AND b.customer_districts_id = c.customer_districts_id GROUP BY c.customer_districts_id ORDER BY c.customer_districts_name");
											while($data_tbl_customer_districts = mysql_fetch_array($tbl_customer_districts))
											{
										?>
											<tr>
												<td>
													<?php echo $no ?>
												</td>
												<td>
													<?php echo $data_tbl_customer_districts['customer_districts_name'] ?>
												</td>
												<?php
													$tbl_customer_category = mysql_query("SELECT customer_category_id, customer_category_name FROM customer_category WHERE customer_category_active = '1' ORDER BY customer_category_name");
													while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
													{
														$tbl_sales_request_quantity_customer_category = mysql_query("SELECT COUNT(b.customer_id) AS customer_quantity_customer_category FROM sales_request a, customer b WHERE a.sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND a.sales_request_active = '1' AND b.customer_category_id = '".$data_tbl_customer_category['customer_category_id']."' AND b.customer_districts_id = '".$data_tbl_customer_districts['customer_districts_id']."' AND b.customer_active = '1' AND a.customer_id = b.customer_id");
														$data_tbl_sales_request_quantity_customer_category = mysql_fetch_array($tbl_sales_request_quantity_customer_category);
														
														$customer_quantity_customer_category_indo = format_angka($data_tbl_sales_request_quantity_customer_category['customer_quantity_customer_category']);
												?>
													<td>
														<?php echo $customer_quantity_customer_category_indo ?>
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
									</table>
								</div>
							</div>
						<?php
							}
						?>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	function form_search_salesman_by_order_method_request_report()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Laporan Permintaan
								</span>
								<span class="caption-helper sbold uppercase">
									Per Salesman Berdasarkan Cara Pesanan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=request-report&tib=form-view-salesman-by-order-method-request-report" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Dari Tanggal
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_request_from_date" placeholder="Dari Tanggal" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Sampai Tanggal
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_request_to_date" placeholder="Sampai Tanggal" type="text">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline purple sbold">
										<i class="fa fa-rss"></i>
										Proses
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
	function form_view_salesman_by_order_method_request_report()
	{
		$sales_request_from_date = explode("-", $_POST['sales_request_from_date']);
		$date_sales_request_from = $sales_request_from_date[0];
		$month_sales_request_from = $sales_request_from_date[1];
		$year_sales_request_from = $sales_request_from_date[2];
		$sales_request_from_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_request_from, $date_sales_request_from, $year_sales_request_from));
	
		$sales_request_from_date_indo = tanggal_indo($sales_request_from_date);
		
		$sales_request_to_date = explode("-", $_POST['sales_request_to_date']);
		$date_sales_request_to = $sales_request_to_date[0];
		$month_sales_request_to = $sales_request_to_date[1];
		$year_sales_request_to = $sales_request_to_date[2];
		$sales_request_to_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_request_to, $date_sales_request_to, $year_sales_request_to));
	
		$sales_request_to_date_indo = tanggal_indo($sales_request_to_date);
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Laporan Permintaan
								</span>
								<span class="caption-helper sbold uppercase">
									Per Salesman Berdasarkan Cara Pesanan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=request-report&tib=form-view-salesman-by-order-method-request-report" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Dari Tanggal
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_request_from_date" placeholder="Dari Tanggal" type="text" value="<?php echo $_POST['sales_request_from_date'] ?>">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Sampai Tanggal
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_request_to_date" placeholder="Sampai Tanggal" type="text" value="<?php echo $_POST['sales_request_to_date'] ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline purple sbold">
										<i class="fa fa-rss"></i>
										Proses
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-red sbold uppercase">
								<?php
									if ($_POST['sales_request_from_date'] == $_POST['sales_request_to_date'])
									{
								?>
									Tanggal <?php echo $sales_request_from_date_indo ?>
								<?php
									}
									else
									{
								?>
									Dari Tanggal <?php echo $sales_request_from_date_indo ?> Sampai Tanggal <?php echo $sales_request_to_date_indo ?>
								<?php
									}
								?>
								</span>
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-responsive">
								<table class="table table-bordered table-hover table-striped">
									<thead>
										<tr>
											<th>
												No
											</th>
											<th>
												Salesman
											</th>
											<th>
												By Phone
											</th>
											<th>
												By Visit
											</th>
										</tr>
									</thead>
									<tbody>
									<?php
										$no = 1;
										$tbl_user = mysql_query("SELECT b.user_id, b.user_name FROM sales_request a, user b, user_category c WHERE a.sales_request_active = '1' AND b.user_active = '1' AND c.user_category_name LIKE 'Salesman%' AND c.user_category_active = '1' AND a.salesman_id = b.user_id AND b.user_category_id = c.user_category_id GROUP BY b.user_id ORDER BY b.user_name");
										while($data_tbl_user = mysql_fetch_array($tbl_user))
										{
											$tbl_sales_request_by_phone = mysql_query("SELECT COUNT(customer_id) AS customer_quantity_order_method_by_phone FROM sales_request WHERE sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND salesman_id = '".$data_tbl_user['user_id']."' AND sales_request_order_method = 'By Phone' AND sales_request_active = '1'");
											$data_tbl_sales_request_by_phone = mysql_fetch_array($tbl_sales_request_by_phone);
											
											$customer_quantity_order_method_by_phone_indo = format_angka($data_tbl_sales_request_by_phone['customer_quantity_order_method_by_phone']);
											
											$tbl_sales_request_by_visit = mysql_query("SELECT COUNT(customer_id) AS customer_quantity_order_method_by_visit FROM sales_request WHERE sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND salesman_id = '".$data_tbl_user['user_id']."' AND sales_request_order_method = 'By Visit' AND sales_request_active = '1'");
											$data_tbl_sales_request_by_visit = mysql_fetch_array($tbl_sales_request_by_visit);
											
											$customer_quantity_order_method_by_visit_indo = format_angka($data_tbl_sales_request_by_visit['customer_quantity_order_method_by_visit']);
									?>
										<tr>
											<td>
												<?php echo $no ?>
											</td>
											<td>
												<?php echo $data_tbl_user['user_name'] ?>
											</td>
											<td>
												<?php echo $customer_quantity_order_method_by_phone_indo ?>
											</td>
											<td>
												<?php echo $customer_quantity_order_method_by_visit_indo ?>
											</td>
										</tr>
									<?php
										$no++;
										}
									?>
									</tbody>
								</table>

			   					<div class="form portlet-body">
                                					<div class="form-actions right">
                                    						<a class="btn btn-sm btn-outline purple sbold" data-original-title="Cetak" data-toggle="modal" href="#print_sales_visit_report<?php echo $sales_request_from_date; $sales_request_to_date; ?>">
                                        						<i class="fa fa-print"></i>
                                        						Cetak
                                    						</a>
                                					</div>
                            					</div>
                            					<div aria-hidden="true" class="modal fade" id="print_sales_visit_report<?php echo $sales_request_from_date; $sales_request_to_date; ?>" role="basic" tabindex="-1">
                             						<div class="modal-dialog">
                               						 	<div class="modal-content">
                                 							<div class="modal-header">
                                    								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                      								<h4 class="modal-title">
                                        							Konfirmasi
                                      								</h4>
                                  							</div>
                                  							<div class="modal-body">
                                   							 	Apakah Anda Yakin Ingin Mencetak Data Ini ?
                                  							</div>
                                  							<div class="modal-footer">
                                    								<a class="btn btn-outline btn-sm green sbold" href="printable-version/request_report.php?tib=form-print-by-order-request-report&sales_request_from_date=<?php echo $sales_request_from_date ?>&sales_request_to_date=<?php echo $sales_request_to_date ?>">
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
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

<?php
	}
	function form_search_by_order_request_report()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" id="form_sample_3" method="post" action="?alimms=request-report&tib=form-result-by-order-request-report">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Laporan Permintaan</span>
								<span class="caption-helper">By Pesanan</span>
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
														<label class="control-label">Dari Tanggal</label>
														<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="Dari Tanggal" name="sales_request_from_date" />
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Sampai Tanggal</label>
														<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="Sampai Tanggal" name="sales_request_to_date" />
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
	function form_result_by_order_request_report()
	{
		$salesrequestfromDate = explode("-", $_POST['sales_request_from_date']);
		$DatesalesrequestfromDate = $salesrequestfromDate[0];
		$MonthsalesrequestfromDate = $salesrequestfromDate[1];
		$YearsalesrequestfromDate = $salesrequestfromDate[2];
		$sales_request_from_date = date("Y-m-d", mktime(0, 0, 0, $MonthsalesrequestfromDate, $DatesalesrequestfromDate, $YearsalesrequestfromDate));
		
		$sales_request_from_date_indo = tanggal_indo($sales_request_from_date);
		
		$salesrequesttoDate = explode("-", $_POST['sales_request_to_date']);
		$DatesalesrequesttoDate = $salesrequesttoDate[0];
		$MonthsalesrequesttoDate = $salesrequesttoDate[1];
		$YearsalesrequesttoDate = $salesrequesttoDate[2];
		$sales_request_to_date = date("Y-m-d", mktime(0, 0, 0, $MonthsalesrequesttoDate, $DatesalesrequesttoDate, $YearsalesrequesttoDate));
		
		$sales_request_to_date_indo = tanggal_indo($sales_request_to_date);
?>
		<div class="row">
			<div class="col-md-12">
				<form class="horizontal-form" role="form" id="form_sample_3" method="post" action="?alimms=request-report&tib=form-result-by-order-request-report">
					<div class="portlet light">
						<div class="portlet-title hidden-print">
							<div class="caption">
								<span class="caption-subject font-blue-madison bold uppercase">Laporan Permintaan</span>
								<span class="caption-helper">By Pesanan</span>
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
														<label class="control-label">Dari Tanggal</label>
														<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="Dari Tanggal" name="sales_request_from_date" value="<?php echo $_POST['sales_request_from_date'] ?>" />
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label class="control-label">Sampai Tanggal</label>
														<input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="Sampai Tanggal" name="sales_request_to_date" value="<?php echo $_POST['sales_request_to_date'] ?>" />
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
															Laporan Permintaan<br />
															By Pesanan
															<span class="muted">Periode <?php echo $sales_request_from_date_indo ?> - <?php echo $sales_request_to_date_indo ?></span>
														</p>
													</div>
												</div>
												<hr/>
												<div class="row">
													<div class="col-xs-12">
														<table class="table table-striped table-hover">
															<thead>
																<tr>
																	<th>
																		No
																	</th>
																	<th>
																		Salesman
																	</th>
																	<th>
																		By Phone
																	</th>
																	<th>
																		By Visit
																	</th>
<th>
																		Total
																	</th>
																</tr>
															</thead>
															<tbody>
														<?php
															$no = 1;
															$tbl_user = mysql_query("SELECT b.user_id, b.user_name FROM sales_request a, user b WHERE a.sales_request_active = '1' AND b.user_active = '1' AND a.sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND a.salesman_id = b.user_id GROUP BY b.user_id ORDER BY b.user_name");
															while ($data_tbl_user = mysql_fetch_array($tbl_user))
															{
																$tbl_sales_request_by_phone = mysql_query("SELECT COUNT(customer_id) AS total_quantity FROM sales_request WHERE sales_request_active = '1' AND sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND salesman_id = '".$data_tbl_user['user_id']."' AND sales_request_order = 'By Phone'");
																$data_tbl_sales_request_by_phone = mysql_fetch_array($tbl_sales_request_by_phone);
																
																$tbl_sales_request_by_visit = mysql_query("SELECT COUNT(customer_id) AS total_quantity FROM sales_request WHERE sales_request_active = '1' AND sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND salesman_id = '".$data_tbl_user['user_id']."' AND sales_request_order = 'By Visit'");
																$data_tbl_sales_request_by_visit = mysql_fetch_array($tbl_sales_request_by_visit);

$tbl_sales_request_by_visit_sum = $data_tbl_sales_request_by_phone['total_quantity'] + $data_tbl_sales_request_by_visit['total_quantity'];
														?>
																<tr>
																	<td style="width: 3%;">
																		<?php echo $no ?>
																	</td>
																	<td>
																		<?php echo $data_tbl_user['user_name'] ?>
																	</td>
																	<td>
																		<?php echo $data_tbl_sales_request_by_phone['total_quantity'] ?>
																	</td>
																	<td>
																		<?php echo $data_tbl_sales_request_by_visit['total_quantity'] ?>
																	</td>

<td>
																		<?php echo $tbl_sales_request_by_visit_sum ?>
																	</td>
																</tr>
														<?php
															$no++;
															}
														?>
															</tbody>
															<thead>
																<tr>
																	<th colspan="2">
																		Grand Total
																	</th>
															<?php
																$tbl_sales_request_by_phone = mysql_query("SELECT COUNT(customer_id) AS total_quantity FROM sales_request WHERE sales_request_active = '1' AND sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND sales_request_order = 'By Phone'");
																$data_tbl_sales_request_by_phone = mysql_fetch_array($tbl_sales_request_by_phone);
																
																$tbl_sales_request_by_visit = mysql_query("SELECT COUNT(customer_id) AS total_quantity FROM sales_request WHERE sales_request_active = '1' AND sales_request_date BETWEEN '".$sales_request_from_date."' AND '".$sales_request_to_date."' AND sales_request_order = 'By Visit'");
																$data_tbl_sales_request_by_visit = mysql_fetch_array($tbl_sales_request_by_visit);

$tbl_sales_request_by_visit_sum =  $data_tbl_sales_request_by_phone['total_quantity'] + $data_tbl_sales_request_by_visit['total_quantity'];
															?>
																	<th>
																		<?php echo $data_tbl_sales_request_by_phone['total_quantity'] ?>
																	</th>
																	<th>
																		<?php echo $data_tbl_sales_request_by_visit['total_quantity'] ?>
																	</th>

<th>
																		<?php echo $tbl_sales_request_by_visit_sum ?>
																	</th>
																</tr>
															</thead>
														</table>
													</div>
												</div>
												<div class="row">
													<div class="col-xs-12 invoice-block">
														<a class="btn green-meadow btn-sm" data-toggle="modal" href="#printbyorderrequestreport">
														<i class="fa fa-print"></i> Cetak
														</a>
													</div>
												</div>
												<div class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false" id="printbyorderrequestreport">
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
																<button type="button" class="btn green-meadow btn-sm" data-dismiss="modal" onclick="location.href='../system/printable-version/request_report.php?alimms=request-report&tib=form-print-by-order-request-report&sales_request_from_date=<?php echo $_POST['sales_request_from_date'] ?>&sales_request_to_date=<?php echo $_POST['sales_request_to_date'] ?>'"><i class="fa fa-check"></i> Ya</button>
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