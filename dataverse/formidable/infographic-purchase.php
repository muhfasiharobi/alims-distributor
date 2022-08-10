<?php
	function default_infographic_purchase_platform()
	{
?>
		<div class="row">
			<div class="col-md-4">
				<a class="dashboard-stat dashboard-stat-v2 blue" href="#">
					<div class="visual">
						<i class="fa fa-comments"></i>
					</div>
					<div class="details">
						<div class="number">
							<span>
							    <?php
							        if($_GET['date'] == "all")
							        {
    							        $item_purchase = mysql_fetch_array(mysql_query("SELECT sum(b.order_item_purchase_quantity * b.order_item_purchase_price) AS order_item_purchase FROM item_purchase a, order_item_purchase b WHERE a.item_purchase_id = b.item_purchase_id AND  a.item_purchase_active = '1'"));
    							        echo currency_format($item_purchase['order_item_purchase']);
							        }
							        else if($_GET['date'] == "month")
							        {
							            $bulan_ini = date("m");
							            $item_purchase = mysql_fetch_array(mysql_query("SELECT sum(b.order_item_purchase_quantity * b.order_item_purchase_price) AS order_item_purchase FROM item_purchase a, order_item_purchase b WHERE MONTH(a.item_purchase_date) = '".$bulan_ini."' AND a.item_purchase_id = b.item_purchase_id AND  a.item_purchase_active = '1'"));
    							        echo currency_format($item_purchase['order_item_purchase']);
							        }
							        else
							        {
							            $hari_ini = date("Y-m-d");
							            $item_purchase = mysql_fetch_array(mysql_query("SELECT sum(b.order_item_purchase_quantity * b.order_item_purchase_price) AS order_item_purchase FROM item_purchase a, order_item_purchase b WHERE a.item_purchase_date = '".$hari_ini."' AND a.item_purchase_id = b.item_purchase_id AND  a.item_purchase_active = '1'"));
    							        echo currency_format($item_purchase['order_item_purchase']);
							        }
							    ?>
							</span>
						</div>
						<div class="desc">
							Total Pembelian
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
							    <?php
							        if($_GET['date'] == "all")
							        {
    							        $item_purchase = mysql_fetch_array(mysql_query("SELECT sum(order_item_purchase_quantity) AS order_item_purchase_quantity FROM item_purchase a, order_item_purchase b WHERE a.item_purchase_id = b.item_purchase_id AND a.item_purchase_active = '1'"));
							            echo $item_purchase['order_item_purchase_quantity'];
							        }
							        else if($_GET['date'] == "month")
							        {
							            $bulan_ini = date("m");
							            $item_purchase = mysql_fetch_array(mysql_query("SELECT sum(order_item_purchase_quantity) AS order_item_purchase_quantity FROM item_purchase a, order_item_purchase b WHERE MONTH(a.item_purchase_date) = '".$bulan_ini."' AND a.item_purchase_id = b.item_purchase_id AND a.item_purchase_active = '1'"));
							            echo $item_purchase['order_item_purchase_quantity'];
							        }
							        else
							        {
							            $hari_ini = date("Y-m-d");
							            $item_purchase = mysql_fetch_array(mysql_query("SELECT sum(order_item_purchase_quantity) AS order_item_purchase_quantity FROM item_purchase a, order_item_purchase b WHERE a.item_purchase_date = '".$hari_ini."' AND a.item_purchase_id = b.item_purchase_id AND a.item_purchase_active = '1'"));
							            echo $item_purchase['order_item_purchase_quantity'];
							        }
							    ?>
							</span>
							Pcs
						</div>
						<div class="desc">
							Jumlah Pembelian barang
							<br>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-4">
				<a class="dashboard-stat dashboard-stat-v2 purple" href="#">
					<div class="visual">
						<i class="fa fa-globe"></i>
					</div>
					<div class="details">
						<div class="number">
							<span>
								<?php
							        if($_GET['date'] == "all")
							        {
    							        $item_retur_purchase = mysql_fetch_array(mysql_query("SELECT SUM(b.order_retur_item_purchase_quantity) AS order_retur_item_purchase_quantity FROM retur_item_purchase a, order_retur_item_purchase b WHERE a.retur_item_purchase_id = b.retur_item_purchase_id AND a.retur_item_purchase_active = '1'"));
								        echo $item_retur_purchase['order_retur_item_purchase_quantity'];
							        }
							        else if($_GET['date'] == "month")
							        {
							            $bulan_ini = date("m");
							            $item_retur_purchase = mysql_fetch_array(mysql_query("SELECT SUM(b.order_retur_item_purchase_quantity) AS order_retur_item_purchase_quantity FROM retur_item_purchase a, order_retur_item_purchase b WHERE MONTH(a.retur_item_purchase_date) = '".$bulan_ini."' AND a.retur_item_purchase_id = b.retur_item_purchase_id AND a.retur_item_purchase_active = '1'"));
								        echo $item_retur_purchase['order_retur_item_purchase_quantity'];
							        }
							        else
							        {
							            $hari_ini = date("Y-m-d");
							            $item_retur_purchase = mysql_fetch_array(mysql_query("SELECT SUM(b.order_retur_item_purchase_quantity) AS order_retur_item_purchase_quantity FROM retur_item_purchase a, order_retur_item_purchase b WHERE a.retur_item_purchase_date = '".$hari_ini."' AND a.retur_item_purchase_id = b.retur_item_purchase_id AND a.retur_item_purchase_active = '1'"));
								        echo $item_retur_purchase['order_retur_item_purchase_quantity'];
							        }
							    ?>
							</span>
							Pcs
						</div>
						<div class="desc">
							Barang Retur
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
								Pembelian Barang
							</span>
						</div>
						<div class="actions">
                            <div class="btn-group">
                                <a href="" class="btn dark btn-outline btn-circle btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Filter Range
                                    <span class="fa fa-angle-down"> </span>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="?connect=infographic-purchase&date=today"> Hari ini </a>
                                    </li>
                                    <li>
                                        <a href="?connect=infographic-purchase&date=month"> Bulan ini </a>
                                    </li>
                                    <li>
                                        <a href="?connect=infographic-purchase&date=all"> Semua </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
					</div>
					<div class="portlet-body">
						<div class="">
							<table class="table table-striped table-bordered table-hover order-column" id="sample_2">
								<thead>
									<tr class="uppercase">
										<th>
											No
										</th>
										<th>
											Tgl. Pembelian
										</th>
										<th>
											Pemasok
										</th>
										<?php
											$item_query = mysql_query("SELECT a.item_name FROM item a, item_category b WHERE a.item_category_id = b.item_category_id  AND a.item_active = '1' AND b.item_category_active = '1' ORDER BY a.item_name");
											
											
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
									    $item_purchase_query = mysql_query("SELECT a.item_purchase_id, a.item_purchase_date, b.supplier_name FROM item_purchase a, supplier b WHERE a.supplier_id = b.supplier_id AND a.item_purchase_active = '1' AND b.supplier_active = '1' ORDER BY a.item_purchase_date DESC");
									}
									else if($_GET['date'] == "month")
									{
									    $bulan_ini = date("m");
									    $item_purchase_query = mysql_query("SELECT a.item_purchase_id, a.item_purchase_date, b.supplier_name FROM item_purchase a, supplier b WHERE MONTH(a.item_purchase_date) = '".$bulan_ini."' AND a.supplier_id = b.supplier_id AND a.item_purchase_active = '1' AND b.supplier_active = '1' ORDER BY a.item_purchase_date DESC");
									}
									else
									{
									    $hari_ini = date("Y-m-d");
									    $item_purchase_query = mysql_query("SELECT a.item_purchase_id, a.item_purchase_date, b.supplier_name FROM item_purchase a, supplier b WHERE a.item_purchase_date = '".$hari_ini."' AND a.supplier_id = b.supplier_id AND a.item_purchase_active = '1' AND b.supplier_active = '1' ORDER BY a.item_purchase_date DESC");
									}
								
									while ($item_purchase_fetch_array = mysql_fetch_array($item_purchase_query))
									{
										$item_purchase_date = indonesia_datetime_format($item_purchase_fetch_array['item_purchase_date']);
								?>
									<tr>
										<td>
											<?php echo $number; ?>
										</td>
										<td>
											<?php echo $item_purchase_date; ?>
										</td>
										<td>
											<?php echo $item_purchase_fetch_array['supplier_name']; ?>
										</td>
										<?php
											$item_query = mysql_query("SELECT a.item_id FROM item a, item_category b WHERE a.item_category_id = b.item_category_id AND a.item_active = '1' AND b.item_category_active = '1' ORDER BY a.item_name");
											while ($item_fetch_array = mysql_fetch_array($item_query))
											{
												$order_item_purchase_query = mysql_query("SELECT a.order_item_purchase_quantity, b.item_name FROM order_item_purchase a, item b WHERE a.item_purchase_id = '".$item_purchase_fetch_array['item_purchase_id']."' AND a.item_id = b.item_id AND b.item_id = '".$item_fetch_array['item_id']."'  AND a.order_item_purchase_active = '1' AND b.item_active = '1'  ORDER BY b.item_name");
												$order_item_purchase_fetch_array = mysql_fetch_array($order_item_purchase_query);
												
												$item_price_value = currency_format($order_item_purchase_fetch_array['item_price_value']);
										?>
												<td>
													<?php echo $order_item_purchase_fetch_array['order_item_purchase_quantity']; ?> 
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