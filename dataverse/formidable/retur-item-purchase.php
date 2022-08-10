<?php
	function default_retur_item_purchase_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-wallet font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Retur Pembelian Barang
							</span>
						</div>
						<div class="actions">
							<div class="actions">
								<a class="btn blue btn-outline" href="?connect=retur-item-purchase&execute=add-retur-item-purchase-platform">
									<i class="icon-note"></i>
									Tambah
								</a>
							</div>
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
										Tgl. Retur
									</th>
									<th>
										Pemasok
									</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$retur_item_purchase_query = mysql_query("SELECT a.retur_item_purchase_id, a.retur_item_purchase_date, b.supplier_name FROM retur_item_purchase a, supplier b WHERE a.supplier_id = b.supplier_id  AND a.retur_item_purchase_active = '1' ORDER BY a.retur_item_purchase_date DESC");
								while ($retur_item_purchase_fetch_array = mysql_fetch_array($retur_item_purchase_query))
								{
									$retur_item_purchase_date = indonesia_datetime_format($retur_item_purchase_fetch_array['retur_item_purchase_date']);
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $retur_item_purchase_date; ?>
										</td>
										<td>
											<?php echo $retur_item_purchase_fetch_array['supplier_name']; ?>
										</td>
										<td>
										    <a class="btn blue btn-outline" href="?connect=retur-item-purchase&execute=detail-retur-item-purchase-platform&retur_item_purchase_id=<?php echo $retur_item_purchase_fetch_array['retur_item_purchase_id']; ?>">
												<i class="icon-eye"></i> 
												Lihat Detail
											</a>
											<a class="btn purple btn-outline" href="?connect=retur-item-purchase&execute=edit-retur-item-purchase-platform&retur_item_purchase_id=<?php echo $retur_item_purchase_fetch_array['retur_item_purchase_id']; ?>">
												<i class="icon-pencil"></i>
												Ubah
											</a>
											<a class="btn red btn-outline" data-target="#delete_retur_item_purchase_id_<?php echo $retur_item_purchase_fetch_array['retur_item_purchase_id']; ?>" data-toggle="modal">
												<i class="icon-trash"></i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_retur_item_purchase_id_<?php echo $retur_item_purchase_fetch_array['retur_item_purchase_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=retur-item-purchase&execute=cancel-retur-item-purchase&retur_item_purchase_id=<?php echo $retur_item_purchase_fetch_array['retur_item_purchase_id']; ?>'" type="button">
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
	function add_retur_item_purchase_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-wallet font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Retur Pembelian Barang
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=retur-item-purchase&execute=add-retur-item-purchase" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
								<div class="row">
								    <div class="col-md-6">
										<div class="form-group">
											<label>
												Tgl. Retur
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="retur_item_purchase_date" placeholder="Tgl. Retur" type="text">
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
	function edit_retur_item_purchase_platform()
	{
	    
	    $retur_item_purchase = mysql_fetch_array(mysql_query("SELECT * FROM retur_item_purchase WHERE retur_item_purchase_id = '".$_GET['retur_item_purchase_id']."'"));
	    
	    $retur_item_purchase_date = explode("-", $retur_item_purchase['retur_item_purchase_date']);
		$date = $retur_item_purchase_date[2];
		$month = $retur_item_purchase_date[1];
		$year = $retur_item_purchase_date[0];
		$retur_item_purchase_date = date("d-m-Y", mktime(0, 0, 0, $month, $date, $year));
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-wallet font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Retur Pembelian Barang
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=retur-item-purchase&execute=edit-retur-item-purchase" class="horizontal-form" id="form_sample_3" method="post">
						    <input type="hidden" name="retur_item_purchase_id" value="<?php echo $_GET['retur_item_purchase_id'] ?>" />
							<div class="form-body">
								<div class="row">
								    <div class="col-md-6">
										<div class="form-group">
											<label>
												Tgl. Retur
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="retur_item_purchase_date" placeholder="Tgl. Retur" type="text" value="<?php echo $retur_item_purchase_date ?>">
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
												    if($supplier_fetch_array['supplier_id'] == $retur_item_purchase['supplier_id'])
												    {
												      
											?>
													    <option value="<?php echo $supplier_fetch_array['supplier_id']; ?>" selected><?php echo $supplier_fetch_array['supplier_name']; ?></option>
											
											    <?php
        											}
        											else
        											{
        										?>
        										        <option value="<?php echo $supplier_fetch_array['supplier_id']; ?>"><?php echo $supplier_fetch_array['supplier_name']; ?></option>
        										<?php
        											}
        										?>
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
	function order_retur_item_purchase_platform()
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
						<form action="?connect=retur-item-purchase&execute=order-retur-item-purchase" class="horizontal-form" id="form_sample_3" method="post">
						<?php
							$retur_item_purchase_query = mysql_query("SELECT a.retur_item_purchase_id, a.retur_item_purchase_date, b.supplier_name FROM retur_item_purchase a, supplier b WHERE a.retur_item_purchase_id = '".$_GET['retur_item_purchase_id']."' AND a.supplier_id = b.supplier_id");
							$retur_item_purchase_fetch_array = mysql_fetch_array($retur_item_purchase_query);

							$retur_item_purchase_date = indonesia_datetime_format($retur_item_purchase_fetch_array['retur_item_purchase_date']);
							$retur_item_purchase_due_date = indonesia_datetime_format($retur_item_purchase_fetch_array['retur_item_purchase_due_date']);
						?>
							<input class="form-control" name="retur_item_purchase_id" type="hidden" value="<?php echo $_GET['retur_item_purchase_id']; ?>">
							<div class="form-body">
								<h4 class="form-section">
									Informasi Pemasok
								</h4>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Tgl. Retur
											</label>
											<input class="form-control" disabled type="text" value="<?php echo $retur_item_purchase_date; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Pemasok
											</label>
											<input class="form-control" disabled type="text" value="<?php echo $retur_item_purchase_fetch_array['supplier_name']; ?>">
										</div>
									</div>
								</div>
								<h4 class="form-section">
									Informasi Retur Pembelian
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
												$item_query = mysql_query("SELECT item_id, item_name FROM item WHERE item_active = '1' ORDER BY item_name");
												while ($item_fetch_array = mysql_fetch_array($item_query))
												{
													$order_retur_item_purchase_query = mysql_query("SELECT order_retur_item_purchase_id FROM order_retur_item_purchase WHERE retur_item_purchase_id = '".$retur_item_purchase_fetch_array['retur_item_purchase_id']."' AND item_id = '".$item_fetch_array['item_id']."' AND order_retur_item_purchase_active = '1'");
													$order_retur_item_purchase_num_rows = mysql_num_rows($order_retur_item_purchase_query);

													if ($order_retur_item_purchase_num_rows < 1)
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
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Jumlah
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="order_retur_item_purchase_quantity" placeholder="Jumlah" type="text">
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
								<a class="btn red btn-outline" data-target="#delete_retur_item_purchase_id_<?php echo $retur_item_purchase_fetch_array['retur_item_purchase_id']; ?>" data-toggle="modal">
									<i class="icon-close"></i>
									Batal
								</a>
								<?php
									$order_retur_item_purchase_query = mysql_query("SELECT retur_item_purchase_id FROM order_retur_item_purchase WHERE retur_item_purchase_id = '".$retur_item_purchase_fetch_array['retur_item_purchase_id']."'");
									$order_retur_item_purchase_num_rows = mysql_num_rows($order_retur_item_purchase_query);

									if ($order_retur_item_purchase_num_rows > 0)
									{
								?>
										&nbsp;
										<button class="btn green btn-outline" onclick="location.href='?connect=retur-item-purchase'" type="button">
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
							<div class="modal fade" data-backdrop="static" id="delete_retur_item_purchase_id_<?php echo $retur_item_purchase_fetch_array['retur_item_purchase_id']; ?>">
								<div class="modal-body">
									<p>
										Apakah Anda Ingin Membatalkan Data Ini ?
									</p>
								</div>
								<div class="modal-footer">
									<button class="btn blue btn-outline" onclick="location.href='?connect=retur-item-purchase&execute=cancel-retur-item-purchase&retur_item_purchase_id=<?php echo $retur_item_purchase_fetch_array['retur_item_purchase_id']; ?>'" type="button">
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
					<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover order-column" id="sample_1">
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
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$order_retur_item_purchase_query = mysql_query("SELECT a.order_retur_item_purchase_id, a.retur_item_purchase_id, a.order_retur_item_purchase_quantity, b.item_name FROM order_retur_item_purchase a, item b WHERE a.retur_item_purchase_id = '".$retur_item_purchase_fetch_array['retur_item_purchase_id']."' AND a.item_id = b.item_id AND b.item_active = '1' ORDER BY a.order_retur_item_purchase_id DESC");
								while ($order_retur_item_purchase_fetch_array = mysql_fetch_array($order_retur_item_purchase_query))
								{
									$order_item_purchase_price = currency_format($order_item_purchase_fetch_array['order_item_purchase_price']);
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $order_retur_item_purchase_fetch_array['item_name']; ?>
										</td>
										<td>
											<?php echo $order_retur_item_purchase_fetch_array['order_retur_item_purchase_quantity']; ?>
										</td>
										<td>
											<a class="btn red btn-outline" data-target="#delete_order_item_purchase_id_<?php echo $order_retur_item_purchase_fetch_array['order_retur_item_purchase_id']; ?>" data-toggle="modal">
												<i class="icon-trash"></i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_order_item_purchase_id_<?php echo $order_retur_item_purchase_fetch_array['order_retur_item_purchase_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=retur-item-purchase&execute=delete-retur-order-item-purchase&order_retur_item_purchase_id=<?php echo $order_retur_item_purchase_fetch_array['order_retur_item_purchase_id']; ?>&retur_item_purchase_id=<?php echo $order_retur_item_purchase_fetch_array['retur_item_purchase_id']; ?>'" type="button">
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
	function detail_retur_item_purchase_platform()
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
						<form action="?connect=retur-item-purchase&execute=order-retur-item-purchase" class="horizontal-form" id="form_sample_3" method="post">
						<?php
							$retur_item_purchase_query = mysql_query("SELECT a.retur_item_purchase_id, a.retur_item_purchase_date, b.supplier_name FROM retur_item_purchase a, supplier b WHERE a.retur_item_purchase_id = '".$_GET['retur_item_purchase_id']."' AND a.supplier_id = b.supplier_id");
							$retur_item_purchase_fetch_array = mysql_fetch_array($retur_item_purchase_query);

							$retur_item_purchase_date = indonesia_datetime_format($retur_item_purchase_fetch_array['retur_item_purchase_date']);
							$retur_item_purchase_due_date = indonesia_datetime_format($retur_item_purchase_fetch_array['retur_item_purchase_due_date']);
						?>
							<input class="form-control" name="retur_item_purchase_id" type="hidden" value="<?php echo $_GET['retur_item_purchase_id']; ?>">
							<div class="form-body">
								<h4 class="form-section">
									Informasi Pemasok
								</h4>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Tgl. Retur
											</label>
											<input class="form-control" disabled type="text" value="<?php echo $retur_item_purchase_date; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Pemasok
											</label>
											<input class="form-control" disabled type="text" value="<?php echo $retur_item_purchase_fetch_array['supplier_name']; ?>">
										</div>
									</div>
								</div>
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
										Barang
									</th>
									<th>
										Jumlah
									</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$order_retur_item_purchase_query = mysql_query("SELECT a.order_retur_item_purchase_id, a.retur_item_purchase_id, a.order_retur_item_purchase_quantity, b.item_name FROM order_retur_item_purchase a, item b WHERE a.retur_item_purchase_id = '".$retur_item_purchase_fetch_array['retur_item_purchase_id']."' AND a.item_id = b.item_id AND b.item_active = '1' ORDER BY a.order_retur_item_purchase_id DESC");
								while ($order_retur_item_purchase_fetch_array = mysql_fetch_array($order_retur_item_purchase_query))
								{
									$order_item_purchase_price = currency_format($order_item_purchase_fetch_array['order_item_purchase_price']);
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $order_retur_item_purchase_fetch_array['item_name']; ?>
										</td>
										<td>
											<?php echo $order_retur_item_purchase_fetch_array['order_retur_item_purchase_quantity']; ?>
										</td>
									</tr>
							<?php
								$number++;
								}
							?>
							</tbody>
						</table>
					</div>
					        <div class="form-actions right">
								<button class="btn green btn-outline" onclick="location.href='?connect=retur-item-purchase'" type="button">
									<i class="icon-logout"></i>
									Kembali
								</button>
							</div>
				</div>
			</div>
		</div>
<?php
	}
?>