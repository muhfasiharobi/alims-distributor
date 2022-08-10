<?php
	function default_invoice_platform()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-bag font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Invoice
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
										Tanggal
									</th>
									<th>
										Nomer Invoice
									</th>
									<th>
										Reseller
									</th>
									<th>
										Tanggal Penjualan
									</th>
									<th>
										Komisi
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
								$invoice_query = mysql_query("SELECT * FROM invoice a, reseller b WHERE a.reseller_id = b.reseller_id AND a.invoice_active = '1'");
								while ($invoice_fetch_array = mysql_fetch_array($invoice_query))
								{
							?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $invoice_fetch_array['invoice_datetime']; ?>
										</td>
										<td>
											<?php echo $invoice_fetch_array['no_invoice']; ?>
										</td>
										<td>
											<?php echo $invoice_fetch_array['reseller_name']; ?>
										</td>
										<td>
											<?php echo indonesia_date_format($invoice_fetch_array['selling_date_from']); ?> - <?php echo indonesia_date_format($invoice_fetch_array['selling_date_to']); ?>
										</td>
										<td>
											<?php echo currency_format($invoice_fetch_array['commission']); ?>
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
										    if($invoice_fetch_array['invoice_status'] == "Pending")
										    {
										?>
											<a class="btn purple btn-outline" data-target="#process_invoice_id_<?php echo $invoice_fetch_array['invoice_id']; ?>" data-toggle="modal">
												<i class="icon-check"></i>
												Proses
											</a>
										<?php
										    }
										?>
										    <a class="btn green btn-outline" href="?connect=invoice&execute=cetak-invoice&invoice_id=<?php echo $invoice_fetch_array['invoice_id']; ?>" data-toggle="modal">
												<i class="fa fa-print"></i>
												Cetak
											</a>
										</td>
									</tr>
									<div class="modal fade" data-backdrop="static" id="process_invoice_id_<?php echo $invoice_fetch_array['invoice_id']; ?>">
										<div class="modal-body">
											<p>
												Apakah Anda Ingin Menyelesaikan Invoice Ini ?
											</p>
										</div>
										<div class="modal-footer">
											<button class="btn blue btn-outline" onclick="location.href='?connect=invoice&execute=process-invoice&invoice_id=<?php echo $invoice_fetch_array['invoice_id']; ?>'" type="button">
												<i class="icon-check"></i>
												Ya
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
	function cetak_invoice()
	{
		
		$invoice = mysql_fetch_array(mysql_query("SELECT * FROM invoice a, reseller b WHERE a.reseller_id = b.reseller_id AND a.invoice_id = '".$_GET['invoice_id']."'"));
		
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

?>

    <?php
        if($invoice['invoice_category'] == "selling")
        {
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
                                            <h3> #<?php echo $invoice['no_invoice'] ?> / <?php echo indonesia_date_format($invoice['invoice_date']) ?>
                                            </h3>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <h3>Agen:</h3>
                                            <ul class="list-unstyled">
                                                <li> Nama : <strong><?php echo $invoice['reseller_name'] ?></strong></li>
        										<li> Nomor Telp : <strong><?php echo $invoice['reseller_phone'] ?></strong></li>
                                                <li> Alamat : <strong><?php echo $invoice['reseller_address'] ?> - <?php echo $invoice['reseller_village'] ?> <br> <?php echo $invoice['reseller_districts'] ?> - <?php echo $invoice['reseller_city'] ?></strong></li>
                                                
                                            </ul>
                                        </div>
                                        <div class="col-xs-4">
                                            <h3>Keterangan:</h3>
                                            <ul class="list-unstyled">
                                                <li> <strong>Komisi Penjualan Agen </strong></li>
        										<li> <strong>Dari : <?php echo indonesia_date_format($invoice['selling_date_from']) ?></strong></li>
        										<li> <strong>Sampai : <?php echo indonesia_date_format($invoice['selling_date_to']) ?></strong></li>
                                            </ul>
                                        </div>
                                        <div class="col-xs-4 invoice-payment">
                                            <h3>Detail Pembayaran :</h3>
                                            <ul class="list-unstyled">
                                                <li>
                                                    Bank :<strong> <?php echo $invoice['reseller_account_bank'] ?> </strong></li>
                                                <li>
                                                    Nomor Rekening :<strong><?php echo $invoice['reseller_account_number'] ?></strong> </li>
                                                <li>
        											Atas Nama :<strong><?php echo $invoice['reseller_account_name'] ?></strong> </li>
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
        											$item_selling_from_date = explode("-", $invoice['selling_date_from']);
        											$date = $item_selling_from_date[0];
        											$month = $item_selling_from_date[1];
        											$year = $item_selling_from_date[2];
        											$item_selling_from_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
        											
        											$item_selling_to_date = explode("-", $invoice['selling_date_to']);
        											$date = $item_selling_to_date[0];
        											$month = $item_selling_to_date[1];
        											$year = $item_selling_to_date[2];
        											$item_selling_to_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
        										
        											$number = 1;
        											$sum_selling = 0;
        											$order_item_selling_query = mysql_query("SELECT * FROM item_selling a, order_item_selling b, item c, item_price d WHERE a.item_selling_id = b.item_selling_id AND  b.item_id = c.item_id AND c.item_id = d.item_id AND d.item_price_active = '1' AND a.reseller_id = '".$invoice['reseller_id']."' AND a.item_selling_date BETWEEN '".$item_selling_from_date."' AND '".$item_selling_to_date."'");
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
                                            <a href="?connect=invoice" class="btn btn-lg green hidden-print margin-bottom-5"> Batal
                                                <i class="fa fa-close"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
        <?php
            }
            else
            {
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
                                                <h3> #<?php echo $invoice['no_invoice'] ?> / <?php echo indonesia_date_format($invoice['invoice_date']) ?>
                                                </h3>
                                            </div>
                                        </div>
                                        <hr/>
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <h3>Agen:</h3>
                                                <ul class="list-unstyled">
                                                    <li> Nama : <strong><?php echo $invoice['reseller_name'] ?></strong></li>
            										<li> Nomor Telp : <strong><?php echo $invoice['reseller_phone'] ?></strong></li>
                                                    <li> Alamat : <strong><?php echo $invoice['reseller_address'] ?> - <?php echo $invoice['reseller_village'] ?> <br> <?php echo $invoice['reseller_districts'] ?> - <?php echo $invoice['reseller_city'] ?></strong></li>
                                                    
                                                </ul>
                                            </div>
                                            <div class="col-xs-4">
                                                <h3>Keterangan:</h3>
                                                <ul class="list-unstyled">
                                                    <li> <strong>Komisi Penjualan Agen </strong></li>
            										<li> <strong>Dari : <?php echo indonesia_date_format($invoice['selling_date_from']) ?></strong></li>
            										<li> <strong>Sampai : <?php echo indonesia_date_format($invoice['selling_date_to']) ?></strong></li>
                                                </ul>
                                            </div>
                                            <div class="col-xs-4 invoice-payment">
                                                <h3>Detail Pembayaran :</h3>
                                                <ul class="list-unstyled">
                                                    <li>
                                                        Bank :<strong> <?php echo $invoice['reseller_account_bank'] ?> </strong></li>
                                                    <li>
                                                        Nomor Rekening :<strong><?php echo $invoice['reseller_account_number'] ?></strong> </li>
                                                    <li>
            											Atas Nama :<strong><?php echo $invoice['reseller_account_name'] ?></strong> </li>
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
            											$item_selling_from_date = explode("-", $invoice['selling_date_from']);
            											$date = $item_selling_from_date[0];
            											$month = $item_selling_from_date[1];
            											$year = $item_selling_from_date[2];
            											$item_selling_from_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
            											
            											$item_selling_to_date = explode("-", $invoice['selling_date_to']);
            											$date = $item_selling_to_date[0];
            											$month = $item_selling_to_date[1];
            											$year = $item_selling_to_date[2];
            											$item_selling_to_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
            										
            											$number = 1;
            											$order_item_selling_query = mysql_query("SELECT *, SUM(b.order_item_selling_quantity) as sum_order_item_selling_quantity FROM item_selling a, order_item_selling b, item c WHERE a.reseller_id = '".$invoice['reseller_id']."' AND a.item_selling_id = b.item_selling_id AND b.item_id = c.item_id AND a.item_selling_date BETWEEN '".$item_selling_from_date."' AND '".$item_selling_to_date."' GROUP BY b.item_id");
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
                                                <a href="?connect=invoice" class="btn btn-lg green hidden-print margin-bottom-5"> Batal
                                                    <i class="fa fa-close"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                
                
        <?php
            }
        ?>
<?php
}
?>