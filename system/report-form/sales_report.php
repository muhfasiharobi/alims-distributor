<?php
	function form_search_customer_by_quantity_product_sell_sales_report()
	{
?>
	<div class="page-fixed-main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">
								Laporan Penjualan
							</span>
							<span class="caption-helper sbold uppercase">
								Per Pelanggan Berdasarkan Jumlah Produk
							</span>
						</div>
					</div>
					<div class="form portlet-body">
						<form action="?alimms=sales-report&tib=form-view-customer-by-quantity-product-sell-sales-report" class="horizontal-form" id="form_sample_3" method="post">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_from_date" placeholder="Dari Tanggal" type="text">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_to_date" placeholder="Sampai Tanggal" type="text">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
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
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kecamatan
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#customer_districts_id" data-placeholder="Kecamatan" name="customer_districts_id">
													<option value=""></option>
													<option value="all">Semua</option>
													<?php
														$tbl_customer_districts = mysql_query("SELECT * FROM customer_districts WHERE customer_districts_active = '1' order by customer_districts_name");
														while($data_tbl_customer_districts = mysql_fetch_array($tbl_customer_districts))
														{
													?>
														<option value="<?php echo $data_tbl_customer_districts['customer_districts_id'] ?>"><?php echo $data_tbl_customer_districts['customer_districts_name'] ?></option>
													<?php
														}
													?>
											</select>
											<div id="customer_districts_id"></div>
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
	function form_view_customer_by_quantity_product_sell_sales_report()
	{
		$sales_invoice_from_date = explode("-", $_POST['sales_invoice_from_date']);
		$date_sales_invoice_from = $sales_invoice_from_date[0];
		$month_sales_invoice_from = $sales_invoice_from_date[1];
		$year_sales_invoice_from = $sales_invoice_from_date[2];
		$sales_invoice_from_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_invoice_from, $date_sales_invoice_from, $year_sales_invoice_from));
		
		$sales_invoice_from_date_indo = tanggal_indo($sales_invoice_from_date);
		
		$sales_invoice_to_date = explode("-", $_POST['sales_invoice_to_date']);
		$date_sales_invoice_to = $sales_invoice_to_date[0];
		$month_sales_invoice_to = $sales_invoice_to_date[1];
		$year_sales_invoice_to = $sales_invoice_to_date[2];
		$sales_invoice_to_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_invoice_to, $date_sales_invoice_to, $year_sales_invoice_to));
		
		$sales_invoice_to_date_indo = tanggal_indo($sales_invoice_to_date);
?>
	<div class="page-fixed-main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">
								Laporan Penjualan
							</span>
							<span class="caption-helper sbold uppercase">
								Per Pelanggan Berdasarkan Jumlah Produk
							</span>
						</div>
					</div>
					<div class="form portlet-body">
						<form action="?alimms=sales-report&tib=form-view-customer-by-quantity-product-sell-sales-report" class="horizontal-form" id="form_sample_3" method="post">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_from_date" placeholder="Dari Tanggal" type="text" value="<?php echo $_POST['sales_invoice_from_date'] ?>">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_to_date" placeholder="Sampai Tanggal" type="text" value="<?php echo $_POST['sales_invoice_to_date'] ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
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
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kecamatan
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#customer_districts_id" data-placeholder="Kecamatan" name="customer_districts_id">
													<option value=""></option>
													<option value="all">Semua</option>
													<?php
														$tbl_customer_districts = mysql_query("SELECT * FROM customer_districts WHERE customer_districts_active = '1' order by customer_districts_name");
														while($data_tbl_customer_districts = mysql_fetch_array($tbl_customer_districts))
														{
													?>
														<option value="<?php echo $data_tbl_customer_districts['customer_districts_id'] ?>"><?php echo $data_tbl_customer_districts['customer_districts_name'] ?></option>
													<?php
														}
													?>
											</select>
											<div id="customer_districts_id"></div>
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
								if ($_POST['sales_invoice_from_date'] == $_POST['sales_invoice_to_date'])
								{
							?>
								Tanggal <?php echo $sales_invoice_from_date_indo ?>
							<?php
								}
								else
								{
							?>
								Dari Tanggal <?php echo $sales_invoice_from_date_indo ?> Sampai Tanggal <?php echo $sales_invoice_to_date_indo ?>
							<?php
								}
							?>
							</span>
						</div>
					</div>
					<div class="portlet-body">
						<div class="table-responsive">
