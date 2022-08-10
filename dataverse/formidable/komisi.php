<?php
	function default_komisi_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-layers font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Komisi
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
							
								$reseller_query = mysql_query("SELECT * FROM reseller a, user b, user_category c WHERE a.user_id = b.user_id AND b.user_category_id = c.user_category_id AND a.reseller_active = '1' AND c.user_category_name = 'Agen'");
								
								
								while($reseller_fetch_array = mysql_fetch_array($reseller_query))
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
											<a class="btn blue btn-outline" href="?connect=komisi&execute=list-month-komisi-platform&reseller_id=<?php echo $reseller_fetch_array['reseller_id']; ?>">
												<i class="icon-note"></i>
													Detail
											</a>
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
	function list_month_komisi_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-present font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Komisi
							</span>
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
										Bulan
									</th>
									<th>
										Status
									</th>
									<th>
										
									</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$item_selling_query = mysql_query("SELECT month(a.item_selling_date) as item_selling_date, a.reseller_id FROM item_selling a, reseller b WHERE a.reseller_id = b.reseller_id AND a.reseller_id = '".$_GET['reseller_id']."' AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses' GROUP BY month(a.item_selling_date)");
								while ($item_selling_fetch_array = mysql_fetch_array($item_selling_query))
								{
									$cek_invoice = mysql_num_rows(mysql_query("SELECT * FROM invoice WHERE invoice_active = '1' AND reseller_id = '".$_GET['reseller_id']."' AND month = '".$item_selling_fetch_array['item_selling_date']."'"));
									
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php 
												if($item_selling_fetch_array['item_selling_date'] == "1")
												{
													echo "januari";
												} 
												else if($item_selling_fetch_array['item_selling_date'] == "2")
												{
													echo "februari";
												} 
												else if($item_selling_fetch_array['item_selling_date'] == "3")
												{
													echo "maret";
												} 
												else if($item_selling_fetch_array['item_selling_date'] == "4")
												{
													echo "april";
												} 
												else if($item_selling_fetch_array['item_selling_date'] == "5")
												{
													echo "mei";
												} 
												else if($item_selling_fetch_array['item_selling_date'] == "6")
												{
													echo "juni";
												} 
												else if($item_selling_fetch_array['item_selling_date'] == "7")
												{
													echo "juli";
												} 
												else if($item_selling_fetch_array['item_selling_date'] == "8")
												{
													echo "agustus";
												} 
												else if($item_selling_fetch_array['item_selling_date'] == "9")
												{
													echo "september";
												} 
												else if($item_selling_fetch_array['item_selling_date'] == "10")
												{
													echo "oktober";
												} 
												else if($item_selling_fetch_array['item_selling_date'] == "11")
												{
													echo "november";
												} 
												else if($item_selling_fetch_array['item_selling_date'] == "12")
												{
													echo "desember";
												} 

											?>
										</td>
										<td>
												<?php
													if($cek_invoice >0)
													{
												?>
														<span class="label label-sm label-success"> Lunas </span>
												<?php
													}
													else
													{
												?>
														<span class="label label-sm label-danger"> Belum Lunas </span>
														
												<?php
													}
												?>
										</td>
										<td>
										<?php
											if($cek_invoice >0)
											{
										?>
											<a class="btn blue btn-outline" href="?connect=komisi&execute=invoice-platform&reseller_id=<?php echo $item_selling_fetch_array['reseller_id'] ?>&month=<?php echo  $item_selling_fetch_array['item_selling_date'] ?>">
												<i class="icon-note"></i>
													Detail
											</a>
										<?php
											}
											else
											{
										?>
											<a class="btn blue btn-outline" href="?connect=komisi&execute=add-komisi-platform&reseller_id=<?php echo $item_selling_fetch_array['reseller_id'] ?>&month=<?php echo  $item_selling_fetch_array['item_selling_date'] ?>">
												<i class="icon-note"></i>
													Detail
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
					<div class="portlet-body form">
						<form action="?connect=komisi-agen&execute=add-komisi-agen" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-actions right">
							
								<button class="btn red btn-outline" onclick="history.back()" type="button">
									<i class="icon-check"></i>
									Kembali
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

<?php
	}
	function invoice_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-diamond font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Komisi
							</span>
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
										Agen
									</th>
									<th>
										Nomor Invoice
									</th>
									<th>
										Tanggal penjualan
									</th>
									<th>
										Total Komisi
									</th>
									<th>
										Reward
									</th>
									<th>
										Status
									</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$invoice_query = mysql_query("SELECT * FROM invoice a, reseller b WHERE a.reseller_id = b.reseller_id AND a.invoice_active = '1' AND a.reseller_id = '".$_GET['reseller_id']."' AND a.month = '".$_GET['month']."'");
								while ($invoice_fetch_array = mysql_fetch_array($invoice_query))
								{
									
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo indonesia_date_format($invoice_fetch_array['invoice_date']) ?>
										</td>
										<td>
											<?php echo $invoice_fetch_array['reseller_code'] ?> | <?php echo $invoice_fetch_array['reseller_name'] ?> 
										</td>
										<td>
											<?php echo $invoice_fetch_array['no_invoice'] ?> 
										</td>
										<td>
											<?php echo indonesia_date_format($invoice_fetch_array['selling_date_from']) ?> Sampai <?php echo indonesia_date_format($invoice_fetch_array['selling_date_to']) ?> 
										</td>
										<td>
											Rp <?php echo currency_format($invoice_fetch_array['commission']) ?>
										</td>
										<td>
											Rp <?php echo currency_format($invoice_fetch_array['reward']) ?>
										</td>
										<td>
												<?php
													if($invoice_fetch_array['invoice_status'] == "Pending")
													{
												?>
														<span class="label label-sm label-danger"> <?php echo $invoice_fetch_array['invoice_status'] ?> </span>
												<?php
													}
													else
													{
												?>
														<span class="label label-sm label-success"> <?php echo $invoice_fetch_array['invoice_status'] ?> </span>
												<?php
													}
												?>
										</td>
										<td>
										<?php
											if($invoice_fetch_array['invoice_status'] == 'Pending')
											{
										?>
											<a class="btn purple btn-outline" href="?connect=komisi&execute=add-komisi-platform&invoice_id=<?php echo $invoice_fetch_array['invoice_id']; ?>">
															<i class="fa fa-paper-plane-o"></i>
															Proses
											</a>
											<a class="btn purple btn-outline" target="_BLANK" href="printable/komisi-agen.php?invoice_id=<?php echo $invoice_fetch_array['invoice_id'] ?>">
												<i class="fa fa-print"></i>
													Cetak
											</a>
										<?php
											}
											else
											{
										?>
											<a class="btn purple btn-outline" target="_BLANK" href="printable/komisi.php?invoice_id=<?php echo $invoice_fetch_array['invoice_id'] ?>">
												<i class="fa fa-print"></i>
													Cetak
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
					<div class="portlet-body form">
						<form action="?connect=komisi-agen&execute=add-komisi-agen" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-actions right">
							
								<button class="btn red btn-outline" onclick="history.back()" type="button">
									<i class="icon-check"></i>
									Kembali
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>


<?php
	}
	function add_komisi_platform()
	{

		//$reseller = mysql_fetch_array(mysql_query("SELECT * FROM invoice a, reseller b, bank c WHERE a.reseller_id = b.reseller_id AND a.invoice_id = '".$_GET['invoice_id']."' AND b.bank_id = c.bank_id"));

		$reseller = mysql_fetch_array(mysql_query("SELECT * FROM reseller a, bank b WHERE a.reseller_id = '".$_GET['reseller_id']."' AND a.bank_id = b.bank_id"));
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-diamond font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Komisi
							</span>
						</div>
					</div>
					<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover order-column" id="">
							
							<tbody>
								<tr>
									<td width="10%">Kode Agen</td>
									<td><?php echo $reseller['reseller_code'] ?></td>
								</tr>
								<tr>
									<td width="10%">Nama Agen</td>
									<td><?php echo $reseller['reseller_name'] ?></td>
								</tr>
								<tr>
									<td width="10%">Alamat</td>
									<td><?php echo $reseller['reseller_address'] ?>, <?php echo $reseller['reseller_village'] ?> - <?php echo $reseller['reseller_districts'] ?> - <?php echo $reseller['reseller_city'] ?></td>
								</tr>
								<tr>
									<td width="10%">No Telepon</td>
									<td><?php echo $reseller['reseller_phone'] ?></td>
								</tr>
								<tr>
									<td width="10%">Bank</td>
									<td><?php echo $reseller['bank_name'] ?> ( <?php echo $reseller['reseller_account_number'] ?> / <?php echo $reseller['reseller_account_name'] ?> )</td>
								</tr>
							</tbody>
						</table>
					</div>
					
					<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover order-column" id="">
							<thead>
								<tr>
									<th>
										No
									</th>
									<th>
										Nomor Penjualan
									</th>
									<th>
										Tanggal Penjualan
									</th>
									<th>
										Jumlah Komisi (Jumlah barang * Komisi barang)
									</th>
									<th>
										Total Komisi
									</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$number = 1;
								$total_quantity = 0;
								$total_komisi = 0;
								$jml_invoice = 0;
								
								$item_selling_query = mysql_query("SELECT * FROM item_selling a, reseller b WHERE a.reseller_id = b.reseller_id AND a.reseller_id = '".$_GET['reseller_id']."' AND a.item_selling_status = 'Sudah Diproses' AND a.invoice_status = 'Belum Cair' AND a.item_selling_active = '1' AND month(a.item_selling_date) = '".$_GET['month']."'");
								$jml_item_selling_query = mysql_num_rows($item_selling_query);
								while ($item_selling_fetch_array = mysql_fetch_array($item_selling_query))
								{
									$cek_invoice = mysql_num_rows(mysql_query("SELECT * FROM invoice_detail a, invoice b WHERE a.invoice_id = b.invoice_id AND b.invoice_active = '1' AND a.item_selling_id = '".$item_selling_fetch_array['item_selling_id']."' AND a.invoice_detail_active = '1'"));
							        if($cek_invoice > 0){}else{
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $item_selling_fetch_array['item_selling_code']; ?>
										</td>
										<td>
											<?php echo indonesia_date_format($item_selling_fetch_array['item_selling_date']); ?>
										</td>
										<td>
										    <?php
										        $komisi = 0;
										        $order_item_selling = mysql_query("SELECT * FROM order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling_fetch_array['item_selling_id']."' AND a.order_item_selling_active = '1'");
										        while($data_order_item_selling = mysql_fetch_array($order_item_selling))
										        {
										            if($komisi == 0)
										            {
										                $komisi = $data_order_item_selling['order_item_selling_quantity']*$data_order_item_selling['item_commission_value'];
										            }
										            else
										            {
										                $komisi = $komisi+$data_order_item_selling['order_item_selling_quantity']*$data_order_item_selling['item_commission_value'];
										            }
										            
										            if($total_quantity == 0)
										            {
										                $total_quantity = $data_order_item_selling['order_item_selling_quantity'];
										            }
										            else
										            {
										                $total_quantity = $total_quantity+$data_order_item_selling['order_item_selling_quantity'];
										            }
										            
										            echo "(".$data_order_item_selling['order_item_selling_quantity'].') '.$data_order_item_selling['item_name'].' x '.currency_format($data_order_item_selling['item_commission_value']);
										            echo "<br>";
										        }
										    ?>
											
										</td>
										<td>
											<?php echo currency_format($komisi) ?>
										</td>
									</tr>
							<?php   
							        if($total_komisi == 0)
							        {
							            $total_komisi = $komisi;
							        }
							        else
							        {
							            $total_komisi = $total_komisi+$komisi;
							        }
							    $number++;
							        }
								
								}
							?>
									<tr>
										<td colspan="3" align="center">Reward</td>
										<td><?php echo $total_quantity; ?></td>
										<td>
											<?php
											    $total_reward = 0;
												$reward = mysql_fetch_array(mysql_query("SELECT * FROM reward WHERE reward_active = '1'"));
                                                if($total_quantity >= $reward['selling_quantity'])
                                                {
                                                    $total_reward = (round($total_quantity/$reward['selling_quantity']))* $reward['reward_value'];
                                                }
												
											?>
											<?php echo currency_format($total_reward) ?>
										</td>
										
									</tr>
									<tr>
										<td colspan="4" align="center">Total</td>
										<td>
											<?php $subtotal = $total_reward + $total_komisi; ?>
											<?php echo currency_format($total_reward + $total_komisi) ?>
										</td>
										
									</tr>

							</tbody>
						</table>
					</div>
					<div class="portlet-body form">
						<form action="?connect=komisi&execute=add-komisi-transfer-platform&reseller_id=<?php echo $_GET['reseller_id'] ?>&month=<?php echo $_GET['month'] ?>&total=<?php echo $subtotal ?>" class="horizontal-form" id="form_sample_3" method="post">
							<div class="form-actions right">
								<button class="btn blue btn-outline" type="submit">
									<i class="icon-check"></i>
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
	function add_komisi_transfer_platform()
	{
        //$invoice = mysql_fetch_array(mysql_query("SELECT * FROM invoice a, reseller b WHERE a.reseller_id = b.reseller_id AND a.invoice_id = '".$_GET['invoice_id']."'"));

        $reseller = mysql_fetch_array(mysql_query("SELECT * FROM reseller a, bank b WHERE a.reseller_id = '".$_GET['reseller_id']."' AND a.bank_id = b.bank_id"));
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-diamond font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Komisi
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=komisi&execute=add-transfer-komisi" class="horizontal-form" id="form_sample_3" method="post" enctype="multipart/form-data">
							<input type="hidden" name="reseller_id" value="<?php echo $_GET['reseller_id'] ?>" >
							<input type="hidden" name="month" value="<?php echo $_GET['month'] ?>" >
							<input type="hidden" name="total" value="<?php echo $_GET['total'] ?>" >
							<div class="form-body">
								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Tgl. Transfer
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="invoice_transfer_date" placeholder="Tgl. Transfer" type="text">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Bank
												<span class="required">
													*
												</span>
											</label>
											<select name="bank_id" class="form-control">
													<?php
														$bank_query = mysql_query("SELECT * FROM bank WHERE bank_active = '1'");
														while($bank_fetch_array = mysql_fetch_array($bank_query))
														{
														    if($bank_fetch_array['bank_id'] == $reseller['bank_id']){
													?>
															<option value="<?php echo $bank_fetch_array['bank_id'] ?>" selected><?php echo $bank_fetch_array['bank_name'] ?></option>
													<?php
														    } else {
													?>
													        <option value="<?php echo $bank_fetch_array['bank_id'] ?>"><?php echo $bank_fetch_array['bank_name'] ?></option>
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
												Nomor Rekening
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="no_rekening" placeholder="Nomor Rekening" type="text" value="<?php echo $reseller['reseller_account_number'] ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Nama Rekening
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="rekening_name" placeholder="Nama Rekening" type="text" value="<?php echo $reseller['reseller_account_name'] ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Jumlah Transfer
												<span class="required">
													*
												</span>
											</label>
											<input autocomplete="off" class="form-control" name="jumlah_transfer" placeholder="Jumlah Transfer" type="text" value="<?php echo $_GET['total'] ?>">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>
												Bukti Transfer
												<span class="required">
													*
												</span>
											</label></br>
											<img id="image-preview" alt="image preview" src="../assets/global/img/no-image.png" width="40%"/>
											<div>
                                                <span class="btn red btn-outline btn-file">
                                                <span class="fileinput-new"> Pilih Gambar </span>
                                                <input type="file" name="bukti_transfer" id="image-source" onchange="previewImage();"> </span>
                                            </div>
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
?>