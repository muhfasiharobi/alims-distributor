<?php
	function default_item_purchase_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-wallet font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Pembelian Barang
							</span>
						</div>
						<div class="actions">
							<div class="actions">
								<a class="btn blue btn-outline" href="?connect=item-purchase&execute=add-item-purchase-platform">
									<i class="icon-note"></i>
									Tambah
								</a>
							</div>
						</div>
					</div>
					<br><br><br>
					<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover order-column" id="sample_2">
							<thead>
								<tr>
									<th>
										No
									</th>
									<th>
										Tgl. Pembelian
									</th>
									<th>
										Tgl. Jatuh Tempo
									</th>
									<th>
										Kategori
									</th>
									<th>
										Pemasok
									</th>
									<?php
										$item_query = mysql_query("SELECT item_id, item_name FROM item WHERE item_active = '1' ORDER BY item_id");
										while ($item_fetch_array = mysql_fetch_array($item_query))
										{
									?>
											<th>
												<?php echo $item_fetch_array['item_name']; ?>
											</th>
									<?php
										}
									?>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$item_purchase_query = mysql_query("SELECT a.item_purchase_id, a.item_purchase_date, a.item_purchase_due_date, b.supplier_name, c.item_category_name FROM item_purchase a, supplier b, item_category c WHERE a.supplier_id = b.supplier_id AND a.item_category_id = c.item_category_id AND a.item_purchase_active = '1' AND b.supplier_active = '1' ORDER BY a.item_purchase_date DESC");
								while ($item_purchase_fetch_array = mysql_fetch_array($item_purchase_query))
								{
									$item_purchase_date = indonesia_datetime_format($item_purchase_fetch_array['item_purchase_date']);
									$item_purchase_due_date = indonesia_datetime_format($item_purchase_fetch_array['item_purchase_due_date']);
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $item_purchase_date; ?>
										</td>
										<td>
											<?php echo $item_purchase_due_date; ?>
										</td>
										<td>
											<?php echo $item_purchase_fetch_array['item_category_name']; ?>
										</td>
										<td>
											<?php echo $item_purchase_fetch_array['supplier_name']; ?>
										</td>
										<?php
											$item_query = mysql_query("SELECT item_id FROM item WHERE item_active = '1' ORDER BY item_id");
											while ($item_fetch_array = mysql_fetch_array($item_query))
											{
												$order_item_purchase_query = mysql_query("SELECT order_item_purchase_quantity, order_item_purchase_price FROM order_item_purchase WHERE item_purchase_id = '".$item_purchase_fetch_array['item_purchase_id']."' AND item_id = '".$item_fetch_array['item_id']."' AND order_item_purchase_active = '1'");
												$order_item_purchase_fetch_array = mysql_fetch_array($order_item_purchase_query);

												$order_item_purchase_price = currency_format($order_item_purchase_fetch_array['order_item_purchase_price']);
										?>
												<td>
													<?php echo $order_item_purchase_fetch_array['order_item_purchase_quantity']; ?>
												</td>
										<?php
											}
										?>
										<td>
											<a class="btn purple btn-outline" href="?connect=item-purchase&execute=edit-item-purchase-platform&item_purchase_id=<?php echo $item_purchase_fetch_array['item_purchase_id']; ?>">
												<i class="icon-pencil"></i>
												Ubah
											</a>
											<a class="btn red btn-outline" data-target="#delete_item_purchase_id_<?php echo $item_purchase_fetch_array['item_purchase_id']; ?>" data-toggle="modal">
												<i class="icon-trash"></i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_item_purchase_id_<?php echo $item_purchase_fetch_array['item_purchase_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=item-purchase&execute=delete-item-purchase&item_purchase_id=<?php echo $item_purchase_fetch_array['item_purchase_id']; ?>'" type="button">
												<i class="icon-check"></i>
												Simpan
											</button>
											<button class="btn red btn-outline" data-dismiss="modal" type="button">
												<i class="icon-close"></i>
												Batal
											</button>
										</div>
									</div>
							<?php
								$number++;
								}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	function add_item_purchase_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-wallet font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Pembelian Barang
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=item-purchase&execute=add-item-purchase" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Tgl. Pembelian
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="item_purchase_date" placeholder="Tgl. Pembelian" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Tgl. Jatuh Tempo
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="item_purchase_due_date" placeholder="Tgl. Jatuh Tempo" type="text">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kategori
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#item_category_id" data-placeholder="Kategori" name="item_category_id">
											<?php
												$item_category_query = mysql_query("SELECT item_category_id, item_category_name FROM item_category WHERE item_category_active = '1' ORDER BY item_category_name");
												while ($item_category_fetch_array = mysql_fetch_array($item_category_query))
												{
											?>
													<option value=""></option>
													<option value="<?php echo $item_category_fetch_array['item_category_id']; ?>"><?php echo $item_category_fetch_array['item_category_name']; ?></option>
											<?php
												}
											?>
											</select>
											<div id="item_category_id"></div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Pemasok
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#supplier_id" data-placeholder="Pemasok" name="supplier_id">
											<?php
												$supplier_query = mysql_query("SELECT supplier_id, supplier_name FROM supplier WHERE supplier_active = '1' ORDER BY supplier_name");
												while ($supplier_fetch_array = mysql_fetch_array($supplier_query))
												{
											?>
													<option value=""></option>
													<option value="<?php echo $supplier_fetch_array['supplier_id']; ?>"><?php echo $supplier_fetch_array['supplier_name']; ?></option>
											<?php
												}
											?>
											</select>
											<div id="supplier_id"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions right">
								<button class="btn yellow btn-outline" type="submit">
									<i class="icon-action-redo"></i>
									Proses
								</button>
								&nbsp;
								<button class="btn red btn-outline" onclick="history.back()" type="button">
									<i class="icon-close"></i>
									Batal
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	function order_item_purchase_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-wallet font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Pembelian Barang
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=item-purchase&execute=order-item-purchase" class="horizontal-form" id="form_sample_3" method="post">
						<?php
							$item_purchase_query = mysql_query("SELECT a.item_purchase_id, a.item_purchase_date, a.item_purchase_due_date, b.item_category_id, b.item_category_name, c.supplier_name FROM item_purchase a, item_category b, supplier c WHERE a.item_purchase_id = '".$_GET['item_purchase_id']."' AND a.item_category_id = b.item_category_id AND a.supplier_id = c.supplier_id");
							$item_purchase_fetch_array = mysql_fetch_array($item_purchase_query);

							$item_purchase_date = indonesia_datetime_format($item_purchase_fetch_array['item_purchase_date']);
							$item_purchase_due_date = indonesia_datetime_format($item_purchase_fetch_array['item_purchase_due_date']);
						?>
							<input class="form-control" name="item_purchase_id" type="hidden" value="<?php echo $item_purchase_fetch_array['item_purchase_id']; ?>">
							<div class="form-body">
								<h4 class="form-section">
									Informasi Pemasok
								</h4>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Tgl. Pembelian
											</label>
											<input class="form-control" disabled type="text" value="<?php echo $item_purchase_date; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Tgl. Jatuh Tempo
											</label>
											<input class="form-control" disabled type="text" value="<?php echo $item_purchase_due_date; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kategori
											</label>
											<input class="form-control" disabled type="text" value="<?php echo $item_purchase_fetch_array['item_category_name']; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Pemasok
											</label>
											<input class="form-control" disabled type="text" value="<?php echo $item_purchase_fetch_array['supplier_name']; ?>">
										</div>
									</div>
								</div>
								<h4 class="form-section">
									Informasi Pembelian
								</h4>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Barang
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#item_id" data-placeholder="Barang" name="item_id">
											<?php
												$item_query = mysql_query("SELECT a.item_id, a.item_name FROM item a, item_category b WHERE a.item_category_id = '".$item_purchase_fetch_array['item_category_id']."' AND a.item_category_id = b.item_category_id AND a.item_active = '1' AND b.item_category_active = '1' ORDER BY a.item_name");
												while ($item_fetch_array = mysql_fetch_array($item_query))
												{
													$order_item_purchase_query = mysql_query("SELECT order_item_purchase_id FROM order_item_purchase WHERE item_purchase_id = '".$item_purchase_fetch_array['item_purchase_id']."' AND item_id = '".$item_fetch_array['item_id']."' AND order_item_purchase_active = '1'");
													$order_item_purchase_num_rows = mysql_num_rows($order_item_purchase_query);

													if ($order_item_purchase_num_rows < 1)
													{
											?>
														<option value=""></option>
														<option value="<?php echo $item_fetch_array['item_id']; ?>"><?php echo $item_fetch_array['item_name']; ?></option>
											<?php
													}
												}
											?>
											</select>
											<div id="item_id"></div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Jumlah
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="order_item_purchase_quantity" placeholder="Jumlah" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Harga Beli
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="order_item_purchase_price" placeholder="Harga Beli" type="text">
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions right">
								<button class="btn blue btn-outline" type="submit">
									<i class="icon-check"></i>
									Tambah
								</button>
								&nbsp;
								<a class="btn red btn-outline" data-target="#delete_item_purchase_id_<?php echo $item_purchase_fetch_array['item_purchase_id']; ?>" data-toggle="modal">
									<i class="icon-close"></i>
									Batal
								</a>
								<?php
									$order_item_purchase_query = mysql_query("SELECT item_purchase_id FROM order_item_purchase WHERE item_purchase_id = '".$item_purchase_fetch_array['item_purchase_id']."' AND order_item_purchase_active = '1'");
									$order_item_purchase_num_rows = mysql_num_rows($order_item_purchase_query);

									if ($order_item_purchase_num_rows > 0)
									{
								?>
										&nbsp;
										<button class="btn green btn-outline" onclick="location.href='?connect=item-purchase'" type="button">
											<i class="icon-logout"></i>
											Selesai
										</button> 
								<?php
									}
									else
									{
									}
								?>
							</div>
							<div class="modal fade" data-backdrop="static" id="delete_item_purchase_id_<?php echo $item_purchase_fetch_array['item_purchase_id']; ?>">
								<div class="modal-body">
									<p>
										Apakah Anda Ingin Membatalkan Data Ini ?
									</p>
								</div>
								<div class="modal-footer">
									<button class="btn blue btn-outline" onclick="location.href='?connect=item-purchase&execute=cancel-order-item-purchase&item_purchase_id=<?php echo $item_purchase_fetch_array['item_purchase_id']; ?>'" type="button">
										<i class="icon-check"></i>
										Simpan
									</button>
									<button class="btn red btn-outline" data-dismiss="modal" type="button">
										<i class="icon-close"></i>
										Batal
									</button>
								</div>
							</div>
						</form>
					</div>
					<br><br><br>
					<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover order-column" id="sample_2">
							<thead>
								<tr>
									<th>
										No
									</th>
									<th>
										Barang
									</th>
									<th>
										Jumlah
									</th>
									<th>
										Harga Beli
									</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$order_item_purchase_query = mysql_query("SELECT a.order_item_purchase_id, a.item_purchase_id, a.order_item_purchase_quantity, a.order_item_purchase_price, b.item_name FROM order_item_purchase a, item b WHERE a.item_purchase_id = '".$item_purchase_fetch_array['item_purchase_id']."' AND a.item_id = b.item_id AND a.order_item_purchase_active = '1' AND b.item_active = '1' ORDER BY a.order_item_purchase_id DESC");
								while ($order_item_purchase_fetch_array = mysql_fetch_array($order_item_purchase_query))
								{
									$order_item_purchase_price = currency_format($order_item_purchase_fetch_array['order_item_purchase_price']);
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $order_item_purchase_fetch_array['item_name']; ?>
										</td>
										<td>
											<?php echo $order_item_purchase_fetch_array['order_item_purchase_quantity']; ?>
										</td>
										<td>
											<?php echo $order_item_purchase_price; ?>
										</td>
										<td>
											<a class="btn red btn-outline" data-target="#delete_order_item_purchase_id_<?php echo $order_item_purchase_fetch_array['order_item_purchase_id']; ?>" data-toggle="modal">
												<i class="icon-trash"></i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_order_item_purchase_id_<?php echo $order_item_purchase_fetch_array['order_item_purchase_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=item-purchase&execute=delete-order-item-purchase&order_item_purchase_id=<?php echo $order_item_purchase_fetch_array['order_item_purchase_id']; ?>&item_purchase_id=<?php echo $order_item_purchase_fetch_array['item_purchase_id']; ?>'" type="button">
												<i class="icon-check"></i>
												Simpan
											</button>
											<button class="btn red btn-outline" data-dismiss="modal" type="button">
												<i class="icon-close"></i>
												Batal
											</button>
										</div>
									</div>
							<?php
								$number++;
								}
							?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
<?php
	}
	function edit_item_purchase_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-wallet font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Pembelian Barang
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=item-purchase&execute=edit-item-purchase" class="horizontal-form" id="form_sample_3" method="post">
						<?php
							$item_purchase_query = mysql_query("SELECT item_purchase_id, item_purchase_date, item_purchase_due_date, item_category_id, supplier_id FROM item_purchase WHERE item_purchase_id = '".$_GET['item_purchase_id']."'");
							$item_purchase_fetch_array = mysql_fetch_array($item_purchase_query);

							$item_purchase_date = explode("-", $item_purchase_fetch_array['item_purchase_date']);
							$date = $item_purchase_date[2];
							$month = $item_purchase_date[1];
							$year = $item_purchase_date[0];
							$item_purchase_date = date("d-m-Y", mktime(0, 0, 0, $month, $date, $year));

							$item_purchase_due_date = explode("-", $item_purchase_fetch_array['item_purchase_due_date']);
							$date = $item_purchase_due_date[2];
							$month = $item_purchase_due_date[1];
							$year = $item_purchase_due_date[0];
							$item_purchase_due_date = date("d-m-Y", mktime(0, 0, 0, $month, $date, $year));
						?>
							<input class="form-control" name="item_purchase_id" type="hidden" value="<?php echo $item_purchase_fetch_array['item_purchase_id']; ?>">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Tgl. Pembelian
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="item_purchase_date" placeholder="Tgl. Pembelian" type="text" value="<?php echo $item_purchase_date; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Tgl. Jatuh Tempo
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="item_purchase_due_date" placeholder="Tgl. Jatuh Tempo" type="text" value="<?php echo $item_purchase_due_date; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kategori
											</label>
											<select class="form-control select2me" data-error-container="#item_category_id" data-placeholder="Kategori" disabled name="item_category_id">
											<?php
												$item_category_query = mysql_query("SELECT item_category_id, item_category_name FROM item_category WHERE item_category_active = '1' ORDER BY item_category_name");
												while ($item_category_fetch_array = mysql_fetch_array($item_category_query))
												{
											?>
													<option value=""></option>
													<option <?php if ($item_category_fetch_array['item_category_id'] == $item_purchase_fetch_array['item_category_id']) { ?> selected="selected" <?php } ?> value="<?php echo $item_category_fetch_array['item_category_id']; ?>"><?php echo $item_category_fetch_array['item_category_name']; ?></option>
											<?php
												}
											?>
											</select>
											<div id="item_category_id"></div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Pemasok
											</label>
											<select class="form-control select2me" data-error-container="#supplier_id" data-placeholder="Pemasok" name="supplier_id">
											<?php
												$supplier_query = mysql_query("SELECT supplier_id, supplier_name FROM supplier WHERE supplier_active = '1' ORDER BY supplier_name");
												while ($supplier_fetch_array = mysql_fetch_array($supplier_query))
												{
											?>
													<option value=""> </option>
													<option <?php if ($supplier_fetch_array['supplier_id'] == $item_purchase_fetch_array['supplier_id']) { ?> selected="selected" <?php } ?> value="<?php echo $supplier_fetch_array['supplier_id']; ?>"><?php echo $supplier_fetch_array['supplier_name']; ?></option>
											<?php
												}
											?>
											</select>
											<div id="supplier_id"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions right">
								<button class="btn purple btn-outline" type="submit">
									<i class="icon-action-redo"></i>
									Proses
								</button>
								&nbsp;
								<button class="btn red btn-outline" onclick="history.back()" type="button">
									<i class="icon-close"></i>
									Batal
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
<?php
	}
?>