<?php
	if($_POST['salesman_id'] == "all"){
		
		$tbl_user = mysql_query("SELECT a.user_id, a.user_name FROM user a, user_category b WHERE a.user_category_id = b.user_category_id AND a.user_active = '1' AND b.user_category_name LIKE '%salesman%'");
		
	} else {
		
       $tbl_user = mysql_query("SELECT a.user_id, a.user_name FROM user a, user_category b WHERE a.user_category_id = b.user_category_id AND a.user_active = '1' AND b.user_category_name LIKE '%salesman%' AND a.user_id = '".$_POST['salesman_id']."'");
	   
	}
       while($data_tbl_user = mysql_fetch_array($tbl_user)){
?>
				<h5 class="font-blue sbold uppercase">
					<?php echo $data_tbl_user['user_name'] ?>
				</h5>
							<table class="table table-bordered table-hover table-striped">
								<thead>
									<tr>
										<th rowspan="3">
											No
										</th>
										<th rowspan="3">
											Pelanggan
										</th>
										<th rowspan="3">
											Kecamatan
										</th>
										<th rowspan="3">
											Frekuensi
										</th>
											<?php
												$tbl_sales_order_month = mysql_query("SELECT c.sales_invoice_date FROM sales_request a, sales_order b, sales_invoice c WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND c.sales_invoice_status = 'Posted' AND a.sales_request_active = '1' AND c.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' group by month(a.sales_request_date)");
												while($data_tbl_sales_order_month = mysql_fetch_array($tbl_sales_order_month)){
													
													$sales_invoice_date = explode("-",$data_tbl_sales_order_month['sales_invoice_date']);
													$date_sales_invoice_date = $sales_invoice_date[0];
													$month_sales_invoice_date = $sales_invoice_date[1];
													$year_sales_invoice_date = $sales_invoice_date[2];
													$sales_invoice_date_result = date("d", mktime(0, 0, 0, $year_sales_invoice_date, $month_sales_invoice_date, $date_sales_invoice_date));
													$sales_invoice_result_date_indo = bulan($sales_invoice_date_result);
													
											?>
										<th colspan="3">
											<?php echo $sales_invoice_result_date_indo; ?>
										</th>
										<?php
												}
										?>
										
									</tr>
									<tr>
										<?php
									
										$tbl_sales_order_month = mysql_query("SELECT c.sales_invoice_date FROM sales_request a, sales_order b, sales_invoice c WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND c.sales_invoice_status = 'Posted' AND a.sales_request_active = '1' AND c.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' group by month(a.sales_request_date)");
										while($data_tbl_sales_order_month = mysql_fetch_array($tbl_sales_order_month)){
											$tbl_product_sell = mysql_query("SELECT product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
											while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
											{
										?>
										
											<th>
												<?php echo $data_tbl_product_sell['product_sell_name'] ?>
											</th>
										<?php
											}
										}
										?>
									</tr>
									<tr>
									<?php
									$tbl_sales_order_month = mysql_query("SELECT c.sales_invoice_date FROM sales_request a, sales_order b, sales_invoice c WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND c.sales_invoice_status = 'Posted' AND a.sales_request_active = '1' AND c.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' group by month(a.sales_request_date)");
										while($data_tbl_sales_order_month = mysql_fetch_array($tbl_sales_order_month)){
										$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1'");
										while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
										{
									?>
										<th>
											Qty
										</th>
									<?php
										}
									}		
									?>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									if($_POST['customer_districts_id'] == "all"){
										
										$tbl_customer = mysql_query("SELECT COUNT(d.customer_id) AS customer_frequency_order, d.customer_id, d.customer_code, d.customer_name, d.customer_address, e.customer_category_name, f.customer_districts_name FROM sales_invoice a, sales_order b, sales_request c, customer d, customer_category e, customer_districts f WHERE c.salesman_id = '".$data_tbl_user['user_id']."' AND a.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' AND a.sales_invoice_status = 'Posted' AND d.customer_active = '1' AND e.customer_category_active = '1' AND f.customer_districts_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id GROUP BY d.customer_id ORDER BY f.customer_districts_name");
										
									}
									else
									{
										
										$tbl_customer = mysql_query("SELECT COUNT(d.customer_id) AS customer_frequency_order, d.customer_id, d.customer_code, d.customer_name, d.customer_address, e.customer_category_name, f.customer_districts_name FROM sales_invoice a, sales_order b, sales_request c, customer d, customer_category e, customer_districts f WHERE c.salesman_id = '".$data_tbl_user['user_id']."' AND a.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' AND a.sales_invoice_status = 'Posted' AND d.customer_active = '1' AND e.customer_category_active = '1' AND f.customer_districts_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id AND d.customer_districts_id = '".$_POST['customer_districts_id']."' GROUP BY d.customer_id ORDER BY f.customer_districts_name");
										
									} 
									
									while($data_tbl_customer = mysql_fetch_array($tbl_customer))
									{
								?>
									<tr>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_customer['customer_category_name'] ?> - <?php echo $data_tbl_customer['customer_code'] ?> - <?php echo $data_tbl_customer['customer_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_customer['customer_districts_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_customer['customer_frequency_order'] ?>
										</td>
										<?php
										$tbl_sales_order_month = mysql_query("SELECT c.sales_invoice_date FROM sales_request a, sales_order b, sales_invoice c WHERE a.sales_request_id = b.sales_request_id AND b.sales_order_id = c.sales_order_id AND c.sales_invoice_status = 'Posted' AND a.sales_request_active = '1' AND c.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' group by month(a.sales_request_date)");
										while($data_tbl_sales_order_month = mysql_fetch_array($tbl_sales_order_month)){
											$sales_invoice_date = explode("-",$data_tbl_sales_order_month['sales_invoice_date']);
											$date_sales_invoice_date = $sales_invoice_date[0];
											$month_sales_invoice_date = $sales_invoice_date[1];
											$year_sales_invoice_date = $sales_invoice_date[2];
											$sales_invoice_date_result = date("d", mktime(0, 0, 0, $year_sales_invoice_date, $month_sales_invoice_date, $date_sales_invoice_date));
													
											$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
											while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
											{
												$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_product_sell_quantity) AS sales_order_detail_product_sell_quantity, SUM(c.sales_order_detail_program_bonus) AS sales_order_detail_program_bonus, SUM(c.sales_order_detail_product_sell_quantity + c.sales_order_detail_program_bonus) AS sales_order_detail_product_sell_total_quantity FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE month(a.sales_invoice_date) = '".$sales_invoice_date_result."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.customer_id = '".$data_tbl_customer['customer_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
												$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
											
												$sales_order_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity']);
												$sales_order_detail_program_bonus_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_program_bonus']);
												$sales_order_detail_product_sell_total_quantity_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_total_quantity']);
										?>
											<td>
												<?php echo $sales_order_detail_product_sell_quantity_indo ?>
											</td>
										<?php
											}
										}
										?>
									</tr>
								<?php
									$no++;
									}
								?>
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
	function form_search_customer_city_by_sales_product_sell_sales_report()
	{
?>
	<div class="page-fixed-main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">
								Laporan Penjualan
							</span>
							<span class="caption-helper sbold uppercase">
								Per Kota/ Kabupaten Berdasarkan Penjualan Produk
							</span>
						</div>
					</div>
					<div class="form portlet-body">
						<form action="?alimms=sales-report&tib=form-view-customer-city-by-sales-product-sell-sales-report" class="horizontal-form" id="form_sample_3" method="post">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_from_date" placeholder="Dari Tanggal" type="text">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_to_date" placeholder="Sampai Tanggal" type="text">
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
	function form_view_customer_city_by_sales_product_sell_sales_report()
	{
		$sales_invoice_from_date = explode("-", $_POST['sales_invoice_from_date']);
		$date_sales_invoice_from = $sales_invoice_from_date[0];
		$month_sales_invoice_from = $sales_invoice_from_date[1];
		$year_sales_invoice_from = $sales_invoice_from_date[2];
		$sales_invoice_from_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_invoice_from, $date_sales_invoice_from, $year_sales_invoice_from));
		
		$sales_invoice_from_date_indo = tanggal_indo($sales_invoice_from_date);
		
		$sales_invoice_to_date = explode("-", $_POST['sales_invoice_to_date']);
		$date_sales_invoice_to = $sales_invoice_to_date[0];
		$month_sales_invoice_to = $sales_invoice_to_date[1];
		$year_sales_invoice_to = $sales_invoice_to_date[2];
		$sales_invoice_to_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_invoice_to, $date_sales_invoice_to, $year_sales_invoice_to));
		
		$sales_invoice_to_date_indo = tanggal_indo($sales_invoice_to_date);
