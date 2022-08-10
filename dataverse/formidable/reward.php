<?php
	function default_reward_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-present font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Reward
							</span>
						</div>
						<div class="actions">
							<div class="actions">
								<a class="btn blue btn-outline" href="?connect=reward&execute=add-reward-platform">
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
										Jumlah Penjualan
									</th>
									<th>
										Nilai Reward
									</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$reward_query = mysql_query("SELECT * FROM reward WHERE reward_active = '1'");
								while ($reward_fetch_array = mysql_fetch_array($reward_query))
								{
									
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $reward_fetch_array['selling_quantity'] ?>
										</td>
										<td>
											<?php echo currency_format($reward_fetch_array['reward_value']) ?>
										</td>
										<td>
											<a class="btn purple btn-outline" href="?connect=reward&execute=edit-reward-platform&reward_id=<?php echo $reward_fetch_array['reward_id']; ?>">
												<i class="icon-pencil"></i>
												Ubah
											</a>
											<a class="btn red btn-outline" data-target="#delete_reward_id_<?php echo $item_fetch_array['reward_id']; ?>" data-toggle="modal">
												<i class="icon-trash"></i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_reward_id_<?php echo $item_fetch_array['reward_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=reward&execute=delete-reward&reward_id=<?php echo $reward_fetch_array['reward_id']; ?>'" type="button">
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
	function add_reward_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-present font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Reward
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=reward&execute=add-reward" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Jumlah Penjualan (Pcs)
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="selling_quantity" placeholder="Jumlah Penjualan" type="text">
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
											<input autocomplete="off" class="form-control" name="reward_value" placeholder="Nilai Komisi" type="text">
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
	function history_reward_platform()
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
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="reward_date" placeholder="Tgl. Komisi" type="text">
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
											<input autocomplete="off" class="form-control" name="reward_value" placeholder="Nilai Komisi" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Jumlah Penjualan (Pcs)
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="selling_quantity" placeholder="Jumlah Penjualan" type="text">
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
										Jumlah Penjualan
									</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$reward_query = mysql_query("SELECT reward_id, reward_date, reward_value, minimal_selling, maximal_selling FROM reward WHERE item_id = '".$item_fetch_array['item_id']."' AND reward_active = '1' ORDER BY reward_date DESC");
								while ($reward_fetch_array = mysql_fetch_array($reward_query))
								{
									$reward_date = indonesia_datetime_format($reward_fetch_array['reward_date']);
									$reward_value = currency_format($reward_fetch_array['reward_value']);
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $reward_date; ?>
										</td>
										<td>
											<?php echo $reward_value; ?>
										</td>
										<td>
											<?php echo $reward_fetch_array['selling_quantity'] ?>
										</td>
										<td>
											<a class="btn purple btn-outline" href="?connect=item-commission&execute=edit-item-commission-platform&reward_id=<?php echo $reward_fetch_array['reward_id']; ?>">
												<i class="icon-pencil"></i>
												Ubah
											</a>
											<a class="btn red btn-outline" data-target="#delete_reward_id_<?php echo $reward_fetch_array['reward_id']; ?>" data-toggle="modal">
												<i class="icon-trash"></i>
												Hapus
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="delete_reward_id_<?php echo $reward_fetch_array['reward_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=item-commission&execute=delete-item-commission&reward_id=<?php echo $reward_fetch_array['reward_id']; ?>&item_id=<?php echo $item_fetch_array['item_id']; ?>'" type="button">
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
	function edit_reward_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-present font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Reward
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=reward&execute=edit-reward" class="horizontal-form" id="form_sample_3" method="post">
						<?php
							$reward_query = mysql_query("SELECT * FROM reward WHERE reward_id = '".$_GET['reward_id']."'");
							$reward_fetch_array = mysql_fetch_array($reward_query);
						?>
							<input class="form-control" name="reward_id" type="hidden" value="<?php echo $reward_fetch_array['reward_id']; ?>">
							<div class="form-body">
								<h4 class="form-section">
									Informasi Reward
								</h4>
								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Jumlah Penjualan (Pcs)
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="selling_quantity" placeholder="Jumlah Penjualan" type="text" value="<?php echo $reward_fetch_array['selling_quantity'] ?>">
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
											<input autocomplete="off" class="form-control" name="reward_value" placeholder="Nilai Komisi" type="text" value="<?php echo $reward_fetch_array['reward_value'] ?>">
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