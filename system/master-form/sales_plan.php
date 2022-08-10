<?php
	function form_initial_sales_plan()
	{
?>
		<div class="page-fixed-main-content">	 
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Rencana Penjualan
								</span>
							</div>
							<div class="actions">
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=sales-plan&tib=form-add-sales-plan">
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
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_sales_plan = mysql_query("SELECT a.sales_plan_id, a.sales_plan_date, b.user_name FROM sales_plan a, user b WHERE a.sales_plan_active = '1' AND b.user_active = '1' AND a.salesman_id = b.user_id ORDER BY a.sales_plan_date DESC");
									while ($data_tbl_sales_plan = mysql_fetch_array($tbl_sales_plan))
									{
										$sales_plan_date_indo = tanggal_indo($data_tbl_sales_plan['sales_plan_date']);
								?>
									<tr class="odd gradeX">
										<td>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=sales-plan&tib=form-view-sales-plan&sales_plan_id=<?php echo $data_tbl_sales_plan['sales_plan_id'] ?>">
												<i class="fa fa-search"></i>
											</a>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=sales-plan&tib=form-edit-sales-plan&sales_plan_id=<?php echo $data_tbl_sales_plan['sales_plan_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_sales_plan_id_<?php echo $data_tbl_sales_plan['sales_plan_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										</td>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_plan['user_name'] ?>
										</td>
										<td>
											<?php echo $sales_plan_date_indo ?>
										</td>
									</tr>
									<div aria-hidden="true" class="modal fade" id="delete_sales_plan_id_<?php echo $data_tbl_sales_plan['sales_plan_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=sales-plan&tib=delete-sales-plan&sales_plan_id=<?php echo $data_tbl_sales_plan['sales_plan_id'] ?>">
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
	function form_add_sales_plan()
	{
		$tgl_sekarang = date("Y-m-d");
		$tgl_sekarang_indo = date("d-m-Y");
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Rencana Penjualan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=sales-plan&tib=add-sales-plan" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<h4 class="form-section">
										Tanggal Rencana
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
													Tanggal
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d" name="sales_plan_date" placeholder="Tanggal" type="text" value="<?php echo $tgl_sekarang_indo ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline purple sbold">
										<i class="fa fa-feed"></i>
										Proses
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=sales-plan'">
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
	function form_add_sales_plan_schedule()
	{
		$tgl_sekarang = date("Y-m-d");
		$tgl_sekarang_indo = date("d-m-Y");
		
		$tbl_sales_plan = mysql_fetch_array(mysql_query("SELECT * FROM sales_plan where sales_plan_id = '".$_GET['sales_plan_id']."'"));
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Rencana Penjualan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=sales-plan&tib=form-sales-plan-schedule-entry" class="horizontal-form" id="form_sample_3" method="post">
                            <input type="hidden" name="salesman_id" value="<?php echo $tbl_sales_plan['salesman_id'] ?>" />
                            <input type="hidden" name="sales_plan_id" value="<?php echo $tbl_sales_plan['sales_plan_id'] ?>" />
								<div class="form-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Hari
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#salesman_id" data-placeholder="Hari" name="sales_schedule_day">
													<option value=""></option>
													<?php
														$tbl_sales_schedule = mysql_query("SELECT sales_schedule_id, sales_schedule_day FROM sales_schedule WHERE sales_schedule_active = '1' AND salesman_id = '".$tbl_sales_plan['salesman_id']."' GROUP BY sales_schedule_day ORDER BY sales_schedule_day");
														while($data_tbl_sales_schedule = mysql_fetch_array($tbl_sales_schedule))
														{
													?>
														<option value="<?php echo $data_tbl_sales_schedule['sales_schedule_day'] ?>"><?php echo $data_tbl_sales_schedule['sales_schedule_day'] ?></option>
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
													Minggu
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#salesman_id" data-placeholder="Minggu" name="sales_schedule_week">
													<option value=""></option>
													<?php
														$tbl_sales_schedule = mysql_query("SELECT sales_schedule_id, sales_schedule_week FROM sales_schedule WHERE sales_schedule_active = '1' AND salesman_id = '".$tbl_sales_plan['salesman_id']."' GROUP BY sales_schedule_week ORDER BY sales_schedule_day ");
														while($data_tbl_sales_schedule = mysql_fetch_array($tbl_sales_schedule))
														{
													?>
														<option value="<?php echo $data_tbl_sales_schedule['sales_schedule_week'] ?>"><?php echo $data_tbl_sales_schedule['sales_schedule_week'] ?></option>
													<?php
														}
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline purple sbold">
										<i class="fa fa-feed"></i>
										Proses
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=sales-plan&tib=sales-plan-canceled&sales_plan_id=<?php echo $tbl_sales_plan['sales_plan_id'] ?>'">
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
	function form_customer_sales_plan()
	{
		$tbl_sales_plan = mysql_query("SELECT a.sales_plan_id, a.sales_plan_date, b.user_name FROM sales_plan a, user b WHERE a.sales_plan_id = '".$_GET['sales_plan_id']."' AND a.salesman_id = b.user_id");
		$data_tbl_sales_plan = mysql_fetch_array($tbl_sales_plan);
		
		$sales_plan_date_indo = tanggal_indo($data_tbl_sales_plan['sales_plan_date']);
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_sales_plan['user_name'] ?>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascript:;">
							<?php echo $sales_plan_date_indo ?>
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
									Rencana Penjualan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=sales-plan&tib=customer-sales-plan" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="sales_plan_id" type="hidden" value="<?php echo $data_tbl_sales_plan['sales_plan_id'] ?>">
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
															$tbl_sales_plan_detail = mysql_query("SELECT b.customer_id FROM sales_plan a, sales_plan_detail b WHERE a.sales_plan_date = '".$data_tbl_sales_plan['sales_plan_date']."' AND a.sales_plan_active = '1' AND b.customer_id = '".$data_tbl_customer['customer_id']."' AND a.sales_plan_id = b.sales_plan_id");
															$jumlah_tbl_sales_plan_detail = mysql_num_rows($tbl_sales_plan_detail);
															
															if ($jumlah_tbl_sales_plan_detail < 1)
															{
													?>
															<option value="<?php echo $data_tbl_customer['customer_id'] ?>"><?php echo $data_tbl_customer['customer_category_name'] ?> - <?php echo $data_tbl_customer['customer_code'] ?> - <?php echo $data_tbl_customer['customer_name'] ?> - <?php echo $data_tbl_customer['customer_address'] ?> (<?php echo $data_tbl_customer['customer_districts_name'] ?>)</option>
													<?php
															}
														}
													?>
												</select>
												<div id="customer_id"></div>
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
										$tbl_sales_plan_detail = mysql_query("SELECT sales_plan_id FROM sales_plan_detail WHERE sales_plan_id = '".$data_tbl_sales_plan['sales_plan_id']."'");
										$jumlah_tbl_sales_plan_detail = mysql_num_rows($tbl_sales_plan_detail);
										
										if ($jumlah_tbl_sales_plan_detail > 0)
										{
									?>
										<button type="button" class="btn btn-sm btn-outline green sbold" onclick="location.href='?alimms=sales-plan'">
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
											Kategori
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
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_sales_plan_detail = mysql_query("SELECT a.sales_plan_detail_id, b.customer_id, b.customer_code, b.customer_name, b.customer_address, c.customer_category_name, d.customer_districts_name FROM sales_plan_detail a, customer b, customer_category c, customer_districts d WHERE a.sales_plan_id = '".$data_tbl_sales_plan['sales_plan_id']."' AND a.customer_id = b.customer_id AND b.customer_category_id = c.customer_category_id AND b.customer_districts_id = d.customer_districts_id ORDER BY a.sales_plan_detail_id");
									while ($data_tbl_sales_plan_detail = mysql_fetch_array($tbl_sales_plan_detail))
									{
								?>
									<tr class="odd gradeX">
										<td>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#remove_sales_plan_detail_id_<?php echo $data_tbl_sales_plan_detail['sales_plan_detail_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										</td>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_plan_detail['customer_category_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_plan_detail['customer_code'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_plan_detail['customer_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_plan_detail['customer_address'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_plan_detail['customer_districts_name'] ?>
										</td>
									</tr>
									<div aria-hidden="true" class="modal fade" id="remove_sales_plan_detail_id_<?php echo $data_tbl_sales_plan_detail['sales_plan_detail_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=sales-plan&tib=remove-sales-plan&sales_plan_detail_id=<?php echo $data_tbl_sales_plan_detail['sales_plan_detail_id'] ?>">
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
	function form_edit_sales_plan()
	{
		$tbl_sales_plan = mysql_query("SELECT sales_plan_id, salesman_id, sales_plan_date FROM sales_plan WHERE sales_plan_id = '".$_GET['sales_plan_id']."'");
		$data_tbl_sales_plan = mysql_fetch_array($tbl_sales_plan);
		
		$sales_plan_date = explode("-", $data_tbl_sales_plan['sales_plan_date']);
		$date_sales_plan = $sales_plan_date[2];
		$month_sales_plan = $sales_plan_date[1];
		$year_sales_plan = $sales_plan_date[0];
		$sales_plan_date = date("d-m-Y", mktime(0, 0, 0, $month_sales_plan, $date_sales_plan, $year_sales_plan));
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Rencana Penjualan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=sales-plan&tib=edit-sales-plan" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="sales_plan_id" type="hidden" value="<?php echo $data_tbl_sales_plan['sales_plan_id'] ?>">
								<div class="form-body">
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
															if ($data_tbl_user['user_id'] == $data_tbl_sales_plan['salesman_id'])
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
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d" name="sales_plan_date" placeholder="Tanggal" type="text" value="<?php echo $sales_plan_date ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline purple sbold">
										<i class="fa fa-feed"></i>
										Proses
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=sales-plan'">
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
	function form_view_sales_plan()
	{
		$tbl_sales_plan = mysql_query("SELECT a.sales_plan_id, a.sales_plan_date, b.user_name FROM sales_plan a, user b WHERE a.sales_plan_id = '".$_GET['sales_plan_id']."' AND a.salesman_id = b.user_id");
		$data_tbl_sales_plan = mysql_fetch_array($tbl_sales_plan);
		
		$sales_plan_date_indo = tanggal_indo($data_tbl_sales_plan['sales_plan_date']);
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_sales_plan['user_name'] ?>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascrip:;">
							<?php echo $sales_plan_date_indo ?>
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
									Rencana Penjualan
								</span>
							</div>
							<div class="actions">
								<a class="btn btn-outline btn-sm sbold yellow" href="?alimms=sales-plan">
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
											Kategori
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
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_sales_plan_detail = mysql_query("SELECT b.customer_id, b.customer_code, b.customer_name, b.customer_address, c.customer_category_name, d.customer_districts_name FROM sales_plan_detail a, customer b, customer_category c, customer_districts d WHERE a.sales_plan_id = '".$data_tbl_sales_plan['sales_plan_id']."' AND a.customer_id = b.customer_id AND b.customer_category_id = c.customer_category_id AND b.customer_districts_id = d.customer_districts_id ORDER BY a.sales_plan_detail_id");
									while ($data_tbl_sales_plan_detail = mysql_fetch_array($tbl_sales_plan_detail))
									{
								?>
									<tr class="odd gradeX">
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_plan_detail['customer_category_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_plan_detail['customer_code'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_plan_detail['customer_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_plan_detail['customer_address'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_plan_detail['customer_districts_name'] ?>
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
	function form_sales_plan_schedule_entry()
	{
		$tbl_sales_schedule = mysql_query("SELECT * FROM sales_schedule a, user b WHERE a.sales_schedule_active = '1' AND a.salesman_id = '".$_POST['salesman_id']."' AND a.sales_schedule_day = '".$_POST['sales_schedule_day']."' AND a.sales_schedule_week = '".$_POST['sales_schedule_week']."' AND a.salesman_id = b.user_id");
		$data_tbl_sales_schedule = mysql_fetch_array($tbl_sales_schedule);
?>
		<div class="page-fixed-main-content">
			<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_sales_schedule['user_name'] ?>
				</h3>
				<ul class="todo-breadcrumb">
					<li>
						<a class="todo-active" href="javascrip:;">
							<?php echo $data_tbl_sales_schedule['sales_schedule_day'] ?>
						</a>
					</li>
                    <li>
						<a class="todo-active" href="javascrip:;">
							<?php echo "Minggu Ke - ".' '.$data_tbl_sales_schedule['sales_schedule_week'] ?>
						</a>
					</li>
				</ul>
			</div>
       <form action="?alimms=sales-plan&tib=add-sales-plan-schedule" class="horizontal-form" id="form_sample_3" method="post">
       	<input type="hidden" name="sales_schedule_id" value="<?php echo $data_tbl_sales_schedule['sales_schedule_id'] ?>" />
        <input type="hidden" name="sales_plan_id" value="<?php echo $_POST['sales_plan_id'] ?>" />
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Jadwal Penjualan
								</span>
							</div>
							<div class="actions">
                            	<button type="submit" class="btn btn-sm btn-outline purple sbold">
										<i class="fa fa-feed"></i>
										Proses
								</button>
								<a class="btn btn-outline btn-sm sbold yellow" href="?alimms=sales-plan&tib=sales-plan-canceled&sales_plan_id=<?php echo $_POST['sales_plan_id'] ?>">
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
											Kategori
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
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_sales_schedule_detail = mysql_query("SELECT * FROM sales_schedule a, sales_schedule_detail b, customer c, customer_category d, customer_districts e WHERE a.sales_schedule_active = '1' AND a.salesman_id = '".$_POST['salesman_id']."' AND a.sales_schedule_day = '".$_POST['sales_schedule_day']."' AND a.sales_schedule_week = '".$_POST['sales_schedule_week']."' AND a.sales_schedule_id = b.sales_schedule_id AND b.customer_id = c.customer_id AND c.customer_category_id = d.customer_category_id AND c.customer_districts_id = e.customer_districts_id ORDER BY b.sales_schedule_detail_id");
									while ($data_tbl_sales_schedule_detail = mysql_fetch_array($tbl_sales_schedule_detail))
									{
								?>
									<tr class="odd gradeX">
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_schedule_detail['customer_category_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_schedule_detail['customer_code'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_schedule_detail['customer_name'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_schedule_detail['customer_address'] ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_schedule_detail['customer_districts_name'] ?>
										</td>
									</tr>
								<?php
									$no++;
									}
								?>
								</tbody>
							</table>
                            </form>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
?>