?>
	<div class="page-fixed-main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">
								Laporan Penjualan
							</span>
							<span class="caption-helper sbold uppercase">
								Per Kota/ Kabupaten Berdasarkan Penjualan Produk
							</span>
						</div>
					</div>
					<div class="form portlet-body">
						<form action="?alimms=sales-report&tib=form-view-customer-city-by-sales-product-sell-sales-report" class="horizontal-form" id="form_sample_3" method="post">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_from_date" placeholder="Dari Tanggal" type="text" value="<?php echo $_POST['sales_invoice_from_date'] ?>">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_to_date" placeholder="Sampai Tanggal" type="text" value="<?php echo $_POST['sales_invoice_to_date'] ?>">
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
								if ($_POST['sales_invoice_from_date'] == $_POST['sales_invoice_to_date'])
								{
							?>
								Tanggal <?php echo $sales_invoice_from_date_indo ?>
							<?php
								}
								else
								{
							?>
								Dari Tanggal <?php echo $sales_invoice_from_date_indo ?> Sampai Tanggal <?php echo $sales_invoice_to_date_indo ?>
							<?php
								}
							?>
							</span>
						</div>
					</div>
					<?php
						$tbl_customer_city = mysql_query("SELECT f.customer_city_id, f.customer_city_name FROM sales_invoice a, sales_order b, sales_request c, customer d, customer_districts e, customer_city f WHERE a.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' AND a.sales_invoice_status = 'Posted' AND d.customer_active = '1' AND e.customer_districts_active = '1' AND f.customer_city_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.customer_id = d.customer_id AND d.customer_districts_id = e.customer_districts_id AND e.customer_city_id = f.customer_city_id GROUP BY f.customer_city_id ORDER BY f.customer_city_name");
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
											<th>
												Penjualan
											</th>
											<th>
												Program Bonus
											</th>
											<th>
												Potongan Diskon (Rp)
											</th>
											<th>
												Diskon Pembelian Tunai (%)
											</th>
											<th>
												Biaya Pengiriman
											</th>
											<th>
												Sub Total
											</th>
										</tr>
									</thead>
									<tbody>
									<?php
										$no = 1;
										$tbl_customer_districts = mysql_query("SELECT e.customer_districts_id, e.customer_districts_name FROM sales_invoice a, sales_order b, sales_request c, customer d, customer_districts e WHERE a.sales_invoice_status = 'Posted' AND d.customer_active = '1' AND e.customer_city_id = '".$data_tbl_customer_city['customer_city_id']."' AND e.customer_districts_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.customer_id = d.customer_id AND d.customer_districts_id = e.customer_districts_id GROUP BY e.customer_districts_id ORDER BY e.customer_districts_name");
										while($data_tbl_customer_districts = mysql_fetch_array($tbl_customer_districts))
										{
											$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_product_sell_quantity * c.sales_order_detail_product_sell_price) AS total_price_product_sell, SUM(c.sales_order_detail_program_bonus * g.product_sell_price_detail_product_sell_price) AS total_price_program_bonus, SUM(c.sales_order_detail_product_sell_quantity * c.sales_order_detail_piece_discount) AS total_price_piece_discount, SUM(c.sales_order_detail_product_sell_quantity * c.sales_order_detail_cash_discount) AS total_price_cash_discount, SUM((c.sales_order_detail_product_sell_quantity + c.sales_order_detail_program_bonus) * c.sales_order_detail_delivery_cost_price) AS total_price_delivery_cost_price, SUM((c.sales_order_detail_product_sell_quantity * c.sales_order_detail_product_sell_price) - (c.sales_order_detail_program_bonus * g.product_sell_price_detail_product_sell_price) - (c.sales_order_detail_product_sell_quantity * c.sales_order_detail_piece_discount) - (c.sales_order_detail_product_sell_quantity * c.sales_order_detail_cash_discount) + ((c.sales_order_detail_product_sell_quantity + c.sales_order_detail_program_bonus) * c.sales_order_detail_delivery_cost_price)) AS sub_total_price_sales_product_sell FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, customer e, product_sell_price f, product_sell_price_detail g WHERE a.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' AND a.sales_invoice_status = 'Posted' AND e.customer_districts_id = '".$data_tbl_customer_districts['customer_districts_id']."' AND f.product_sell_price_name = 'HPP' AND f.product_sell_price_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND c.product_sell_id = g.product_sell_id AND d.customer_id = e.customer_id AND f.product_sell_price_id = g.product_sell_price_id");
											$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
										
											$total_price_product_sell_indo = format_angka($data_tbl_sales_order_detail['total_price_product_sell']);
											$total_price_program_bonus_indo = format_angka($data_tbl_sales_order_detail['total_price_program_bonus']);
											$total_price_piece_discount_indo = format_angka($data_tbl_sales_order_detail['total_price_piece_discount']);
											$total_price_cash_discount_indo = format_angka($data_tbl_sales_order_detail['total_price_cash_discount']);
											$total_price_delivery_cost_price_indo = format_angka($data_tbl_sales_order_detail['total_price_delivery_cost_price']);
											$sub_total_price_sales_product_sell_indo = format_angka($data_tbl_sales_order_detail['sub_total_price_sales_product_sell']);
									?>
										<tr>
											<td>
												<?php echo $no ?>
											</td>
											<td>
												<?php echo $data_tbl_customer_districts['customer_districts_name'] ?>
											</td>
											<td>
												<?php echo $total_price_product_sell_indo ?>
											</td>
											<td>
												<?php echo $total_price_program_bonus_indo ?>
											</td>
											<td>
												<?php echo $total_price_piece_discount_indo ?>
											</td>
											<td>
												<?php echo $total_price_cash_discount_indo ?>
											</td>
											<td>
												<?php echo $total_price_delivery_cost_price_indo ?>
											</td>
											<td>
												<?php echo $sub_total_price_sales_product_sell_indo ?>
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
	function form_search_customer_city_by_quantity_product_sell_sales_report()
	{
?>
	<div class="page-fixed-main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">
								Laporan Penjualan
							</span>
							<span class="caption-helper sbold uppercase">
								Per Kota/ Kabupaten Berdasarkan Jumlah Produk
							</span>
						</div>
					</div>
					<div class="form portlet-body">
						<form action="?alimms=sales-report&tib=form-view-customer-city-by-quantity-product-sell-sales-report" class="horizontal-form" id="form_sample_3" method="post">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_from_date" placeholder="Dari Tanggal" type="text">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_to_date" placeholder="Sampai Tanggal" type="text">
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
	function form_view_customer_city_by_quantity_product_sell_sales_report()
	{
		$sales_invoice_from_date = explode("-", $_POST['sales_invoice_from_date']);
		$date_sales_invoice_from = $sales_invoice_from_date[0];
		$month_sales_invoice_from = $sales_invoice_from_date[1];
		$year_sales_invoice_from = $sales_invoice_from_date[2];
		$sales_invoice_from_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_invoice_from, $date_sales_invoice_from, $year_sales_invoice_from));
		
		$sales_invoice_from_date_indo = tanggal_indo($sales_invoice_from_date);
		
		$sales_invoice_to_date = explode("-", $_POST['sales_invoice_to_date']);
		$date_sales_invoice_to = $sales_invoice_to_date[0];
		$month_sales_invoice_to = $sales_invoice_to_date[1];
		$year_sales_invoice_to = $sales_invoice_to_date[2];
		$sales_invoice_to_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_invoice_to, $date_sales_invoice_to, $year_sales_invoice_to));
		
		$sales_invoice_to_date_indo = tanggal_indo($sales_invoice_to_date);
