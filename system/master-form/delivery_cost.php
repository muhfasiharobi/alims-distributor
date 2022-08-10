<?php
	function form_initial_delivery_cost()
	{
?>
		<div class="page-fixed-main-content">	 
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Biaya Pengiriman
								</span>
							</div>
							<div class="actions">
								<a class="blue btn btn-outline btn-sm sbold" href="?alimms=delivery-cost&tib=form-add-delivery-cost">
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
											Kota/ Kabupaten
										</th>
										<th>
											Biaya
										</th>
										<th>
											Status
										</th>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									$tbl_delivery_cost = mysql_query("SELECT a.delivery_cost_id, a.delivery_cost_price, a.delivery_cost_active, b.customer_city_name FROM delivery_cost a, customer_city b WHERE b.customer_city_active = '1' AND a.customer_city_id = b.customer_city_id ORDER BY b.customer_city_name");
									while ($data_tbl_delivery_cost = mysql_fetch_array($tbl_delivery_cost))
									{
										$delivery_cost_price_indo = format_angka($data_tbl_delivery_cost['delivery_cost_price']);
								?>
									<tr class="odd gradeX">
										<td>
										<?php
											if ($data_tbl_delivery_cost['delivery_cost_active'] == 1)
											{
										?>
											<a class="btn btn-icon-only btn-outline green tooltips" data-original-title="Ubah" href="?alimms=delivery-cost&tib=form-edit-delivery-cost&delivery_cost_id=<?php echo $data_tbl_delivery_cost['delivery_cost_id'] ?>">
												<i class="fa fa-pencil"></i>
											</a>
											<a class="btn btn-icon-only btn-outline red tooltips" data-original-title="Hapus" data-toggle="modal" href="#delete_delivery_cost_id_<?php echo $data_tbl_delivery_cost['delivery_cost_id'] ?>">
												<i class="fa fa-trash"></i>
											</a>
										<?php
											}
											else
											{
										?>
											<a class="btn btn-icon-only btn-outline dark tooltips" data-original-title="Aktif" data-toggle="modal" href="#active_delivery_cost_id_<?php echo $data_tbl_delivery_cost['delivery_cost_id'] ?>">
												<i class="fa fa-exchange"></i>
											</a>
										<?php
											}
										?>
										</td>
										<td>
											<?php echo $no ?>
										</td>
										<td>
											<?php echo $data_tbl_delivery_cost['customer_city_name'] ?>
										</td>
										<td>
											<?php echo $delivery_cost_price_indo ?>
										</td>
										<td>
										<?php
											if ($data_tbl_delivery_cost['delivery_cost_active'] == 1)
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
									<div aria-hidden="true" class="fade modal" id="delete_delivery_cost_id_<?php echo $data_tbl_delivery_cost['delivery_cost_id'] ?>" role="basic" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" class="close" data-dismiss="modal" type="button"></button>
                                                    <h4 class="modal-title">
														Konfirmasi
													</h4>
                                                </div>
                                                <div class="modal-body">
													Apakah Anda Yakin Ingin Menghapus Data Ini ?
												</div>
                                                <div class="modal-footer">
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=delivery-cost&tib=delete-delivery-cost&delivery_cost_id=<?php echo $data_tbl_delivery_cost['delivery_cost_id'] ?>">
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
									<div aria-hidden="true" class="fade modal" id="active_delivery_cost_id_<?php echo $data_tbl_delivery_cost['delivery_cost_id'] ?>" role="basic" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button aria-hidden="true" class="close" data-dismiss="modal" type="button"></button>
                                                    <h4 class="modal-title">
														Konfirmasi
													</h4>
                                                </div>
                                                <div class="modal-body">
													Apakah Anda Yakin Ingin Mengaktifkan Data Ini ?
												</div>
                                                <div class="modal-footer">
													<a class="btn btn-outline btn-sm green sbold" href="?alimms=delivery-cost&tib=active-delivery-cost&delivery_cost_id=<?php echo $data_tbl_delivery_cost['delivery_cost_id'] ?>">
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
	function form_add_delivery_cost()
	{
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Biaya Pengiriman
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=delivery-cost&tib=add-delivery-cost" class="horizontal-form" id="form_sample_3" method="post">
								<div class="form-body">
									<h4 class="form-section">
										Biaya Pengiriman
									</h4>
									<div class="row">
										<div class="col-md-6">
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
														$tbl_customer_city = mysql_query("SELECT customer_city_id, customer_city_name FROM customer_city WHERE customer_city_active = '1' ORDER BY customer_city_name");
														while($data_tbl_customer_city = mysql_fetch_array($tbl_customer_city))
														{
															$tbl_delivery_cost = mysql_query("SELECT customer_city_id FROM delivery_cost WHERE customer_city_id = '".$data_tbl_customer_city['customer_city_id']."' AND delivery_cost_active = '1'");
															$jumlah_tbl_delivery_cost = mysql_num_rows($tbl_delivery_cost);

															if ($jumlah_tbl_delivery_cost < 1)
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
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Biaya
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="delivery_cost_price" placeholder="Biaya" type="text">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=delivery-cost'">
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
	function form_edit_delivery_cost()
	{
		$tbl_delivery_cost = mysql_query("SELECT delivery_cost_id, customer_city_id, delivery_cost_price FROM delivery_cost WHERE delivery_cost_id = '".$_GET['delivery_cost_id']."'");
		$data_tbl_delivery_cost = mysql_fetch_array($tbl_delivery_cost);
?>
		<div class="page-fixed-main-content">
			<div class="row">
				<div class="col-md-12">
					<div class="bordered light portlet">
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-blue sbold uppercase">
									Biaya Pengiriman
								</span>
							</div>
						</div>
						<div class="form portlet-body">
							<form action="?alimms=delivery-cost&tib=edit-delivery-cost" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="delivery_cost_id" type="hidden" value="<?php echo $data_tbl_delivery_cost['delivery_cost_id'] ?>">
								<div class="form-body">
									<h4 class="form-section">
										Biaya Pengiriman
									</h4>
									<div class="row">
										<div class="col-md-6">
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
														$tbl_customer_city = mysql_query("SELECT customer_city_id, customer_city_name FROM customer_city WHERE customer_city_active = '1' ORDER BY customer_city_name");
														while($data_tbl_customer_city = mysql_fetch_array($tbl_customer_city))
														{	
															$tbl_delivery_cost = mysql_query("SELECT customer_city_id, delivery_cost_id FROM delivery_cost WHERE customer_city_id = '".$data_tbl_customer_city['customer_city_id']."' AND delivery_cost_active = '1'");
															$jumlah_tbl_delivery_cost = mysql_num_rows($tbl_delivery_cost);
															
															$tbl_delivery_cost_selected = mysql_query("SELECT customer_city_id FROM delivery_cost WHERE customer_city_id = '".$data_tbl_customer_city['customer_city_id']."' AND delivery_cost_active = '1' AND delivery_cost_id = '".$_GET['delivery_cost_id']."'");
															$data_tbl_delivery_cost_selected = mysql_fetch_array($tbl_delivery_cost_selected);
															
															if ($jumlah_tbl_delivery_cost > 0)
															{
																if ($data_tbl_customer_city['customer_city_id'] == $data_tbl_delivery_cost_selected['customer_city_id'])
																{
													?>
															<option selected="selected" value="<?php echo $data_tbl_customer_city['customer_city_id'] ?>"><?php echo $data_tbl_customer_city['customer_city_name'] ?></option>
													<?php
																}
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
										<div class="col-md-6">
											<div class="form-group">
												<label>
													Biaya
													<span class="required">
														*
													</span>
												</label>
												<input class="form-control" name="delivery_cost_price" placeholder="Biaya" type="text" value="<?php echo $data_tbl_delivery_cost['delivery_cost_price'] ?>">
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="submit" class="btn btn-sm btn-outline green sbold">
										<i class="fa fa-check"></i>
										Simpan
									</button>
									<button type="button" class="btn btn-sm btn-outline red sbold" onclick="location.href='?alimms=delivery-cost'">
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