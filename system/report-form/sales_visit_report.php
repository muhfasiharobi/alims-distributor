<?php
	function form_search_salesman_by_count_visit_sales_visit_report()
	{
?>
	<div class="page-fixed-main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">
								Laporan Kunjungan
							</span>
							<span class="caption-helper sbold uppercase">
								Per Salesman Berdasarkan Jumlah Kunjungan
							</span>
						</div>
					</div>
					<div class="form portlet-body">
						<form action="?alimms=sales-visit-report&tib=form-view-salesman-by-count-visit-sales-visit-report" class="horizontal-form" id="form_sample_3" method="post">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_plan_from_date" placeholder="Dari Tanggal" type="text">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_plan_to_date" placeholder="Sampai Tanggal" type="text">
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
	function form_view_salesman_by_count_visit_sales_visit_report()
	{
		$sales_plan_from_date = explode("-", $_POST['sales_plan_from_date']);
		$date_sales_plan_from = $sales_plan_from_date[0];
		$month_sales_plan_from = $sales_plan_from_date[1];
		$year_sales_plan_from = $sales_plan_from_date[2];
		$sales_plan_from_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_plan_from, $date_sales_plan_from, $year_sales_plan_from));
		
		$sales_plan_from_date_indo = tanggal_indo($sales_plan_from_date);
		
		$sales_plan_to_date = explode("-", $_POST['sales_plan_to_date']);
		$date_sales_plan_to = $sales_plan_to_date[0];
		$month_sales_plan_to = $sales_plan_to_date[1];
		$year_sales_plan_to = $sales_plan_to_date[2];
		$sales_plan_to_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_plan_to, $date_sales_plan_to, $year_sales_plan_to));
		
		$sales_plan_to_date_indo = tanggal_indo($sales_plan_to_date);