?>
	<div class="page-fixed-main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">
								Laporan Penjualan
							</span>
							<span class="caption-helper sbold uppercase">
								Per Kota/ Kabupaten Berdasarkan Jumlah Produk
							</span>
						</div>
					</div>
					<div class="form portlet-body">
						<form action="?alimms=sales-report&tib=form-view-customer-city-by-quantity-product-sell-sales-report" class="horizontal-form" id="form_sample_3" method="post">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_from_date" placeholder="Dari Tanggal" type="text" value="<?php echo $_POST['sales_invoice_from_date'] ?>">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_to_date" placeholder="Sampai Tanggal" type="text" value="<?php echo $_POST['sales_invoice_to_date'] ?>">
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
								if ($_POST['sales_invoice_from_date'] == $_POST['sales_invoice_to_date'])
								{
							?>
								Tanggal <?php echo $sales_invoice_from_date_indo ?>
							<?php
								}
								else
								{
							?>
								Dari Tanggal <?php echo $sales_invoice_from_date_indo ?> Sampai Tanggal <?php echo $sales_invoice_to_date_indo ?>
							<?php
								}
							?>
							</span>
						</div>
					</div>
					<?php
						$tbl_customer_city = mysql_query("SELECT f.customer_city_id, f.customer_city_name FROM sales_invoice a, sales_order b, sales_request c, customer d, customer_districts e, customer_city f WHERE a.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' AND a.sales_invoice_status = 'Posted' AND d.customer_active = '1' AND e.customer_districts_active = '1' AND f.customer_city_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.customer_id = d.customer_id AND d.customer_districts_id = e.customer_districts_id AND e.customer_city_id = f.customer_city_id GROUP BY f.customer_city_id ORDER BY f.customer_city_name");
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
											<th rowspan="2">
												No
											</th>
											<th rowspan="2">
												Kecamatan
											</th>
											<?php
												$tbl_product_sell = mysql_query("SELECT product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
												while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
												{
											?>
												<th colspan="3">
													<?php echo $data_tbl_product_sell['product_sell_name'] ?>
												</th>
											<?php
												}
											?>
										</tr>
										<tr>
										<?php
											$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1'");
											while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
											{
										?>
											<th>
												Jumlah
											</th>
											<th>
												Bonus
											</th>
											<th>
												Total
											</th>
										<?php
											}
										?>
										</tr>
									</thead>
									<tbody>
									<?php
										$no = 1;
										$tbl_customer_districts = mysql_query("SELECT e.customer_districts_id, e.customer_districts_name FROM sales_invoice a, sales_order b, sales_request c, customer d, customer_districts e WHERE a.sales_invoice_status = 'Posted' AND d.customer_active = '1' AND e.customer_city_id = '".$data_tbl_customer_city['customer_city_id']."' AND e.customer_districts_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.customer_id = d.customer_id AND d.customer_districts_id = e.customer_districts_id GROUP BY e.customer_districts_id ORDER BY e.customer_districts_name");
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
												$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
												while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
												{
													$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_product_sell_quantity) AS sales_order_detail_product_sell_quantity, SUM(c.sales_order_detail_program_bonus) AS sales_order_detail_program_bonus, SUM(c.sales_order_detail_product_sell_quantity + c.sales_order_detail_program_bonus) AS total_quantity_product_sell FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, customer e WHERE a.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND e.customer_districts_id = '".$data_tbl_customer_districts['customer_districts_id']."' AND e.customer_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.customer_id = e.customer_id");
													$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
												
													$sales_order_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity']);
													$sales_order_detail_program_bonus_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_program_bonus']);
													$total_quantity_product_sell_indo = format_angka($data_tbl_sales_order_detail['total_quantity_product_sell']);
											?>
												<td>
													<?php echo $sales_order_detail_product_sell_quantity_indo ?>
												</td>
												<td>
													<?php echo $sales_order_detail_program_bonus_indo ?>
												</td>
												<td>
													<?php echo $total_quantity_product_sell_indo ?>
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
	function form_search_salesman_by_sales_invoice_sales_report()
	{
?>
	<div class="page-fixed-main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">
								Laporan Penjualan
							</span>
							<span class="caption-helper sbold uppercase">
								Per Salesman Berdasarkan Faktur Penjualan
							</span>
						</div>
					</div>
					<div class="form portlet-body">
						<form action="?alimms=sales-report&tib=form-view-salesman-by-sales-invoice-sales-report" class="horizontal-form" id="form_sample_3" method="post">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_from_date" placeholder="Dari Tanggal" type="text">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_to_date" placeholder="Sampai Tanggal" type="text">
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
	function form_view_salesman_by_sales_invoice_sales_report()
	{
		$sales_invoice_from_date = explode("-", $_POST['sales_invoice_from_date']);
		$date_sales_invoice_from = $sales_invoice_from_date[0];
		$month_sales_invoice_from = $sales_invoice_from_date[1];
		$year_sales_invoice_from = $sales_invoice_from_date[2];
		$sales_invoice_from_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_invoice_from, $date_sales_invoice_from, $year_sales_invoice_from));
		
		$sales_invoice_from_date_indo = tanggal_indo($sales_invoice_from_date);
		
		$sales_invoice_to_date = explode("-", $_POST['sales_invoice_to_date']);
		$date_sales_invoice_to = $sales_invoice_to_date[0];
		$month_sales_invoice_to = $sales_invoice_to_date[1];
		$year_sales_invoice_to = $sales_invoice_to_date[2];
		$sales_invoice_to_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_invoice_to, $date_sales_invoice_to, $year_sales_invoice_to));
		
		$sales_invoice_to_date_indo = tanggal_indo($sales_invoice_to_date);
