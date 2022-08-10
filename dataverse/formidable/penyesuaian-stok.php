<?php
	function default_penyesuaian_stok_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-bag font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Penyesuaian Stok
							</span>
						</div>
						<div class="actions">
							<div class="actions">
								<a class="btn blue btn-outline" href="?connect=penyesuaian-stok&execute=add-penyesuaian-stok-platform">
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
										Tanggal
									</th>
									<th>
										Barang
									</th>
									<th>
										Operasi
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
								if($_SESSION['user_category_name'] == "Administrator")
								{
									$penyesuaian_stok_query = mysql_query("SELECT * FROM penyesuaian_stok a, item b WHERE a.item_id = b.item_id AND a.penyesuaian_stok_active = '1' AND b.item_category_id = '".$_SESSION['item_category_id']."' ORDER BY a.penyesuaian_stok_date DESC");
								}
								else
								{
									$penyesuaian_stok_query = mysql_query("SELECT * FROM penyesuaian_stok a, item b WHERE a.item_id = b.item_id AND a.penyesuaian_stok_active = '1' ORDER BY a.penyesuaian_stok_date DESC");
								}
								
								while ($penyesuaian_stok_fetch_array = mysql_fetch_array($penyesuaian_stok_query))
								{
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo indonesia_date_format($penyesuaian_stok_fetch_array['penyesuaian_stok_date']); ?>
										</td>
										<td>
											<?php echo $penyesuaian_stok_fetch_array['item_name'] ?>
										</td>
										<td>
											<?php echo $penyesuaian_stok_fetch_array['penyesuaian_stok_operation']; ?>
										</td>
										<td>
											<?php echo $penyesuaian_stok_fetch_array['penyesuaian_stok_quantity']; ?>
										</td>
										<td>
											<a class="btn purple btn-outline" href="?connect=penyesuaian-stok&execute=edit-penyesuaian-stok-platform&penyesuaian_stok_id=<?php echo $penyesuaian_stok_fetch_array['penyesuaian_stok_id']; ?>">
												<i class="icon-pencil"></i>
												Ubah
											</a>
											<a class="btn red btn-outline" data-target="#delete_penyesuaian_stok_id_<?php echo $penyesuaian_stok_fetch_array['penyesuaian_stok_id']; ?>" data-toggle="modal">
												<i class="icon-trash"></i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_penyesuaian_stok_id_<?php echo $penyesuaian_stok_fetch_array['penyesuaian_stok_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=penyesuaian-stok&execute=delete-penyesuaian-stok&penyesuaian_stok_id=<?php echo $penyesuaian_stok_fetch_array['penyesuaian_stok_id']; ?>'" type="button">
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
	function add_penyesuaian_stok_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-bag font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Penyesuaian Stok
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=penyesuaian-stok&execute=add-penyesuaian-stok" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Tanggal Penyesuaian Stok
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="penyesuaian_stok_date" placeholder="Tgl. Penjualan" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Barang
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#item_id" data-placeholder="Kategori" name="item_id">
											<?php
											if($_SESSION['user_category_name'] == "Administrator")
											{
												$item = mysql_query("SELECT * FROM item WHERE item_active = '1'");
											}
											else
											{
												$item = mysql_query("SELECT * FROM item WHERE item_category_id = '".$_SESSION['item_category_id']."' AND item_active = '1'");
											}
												
												while($data_item = mysql_fetch_array($item))
												{
											?>
													<option value="<?php echo $data_item['item_id'] ?>"><?php echo $data_item['item_name'] ?></option>
											<?php
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
												Operasi
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#penyesuaian_stok_operation" data-placeholder="Kategori" name="penyesuaian_stok_operation">
												<option value="kelebihan">kelebihan</option>
												<option value="kekurangan">kekurangan</option>
											</select>
											<div id="penyesuaian_stok_operation"></div>
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
											<input autocomplete="off" class="form-control" name="penyesuaian_stok_quantity" placeholder="Jumlah" type="text">
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
	function edit_penyesuaian_stok_platform()
	{
			$penyesuaian_stok = mysql_fetch_array(mysql_query("SELECT * FROM penyesuaian_stok WHERE penyesuaian_stok_id = '".$_GET['penyesuaian_stok_id']."'"));
			
			$penyesuaian_stok_date = explode("-", $penyesuaian_stok['penyesuaian_stok_date']);
							$date = $penyesuaian_stok_date[2];
							$month = $penyesuaian_stok_date[1];
							$year = $penyesuaian_stok_date[0];
							$penyesuaian_stok_date = date("d-m-Y", mktime(0, 0, 0, $month, $date, $year));
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-bag font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Penyesuaian Stok
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=penyesuaian-stok&execute=edit-penyesuaian-stok" class="horizontal-form" id="form_sample_3" method="post">
						<input type="hidden" name="penyesuaian_stok_id" value="<?php echo $penyesuaian_stok['penyesuaian_stok_id'] ?>">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Tanggal Penyesuaian Stok
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="penyesuaian_stok_date" placeholder="Tgl. Penjualan" type="text" value="<?php echo $penyesuaian_stok_date; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Barang
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#item_id" data-placeholder="Kategori" name="item_id">
											<?php
												if($_SESSION['user_category_name'] == "Administrator")
												{
													$item = mysql_query("SELECT * FROM item WHERE item_active = '1'");
												}
												else
												{
													$item = mysql_query("SELECT * FROM item WHERE item_category_id = '".$_SESSION['item_category_id']."' AND item_active = '1'");
												}
												while($data_item = mysql_fetch_array($item))
												{
													if($data_item['item_id'] == $penyesuaian_stok['item_id'])
													{
											?>
													<option value="<?php echo $data_item['item_id'] ?>" selected><?php echo $data_item['item_name'] ?></option>
											<?php
													}
													else
													{
											?>
													<option value="<?php echo $data_item['item_id'] ?>"><?php echo $data_item['item_name'] ?></option>
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
												Operasi
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#penyesuaian_stok_operation" data-placeholder="Kategori" name="penyesuaian_stok_operation">
											<?php
												if($penyesuaian_stok['penyesuaian_stok_operation'] == "kelebihan")
												{
											?>
												<option value="kelebihan" selected>kelebihan</option>
												<option value="kekurangan">kekurangan</option>
											<?php
												}
												else
												{
											?>
												<option value="kelebihan">kelebihan</option>
												<option value="kekurangan" selected>kekurangan</option>
											<?php
												}
											?>
												
											</select>
											<div id="penyesuaian_stok_operation"></div>
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
											<input autocomplete="off" class="form-control" name="penyesuaian_stok_quantity" placeholder="Jumlah" type="text" value="<?php echo $penyesuaian_stok['penyesuaian_stok_quantity'] ?>">
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