?>
	<div class="page-fixed-main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">
								Laporan Kunjungan
							</span>
							<span class="caption-helper sbold uppercase">
								Per Salesman Berdasarkan Jumlah Kunjungan
							</span>
						</div>
					</div>
					<div class="form portlet-body">
						<form action="?alimms=sales-visit-report&tib=form-view-salesman-by-count-visit-sales-visit-report" class="horizontal-form" id="form_sample_3" method="post">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_plan_from_date" placeholder="Dari Tanggal" type="text" value="<?php echo $_POST['sales_plan_from_date'] ?>">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_plan_to_date" placeholder="Sampai Tanggal" type="text" value="<?php echo $_POST['sales_plan_to_date'] ?>">
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
								if ($_POST['sales_plan_from_date'] == $_POST['sales_plan_to_date'])
								{
							?>
								Tanggal <?php echo $sales_plan_from_date_indo ?>
							<?php
								}
								else
								{
							?>
								Dari Tanggal <?php echo $sales_plan_from_date_indo ?> Sampai Tanggal <?php echo $sales_plan_to_date_indo ?>
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
										<th rowspan="2">
											No
										</th>
										<th rowspan="2">
											Salesman
										</th>
										
										<th colspan="5">
											Kunjungan
										</th>
									</tr>
									<tr>
										<th>
											Rencana
										</th>
										<th>
											Dikunjungi
										</th>
										<th>
											Tidak Dikunjungi
										</th>
										<th>
											Memesan
										</th>
										<th>
											Tidak Memesan
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_user = mysql_query("SELECT a.sales_plan_id, COUNT(b.customer_id) AS customer_plan_count, c.user_id, c.user_name FROM sales_plan a, sales_plan_detail b, user c WHERE a.sales_plan_date BETWEEN '".$sales_plan_from_date."' AND '".$sales_plan_to_date."' AND a.sales_plan_active = '1' AND a.sales_plan_id = b.sales_plan_id AND a.salesman_id = c.user_id GROUP BY c.user_id ORDER BY c.user_name");
									while($data_tbl_user = mysql_fetch_array($tbl_user))
									{
										$customer_plan_count_indo = format_angka($data_tbl_user['customer_plan_count']);
										
										$tbl_sales_visit_visited = mysql_query("SELECT COUNT(c.customer_id) AS customer_count_visited FROM sales_visit a, sales_plan b, sales_plan_detail c WHERE NOT a.sales_visit_status = 'Call' AND b.salesman_id = '".$data_tbl_user['user_id']."' AND b.sales_plan_date BETWEEN '".$sales_plan_from_date."' AND '".$sales_plan_to_date."' AND b.sales_plan_active = '1' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id");
										$data_tbl_sales_visit_visited = mysql_fetch_array($tbl_sales_visit_visited);
										
										$customer_count_visited_indo = format_angka($data_tbl_sales_visit_visited['customer_count_visited']);
										
										$tbl_sales_visit_not_visited = mysql_query("SELECT COUNT(c.customer_id) AS customer_count_not_visited FROM sales_visit a, sales_plan b, sales_plan_detail c WHERE a.sales_visit_status = 'Call' AND b.salesman_id = '".$data_tbl_user['user_id']."' AND b.sales_plan_date BETWEEN '".$sales_plan_from_date."' AND '".$sales_plan_to_date."' AND b.sales_plan_active = '1' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id");
										$data_tbl_sales_visit_not_visited = mysql_fetch_array($tbl_sales_visit_not_visited);

										$customer_count_not_visited_indo = format_angka($data_tbl_sales_visit_not_visited['customer_count_not_visited']);
										
										$tbl_sales_visit_order = mysql_query("SELECT COUNT(c.customer_id) AS customer_count_order FROM sales_visit a, sales_plan b, sales_plan_detail c WHERE a.sales_visit_status = 'Order' AND b.salesman_id = '".$data_tbl_user['user_id']."' AND b.sales_plan_date BETWEEN '".$sales_plan_from_date."' AND '".$sales_plan_to_date."' AND b.sales_plan_active = '1' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id");
										$data_tbl_sales_visit_order = mysql_fetch_array($tbl_sales_visit_order);
										
										$customer_count_order_indo = format_angka($data_tbl_sales_visit_order['customer_count_order']);
										
										$tbl_sales_visit_not_order = mysql_query("SELECT COUNT(c.customer_id) AS customer_count_not_order FROM sales_visit a, sales_plan b, sales_plan_detail c WHERE a.sales_visit_status = 'Not Order' AND b.salesman_id = '".$data_tbl_user['user_id']."' AND b.sales_plan_date BETWEEN '".$sales_plan_from_date."' AND '".$sales_plan_to_date."' AND b.sales_plan_active = '1' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id");
										$data_tbl_sales_visit_not_order = mysql_fetch_array($tbl_sales_visit_not_order);
										
										$customer_count_not_order_indo = format_angka($data_tbl_sales_visit_not_order['customer_count_not_order']);
								?>
									<tr>
										<td style="text-align: center;">
											<?php echo $no ?>
										</td>
										<td style="text-align: left;">
											<?php echo $data_tbl_user['user_name'] ?>
										</td>
										<td style="text-align: center;">
											<?php echo $customer_plan_count_indo ?>
										</td>
										<td style="text-align: center;">
											<?php echo $customer_count_visited_indo ?>
										</td>
										<td style="text-align: center;">
											<?php echo $customer_count_not_visited_indo ?>
										</td>
										<td style="text-align: center;">
											<?php echo $customer_count_order_indo ?>
										</td>
										<td style="text-align: center;">
											<?php echo $customer_count_not_order_indo ?>
										</td>
									</tr>
								<?php
									$no++;
									}
								?>
								</tbody>
								<thead>
								<?php
									$tbl_sales_plan = mysql_query("SELECT COUNT(b.customer_id) AS customer_plan_total_count FROM sales_plan a, sales_plan_detail b WHERE a.sales_plan_date BETWEEN '".$sales_plan_from_date."' AND '".$sales_plan_to_date."' AND a.sales_plan_active = '1' AND a.sales_plan_id = b.sales_plan_id");
									$data_tbl_sales_plan = mysql_fetch_array($tbl_sales_plan);
									
									$customer_plan_total_count_indo = format_angka($data_tbl_sales_plan['customer_plan_total_count']);
									
									$tbl_sales_visit_visited = mysql_query("SELECT COUNT(c.customer_id) AS customer_visited_total_count FROM sales_visit a, sales_plan b, sales_plan_detail c WHERE NOT a.sales_visit_status = 'Call' AND b.sales_plan_date BETWEEN '".$sales_plan_from_date."' AND '".$sales_plan_to_date."' AND b.sales_plan_active = '1' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id");
									$data_tbl_sales_visit_visited = mysql_fetch_array($tbl_sales_visit_visited);
									
									$customer_visited_total_count_indo = format_angka($data_tbl_sales_visit_visited['customer_visited_total_count']);
									
									$tbl_sales_visit_not_visited = mysql_query("SELECT COUNT(c.customer_id) AS customer_not_visited_total_count FROM sales_visit a, sales_plan b, sales_plan_detail c WHERE a.sales_visit_status = 'Call' AND b.sales_plan_date BETWEEN '".$sales_plan_from_date."' AND '".$sales_plan_to_date."' AND b.sales_plan_active = '1' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id");
									$data_tbl_sales_visit_not_visited = mysql_fetch_array($tbl_sales_visit_not_visited);

									$customer_not_visited_total_count_indo = format_angka($data_tbl_sales_visit_not_visited['customer_not_visited_total_count']);
									
									$tbl_sales_visit_order = mysql_query("SELECT COUNT(c.customer_id) AS customer_order_total_count FROM sales_visit a, sales_plan b, sales_plan_detail c WHERE a.sales_visit_status = 'Order' AND b.sales_plan_date BETWEEN '".$sales_plan_from_date."' AND '".$sales_plan_to_date."' AND b.sales_plan_active = '1' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id");
									$data_tbl_sales_visit_order = mysql_fetch_array($tbl_sales_visit_order);
									
									$customer_order_total_count_indo = format_angka($data_tbl_sales_visit_order['customer_order_total_count']);
									
									$tbl_sales_visit_not_order = mysql_query("SELECT COUNT(c.customer_id) AS customer_not_order_total_count FROM sales_visit a, sales_plan b, sales_plan_detail c WHERE a.sales_visit_status = 'Not Order' AND b.sales_plan_date BETWEEN '".$sales_plan_from_date."' AND '".$sales_plan_to_date."' AND b.sales_plan_active = '1' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id");
									$data_tbl_sales_visit_not_order = mysql_fetch_array($tbl_sales_visit_not_order);
									
									$customer_not_order_total_count_indo = format_angka($data_tbl_sales_visit_not_order['customer_not_order_total_count']);
								?>
									<tr>
										<th colspan="2">
											Grand Total
										</th>
										<th>
											<?php echo $customer_plan_total_count_indo ?>
										</th>
										<th>
											<?php echo $customer_visited_total_count_indo ?>
										</th>
										<th>
											<?php echo $customer_not_visited_total_count_indo ?>
										</th>
										<th>
											<?php echo $customer_order_total_count_indo ?>
										</th>
										<th>
											<?php echo $customer_not_order_total_count_indo ?>
										</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
	}
	function form_search_salesman_by_time_visit_sales_visit_report()
	{
?>
	<div class="page-fixed-main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">
								Laporan Kunjungan
							</span>
							<span class="caption-helper sbold uppercase">
								Per Salesman Berdasarkan Waktu Kunjungan
							</span>
						</div>
					</div>
					<div class="form portlet-body">
						<form action="?alimms=sales-visit-report&tib=form-view-salesman-by-time-visit-sales-visit-report" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>
												Tanggal
												<span class="required">
													*
												</span>
											</label>
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_plan_date" placeholder="Tanggal" type="text">
										</div>
									</div>
								</div>
                                                        <div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>
												Salesman
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#salesman_id" data-placeholder="Salesman" name="salesman_id">
													<option value=""></option>
													<option value="all">Semua</option>
													<?php
														$tbl_user = mysql_query("SELECT a.user_id, a.user_name FROM user a, user_category b WHERE a.user_active = '1' AND b.user_category_active = '1' AND a.user_category_id = b.user_category_id AND b.user_category_name LIKE 'Salesman%' ORDER BY a.user_name");
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
	function form_view_salesman_by_time_visit_sales_visit_report()
	{
		$sales_plan_date = explode("-", $_POST['sales_plan_date']);
		$date_sales_plan = $sales_plan_date[0];
		$month_sales_plan = $sales_plan_date[1];
		$year_sales_plan = $sales_plan_date[2];
		$sales_plan_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_plan, $date_sales_plan, $year_sales_plan));
		
		$sales_plan_date_indo = tanggal_indo($sales_plan_date);