?>
	<div class="page-fixed-main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">
								Laporan Penjualan
							</span>
							<span class="caption-helper sbold uppercase">
								Per Salesman Berdasarkan Faktur Penjualan
							</span>
						</div>
					</div>
					<div class="form portlet-body">
						<form action="?alimms=sales-report&tib=form-view-salesman-by-sales-invoice-sales-report" class="horizontal-form" id="form_sample_3" method="post">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_from_date" placeholder="Dari Tanggal" type="text" value="<?php echo $_POST['sales_invoice_from_date'] ?>">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_to_date" placeholder="Sampai Tanggal" type="text" value="<?php echo $_POST['sales_invoice_to_date'] ?>">
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
								if ($_POST['sales_invoice_from_date'] == $_POST['sales_invoice_to_date'])
								{
							?>
								Tanggal <?php echo $sales_invoice_from_date_indo ?>
							<?php
								}
								else
								{
							?>
								Dari Tanggal <?php echo $sales_invoice_from_date_indo ?> Sampai Tanggal <?php echo $sales_invoice_to_date_indo ?>
							<?php
								}
							?>
							</span>
						</div>
					</div>
					<?php
						$tbl_user = mysql_query("SELECT d.user_id, d.user_name FROM sales_invoice a, sales_order b, sales_request c, user d WHERE a.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' AND a.sales_invoice_status = 'Posted' AND d.user_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.salesman_id = d.user_id GROUP BY d.user_id ORDER BY d.user_name");
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
												Faktur
											</th>
											<th rowspan="2">
												Pelanggan
											</th>
											<th rowspan="2">
												Kecamatan
											</th>
											<?php
												$tbl_product_sell = mysql_query("SELECT product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
												while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
												{
											?>
												<th colspan="4">
													<?php echo $data_tbl_product_sell['product_sell_name'] ?>
												</th>
											<?php
												}
											?>
										</tr>
										<tr>
											<?php
												$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1'");
												while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
												{
											?>
												<th>
													Jumlah
												</th>
												<th>
													Bonus
												</th>
												<th>
													Harga Jual
												</th>
												<th>
													Sub Total
												</th>
											<?php
												}
											?>
										</tr>
									</thead>
									<tbody>
									<?php
										$no = 1;
										$tbl_invoice = mysql_query("SELECT a.sales_invoice_no, a.sales_invoice_date, b.sales_order_id, d.customer_code, d.customer_name, e.customer_category_name, f.customer_districts_name FROM sales_invoice a, sales_order b, sales_request c, customer d, customer_category e, customer_districts f WHERE a.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' AND a.sales_invoice_status = 'Posted' AND c.salesman_id = '".$data_tbl_user['user_id']."' AND d.customer_active = '1' AND e.customer_category_active = '1' AND f.customer_districts_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id ORDER BY a.sales_invoice_no");
										while($data_tbl_invoice = mysql_fetch_array($tbl_invoice))
										{
											$sales_invoice_date_indo = tanggal_indo($data_tbl_invoice['sales_invoice_date']);
									?>
										<tr>
											<td>
												<?php echo $no ?>
											</td>
											<td>
												<?php echo $data_tbl_invoice['sales_invoice_no'] ?><br />
												<?php echo $sales_invoice_date_indo ?>
											</td>
											<td>
												<?php echo $data_tbl_invoice['customer_category_name'] ?> - <?php echo $data_tbl_invoice['customer_code'] ?> - <?php echo $data_tbl_invoice['customer_name'] ?>
											</td>
											<td>
												<?php echo $data_tbl_invoice['customer_districts_name'] ?>
											</td>
											<?php
												$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1'");
												while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
												{
													$tbl_sales_order_detail = mysql_query("SELECT sales_order_detail_product_sell_quantity, sales_order_detail_program_bonus, (sales_order_detail_product_sell_price - sales_order_detail_piece_discount - sales_order_detail_cash_discount) AS sales_order_detail_product_sell_price, (sales_order_detail_product_sell_quantity * (sales_order_detail_product_sell_price - sales_order_detail_piece_discount - sales_order_detail_cash_discount)) AS sub_total_price_sales_product_sell FROM sales_order_detail WHERE sales_order_id = '".$data_tbl_invoice['sales_order_id']."' AND product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
													$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
												
													$sales_order_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity']);
													$sales_order_detail_program_bonus_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_program_bonus']);
													$sales_order_detail_product_sell_price_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_price']);
													$sub_total_price_sales_product_sell_indo = format_angka($data_tbl_sales_order_detail['sub_total_price_sales_product_sell']);
											?>
												<td>
													<?php echo $sales_order_detail_product_sell_quantity_indo ?>
												</td>
												<td>
													<?php echo $sales_order_detail_program_bonus_indo ?>
												</td>
												<td>
													<?php echo $sales_order_detail_product_sell_price_indo ?>
												</td>
												<td>
													<?php echo $sub_total_price_sales_product_sell_indo ?>
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
                    
                    <div aria-hidden="true" class="modal fade" id="print_sales_report<?php echo $sales_invoice_from_date; $sales_invoice_to_date; ?>" role="basic" tabindex="-1">
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
                            <a class="btn btn-outline btn-sm green sbold" href="printable-version/sales_report.php?tib=form-print-by-salesman-sales-invoice-sales-report&sales_invoice_from_date=<?php echo $sales_invoice_from_date ?>&sales_invoice_to_date=<?php echo $sales_invoice_to_date ?>">
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
<?php
	}
	function form_search_salesman_by_sales_product_sell_sales_report()
	{
?>
	<div class="page-fixed-main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">
								Laporan Penjualan
							</span>
							<span class="caption-helper sbold uppercase">
								Per Salesman Berdasarkan Penjualan Produk
							</span>
						</div>
					</div>
					<div class="form portlet-body">
						<form action="?alimms=sales-report&tib=form-view-salesman-by-sales-product-sell-sales-report" class="horizontal-form" id="form_sample_3" method="post">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_from_date" placeholder="Dari Tanggal" type="text">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_to_date" placeholder="Sampai Tanggal" type="text">
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
	function form_view_salesman_by_sales_product_sell_sales_report()
	{
		$sales_invoice_from_date = explode("-", $_POST['sales_invoice_from_date']);
		$date_sales_invoice_from = $sales_invoice_from_date[0];
		$month_sales_invoice_from = $sales_invoice_from_date[1];
		$year_sales_invoice_from = $sales_invoice_from_date[2];
		$sales_invoice_from_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_invoice_from, $date_sales_invoice_from, $year_sales_invoice_from));
		
		$sales_invoice_from_date_indo = tanggal_indo($sales_invoice_from_date);
		
		$sales_invoice_to_date = explode("-", $_POST['sales_invoice_to_date']);
		$date_sales_invoice_to = $sales_invoice_to_date[0];
		$month_sales_invoice_to = $sales_invoice_to_date[1];
		$year_sales_invoice_to = $sales_invoice_to_date[2];
		$sales_invoice_to_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_invoice_to, $date_sales_invoice_to, $year_sales_invoice_to));
		
		$sales_invoice_to_date_indo = tanggal_indo($sales_invoice_to_date);
?>
	<div class="page-fixed-main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">
								Laporan Penjualan
							</span>
							<span class="caption-helper sbold uppercase">
								Per Salesman Berdasarkan Penjualan Produk
							</span>
						</div>
					</div>
					<div class="form portlet-body">
						<form action="?alimms=sales-report&tib=form-view-salesman-by-sales-product-sell-sales-report" class="horizontal-form" id="form_sample_3" method="post">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_from_date" placeholder="Dari Tanggal" type="text" value="<?php echo $_POST['sales_invoice_from_date'] ?>">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_to_date" placeholder="Sampai Tanggal" type="text" value="<?php echo $_POST['sales_invoice_to_date'] ?>">
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
								if ($_POST['sales_invoice_from_date'] == $_POST['sales_invoice_to_date'])
								{
							?>
								Tanggal <?php echo $sales_invoice_from_date_indo ?>
							<?php
								}
								else
								{
							?>
								Dari Tanggal <?php echo $sales_invoice_from_date_indo ?> Sampai Tanggal <?php echo $sales_invoice_to_date_indo ?>
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
											Penjualan
										</th>
										<th>
											Program Bonus
										</th>
										<th>
											Potongan Diskon (Rp)
										</th>
										<th>
											Diskon Pembelian Tunai (%)
										</th>
										<th>
											Biaya Pengiriman
										</th>
										<th>
											Sub Tota
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_user = mysql_query("SELECT d.user_id, d.user_name FROM sales_invoice a, sales_order b, sales_request c, user d WHERE a.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' AND a.sales_invoice_status = 'Posted' AND d.user_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.salesman_id = d.user_id GROUP BY d.user_id ORDER BY d.user_name");
									while($data_tbl_user = mysql_fetch_array($tbl_user))
									{

										$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_product_sell_quantity * c.sales_order_detail_product_sell_price) AS total_price_product_sell, SUM(c.sales_order_detail_program_bonus * f.product_sell_price_detail_product_sell_price) AS total_price_program_bonus, SUM(c.sales_order_detail_product_sell_quantity * c.sales_order_detail_piece_discount) AS total_price_piece_discount, SUM(c.sales_order_detail_product_sell_quantity * c.sales_order_detail_cash_discount) AS total_price_cash_discount, SUM((c.sales_order_detail_product_sell_quantity + c.sales_order_detail_program_bonus) * c.sales_order_detail_delivery_cost_price) AS total_price_delivery_cost_price, SUM((c.sales_order_detail_product_sell_quantity * c.sales_order_detail_product_sell_price) - (c.sales_order_detail_program_bonus * f.product_sell_price_detail_product_sell_price) - (c.sales_order_detail_product_sell_quantity * c.sales_order_detail_piece_discount) - (c.sales_order_detail_product_sell_quantity * c.sales_order_detail_cash_discount) + ((c.sales_order_detail_product_sell_quantity + c.sales_order_detail_program_bonus) * c.sales_order_detail_delivery_cost_price)) AS sub_total_price_sales_product_sell FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, product_sell_price e, product_sell_price_detail f WHERE a.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' AND a.sales_invoice_status = 'Posted' AND e.product_sell_price_name = 'HPP' AND d.salesman_id = '".$data_tbl_user['user_id']."' AND e.product_sell_price_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND c.product_sell_id = f.product_sell_id AND e.product_sell_price_id = f.product_sell_price_id");
										$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
									
										$total_price_product_sell_indo = format_angka($data_tbl_sales_order_detail['total_price_product_sell']);
										$total_price_program_bonus_indo = format_angka($data_tbl_sales_order_detail['total_price_program_bonus']);
										$total_price_piece_discount_indo = format_angka($data_tbl_sales_order_detail['total_price_piece_discount']);
										$total_price_cash_discount_indo = format_angka($data_tbl_sales_order_detail['total_price_cash_discount']);
										$total_price_delivery_cost_price_indo = format_angka($data_tbl_sales_order_detail['total_price_delivery_cost_price']);
										$sub_total_price_sales_product_sell_indo = format_angka($data_tbl_sales_order_detail['sub_total_price_sales_product_sell']);
										
										$tbl_sum_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_product_sell_quantity * c.sales_order_detail_product_sell_price) AS total_price_product_sell, SUM(c.sales_order_detail_program_bonus * f.product_sell_price_detail_product_sell_price) AS total_price_program_bonus, SUM(c.sales_order_detail_product_sell_quantity * c.sales_order_detail_piece_discount) AS total_price_piece_discount, SUM(c.sales_order_detail_product_sell_quantity * c.sales_order_detail_cash_discount) AS total_price_cash_discount, SUM((c.sales_order_detail_product_sell_quantity + c.sales_order_detail_program_bonus) * c.sales_order_detail_delivery_cost_price) AS total_price_delivery_cost_price, SUM((c.sales_order_detail_product_sell_quantity * c.sales_order_detail_product_sell_price) - (c.sales_order_detail_program_bonus * f.product_sell_price_detail_product_sell_price) - (c.sales_order_detail_product_sell_quantity * c.sales_order_detail_piece_discount) - (c.sales_order_detail_product_sell_quantity * c.sales_order_detail_cash_discount) + ((c.sales_order_detail_product_sell_quantity + c.sales_order_detail_program_bonus) * c.sales_order_detail_delivery_cost_price)) AS sub_total_price_sales_product_sell FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, product_sell_price e, product_sell_price_detail f WHERE a.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' AND a.sales_invoice_status = 'Posted' AND e.product_sell_price_name = 'HPP' AND  e.product_sell_price_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND c.product_sell_id = f.product_sell_id AND e.product_sell_price_id = f.product_sell_price_id");
										$data_tbl_sum_sales_order_detail = mysql_fetch_array($tbl_sum_sales_order_detail);
										
										$sum_price_product_sell_indo = format_angka($data_tbl_sum_sales_order_detail['total_price_product_sell']);
										$sum_price_program_bonus_indo = format_angka($data_tbl_sum_sales_order_detail['total_price_program_bonus']);
										$sum_price_piece_discount_indo = format_angka($data_tbl_sum_sales_order_detail['total_price_piece_discount']);
										$sum_price_cash_discount_indo = format_angka($data_tbl_sum_sales_order_detail['total_price_cash_discount']);
										$sum_price_delivery_cost_price_indo = format_angka($data_tbl_sum_sales_order_detail['total_price_delivery_cost_price']);
										$sum_sub_total_price_sales_product_sell_indo = format_angka($data_tbl_sum_sales_order_detail['sub_total_price_sales_product_sell']);
										
								?>
									<tr>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_user['user_name'] ?>
										</td>
										<td>
											<?php echo $total_price_product_sell_indo ?>
										</td>
										<td>
											<?php echo $total_price_program_bonus_indo ?>
										</td>
										<td>
											<?php echo $total_price_piece_discount_indo ?>
										</td>
										<td>
											<?php echo $total_price_cash_discount_indo ?>
										</td>
										<td>
											<?php echo $total_price_delivery_cost_price_indo ?>
										</td>
										<td>
											<?php echo $sub_total_price_sales_product_sell_indo ?>
										</td>
									</tr>
								<?php
									$no++;
									}
								?>
								<tr>
									<td colspan="2">Total</td>
									<td><?php echo $sum_price_product_sell_indo ?> </td>
									<td><?php echo $sum_price_program_bonus_indo ?> </td>
									<td><?php echo $sum_price_piece_discount_indo ?> </td>
									<td><?php echo $sum_price_cash_discount_indo ?> </td>
									<td><?php echo $sum_price_delivery_cost_price_indo ?> </td>
									<td><?php echo $sum_sub_total_price_sales_product_sell_indo ?> </td>
								</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="form-actions right">
						<a class="btn btn-sm btn-outline purple sbold" data-original-title="Cetak" data-toggle="modal" href="#export_sales_report<?php echo $sales_invoice_from_date; $sales_invoice_to_date; ?>">
							<i class="fa fa-print"></i>
								Export
						</a>
					</div>
					<div aria-hidden="true" class="modal fade" id="export_sales_report<?php echo $sales_invoice_from_date; $sales_invoice_to_date; ?>" role="basic" tabindex="-1">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h4 class="modal-title">
											Konfirmasi
										</h4>
								</div>
								<div class="modal-body">
											Apakah Anda Yakin Ingin Export Data Ini ?
								</div>
								<div class="modal-footer">
									<a class="btn btn-outline btn-sm green sbold" href="export_report.php?tib=export-by-product-sell&sales_invoice_from_date=<?php echo $sales_invoice_from_date; ?>&sales_invoice_to_date=<?php echo $sales_invoice_to_date; ?>">
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
<?php
	}
	function form_search_salesman_by_quantity_product_sell_sales_report()
	{
?>
	<div class="page-fixed-main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">
								Laporan Penjualan
							</span>
							<span class="caption-helper sbold uppercase">
								Per Salesman Berdasarkan Jumlah Produk
							</span>
						</div>
					</div>
					<div class="form portlet-body">
						<form action="?alimms=sales-report&tib=form-view-salesman-by-quantity-product-sell-sales-report" class="horizontal-form" id="form_sample_3" method="post">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_from_date" placeholder="Dari Tanggal" type="text">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_to_date" placeholder="Sampai Tanggal" type="text">
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
	function form_view_salesman_by_quantity_product_sell_sales_report()
	{
		$sales_invoice_from_date = explode("-", $_POST['sales_invoice_from_date']);
		$date_sales_invoice_from = $sales_invoice_from_date[0];
		$month_sales_invoice_from = $sales_invoice_from_date[1];
		$year_sales_invoice_from = $sales_invoice_from_date[2];
		$sales_invoice_from_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_invoice_from, $date_sales_invoice_from, $year_sales_invoice_from));
		
		$sales_invoice_from_date_indo = tanggal_indo($sales_invoice_from_date);
		
		$sales_invoice_to_date = explode("-", $_POST['sales_invoice_to_date']);
		$date_sales_invoice_to = $sales_invoice_to_date[0];
		$month_sales_invoice_to = $sales_invoice_to_date[1];
		$year_sales_invoice_to = $sales_invoice_to_date[2];
		$sales_invoice_to_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_invoice_to, $date_sales_invoice_to, $year_sales_invoice_to));
		
		$sales_invoice_to_date_indo = tanggal_indo($sales_invoice_to_date);
