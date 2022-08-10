<?php
	function default_item_commission_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-present font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Komisi Barang
							</span>
						</div>
					</div>
					<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover order-column" id="sample_1">
							<thead>
								<tr>
									<th>
										No
									</th>
									<th>
										Tgl. Komisi
									</th>
									<th>
										Barang
									</th>
									<th>
										Nilai Komisi
									</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$order_item_purchase_query = mysql_query("SELECT b.item_id, b.item_name FROM order_item_purchase a, item b WHERE a.item_id = b.item_id AND a.order_item_purchase_active = '1' AND b.item_active = '1' GROUP BY b.item_id ORDER BY b.item_name");
								while ($order_item_purchase_fetch_array = mysql_fetch_array($order_item_purchase_query))
								{
									$item_commission_query = mysql_query("SELECT item_commission_date, item_commission_value FROM item_commission WHERE item_id = '".$order_item_purchase_fetch_array['item_id']."' AND item_commission_date IN (SELECT MAX(item_commission_date) FROM item_commission GROUP BY item_id) AND item_commission_active = '1'");
									$item_commission_num_rows = mysql_num_rows($item_commission_query);
									$item_commission_fetch_array = mysql_fetch_array($item_commission_query);

									$item_commission_date = indonesia_datetime_format($item_commission_fetch_array['item_commission_date']);
									$item_commission_value = currency_format($item_commission_fetch_array['item_commission_value']);
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
										<?php 
											if ($item_commission_num_rows > 0)
											{
												echo $item_commission_date; 
											}
											else
											{
										?>
												(Belum Terisi)
										<?php
											}
										?>
										</td>
										<td>
											<?php echo $order_item_purchase_fetch_array['item_name']; ?>
										</td>
										<td>
										<?php 
											if ($item_commission_num_rows > 0)
											{
												echo $item_commission_value;
											}
											else
											{
										?>
												(Belum Terisi)
										<?php
											}
										?>
										</td>
										<td>
										<?php 
											if ($item_commission_num_rows > 0)
											{
										?>
												<a class="btn yellow btn-outline" href="?connect=item-commission&execute=history-item-commission-platform&item_id=<?php echo $order_item_purchase_fetch_array['item_id']; ?>">
												<i class="icon-clock"></i>
													Riwayat
												</a>
										<?php
											}
											else
											{
										?>
												<a class="btn blue btn-outline" href="?connect=item-commission&execute=add-item-commission-platform&item_id=<?php echo $order_item_purchase_fetch_array['item_id']; ?>">
												<i class="icon-note"></i>
													Tambah
												</a>
										<?php
											}
										?>
										</td>
									</tr>
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
	function add_item_commission_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-present font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Komisi Barang
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=item-commission&execute=add-item-commission" class="horizontal-form" id="form_sample_3" method="post">
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
									Informasi Komisi
								</h4>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Tgl. Komisi
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="item_commission_date" placeholder="Tgl. Komisi" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Nilai Komisi
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="item_commission_value" placeholder="Nilai Komisi" type="text">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Minimal Penjualan (Pcs)
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="minimal_selling" placeholder="Minimal Penjualan" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Maximal Penjualan (Pcs)
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="maximal_selling" placeholder="Maximal Penjualan" type="text">
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
	function history_item_commission_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-present font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Komisi Barang
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=item-commission&execute=add-item-commission" class="horizontal-form" id="form_sample_3" method="post">
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
									Informasi Komisi
								</h4>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Tgl. Komisi
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="item_commission_date" placeholder="Tgl. Komisi" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Nilai Komisi
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="item_commission_value" placeholder="Nilai Komisi" type="text">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Minimal Penjualan (Pcs)
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="minimal_selling" placeholder="Minimal Penjualan" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Maximal Penjualan (Pcs)
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="maximal_selling" placeholder="Maximal Penjualan" type="text">
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
								<button class="btn green btn-outline" onclick="location.href='?connect=item-commission'" type="button">
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
										Tgl. Komisi
									</th>
									<th>
										Nilai Komisi
									</th>
									<th>
										Minimal Penjualan
									</th>
									<th>
										Maximal Penjualan
									</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$item_commission_query = mysql_query("SELECT item_commission_id, item_commission_date, item_commission_value, minimal_selling, maximal_selling FROM item_commission WHERE item_id = '".$item_fetch_array['item_id']."' AND item_commission_active = '1' ORDER BY item_commission_date DESC");
								while ($item_commission_fetch_array = mysql_fetch_array($item_commission_query))
								{
									$item_commission_date = indonesia_datetime_format($item_commission_fetch_array['item_commission_date']);
									$item_commission_value = currency_format($item_commission_fetch_array['item_commission_value']);
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $item_commission_date; ?>
										</td>
										<td>
											<?php echo $item_commission_value; ?>
										</td>
										<td>
											<?php echo $item_commission_fetch_array['minimal_selling'] ?>
										</td>
										<td>
											<?php echo $item_commission_fetch_array['maximal_selling'] ?>
										</td>
										<td>
											<a class="btn purple btn-outline" href="?connect=item-commission&execute=edit-item-commission-platform&item_commission_id=<?php echo $item_commission_fetch_array['item_commission_id']; ?>">
												<i class="icon-pencil"></i>
												Ubah
											</a>
											<a class="btn red btn-outline" data-target="#delete_item_commission_id_<?php echo $item_commission_fetch_array['item_commission_id']; ?>" data-toggle="modal">
												<i class="icon-trash"></i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_item_commission_id_<?php echo $item_commission_fetch_array['item_commission_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=item-commission&execute=delete-item-commission&item_commission_id=<?php echo $item_commission_fetch_array['item_commission_id']; ?>&item_id=<?php echo $item_fetch_array['item_id']; ?>'" type="button">
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
	function edit_item_commission_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-present font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Komisi Barang
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=item-commission&execute=edit-item-commission" class="horizontal-form" id="form_sample_3" method="post">
						<?php
							$item_commission_query = mysql_query("SELECT a.item_commission_id, a.item_commission_date, a.item_commission_value, b.item_id, b.item_name, a.minimal_selling, a.maximal_selling FROM item_commission a, item b WHERE a.item_commission_id = '".$_GET['item_commission_id']."' AND a.item_id = b.item_id");
							$item_commission_fetch_array = mysql_fetch_array($item_commission_query);

							$item_commission_date = explode("-", $item_commission_fetch_array['item_commission_date']);
							$date = $item_commission_date[2];
							$month = $item_commission_date[1];
							$year = $item_commission_date[0];
							$item_commission_date = date("d-m-Y", mktime(0, 0, 0, $month, $date, $year));
						?>
							<input class="form-control" name="item_commission_id" type="hidden" value="<?php echo $item_commission_fetch_array['item_commission_id']; ?>">
							<input class="form-control" name="item_id" type="hidden" value="<?php echo $item_commission_fetch_array['item_id']; ?>">
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
											<input class="form-control" disabled type="text" value="<?php echo $item_commission_fetch_array['item_name']; ?>">
										</div>
									</div>
								</div>
								<h4 class="form-section">
									Informasi Komisi
								</h4>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Tgl. Komisi
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="item_commission_date" placeholder="Tgl. Komisi" type="text" value="<?php echo $item_commission_date; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Nilai Komisi
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="item_commission_value" placeholder="Nilai Komisi" type="text" value="<?php echo $item_commission_fetch_array['item_commission_value']; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Minimal Penjualan (Pcs)
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="minimal_selling" placeholder="Minimal Penjualan" type="text" value="<?php echo $item_commission_fetch_array['minimal_selling'] ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Maximal Penjualan (Pcs)
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="maximal_selling" placeholder="Maximal Penjualan" type="text" value="<?php echo $item_commission_fetch_array['maximal_selling'] ?>">
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