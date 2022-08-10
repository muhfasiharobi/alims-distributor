<?php
	function default_transaksi_dropship_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-basket font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Transaksi Dropship
							</span>
						</div>
						<div class="actions">
							<div class="actions">
								<a class="btn blue btn-outline" href="?connect=transaksi-dropship&execute=add-transaksi-dropship-platform">
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
										Barang
									</th>
									<th>
									    Status
									</th>
									<th>
										Bukti Pembayaran
									</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$item_selling_query = mysql_query("SELECT * FROM item_selling a, reseller b WHERE a.reseller_id = b.reseller_id AND b.user_id = '".$_SESSION['user_id']."' AND a.item_selling_active = '1' AND a.order_via_id = '5' AND b.reseller_active = '1'");
								while ($item_selling_fetch_array = mysql_fetch_array($item_selling_query))
								{
									$item_selling_date = indonesia_datetime_format($item_selling_fetch_array['item_selling_date']);
									
									$order_via = mysql_fetch_array(mysql_query("SELECT * FROM order_via WHERE order_via_id = '".$item_selling_fetch_array['order_via_id']."'"));
									
									$item_selling_delivery = mysql_fetch_array(mysql_query("SELECT * FROM item_selling_delivery WHERE item_selling_delivery_id = '".$item_selling_fetch_array['item_selling_delivery_id']."' AND item_selling_delivery_active = '1'"));

									$delivery_service = mysql_fetch_array(mysql_query("SELECT * FROM delivery_service WHERE delivery_service_id = '".$item_selling_delivery['delivery_service_id']."'"));
									
									$customer = mysql_fetch_array(mysql_query("SELECT * FROM customer WHERE customer_id = '".$item_selling_fetch_array['customer_id']."'"));

									$promo = mysql_fetch_array(mysql_query("SELECT * FROM promo WHERE promo_id = '".$item_selling_fetch_array['promo_id']."'"));
							?>
									
									
							<?php		
								if($item_selling_fetch_array['item_selling_status'] == "Belum Diproses")
								{
							?>		
									
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $item_selling_date; ?>
										</td>
										<td>
											<table class="table table-bordered table-striped">
											<?php
												$total = 0;
												$order_item_selling_query = mysql_query("SELECT a.order_item_selling_quantity, b.item_name, c.item_price_value FROM order_item_selling a, item b, item_price c WHERE a.item_id = b.item_id AND a.item_price_id = c.item_price_id AND a.order_item_selling_active = '1' AND b.item_active = '1' AND c.item_price_active = '1'");
												while($order_item_selling_fetch_array = mysql_fetch_array($order_item_selling_query))
												{
													$item_price_value = currency_format($order_item_selling_fetch_array['item_price_value']);
													
													if($total == 0)
													{
														$total = $order_item_selling_fetch_array['item_price_value']*$order_item_selling_fetch_array['order_item_selling_quantity'];
													}
													else
													{
														$total = $total + ($order_item_selling_fetch_array['item_price_value']*$order_item_selling_fetch_array['order_item_selling_quantity']);
													}
													
											?>
													<tr>
														<td>
															<strong>
																<?php echo $order_item_selling_fetch_array['item_name']; ?>
															</strong>
															<br/>
															<?php echo $order_item_selling_fetch_array['order_item_selling_quantity']; ?> Pcs
														</td>
														<td>
															<?php echo $item_price_value; ?>
														</td>
														<td>
															<?php echo $sub_total = currency_format($order_item_selling_fetch_array['order_item_selling_quantity'] * $order_item_selling_fetch_array['item_price_value'])  ?>
														</td>
													</tr>
											<?php
												}
											?>
														<tr>
																<td colspan="2" align="center"><strong>Total</strong></td>
																<td>
																	<?php
																		echo currency_format($total );
																	?>
																</td>
														</tr>
														
														<?php
															if($item_selling_fetch_array['promo_id'] != "")
															{
														?>
															<?php
																if($promo['kategori_promo'] == "prosentase")
																{
															?>
																<tr>	
																	<td colspan="2" align="center"><strong>Diskon</strong></td>
																	<td><?php echo $promo['promo_value'] ?>%</td>
																</tr>
																<tr>
																	<td colspan="2" align="center"><strong>Total</strong></td>
																	<td><?php echo currency_format($total- ($promo['promo_value'] * ($total)/100)); ?></td>
																</tr>
															<?php
																}
																else
																{
															?>
																<tr>	
																	<td colspan="2" align="center"><strong>Diskon</strong></td>
																	<td><?php echo currency_format($promo['promo_value']) ?></td>
																</tr>
																<tr>
																	<td colspan="2" align="center"><strong>Total</strong></td>
																	<td><?php echo currency_format($total- $promo['promo_value']); ?></td>
																</tr>
															<?php
																}
															?>	
														<?php
															}
														?>
														
														
													
											</table>
										</td>
										<td>
										    <?php
										        if($item_selling_fetch_array['item_selling_status'] == "Belum Diproses")
										        {
										    ?>
										            <span class="label label-sm label-danger"> <?php echo $item_selling_fetch_array['item_selling_status'] ?> </span>
										    <?php
										        }
										        else
										        {
										    ?>
										            <span class="label label-sm label-success"> <?php echo $item_selling_fetch_array['item_selling_status'] ?> </span>
										    <?php
										        }
										    ?>
										    
										    
										</td>
										<td>
										<?php
											if($item_selling_delivery['payment'] != "")
											{
										?>
												<a href="transfer/<?php echo $item_selling_delivery['payment'] ?>" target="_BLANK">
													<img src="transfer/<?php echo $item_selling_delivery['payment'] ?>"  width="70px">
												</a>
										<?php
											}
										?>
											
										</td>
										<td>
										    <?php
										        if($item_selling_fetch_array['item_selling_status'] == "Belum Diproses")
										        {
										    ?>
        											
        											<a class="btn red btn-outline" data-target="#delete_item_selling_id_<?php echo $item_selling_fetch_array['item_selling_id']; ?>" data-toggle="modal">
        												<i class="icon-trash"></i>
        												Hapus
        											</a>
        									<?php
										        }
										        else
										        {
        									?>
        									
        									        <a class="btn purple btn-outline" target="_BLANK" href="cetak.php?item_selling_id=<?php echo $item_selling_fetch_array['item_selling_id']; ?>">
        												<i class="fa fa-print"></i>
        												Cetak
        											</a>
        									
        									<?php
										        }
        									?>
										</td>
									</tr>
							<?php
								}
								else
								{
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $item_selling_date; ?>
										</td>
										<td>
											<table class="table table-bordered table-striped">
											<?php
												$total = 0;
												$order_item_selling_query = mysql_query("SELECT * FROM order_item_selling WHERE order_item_selling_active = '1'");
												while($order_item_selling_fetch_array = mysql_fetch_array($order_item_selling_query))
												{
													$item_price_value = currency_format($order_item_selling_fetch_array['item_price_value']);
													
													if($total == 0)
													{
														$total = $order_item_selling_fetch_array['item_price_value']*$order_item_selling_fetch_array['order_item_selling_quantity'];
													}
													else
													{
														$total = $total + ($order_item_selling_fetch_array['item_price_value']*$order_item_selling_fetch_array['order_item_selling_quantity']);
													}
													
											?>
													<tr>
														<td>
															<strong>
																<?php echo $order_item_selling_fetch_array['item_name']; ?>
															</strong>
															<br/>
															<?php echo $order_item_selling_fetch_array['order_item_selling_quantity']; ?> Pcs
														</td>
														<td>
															<?php echo $item_price_value; ?>
														</td>
														<td>
															<?php echo $sub_total = currency_format($order_item_selling_fetch_array['order_item_selling_quantity'] * $order_item_selling_fetch_array['item_price_value'])  ?>
														</td>
													</tr>
											<?php
												}
											?>
															<tr>
																<td colspan="2" align="center"><strong>Total</strong></td>
																<td>
																	<?php
																		echo currency_format($total);
																	?>
																</td>
															</tr>
															
													<?php
															if($item_selling_fetch_array['promo_id'] != "")
															{
														?>
															<?php
																if($item_selling_fetch_array['kategori_promo'] == "prosentase")
																{
															?>
																<tr>	
																	<td colspan="2" align="center"><strong>Diskon</strong></td>
																	<td><?php echo $item_selling_fetch_array['promo_value'] ?>%</td>
																</tr>
																<tr>
																	<td colspan="2" align="center"><strong>Total</strong></td>
																	<td><?php echo currency_format($total- ($item_selling_fetch_array['promo_value'] * ($total)/100)); ?></td>
																</tr>
															<?php
																}
																else
																{
															?>	
																<tr>	
																	<td colspan="2" align="center"><strong>Diskon</strong></td>
																	<td><?php echo currency_format($item_selling_fetch_array['promo_value']) ?></td>
																</tr>
																<tr>
																	<td colspan="2" align="center"><strong>Total</strong></td>
																	<td><?php echo currency_format($total- $item_selling_fetch_array['promo_value']); ?></td>
																</tr>

															<?php
																}
															?>
														<?php
															}
														?>
											</table>
										</td>
										<td>
										    <?php
										        if($item_selling_fetch_array['item_selling_status'] == "Belum Diproses")
										        {
										    ?>
										            <span class="label label-sm label-danger"> <?php echo $item_selling_fetch_array['item_selling_status'] ?> </span>
											<?php
										        }
										        else if($item_selling_fetch_array['item_selling_status'] == "Menunggu Bukti Pembayaran")
										        {
										    ?>
													<span class="label label-sm label-warning"> <?php echo $item_selling_fetch_array['item_selling_status'] ?> </span>
										    <?php
										        }
										        else
										        {
										    ?>
										            <span class="label label-sm label-success"> <?php echo $item_selling_fetch_array['item_selling_status'] ?> </span>
										    <?php
										        }
										    ?>	
										    
										</td>
										
										<td>
										<?php
											if($item_selling_delivery['payment'] != "")
											{
										?>
											<a href="transfer/<?php echo $item_selling_delivery['payment'] ?>" target="_BLANK">
												<img src="transfer/<?php echo $item_selling_delivery['payment'] ?>"  width="70px">
											</a>
										<?php
											}
										?>
										</td>
										<td>
										    <?php
										        if($item_selling_fetch_array['item_selling_status'] == "Belum Diproses")
										        {
										    ?>
        											
        											<a class="btn red btn-outline" data-target="#delete_item_selling_id_<?php echo $item_selling_fetch_array['item_selling_id']; ?>" data-toggle="modal">
        												<i class="icon-trash"></i>
        												Hapus
        											</a>
											<?php
										        }
										        else if($item_selling_fetch_array['item_selling_status'] == "Menunggu Bukti Pembayaran")
										        {
        									?>
													<a class="btn blue btn-outline" href="home.php?connect=transaksi-dropship&execute=add-bukti-pembayaran-platform">
        												<i class="fa fa-paper-plane-o"></i>
        												Upload Bukti Pembayaran
        											</a>
        									<?php
										        }
										        else
										        {
        									?>
        									
        									        <a class="btn purple btn-outline" target="_BLANK" href="cetak.php?item_selling_id=<?php echo $item_selling_fetch_array['item_selling_id']; ?>">
        												<i class="fa fa-print"></i>
        												Cetak
        											</a>
        									
        									<?php
										        }
        									?>
										</td>
									</tr>
							
							<?php
								}
							?>
									<div class="modal fade" data-backdrop="static" id="delete_item_selling_id_<?php echo $item_selling_fetch_array['item_selling_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=transaksi-dropship&execute=delete-transaksi-dropship'" type="button">
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
	function add_transaksi_dropship_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-basket font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Pembelian Dropship
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=transaksi-dropship&execute=order-transaksi-dropship" class="horizontal-form" id="form_sample_3" method="post">
						<?php
							$item_selling_query = mysql_query("SELECT a.item_selling_id, a.item_selling_date, b.reseller_name FROM item_selling a, reseller b WHERE a.reseller_id = b.reseller_id");
							$item_selling_fetch_array = mysql_fetch_array($item_selling_query);

							$item_selling_date = indonesia_datetime_format($item_selling_fetch_array['item_selling_date']);
						?>
							<input class="form-control" name="item_selling_id" type="hidden" value="<?php echo $item_selling_fetch_array['item_selling_id']; ?>">
							<div class="form-body">
								<h4 class="form-section">
									Informasi Dropship
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
														$item_query = mysql_query("SELECT * FROM item a, reseller b, reseller_item_sell c WHERE a.item_id = c.item_id AND b.reseller_id = c.reseller_id AND b.user_id = '".$_SESSION['user_id']."' AND a.item_active = '1' AND reseller_item_sell_active = '1'");
														while ($item_fetch_array = mysql_fetch_array($item_query))
														{	
														    $cek_barang = mysql_query("SELECT * FROM order_item_selling WHERE item_id = '".$item_fetch_array['item_id']."' ");
													        $jml_cek_barang = mysql_num_rows($cek_barang);
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
							</div>
							<div class="form-actions right">
								<button class="btn blue btn-outline" type="submit">
									<i class="icon-check"></i>
									tambah
								</button>
								&nbsp;
								<a class="btn red btn-outline" data-target="#delete_item_selling_id_<?php echo $item_selling_fetch_array['item_selling_id']; ?>" data-toggle="modal">
									<i class="icon-close"></i>
									Batal
								</a>
								<?php
									$order_item_selling_query = mysql_query("SELECT item_selling_id FROM order_item_selling WHERE order_item_selling_active = '1'");
									$order_item_selling_num_rows = mysql_num_rows($order_item_selling_query);

									if ($order_item_selling_num_rows > 0)
									{
								?>
										&nbsp;
										<button class="btn green btn-outline" onclick="location.href='?connect=transaksi-dropship'" type="button">
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
									<button class="btn blue btn-outline" onclick="location.href='?connect=transaksi-dropship&execute=cancel-order-transaksi-dropship'" type="button">
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
								$order_item_selling_query = mysql_query("SELECT * FROM order_item_selling a, item b, item_price c WHERE a.item_id = b.item_id AND a.item_price_id = c.item_price_id AND c.item_price_active = '1' AND order_item_selling_active = '1'");
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
											<button class="btn blue btn-outline" onclick="location.href='?connect=transaksi-dropship&execute=delete-order-transaksi-dropship'" type="button">
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
?>