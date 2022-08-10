<?php
	function form_initial_sales_target()
	{
?>
		<div class="page-fixed-main-content">	 
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Target Penjualan
								</span>
							</div>
							<div class="actions">
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=sales-target&tib=form-add-sales-target">
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
											Periode
										</th>
                                                                                 <th>
											Value
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
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_sales_target = mysql_query("SELECT a.sales_target_id,a.sales_target_value, a.sales_target_period, b.user_name FROM sales_target a, user b WHERE a.sales_target_active = '1' AND b.user_active = '1' AND a.salesman_id = b.user_id ORDER BY a.sales_target_period DESC");
									while ($data_tbl_sales_target = mysql_fetch_array($tbl_sales_target))
									{
										$sales_target_period = explode("-", $data_tbl_sales_target['sales_target_period']);
										$month_sales_target = $sales_target_period[1];
										$year_sales_target = $sales_target_period[0];
										$month_sales_target = bulan($month_sales_target);

                                                                                $data_tbl_sales_target_indo = format_angka($data_tbl_sales_target['sales_target_value']);
								?>
									<tr class="odd gradeX">
										<td>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=sales-target&tib=form-edit-sales-target&sales_target_id=<?php echo $data_tbl_sales_target['sales_target_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_sales_target_id_<?php echo $data_tbl_sales_target['sales_target_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										</td>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_target['user_name'] ?>
										</td>
										<td>
											<?php echo $month_sales_target ?> <?php echo $year_sales_target ?>
										</td>
                                                                                 <td>
											<?php echo $data_tbl_sales_target_indo  ?>
										</td>
										<?php
											$tbl_sales_target_detail = mysql_query("SELECT sales_target_detail_product_sell_quantity FROM sales_target_detail WHERE sales_target_id = '".$data_tbl_sales_target['sales_target_id']."'");
											while ($data_tbl_sales_target_detail = mysql_fetch_array($tbl_sales_target_detail))
											{
												$sales_target_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_target_detail['sales_target_detail_product_sell_quantity']);
										?>
											<td>
												<?php echo $sales_target_detail_product_sell_quantity_indo ?>
											</td>
										<?php
											}
										?>
									</tr>
									<div aria-hidden="true" class="modal fade" id="delete_sales_target_id_<?php echo $data_tbl_sales_target['sales_target_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=sales-target&tib=delete-sales-target&sales_target_id=<?php echo $data_tbl_sales_target['sales_target_id'] ?>">
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
	function form_add_sales_target()
	{
		$blnthn_sekarang_indo = date("m-Y");
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Target Penjualan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=sales-target&tib=add-sales-target" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<h4 class="form-section">
										Periode Target
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
												<select class="form-control select2me" data-error-container="#salesman_id" data-placeholder="Salesman" name="salesman_id">
													<option value=""></option>
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
													Periode
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="mm-yyyy" data-date-minviewmode="months" data-date-start-date="+0d" data-date-viewmode="years" name="sales_target_period" placeholder="Periode" type="text" value="<?php echo $blnthn_sekarang_indo ?>">
											</div>
										</div>
                                                                                <div class="col-md-6">
											<div class="form-group">
												<label>
													Value
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="sales_target_value" placeholder="Value" type="text">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline purple sbold">
										<i class="fa fa-feed"></i>
										Proses
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=sales-target'">
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
	function form_product_sell_sales_target()
	{
		$tbl_sales_target = mysql_query("SELECT a.sales_target_id, a.sales_target_period, b.user_name FROM sales_target a, user b WHERE a.sales_target_id = '".$_GET['sales_target_id']."' AND a.salesman_id = b.user_id");
		$data_tbl_sales_target = mysql_fetch_array($tbl_sales_target);
		
		$sales_target_period = explode("-", $data_tbl_sales_target['sales_target_period']);
		$month_sales_target = $sales_target_period[1];
		$year_sales_target = $sales_target_period[0];
		
		$month_sales_target_indo = bulan($month_sales_target);
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_sales_target['user_name'] ?>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $month_sales_target_indo ?> <?php echo $year_sales_target ?>
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
									Target Penjualan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=sales-target&tib=product-sell-sales-target" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="sales_target_id" type="hidden" value="<?php echo $data_tbl_sales_target['sales_target_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Produk
									</h4>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Produk
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#product_sell_id" data-placeholder="Produk" name="product_sell_id">
													<option value=""></option>
													<?php
														$tbl_product_sell = mysql_query("SELECT product_sell_id, product_sell_name FROM product_sell WHERE product_sell_active = '1' ORDER BY product_sell_code");
														while($data_tbl_product_sell = mysql_fetch_array($tbl_product_sell))
														{
															$tbl_sales_target_detail = mysql_query("SELECT sales_target_detail_id FROM sales_target_detail WHERE sales_target_id = '".$data_tbl_sales_target['sales_target_id']."' AND product_sell_id = '".$data_tbl_product_sell['product_sell_id']."'");
															$jumlah_tbl_sales_target_detail = mysql_num_rows($tbl_sales_target_detail);

															if ($jumlah_tbl_sales_target_detail < 1)
															{
													?>
															<option value="<?php echo $data_tbl_product_sell['product_sell_id'] ?>"><?php echo $data_tbl_product_sell['product_sell_name'] ?></option>
													<?php
															}
														}
													?>
												</select>
												<div id="product_sell_id"></div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Jumlah
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="sales_target_detail_product_sell_quantity" placeholder="Jumlah" type="text">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline blue sbold">
										<i class="fa fa-plus"></i>
										Tambah
									</button>
									<?php
										$tbl_sales_target_detail = mysql_query("SELECT sales_target_id FROM sales_target_detail WHERE sales_target_id = '".$data_tbl_sales_target['sales_target_id']."'");
										$jumlah_tbl_sales_target_detail = mysql_num_rows($tbl_sales_target_detail);
										
										if ($jumlah_tbl_sales_target_detail == 3)
										{
									?>
										<button type="button" class="btn btn-sm btn-outline green sbold" onclick="location.href='?alimms=sales-target'">
											<i class="fa fa-home"></i>
											Selesai
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
											Produk
										</th>
										<th>
											Jumlah
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_sales_target_detail = mysql_query("SELECT a.sales_target_detail_id, a.sales_target_detail_product_sell_quantity, b.product_sell_name FROM sales_target_detail a, product_sell b WHERE a.sales_target_id = '".$data_tbl_sales_target['sales_target_id']."' AND a.product_sell_id = b.product_sell_id ORDER BY b.product_sell_code");
									while ($data_tbl_sales_target_detail = mysql_fetch_array($tbl_sales_target_detail))
									{
										$sales_target_detail_product_sell_quantity_indo = format_angka($data_tbl_sales_target_detail['sales_target_detail_product_sell_quantity']);
								?>
									<tr class="odd gradeX">
										<td>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#remove_sales_target_detail_id_<?php echo $data_tbl_sales_target_detail['sales_target_detail_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										</td>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_target_detail['product_sell_name'] ?>
										</td>
										<td>
											<?php echo $sales_target_detail_product_sell_quantity_indo ?>
										</td>
									</tr>
									<div aria-hidden="true" class="modal fade" id="remove_sales_target_detail_id_<?php echo $data_tbl_sales_target_detail['sales_target_detail_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=sales-target&tib=remove-sales-target&sales_target_detail_id=<?php echo $data_tbl_sales_target_detail['sales_target_detail_id'] ?>">
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
	function form_edit_sales_target()
	{
		$tbl_sales_target = mysql_query("SELECT sales_target_id, salesman_id, sales_target_period,sales_target_value FROM sales_target WHERE sales_target_id = '".$_GET['sales_target_id']."'");
		$data_tbl_sales_target = mysql_fetch_array($tbl_sales_target);
		
		$sales_target_period = explode("-", $data_tbl_sales_target['sales_target_period']);			
		$month_sales_target = $sales_target_period[1];
		$year_sales_target = $sales_target_period[0];
		$sales_target_period = $month_sales_target.'-'.$year_sales_target;

                $data_tbl_sales_target_indo = format_angka($data_tbl_sales_target['sales_target_value']);
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Target Penjualan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=sales-target&tib=edit-sales-target" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="sales_target_id" type="hidden" value="<?php echo $data_tbl_sales_target['sales_target_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Target Penjualan
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
												<select class="form-control select2me" data-error-container="#salesman_id" data-placeholder="Salesman" name="salesman_id">
													<option value=""></option>
													<?php
														$tbl_user = mysql_query("SELECT a.user_id, a.user_name FROM user a, user_category b WHERE a.user_active = '1' AND b.user_category_active = '1' AND a.user_category_id = b.user_category_id AND b.user_category_name LIKE 'Salesman%' ORDER BY a.user_name");
														while($data_tbl_user = mysql_fetch_array($tbl_user))
														{
															if ($data_tbl_user['user_id'] == $data_tbl_sales_target['salesman_id'])
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
													Periode
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="mm-yyyy" data-date-minviewmode="months" data-date-start-date="+0d" data-date-viewmode="years" name="sales_target_period" placeholder="Periode" type="text" value="<?php echo $sales_target_period ?>">
											</div>
										</div>
                                                                                <div class="col-md-6">
											<div class="form-group">
												<label>
													Value
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="sales_target_value" placeholder="Value" type="text" value="<?php echo $data_tbl_sales_target_indo ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline purple sbold">
										<i class="fa fa-feed"></i>
										Proses
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=sales-target'">
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
?>