<?php
	function default_reseller_item_sell_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-layers font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Produk Jual Agen
							</span>
						</div>
					</div>
					<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover order-column" id="sample_2">
							<thead>
								<tr>
									<th>
										No
									</th>
									<th>
										Kode
									</th>
									<th>
										Agen
									</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;

								if($_SESSION['user_category_name'] == "Administrator")
								{
									$reseller_query = mysql_query("SELECT * FROM reseller WHERE reseller_active = '1'");
								}
								else
								{
									$reseller_query = mysql_query("SELECT * FROM reseller a, user b WHERE a.user_id = b.user_id AND b.item_category_id = '".$_SESSION['item_category_id']."' AND a.reseller_active = '1'");
								}
								
								while($reseller_fetch_array = mysql_fetch_array($reseller_query))
								{
									if($reseller_fetch_array['reseller_code'] == "Admin Penjualan")
									{
									}
									else
									{
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $reseller_fetch_array['reseller_code']; ?>
										</td>
										<td>
											<?php echo $reseller_fetch_array['reseller_name']; ?>
										</td>
										<td>
											<a class="btn blue btn-outline" href="?connect=reseller-item-sell&execute=add-reseller-item-sell-platform&reseller_id=<?php echo $reseller_fetch_array['reseller_id']; ?>">
												<i class="icon-note"></i>
													Detail
											</a>
										</td>
									</tr>
							<?php

								$number++;
									}
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
	function add_reseller_item_sell_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-layers font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Produk Jual Agen
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=reseller-item-sell&execute=add-reseller-item-sell" class="horizontal-form" id="form_sample_3" method="post">
							<input class="form-control" name="reseller_id" type="hidden" value="<?php echo $_GET['reseller_id']; ?>">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Barang
											</label>
											<select class="form-control" name="item_id" id="item_id">
												<?php
												if($_SESSION['user_category_name'] == "Administrator")
												{
													$item = mysql_query("SELECT * FROM item WHERE item_active = '1'");
												}
												else
												{
													$item = mysql_query("SELECT * FROM reseller_item_sell a, reseller b, user c, item d WHERE a.reseller_id = b.reseller_id AND b.user_id = c.user_id AND c.user_id = '".$_SESSION['user_id']."' AND a.item_id = d.item_id AND a.reseller_item_sell_active = '1' AND d.item_active = '1'");
												}
													
													while($data_item = mysql_fetch_array($item))
													{
												?>
														<option value="<?php echo $data_item['item_id'] ?>"><?php echo $data_item['item_name'] ?></option>
												<?php
													}
												?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Harga Jual
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="item_price_value" placeholder="Harga Jual" type="text">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Komisi
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="item_commission_value" placeholder="Komisi" type="text">
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
								<button class="btn green btn-outline" onclick="location.href='?connect=reseller-item-sell'" type="button">
									<i class="icon-logout"></i>
									Selesai
								</button>
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
										Produk
									</th>
									<th>
										Harga Jual
									</th>
									<th>
										Komisi
									</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$reseller_item_sell_query = mysql_query("SELECT * FROM reseller_item_sell a, item b WHERE a.item_id = b.item_id AND a.reseller_id = '".$_GET['reseller_id']."' AND a.reseller_item_sell_active = '1'");
								while ($reseller_item_sell_fetch_array = mysql_fetch_array($reseller_item_sell_query))
								{
									$item_price = mysql_fetch_array(mysql_query("SELECT * FROM item_price WHERE item_price_id = '".$reseller_item_sell_fetch_array['item_price_id']."'"));
									
									$item_commission = mysql_fetch_array(mysql_query("SELECT * FROM item_commission WHERE item_commission_id = '".$reseller_item_sell_fetch_array['item_commission_id']."'"));
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $reseller_item_sell_fetch_array['item_name']; ?>
										</td>
										<td>
											<?php echo currency_format($item_price['item_price_value']); ?>
										</td>
										<td>
											<?php echo currency_format($item_commission['item_commission_value']); ?>
										</td>
										<td>
											<a class="btn red btn-outline" href="?connect=reseller-item-sell&execute=delete-reseller-item-sell&reseller_item_sell_id=<?php echo $reseller_item_sell_fetch_array['reseller_item_sell_id']; ?>&reseller_id=<?php echo $reseller_item_sell_fetch_array['reseller_id']; ?>">
												<i class="icon-trash"></i>
													Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_item_price_id_<?php echo $item_price_fetch_array['item_price_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=item-price&execute=delete-item-price&item_price_id=<?php echo $item_price_fetch_array['item_price_id']; ?>&item_id=<?php echo $item_fetch_array['item_id']; ?>'" type="button">
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
	function history_reseller_item_sell_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-layers font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Harga Barang
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=item-price&execute=add-item-price" class="horizontal-form" id="form_sample_3" method="post">
						<?php
							$item_query = mysql_query("SELECT item_id, item_name FROM item WHERE item_id = '".$_GET['item_id']."'");
							$item_fetch_array = mysql_fetch_array($item_query);
						?>
							<input class="form-control" name="item_id" type="hidden" value="<?php echo $item_fetch_array['item_id']; ?>">
							<div class="form-body">
								<h4 class="form-section">
									Informasi Barang
								</h4>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Barang
											</label>
											<input class="form-control" disabled type="text" value="<?php echo $item_fetch_array['item_name']; ?>">
										</div>
									</div>
								</div>
								<h4 class="form-section">
									Informasi Harga
								</h4>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Tgl. Harga Jual
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="item_price_date" placeholder="Tgl. Harga Jual" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Harga Jual
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="item_price_value" placeholder="Harga Jual" type="text">
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
								<button class="btn green btn-outline" onclick="location.href='?connect=item-price'" type="button">
									<i class="icon-logout"></i>
									Selesai
								</button>
							</div>
						</form>
					</div>
					<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover order-column" id="sample_1">
							<thead>
								<tr>
									<th>
										No
									</th>
									<th>
										Tgl. Harga Jual
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
								$item_price_query = mysql_query("SELECT item_price_id, item_price_date, item_price_value, item_price_active FROM item_price WHERE item_id = '".$item_fetch_array['item_id']."' ORDER BY item_price_date DESC");
								while ($item_price_fetch_array = mysql_fetch_array($item_price_query))
								{
									$item_price_date = indonesia_datetime_format($item_price_fetch_array['item_price_date']);
									$item_price_value = currency_format($item_price_fetch_array['item_price_value']);
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $item_price_date; ?>
										</td>
										<td>
											<?php echo $item_price_value; ?>
										</td>
										<td>
											<?php
												if($item_price_fetch_array['item_price_active'] == '1')
												{
											?>
													<a class="btn purple btn-outline" href="#">
														
														Aktif
													</a>
											<?php
												}
												else
												{
											?>
													<a class="btn red btn-outline" data-target="#" data-toggle="modal">
														
														Non Aktif
													</a>
											<?php
												}
											?>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_item_price_id_<?php echo $item_price_fetch_array['item_price_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=item-price&execute=delete-item-price&item_price_id=<?php echo $item_price_fetch_array['item_price_id']; ?>&item_id=<?php echo $item_fetch_array['item_id']; ?>'" type="button">
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
	function edit_reseller_item_sell_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-layers font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Harga Barang
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=item-price&execute=edit-item-price" class="horizontal-form" id="form_sample_3" method="post">
						<?php
							$item_price_query = mysql_query("SELECT a.item_price_id, a.item_price_date, a.item_price_value, b.item_id, b.item_name FROM item_price a, item b WHERE a.item_price_id = '".$_GET['item_price_id']."' AND a.item_id = b.item_id");
							$item_price_fetch_array = mysql_fetch_array($item_price_query);

							$item_price_date = explode("-", $item_price_fetch_array['item_price_date']);
							$date = $item_price_date[2];
							$month = $item_price_date[1];
							$year = $item_price_date[0];
							$item_price_date = date("d-m-Y", mktime(0, 0, 0, $month, $date, $year));
						?>
							<input class="form-control" name="item_price_id" type="hidden" value="<?php echo $item_price_fetch_array['item_price_id']; ?>">
							<input class="form-control" name="item_id" type="hidden" value="<?php echo $item_price_fetch_array['item_id']; ?>">
							<div class="form-body">
								<h4 class="form-section">
									Informasi Barang
								</h4>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Barang
											</label>
											<input class="form-control" disabled type="text" value="<?php echo $item_price_fetch_array['item_name']; ?>">
										</div>
									</div>
								</div>
								<h4 class="form-section">
									Informasi Harga
								</h4>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Tgl. Harga Jual
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="item_price_date" placeholder="Tgl. Harga Jual" type="text" value="<?php echo $item_price_date; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Harga Jual
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="item_price_value" placeholder="Harga Jual" type="text" value="<?php echo $item_price_fetch_array['item_price_value']; ?>">
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