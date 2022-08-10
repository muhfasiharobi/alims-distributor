<?php
	function form_initial_sales_dashboard()
	{
		$tgl_sekarang = date("Y-m-d");
		$thn_sekarang = date("Y");
		
		$blnthn_sekarang = date("Y-m");
		$blnthn_sebelum = date("Y-m", mktime(0,0,0, date("m") - 1, date("d"), date("Y")));
		
		$bln_sekarang = date("m");
		$bln_sebelum = date("m", mktime(0,0,0, date("m") - 1, date("d"), date("Y")));
		
		$tgl_sekarang_awal = date('Y-m-01', strtotime($tgl_sekarang));
		$tgl_sekarang_akhir = date('Y-m-t', strtotime($tgl_sekarang));
		
		$bln_sekarang_awal = date('Y-01', strtotime($tgl_sekarang));
		$bln_sekarang_akhir = date('Y-m', strtotime($tgl_sekarang));
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-4">
					<div class="bordered dashboard-stat2">
						<?php
							$tbl_sales_target_detail_on_month = mysql_query("SELECT SUM(b.sales_target_detail_product_sell_quantity) AS sales_target_detail_product_sell_quantity FROM sales_target a, sales_target_detail b, product_sell_price c, product_sell_price_detail d WHERE a.sales_target_period = '".$blnthn_sekarang."' AND a.sales_target_active = '1' AND c.product_sell_price_name = 'HJ Retail' AND c.product_sell_price_active = '1' AND a.sales_target_id = b.sales_target_id AND b.product_sell_id = d.product_sell_id AND c.product_sell_price_id = d.product_sell_price_id");
							$data_tbl_sales_target_detail_on_month = mysql_fetch_array($tbl_sales_target_detail_on_month);
		
							$sales_target_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_target_detail_on_month['sales_target_detail_product_sell_quantity']);
							
							$tbl_sales_order_detail_on_month = mysql_query("SELECT SUM(b.sales_order_detail_product_sell_quantity) AS sales_order_detail_product_sell_quantity FROM sales_invoice a, sales_order_detail b WHERE a.sales_invoice_date BETWEEN '".$tgl_sekarang_awal."' AND '".$tgl_sekarang_akhir."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id");
							$data_tbl_sales_order_detail_on_month = mysql_fetch_array($tbl_sales_order_detail_on_month);
							
							$sales_order_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_order_detail_on_month['sales_order_detail_product_sell_quantity']);
							
							$prosentase_product_sell_quantity_on_month = round(($data_tbl_sales_order_detail_on_month['sales_order_detail_product_sell_quantity'] / $data_tbl_sales_target_detail_on_month['sales_target_detail_product_sell_quantity']) * 100, 2);
						?>
						<div class="display">
							<div class="number">
								<small class="font-red">
									TARGET ON MONTH (IN QTY)
								</small>
								<h3 class="font-red">
									<span>
										<?php echo $sales_target_detail_product_sell_quantity_indo ?>
									</span>
								</h3>
							</div>
							<div class="icon">
								<i class="icon-speedometer"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
							<?php
								if ($prosentase_product_sell_quantity_on_month >= 90)
								{
							?>
								<span style="width: <?php echo $prosentase_product_sell_quantity_on_month?>%;" class="blue progress-bar progress-bar-success"></span>
							<?php
								}
								elseif ($prosentase_product_sell_quantity_on_month >= 80 && $prosentase_product_sell_quantity_on_month <= 89)
								{
							?>
								<span style="width: <?php echo $prosentase_product_sell_quantity_on_month?>%;" class="green progress-bar progress-bar-success"></span>
							<?php
								}
								elseif ($prosentase_product_sell_quantity_on_month >= 60 && $prosentase_product_sell_quantity_on_month <= 79)
								{
							?>
								<span style="width: <?php echo $prosentase_product_sell_quantity_on_month?>%;" class="yellow progress-bar progress-bar-success"></span>
							<?php
								}
								else
								{
							?>
								<span style="width: <?php echo $prosentase_product_sell_quantity_on_month?>%;" class="red progress-bar progress-bar-success"></span>
							<?php
								}
							?>
							</div>
							<div class="status">
								<div class="font-blue status-title">
									ACTUAL (IN QTY)
								</div>
								<?php
									if ($prosentase_product_sell_quantity_on_month >= 90)
									{
								?>
									<div class="font-blue status-number">
										<?php echo $prosentase_product_sell_quantity_on_month ?> %
									</div>
								<?php
									}
									elseif ($prosentase_product_sell_quantity_on_month >= 80 && $prosentase_product_sell_quantity_on_month <= 89)
									{
								?>
									<div class="font-green status-number">
										<?php echo $prosentase_product_sell_quantity_on_month ?> %
									</div>
								<?php
									}
									elseif ($prosentase_product_sell_quantity_on_month >= 60 && $prosentase_product_sell_quantity_on_month <= 79)
									{
								?>
									<div class="font-yellow status-number">
										<?php echo $prosentase_product_sell_quantity_on_month ?> %
									</div>
								<?php
									}
									else
									{
								?>
									<div class="font-red status-number">
										<?php echo $prosentase_product_sell_quantity_on_month ?> %
									</div>
								<?php
									}
								?>
							</div>
						</div>
						<br />
						<div class="display">
							<div class="number">
								<h3 class="font-blue">
									<span>
										<?php echo $sales_order_detail_product_sell_quantity_indo ?>
									</span>
								</h3>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="bordered dashboard-stat2">
						<?php
							$tbl_sales_target_detail_cummulative = mysql_query("SELECT SUM(b.sales_target_detail_product_sell_quantity) AS sales_target_detail_product_sell_quantity FROM sales_target a, sales_target_detail b, product_sell_price c, product_sell_price_detail d WHERE a.sales_target_period BETWEEN '".$bln_sekarang_awal."' AND '".$bln_sekarang_akhir."' AND a.sales_target_active = '1' AND c.product_sell_price_name = 'HJ Retail' AND c.product_sell_price_active = '1' AND a.sales_target_id = b.sales_target_id AND b.product_sell_id = d.product_sell_id AND c.product_sell_price_id = d.product_sell_price_id");
							$data_tbl_sales_target_detail_cummulative = mysql_fetch_array($tbl_sales_target_detail_cummulative);

							$sales_target_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_target_detail_cummulative['sales_target_detail_product_sell_quantity']);
							
							$tbl_sales_order_detail_cummulative = mysql_query("SELECT SUM(b.sales_order_detail_product_sell_quantity) AS sales_order_detail_product_sell_quantity FROM sales_invoice a, sales_order_detail b WHERE DATE_FORMAT(a.sales_invoice_date, '%Y-%m') BETWEEN '".$bln_sekarang_awal."' AND '".$bln_sekarang_akhir."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id");
							$data_tbl_sales_order_detail_cummulative = mysql_fetch_array($tbl_sales_order_detail_cummulative);
							
							$sales_order_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_order_detail_cummulative['sales_order_detail_product_sell_quantity']);
							
							$prosentase_product_sell_quantity_cummulative = round(($data_tbl_sales_order_detail_cummulative['sales_order_detail_product_sell_quantity'] / $data_tbl_sales_target_detail_cummulative['sales_target_detail_product_sell_quantity']) * 100, 2);
						?>
						<div class="display">
							<div class="number">
								<small class="font-red">
									TARGET CUMULATIVE (IN QTY)
								</small>
								<h3 class="font-red">
									<span>
										<?php echo $sales_target_detail_product_sell_quantity_indo ?>
									</span>
								</h3>
							</div>
							<div class="icon">
								<i class="icon-badge"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
							<?php
								if ($prosentase_product_sell_quantity_cummulative >= 90)
								{
							?>
								<span style="width: <?php echo $prosentase_product_sell_quantity_cummulative?>%;" class="blue progress-bar progress-bar-success"></span>
							<?php
								}
								elseif ($prosentase_product_sell_quantity_cummulative >= 80 && $prosentase_product_sell_quantity_cummulative <= 89)
								{
							?>
								<span style="width: <?php echo $prosentase_product_sell_quantity_cummulative?>%;" class="green progress-bar progress-bar-success"></span>
							<?php
								}
								elseif ($prosentase_product_sell_quantity_cummulative >= 60 && $prosentase_product_sell_quantity_cummulative <= 79)
								{
							?>
								<span style="width: <?php echo $prosentase_product_sell_quantity_cummulative?>%;" class="yellow progress-bar progress-bar-success"></span>
							<?php
								}
								else
								{
							?>
								<span style="width: <?php echo $prosentase_product_sell_quantity_cummulative?>%;" class="red progress-bar progress-bar-success"></span>
							<?php
								}
							?>
							</div>
							<div class="status">
								<div class="font-blue status-title">
									ACTUAL (IN QTY)
								</div>
								<?php
									if ($prosentase_product_sell_quantity_cummulative >= 90)
									{
								?>
									<div class="font-blue status-number">
										<?php echo $prosentase_product_sell_quantity_cummulative ?> %
									</div>
								<?php
									}
									elseif ($prosentase_product_sell_quantity_cummulative >= 80 && $prosentase_product_sell_quantity_cummulative <= 89)
									{
								?>
									<div class="font-green status-number">
										<?php echo $prosentase_product_sell_quantity_cummulative ?> %
									</div>
								<?php
									}
									elseif ($prosentase_product_sell_quantity_cummulative >= 60 && $prosentase_product_sell_quantity_cummulative <= 79)
									{
								?>
									<div class="font-yellow status-number">
										<?php echo $prosentase_product_sell_quantity_cummulative ?> %
									</div>
								<?php
									}
									else
									{
								?>
									<div class="font-red status-number">
										<?php echo $prosentase_product_sell_quantity_cummulative ?> %
									</div>
								<?php
									}
								?>
							</div>
						</div>
						<br />
						<div class="display">
							<div class="number">
								<h3 class="font-blue">
									<span>
										<?php echo $sales_order_detail_product_sell_quantity_indo ?>
									</span>
								</h3>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="bordered dashboard-stat2">
						<div class="display">
						<?php
							$tbl_sales_target_detail_on_year = mysql_query("SELECT SUM(b.sales_target_detail_product_sell_quantity) AS sales_target_detail_product_sell_quantity FROM sales_target a, sales_target_detail b, product_sell_price c, product_sell_price_detail d WHERE SUBSTRING(a.sales_target_period,1,4) = '".$thn_sekarang."' AND a.sales_target_active = '1' AND c.product_sell_price_name = 'HJ Retail' AND c.product_sell_price_active = '1' AND a.sales_target_id = b.sales_target_id AND b.product_sell_id = d.product_sell_id AND c.product_sell_price_id = d.product_sell_price_id");
							$data_tbl_sales_target_detail_on_year = mysql_fetch_array($tbl_sales_target_detail_on_year);

							$sales_target_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_target_detail_on_year['sales_target_detail_product_sell_quantity']);
							
							$tbl_sales_order_detail_on_year = mysql_query("SELECT SUM(b.sales_order_detail_product_sell_quantity) AS sales_order_detail_product_sell_quantity FROM sales_invoice a, sales_order_detail b WHERE SUBSTRING(a.sales_invoice_date,1,4) = '".$thn_sekarang."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id");
							$data_tbl_sales_order_detail_on_year = mysql_fetch_array($tbl_sales_order_detail_on_year);
							
							$sales_order_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_order_detail_on_year['sales_order_detail_product_sell_quantity']);
							
							$prosentase_product_sell_quantity_on_year = round(($data_tbl_sales_order_detail_on_year['sales_order_detail_product_sell_quantity'] / $data_tbl_sales_target_detail_on_year['sales_target_detail_product_sell_quantity']) * 100, 2);
						?>
							<div class="number">
								<small class="font-red">
									TARGET ON YEAR <?php echo $data_tbl_sales_target_on_year['tahun'] ?> (IN QTY)
								</small>
								<h3 class="font-red">
									<span>
										<?php echo $sales_target_detail_product_sell_quantity_indo ?>
									</span>
								</h3>
							</div>
							<div class="icon">
								<i class="icon-trophy"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
							<?php
								if ($prosentase_product_sell_quantity_on_year >= 90)
								{
							?>
								<span style="width: <?php echo $prosentase_product_sell_quantity_on_year?>%;" class="blue progress-bar progress-bar-success"></span>
							<?php
								}
								elseif ($prosentase_product_sell_quantity_on_year >= 80 && $prosentase_product_sell_quantity_on_year <= 89)
								{
							?>
								<span style="width: <?php echo $prosentase_product_sell_quantity_on_year?>%;" class="green progress-bar progress-bar-success"></span>
							<?php
								}
								elseif ($prosentase_product_sell_quantity_on_year >= 60 && $prosentase_product_sell_quantity_on_year <= 79)
								{
							?>
								<span style="width: <?php echo $prosentase_product_sell_quantity_on_year?>%;" class="yellow progress-bar progress-bar-success"></span>
							<?php
								}
								else
								{
							?>
								<span style="width: <?php echo $prosentase_product_sell_quantity_on_year?>%;" class="red progress-bar progress-bar-success"></span>
							<?php
								}
							?>
							</div>
							<div class="status">
								<div class="font-blue status-title">
									ACTUAL (IN QTY)
								</div>
								<?php
									if ($prosentase_product_sell_quantity_on_year >= 90)
									{
								?>
									<div class="font-blue status-number">
										<?php echo $prosentase_product_sell_quantity_on_year ?> %
									</div>
								<?php
									}
									elseif ($prosentase_product_sell_quantity_on_year >= 80 && $prosentase_product_sell_quantity_on_year <= 89)
									{
								?>
									<div class="font-green status-number">
										<?php echo $prosentase_product_sell_quantity_on_year ?> %
									</div>
								<?php
									}
									elseif ($prosentase_product_sell_quantity_on_year >= 60 && $prosentase_product_sell_quantity_on_year <= 79)
									{
								?>
									<div class="font-yellow status-number">
										<?php echo $prosentase_product_sell_quantity_on_year ?> %
									</div>
								<?php
									}
									else
									{
								?>
									<div class="font-red status-number">
										<?php echo $prosentase_product_sell_quantity_on_year ?> %
									</div>
								<?php
									}
								?>
							</div>
						</div>
						<br />
						<div class="display">
							<div class="number">
								<h3 class="font-blue">
									<span>
										<?php echo $sales_order_detail_product_sell_quantity_indo ?>
									</span>
								</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="bordered dashboard-stat2">
						<?php
							$tbl_sales_target_value_on_month = mysql_query("SELECT SUM(sales_target_value) AS sales_target_value FROM sales_target WHERE sales_target_period = '".$blnthn_sekarang."' AND sales_target_active = '1'");
							$data_tbl_sales_target_value_on_month = mysql_fetch_array($tbl_sales_target_value_on_month);
		
							$sales_target_value_indo = format_angka($data_tbl_sales_target_value_on_month['sales_target_value']);
							
							$tbl_sales_invoice_on_month = mysql_query("SELECT SUM((sales_order_detail_product_sell_price - sales_order_detail_piece_discount) * sales_order_detail_product_sell_quantity) AS sales_order_detail_sum_value FROM sales_invoice a, sales_order_detail b WHERE a.sales_invoice_date BETWEEN '".$tgl_sekarang_awal."' AND '".$tgl_sekarang_akhir."' AND a.sales_invoice_status = 'Posted' AND a.sales_order_id = b.sales_order_id");
							$data_tbl_sales_invoice_on_month = mysql_fetch_array($tbl_sales_invoice_on_month);
							
							$data_tbl_sales_invoice_on_month_indo = format_angka($data_tbl_sales_invoice_on_month['sales_order_detail_sum_value']);
							
							$prosentase_product_sell_value_on_month = round(($data_tbl_sales_invoice_on_month['sales_order_detail_sum_value'] / $data_tbl_sales_target_value_on_month['sales_target_value']) * 100, 2);
						?>
						<div class="display">
							<div class="number">
								<small class="font-red">
									TARGET ON MONTH (IN VALUE)
								</small>
								<h3 class="font-red">
									<span>
										<?php echo $sales_target_value_indo ?>
									</span>
								</h3>
							</div>
							<div class="icon">
								<i class="icon-credit-card"></i>
							</div>
						</div>
						<div class="progress-info">
							<div class="progress">
							<?php
								if ($prosentase_product_sell_value_on_month >= 90)
								{
							?>
								<span style="width: <?php echo $prosentase_product_sell_value_on_month?>%;" class="blue progress-bar progress-bar-success"></span>
							<?php
								}
								elseif ($prosentase_product_sell_value_on_month >= 80 && $prosentase_product_sell_value_on_month <= 89)
								{
							?>
								<span style="width: <?php echo $prosentase_product_sell_value_on_month?>%;" class="green progress-bar progress-bar-success"></span>
							<?php
								}
								elseif ($prosentase_product_sell_value_on_month >= 60 && $prosentase_product_sell_value_on_month <= 79)
								{
							?>
								<span style="width: <?php echo $prosentase_product_sell_value_on_month?>%;" class="yellow progress-bar progress-bar-success"></span>
							<?php
								}
								else
								{
							?>
								<span style="width: <?php echo $prosentase_product_sell_value_on_month?>%;" class="red progress-bar progress-bar-success"></span>
							<?php
								}
							?>
							</div>
							<div class="status">
								<div class="font-blue status-title">
									ACTUAL (IN VALUE)
								</div>
								<?php
									if ($prosentase_product_sell_value_on_month >= 90)
									{
								?>
									<div class="font-blue status-number">
										<?php echo $prosentase_product_sell_value_on_month ?> %
									</div>
								<?php
									}
									elseif ($prosentase_product_sell_value_on_month >= 80 && $prosentase_product_sell_value_on_month <= 89)
									{
								?>
									<div class="font-green status-number">
										<?php echo $prosentase_product_sell_value_on_month ?> %
									</div>
								<?php
									}
									elseif ($prosentase_product_sell_value_on_month >= 60 && $prosentase_product_sell_value_on_month <= 79)
									{
								?>
									<div class="font-yellow status-number">
										<?php echo $prosentase_product_sell_value_on_month ?> %
									</div>
								<?php
									}
									else
									{
								?>
									<div class="font-red status-number">
										<?php echo $prosentase_product_sell_value_on_month ?> %
									</div>
								<?php
									}
								?>
							</div>
						</div>
						<br />
						<div class="display">
							<div class="number">
								<h3 class="font-blue">
									<span>
										<?php echo $data_tbl_sales_invoice_on_month_indo ?>
									</span>
								</h3>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Salesman Performance
								</span>
								<span class="caption-helper sbold uppercase">
									<?php echo bulan_tahunsekarangindo() ?>
								</span>
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-scrollable table-scrollable-borderless">
								<table class="table table-hover table-light">
									<thead>
										<tr class="center uppercase">
											<th colspan="2" rowspan="2">
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
										<tr class="uppercase">
											<?php
												$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1'");
												while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
												{
											?>
												<th>
													Target
												</th>
												<th>
													Actual
												</th>
												<th>
													Prosentase
												</th>
												<th>
													Status
												</th>
											<?php
												}
											?>
										</tr>
									</thead>
									<?php
										$tbl_user = mysql_query("SELECT b.user_id, b.user_name FROM sales_target a, user b WHERE a.sales_target_active = '1' AND b.user_active = '1' AND a.sales_target_period = '".$blnthn_sekarang."' AND a.salesman_id = b.user_id ORDER BY b.user_name");
										while($data_tbl_user = mysql_fetch_array($tbl_user))
										{
									?>
										<tr>
											<td class="fit">
												<img class="user-pic" src="../assets/pages/media/users/avatar4.jpg">
											</td>
											<td>
												<a href="javascript:;" class="primary-link"><?php echo $data_tbl_user['user_name'] ?></a>
											</td>
											<?php
												$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
												while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
												{
													$tbl_sales_target_detail = mysql_query("SELECT SUM(b.sales_target_detail_product_sell_quantity) AS sales_target_detail_product_sell_quantity FROM sales_target a, sales_target_detail b, product_sell_price c, product_sell_price_detail d WHERE a.salesman_id = '".$data_tbl_user['user_id']."' AND a.sales_target_period = '".$blnthn_sekarang."' AND a.sales_target_active = '1' AND b.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND c.product_sell_price_name = 'HJ Retail' AND c.product_sell_price_active = '1' AND a.sales_target_id = b.sales_target_id AND b.product_sell_id = d.product_sell_id AND c.product_sell_price_id = d.product_sell_price_id");
													$data_tbl_sales_target_detail = mysql_fetch_array($tbl_sales_target_detail);
													
													$sales_target_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_target_detail['sales_target_detail_product_sell_quantity']);
													
													$tbl_sales_order_detail = mysql_query("SELECT SUM(c.sales_order_detail_product_sell_quantity) AS sales_order_detail_product_sell_quantity FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d WHERE a.sales_invoice_date BETWEEN '".$tgl_sekarang_awal."' AND '".$tgl_sekarang_akhir."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND d.salesman_id = '".$data_tbl_user['user_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id");
													$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
											
													$sales_order_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity']);
											
													$prosentase_product_sell_quantity = round(($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity'] / $data_tbl_sales_target_detail['sales_target_detail_product_sell_quantity']) * 100, 2);
											?>
												<td>
													<?php echo $sales_target_detail_product_sell_quantity_indo ?>
												</td>
												<td>
													<?php echo $sales_order_detail_product_sell_quantity_indo ?>
												</td>
												<td>
												<?php
													if ($prosentase_product_sell_quantity >= 90)
													{
												?>
													<span class="sbold font-blue">
														<?php echo $prosentase_product_sell_quantity ?> %
													</span>
												<?php
													}
													elseif ($prosentase_product_sell_quantity >= 80 && $prosentase_product_sell_quantity <= 89)
													{
												?>
													<span class="sbold font-green">
														<?php echo $prosentase_product_sell_quantity ?> %
													</span>
												<?php
													}
													elseif ($prosentase_product_sell_quantity >= 60 && $prosentase_product_sell_quantity <= 79)
													{
												?>
													<span class="sbold font-yellow">
														<?php echo $prosentase_product_sell_quantity ?> %
													</span>
												<?php
													}
													else
													{
												?>
													<span class="bold font-red">
														<?php echo $prosentase_product_sell_quantity ?> %
													</span>
												<?php
													}
												?>
												</td>
												<td>
												<?php
													if ($prosentase_product_sell_quantity >= 90)
													{
												?>
													<span class="label label-info label-sm">
														Excellent
													</span>
												<?php
													}
													elseif ($prosentase_product_sell_quantity >= 80 && $prosentase_product_sell_quantity <= 89)
													{
												?>
													<span class="label label-sm label-success">
														On Track
													</span>
												<?php
													}
													elseif ($prosentase_product_sell_quantity >= 60 && $prosentase_product_sell_quantity <= 79)
													{
												?>
													<span class="label label-sm label-warning">
														Warning
													</span>
												<?php
													}
													else
													{
												?>
													<span class="label label-danger label-sm">
														Alert
													</span>
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
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Distribution Performance
								</span>
								<span class="caption-helper sbold uppercase">
									<?php echo $thn_sekarang ?>
								</span>
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-scrollable table-scrollable-borderless" style="height: 560px; overflow: auto;">
								<table class="table table-hover table-light">
									<thead>
										<tr class="uppercase">
											<th rowspan="2">
											</th>
											<?php
												$tbl_product_sell = mysql_query("SELECT product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
												while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
												{
											?>
												<th colspan="2">
													<?php echo $data_tbl_product_sell['product_sell_name'] ?>
												</th>
											<?php
												}
											?>
										</tr>
										<tr class="uppercase">
										<?php
											$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
											while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
											{
												$bln_sebelum_indo = singkatan_bulan($bln_sebelum);
												$bln_sekarang_indo = singkatan_bulan($bln_sekarang);
										?>
											<th>
												<?php echo $bln_sebelum_indo ?>
											</th>
											<th>
												<?php echo $bln_sekarang_indo ?>
											</th>
										<?php
											}
										?>
										</tr>
									</thead>
									<?php
										$tbl_districts = mysql_query("SELECT e.customer_districts_id, e.customer_districts_name FROM sales_invoice a, sales_order b, sales_request c, customer d, customer_districts e WHERE DATE_FORMAT(a.sales_invoice_date, '%Y-%m') BETWEEN '".$bln_sekarang_awal."' AND '".$bln_sekarang_akhir."' AND a.sales_invoice_status = 'Posted' AND d.customer_active = '1' AND e.customer_districts_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id AND c.customer_id = d.customer_id AND d.customer_districts_id = e.customer_districts_id GROUP BY e.customer_districts_id ORDER BY e.customer_districts_name");
										while($data_tbl_districts = mysql_fetch_array($tbl_districts))
										{
									?>
										<tr>
											<td>
												<?php echo $data_tbl_districts['customer_districts_name'] ?>
											</td>
											<?php
												$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
												while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
												{
													$tbl_sales_order_detail_last_month = mysql_query("SELECT SUM(c.sales_order_detail_product_sell_quantity) AS sales_order_detail_product_sell_quantity_last_month FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, customer e WHERE DATE_FORMAT(a.sales_invoice_date, '%Y-%m') = '".$blnthn_sebelum."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND e.customer_districts_id = '".$data_tbl_districts['customer_districts_id']."' AND e.customer_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.customer_id = e.customer_id");
													$data_tbl_sales_order_detail_last_month = mysql_fetch_array($tbl_sales_order_detail_last_month);
													
													$sales_order_detail_product_sell_quantity_last_month_indo = format_angka($data_tbl_sales_order_detail_last_month['sales_order_detail_product_sell_quantity_last_month']);
													
													$tbl_sales_order_detail_this_month = mysql_query("SELECT SUM(c.sales_order_detail_product_sell_quantity) AS sales_order_detail_product_sell_quantity_this_month FROM sales_invoice a, sales_order b, sales_order_detail c, sales_request d, customer e WHERE DATE_FORMAT(a.sales_invoice_date, '%Y-%m') = '".$blnthn_sekarang."' AND a.sales_invoice_status = 'Posted' AND c.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND e.customer_districts_id = '".$data_tbl_districts['customer_districts_id']."' AND e.customer_active = '1' AND a.sales_order_id = b.sales_order_id AND b.sales_order_id = c.sales_order_id AND b.sales_request_id = d.sales_request_id AND d.customer_id = e.customer_id");
													$data_tbl_sales_order_detail_this_month = mysql_fetch_array($tbl_sales_order_detail_this_month);
													
													$sales_order_detail_product_sell_quantity_this_month_indo = format_angka($data_tbl_sales_order_detail_this_month['sales_order_detail_product_sell_quantity_this_month']);
											?>
												<td>
													<?php echo $sales_order_detail_product_sell_quantity_last_month_indo ?>
												</td>
												<td>
													<?php echo $sales_order_detail_product_sell_quantity_this_month_indo ?>
												</td>
											<?php
												}
											?>
										</tr>
									<?php
										}
									?>
								</table>
							</div>
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
									Product Performance
								</span>
								<span class="caption-helper sbold uppercase">
									<?php echo $thn_sekarang ?>
								</span>
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-scrollable table-scrollable-borderless">
								<table class="table table-hover table-light">
									<thead>
										<tr class="uppercase">
											<th rowspan="2">
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
										<tr class="uppercase">
											<?php
												$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1'");
												while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
												{
											?>
												<th>
													Target
												</th>
												<th>
													Actual
												</th>
												<th>
													Prosentase
												</th>
												<th>
													Status
												</th>
											<?php
												}
											?>
										</tr>
									</thead>
									<?php
										$tbl_sales_invoice_on_month = mysql_query("SELECT DATE_FORMAT(sales_invoice_date, '%m') AS sales_invoice_date_on_month FROM sales_invoice WHERE DATE_FORMAT(sales_invoice_date, '%Y-%m') BETWEEN '".$bln_sekarang_awal."' AND '".$bln_sekarang_akhir."' AND sales_invoice_status = 'Posted' GROUP BY sales_invoice_date_on_month");
										while($data_tbl_sales_invoice_on_month = mysql_fetch_array($tbl_sales_invoice_on_month))
										{
											$sales_invoice_date_on_month_indo = bulan($data_tbl_sales_invoice_on_month['sales_invoice_date_on_month']);

$blnthn_sekarang = $thn_sekarang.'-'.$data_tbl_sales_invoice_on_month['sales_invoice_date_on_month'];
									?>
										<tr>
											<td>
												<?php echo $sales_invoice_date_on_month_indo ?>
											</td>
											<?php
												$tbl_product_sell = mysql_query("SELECT product_sell_id FROM product_sell WHERE product_sell_active = '1'");
												while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
												{
													$tbl_sales_target_detail = mysql_query("SELECT SUM(b.sales_target_detail_product_sell_quantity) AS sales_target_detail_product_sell_quantity FROM sales_target a, sales_target_detail b WHERE a.sales_target_period = '".$blnthn_sekarang."' AND a.sales_target_active = '1' AND b.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.sales_target_id = b.sales_target_id");
													$data_tbl_sales_target_detail = mysql_fetch_array($tbl_sales_target_detail);
													
													$sales_target_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_target_detail['sales_target_detail_product_sell_quantity']);
													
													$tbl_sales_order_detail = mysql_query("SELECT SUM(b.sales_order_detail_product_sell_quantity) AS sales_order_detail_product_sell_quantity FROM sales_invoice a, sales_order_detail b WHERE DATE_FORMAT(a.sales_invoice_date, '%m') = '".$data_tbl_sales_invoice_on_month['sales_invoice_date_on_month']."' AND a.sales_invoice_status = 'Posted' AND b.product_sell_id = '".$data_tbl_product_sell['product_sell_id']."' AND a.sales_order_id = b.sales_order_id");
													$data_tbl_sales_order_detail = mysql_fetch_array($tbl_sales_order_detail);
											
													$sales_order_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity']);
											
													$prosentase_product_sell_quantity = round(($data_tbl_sales_order_detail['sales_order_detail_product_sell_quantity'] / $data_tbl_sales_target_detail['sales_target_detail_product_sell_quantity']) * 100, 2);
											?>
												<td>
													<?php echo $sales_target_detail_product_sell_quantity_indo ?>
												</td>
												<td>
													<?php echo $sales_order_detail_product_sell_quantity_indo ?>
												</td>
												<td>
												<?php
													if ($prosentase_product_sell_quantity >= 90)
													{
												?>
													<span class="sbold font-blue">
														<?php echo $prosentase_product_sell_quantity ?> %
													</span>
												<?php
													}
													elseif ($prosentase_product_sell_quantity >= 80 && $prosentase_product_sell_quantity <= 89)
													{
												?>
													<span class="sbold font-green">
														<?php echo $prosentase_product_sell_quantity ?> %
													</span>
												<?php
													}
													elseif ($prosentase_product_sell_quantity >= 60 && $prosentase_product_sell_quantity <= 79)
													{
												?>
													<span class="sbold font-yellow">
														<?php echo $prosentase_product_sell_quantity ?> %
													</span>
												<?php
													}
													else
													{
												?>
													<span class="bold font-red">
														<?php echo $prosentase_product_sell_quantity ?> %
													</span>
												<?php
													}
												?>
												</td>
												<td>
												<?php
													if ($prosentase_product_sell_quantity >= 90)
													{
												?>
													<span class="label label-info label-sm">
														Excellent
													</span>
												<?php
													}
													elseif ($prosentase_product_sell_quantity >= 80 && $prosentase_product_sell_quantity <= 89)
													{
												?>
													<span class="label label-sm label-success">
														On Track
													</span>
												<?php
													}
													elseif ($prosentase_product_sell_quantity >= 60 && $prosentase_product_sell_quantity <= 79)
													{
												?>
													<span class="label label-sm label-warning">
														Warning
													</span>
												<?php
													}
													else
													{
												?>
													<span class="label label-danger label-sm">
														Alert
													</span>
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
								</table>
							</div>
						</div>
					</div>
<div class="form-actions right">
						<a class="btn btn-sm btn-outline purple sbold" data-original-title="Cetak" data-toggle="modal" href="#export_sales_report">
							<i class="fa fa-print"></i>
								Export
						</a>
					</div>
					<div aria-hidden="true" class="modal fade" id="export_sales_report" role="basic" tabindex="-1">
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
									<a class="btn btn-outline btn-sm green sbold" href="export_report.php?tib=export-by-target-on-month">
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
<?php
	}
?>