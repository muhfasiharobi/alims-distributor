<?php
	function form_initial_sales_schedule()
	{
?>
		<div class="page-fixed-main-content">	 
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
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=sales-schedule&tib=form-add-sales-schedule-user">
									<i class="fa fa-plus"></i>
									Tambah
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<table class="table table-bordered table-checkable table-hover table-striped order-column" id="sample_2">
								<thead>
									<tr>
										<th width="20%">
										</th>
										<th width="3%">
											No
										</th>
										<th>
											Salesman
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_sales_schedule_user = mysql_query("SELECT * FROM sales_schedule_user a, user b WHERE a.salesman_id = b.user_id AND sales_schedule_user_active = '1' AND b.user_active = '1'");
									while ($data_tbl_sales_schedule_user = mysql_fetch_array($tbl_sales_schedule_user))
									{
										
								?>
									<tr class="odd gradeX">
										<td width="20%">
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=sales-schedule&tib=form-view-sales-schedule&salesman_id=<?php echo $data_tbl_sales_schedule_user['salesman_id'] ?>">
												<i class="fa fa-search"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_sales_schedule_id_<?php echo $data_tbl_sales_schedule_user['sales_schedule_user_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										</td>
										<td width="3%">
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_schedule_user['user_name'] ?>
										</td>
									</tr>
									<div aria-hidden="true" class="modal fade" id="delete_sales_schedule_id_<?php echo $data_tbl_sales_schedule_user['sales_schedule_user_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=sales-schedule&tib=delete-sales-schedule-user&sales_schedule_user_id=<?php echo $data_tbl_sales_schedule_user['sales_schedule_user_id'] ?>">
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
	function form_add_sales_schedule_user()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Jadwal Penjualan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=sales-schedule&tib=add-sales-schedule-user" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>
													Sales
													<span class="required">
														*
													</span>
												</label>
												<select class="form-control select2me" data-error-container="#customer_districts_id" data-placeholder="Sales" name="salesman_id">
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
	function form_view_sales_schedule()
	{
		$tbl_sales_schedule_user = mysql_query("SELECT b.user_name FROM sales_schedule_user a, user b WHERE a.salesman_id = b.user_id AND a.salesman_id = '".$_GET['salesman_id']."'");
		$data_tbl_sales_schedule_user = mysql_fetch_array($tbl_sales_schedule_user);
?>
		<div class="page-fixed-main-content">	
        	<div class="todo-main-header">
				<h3>
					<?php echo $data_tbl_sales_schedule_user['user_name'] ?>
				</h3>
			</div> 
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
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=sales-schedule&tib=form-add-sales-schedule&salesman_id=<?php echo $_GET['salesman_id'] ?>">
									<i class="fa fa-plus"></i>
									Tambah
								</a>
                                <a class="btn btn-outline btn-sm sbold yellow" href="?alimms=sales-schedule&tib=sales-shedule">
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
										</th>
										<th width="3%">
											No
										</th>
										<th>
											Hari
										</th>
                                        <th>
											Minggu Ke
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_sales_schedule = mysql_query("SELECT * FROM sales_schedule  WHERE salesman_id = '".$_GET['salesman_id']."' AND sales_schedule_active = '1' order by sales_schedule_week, sales_schedule_id");
									while ($data_tbl_sales_schedule = mysql_fetch_array($tbl_sales_schedule))
									{
										
								?>
									<tr class="odd gradeX">
										<td>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Lihat" href="?alimms=sales-schedule&tib=form-view-sales-schedule-entry&sales_schedule_id=<?php echo $data_tbl_sales_schedule['sales_schedule_id'] ?>">
												<i class="fa fa-search"></i>
											</a>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=sales-schedule&tib=form-edit-sales-schedule-entry&sales_schedule_id=<?php echo $data_tbl_sales_schedule['sales_schedule_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_sales_schedule_id_<?php echo $data_tbl_sales_schedule['sales_schedule_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										</td>
										<td width="3%">
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_sales_schedule['sales_schedule_day'] ?>
										</td>
                                        <td>
											<?php echo $data_tbl_sales_schedule['sales_schedule_week'] ?>
										</td>
									</tr>
									<div aria-hidden="true" class="modal fade" id="delete_sales_schedule_id_<?php echo $data_tbl_sales_schedule['sales_schedule_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=sales-schedule&tib=delete-sales-schedule&sales_schedule_id=<?php echo $data_tbl_sales_schedule['sales_schedule_id'] ?>">
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
	function form_add_sales_schedule()
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
									Jadwal Penjualan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=sales-schedule&tib=add-sales-schedule" class="horizontal-form" id="form_sample_3" method="post">
                            <input type="hidden" name="salesman_id" value="<?php echo $_GET['salesman_id'] ?>" />
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
												 <?php
                                                    $dayList = array(
                                                        '1' => 'Senin',
                                                        '2' => 'Selasa',
                                                        '3' => 'Rabu',
                                                        '4' => 'Kamis',
                                                        '5' => 'Jumat',
                                                        '6' => 'Sabtu'
                                                    );
													?>	
														<select class="form-control select2me" placeholder="Hari" name="sales_schedule_day" />
															<option value=""></option>
															<?php
                                                                for($a=1; $a <= count($dayList); $a++)
                                                                {
                                                            ?>
                                                                    <option value="<?php echo $dayList[$a] ?>"><?php echo $dayList[$a] ?></option>
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
												<?php
                                                    $weekList = array(
                                                        '1' => 'Minggu 1',
                                                        '2' => 'Minggu 2',
                                                        '3' => 'Minggu 3',
                                                        '4' => 'Minggu 4'
                                                    );
													?>	
														<select class="form-control select2me" placeholder="Minggu" name="sales_schedule_week" />
															<option value=""></option>
															<?php
                                                                for($b=1; $b <= count($weekList); $b++)
                                                                {
                                                            ?>
                                                                    <option value="<?php echo $b ?>"><?php echo $weekList[$b] ?></option>
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
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=sales-schedule'">
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
	function form_sales_schedule_entry()
	{
		$tbl_sales_schedule = mysql_query("SELECT * FROM sales_schedule a, user b WHERE a.sales_schedule_id = '".$_GET['sales_schedule_id']."' AND a.salesman_id = b.user_id");
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
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Jadwal Penjualan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=sales-schedule&tib=add-sales-schedule-entry" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="sales_schedule_id" type="hidden" value="<?php echo $data_tbl_sales_schedule['sales_schedule_id'] ?>">
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
															$tbl_sales_schedule_detail = mysql_query("SELECT b.customer_id FROM sales_schedule a, sales_schedule_detail b WHERE a.sales_schedule_date = '".$data_tbl_sales_schedule['sales_schedule_date']."' AND a.sales_schedule_active = '1' AND b.customer_id = '".$data_tbl_customer['customer_id']."' AND a.sales_schedule_id = b.sales_schedule_id");
															$jumlah_tbl_sales_schedule_detail = mysql_num_rows($tbl_sales_schedule_detail);
															
															if ($jumlah_tbl_sales_schedule_detail < 1)
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
										$tbl_sales_schedule_detail = mysql_query("SELECT sales_schedule_id FROM sales_schedule_detail WHERE sales_schedule_id = '".$data_tbl_sales_schedule['sales_schedule_id']."'");
										$jumlah_tbl_sales_schedule_detail = mysql_num_rows($tbl_sales_schedule_detail);
										
										if ($jumlah_tbl_sales_schedule_detail > 0)
										{
									?>
										<button type="button" class="btn btn-sm btn-outline green sbold" onclick="location.href='?alimms=sales-schedule&tib=form-view-sales-schedule&salesman_id=<?php echo $data_tbl_sales_schedule['salesman_id'] ?>'">
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
									$tbl_sales_schedule_detail = mysql_query("SELECT a.sales_schedule_detail_id, b.customer_id, b.customer_code, b.customer_name, b.customer_address, c.customer_category_name, d.customer_districts_name FROM sales_schedule_detail a, customer b, customer_category c, customer_districts d WHERE a.sales_schedule_id = '".$data_tbl_sales_schedule['sales_schedule_id']."' AND a.customer_id = b.customer_id AND b.customer_category_id = c.customer_category_id AND b.customer_districts_id = d.customer_districts_id ORDER BY a.sales_schedule_detail_id");
									while ($data_tbl_sales_schedule_detail = mysql_fetch_array($tbl_sales_schedule_detail))
									{
								?>
									<tr class="odd gradeX">
										<td>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#remove_sales_schedule_detail_id_<?php echo $data_tbl_sales_schedule_detail['sales_schedule_detail_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										</td>
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
									<div aria-hidden="true" class="modal fade" id="remove_sales_schedule_detail_id_<?php echo $data_tbl_sales_schedule_detail['sales_schedule_detail_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=sales-schedule&tib=remove-sales-schedule&sales_schedule_detail_id=<?php echo $data_tbl_sales_schedule_detail['sales_schedule_detail_id'] ?>">
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
	function form_edit_sales_schedule_entry()
	{
		$tbl_sales_schedule = mysql_query("SELECT * FROM sales_schedule a, user b WHERE a.sales_schedule_id = '".$_GET['sales_schedule_id']."' AND a.salesman_id = b.user_id");
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
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Jadwal Penjualan
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=sales-schedule&tib=add-sales-schedule-entry" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="sales_schedule_id" type="hidden" value="<?php echo $data_tbl_sales_schedule['sales_schedule_id'] ?>">
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
															$tbl_sales_schedule_detail = mysql_query("SELECT b.customer_id FROM sales_schedule a, sales_schedule_detail b WHERE a.sales_schedule_date = '".$data_tbl_sales_schedule['sales_schedule_date']."' AND a.sales_schedule_active = '1' AND b.customer_id = '".$data_tbl_customer['customer_id']."' AND a.sales_schedule_id = b.sales_schedule_id");
															$jumlah_tbl_sales_schedule_detail = mysql_num_rows($tbl_sales_schedule_detail);
															
															if ($jumlah_tbl_sales_schedule_detail < 1)
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
										$tbl_sales_schedule_detail = mysql_query("SELECT sales_schedule_id FROM sales_schedule_detail WHERE sales_schedule_id = '".$data_tbl_sales_schedule['sales_schedule_id']."'");
										$jumlah_tbl_sales_schedule_detail = mysql_num_rows($tbl_sales_schedule_detail);
										
										if ($jumlah_tbl_sales_schedule_detail > 0)
										{
									?>
										<button type="button" class="btn btn-sm btn-outline green sbold" onclick="location.href='?alimms=sales-schedule&tib=form-view-sales-schedule&salesman_id=<?php echo $data_tbl_sales_schedule['salesman_id'] ?>'">
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
									$tbl_sales_schedule_detail = mysql_query("SELECT a.sales_schedule_detail_id, b.customer_id, b.customer_code, b.customer_name, b.customer_address, c.customer_category_name, d.customer_districts_name FROM sales_schedule_detail a, customer b, customer_category c, customer_districts d WHERE a.sales_schedule_id = '".$data_tbl_sales_schedule['sales_schedule_id']."' AND a.customer_id = b.customer_id AND b.customer_category_id = c.customer_category_id AND b.customer_districts_id = d.customer_districts_id ORDER BY a.sales_schedule_no");
									while ($data_tbl_sales_schedule_detail = mysql_fetch_array($tbl_sales_schedule_detail))
									{
								?>
									<tr class="odd gradeX">
										<td>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#remove_sales_schedule_detail_id_<?php echo $data_tbl_sales_schedule_detail['sales_schedule_detail_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										</td>
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
									<div aria-hidden="true" class="modal fade" id="remove_sales_schedule_detail_id_<?php echo $data_tbl_sales_schedule_detail['sales_schedule_detail_id'] ?>" role="basic" tabindex="-1">
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
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=sales-schedule&tib=remove-sales-schedule&sales_schedule_detail_id=<?php echo $data_tbl_sales_schedule_detail['sales_schedule_detail_id'] ?>">
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
	function form_view_sales_schedule_entry()
	{
		$tbl_sales_schedule = mysql_query("SELECT * FROM sales_schedule a, user b WHERE a.sales_schedule_id = '".$_GET['sales_schedule_id']."' AND a.salesman_id = b.user_id");
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
								<a class="btn btn-outline btn-sm sbold yellow" href="?alimms=sales-schedule&tib=form-view-sales-shedule&tib=form-view-sales-schedule&salesman_id=<?php echo $data_tbl_sales_schedule['salesman_id'] ?>">
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
									$tbl_sales_schedule_detail = mysql_query("SELECT b.customer_id, b.customer_code, b.customer_name, b.customer_address, c.customer_category_name, d.customer_districts_name FROM sales_schedule_detail a, customer b, customer_category c, customer_districts d WHERE a.sales_schedule_id = '".$data_tbl_sales_schedule['sales_schedule_id']."' AND a.customer_id = b.customer_id AND b.customer_category_id = c.customer_category_id AND b.customer_districts_id = d.customer_districts_id ORDER BY a.sales_schedule_no");
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
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
	}
?>