<?php
	function default_item_selling_agen_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-basket font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Penjualan
							</span>
						</div>
						<div class="actions">
							<div class="actions">
								<a class="btn blue btn-outline" href="?connect=item-selling-agen&execute=add-item-selling-agen-platform">
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
										No Penjualan
									</th>
									<th>
										Tgl. Penjualan
									</th>
									
									<th>
										Pelanggan
									</th>
									<th>
										Order Via
									</th>
									<th>
										Barang
									</th>
									<th>
									    Status
									</th>
									<th>
										JOB / Resi
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
								$item_selling_query = mysql_query("SELECT * FROM item_selling a, reseller b WHERE a.reseller_id = b.reseller_id AND b.user_id = '".$_SESSION['user_id']."' AND a.item_selling_active = '1' AND b.reseller_active = '1' ORDER BY a.item_selling_id DESC");
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
										    <?php echo $item_selling_fetch_array['item_selling_code'] ?>
										</td>
										<td>
											<?php echo $item_selling_date; ?>
										</td>
										<td>
											<?php echo $customer['customer_code']; ?> | <?php echo $customer['customer_name']; ?>
										</td>
										<td>
											<?php echo $order_via['order_via_name']; ?>
										</td>
										<td>
											<table class="table table-bordered table-striped">
											<?php
												$total = 0;
												$order_item_selling_query = mysql_query("SELECT a.order_item_selling_quantity, b.item_name, c.item_price_value FROM order_item_selling a, item b, item_price c WHERE a.item_selling_id = '".$item_selling_fetch_array['item_selling_id']."' AND a.item_id = b.item_id AND a.item_price_id = c.item_price_id AND a.order_item_selling_active = '1' AND b.item_active = '1' AND c.item_price_active = '1'");
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
													<tr>
															<td colspan="2" align="center"><strong>Ongkir</strong></td>
															<td><?php echo currency_format($item_selling_delivery['delivery_cost']); ?></td>
														</tr>	
														
														
													
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
										<td><?php echo $delivery_service['delivery_service_name'] ?> - <?php echo $item_selling_delivery['no_resi'] ?></td>
										<td>
											<a href="transfer/<?php echo $item_selling_delivery['payment'] ?>" target="_BLANK">
												<img src="transfer/<?php echo $item_selling_delivery['payment'] ?>"  width="70px">
											</a>
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
										    <?php echo $item_selling_fetch_array['item_selling_code'] ?>
										</td>
										<td>
											<?php echo $item_selling_date; ?>
										</td>
										<td>
											<?php echo $item_selling_fetch_array['customer_code']; ?> | <?php echo $item_selling_fetch_array['customer_name']; ?>
										</td>
										<td>
											<?php echo $order_via['order_via_name']; ?>
										</td>
										<td>
											<table class="table table-bordered table-striped">
											<?php
												$total = 0;
												$order_item_selling_query = mysql_query("SELECT * FROM order_item_selling WHERE item_selling_id = '".$item_selling_fetch_array['item_selling_id']."' AND order_item_selling_active = '1'");
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
														<tr>
															<td colspan="2" align="center"><strong>Ongkir</strong></td>
															<td><?php echo currency_format($item_selling_delivery['delivery_cost']); ?></td>
														
													</tr>
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
										<td><?php echo $delivery_service['delivery_service_name'] ?> - <?php echo $item_selling_delivery['no_resi'] ?></td>
										<td>
											<a href="transfer/<?php echo $item_selling_delivery['payment'] ?>" target="_BLANK">
												<img src="transfer/<?php echo $item_selling_delivery['payment'] ?>"  width="70px">
											</a>
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
							?>
									<div class="modal fade" data-backdrop="static" id="delete_item_selling_id_<?php echo $item_selling_fetch_array['item_selling_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menghapus Data Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=item-selling-agen&execute=delete-item-selling-agen&item_selling_id=<?php echo $item_selling_fetch_array['item_selling_id']; ?>'" type="button">
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
	function add_item_selling_agen_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-basket font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Penjualan
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=item-selling-agen&execute=add-item-selling-agen" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Tgl. Penjualan
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="item_selling_date" placeholder="Tgl. Penjualan" type="text" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Order 
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#order_id" data-placeholder="Order" name="order_via_id" required>
												<?php
													$order_via = mysql_query("SELECT * FROM order_via WHERE order_via_active = '1'");
													while($data_order_via = mysql_fetch_array($order_via))
													{
												?>
														<option value="<?php echo $data_order_via['order_via_id'] ?>"><?php echo $data_order_via['order_via_name'] ?></option>
												<?php
													}
												?>
											</select>
											<div id="reseller_id"></div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Pelanggan 
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#customer_id" data-placeholder="Pelanggan" name="customer_id" id="customer_id" required>
												<?php
													$customer = mysql_query("SELECT * FROM customer a, reseller b WHERE a.reseller_id = b.reseller_id AND b.user_id = '".$_SESSION['user_id']."' AND a.customer_active = '1'");
													while($data_customer = mysql_fetch_array($customer))
													{
												?>
														<option></option>
														<option value="<?php echo $data_customer['customer_id'] ?>"><?php echo $data_customer['customer_code'] ?> - <?php echo $data_customer['customer_name'] ?></option>
												<?php
													}
												?>
											</select>
											<div id="reseller_id"></div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Promo 
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#promo_id" data-placeholder="Promo" name="promo_id" id="promo_id">
												<option value=""></option>
												<?php
													$tgl_skrg = date('Y-m-d');
													$promo = mysql_query("SELECT * FROM promo WHERE promo_active = '1' AND '".$tgl_skrg."' BETWEEN promo_from_date AND promo_to_date");
													while($data_promo = mysql_fetch_array($promo))
													{
												?>
														<?php
															if($data_promo['kategori_promo'] == "prosentase")
															{
														?>
																
																<option value="<?php echo $data_promo['promo_id'] ?>"><?php echo $data_promo['promo_name'] ?> - <?php echo $data_promo['promo_value'] ?>%</option>
														<?php
															}
															else
															{
														?>
																<option value="<?php echo $data_promo['promo_id'] ?>"><?php echo $data_promo['promo_name'] ?> - <?php echo currency_format($data_promo['promo_value']) ?></option>
														<?php
															}
														?>
												<?php
													}
												?>
											</select>
											<div id="promo_id"></div>
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
	function add_delivery_agen_platform()
	{
		$item_selling = mysql_fetch_array(mysql_query("SELECT * FROM item_selling a, customer b WHERE a.customer_id = b.customer_id AND a.item_selling_id = '".$_GET['item_selling_id']."'"));
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-basket font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Penjualan 
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=item-selling-agen&execute=add-delivery-selling-agen" class="horizontal-form" id="form_sample_3" method="post" enctype="multipart/form-data">
						<input type="hidden" name="item_selling_id" value="<?php echo $item_selling['item_selling_id'] ?>">
						<?php
							$order_via = mysql_fetch_array(mysql_query("SELECT * FROM order_via WHERE order_via_id = '".$item_selling['order_via_id']."'"));
							if($order_via['order_via_name'] == "Whatsapp")
							{
						?>
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Alamat Pengiriman
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="delivery_address" placeholder="Alamat Pengiriman" type="text" value="<?php echo $item_selling['customer_address'] ?>, <?php echo $item_selling['customer_village'] ?> - <?php echo $item_selling['customer_districts'] ?> - <?php echo $item_selling['customer_city'] ?>" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Bukti Pembayaran
												<span class="required">
													*
												</span>
											</label></br>
											<img id="image-preview" alt="image preview" src="../assets/global/img/no-image.png" width="40%"/>
											<div>
                                                <span class="btn red btn-outline btn-file">
                                                <span class="fileinput-new"> Pilih Gambar </span>
                                                <input type="file" name="payment" id="image-source" onchange="previewImage();" required> </span>
                                            </div>
										</div>
									</div>
								</div>
							</div>
						<?php
							}
							else
							{
						?>
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Alamat Pengiriman
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="delivery_address" placeholder="Alamat Pengiriman" type="text" value="<?php echo $item_selling['customer_address'] ?>, <?php echo $item_selling['customer_village'] ?> - <?php echo $item_selling['customer_districts'] ?> - <?php echo $item_selling['customer_city'] ?>" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Jasa Pengiriman
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#delivery_service_id" data-placeholder="Jasa Pengiriman" name="delivery_service_id" required>
													<?php
														$delivery_service_query = mysql_query("SELECT * FROM delivery_service WHERE delivery_service_active = '1'");
														while ($delivery_service_fetch_array = mysql_fetch_array($delivery_service_query))
														{	
													?>
																<option value="<?php echo $delivery_service_fetch_array['delivery_service_id']; ?>"><?php echo $delivery_service_fetch_array['delivery_service_name']; ?></option>
													<?php
														}
													?>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												JOB / Resi
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="no_resi" placeholder="JOB / Resi" type="text" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Biaya Pengiriman
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="delivery_cost" placeholder="Biaya Pengiriman" type="text" required>
										</div>
									</div>
								</div>
								<div class="row">
							        <div class="col-md-6">
										<div class="form-group">
											<label>
												Bukti Pembayaran
												<span class="required">
													*
												</span>
											</label></br>
											<img id="image-preview" alt="image preview" src="../assets/global/img/no-image.png" width="40%"/>
											<div>
                                                <span class="btn red btn-outline btn-file">
                                                <span class="fileinput-new"> Pilih Gambar </span>
                                                <input type="file" name="payment" id="image-source" onchange="previewImage();" required> </span>
                                            </div>
										</div>
									</div>
							    </div>
							</div>
							
							<?php
							}
							?>
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
	function order_item_selling_agen_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-basket font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Penjualan Barang
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=item-selling-agen&execute=order-item-selling-agen" class="horizontal-form" id="form_sample_3" method="post">
						<?php
							$item_selling_query = mysql_query("SELECT a.item_selling_id, a.item_selling_date, b.reseller_name FROM item_selling a, reseller b WHERE a.item_selling_id = '".$_GET['item_selling_id']."' AND a.reseller_id = b.reseller_id");
							$item_selling_fetch_array = mysql_fetch_array($item_selling_query);

							$item_selling_date = indonesia_datetime_format($item_selling_fetch_array['item_selling_date']);
						?>
							<input class="form-control" name="item_selling_id" type="hidden" value="<?php echo $item_selling_fetch_array['item_selling_id']; ?>">
							<div class="form-body">
								<h4 class="form-section">
									Informasi Agen
								</h4>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Tgl. Penjualan
											</label>
											<input class="form-control" disabled type="text" value="<?php echo $item_selling_date; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Agen
											</label>
											<input class="form-control" disabled type="text" value="<?php echo $item_selling_fetch_array['reseller_name']; ?>">
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
											
												<select class="form-control select2me" data-error-container="#item_id" data-placeholder="Barang" name="item_id">
													<?php
														$item_query = mysql_query("SELECT * FROM item a, reseller b, reseller_item_sell c WHERE a.item_id = c.item_id AND b.reseller_id = c.reseller_id AND b.user_id = '".$_SESSION['user_id']."' AND a.item_active = '1' AND reseller_item_sell_active = '1'");
														while ($item_fetch_array = mysql_fetch_array($item_query))
														{	
														    $cek_barang = mysql_query("SELECT * FROM order_item_selling WHERE item_id = '".$item_fetch_array['item_id']."' AND item_selling_id = '".$_GET['item_selling_id']."'");
													        $jml_cek_barang = mysql_num_rows($cek_barang);
													?>
																
																<option value=""></option>
																<?php
																    if($jml_cek_barang > 0){}else{
																?>
																<option value="<?php echo $item_fetch_array['item_id']; ?>"><?php echo $item_fetch_array['item_name']; ?></option>
																<?php
																    }
																?>
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
									$order_item_selling_query = mysql_query("SELECT item_selling_id FROM order_item_selling WHERE item_selling_id = '".$item_selling_fetch_array['item_selling_id']."' AND order_item_selling_active = '1'");
									$order_item_selling_num_rows = mysql_num_rows($order_item_selling_query);

									if ($order_item_selling_num_rows > 0)
									{
								?>
										&nbsp;
										<button class="btn green btn-outline" onclick="location.href='?connect=item-selling-agen'" type="button">
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
									<button class="btn blue btn-outline" onclick="location.href='?connect=item-selling-agen&execute=cancel-order-item-selling-agen&item_selling_id=<?php echo $item_selling_fetch_array['item_selling_id']; ?>'" type="button">
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
								$order_item_selling_query = mysql_query("SELECT * FROM order_item_selling a, item b, item_price c WHERE a.item_selling_id = '".$item_selling_fetch_array['item_selling_id']."' AND a.item_id = b.item_id AND a.item_price_id = c.item_price_id AND c.item_price_active = '1' AND order_item_selling_active = '1'");
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
											<button class="btn blue btn-outline" onclick="location.href='?connect=item-selling-agen&execute=delete-order-item-selling-agen&order_item_selling_id=<?php echo $order_item_selling_fetch_array['order_item_selling_id']; ?>&item_selling_id=<?php echo $order_item_selling_fetch_array['item_selling_id']; ?>'" type="button">
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
	function edit_item_selling_agen_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-basket font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Penjualan Barang
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=item-selling-agen&execute=edit-item-selling-agen" class="horizontal-form" id="form_sample_3" method="post">
						<?php
							$item_selling_query = mysql_query("SELECT * FROM item_selling WHERE item_selling_id = '".$_GET['item_selling_id']."'");
							$item_selling_fetch_array = mysql_fetch_array($item_selling_query);

							$item_selling_date = explode("-", $item_selling_fetch_array['item_selling_date']);
							$date = $item_selling_date[2];
							$month = $item_selling_date[1];
							$year = $item_selling_date[0];
							$item_selling_date = date("d-m-Y", mktime(0, 0, 0, $month, $date, $year));
						?>
							<input class="form-control" name="item_selling_id" type="hidden" value="<?php echo $item_selling_fetch_array['item_selling_id']; ?>">
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Tgl. Penjualan
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="item_selling_date" placeholder="Tgl. Penjualan" type="text" value="<?php echo $item_selling_date; ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Order 
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#order_id" data-placeholder="Order" name="order_via_id">
												<?php
													$order_via = mysql_query("SELECT * FROM order_via WHERE order_via_active = '1'");
													while($data_order_via = mysql_fetch_array($order_via))
													{
														if($data_order_via['order_via_id'] == $item_selling_fetch_array['order_via_id'])
														{
												?>
															<option value="<?php echo $data_order_via['order_via_id'] ?>" selected><?php echo $data_order_via['order_via_name'] ?></option>
														
													<?php
														}
														else
														{
													?>
															<option value="<?php echo $data_order_via['order_via_id'] ?>"><?php echo $data_order_via['order_via_name'] ?></option>
													<?php
														}
													?>
													
												<?php
													}
												?>
											</select>
											<div id="reseller_id"></div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Pembeli 
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#customer_id" data-placeholder="Pembeli" name="customer_id" id="customer_id" >
												<?php
													$customer = mysql_query("SELECT * FROM customer WHERE customer_active = '1'");
													while($data_customer = mysql_fetch_array($customer))
													{
														if($data_customer['customer_id'] == $item_selling_fetch_array['customer_id'])
														{
												?>
															<option value="<?php echo $data_customer['customer_id'] ?>" selected><?php echo $data_customer['customer_code'] ?> - <?php echo $data_customer['customer_name'] ?></option>
														
													<?php
														}
														else
														{
													?>
													
															<option value="<?php echo $data_customer['customer_id'] ?>"><?php echo $data_customer['customer_code'] ?> - <?php echo $data_customer['customer_name'] ?></option>
												<?php
														}
													}
												?>
											</select>
											<div id="reseller_id"></div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Promo 
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#promo_id" data-placeholder="Promo" name="promo_id" id="promo_id" >
												<?php
													$tgl_skrg = date('Y-m-d');
													$promo = mysql_query("SELECT * FROM promo WHERE promo_active = '1' AND '".$tgl_skrg."' BETWEEN promo_from_date AND promo_to_date");
													while($data_promo = mysql_fetch_array($promo))
													{
														if($item_selling_fetch_array['promo_id'] == $data_promo['promo_id'])
														{
												?>
														
														<option value="<?php echo $data_promo['promo_id'] ?>" selected><?php echo $data_promo['promo_name'] ?> - <?php echo $data_promo['promo_value'] ?>%</option>
												<?php
														}
														else
														{
												?>
														<option value="<?php echo $data_promo['promo_id'] ?>"><?php echo $data_promo['promo_name'] ?> - <?php echo $data_promo['promo_value'] ?>%</option>
												<?php
														}
													}
												?>
											</select>
											<div id="promo_id"></div>
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
	function edit_delivery_agen_platform()
	{
		$item_selling = mysql_fetch_array(mysql_query("SELECT * FROM item_selling a, customer b WHERE a.customer_id = b.customer_id AND a.item_selling_id = '".$_GET['item_selling_id']."'"));

		$item_selling_delivery = mysql_fetch_array(mysql_query("SELECT * FROM item_selling_delivery WHERE item_selling_id = '".$item_selling['item_selling_id']."'"));
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-basket font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Penjualan 
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=item-selling-agen&execute=edit-delivery-agen" class="horizontal-form" id="form_sample_3" method="post" enctype="multipart/form-data">
						<input type="hidden" name="item_selling_id" value="<?php echo $item_selling['item_selling_id'] ?>">
						<input type="hidden" name="item_selling_delivery_id" value="<?php echo $item_selling_delivery['item_selling_delivery_id'] ?>">
						<?php
							$order_via = mysql_fetch_array(mysql_query("SELECT * FROM order_via WHERE order_via_id = '".$item_selling['order_via_id']."'"));
							if($order_via['order_via_name'] == "Whatsapp")
							{
						?>
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Alamat Pengiriman
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="delivery_address" placeholder="Alamat Pengiriman" type="text" value="<?php echo $item_selling['customer_address'] ?>, <?php echo $item_selling['customer_village'] ?> - <?php echo $item_selling['customer_districts'] ?> - <?php echo $item_selling['customer_city'] ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Bukti Pembayaran
												<span class="required">
													*
												</span>
											</label></br>
											<img id="image-preview" alt="image preview" src="../assets/global/img/no-image.png" width="40%"/>
											<div>
                                                <span class="btn red btn-outline btn-file">
                                                <span class="fileinput-new"> Pilih Gambar </span>
                                                <input type="file" name="payment" id="image-source" onchange="previewImage();"> </span>
                                            </div>
										</div>
									</div>
								</div>
							</div>
						<?php
							}
							else
							{
						?>
							<div class="form-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Alamat Pengiriman
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="delivery_address" placeholder="Alamat Pengiriman" type="text" value="<?php echo $item_selling['customer_address'] ?>, <?php echo $item_selling['customer_village'] ?> - <?php echo $item_selling['customer_districts'] ?> - <?php echo $item_selling['customer_city'] ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Jasa Pengiriman
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#delivery_service_id" data-placeholder="Jasa Pengiriman" name="delivery_service_id">
													<?php
														$delivery_service_query = mysql_query("SELECT * FROM delivery_service WHERE delivery_service_active = '1'");
														while ($delivery_service_fetch_array = mysql_fetch_array($delivery_service_query))
														{	
															if($delivery_service_fetch_array['delivery_service_id'] == $item_selling_delivery['delivery_service_id'])
															{
													?>
																<option value="<?php echo $delivery_service_fetch_array['delivery_service_id']; ?>" selected><?php echo $delivery_service_fetch_array['delivery_service_name']; ?></option>
													<?php
															}
															else
															{
													?>
																<option value="<?php echo $delivery_service_fetch_array['delivery_service_id']; ?>"><?php echo $delivery_service_fetch_array['delivery_service_name']; ?></option>
													<?php
															}
														}
													?>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												JOB / Resi
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="no_resi" placeholder="JOB / Resi" type="text" value="<?php echo $item_selling_delivery['no_resi'] ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Biaya Pengiriman
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="delivery_cost" placeholder="Biaya Pengiriman" type="text" value="<?php echo $item_selling_delivery['delivery_cost'] ?>">
										</div>
									</div>
								</div>
								<div class="row">
							        <div class="col-md-6">
										<div class="form-group">
											<label>
												Bukti Pembayaran
												<span class="required">
													*
												</span>
											</label></br>
											<img id="image-preview" alt="image preview" src="../assets/global/img/no-image.png" width="40%"/>
											<div>
                                                <span class="btn red btn-outline btn-file">
                                                <span class="fileinput-new"> Pilih Gambar </span>
                                                <input type="file" name="payment" id="image-source" onchange="previewImage();"> </span>
                                            </div>
										</div>
									</div>
							    </div>
							</div>
							
							<?php
							}
							?>
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
	function delivery_label_agen_platform()
	{
	    $company = mysql_fetch_array(mysql_query("SELECT * FROM company WHERE company_active = '1'"));
	    
	    $reseller = mysql_fetch_array(mysql_query("SELECT * FROM item_selling a, reseller b WHERE a.reseller_id = b.reseller_id AND item_selling_id = '".$_GET['item_selling_id']."'"));
?>
		<style type="text/css" media="print">
		@page 
		{
			size: auto;   /* auto is the initial value */
			margin: 0mm;  /* this affects the margin in the printer settings */
		}
	</style>
                       
                        <div class="invoice">
                            <div class="row invoice-logo">
                                <div class="col-xs-6 invoice-logo-space">
                                    <img src="../assets/pages/media/invoice/walmart.png" class="img-responsive" alt="" /> </div>
                                <div class="col-xs-6">
                                    <h3> #<?php echo $no_invoice ?> / <?php echo indonesia_date_format($tgl_skrg) ?>
                                    </h3>
                                </div>
                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-xs-12">
                                    
                                    
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-xs-6">
                                    <h3>Pengirim</h3>
                                    <ul class="list-unstyled">
                                        <li> Nama : <strong><?php echo $company['company_name'] ?></strong></li>
										<li> Nomor Telp : <strong><?php echo $company['company_phone'] ?></strong></li>
                                        <li> Alamat : <strong><?php echo $company['company_address'] ?>, <?php echo $company['company_village'] ?>  - <?php echo $company['company_districts'] ?> - <?php echo $company['company_city'] ?></strong></li>
                                        
                                    </ul>
                                </div>
                                <div class="col-xs-6 invoice-payment">
                                    <h3>Penerima</h3>
                                    <ul class="list-unstyled">
                                        <li>
                                            Nama : <strong> <?php echo $reseller['reseller_name'] ?> </strong></li>
                                        <li>
                                            Nomor Telp : <strong><?php echo $reseller['reseller_phone'] ?></strong> </li>
                                        <li>
											Alamat : <strong><?php echo $reseller['reseller_address'] ?> - <?php echo $reseller['reseller_village'] ?>- <?php echo $reseller['reseller_districts'] ?> - <?php echo $reseller['reseller_city'] ?></strong> </li>
                                    </ul>
                                </div>
                            </div>
                            
							<br/>
                            <div class="row">
                                <div class="col-xs-6">
                                    
                                </div>
                                <div class="col-xs-6 invoice-block">
                                    <ul class="list-unstyled amounts">
                                        <li>
                                            <h5>Estimasi Ongkos Kirim : <strong> Rp <?php echo currency_format($total_commission) ?> </strong></h5>
										</li>
                                       
                                    </ul>
                                    <br/>
                                    <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();"> Print
                                        <i class="fa fa-print"></i>
                                    </a>
                                    <a href="?connect=report-agent" class="btn btn-lg green hidden-print margin-bottom-5"> Batal
                                        <i class="fa fa-close"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
<?php
	}
?>