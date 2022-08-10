<?php
	function default_item_stock_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-bag font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Stok Barang
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=item-stock" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Dari Tanggal
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="from_date" placeholder="Tgl. Penjualan" type="text" value="<?php echo $_POST['from_date'] ?>">
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
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="to_date" placeholder="Tgl. Penjualan" type="text" value="<?php echo $_POST['to_date'] ?>">
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions right">
								<button class="btn yellow btn-outline" type="submit">
									<i class="icon-action-redo"></i>
									Proses
								</button>
							</div>
						</form>
					</div>
					<br>
					<div class="portlet-body">
					    <div class="alert alert-info">
                                            <strong>Stok Akhir = Stok Awal/Pembelian - ( Penjualan + Free Produk ) +/- Penyesuaian Stok</strong>
                    	</div>
                                            <br><br><br>
						<table class="table table-striped table-bordered table-hover order-column" id="sample_2">
							<thead>
								<tr>
									<th>
										No
									</th>
									<th>
										Nama Barang
									</th>
									<th>
										Stok Awal/Pembelian
									</th>
									<th>
										Penjualan
									</th>
									<th>
										Free Produk
									</th>
									<th>
										Penyesuaian Stok
									</th>
									<th>
										Stok Akhir
									</th>
								</tr>
							</thead>
							<tbody>
							<?php
							        $selling_from_date = explode("-", $_POST['from_date']);
									$date = $selling_from_date[0];
									$month = $selling_from_date[1];
									$year = $selling_from_date[2];
									$selling_from_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));

									$selling_to_date = explode("-", $_POST['to_date']);
									$date = $selling_to_date[0];
									$month = $selling_to_date[1];
									$year = $selling_to_date[2];
									$selling_to_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
									
								$number = 1;
								if($_SESSION['user_category_name'] == "Administrator")
								{
									$item_query = mysql_query("SELECT * FROM item WHERE item_active = '1'");
								}
								else
								{
									$item_query = mysql_query("SELECT * FROM item WHERE item_category_id = '".$_SESSION['item_category_id']."' AND item_active = '1'");
								}
								
								while ($item_fetch_array = mysql_fetch_array($item_query))
								{
								    if($_POST['from_date'] == "")
								    {
								        $item_purchase = mysql_fetch_array(mysql_query("SELECT SUM(order_item_purchase_quantity) as order_item_purchase_quantity FROM order_item_purchase WHERE item_id = '".$item_fetch_array['item_id']."' AND order_item_purchase_active = '1'"));
									
    									$item_selling = mysql_fetch_array(mysql_query("SELECT SUM(b.order_item_selling_quantity) as order_item_selling_quantity FROM item_selling a, order_item_selling b WHERE a.item_selling_id = b.item_selling_id AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses' AND b.item_id = '".$item_fetch_array['item_id']."' AND b.order_item_selling_active = '1'"));
    									
    									$penyesuaian_stok = 0;
    									$penyesuaian_stok_plus = mysql_fetch_array(mysql_query("SELECT SUM(penyesuaian_stok_quantity) as penyesuaian_stok_quantity FROM penyesuaian_stok WHERE item_id = '".$item_fetch_array['item_id']."' AND penyesuaian_stok_operation = 'kekurangan' AND penyesuaian_stok_active = '1'"));
    												
    									$penyesuaian_stok_minus = mysql_fetch_array(mysql_query("SELECT SUM(penyesuaian_stok_quantity) as penyesuaian_stok_quantity FROM penyesuaian_stok WHERE item_id = '".$item_fetch_array['item_id']."' AND penyesuaian_stok_operation = 'kelebihan' AND penyesuaian_stok_active = '1'"));
    												
    									$penyesuaian_stok = $penyesuaian_stok_plus['penyesuaian_stok_quantity'] - $penyesuaian_stok_minus['penyesuaian_stok_quantity'];
    									
    									$barang_keluar = mysql_fetch_array(mysql_query("SELECT SUM(barang_keluar_quantity) as barang_keluar_quantity FROM barang_keluar WHERE item_id = '".$item_fetch_array['item_id']."' AND barang_keluar_active = '1' "));
    									
    									$stock = $item_purchase['order_item_purchase_quantity'] - ($item_selling['order_item_selling_quantity'] + $barang_keluar['barang_keluar_quantity']) + $penyesuaian_stok;
								    }
								    else
								    {
								        $item_purchase = mysql_fetch_array(mysql_query("SELECT SUM(order_item_purchase_quantity) as order_item_purchase_quantity FROM order_item_purchase WHERE item_id = '".$item_fetch_array['item_id']."' AND order_item_purchase_active = '1' AND item_purchase_date BETWEEN '".$selling_from_date."' AND '".$selling_to_date."'"));
									
    									$item_selling = mysql_fetch_array(mysql_query("SELECT SUM(b.order_item_selling_quantity) as order_item_selling_quantity FROM item_selling a, order_item_selling b WHERE a.item_selling_id = b.item_selling_id AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses' AND b.item_id = '".$item_fetch_array['item_id']."' AND b.order_item_selling_active = '1' AND a.item_selling_date BETWEEN '".$selling_from_date."' AND '".$selling_to_date."'"));
    									
    									$penyesuaian_stok = 0;
    									$penyesuaian_stok_plus = mysql_fetch_array(mysql_query("SELECT SUM(penyesuaian_stok_quantity) as penyesuaian_stok_quantity FROM penyesuaian_stok WHERE item_id = '".$item_fetch_array['item_id']."' AND penyesuaian_stok_operation = 'kekurangan' AND penyesuaian_stok_active = '1' AND penyesuaian_stok_date BETWEEN '".$selling_from_date."' AND '".$selling_to_date."'"));
    												
    									$penyesuaian_stok_minus = mysql_fetch_array(mysql_query("SELECT SUM(penyesuaian_stok_quantity) as penyesuaian_stok_quantity FROM penyesuaian_stok WHERE item_id = '".$item_fetch_array['item_id']."' AND penyesuaian_stok_operation = 'kelebihan' AND penyesuaian_stok_active = '1' AND penyesuaian_stok_date BETWEEN '".$selling_from_date."' AND '".$selling_to_date."'"));
    												
    									$penyesuaian_stok = $penyesuaian_stok_plus['penyesuaian_stok_quantity'] - $penyesuaian_stok_minus['penyesuaian_stok_quantity'];
    									
    									$barang_keluar = mysql_fetch_array(mysql_query("SELECT SUM(barang_keluar_quantity) as barang_keluar_quantity FROM barang_keluar WHERE item_id = '".$item_fetch_array['item_id']."' AND barang_keluar_active = '1' AND barang_keluar_date BETWEEN '".$selling_from_date."' AND '".$selling_to_date."'"));
    									
    									$stock = $item_purchase['order_item_purchase_quantity'] - ($item_selling['order_item_selling_quantity'] + $barang_keluar['barang_keluar_quantity']) + $penyesuaian_stok;
								    }
									
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $item_fetch_array['item_name']; ?>
										</td>
										<td>
											<?php
												if($item_purchase['order_item_purchase_quantity'] != "")
												{
											?>
													<?php echo $item_purchase['order_item_purchase_quantity']; ?>
											<?php
												}
												else
												{
											?>
													0
											<?php
												}
											?>
										</td>
										
										<td>
											<?php
												if($item_selling['order_item_selling_quantity'] != "")
												{
											?>
													<?php echo $item_selling['order_item_selling_quantity']; ?>
											<?php
												}
												else
												{
											?>
													0
											<?php
												}
											?>
										</td>
										<td>
											<?php echo $barang_keluar['barang_keluar_quantity'] ?>
										</td>
										<td>
											<?php
												echo $penyesuaian_stok;
											?>
										</td>
										<td>
											<?php echo $stock; ?>
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
	function add_item_stock_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-bag font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Barang
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=item&execute=add-item" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
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
												Nama
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="item_name" placeholder="Nama" type="text">
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
	function edit_item_stock_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-bag font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Barang
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=item&execute=edit-item" class="horizontal-form" id="form_sample_3" method="post">
						<?php
							$item_query = mysql_query("SELECT item_id, item_category_id, item_name FROM item WHERE item_id = '".$_GET['item_id']."'");
							$item_fetch_array = mysql_fetch_array($item_query);
						?>
							<input class="form-control" name="item_id" type="hidden" value="<?php echo $item_fetch_array['item_id']; ?>">
							<div class="form-body">
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
													<option <?php if ($item_category_fetch_array['item_category_id'] == $item_fetch_array['item_category_id']) { ?> selected="selected" <?php } ?> value="<?php echo $item_category_fetch_array['item_category_id']; ?>"><?php echo $item_category_fetch_array['item_category_name']; ?></option>
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
												Nama
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="item_name" placeholder="Nama" type="text" value="<?php echo $item_fetch_array['item_name']; ?>">
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