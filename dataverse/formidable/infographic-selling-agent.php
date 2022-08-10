<?php
	function default_infographic_selling_agent_platform()
	{
?>
		<div class="row">
			<div class="col-md-4">
				<a class="dashboard-stat dashboard-stat-v2 green" href="#">
					<div class="visual">
						<i class="fa fa-shopping-cart"></i>
					</div>
					<div class="details">
						<div class="number">
							<span>
								Rp
								<?php
							        if($_GET['date'] == "all")
							        {
										
										$item_selling_query = mysql_query("SELECT * FROM item_selling a, reseller b WHERE a.reseller_id = b.reseller_id AND b.user_id = '".$_SESSION['user_id']."' AND a.item_selling_status = 'Sudah Diproses' AND a.item_selling_active = '1'");
        								$jml_item_selling_query = mysql_num_rows($item_selling_query);
        								while ($item_selling_fetch_array = mysql_fetch_array($item_selling_query))
        								{
        								    
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
										            
										        }
        								    
        								}
        								echo currency_format($komisi);
							        }
							        else if($_GET['date'] == "today")
							        {
							            
							           $hari_ini = date("Y-m-d");
							           
							            $item_selling_query = mysql_query("SELECT * FROM item_selling a, reseller b WHERE a.reseller_id = b.reseller_id AND b.user_id = '".$_SESSION['user_id']."' AND a.item_selling_status = 'Sudah Diproses' AND a.item_selling_active = '1' AND a.item_selling_date = '".$hari_ini."'");
        								$jml_item_selling_query = mysql_num_rows($item_selling_query);
        								while ($item_selling_fetch_array = mysql_fetch_array($item_selling_query))
        								{
        								    
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
										            
										        }
        								    
        								}
        								echo currency_format($komisi);
							           
										
							        }
							        else
							        {
										$bulan_ini = date("m");
										$item_selling_query = mysql_query("SELECT * FROM item_selling a, reseller b WHERE MONTH(a.item_selling_date) = '".$bulan_ini."' AND a.reseller_id = b.reseller_id AND b.user_id = '".$_SESSION['user_id']."' AND a.item_selling_status = 'Sudah Diproses' AND a.item_selling_active = '1'");
        								$jml_item_selling_query = mysql_num_rows($item_selling_query);
        								while ($item_selling_fetch_array = mysql_fetch_array($item_selling_query))
        								{
        								    
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
										            
										        }
        								    
        								}
        								echo currency_format($komisi);
										
							        }
							    ?>
							</span>
						</div>
						<div class="desc">
							Total komisi
							<?php 
								if($_GET['date'] == "today")
								{
							?>
									Hari ini
							<?php
								} else if($_GET['date'] == "all") {
							?>
									Seluruhnya
							<?php
								}
								else
								{
							?>
									Bulan ini
							<?php
								}
							?>
							<br>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-4">
				<a class="dashboard-stat dashboard-stat-v2 blue" href="#">
					<div class="visual">
						<i class="fa fa-comments"></i>
					</div>
					<div class="details">
						<div class="number">
							<span>
							Rp
							    <?php
							        $komisi = 0;
							        if($_GET['date'] == "all")
							        {
										
										$item_selling_query = mysql_query("SELECT * FROM item_selling a, reseller b WHERE a.reseller_id = b.reseller_id AND b.user_id = '".$_SESSION['user_id']."' AND a.item_selling_status = 'Sudah Diproses' AND a.item_selling_active = '1' AND a.invoice_status = 'Cair'");
        								$jml_item_selling_query = mysql_num_rows($item_selling_query);
        								while ($item_selling_fetch_array = mysql_fetch_array($item_selling_query))
        								{
        								   
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
										            
										        }
        								    
        								}
        								echo currency_format($komisi);
							        }
							        else if($_GET['date'] == "today")
							        {
							            
							           $hari_ini = date("Y-m-d");
							           $item_selling_query = mysql_query("SELECT * FROM item_selling a, reseller b WHERE a.reseller_id = b.reseller_id AND b.user_id = '".$_SESSION['user_id']."' AND a.item_selling_status = 'Sudah Diproses' AND a.item_selling_active = '1' AND a.invoice_status = 'Cair' AND a.item_selling_date = '".$hari_ini."'");
        								$jml_item_selling_query = mysql_num_rows($item_selling_query);
        								while ($item_selling_fetch_array = mysql_fetch_array($item_selling_query))
        								{
        								  
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
										            
										        }
        								    
        								}
        								echo currency_format($komisi);
							        }
							        else
							        {
							            
										$bulan_ini = date("m");
										$item_selling_query = mysql_query("SELECT * FROM item_selling a, reseller b WHERE MONTH(a.item_selling_date) = '".$bulan_ini."' AND a.reseller_id = b.reseller_id AND b.user_id = '".$_SESSION['user_id']."' AND a.item_selling_status = 'Sudah Diproses' AND a.item_selling_active = '1' AND a.invoice_status = 'Cair'");
        								$jml_item_selling_query = mysql_num_rows($item_selling_query);
        								while ($item_selling_fetch_array = mysql_fetch_array($item_selling_query))
        								{
        								    
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
										            
										        }
        								    
        								}
        								echo currency_format($komisi);
							            
							        }
							    ?>
							</span>
						</div>
						<div class="desc">
							Komisi Sudah Diambil
							<?php 
								if($_GET['date'] == "today")
								{
							?>
									Hari ini
							<?php
								} else if($_GET['date'] == "all") {
							?>
									Seluruhnya
							<?php
								}
								else
								{
							?>
									Bulan ini
							<?php
								}
							?>
							<br>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-4">
				<a class="dashboard-stat dashboard-stat-v2 red" href="#">
					<div class="visual">
						<i class="fa fa-bar-chart-o"></i>
					</div>
					<div class="details">
						<div class="number">
							<span>
								Rp 
							    <?php
							        $komisi = 0;
							        if($_GET['date'] == "all")
							        {
										
										$item_selling_query = mysql_query("SELECT * FROM item_selling a, reseller b WHERE a.reseller_id = b.reseller_id AND b.user_id = '".$_SESSION['user_id']."' AND a.item_selling_status = 'Sudah Diproses' AND a.item_selling_active = '1' AND a.invoice_status = 'Belum Cair'");
        								$jml_item_selling_query = mysql_num_rows($item_selling_query);
        								while ($item_selling_fetch_array = mysql_fetch_array($item_selling_query))
        								{
        								   
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
										            
										        }
        								    
        								}
        								echo currency_format($komisi);
							        }
							        else if($_GET['date'] == "today")
							        {
							            
							           $hari_ini = date("Y-m-d");
							           $item_selling_query = mysql_query("SELECT * FROM item_selling a, reseller b WHERE a.reseller_id = b.reseller_id AND b.user_id = '".$_SESSION['user_id']."' AND a.item_selling_status = 'Sudah Diproses' AND a.item_selling_active = '1' AND a.invoice_status = 'Belum Cair' AND a.item_selling_date = '".$hari_ini."'");
        								$jml_item_selling_query = mysql_num_rows($item_selling_query);
        								while ($item_selling_fetch_array = mysql_fetch_array($item_selling_query))
        								{
        								  
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
										            
										        }
        								    
        								}
        								echo currency_format($komisi);
							        }
							        else
							        {
							            
										$bulan_ini = date("m");
										$item_selling_query = mysql_query("SELECT * FROM item_selling a, reseller b WHERE MONTH(a.item_selling_date) = '".$bulan_ini."' AND a.reseller_id = b.reseller_id AND b.user_id = '".$_SESSION['user_id']."' AND a.item_selling_status = 'Sudah Diproses' AND a.item_selling_active = '1' AND a.invoice_status = 'Belum Cair'");
        								$jml_item_selling_query = mysql_num_rows($item_selling_query);
        								while ($item_selling_fetch_array = mysql_fetch_array($item_selling_query))
        								{
        								    
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
										            
										        }
        								    
        								}
        								echo currency_format($komisi);
							            
							        }
							    ?>
							</span>
							
						</div>
						<div class="desc">
							Komisi Belum Diambil
							<?php 
								if($_GET['date'] == "today")
								{
							?>
									Hari ini
							<?php
								} else if($_GET['date'] == "all") {
							?>
									Seluruhnya
							<?php
								}
								else
								{
							?>
									Bulan ini
							<?php
								}
							?>
							<br>
						</div>
					</div>
				</a>
			</div>
			
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="portlet light bordered">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-bar-chart font-dark"></i>
							<span class="caption-subject font-dark uppercase">
								Penjualan Barang
							</span>
						</div>
						<div class="actions">
                            <div class="btn-group">
                                <a href="" class="btn dark btn-outline btn-circle btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Filter Range
                                    <span class="fa fa-angle-down"> </span>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="?connect=infographic-selling-agent&date=today"> Hari ini </a>
                                    </li>
                                    <li>
                                        <a href="?connect=infographic-selling-agent&date=month"> Bulan ini </a>
                                    </li>
                                    <li>
                                        <a href="?connect=infographic-selling-agent&date=all"> Semua </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
					</div>
					<div class="portlet-body">
						<div class="table-scrollable table-scrollable-borderless">
							<table class="table table-hover table-light">
								<thead>
									<tr class="uppercase">
										<th>
											No
										</th>
										<th>
											Tgl. Penjualan
										</th>
										<th>
											No Penjualan
										</th>
										<th>
											Pelanggan
										</th>
										<?php
											$item_query = mysql_query("SELECT * FROM reseller_item_sell a, reseller b, item c WHERE a.reseller_id = b.reseller_id AND a.item_id = c.item_id AND b.user_id = '".$_SESSION['user_id']."' AND a.reseller_item_sell_active = '1'");
											while ($item_fetch_array = mysql_fetch_array($item_query))
											{
										?>
												<th>
													<?php echo $item_fetch_array['item_name']; ?>
												</th>
										<?php
											}
										?>
									</tr>
								</thead>
								<tbody>
								<?php
									$number = 1;
									
									if($_GET['date'] == "all")
									{
									    $item_selling_query = mysql_query("SELECT a.item_selling_id, a.item_selling_date,a.item_selling_code, c.customer_name FROM item_selling a, reseller b, customer c WHERE a.reseller_id = b.reseller_id AND a.customer_id = c.customer_id AND b.user_id = '".$_SESSION['user_id']."' AND a.item_selling_active = '1' AND b.reseller_active = '1' AND a.item_selling_status = 'Sudah Diproses' ORDER BY a.item_selling_date DESC");
									}
									else if($_GET['date'] == "today")
									{
									    									    
										$hari_ini = date("Y-m-d");
										$item_selling_query = mysql_query("SELECT a.item_selling_id, a.item_selling_date,a.item_selling_code, c.customer_name FROM item_selling a, reseller b, customer c WHERE a.item_selling_date = '".$hari_ini."' AND a.reseller_id = b.reseller_id AND a.customer_id = c.customer_id AND b.user_id = '".$_SESSION['user_id']."' AND a.item_selling_active = '1' AND b.reseller_active = '1' AND a.item_selling_status = 'Sudah Diproses' ORDER BY a.item_selling_date DESC");
									}
									else
									{
									    $bulan_ini = date("m");
										$item_selling_query = mysql_query("SELECT a.item_selling_id, a.item_selling_date,a.item_selling_code, c.customer_name FROM item_selling a, reseller b, customer c WHERE MONTH(a.item_selling_date) = '".$bulan_ini."' AND a.reseller_id = b.reseller_id AND a.customer_id = c.customer_id AND b.user_id = '".$_SESSION['user_id']."' AND a.item_selling_active = '1' AND b.reseller_active = '1' AND a.item_selling_status = 'Sudah Diproses' ORDER BY a.item_selling_date DESC");
									   
									}
								
									while ($item_selling_fetch_array = mysql_fetch_array($item_selling_query))
									{
										$item_selling_date = indonesia_datetime_format($item_selling_fetch_array['item_selling_date']);
								?>
    									<tr>
    										<td>
    											<?php echo $number; ?>
    										</td>
    										<td>
    											<?php echo $item_selling_date; ?>
    										</td>
    										<td>
    											<?php echo $item_selling_fetch_array['item_selling_code']; ?>
    										</td>
    										<td>
    											<?php echo $item_selling_fetch_array['customer_name']; ?>
    										</td>
    										<?php
    											$item_query = mysql_query("SELECT * FROM reseller_item_sell a, reseller b, item c WHERE a.reseller_id = b.reseller_id AND a.item_id = c.item_id AND b.user_id = '".$_SESSION['user_id']."' AND a.reseller_item_sell_active = '1'");
    											while ($item_fetch_array = mysql_fetch_array($item_query))
    											{
    											    $order_item_selling = mysql_fetch_array(mysql_query("SELECT * FROM order_item_selling WHERE item_selling_id = '".$item_selling_fetch_array['item_selling_id']."' AND item_id = '".$item_fetch_array['item_id']."' AND order_item_selling_active = '1'"));
    										?>
    												<td>
														<?php 
															if($order_item_selling['order_item_selling_quantity'] != "")
															{
														?>
															<?php echo $order_item_selling['order_item_selling_quantity']; ?> Pcs
														<?php
															}
															else
															{
														?>
															0 Pcs
														<?php
															}
														?>
    												</td>
    										<?php
    											}
    										?>
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
		</div>
	</div>
	<!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<?php
	}
?>