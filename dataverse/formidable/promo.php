<?php
	function default_promo_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-present font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Promo
							</span>
						</div>
						<div class="actions">
							<div class="actions">
								<a class="btn blue btn-outline" href="?connect=promo&execute=add-promo-platform">
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
										Nama Promo
									</th>
									<th>
										Diskon
									</th>
									<th>
										Mulai tanggal
									</th>
									<th>
										Sampai Tanggal
									</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$promo_query = mysql_query("SELECT * FROM promo WHERE promo_active = '1'");
								while ($promo_fetch_array = mysql_fetch_array($promo_query))
								{
									
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $promo_fetch_array['promo_name'] ?>
										</td>
										<td>
											<?php
												if($promo_fetch_array['kategori_promo'] == "nominal")
												{
											?>
													Rp <?php echo currency_format($promo_fetch_array['promo_value']) ?>
											<?php
												}
												else
												{
											?>
													<?php echo $promo_fetch_array['promo_value'] ?> %
											<?php
												}
											?>
											
										</td>
										<td>
											<?php echo indonesia_date_format($promo_fetch_array['promo_from_date']) ?>
										</td>
										<td>
											<?php echo indonesia_date_format($promo_fetch_array['promo_to_date']) ?>
										</td>
										<td>
											<a class="btn purple btn-outline" href="?connect=promo&execute=edit-promo-platform&promo_id=<?php echo $promo_fetch_array['promo_id']; ?>">
												<i class="icon-pencil"></i>
												Ubah
											</a>
											<a class="btn red btn-outline" data-target="#delete_promo_id_<?php echo $promo_fetch_array['promo_id']; ?>" data-toggle="modal">
												<i class="icon-trash"></i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_promo_id_<?php echo $promo_fetch_array['promo_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=promo&execute=delete-promo&promo_id=<?php echo $promo_fetch_array['promo_id']; ?>'" type="button">
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
	function add_promo_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-present font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Promo
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=promo&execute=add-promo" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Mulai Tanggal
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="from_date" placeholder="Mulai Tanggal" type="text">
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
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="to_date" placeholder="Sampai Tanggal" type="text">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Nama Promo
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="promo_name" placeholder="Nama Promo" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Kategori Promo
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control" name="kategori_promo">
												<option value="prosentase">Prosentase</option>
												<option value="nominal">Nominal</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Jumlah Diskon
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="promo_value" placeholder="Diskon" type="text">
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions right">
								<button class="btn blue btn-outline" type="submit">
									<i class="icon-check"></i>
									Simpan
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
	function add_item_promo_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-basket font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Promo
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=item-selling&execute=order-item-selling" class="horizontal-form" id="form_sample_3" method="post">
						<?php
							$promo_query = mysql_query("SELECT * FROM promo WHERE promo_id = '".$_GET['promo_id']."'");
							$promo_fetch_array = mysql_fetch_array($promo_query);

							$promo_from_date = explode("-", $promo_fetch_array['promo_from_date']);
							$date = $promo_from_date[2];
							$month = $promo_from_date[1];
							$year = $promo_from_date[0];
							$promo_from_date = date("d-m-Y", mktime(0, 0, 0, $month, $date, $year));

							$promo_to_date = explode("-", $promo_fetch_array['promo_to_date']);
							$date = $promo_to_date[2];
							$month = $promo_to_date[1];
							$year = $promo_to_date[0];
							$promo_to_date = date("d-m-Y", mktime(0, 0, 0, $month, $date, $year));

						?>
							<input class="form-control" name="item_selling_id" type="hidden" value="<?php echo $item_selling_fetch_array['item_selling_id']; ?>">
							<input class="form-control" name="reseller_id" type="hidden" value="<?php echo $item_selling_fetch_array['reseller_id']; ?>">
							<div class="form-body">
								<h4 class="form-section">
									Informasi Promo
								</h4>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Nama Promo
											</label>
											<input class="form-control" disabled type="text" value="<?php echo $promo_fetch_array['promo_name']; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Mulai Tanggal
											</label>
											<input class="form-control" disabled type="text" value="<?php echo $promo_from_date; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Sampai Tanggal
											</label>
											<input class="form-control" disabled type="text" value="<?php echo $promo_to_date; ?>">
										</div>
									</div>
								</div>
								<h4 class="form-section">
									Informasi Penjualan
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
												<select class="form-control select2me" data-error-container="#item_id" data-placeholder="Barang" name="item_id" onchange="changeValue(this.value)">
													<?php
														$item_query = mysql_query("SELECT item_id, item_name FROM item WHERE item_active = '1'");
														while ($item_fetch_array = mysql_fetch_array($item_query))
														{	
															
													?>
																<option value=""></option>
																<option value="<?php echo $item_fetch_array['item_id']; ?>"><?php echo $item_fetch_array['item_name']; ?></option>
													<?php
															
														}
													?>
												</select>
												
											<div id="item_id"></div>
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
											<input autocomplete="off" class="form-control" name="order_item_selling_quantity" placeholder="Jumlah" type="text">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Harga
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="item_price_value" placeholder="Harga" type="text">
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
								<a class="btn red btn-outline" data-target="#delete_item_selling_id_<?php echo $item_selling_fetch_array['item_selling_id']; ?>" data-toggle="modal">
									<i class="icon-close"></i>
									Batal
								</a>
								<?php
									$order_item_selling_query = mysql_query("SELECT item_selling_id FROM order_item_selling WHERE item_selling_id = '".$item_selling_fetch_array['item_selling_id']."' AND order_item_selling_active = '1'");
									$order_item_selling_num_rows = mysql_num_rows($order_item_selling_query);

									if ($order_item_selling_num_rows > 0)
									{
								?>
										&nbsp;
										<button class="btn green btn-outline" onclick="location.href='?connect=item-selling'" type="button">
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
							<div class="modal fade" data-backdrop="static" id="delete_item_selling_id_<?php echo $item_selling_fetch_array['item_selling_id']; ?>">
								<div class="modal-body">
									<p>
										Apakah Anda Ingin Membatalkan Data Ini ?
									</p>
								</div>
								<div class="modal-footer">
									<button class="btn blue btn-outline" onclick="location.href='?connect=item-selling&execute=cancel-order-item-selling&item_selling_id=<?php echo $item_selling_fetch_array['item_selling_id']; ?>'" type="button">
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
										Harga Jual
									</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$order_item_selling_query = mysql_query("SELECT * FROM order_item_selling a, item b WHERE a.item_selling_id = '".$item_selling_fetch_array['item_selling_id']."' AND a.item_id = b.item_id AND a.order_item_selling_active = '1' AND b.item_active = '1' ORDER BY a.order_item_selling_id");
								while ($order_item_selling_fetch_array = mysql_fetch_array($order_item_selling_query))
								{
									$item_price_value = currency_format($order_item_selling_fetch_array['item_price_value']);
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $order_item_selling_fetch_array['item_name']; ?>
										</td>
										<td>
											<?php echo $order_item_selling_fetch_array['order_item_selling_quantity']; ?>
										</td>
										<td>
											<?php echo $item_price_value; ?>
										</td>
										<td>
											<a class="btn red btn-outline" data-target="#delete_order_item_selling_id_<?php echo $order_item_selling_fetch_array['order_item_selling_id']; ?>" data-toggle="modal">
												<i class="icon-trash"></i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_order_item_selling_id_<?php echo $order_item_selling_fetch_array['order_item_selling_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=item-selling&execute=delete-order-item-selling&order_item_selling_id=<?php echo $order_item_selling_fetch_array['order_item_selling_id']; ?>&item_selling_id=<?php echo $order_item_selling_fetch_array['item_selling_id']; ?>'" type="button">
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
	function edit_promo_platform()
	{
		$promo_fetch_array = mysql_fetch_array(mysql_query("SELECT * FROM promo WHERE promo_id = '".$_GET['promo_id']."'"));

		$promo_from_date = explode("-", $promo_fetch_array['promo_from_date']);
		$date = $promo_from_date[2];
		$month = $promo_from_date[1];
		$year = $promo_from_date[0];
		$promo_from_date = date("d-m-Y", mktime(0, 0, 0, $month, $date, $year));

		$promo_to_date = explode("-", $promo_fetch_array['promo_to_date']);
		$date = $promo_to_date[2];
		$month = $promo_to_date[1];
		$year = $promo_to_date[0];
		$promo_to_date = date("d-m-Y", mktime(0, 0, 0, $month, $date, $year));
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-present font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Promo
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=promo&execute=edit-promo" class="horizontal-form" id="form_sample_3" method="post">
							<input type="hidden" name="promo_id" value="<?php echo $promo_fetch_array['promo_id'] ?>">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Nama Promo
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="promo_name" placeholder="Nama Promo" type="text" value="<?php echo $promo_fetch_array['promo_name'] ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Diskon (%)
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="promo_value" placeholder="Diskon" type="text" value="<?php echo $promo_fetch_array['promo_value'] ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Mulai Tanggal
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="from_date" placeholder="Mulai Tanggal" type="text" value="<?php echo $promo_from_date ?>">
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
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="to_date" placeholder="Sampai Tanggal" type="text" value="<?php echo $promo_to_date ?>">
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions right">
								<button class="btn blue btn-outline" type="submit">
									<i class="icon-check"></i>
									Simpan
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