?>
	<div class="page-fixed-main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">
								Laporan Kunjungan
							</span>
							<span class="caption-helper sbold uppercase">
								Per Salesman Berdasarkan Waktu Kunjungan
							</span>
						</div>
					</div>
					<div class="form portlet-body">
						<form action="?alimms=sales-visit-report&tib=form-view-salesman-by-time-visit-sales-visit-report" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>
												Tanggal
												<span class="required">
													*
												</span>
											</label>
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_plan_date" placeholder="Tanggal" type="text" value="<?php echo $_POST['sales_plan_date'] ?>">
										</div>
									</div>
								</div>
                                                                <div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>
												Salesman
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#salesman_id" data-placeholder="Salesman" name="salesman_id">
													<option value=""></option>
													<option value="all">Semua</option>
													<?php
														$tbl_user = mysql_query("SELECT a.user_id, a.user_name FROM user a, user_category b WHERE a.user_active = '1' AND b.user_category_active = '1' AND a.user_category_id = b.user_category_id AND b.user_category_name LIKE 'Salesman%' ORDER BY a.user_name");
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
								Tanggal <?php echo $sales_plan_date_indo ?>
							</span>
						</div>
					</div>
					<?php
						if($_POST['salesman_id'] == "all")
						{
							
							$tbl_user = mysql_query("SELECT c.user_id, c.user_name FROM sales_plan a, sales_plan_detail b, user c WHERE a.sales_plan_date = '".$sales_plan_date."' AND a.sales_plan_active = '1' AND a.sales_plan_id = b.sales_plan_id AND a.salesman_id = c.user_id GROUP BY c.user_id ORDER BY c.user_name");
						
						}
						else
						{
							$tbl_user = mysql_query("SELECT c.user_id, c.user_name FROM sales_plan a, sales_plan_detail b, user c WHERE a.sales_plan_date = '".$sales_plan_date."' AND a.sales_plan_active = '1' AND a.sales_plan_id = b.sales_plan_id AND a.salesman_id = c.user_id AND a.salesman_id = '".$_POST['salesman_id']."' GROUP BY c.user_id ORDER BY c.user_name");
							
						}
						while($data_tbl_user = mysql_fetch_array($tbl_user))
						{
					?>
						<h5 class="font-blue sbold uppercase">
							<?php echo $data_tbl_user['user_name'] ?>
						</h5>
						<div class="portlet-body">
							<div class="table-responsive">
								<table class="table table-bordered table-hover table-striped">
									<thead>
										<tr>
											<th rowspan="2">
												No
											</th>
											<th rowspan="2">
												Pelanggan
											</th>
											<th rowspan="2">
												Kecamatan
											</th>
											<th colspan="3">
												Kunjungan
											</th>
											<th colspan="3">
												Stok Produk
											</th>
											<th rowspan="2">
												Foto Produk
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
											<th>
												Durasi Waktu
											</th>
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

										if($_POST['salesman_id'] == "all")
										{
											
											$tbl_sales_visit = mysql_query("SELECT a.sales_visit_id, a.sales_visit_time_in, a.sales_visit_time_out, timediff(a.sales_visit_time_out, a.sales_visit_time_in) AS sales_visit_time_duration, a.sales_visit_status, a.sales_visit_description, d.customer_code, d.customer_name, e.customer_category_name, f.customer_districts_name FROM sales_visit a, sales_plan b, sales_plan_detail c, customer d, customer_category e, customer_districts f WHERE b.salesman_id = '".$data_tbl_user['user_id']."' AND b.sales_plan_date = '".$sales_plan_date."' AND b.sales_plan_active = '1' AND d.customer_active = '1' AND e.customer_category_active = '1' AND f.customer_districts_active = '1' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id AND c.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id");
											
										}
										else
										{
										
											$tbl_sales_visit = mysql_query("SELECT a.sales_visit_id, a.sales_visit_time_in, a.sales_visit_time_out, timediff(a.sales_visit_time_out, a.sales_visit_time_in) AS sales_visit_time_duration, a.sales_visit_status, a.sales_visit_description, d.customer_code, d.customer_name, e.customer_category_name, f.customer_districts_name FROM sales_visit a, sales_plan b, sales_plan_detail c, customer d, customer_category e, customer_districts f WHERE b.salesman_id = '".$data_tbl_user['user_id']."' AND b.sales_plan_date = '".$sales_plan_date."' AND b.sales_plan_active = '1' AND d.customer_active = '1' AND e.customer_category_active = '1' AND f.customer_districts_active = '1' AND a.sales_plan_detail_id = c.sales_plan_detail_id AND b.sales_plan_id = c.sales_plan_id AND c.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id AND b.salesman_id = '".$_POST['salesman_id']."'");
										
										}	

										while($data_tbl_sales_visit = mysql_fetch_array($tbl_sales_visit))
										{
									?>
										<tr>
											<td style="text-align: center;">
												<?php echo $no ?>
											</td>
											<td style="text-align: left;">
												<?php echo $data_tbl_sales_visit['customer_category_name'] ?> - <?php echo $data_tbl_sales_visit['customer_code'] ?> - <?php echo $data_tbl_sales_visit['customer_name'] ?>
											</td>
											<td style="text-align: center;">
												<?php echo $data_tbl_sales_visit['customer_districts_name'] ?>
											</td>
											<td style="text-align: center;">
												<?php echo $data_tbl_sales_visit['sales_visit_time_in'] ?>
											</td>
											<td style="text-align: center;">
												<?php echo $data_tbl_sales_visit['sales_visit_time_out'] ?>
											</td>
											<td style="text-align: center;">
												<?php echo $data_tbl_sales_visit['sales_visit_time_duration'] ?>
											</td>
											<?php
												$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
												while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
												{
													$tbl_sales_visit_detail = mysql_query("SELECT sales_visit_detail_product_sell_quantity FROM sales_visit_detail WHERE sales_visit_id = '".$data_tbl_sales_visit['sales_visit_id']."' AND product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
													$jumlah_tbl_sales_visit_detail = mysql_num_rows($tbl_sales_visit_detail);
													$data_tbl_sales_visit_detail = mysql_fetch_array($tbl_sales_visit_detail);
													
													$sales_visit_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_visit_detail['sales_visit_detail_product_sell_quantity']);
													
													if ($jumlah_tbl_sales_visit_detail > 0)
													{
											?>
													<td style="text-align: center;">
														<?php echo $sales_visit_detail_product_sell_quantity_indo ?>
													</td>
											<?php
													}
													else
													{
											?>
													<td style="text-align: center;">
														0
													</td>
											<?php
													}													
												}
											?>
											<td>
											<?php
												$tbl_product_display = mysql_query("SELECT product_display_photo FROM product_display WHERE sales_visit_id = '".$data_tbl_sales_visit['sales_visit_id']."'");
												$jumlah_tbl_product_display = mysql_num_rows($tbl_product_display);
												
												if ($jumlah_tbl_product_display > 0)
												{
													while($data_tbl_product_display = mysql_fetch_array($tbl_product_display))
													{
											?>
														<div class="thumbnail">
															<a href="../assets/layouts/layout6/img/product-display/<?php echo $data_tbl_product_display['product_display_photo'] ?>" class="fancybox-button" data-rel="fancybox-button">
																<img class="img-responsive" src="../assets/layouts/layout6/img/product-display/<?php echo $data_tbl_product_display['product_display_photo'] ?>" style="width: 100%; height: 100px;">
															</a>
														</div>
											<?php
													}
												}
												else
												{
											?>
													<div class="thumbnail">
														<a href="../assets/layouts/layout6/img/product-display/no_photo.jpg" class="fancybox-button" data-rel="fancybox-button">
															<img class="img-responsive" src="../assets/layouts/layout6/img/product-display/no_photo.jpg" style="width: 100%; height: 100px;">
														</a>
													</div>
											<?php
												} 
											?>
											</td>
											<td>
											<?php
												if ($data_tbl_sales_visit['sales_visit_status'] == "Call")
												{
											?>
												<span class="label label-info label-sm">Call</span>
											<?php
												}
												elseif ($data_tbl_sales_visit['sales_visit_status'] == "Not Order")
												{
											?>
												<span class="label label-danger label-sm">Not Order</span><br />
												<?php echo $data_tbl_sales_visit['sales_visit_description'] ?>
											<?php
												}
												else
												{
											?>
												<span class="label label-success label-sm">Order</span>
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
					<?php
						}
					?>
				</div>
			</div>
		</div>
	</div>
<?php
	}
	function form_search_call_book_salesman()
	{
		
?>
	<div class="page-fixed-main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">
								CALL BOOK SALESMAN
							</span>
						</div>
					</div>
					<div class="form portlet-body">
						<form action="?alimms=sales-visit-report&tib=form-result-call-book-salesman" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>
												Pelanggan
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#customer_id" data-placeholder="Pelanggan" name="customer_id">
													<option value=""></option>
													<?php
														$tbl_customer = mysql_query("SELECT a.customer_id, a.customer_code, a.customer_name, a.customer_address, b.customer_category_name, c.customer_districts_name FROM customer a, customer_category b, customer_districts c WHERE a.customer_active = '1' AND b.customer_category_active = '1' AND c.customer_districts_active = '1' AND a.customer_category_id = b.customer_category_id AND a.customer_districts_id = c.customer_districts_id ORDER BY a.customer_code");
														while($data_tbl_customer = mysql_fetch_array($tbl_customer))
														{
													?>
															<option value="<?php echo $data_tbl_customer['customer_id'] ?>"><?php echo $data_tbl_customer['customer_category_name'] ?> - <?php echo $data_tbl_customer['customer_code'] ?> - <?php echo $data_tbl_customer['customer_name'] ?> - <?php echo $data_tbl_customer['customer_address'] ?> (<?php echo $data_tbl_customer['customer_districts_name'] ?>)</option>
													<?php
														}
													?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Dari Tanggal
												<span class="required">
													*
												</span>
											</label>
											<input class="form-control date-picker" data-date-format="mm-yyyy" data-date-minviewmode="months" data-date-viewmode="years" name="call_book_from_date" placeholder="Periode" type="text" >
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
											<input class="form-control date-picker" data-date-format="mm-yyyy" data-date-minviewmode="months" data-date-viewmode="years" name="call_book_to_date" placeholder="Periode" type="text">
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
	function form_result_call_book_salesman()
	{
		
			$call_book_date = explode("-", $_POST['call_book_date']);
			$date_call_book_date = $call_book_date[0];
			$month_call_book_date = $call_book_date[1];
			$year_call_book_date = $call_book_date[2];
			$call_book_date = date("Y-m", mktime(0, 0, 0, $month_call_book_date, $date_call_book_date, $year_call_book_date));
		
		$tbl_pelanggan = mysql_query("SELECT * FROM customer a, customer_districts b WHERE a.customer_districts_id = b.customer_districts_id AND a.customer_id = '".$_POST['customer_id']."'");
		$data_tbl_pelanggan = mysql_fetch_array($tbl_pelanggan);
		
		$call_book_from_date = explode("-", $_POST['call_book_from_date']);
		$month_call_book_from = $call_book_from_date[0];
		$year_call_book_from = $call_book_from_date[1];
		$call_book_from_date = $year_call_book_from.'-'.$month_call_book_from.'-'.'01';

		$call_book_to_date = explode("-", $_POST['call_book_to_date']);
		$month_call_book_to = $call_book_to_date[0];
		$year_call_book_to = $call_book_to_date[1];
		$call_book_to_date = $year_call_book_to.'-'.$month_call_book_to.'-'.'31';
		
		$tgl_sekarang = date('Y-m-d');
?>
	<div class="page-fixed-main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">
								CALL BOOK SALESMAN
							</span>
						</div>
					</div>
					<div class="form portlet-body">
						<form action="?alimms=sales-visit-report&tib=form-result-call-book-salesman" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>
												Pelanggan
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#customer_id" data-placeholder="Pelanggan" name="customer_id">
													<option value=""></option>
													<?php
														$tbl_customer = mysql_query("SELECT a.customer_id, a.customer_code, a.customer_name, a.customer_address, b.customer_category_name, c.customer_districts_name FROM customer a, customer_category b, customer_districts c WHERE a.customer_active = '1' AND b.customer_category_active = '1' AND c.customer_districts_active = '1' AND a.customer_category_id = b.customer_category_id AND a.customer_districts_id = c.customer_districts_id ORDER BY a.customer_code");
														while($data_tbl_customer = mysql_fetch_array($tbl_customer))
														{
													?>
															<option value="<?php echo $data_tbl_customer['customer_id'] ?>"><?php echo $data_tbl_customer['customer_category_name'] ?> - <?php echo $data_tbl_customer['customer_code'] ?> - <?php echo $data_tbl_customer['customer_name'] ?> - <?php echo $data_tbl_customer['customer_address'] ?> (<?php echo $data_tbl_customer['customer_districts_name'] ?>)</option>
													<?php
														}
													?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Dari Tanggal
												<span class="required">
													*
												</span>
											</label>
											<input class="form-control date-picker" data-date-format="mm-yyyy" data-date-minviewmode="months" data-date-viewmode="years" name="call_book_from_date" placeholder="Periode" type="text" >
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
											<input class="form-control date-picker" data-date-format="mm-yyyy" data-date-minviewmode="months" data-date-viewmode="years" name="call_book_to_date" placeholder="Periode" type="text">
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
					<div class="todo-main-header">
						<h3>
							<?php echo $data_tbl_pelanggan['customer_name'] ?>
						</h3>
						<ul class="todo-breadcrumb">
							<li>
								<a class="todo-active" href="javascript:;">
									<?php echo $data_tbl_pelanggan['customer_address'] ?>
								</a>
							</li>
							<li>
								<a class="todo-active" href="javascript:;">
									<?php echo $data_tbl_pelanggan['customer_districts_name'] ?> 
								</a>
							</li>
						</ul>
					</div>
					
					<div class="portlet-body">
						<div class="table-responsive">
						<?php
							
							$call_book_month = mysql_query("SELECT a.sales_plan_date FROM sales_plan a, sales_plan_detail b WHERE a.sales_plan_id = b.sales_plan_id AND b.customer_id = '".$_POST['customer_id']."' AND a.sales_plan_date between '".$call_book_from_date."' AND '".$call_book_to_date."' AND a.sales_plan_active = '1' group by MONTH(a.sales_plan_date)");
							while($data_call_book_month = mysql_fetch_array($call_book_month)){
								$call_book_on_month = explode("-", $data_call_book_month['sales_plan_date']);
								$year_call_book_on_month = $call_book_on_month[0];
								$month_call_book_on_month = $call_book_on_month[1];
								$date_call_book_on_month = $call_book_on_month[2];
								$data_call_book_on_month = date("Y-m", mktime(0, 0, 0, $month_call_book_on_month, $date_call_book_on_month, $year_call_book_on_month)); 
							
						?>
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th rowspan="2">
											Produk
										</th>
										<?php
											$n = 0;
											$tbl_sales_request = mysql_query("SELECT a.sales_plan_date FROM sales_plan a, sales_plan_detail b WHERE a.sales_plan_id = b.sales_plan_id AND b.customer_id = '".$_POST['customer_id']."' AND a.sales_plan_date like '%".$data_call_book_on_month."%' AND a.sales_plan_active = '1' AND NOT EXISTS(SELECT a.sales_request_date FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date = a.sales_plan_date) group by a.sales_plan_date
																				union all
																			  SELECT a.sales_request_date FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date like '%".$data_call_book_on_month."%' group by a.sales_request_date order by sales_plan_date ");
											while($data_tbl_sales_request = mysql_fetch_array($tbl_sales_request)){ 
												$n++;
												$sales_plan_date_indo = tanggal_indo($data_tbl_sales_request['sales_plan_date']);
											?>
												
												<th colspan="2">
													Tanggal <?php echo $sales_plan_date_indo ?>
												</th>
												
										
										<?php		
											}
										?>
										<th colspan="2">
											1 Bulan
										</th>
									</tr>
									<tr>
										<?php
											$n = 0;
											$tbl_sales_request = mysql_query("SELECT a.sales_plan_date FROM sales_plan a, sales_plan_detail b WHERE a.sales_plan_id = b.sales_plan_id AND b.customer_id = '".$_POST['customer_id']."' AND a.sales_plan_date like '%".$data_call_book_on_month."%' AND a.sales_plan_active = '1' AND NOT EXISTS(SELECT a.sales_request_date FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date = a.sales_plan_date) group by a.sales_plan_date
																				union all
																			  SELECT a.sales_request_date FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date like '%".$data_call_book_on_month."%' group by a.sales_request_date order by sales_plan_date ");
											while($data_tbl_sales_request = mysql_fetch_array($tbl_sales_request)){ 
												$n++;
												$sales_plan_date_indo = tanggal_indo($data_tbl_sales_request['sales_plan_date']);
											?>
												
												<th>
													Stok 
												</th>
												<th>
													Order 
												</th>
										
										<?php		
											}
										?>
										
										<th>
											Total
										</th>
										<th>
											AVG
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_product_sell = mysql_query("SELECT product_sell_id, product_sell_name FROM product_sell WHERE product_sell_active = '1'");
									while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
									{
								?>
									<tr>
										<td>
											<?php echo $data_tbl_product_sell['product_sell_name'] ?>
										</td>
										<?php
											$n = 0;
											$tbl_sales_request = mysql_query("SELECT a.sales_plan_date FROM sales_plan a, sales_plan_detail b WHERE a.sales_plan_id = b.sales_plan_id AND b.customer_id = '".$_POST['customer_id']."' AND a.sales_plan_date like '%".$data_call_book_on_month."%' AND a.sales_plan_active = '1' AND NOT EXISTS(SELECT a.sales_request_date FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date = a.sales_plan_date) group by a.sales_plan_date
																				union all
																			  SELECT a.sales_request_date FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date like '%".$data_call_book_on_month."%' group by a.sales_request_date order by sales_plan_date ");
											while($data_tbl_sales_request = mysql_fetch_array($tbl_sales_request)){ 
												$n++;
												$sales_plan_date_indo = tanggal_indo($data_tbl_sales_request['sales_plan_date']);
												
												$tbl_sales_plan = mysql_query("SELECT * FROM sales_plan a, sales_plan_detail b WHERE a.sales_plan_active = '1' AND a.sales_plan_id = b.sales_plan_id AND b.customer_id = '".$_POST['customer_id']."' AND a.sales_plan_date = '".$data_tbl_sales_request['sales_plan_date']."'");
												$data_tbl_sales_plan = mysql_fetch_array($tbl_sales_plan);
												
												$tbl_sales_visit = mysql_query("SELECT * FROM sales_visit a, sales_visit_detail b WHERE a.sales_plan_detail_id = '".$data_tbl_sales_plan['sales_plan_detail_id']."' AND a.sales_visit_id = b.sales_visit_id AND b.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
												$data_tbl_sales_visit = mysql_fetch_array($tbl_sales_visit);
												
												$tbl_sales_request_detail = mysql_query("SELECT * FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date = '".$data_tbl_sales_request['sales_plan_date']."' AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
												$data_tbl_sales_request_detail = mysql_fetch_array($tbl_sales_request_detail);
											?>
												
												<td align="center">
													 <?php 
														if($data_tbl_sales_visit['sales_visit_detail_product_sell_quantity'] == ""){
															echo "0";
														} else {
															echo $data_tbl_sales_visit['sales_visit_detail_product_sell_quantity'];
														}
														 
													 ?>
												</td>
												<td align="center">
													 <?php 
														if($data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'] == ""){
															echo "0"; 
														} else {
															echo $data_tbl_sales_request_detail['sales_request_detail_product_sell_quantity'];
														}
													?>
												</td>
										
										<?php		
											}
											
											$tbl_sum_sales_request_detail = mysql_query("SELECT sum(d.sales_request_detail_product_sell_quantity) as sales_request_detail_product_sell_quantity FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date like '%".$data_call_book_on_month."%' AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
											$data_tbl_sum_sales_request_detail = mysql_fetch_array($tbl_sum_sales_request_detail);
											
											$tbl_count_sales_request_detail = mysql_query("SELECT a.sales_request_id FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date like '%".$data_call_book_on_month."%' AND d.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
											$data_tbl_count_sales_request_detail = mysql_num_rows($tbl_count_sales_request_detail);
											
											$avg_sales_request_detail = round($data_tbl_sum_sales_request_detail['sales_request_detail_product_sell_quantity'] / $data_tbl_count_sales_request_detail);
											
											$sum_avg_sales_request_detail = $sum_avg_sales_request_detail + $avg_sales_request_detail;
												
											?>
												<td align="center">
													<?php 
													if($data_tbl_sum_sales_request_detail['sales_request_detail_product_sell_quantity'] == ""){
														echo "0";
													} else {
														echo $data_tbl_sum_sales_request_detail['sales_request_detail_product_sell_quantity'];
													}
														 
													?>
												</td>
												<td align="center">
													<?php 
														if($avg_sales_request_detail == ""){
															echo "0";
														} else {
															echo $avg_sales_request_detail; 
														}
													?>
												</td>
									</tr>
								<?php
									}
								?>
									<tr>
										<td>
											Total
										</td>
										<?php
											$n = 0;
											
											$tbl_sales_request = mysql_query("SELECT a.sales_plan_date FROM sales_plan a, sales_plan_detail b WHERE a.sales_plan_id = b.sales_plan_id AND b.customer_id = '".$_POST['customer_id']."' AND a.sales_plan_date like '%".$data_call_book_on_month."%' AND a.sales_plan_active = '1' AND NOT EXISTS(SELECT a.sales_request_date FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date = a.sales_plan_date) group by a.sales_plan_date
																				union all
																			  SELECT a.sales_request_date FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date like '%".$data_call_book_on_month."%' group by a.sales_request_date order by sales_plan_date ");
											while($data_tbl_sales_request = mysql_fetch_array($tbl_sales_request)){ 
												$n++;
												$sales_plan_date_indo = tanggal_indo($data_tbl_sales_request['sales_plan_date']);
												
												$tbl_sales_plan = mysql_query("SELECT * FROM sales_plan a, sales_plan_detail b WHERE a.sales_plan_active = '1' AND a.sales_plan_id = b.sales_plan_id AND b.customer_id = '".$_POST['customer_id']."' AND a.sales_plan_date = '".$data_tbl_sales_request['sales_plan_date']."'");
												$data_tbl_sales_plan = mysql_fetch_array($tbl_sales_plan);
												
												$tbl_sales_visit = mysql_query("SELECT *, sum(b.sales_visit_detail_product_sell_quantity) as sum_sales_visit_detail_product_sell_quantity FROM sales_visit a, sales_visit_detail b WHERE a.sales_plan_detail_id = '".$data_tbl_sales_plan['sales_plan_detail_id']."' AND a.sales_visit_id = b.sales_visit_id");
												$data_tbl_sales_visit = mysql_fetch_array($tbl_sales_visit);
												
												$tbl_sales_request_detail = mysql_query("SELECT *, sum(d.sales_request_detail_product_sell_quantity) as sum_sales_request_detail_product_sell_quantity FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date = '".$data_tbl_sales_request['sales_plan_date']."'");
												$data_tbl_sales_request_detail = mysql_fetch_array($tbl_sales_request_detail);
											?>
												
												<td align="center">
													 <?php echo $data_tbl_sales_visit['sum_sales_visit_detail_product_sell_quantity'] ?>
												</td>
												<td align="center">
													 <?php echo $data_tbl_sales_request_detail['sum_sales_request_detail_product_sell_quantity'] ?>
												</td>
										
										<?php		
											}
											
											$tbl_sum_sales_request_detail = mysql_query("SELECT sum(d.sales_request_detail_product_sell_quantity) as sales_request_detail_product_sell_quantity FROM sales_request a, sales_order b, sales_invoice c, sales_request_detail d WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND a.sales_request_id = d.sales_request_id AND c.sales_invoice_status = 'Posted' AND a.customer_id = '".$_POST['customer_id']."' AND a.sales_request_date like '%".$data_call_book_on_month."%'");
											$data_tbl_sum_sales_request_detail = mysql_fetch_array($tbl_sum_sales_request_detail);
											
											
											?>
												<td align="center">
													<?php echo $data_tbl_sum_sales_request_detail['sales_request_detail_product_sell_quantity'] ?>
												</td>
												<td align="center">
													<?php 
														if($sum_avg_sales_request_detail == "")
														{
															
														} else {
															echo $sum_avg_sales_request_detail;
														}
														 
													?>
												</td>
									</tr>
									
								</tbody>
							</table>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	

<?php
	}
?>