?>
	<div class="page-fixed-main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">
								Laporan Penjualan
							</span>
							<span class="caption-helper sbold uppercase">
								Per Salesman Berdasarkan Jumlah Produk
							</span>
						</div>
					</div>
					<div class="form portlet-body">
						<form action="?alimms=sales-report&tib=form-view-salesman-by-quantity-product-sell-sales-report" class="horizontal-form" id="form_sample_3" method="post">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_from_date" placeholder="Dari Tanggal" type="text" value="<?php echo $_POST['sales_invoice_from_date'] ?>">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_to_date" placeholder="Sampai Tanggal" type="text" value="<?php echo $_POST['sales_invoice_to_date'] ?>">
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
								if ($_POST['sales_invoice_from_date'] == $_POST['sales_invoice_to_date'])
								{
							?>
								Tanggal <?php echo $sales_invoice_from_date_indo ?>
							<?php
								}
								else
								{
							?>
								Dari Tanggal <?php echo $sales_invoice_from_date_indo ?> Sampai Tanggal <?php echo $sales_invoice_to_date_indo ?>
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
										<?php
											$tbl_product_sell = mysql_query("SELECT product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
											while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
											{
										?>
											<th colspan="3">
												<?php echo $data_tbl_product_sell['product_sell_name'] ?>
											</th>
										<?php
											}
										?>
									</tr>
									<tr>
									<?php
										$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1'");
										while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
										{
									?>
										<th>
											Jumlah
										</th>
										<th>
											Bonus
										</th>
										<th>
											Total
										</th>
									<?php
										}
									?>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_user = mysql_query("SELECT d.user_id, d.user_name FROM sales_invoice a, sales_order b, sales_request c, user d WHERE a.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' AND a.sales_invoice_status = 'Posted' AND d.user_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.salesman_id = d.user_id GROUP BY d.user_id ORDER BY d.user_name");
									while($data_tbl_user = mysql_fetch_array($tbl_user))
									{
								?>
									<tr>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_user['user_name'] ?>
										</td>
										<?php
											$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
											while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
											{
												$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_product_sell_quantity) AS sales_order_detail_product_sell_quantity, SUM(c.sales_order_detail_program_bonus) AS sales_order_detail_program_bonus, SUM(c.sales_order_detail_product_sell_quantity + c.sales_order_detail_program_bonus) AS sales_order_detail_product_sell_total_quantity FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE a.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.salesman_id = '".$data_tbl_user['user_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
												$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
											
												$sales_order_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity']);
												$sales_order_detail_program_bonus_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_program_bonus']);
												$sales_order_detail_product_sell_total_quantity_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_total_quantity']);
										?>
											<td>
												<?php echo $sales_order_detail_product_sell_quantity_indo ?>
											</td>
											<td>
												<?php echo $sales_order_detail_program_bonus_indo ?>
											</td>
											<td>
												<?php echo $sales_order_detail_product_sell_total_quantity_indo ?>
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
						<div class="form-actions right">
							<a class="btn btn-sm btn-outline purple sbold" data-original-title="Cetak" data-toggle="modal" href="#export_sales_report<?php echo $sales_invoice_from_date; $sales_invoice_to_date; ?>">
								<i class="fa fa-print"></i>
									Export
							</a>
						</div>
						<div aria-hidden="true" class="modal fade" id="export_sales_report<?php echo $sales_invoice_from_date; $sales_invoice_to_date; ?>" role="basic" tabindex="-1">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h4 class="modal-title">
												Konfirmasi
											</h4>
									</div>
									<div class="modal-body">
												Apakah Anda Yakin Ingin Export Data Ini ?
									</div>
									<div class="modal-footer">
										<a class="btn btn-outline btn-sm green sbold" href="export_report.php?tib=export-by-quantity&sales_invoice_from_date=<?php echo $sales_invoice_from_date; ?>&sales_invoice_to_date=<?php echo $sales_invoice_to_date; ?>">
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
<?php
	}
	function form_search_salesman_by_sales_invoice_sales_report_edit()
	{
?>
	<div class="page-fixed-main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">
								Laporan Penjualan
							</span>
							<span class="caption-helper sbold uppercase">
								Per Salesman Berdasarkan Faktur Penjualan
							</span>
						</div>
					</div>
					<div class="form portlet-body">
						<form action="?alimms=sales-report&tib=form-view-salesman-by-sales-invoice-sales-report-edit" class="horizontal-form" id="form_sample_3" method="post">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_from_date" placeholder="Dari Tanggal" type="text">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_to_date" placeholder="Sampai Tanggal" type="text">
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
	function form_view_salesman_by_sales_invoice_sales_report_edit()
	{
		$sales_invoice_from_date = explode("-", $_POST['sales_invoice_from_date']);
		$date_sales_invoice_from = $sales_invoice_from_date[0];
		$month_sales_invoice_from = $sales_invoice_from_date[1];
		$year_sales_invoice_from = $sales_invoice_from_date[2];
		$sales_invoice_from_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_invoice_from, $date_sales_invoice_from, $year_sales_invoice_from));
		
		$sales_invoice_from_date_indo = tanggal_indo($sales_invoice_from_date);
		
		$sales_invoice_to_date = explode("-", $_POST['sales_invoice_to_date']);
		$date_sales_invoice_to = $sales_invoice_to_date[0];
		$month_sales_invoice_to = $sales_invoice_to_date[1];
		$year_sales_invoice_to = $sales_invoice_to_date[2];
		$sales_invoice_to_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_invoice_to, $date_sales_invoice_to, $year_sales_invoice_to));
		
		$sales_invoice_to_date_indo = tanggal_indo($sales_invoice_to_date);
