<?php
	function default_commission_report_agen()
	{
?>
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-basket font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Laporan Komisi
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=commission-report-agen&execute=form-report-commission-agen" class="horizontal-form" id="form_sample_3" method="post">
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
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="selling_from_date" placeholder="Tgl. Penjualan" type="text">
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
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="selling_to_date" placeholder="Tgl. Penjualan" type="text">
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
	function form_report_commission_agen()
	{
?>	
		<div class="row">
			<div class="col-md-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-basket font-blue"></i>
							<span class="caption-subject font-blue uppercase">
								Laporan Komisi
							</span>
						</div>
					</div>
					<div class="portlet-body form">
						<form action="?connect=commission-report-agen&execute=form-report-commission-agen" class="horizontal-form" id="form_sample_3" method="post">
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
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="selling_from_date" placeholder="Tgl. Penjualan" type="text" value="<?php echo $_POST['selling_from_date'] ?>">
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
											<input autocomplete="off" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="selling_to_date" placeholder="Tgl. Penjualan" type="text" value="<?php echo $_POST['selling_to_date'] ?>">
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
										Total Komisi
									</th>
									<th>
										Komisi Sudah Diambil
									</th>
									<th>
										Komisi Belum Diambil
									</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$selling_from_date = explode("-", $_POST['selling_from_date']);
								$date = $selling_from_date[0];
								$month = $selling_from_date[1];
								$year = $selling_from_date[2];
								$selling_from_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
								
								$selling_to_date = explode("-", $_POST['selling_to_date']);
								$date = $selling_to_date[0];
								$month = $selling_to_date[1];
								$year = $selling_to_date[2];
								$selling_to_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
								
								$komisi_all = 0;
								$komisi_belum_cair = 0;
								$komisi_cair = 0;
								
								$item_selling_all_query = mysql_query("SELECT * FROM item_selling a, reseller b WHERE a.reseller_id = b.reseller_id AND b.user_id = '".$_SESSION['user_id']."' AND a.item_selling_status = 'Sudah Diproses' AND a.item_selling_active = '1' AND a.item_selling_date BETWEEN '".$selling_from_date."' AND '".$selling_to_date."'");
        						while ($item_selling_all_fetch_array = mysql_fetch_array($item_selling_all_query))
        						{
        						   
								    $order_item_selling = mysql_query("SELECT * FROM order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling_all_fetch_array['item_selling_id']."' AND a.order_item_selling_active = '1'");
								    while($data_order_item_selling = mysql_fetch_array($order_item_selling))
								    {
								        if($komisi_all == 0)
								        {
								            $komisi_all = $data_order_item_selling['order_item_selling_quantity']*$data_order_item_selling['item_commission_value'];
								        }
								        else
								        {
								            $komisi_all = $komisi_all+$data_order_item_selling['order_item_selling_quantity']*$data_order_item_selling['item_commission_value'];
								        }
									            
								    }
        							    
        						}
        						
        						$item_selling_belum_cair_query = mysql_query("SELECT * FROM item_selling a, reseller b WHERE a.reseller_id = b.reseller_id AND b.user_id = '".$_SESSION['user_id']."' AND a.item_selling_status = 'Sudah Diproses' AND a.item_selling_active = '1' AND a.invoice_status = 'Belum Cair' AND a.item_selling_date BETWEEN '".$selling_from_date."' AND '".$selling_to_date."'");
        						while ($item_selling_belum_cair_fetch_array = mysql_fetch_array($item_selling_belum_cair_query))
        						{
        						   
								    $order_item_selling = mysql_query("SELECT * FROM order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling_belum_cair_fetch_array['item_selling_id']."' AND a.order_item_selling_active = '1'");
								    while($data_order_item_selling = mysql_fetch_array($order_item_selling))
								    {
								        if($komisi_belum_cair == 0)
								        {
								            $komisi_belum_cair = $data_order_item_selling['order_item_selling_quantity']*$data_order_item_selling['item_commission_value'];
								        }
								        else
								        {
								            $komisi_belum_cair = $komisi_belum_cair+$data_order_item_selling['order_item_selling_quantity']*$data_order_item_selling['item_commission_value'];
								        }
									            
								    }
        							    
        						}
        						
        						$item_selling_cair_query = mysql_query("SELECT * FROM item_selling a, reseller b WHERE a.reseller_id = b.reseller_id AND b.user_id = '".$_SESSION['user_id']."' AND a.item_selling_status = 'Sudah Diproses' AND a.item_selling_active = '1' AND a.invoice_status = 'Cair' AND a.item_selling_date BETWEEN '".$selling_from_date."' AND '".$selling_to_date."'");
        						while ($item_selling_cair_fetch_array = mysql_fetch_array($item_selling_cair_query))
        						{
        						   
								    $order_item_selling = mysql_query("SELECT * FROM order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling_cair_fetch_array['item_selling_id']."' AND a.order_item_selling_active = '1'");
								    while($data_order_item_selling = mysql_fetch_array($order_item_selling))
								    {
								        if($komisi_cair == 0)
								        {
								            $komisi_cair = $data_order_item_selling['order_item_selling_quantity']*$data_order_item_selling['item_commission_value'];
								        }
								        else
								        {
								            $komisi_cair = $komisi_cair+$data_order_item_selling['order_item_selling_quantity']*$data_order_item_selling['item_commission_value'];
								        }
									            
								    }
        							    
        						}
        						
							?>
									
									<tr>
										<td><?php echo currency_format($komisi_all) ?></td>
										<td><?php echo currency_format($komisi_cair) ?></td>
										<td><?php echo currency_format($komisi_belum_cair) ?></td>
									</tr>
									
									
						
						
							</tbody>
						</table>

					</div>
				</div>
			</div>
		</div>

<?php
	}
?>