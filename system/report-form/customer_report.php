<?php
	function form_search_customer_city_by_customer_quantity_customer_report()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Laporan Pelanggan
								</span>
								<span class="caption-helper sbold uppercase">
									Per Kota/ Kabupaten Berdasarkan Jumlah Pelanggan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=customer-report&tib=form-view-customer-city-by-customer-quantity-customer-report" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>
													Kota/ Kabupaten
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#customer_city_id" data-placeholder="Kota/ Kabupaten" name="customer_city_id">
													<option value=""></option>
													<option value="0">Semua Kota/ Kabupaten</option>
													<?php
														$tbl_customer_city = mysql_query("SELECT customer_city_id, customer_city_name FROM customer_city WHERE customer_city_active = '1' ORDER BY customer_city_name");
														while($data_tbl_customer_city = mysql_fetch_array($tbl_customer_city))
														{
													?>
														<option value="<?php echo $data_tbl_customer_city['customer_city_id'] ?>"><?php echo $data_tbl_customer_city['customer_city_name'] ?></option>
													<?php	
														}
													?>
												</select>
												<div id="customer_city_id"></div>
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
	function form_view_customer_city_by_customer_quantity_customer_report()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Laporan Pelanggan
								</span>
								<span class="caption-helper sbold uppercase">
									Per Kota/ Kabupaten Berdasarkan Jumlah Pelanggan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=customer-report&tib=form-view-customer-city-by-customer-quantity-customer-report" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>
													Kota/ Kabupaten
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#customer_city_id" data-placeholder="Kota/ Kabupaten" name="customer_city_id">
													<option value=""></option>
													<?php
														if ($_POST['customer_city_id'] == "0")
														{
													?>
														<option selected="selected" value="0">Semua Kota/ Kabupaten</option>
													<?php
														}
														else
														{
													?>
														<option value="0">Semua Kota/ Kabupaten</option>
													<?php
														}
													?>
													<?php
														$tbl_customer_city = mysql_query("SELECT customer_city_id, customer_city_name FROM customer_city WHERE customer_city_active = '1' ORDER BY customer_city_name");
														while($data_tbl_customer_city = mysql_fetch_array($tbl_customer_city))
														{
															if ($data_tbl_customer_city['customer_city_id'] == $_POST['customer_city_id'])
															{
													?>
															<option selected="selected" value="<?php echo $data_tbl_customer_city['customer_city_id'] ?>"><?php echo $data_tbl_customer_city['customer_city_name'] ?></option>
													<?php
															} 
															else
															{
													?>
															<option value="<?php echo $data_tbl_customer_city['customer_city_id'] ?>"><?php echo $data_tbl_customer_city['customer_city_name'] ?></option>
													<?php
															}
														}
													?>
												</select>
												<div id="customer_city_id"></div>
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
			<?php
				if ($_POST['customer_city_id'] == "0")
				{
					$tbl_customer_city = mysql_query("SELECT customer_city_id, customer_city_name FROM customer_city WHERE customer_city_active = '1' ORDER BY customer_city_name");
					while($data_tbl_customer_city = mysql_fetch_array($tbl_customer_city))
					{
			?>
					<div class="row">
						<div class="col-md-12">
							<div class="bordered light portlet">
								<div class="portlet-title">
									<div class="caption">
										<span class="caption-subject font-red sbold uppercase">
											<?php echo $data_tbl_customer_city['customer_city_name'] ?>
										</span>
										<span class="caption-helper sbold uppercase">
										<?php
											$tbl_customer_category = mysql_query("SELECT customer_category_id, customer_category_name FROM customer_category WHERE customer_category_active = '1' ORDER BY customer_category_name");
											while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
											{
												$tbl_customer_quantity_customer_category = mysql_query("SELECT COUNT(a.customer_id) AS customer_quantity_customer_category FROM customer a, customer_districts b WHERE a.customer_category_id = '".$data_tbl_customer_category['customer_category_id']."' AND b.customer_city_id = '".$data_tbl_customer_city['customer_city_id']."' AND b.customer_districts_active = '1' AND a.customer_districts_id = b.customer_districts_id");
												$data_tbl_customer_quantity_customer_category = mysql_fetch_array($tbl_customer_quantity_customer_category);
												
												$customer_quantity_customer_category_indo = format_angka($data_tbl_customer_quantity_customer_category['customer_quantity_customer_category']);
										?>
											<?php echo $data_tbl_customer_category['customer_category_name'] ?> : <?php echo $customer_quantity_customer_category_indo ?>
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
														Kategori
													</th>
													<th>
														Kelas
													</th>
													<th>
														Kode
													</th>
													<th>
														Pelanggan
													</th>
													<th>
														Alamat
													</th>
													<th>
														Kecamatan
													</th>
													<th>
														Kontak
													</th>
													<th>
														No. Telepon
													</th>
													<th>
														Harga Jual Produk
													</th>
													<th>
														Program Promo Produk
													</th>
													<th>
														Status
													</th>
												</tr>
											</thead>
											<tbody>
											<?php
												$no = 1;
												$tbl_customer = mysql_query("SELECT a.customer_code, a.customer_name, a.customer_address, a.customer_contact, a.customer_phone, a.customer_product_sell_program_promo, a.customer_active, b.customer_category_name, c.customer_class_name, d.customer_districts_name, e.product_sell_price_name FROM customer a, customer_category b, customer_class c, customer_districts d, product_sell_price e WHERE b.customer_category_active = '1' AND c.customer_class_active = '1' AND d.customer_city_id = '".$data_tbl_customer_city['customer_city_id']."' AND d.customer_districts_active = '1' AND e.product_sell_price_active = '1' AND a.customer_category_id = b.customer_category_id AND a.customer_class_id = c.customer_class_id AND a.customer_districts_id = d.customer_districts_id AND a.product_sell_price_id = e.product_sell_price_id ORDER BY a.customer_code");
												while ($data_tbl_customer = mysql_fetch_array($tbl_customer))
												{
											?>
												<tr>
													<td>
														<?php echo $no ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_category_name'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_class_name'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_code'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_name'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_address'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_districts_name'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_contact'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_phone'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['product_sell_price_name'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_product_sell_program_promo'] ?>
													</td>
													<td>
													<?php
														if ($data_tbl_customer['customer_active'] == "1")
														{
													?>
														<span class="label label-info label-sm">Active</span>
													<?php
														}
														else
														{
													?>
														<span class="label label-danger label-sm">Non Active</span>
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
			<?php
					}
				}
				else
				{
				$tbl_customer_city = mysql_query("SELECT customer_city_id, customer_city_name FROM customer_city WHERE customer_city_id = '".$_POST['customer_city_id']."' AND customer_city_active = '1' ORDER BY customer_city_name");
				$data_tbl_customer_city = mysql_fetch_array($tbl_customer_city);
			?>
				<div class="row">
					<div class="col-md-12">
						<div class="bordered light portlet">
							<div class="portlet-title">
								<div class="caption">
									<span class="caption-subject font-red sbold uppercase">
										<?php echo $data_tbl_customer_city['customer_city_name'] ?>
									</span>
									<span class="caption-helper sbold uppercase">
									<?php
										$tbl_customer_category = mysql_query("SELECT customer_category_id, customer_category_name FROM customer_category WHERE customer_category_active = '1' ORDER BY customer_category_name");
										while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
										{
											$tbl_customer_quantity_customer_category = mysql_query("SELECT COUNT(a.customer_id) AS customer_quantity_customer_category FROM customer a, customer_districts b WHERE a.customer_category_id = '".$data_tbl_customer_category['customer_category_id']."' AND b.customer_city_id = '".$data_tbl_customer_city['customer_city_id']."' AND b.customer_districts_active = '1' AND a.customer_districts_id = b.customer_districts_id");
											$data_tbl_customer_quantity_customer_category = mysql_fetch_array($tbl_customer_quantity_customer_category);
											
											$customer_quantity_customer_category_indo = format_angka($data_tbl_customer_quantity_customer_category['customer_quantity_customer_category']);
									?>
										<?php echo $data_tbl_customer_category['customer_category_name'] ?> : <?php echo $customer_quantity_customer_category_indo ?>
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
													Kategori
												</th>
												<th>
													Kelas
												</th>
												<th>
													Kode
												</th>
												<th>
													Pelanggan
												</th>
												<th>
													Alamat
												</th>
												<th>
													Kecamatan
												</th>
												<th>
													Kontak
												</th>
												<th>
													No. Telepon
												</th>
												<th>
													Harga Jual Produk
												</th>
												<th>
													Program Promo Produk
												</th>
												<th>
													Status
												</th>
											</tr>
										</thead>
										<tbody>
										<?php
											$no = 1;
											$tbl_customer = mysql_query("SELECT a.customer_code, a.customer_name, a.customer_address, a.customer_contact, a.customer_phone, a.customer_product_sell_program_promo, a.customer_active, b.customer_category_name, c.customer_class_name, d.customer_districts_name, e.product_sell_price_name FROM customer a, customer_category b, customer_class c, customer_districts d, product_sell_price e WHERE b.customer_category_active = '1' AND c.customer_class_active = '1' AND d.customer_city_id = '".$data_tbl_customer_city['customer_city_id']."' AND d.customer_districts_active = '1' AND e.product_sell_price_active = '1' AND a.customer_category_id = b.customer_category_id AND a.customer_class_id = c.customer_class_id AND a.customer_districts_id = d.customer_districts_id AND a.product_sell_price_id = e.product_sell_price_id ORDER BY a.customer_code");
											while ($data_tbl_customer = mysql_fetch_array($tbl_customer))
											{
										?>
											<tr>
												<td>
													<?php echo $no ?>
												</td>
												<td>
													<?php echo $data_tbl_customer['customer_category_name'] ?>
												</td>
												<td>
													<?php echo $data_tbl_customer['customer_class_name'] ?>
												</td>
												<td>
													<?php echo $data_tbl_customer['customer_code'] ?>
												</td>
												<td>
													<?php echo $data_tbl_customer['customer_name'] ?>
												</td>
												<td>
													<?php echo $data_tbl_customer['customer_address'] ?>
												</td>
												<td>
													<?php echo $data_tbl_customer['customer_districts_name'] ?>
												</td>
												<td>
													<?php echo $data_tbl_customer['customer_contact'] ?>
												</td>
												<td>
													<?php echo $data_tbl_customer['customer_phone'] ?>
												</td>
												<td>
													<?php echo $data_tbl_customer['product_sell_price_name'] ?>
												</td>
												<td>
													<?php echo $data_tbl_customer['customer_product_sell_program_promo'] ?>
												</td>
												<td>
												<?php
													if ($data_tbl_customer['customer_active'] == "1")
													{
												?>
													<span class="label label-info label-sm">Active</span>
												<?php
													}
													else
													{
												?>
													<span class="label label-danger label-sm">Non Active</span>
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
			<?php
				}
			?>
		</div>
<?php
	}
	function form_search_customer_districts_by_customer_quantity_customer_report()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Laporan Pelanggan
								</span>
								<span class="caption-helper sbold uppercase">
									Per Kecamatan Berdasarkan Jumlah Pelanggan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=customer-report&tib=form-view-customer-districts-by-customer-quantity-customer-report" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>
													Kecamatan
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#customer_districts_id" data-placeholder="Kecamatan" name="customer_districts_id">
													<option value=""></option>
													<option value="0">Semua Kecamatan</option>
													<?php
														$tbl_customer_districts = mysql_query("SELECT customer_districts_id, customer_districts_name FROM customer_districts WHERE customer_districts_active = '1' ORDER BY customer_districts_name");
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
	function form_view_customer_districts_by_customer_quantity_customer_report()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Laporan Pelanggan
								</span>
								<span class="caption-helper sbold uppercase">
									Per Kecamatan Berdasarkan Jumlah Pelanggan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=customer-report&tib=form-view-customer-districts-by-customer-quantity-customer-report" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>
													Kecamatan
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#customer_districts_id" data-placeholder="Kecamatan" name="customer_districts_id">
													<option value=""></option>
													<?php
														if ($_POST['customer_districts_id'] == "0")
														{
													?>
														<option selected="selected" value="0">Semua Kecamatan</option>
													<?php
														}
														else
														{
													?>
														<option value="0">Semua Kecamatan</option>
													<?php
														}
													?>
													<?php
														$tbl_customer_districts = mysql_query("SELECT customer_districts_id, customer_districts_name FROM customer_districts WHERE customer_districts_active = '1' ORDER BY customer_districts_name");
														while($data_tbl_customer_districts = mysql_fetch_array($tbl_customer_districts))
														{
															if ($data_tbl_customer_districts['customer_districts_id'] == $_POST['customer_districts_id'])
															{
													?>
															<option selected="selected" value="<?php echo $data_tbl_customer_districts['customer_districts_id'] ?>"><?php echo $data_tbl_customer_districts['customer_districts_name'] ?></option>
													<?php
															} 
															else
															{
													?>
															<option value="<?php echo $data_tbl_customer_districts['customer_districts_id'] ?>"><?php echo $data_tbl_customer_districts['customer_districts_name'] ?></option>
													<?php
															}
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
			<?php
				if ($_POST['customer_districts_id'] == "0")
				{
					$tbl_customer_districts = mysql_query("SELECT a.customer_districts_id, a.customer_districts_name, b.customer_city_name FROM customer_districts a, customer_city b WHERE a.customer_districts_active = '1' AND b.customer_city_active = '1' AND a.customer_city_id = b.customer_city_id ORDER BY a.customer_districts_name");
					while($data_tbl_customer_districts = mysql_fetch_array($tbl_customer_districts))
					{
			?>
					<div class="row">
						<div class="col-md-12">
							<div class="bordered light portlet">
								<div class="portlet-title">
									<div class="caption">
										<span class="caption-subject font-red sbold uppercase">
											<?php echo $data_tbl_customer_districts['customer_districts_name'] ?> - <?php echo $data_tbl_customer_districts['customer_city_name'] ?>
										</span>
										<span class="caption-helper sbold uppercase">
										<?php
											$tbl_customer_category = mysql_query("SELECT customer_category_id, customer_category_name FROM customer_category WHERE customer_category_active = '1' ORDER BY customer_category_name");
											while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
											{
												$tbl_customer_quantity_customer_category = mysql_query("SELECT COUNT(customer_id) AS customer_quantity_customer_category FROM customer WHERE customer_category_id = '".$data_tbl_customer_category['customer_category_id']."' AND customer_districts_id = '".$data_tbl_customer_districts['customer_districts_id']."'");
												$data_tbl_customer_quantity_customer_category = mysql_fetch_array($tbl_customer_quantity_customer_category);
										?>
											<?php echo $data_tbl_customer_category['customer_category_name'] ?> : <?php echo $data_tbl_customer_quantity_customer_category['customer_quantity_customer_category'] ?>
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
														Kategori
													</th>
													<th>
														Kelas
													</th>
													<th>
														Kode
													</th>
													<th>
														Pelanggan
													</th>
													<th>
														Alamat
													</th>
													<th>
														Kontak
													</th>
													<th>
														No. Telepon
													</th>
													<th>
														Harga Jual Produk
													</th>
													<th>
														Program Promo Produk
													</th>
													<th>
														Status
													</th>
												</tr>
											</thead>
											<tbody>
											<?php
												$no = 1;
												$tbl_customer = mysql_query("SELECT a.customer_code, a.customer_name, a.customer_address, a.customer_contact, a.customer_phone, a.customer_product_sell_program_promo, a.customer_active, b.customer_category_name, c.customer_class_name, d.product_sell_price_name FROM customer a, customer_category b, customer_class c, product_sell_price d WHERE a.customer_districts_id = '".$data_tbl_customer_districts['customer_districts_id']."' AND b.customer_category_active = '1' AND c.customer_class_active = '1' AND d.product_sell_price_active = '1' AND a.customer_category_id = b.customer_category_id AND a.customer_class_id = c.customer_class_id AND a.product_sell_price_id = d.product_sell_price_id ORDER BY a.customer_code");
												while ($data_tbl_customer = mysql_fetch_array($tbl_customer))
												{
											?>
												<tr>
													<td>
														<?php echo $no ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_category_name'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_class_name'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_code'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_name'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_address'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_contact'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_phone'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['product_sell_price_name'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_product_sell_program_promo'] ?>
													</td>
													<td>
													<?php
														if ($data_tbl_customer['customer_active'] == "1")
														{
													?>
														<span class="label label-info label-sm">Active</span>
													<?php
														}
														else
														{
													?>
														<span class="label label-danger label-sm">Non Active</span>
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
			<?php
					}
				}
				else
				{
				$tbl_customer_districts = mysql_query("SELECT a.customer_districts_id, a.customer_districts_name, b.customer_city_name FROM customer_districts a, customer_city b WHERE a.customer_districts_id = '".$_POST['customer_districts_id']."' AND a.customer_districts_active = '1' AND b.customer_city_active = '1' AND a.customer_city_id = b.customer_city_id");
				$data_tbl_customer_districts = mysql_fetch_array($tbl_customer_districts);
			?>
				<div class="row">
					<div class="col-md-12">
						<div class="bordered light portlet">
							<div class="portlet-title">
								<div class="caption">
									<span class="caption-subject font-red sbold uppercase">
										<?php echo $data_tbl_customer_districts['customer_districts_name'] ?> - <?php echo $data_tbl_customer_districts['customer_city_name'] ?>
									</span>
									<span class="caption-helper sbold uppercase">
									<?php
										$tbl_customer_category = mysql_query("SELECT customer_category_id, customer_category_name FROM customer_category WHERE customer_category_active = '1' ORDER BY customer_category_name");
										while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
										{
											$tbl_customer_quantity_customer_category = mysql_query("SELECT COUNT(customer_id) AS customer_quantity_customer_category FROM customer WHERE customer_category_id = '".$data_tbl_customer_category['customer_category_id']."' AND customer_districts_id = '".$data_tbl_customer_districts['customer_districts_id']."'");
											$data_tbl_customer_quantity_customer_category = mysql_fetch_array($tbl_customer_quantity_customer_category);
											
											$customer_quantity_customer_category_indo = format_angka($data_tbl_customer_quantity_customer_category['customer_quantity_customer_category']);
									?>
										<?php echo $data_tbl_customer_category['customer_category_name'] ?> : <?php echo $customer_quantity_customer_category_indo ?>
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
													Kategori
												</th>
												<th>
													Kelas
												</th>
												<th>
													Kode
												</th>
												<th>
													Pelanggan
												</th>
												<th>
													Alamat
												</th>
												<th>
													Kontak
												</th>
												<th>
													No. Telepon
												</th>
												<th>
													Harga Jual Produk
												</th>
												<th>
													Program Promo Produk
												</th>
												<th>
													Status
												</th>
											</tr>
										</thead>
										<tbody>
										<?php
											$no = 1;
											$tbl_customer = mysql_query("SELECT a.customer_code, a.customer_name, a.customer_address, a.customer_contact, a.customer_phone, a.customer_product_sell_program_promo, a.customer_active, b.customer_category_name, c.customer_class_name, d.product_sell_price_name FROM customer a, customer_category b, customer_class c, product_sell_price d WHERE a.customer_districts_id = '".$data_tbl_customer_districts['customer_districts_id']."' AND b.customer_category_active = '1' AND c.customer_class_active = '1' AND d.product_sell_price_active = '1' AND a.customer_category_id = b.customer_category_id AND a.customer_class_id = c.customer_class_id AND a.product_sell_price_id = d.product_sell_price_id ORDER BY a.customer_code");
											while ($data_tbl_customer = mysql_fetch_array($tbl_customer))
											{
										?>
											<tr>
												<td>
													<?php echo $no ?>
												</td>
												<td>
													<?php echo $data_tbl_customer['customer_category_name'] ?>
												</td>
												<td>
													<?php echo $data_tbl_customer['customer_class_name'] ?>
												</td>
												<td>
													<?php echo $data_tbl_customer['customer_code'] ?>
												</td>
												<td>
													<?php echo $data_tbl_customer['customer_name'] ?>
												</td>
												<td>
													<?php echo $data_tbl_customer['customer_address'] ?>
												</td>
												<td>
													<?php echo $data_tbl_customer['customer_contact'] ?>
												</td>
												<td>
													<?php echo $data_tbl_customer['customer_phone'] ?>
												</td>
												<td>
													<?php echo $data_tbl_customer['product_sell_price_name'] ?>
												</td>
												<td>
													<?php echo $data_tbl_customer['customer_product_sell_program_promo'] ?>
												</td>
												<td>
												<?php
													if ($data_tbl_customer['customer_active'] == "1")
													{
												?>
													<span class="label label-info label-sm">Active</span>
												<?php
													}
													else
													{
												?>
													<span class="label label-danger label-sm">Non Active</span>
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
			<?php
				}
			?>
		</div>
<?php
	}
	function form_search_salesman_by_customer_quantity_customer_report()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Laporan Pelanggan
								</span>
								<span class="caption-helper sbold uppercase">
									Per Salesman Berdasarkan Jumlah Pelanggan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=customer-report&tib=form-view-salesman-by-customer-quantity-customer-report" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
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
													<option value="0">Semua Salesman</option>
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
	function form_view_salesman_by_customer_quantity_customer_report()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Laporan Pelanggan
								</span>
								<span class="caption-helper sbold uppercase">
									Per Salesman Berdasarkan Jumlah Pelanggan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=customer-report&tib=form-view-salesman-by-customer-quantity-customer-report" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
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
													<?php
														if ($_POST['salesman_id'] == "0")
														{
													?>
														<option selected="selected" value="0">Semua Salesman</option>
													<?php
														}
														else
														{
													?>
														<option value="0">Semua Salesman</option>
													<?php
														}
													?>
													<?php
														$tbl_user = mysql_query("SELECT a.user_id, a.user_name FROM user a, user_category b WHERE a.user_active = '1' AND b.user_category_active = '1' AND a.user_category_id = b.user_category_id AND b.user_category_name LIKE 'Salesman%' ORDER BY a.user_name");
														while($data_tbl_user = mysql_fetch_array($tbl_user))
														{
															if ($data_tbl_user['user_id'] == $_POST['salesman_id'])
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
			<?php
				if ($_POST['salesman_id'] == '0')
				{
					$tbl_user = mysql_query("SELECT a.user_id, a.user_name, b.user_category_name FROM user a, user_category b WHERE a.user_active = '1' AND b.user_category_name LIKE 'Salesman%' AND b.user_category_active = '1' AND a.user_category_id = b.user_category_id ORDER BY a.user_name");
					while($data_tbl_user = mysql_fetch_array($tbl_user))
					{
			?>
					<div class="row">
						<div class="col-md-12">
							<div class="bordered light portlet">
								<div class="portlet-title">
									<div class="caption">
										<span class="caption-subject font-blue sbold uppercase">
											<?php echo $data_tbl_user['user_name'] ?>
										</span>
									</div>
								</div>
								<?php
									$tbl_customer_districts = mysql_query("SELECT a.sales_plan_id, d.customer_districts_id, d.customer_districts_name, e.customer_city_name FROM sales_plan a, sales_plan_detail b, customer c, customer_districts d, customer_city e WHERE a.salesman_id = '".$data_tbl_user['user_id']."' AND c.customer_active = '1' AND d.customer_districts_active = '1' AND e.customer_city_active = '1' AND a.sales_plan_id = b.sales_plan_id AND b.customer_id = c.customer_id AND c.customer_districts_id = d.customer_districts_id AND d.customer_city_id = e.customer_city_id GROUP BY c.customer_id ORDER BY d.customer_districts_name");
									while($data_tbl_customer_districts = mysql_fetch_array($tbl_customer_districts))
									{
								?>
									<h5 class="font-red sbold uppercase">
										<?php echo $data_tbl_customer_districts['customer_districts_name'] ?> - <?php echo $data_tbl_customer_districts['customer_city_name'] ?>
										<small class="font-yellow sbold uppercase">
										<?php
											$tbl_customer_category = mysql_query("SELECT customer_category_id, customer_category_name FROM customer_category WHERE customer_category_active = '1' ORDER BY customer_category_name");
											while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
											{
												$tbl_sales_plan_detail_quantity_customer_category = mysql_query("SELECT COUNT(b.customer_id) AS customer_quantity_customer_category FROM sales_plan_detail a, customer b WHERE a.sales_plan_id = '".$data_tbl_customer_districts['sales_plan_id']."' AND b.customer_category_id = '".$data_tbl_customer_category['customer_category_id']."' AND b.customer_active = '1' AND b.customer_districts_id = '".$data_tbl_customer_districts['customer_districts_id']."' AND a.customer_id = b.customer_id");
												$data_tbl_sales_plan_detail_quantity_customer_category = mysql_fetch_array($tbl_sales_plan_detail_quantity_customer_category);
												
												$customer_quantity_customer_category_indo = format_angka($data_tbl_sales_plan_detail_quantity_customer_category['customer_quantity_customer_category']);
										?>
											<?php echo $data_tbl_customer_category['customer_category_name'] ?> : <?php echo $customer_quantity_customer_category_indo ?>
										<?php
											}
										?>
										</small>
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
															Kategori
														</th>
														<th>
															Kelas
														</th>
														<th>
															Kode
														</th>
														<th>
															Pelanggan
														</th>
														<th>
															Alamat
														</th>
														<th>
															Kontak
														</th>
														<th>
															No. Telepon
														</th>
														<th>
															Harga Jual Produk
														</th>
														<th>
															Program Promo Produk
														</th>
														<th>
															Status
														</th>
													</tr>
												</thead>
												<tbody>
												<?php
													$no = 1;
													$tbl_customer = mysql_query("SELECT b.customer_code, b.customer_name, b.customer_address, b.customer_contact, b.customer_phone, b.customer_product_sell_program_promo, b.customer_active, c.customer_category_name, d.customer_class_name, e.product_sell_price_name FROM sales_plan_detail a, customer b, customer_category c, customer_class d, product_sell_price e WHERE a.sales_plan_id = '".$data_tbl_customer_districts['sales_plan_id']."' AND b.customer_districts_id = '".$data_tbl_customer_districts['customer_districts_id']."' AND b.customer_active = '1' AND c.customer_category_active = '1' AND d.customer_class_active = '1' AND e.product_sell_price_active = '1' AND a.customer_id = b.customer_id AND b.customer_category_id = c.customer_category_id AND b.customer_class_id = d.customer_class_id AND b.product_sell_price_id = e.product_sell_price_id ORDER BY b.customer_code");
													while ($data_tbl_customer = mysql_fetch_array($tbl_customer))
													{
												?>
													<tr>
														<td>
															<?php echo $no ?>
														</td>
														<td>
															<?php echo $data_tbl_customer['customer_category_name'] ?>
														</td>
														<td>
															<?php echo $data_tbl_customer['customer_class_name'] ?>
														</td>
														<td>
															<?php echo $data_tbl_customer['customer_code'] ?>
														</td>
														<td>
															<?php echo $data_tbl_customer['customer_name'] ?>
														</td>
														<td>
															<?php echo $data_tbl_customer['customer_address'] ?>
														</td>
														<td>
															<?php echo $data_tbl_customer['customer_contact'] ?>
														</td>
														<td>
															<?php echo $data_tbl_customer['customer_phone'] ?>
														</td>
														<td>
															<?php echo $data_tbl_customer['product_sell_price_name'] ?>
														</td>
														<td>
															<?php echo $data_tbl_customer['customer_product_sell_program_promo'] ?>
														</td>
														<td>
														<?php
															if ($data_tbl_customer['customer_active'] == "1")
															{
														?>
															<span class="label label-info label-sm">Active</span>
														<?php
															}
															else
															{
														?>
															<span class="label label-danger label-sm">Non Active</span>
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
			<?php
					}
				}
				else
				{
				$tbl_user = mysql_query("SELECT a.user_id, a.user_name FROM user a, user_category b WHERE a.user_id = '".$_POST['salesman_id']."' AND a.user_active = '1' AND b.user_category_active = '1' AND a.user_category_id = b.user_category_id");
				$data_tbl_user = mysql_fetch_array($tbl_user);
		?>
				<div class="row">
					<div class="col-md-12">
						<div class="bordered light portlet">
							<div class="portlet-title">
								<div class="caption">
									<span class="caption-subject font-blue sbold uppercase">
										<?php echo $data_tbl_user['user_name'] ?>
									</span>
								</div>
							</div>
							<?php
								$tbl_customer_districts = mysql_query("SELECT a.sales_plan_id, d.customer_districts_id, d.customer_districts_name, e.customer_city_name FROM sales_plan a, sales_plan_detail b, customer c, customer_districts d, customer_city e WHERE a.salesman_id = '".$data_tbl_user['user_id']."' AND a.sales_plan_active = '1' AND c.customer_active = '1' AND d.customer_districts_active = '1' AND e.customer_city_active = '1' AND a.sales_plan_id = b.sales_plan_id AND b.customer_id = c.customer_id AND c.customer_districts_id = d.customer_districts_id AND d.customer_city_id = e.customer_city_id GROUP BY d.customer_districts_id ORDER BY d.customer_districts_name");
								while($data_tbl_customer_districts = mysql_fetch_array($tbl_customer_districts))
								{
							?>
								<h5 class="font-red sbold uppercase">
									<?php echo $data_tbl_customer_districts['customer_districts_name'] ?> - <?php echo $data_tbl_customer_districts['customer_city_name'] ?>
									<small class="font-yellow sbold uppercase">
									<?php
										$tbl_customer_category = mysql_query("SELECT customer_category_id, customer_category_name FROM customer_category WHERE customer_category_active = '1' ORDER BY customer_category_name");
										while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
										{
											$tbl_sales_plan_detail_quantity_customer_category = mysql_query("SELECT COUNT(b.customer_id) AS customer_quantity_customer_category FROM sales_plan_detail a, customer b WHERE a.sales_plan_id = '".$data_tbl_customer_districts['sales_plan_id']."' AND b.customer_category_id = '".$data_tbl_customer_category['customer_category_id']."' AND b.customer_districts_id = '".$data_tbl_customer_districts['customer_districts_id']."' AND b.customer_active = '1' AND a.customer_id = b.customer_id");
											$data_tbl_sales_plan_detail_quantity_customer_category = mysql_fetch_array($tbl_sales_plan_detail_quantity_customer_category);
											
											$customer_quantity_customer_category_indo = format_angka($data_tbl_sales_plan_detail_quantity_customer_category['customer_quantity_customer_category']);
									?>
										<?php echo $data_tbl_customer_category['customer_category_name'] ?> : <?php echo $customer_quantity_customer_category_indo ?>
									<?php
										}
									?>
									</small>
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
														Kategori
													</th>
													<th>
														Kelas
													</th>
													<th>
														Kode
													</th>
													<th>
														Pelanggan
													</th>
													<th>
														Alamat
													</th>
													<th>
														Kontak
													</th>
													<th>
														No. Telepon
													</th>
													<th>
														Harga Jual Produk
													</th>
													<th>
														Program Promo Produk
													</th>
													<th>
														Status
													</th>
												</tr>
											</thead>
											<tbody>
											<?php
												$no = 1;
												$tbl_customer = mysql_query("SELECT b.customer_code, b.customer_name, b.customer_address, b.customer_contact, b.customer_phone, b.customer_product_sell_program_promo, b.customer_active, c.customer_category_name, d.customer_class_name, e.product_sell_price_name FROM sales_plan_detail a, customer b, customer_category c, customer_class d, product_sell_price e WHERE a.sales_plan_id = '".$data_tbl_customer_districts['sales_plan_id']."' AND b.customer_districts_id = '".$data_tbl_customer_districts['customer_districts_id']."' AND b.customer_active = '1' AND c.customer_category_active = '1' AND d.customer_class_active = '1' AND e.product_sell_price_active = '1' AND a.customer_id = b.customer_id AND b.customer_category_id = c.customer_category_id AND b.customer_class_id = d.customer_class_id AND b.product_sell_price_id = e.product_sell_price_id ORDER BY b.customer_code");
												while ($data_tbl_customer = mysql_fetch_array($tbl_customer))
												{
											?>
												<tr>
													<td>
														<?php echo $no ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_category_name'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_class_name'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_code'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_name'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_address'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_contact'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_phone'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['product_sell_price_name'] ?>
													</td>
													<td>
														<?php echo $data_tbl_customer['customer_product_sell_program_promo'] ?>
													</td>
													<td>
													<?php
														if ($data_tbl_customer['customer_active'] == "1")
														{
													?>
														<span class="label label-info label-sm">Active</span>
													<?php
														}
														else
														{
													?>
														<span class="label label-danger label-sm">Non Active</span>
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
			<?php
				}
			?>
		</div>
<?php
	}
?>