?>
	<div class="page-fixed-main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="bordered light portlet">
					<div class="portlet-title">
						<div class="caption">
							<span class="caption-subject font-blue sbold uppercase">
								Laporan Penjualan
							</span>
							<span class="caption-helper sbold uppercase">
								Per Salesman Berdasarkan Faktur Penjualan
							</span>
						</div>
					</div>
					<div class="form portlet-body">
						<form action="?alimms=sales-report&tib=form-view-salesman-by-sales-invoice-sales-report-edit" class="horizontal-form" id="form_sample_3" method="post">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_from_date" placeholder="Dari Tanggal" type="text" value="<?php echo $_POST['sales_invoice_from_date'] ?>">
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
											<input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="sales_invoice_to_date" placeholder="Sampai Tanggal" type="text" value="<?php echo $_POST['sales_invoice_to_date'] ?>">
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
								if ($_POST['sales_invoice_from_date'] == $_POST['sales_invoice_to_date'])
								{
							?>
								Tanggal <?php echo $sales_invoice_from_date_indo ?>
							<?php
								}
								else
								{
							?>
								Dari Tanggal <?php echo $sales_invoice_from_date_indo ?> Sampai Tanggal <?php echo $sales_invoice_to_date_indo ?>
							<?php
								}
							?>
							</span>
						</div>
					</div>
					
					<?php
						$tbl_user = mysql_query("SELECT d.user_id, d.user_name FROM sales_invoice a, sales_order b, sales_request c, user d WHERE a.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' AND a.sales_invoice_status = 'Posted' AND d.user_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.salesman_id = d.user_id GROUP BY d.user_id ORDER BY d.user_name");
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
												
											</th>
											<th rowspan="2">
												No
											</th>
											<th rowspan="2">
												Faktur
											</th>
											<th rowspan="2">
												Pelanggan
											</th>
											<th rowspan="2">
												Kecamatan
											</th>
											<?php
												$tbl_product_sell = mysql_query("SELECT product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
												while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
												{
											?>
												<th colspan="4">
													<?php echo $data_tbl_product_sell['product_sell_name'] ?>
												</th>
											<?php
												}
											?>
										</tr>
										<tr>
											<?php
												$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1'");
												while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
												{
											?>
												<th>
													Jumlah
												</th>
												<th>
													Harga Jual
												</th>
												<th>
													Diskon
												</th>
												<th>
													Sub Total
												</th>
											<?php
												}
											?>
										</tr>
									</thead>
									<tbody>
									<?php
										$no = 1;
										$tbl_invoice = mysql_query("SELECT a.sales_invoice_no, a.sales_invoice_id, a.sales_invoice_date, b.sales_order_id, d.customer_code, d.customer_name, e.customer_category_name, f.customer_districts_name FROM sales_invoice a, sales_order b, sales_request c, customer d, customer_category e, customer_districts f WHERE a.sales_invoice_date BETWEEN '".$sales_invoice_from_date."' AND '".$sales_invoice_to_date."' AND a.sales_invoice_status = 'Posted' AND c.salesman_id = '".$data_tbl_user['user_id']."' AND d.customer_active = '1' AND e.customer_category_active = '1' AND f.customer_districts_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.customer_id = d.customer_id AND d.customer_category_id = e.customer_category_id AND d.customer_districts_id = f.customer_districts_id ORDER BY a.sales_invoice_no");
										while($data_tbl_invoice = mysql_fetch_array($tbl_invoice))
										{
											$sales_invoice_date_indo = tanggal_indo($data_tbl_invoice['sales_invoice_date']);
											$s = $data_tbl_invoice['sales_invoice_id'];
									?>
										<form action="?alimms=sales-report&tib=edit-sales-invoice-sales-report" class="horizontal-form" id="form_sample_3" method="post">
											<input type="hidden" name="sales_invoice_id" value="<?php echo $data_tbl_invoice['sales_invoice_id'] ?>" />
										<tr>
											<td>
												<button type="submit" class="btn green-meadow btn-sm"><i class="fa fa-check"></i> Perbarui</button>
											</td>
											<td>
												<?php echo $no ?>
											</td>
											<td>
												<?php echo $data_tbl_invoice['sales_invoice_no'] ?><br />
												<?php echo $sales_invoice_date_indo ?>
											</td>
											<td>
												<?php echo $data_tbl_invoice['customer_category_name'] ?> - <?php echo $data_tbl_invoice['customer_code'] ?> - <?php echo $data_tbl_invoice['customer_name'] ?>
											</td>
											<td>
												<?php echo $data_tbl_invoice['customer_districts_name'] ?>
											</td>
											<?php
												$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1'");
												while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
												{
													$tbl_sales_order_detail = mysql_query("SELECT sales_order_detail_product_sell_quantity, sales_order_detail_program_bonus, (sales_order_detail_product_sell_price - sales_order_detail_piece_discount - sales_order_detail_cash_discount) AS sales_order_detail_product_sell_price, (sales_order_detail_product_sell_quantity * (sales_order_detail_product_sell_price - sales_order_detail_piece_discount - sales_order_detail_cash_discount)) AS sub_total_price_sales_product_sell, sales_order_detail_piece_discount FROM sales_order_detail WHERE sales_order_id = '".$data_tbl_invoice['sales_order_id']."' AND product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
													$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
												
													$sales_order_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity']);
													$sales_order_detail_program_bonus_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_program_bonus']);
													$sales_order_detail_product_sell_price_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_price']);
													$sub_total_price_sales_product_sell_indo = format_angka($data_tbl_sales_order_detail['sub_total_price_sales_product_sell']);
													
													$p = $data_tbl_product_sell['product_sell_id'];
											?>
												<input type="hidden" name="product_sell_id[<?php echo $p; ?>]" value="<?php echo $data_tbl_product_sell['product_sell_id'] ?>" />
												<td>
													<input type="text" class="form form-control" name="sales_order_detail_product_sell_quantity[<?php echo $s; ?>][<?php echo $p; ?>]" value="<?php echo $sales_order_detail_product_sell_quantity_indo ?>" />
													
												</td>
												<td>
													<input type="text" class="form form-control" name="sales_order_detail_product_sell_price[<?php echo $s; ?>][<?php echo $p; ?>]" value="<?php echo $data_tbl_sales_order_detail['sales_order_detail_product_sell_price'] ?>" />
												</td>
												<td>
													<input type="text" class="form form-control" name="sales_order_detail_piece_discount[<?php echo $s; ?>][<?php echo $p; ?>]" value="<?php echo $data_tbl_sales_order_detail['sales_order_detail_piece_discount'] ?>" />
													
												</td>
												<td>
													<?php echo $sub_total_price_sales_product_sell_indo ?>
												</td>
											<?php
												}
											?>
										</tr>
										</form>
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
?>