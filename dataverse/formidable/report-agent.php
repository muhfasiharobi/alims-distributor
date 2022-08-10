<?php
	function default_report_agent_by_product_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-basket font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Komisi Penjualan
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=report-agent&execute=form-report-selling-agent" class="horizontal-form" id="form_sample_3" method="post">
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
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="selling_commission_from_date" placeholder="Tgl. Penjualan" type="text">
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
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="selling_commission_to_date" placeholder="Tgl. Penjualan" type="text">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>
												Agen
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#reseller_id" data-placeholder="Agen" name="reseller_id">
											<?php
												$reseller_query = mysql_query("SELECT reseller_id, reseller_name FROM reseller WHERE reseller_active = '1' ORDER BY reseller_name");
												while ($reseller_fetch_array = mysql_fetch_array($reseller_query))
												{
											?>
													<option value=""></option>
													<option value="<?php echo $reseller_fetch_array['reseller_id']; ?>"><?php echo $reseller_fetch_array['reseller_name']; ?></option>
											<?php
												}
											?>
											</select>
											<div id="reseller_id"></div>
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
	function form_report_selling_agent()
	{
?>	
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-basket font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Komisi Penjualan
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=report-agent&execute=form-report-selling-agent" class="horizontal-form" id="form_sample_3" method="post">
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
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="selling_commission_from_date" placeholder="Tgl. Penjualan" type="text" value="<?php echo $_POST['selling_commission_from_date'] ?>">
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
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="selling_commission_to_date" placeholder="Tgl. Penjualan" type="text" value="<?php echo $_POST['selling_commission_to_date'] ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>
												Agen
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#reseller_id" data-placeholder="Agen" name="reseller_id">
											<?php
												$reseller_query = mysql_query("SELECT reseller_id, reseller_name FROM reseller WHERE reseller_active = '1' ORDER BY reseller_name");
												while ($reseller_fetch_array = mysql_fetch_array($reseller_query))
												{
													if($reseller_fetch_array['reseller_id'] == $_POST['reseller_id'])
													{
											?>
														
														<option value="<?php echo $reseller_fetch_array['reseller_id']; ?>" selected><?php echo $reseller_fetch_array['reseller_name']; ?></option>
													
												<?php
													}
													else
													{
												?>
														<option></option>
														<option value="<?php echo $reseller_fetch_array['reseller_id']; ?>"><?php echo $reseller_fetch_array['reseller_name']; ?></option>
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
										Jumlah Terjual
									</th>
									<th>
										
									</th>
									<th>
										Komisi
									</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$item_selling_from_date = explode("-", $_POST['selling_commission_from_date']);
								$date = $item_selling_from_date[0];
								$month = $item_selling_from_date[1];
								$year = $item_selling_from_date[2];
								$item_selling_from_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
								
								$item_selling_to_date = explode("-", $_POST['selling_commission_to_date']);
								$date = $item_selling_to_date[0];
								$month = $item_selling_to_date[1];
								$year = $item_selling_to_date[2];
								$item_selling_to_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
							
								$number = 1;
								$order_item_selling_query = mysql_query("SELECT *, SUM(b.order_item_selling_quantity) as sum_order_item_selling_quantity FROM item_selling a, order_item_selling b, item c WHERE a.item_selling_status = 'On Hold' AND a.reseller_id = '".$_POST['reseller_id']."' AND a.item_selling_id = b.item_selling_id AND b.item_id = c.item_id AND a.item_selling_date BETWEEN '".$item_selling_from_date."' AND '".$item_selling_to_date."' GROUP BY b.item_id");
								while ($order_item_selling_fetch_array = mysql_fetch_array($order_item_selling_query))
								{
									$item_commission = mysql_fetch_array(mysql_query("SELECT * FROM item_commission WHERE item_id = '".$order_item_selling_fetch_array['item_id']."' AND minimal_selling <= '".$order_item_selling_fetch_array['sum_order_item_selling_quantity']."' AND maximal_selling >= '".$order_item_selling_fetch_array['sum_order_item_selling_quantity']."'"));
									
									$item_commission = $item_commission['item_commission_value'];
									
									$total_qty = $order_item_selling_fetch_array['sum_order_item_selling_quantity'];
							?>
									
									
											<tr>
												<td>
													<?php echo $number; ?>
												</td>
												<td>
													<?php echo $order_item_selling_fetch_array['item_name']; ?>
												</td>
												<td>
													<?php echo $order_item_selling_fetch_array['sum_order_item_selling_quantity']; ?>
												</td>
												<td>
													<div class="portlet box green">
														<div class="portlet-title">
															<div class="caption">
																Detail </div>
															<div class="tools">
																<a href="javascript:;" class="expand"> </a>
															</div>
														</div>
														<div class="portlet-body portlet-collapsed">
															<table class="table table-striped table-bordered table-hover order-column" id="sample_1">
																<thead>
																	<tr>
																		<th>
																			No
																		</th>
																		<th>
																			Tanggal
																		</th>
																		<th>
																			Jumlah
																		</th>
																	</tr>
																</thead>
																<tbody>
																<?php
																	$no = 1;
																	$order_detail_query = mysql_query("SELECT * FROM item_selling a, order_item_selling b WHERE a.reseller_id = '".$_POST['reseller_id']."' AND a.item_selling_id = b.item_selling_id AND b.item_id = '".$order_item_selling_fetch_array['item_id']."'");
																	while($order_detail_fetch_array = mysql_fetch_array($order_detail_query))
																	{
																?>
																		<tr>
																			<td><?php echo $no ?></td>
																			<td><?php echo indonesia_date_format($order_detail_fetch_array['item_selling_date']) ?></td>
																			<td><?php echo indonesia_date_format($order_detail_fetch_array['order_item_selling_quantity']) ?></td>
																		</tr>
																<?php
																		$no++;
																	}
																?>
																</tbody>
															</table>
														</div>
													</div>
												</td>
												<td>
													<?php echo currency_format($item_commission); ?>
												</td>
												
											</tr>
											
									
							<?php
									$number++;
								}
							?>
							</tbody>
						</table>
					    <?php
					        if($item_commission != "")
					        {
					    ?>
							<div class="form-actions right">
								<a href="?connect=report-agent&execute=insert-invoice-report-agent-by-product&from=<?php echo $_POST['selling_commission_from_date'] ?>&to=<?php echo $_POST['selling_commission_to_date'] ?>&reseller=<?php echo $_POST['reseller_id'] ?>&komisi=<?php echo $item_commission ?>&qty=<?php echo $total_qty ?>">
									<button class="btn green btn-outline" type="button">
										<i class="fa fa-print"></i>
										Proses & Cetak
									</button>
								</a>
							</div>
						<?php
					        }
						?>
					</div>
				</div>
			</div>
		</div>
											
											
											
<?php
	}
	function invoice_report_agent_by_product()
	{
		
		$reseller = mysql_fetch_array(mysql_query("SELECT * FROM reseller WHERE reseller_id = '".$_GET['reseller']."'"));
		
		$from_date = explode("-", $_GET['from']);
		$date = $from_date[0];
		$month = $from_date[1];
		$year = $from_date[2];
		$from_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
		
		$to_date = explode("-", $_GET['to']);
		$date = $to_date[0];
		$month = $to_date[1];
		$year = $to_date[2];
		$to_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
		
		$total_commission = 0;
		
		$tgl = date('d');
		$bulan = date('m');
		$tahun= substr(date('Y'),2,2);
		$tgl_skrg = date('Y-m-d');
		
		$no_invoice = $_GET['reseller'].''.$tgl.''.$bulan.''.$tahun;
?>
	<style type="text/css" media="print">
		@page 
		{
			size: auto;   /* auto is the initial value */
			margin: 0mm;  /* this affects the margin in the printer settings */
		}
	</style>
                        <h1 class="page-title"> Invoice
                        </h1>
                        <div class="invoice">
                            <div class="row invoice-logo">
                                <div class="col-xs-6 invoice-logo-space">
                                    <img src="../assets/pages/media/invoice/walmart.png" class="img-responsive" alt="" /> </div>
                                <div class="col-xs-6">
                                    <h3> #<?php echo $no_invoice ?> / <?php echo indonesia_date_format($tgl_skrg) ?>
                                    </h3>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-xs-4">
                                    <h3>Agen:</h3>
                                    <ul class="list-unstyled">
                                        <li> Nama : <strong><?php echo $reseller['reseller_name'] ?></strong></li>
										<li> Nomor Telp : <strong><?php echo $reseller['reseller_phone'] ?></strong></li>
                                        <li> Alamat : <strong><?php echo $reseller['reseller_address'] ?> - <?php echo $reseller['reseller_village'] ?> <br> <?php echo $reseller['reseller_districts'] ?> - <?php echo $reseller['reseller_city'] ?></strong></li>
                                        
                                    </ul>
                                </div>
                                <div class="col-xs-4">
                                    <h3>Keterangan:</h3>
                                    <ul class="list-unstyled">
                                        <li> <strong>Komisi Penjualan Agen </strong></li>
										<li> <strong>Dari : <?php echo indonesia_date_format($from_date) ?></strong></li>
										<li> <strong>Sampai : <?php echo indonesia_date_format($to_date) ?></strong></li>
                                    </ul>
                                </div>
                                <div class="col-xs-4 invoice-payment">
                                    <h3>Detail Pembayaran :</h3>
                                    <ul class="list-unstyled">
                                        <li>
                                            Bank :<strong> <?php echo $reseller['reseller_account_bank'] ?> </strong></li>
                                        <li>
                                            Nomor Rekening :<strong><?php echo $reseller['reseller_account_number'] ?></strong> </li>
                                        <li>
											Atas Nama :<strong><?php echo $reseller['reseller_account_name'] ?></strong> </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th> # </th>
                                                <th > Produk </th>
                                                <th> Jumlah </th>
                                                <th> Komisi </th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											$item_selling_from_date = explode("-", $_GET['from']);
											$date = $item_selling_from_date[0];
											$month = $item_selling_from_date[1];
											$year = $item_selling_from_date[2];
											$item_selling_from_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
											
											$item_selling_to_date = explode("-", $_GET['to']);
											$date = $item_selling_to_date[0];
											$month = $item_selling_to_date[1];
											$year = $item_selling_to_date[2];
											$item_selling_to_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
										
											$number = 1;
											$order_item_selling_query = mysql_query("SELECT *, SUM(b.order_item_selling_quantity) as sum_order_item_selling_quantity FROM item_selling a, order_item_selling b, item c WHERE a.reseller_id = '".$_GET['reseller']."' AND a.item_selling_id = b.item_selling_id AND b.item_id = c.item_id AND a.item_selling_date BETWEEN '".$item_selling_from_date."' AND '".$item_selling_to_date."' GROUP BY b.item_id");
											while ($order_item_selling_fetch_array = mysql_fetch_array($order_item_selling_query))
											{
												$item_commission = mysql_fetch_array(mysql_query("SELECT * FROM item_commission WHERE item_id = '".$order_item_selling_fetch_array['item_id']."' AND minimal_selling <= '".$order_item_selling_fetch_array['sum_order_item_selling_quantity']."' AND maximal_selling >= '".$order_item_selling_fetch_array['sum_order_item_selling_quantity']."'"));
												
												if($total_commission == 0)
												{
													$total_commission = $item_commission['item_commission_value'];
												}
												else
												{
													$total_commission = $total_commission + $item_commission['item_commission_value'];
												}
												
												$item_commission = currency_format($item_commission['item_commission_value']);
										?>
											
											
													<tr>
														<td>
															<?php echo $number; ?>
														</td>
														<td>
															<?php echo $order_item_selling_fetch_array['item_name']; ?>
														</td>
														<td>
															<?php echo $order_item_selling_fetch_array['sum_order_item_selling_quantity']; ?>
														</td>
														<td>
															Rp <?php echo $item_commission; ?>
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
							<br/>
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="well">
									<?php
										$company = mysql_fetch_array(mysql_query("SELECT * FROM company WHERE company_active = '1'"));
									?>
                                        <address>
                                            <strong><?php echo $company['company_name'] ?></strong>
                                            <br/> <?php echo $company['company_address'] ?>, <?php echo $company['company_village'] ?>  - <?php echo $company['company_districts'] ?> - <?php echo $company['company_city'] ?>
                                            <br/> 
                                            <abbr title="Phone"></abbr> <?php echo $company['company_phone'] ?> </address>
                                        <address>
                                            <strong>Full Name</strong>
                                            <br/>
                                            <a href="mailto:#"> <?php echo $company['company_email'] ?>  </a>
                                        </address>
                                    </div>
                                </div>
                                <div class="col-xs-8 invoice-block">
                                    <ul class="list-unstyled amounts">
                                        <li>
                                            <h5>Total Komisi: <strong> Rp <?php echo currency_format($total_commission) ?> </strong></h5>
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
	function report_agent_sum_selling()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-basket font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Komisi Penjualan
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=report-agent&execute=form-report-sum-selling" class="horizontal-form" id="form_sample_3" method="post">
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
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="selling_commission_from_date" placeholder="Tgl. Penjualan" type="text">
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
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="selling_commission_to_date" placeholder="Tgl. Penjualan" type="text">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>
												Agen
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#reseller_id" data-placeholder="Agen" name="reseller_id">
											<?php
												$reseller_query = mysql_query("SELECT reseller_id, reseller_name FROM reseller WHERE reseller_active = '1' ORDER BY reseller_name");
												while ($reseller_fetch_array = mysql_fetch_array($reseller_query))
												{
											?>
													<option value=""></option>
													<option value="<?php echo $reseller_fetch_array['reseller_id']; ?>"><?php echo $reseller_fetch_array['reseller_name']; ?></option>
											<?php
												}
											?>
											</select>
											<div id="reseller_id"></div>
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
	function form_report_sum_selling()
	{
?>	
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-basket font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Komisi Penjualan
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=report-agent&execute=form-report-sum-selling" class="horizontal-form" id="form_sample_3" method="post">
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
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="selling_commission_from_date" placeholder="Tgl. Penjualan" type="text" value="<?php echo $_POST['selling_commission_from_date'] ?>">
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
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="selling_commission_to_date" placeholder="Tgl. Penjualan" type="text" value="<?php echo $_POST['selling_commission_to_date'] ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label>
												Agen
												<span class="required">
													*
												</span>
											</label>
											<select class="form-control select2me" data-error-container="#reseller_id" data-placeholder="Agen" name="reseller_id">
											<?php
												$reseller_query = mysql_query("SELECT reseller_id, reseller_name FROM reseller WHERE reseller_active = '1' ORDER BY reseller_name");
												while ($reseller_fetch_array = mysql_fetch_array($reseller_query))
												{
													if($reseller_fetch_array['reseller_id'] == $_POST['reseller_id'])
													{
											?>
														
														<option value="<?php echo $reseller_fetch_array['reseller_id']; ?>" selected><?php echo $reseller_fetch_array['reseller_name']; ?></option>
													
												<?php
													}
													else
													{
												?>
														<option></option>
														<option value="<?php echo $reseller_fetch_array['reseller_id']; ?>"><?php echo $reseller_fetch_array['reseller_name']; ?></option>
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
					<div class="portlet-body">
						<table class="table table-striped table-bordered table-hover order-column" id="sample_1">
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
										Jumlah
									</th>
									<th>
										Harga
									</th>
									<th>
										Total
									</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$item_selling_from_date = explode("-", $_POST['selling_commission_from_date']);
								$date = $item_selling_from_date[0];
								$month = $item_selling_from_date[1];
								$year = $item_selling_from_date[2];
								$item_selling_from_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
								
								$item_selling_to_date = explode("-", $_POST['selling_commission_to_date']);
								$date = $item_selling_to_date[0];
								$month = $item_selling_to_date[1];
								$year = $item_selling_to_date[2];
								$item_selling_to_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
							
								$number = 1;
								$sum_selling = 0;
								$order_item_selling_query = mysql_query("SELECT * FROM item_selling a, order_item_selling b, item c, item_price d WHERE a.item_selling_id = b.item_selling_id AND  b.item_id = c.item_id AND c.item_id = d.item_id AND d.item_price_active = '1' AND a.reseller_id = '".$_POST['reseller_id']."' AND a.item_selling_date BETWEEN '".$item_selling_from_date."' AND '".$item_selling_to_date."'");
								while ($order_item_selling_fetch_array = mysql_fetch_array($order_item_selling_query))
								{
									if($sum_selling == 0)
									{
										$sum_selling = $order_item_selling_fetch_array['order_item_selling_quantity'] * $order_item_selling_fetch_array['item_price_value'];
									}
									else
									{
										$sum_selling = $sum_selling + ($order_item_selling_fetch_array['order_item_selling_quantity'] * $order_item_selling_fetch_array['item_price_value']);
									}
							?>
									
											<tr>
												<td>
													<?php echo $number; ?>
												</td>
												<td>
													<?php echo indonesia_date_format($order_item_selling_fetch_array['item_selling_date']) ?>
												</td>
												<td>
													<?php echo $order_item_selling_fetch_array['item_name']; ?>
												</td>
												<td>
													<?php echo $order_item_selling_fetch_array['order_item_selling_quantity']; ?>
												</td>
												<td>
													<?php echo currency_format($order_item_selling_fetch_array['item_price_value']) ?>
												</td>
												<td>
													<?php echo $total = currency_format($order_item_selling_fetch_array['order_item_selling_quantity'] * $order_item_selling_fetch_array['item_price_value'])?>
												</td>
											</tr>
											
									
							<?php
									
									$number++;
								}
							?>
							               
											
							</tbody>
						</table>
							<div class="form-actions right">
								<a href="?connect=report-agent&execute=insert-invoice-report-agent-by-sum-selling&from=<?php echo $_POST['selling_commission_from_date'] ?>&to=<?php echo $_POST['selling_commission_to_date'] ?>&reseller=<?php echo $_POST['reseller_id'] ?>&total=<?php echo $sum_selling ?>&komisi=<?php echo $selling_commission['selling_commission_value'] ?>">
									<button class="btn green btn-outline" type="button">
										<i class="icon-action-print"></i>
										Proses & Cetak
									</button>
								</a>
							</div>
					</div>
				</div>
			</div>
		</div>		

<?php
	}
	function invoice_report_agent_by_sum_selling()
	{
		
		$reseller = mysql_fetch_array(mysql_query("SELECT * FROM reseller WHERE reseller_id = '".$_GET['reseller']."'"));
		
		$from_date = explode("-", $_GET['from']);
		$date = $from_date[0];
		$month = $from_date[1];
		$year = $from_date[2];
		$from_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
		
		$to_date = explode("-", $_GET['to']);
		$date = $to_date[0];
		$month = $to_date[1];
		$year = $to_date[2];
		$to_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
		
		$total_commission = 0;
		
		$tgl = date('d');
		$bulan = date('m');
		$tahun= substr(date('Y'),2,2);
		$tgl_skrg = date('Y-m-d');
		
		$no_invoice = $_GET['reseller'].''.$tgl.''.$bulan.''.$tahun;
?>
	<style type="text/css" media="print">
		@page 
		{
			size: auto;   /* auto is the initial value */
			margin: 0mm;  /* this affects the margin in the printer settings */
		}
	</style>
                        <h1 class="page-title"> Invoice
                        </h1>
                        <div class="invoice">
                            <div class="row invoice-logo">
                                <div class="col-xs-6 invoice-logo-space">
                                    <img src="../assets/pages/media/invoice/walmart.png" class="img-responsive" alt="" /> </div>
                                <div class="col-xs-6">
                                    <h3> #<?php echo $no_invoice ?> / <?php echo indonesia_date_format($tgl_skrg) ?>
                                    </h3>
                                </div>
                            </div>
                            <hr/>
                            <div class="row">
                                <div class="col-xs-4">
                                    <h3>Agen:</h3>
                                    <ul class="list-unstyled">
                                        <li> Nama : <strong><?php echo $reseller['reseller_name'] ?></strong></li>
										<li> Nomor Telp : <strong><?php echo $reseller['reseller_phone'] ?></strong></li>
                                        <li> Alamat : <strong><?php echo $reseller['reseller_address'] ?> - <?php echo $reseller['reseller_village'] ?> <br> <?php echo $reseller['reseller_districts'] ?> - <?php echo $reseller['reseller_city'] ?></strong></li>
                                        
                                    </ul>
                                </div>
                                <div class="col-xs-4">
                                    <h3>Keterangan:</h3>
                                    <ul class="list-unstyled">
                                        <li> <strong>Komisi Penjualan Agen </strong></li>
										<li> <strong>Dari : <?php echo indonesia_date_format($from_date) ?></strong></li>
										<li> <strong>Sampai : <?php echo indonesia_date_format($to_date) ?></strong></li>
                                    </ul>
                                </div>
                                <div class="col-xs-4 invoice-payment">
                                    <h3>Detail Pembayaran :</h3>
                                    <ul class="list-unstyled">
                                        <li>
                                            Bank :<strong> <?php echo $reseller['reseller_account_bank'] ?> </strong></li>
                                        <li>
                                            Nomor Rekening :<strong><?php echo $reseller['reseller_account_number'] ?></strong> </li>
                                        <li>
											Atas Nama :<strong><?php echo $reseller['reseller_account_name'] ?></strong> </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <table class="table table-striped table-hover">
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
													Jumlah
												</th>
												<th>
													Harga
												</th>
												<th>
													Total
												</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
											$item_selling_from_date = explode("-", $_GET['from']);
											$date = $item_selling_from_date[0];
											$month = $item_selling_from_date[1];
											$year = $item_selling_from_date[2];
											$item_selling_from_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
											
											$item_selling_to_date = explode("-", $_GET['to']);
											$date = $item_selling_to_date[0];
											$month = $item_selling_to_date[1];
											$year = $item_selling_to_date[2];
											$item_selling_to_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
										
											$number = 1;
											$sum_selling = 0;
											$order_item_selling_query = mysql_query("SELECT * FROM item_selling a, order_item_selling b, item c, item_price d WHERE a.item_selling_id = b.item_selling_id AND  b.item_id = c.item_id AND c.item_id = d.item_id AND d.item_price_active = '1' AND a.reseller_id = '".$_GET['reseller']."' AND a.item_selling_date BETWEEN '".$item_selling_from_date."' AND '".$item_selling_to_date."'");
											while ($order_item_selling_fetch_array = mysql_fetch_array($order_item_selling_query))
											{
												if($sum_selling == 0)
												{
													$sum_selling = $order_item_selling_fetch_array['order_item_selling_quantity'] * $order_item_selling_fetch_array['item_price_value'];
												}
												else
												{
													$sum_selling = $sum_selling + ($order_item_selling_fetch_array['order_item_selling_quantity'] * $order_item_selling_fetch_array['item_price_value']);
												}
										?>
											
											
													<tr>
														<td>
															<?php echo $number; ?>
														</td>
														<td>
															<?php echo indonesia_date_format($order_item_selling_fetch_array['item_selling_date']) ?>
														</td>
														<td>
															<?php echo $order_item_selling_fetch_array['item_name']; ?>
														</td>
														<td>
															<?php echo $order_item_selling_fetch_array['order_item_selling_quantity']; ?>
														</td>
														<td>
															<?php echo currency_format($order_item_selling_fetch_array['item_price_value']) ?>
														</td>
														<td>
															<?php echo $total = currency_format($order_item_selling_fetch_array['order_item_selling_quantity'] * $order_item_selling_fetch_array['item_price_value'])?>
														</td>
													</tr>
										
											
                                        <?php
												$number++;
											}
										?>
													<tr>
														<td colspan="5" align="center">
															<strong>Total</strong>
														</td>
														<td>
															<?php echo currency_format($sum_selling); ?>
														</td>
													</tr>
													<tr>
														<td colspan="5" align="center">
															<strong>Komisi</strong>
														</td>
														<td>
															<?php 
																$selling_commission = mysql_fetch_array(mysql_query("SELECT * FROM selling_commission WHERE minimal_selling <= '".$sum_selling."' AND maximal_selling >= '".$sum_selling."'"));
																echo currency_format($selling_commission['selling_commission_value']); 
															?>
														</td>
													</tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
							<br/>
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="well">
									<?php
										$company = mysql_fetch_array(mysql_query("SELECT * FROM company WHERE company_active = '1'"));
									?>
                                        <address>
                                            <strong><?php echo $company['company_name'] ?></strong>
                                            <br/> <?php echo $company['company_address'] ?>, <?php echo $company['company_village'] ?>  - <?php echo $company['company_districts'] ?> - <?php echo $company['company_city'] ?>
                                            <br/> 
                                             <?php echo $company['company_phone'] ?> </address>
                                        <address>
                                            <strong>Full Name</strong>
                                            <br/>
                                            <a href="mailto:#"> <?php echo $company['company_email'] ?>  </a>
                                        </address>
                                    </div>
                                </div>
                                <div class="col-xs-8 invoice-block">
                                    
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