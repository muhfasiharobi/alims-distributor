<?php
	function default_infographic_selling_platform()
	{
?>
		<div class="row">
			<div class="col-lg-12">
				<div class="portlet light">
					<div class="portlet-title">
						<div class="actions">
                            <div class="btn-group">
                                <a href="" class="btn dark btn-outline btn-circle btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> Filter Range
                                    <span class="fa fa-angle-down"> </span>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="?connect=infographic-selling&date=today"> Hari ini </a>
                                    </li>
                                    <li>
                                        <a href="?connect=infographic-selling&date=month"> Bulan ini </a>
                                    </li>
                                    <li>
                                        <a href="?connect=infographic-selling&date=all"> Semua </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
					</div>
				</div>
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

							        	if($_SESSION['user_category_name'] == "Administrator")
							        	{
							        		$item_selling = mysql_fetch_array(mysql_query("SELECT sum(b.order_item_selling_quantity * b.item_price_value) AS order_item_selling_quantity FROM item_selling a, order_item_selling b WHERE a.item_selling_id = b.item_selling_id AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses'"));

							        		$promo_prosentase = mysql_fetch_array(mysql_query("SELECT sum(((b.order_item_selling_quantity * b.item_price_value)* a.promo_value) / 100) AS promo_prosentase FROM item_selling a, order_item_selling b WHERE a.item_selling_id = b.item_selling_id AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses' AND a.kategori_promo = 'Prosentase'"));

							        		$promo_nominal = mysql_fetch_array(mysql_query("SELECT sum(a.promo_value) AS promo_nominal FROM item_selling a, order_item_selling b WHERE a.item_selling_id = b.item_selling_id AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses' AND a.kategori_promo = 'Nominal'"));
							        	}
							        	else
							        	{
							        		$item_selling = mysql_fetch_array(mysql_query("SELECT sum(b.order_item_selling_quantity * b.item_price_value) AS order_item_selling_quantity FROM item_selling a, order_item_selling b, item c WHERE a.item_selling_id = b.item_selling_id AND b.item_id = c.item_id AND c.item_category_id = '".$_SESSION['item_category_id']."' AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses'"));

							        		$promo_prosentase = mysql_fetch_array(mysql_query("SELECT sum((b.order_item_selling_quantity * b.item_price_value) * a.promo_value)/100 AS promo_prosentase FROM item_selling a, order_item_selling b, item c WHERE a.item_selling_id = b.item_selling_id AND b.item_id = c.item_id AND c.item_category_id = '".$_SESSION['item_category_id']."' AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses' AND a.kategori_promo = 'Prosentase'"));

							        		$promo_nominal = mysql_fetch_array(mysql_query("SELECT sum(a.promo_value) AS promo_nominal FROM item_selling a, order_item_selling b, item c WHERE a.item_selling_id = b.item_selling_id AND b.item_id = c.item_id AND c.item_category_id = '".$_SESSION['item_category_id']."' AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses' AND a.kategori_promo = 'Nominal'"));
							        	}
    							        
    							        echo currency_format($item_selling['order_item_selling_quantity'] - ($promo_prosentase['promo_prosentase'] + $promo_nominal['promo_nominal']));
							        }
							        else if($_GET['date'] == "today")
							        {
										$hari_ini = date("Y-m-d");

										if($_SESSION['user_category_name'] == "Administrator")
							        	{
							            	$item_selling = mysql_fetch_array(mysql_query("SELECT sum(b.order_item_selling_quantity * b.item_price_value) AS order_item_selling_quantity FROM item_selling a, order_item_selling b WHERE a.item_selling_date = '".$hari_ini."' AND a.item_selling_id = b.item_selling_id AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses'"));

							            	$promo_prosentase = mysql_fetch_array(mysql_query("SELECT sum(((b.order_item_selling_quantity * b.item_price_value)* a.promo_value) / 100) AS promo_prosentase FROM item_selling a, order_item_selling b WHERE a.item_selling_date = '".$hari_ini."' AND a.item_selling_id = b.item_selling_id AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses' AND a.kategori_promo = 'Prosentase'"));

							        		$promo_nominal = mysql_fetch_array(mysql_query("SELECT sum(a.promo_value) AS promo_nominal FROM item_selling a, order_item_selling b WHERE a.item_selling_date = '".$hari_ini."' AND a.item_selling_id = b.item_selling_id AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses' AND a.kategori_promo = 'Nominal'"));


							            }
							            else
							            {
							            	$item_selling = mysql_fetch_array(mysql_query("SELECT sum(b.order_item_selling_quantity * b.item_price_value) AS order_item_selling_quantity FROM item_selling a, order_item_selling b, item c WHERE a.item_selling_date = '".$hari_ini."' AND a.item_selling_id = b.item_selling_id AND b.item_id = c.item_id AND c.item_category_id = '".$_SESSION['item_category_id']."' AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses'"));

							            	$promo_prosentase = mysql_fetch_array(mysql_query("SELECT sum((b.order_item_selling_quantity * b.item_price_value) * a.promo_value)/100 AS promo_prosentase FROM item_selling a, order_item_selling b, item c WHERE a.item_selling_date = '".$hari_ini."' AND a.item_selling_id = b.item_selling_id AND b.item_id = c.item_id AND c.item_category_id = '".$_SESSION['item_category_id']."' AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses' AND a.kategori_promo = 'Prosentase'"));

							        		$promo_nominal = mysql_fetch_array(mysql_query("SELECT sum(a.promo_value) AS promo_nominal FROM item_selling a, order_item_selling b, item c WHERE a.item_selling_date = '".$hari_ini."' AND a.item_selling_id = b.item_selling_id AND b.item_id = c.item_id AND c.item_category_id = '".$_SESSION['item_category_id']."' AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses' AND a.kategori_promo = 'Nominal'"));
							            }
    							        echo currency_format($item_selling['order_item_selling_quantity'] - ($promo_prosentase['promo_prosentase'] + $promo_nominal['promo_nominal']));
							        }
							        else
							        {
							            
										$bulan_ini = date("m");

										if($_SESSION['user_category_name'] == "Administrator")
							        	{
							            	$item_selling = mysql_fetch_array(mysql_query("SELECT sum(b.order_item_selling_quantity * b.item_price_value) AS order_item_selling_quantity FROM item_selling a, order_item_selling b WHERE MONTH(a.item_selling_date) = '".$bulan_ini."' AND a.item_selling_id = b.item_selling_id AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses'"));

							            	$promo_prosentase = mysql_fetch_array(mysql_query("SELECT sum(((b.order_item_selling_quantity * b.item_price_value)* a.promo_value) / 100) AS promo_prosentase FROM item_selling a, order_item_selling b WHERE MONTH(a.item_selling_date) = '".$bulan_ini."' AND a.item_selling_id = b.item_selling_id AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses' AND a.kategori_promo = 'Prosentase'"));

							        		$promo_nominal = mysql_fetch_array(mysql_query("SELECT sum(a.promo_value) AS promo_nominal FROM item_selling a, order_item_selling b WHERE MONTH(a.item_selling_date) = '".$bulan_ini."' AND a.item_selling_id = b.item_selling_id AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses' AND a.kategori_promo = 'Nominal'"));
							            }
							            else
							            {
							            	$item_selling = mysql_fetch_array(mysql_query("SELECT sum(b.order_item_selling_quantity * b.item_price_value) AS order_item_selling_quantity FROM item_selling a, order_item_selling b, item c WHERE MONTH(a.item_selling_date) = '".$bulan_ini."' AND a.item_selling_id = b.item_selling_id AND b.item_id = c.item_id AND c.item_category_id = '".$_SESSION['item_category_id']."' AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses'"));

							            	$promo_prosentase = mysql_fetch_array(mysql_query("SELECT sum((b.order_item_selling_quantity * b.item_price_value) * a.promo_value)/100 AS promo_prosentase FROM item_selling a, order_item_selling b, item c WHERE MONTH(a.item_selling_date) = '".$bulan_ini."' AND a.item_selling_id = b.item_selling_id AND b.item_id = c.item_id AND c.item_category_id = '".$_SESSION['item_category_id']."' AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses' AND a.kategori_promo = 'Prosentase'"));

							        		$promo_nominal = mysql_fetch_array(mysql_query("SELECT sum(a.promo_value) AS promo_nominal FROM item_selling a, order_item_selling b, item c WHERE MONTH(a.item_selling_date) = '".$bulan_ini."' AND a.item_selling_id = b.item_selling_id AND b.item_id = c.item_id AND c.item_category_id = '".$_SESSION['item_category_id']."' AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses' AND a.kategori_promo = 'Nominal'"));
							            }
    							        echo currency_format($item_selling['order_item_selling_quantity'] - ($promo_prosentase['promo_prosentase'] + $promo_nominal['promo_nominal']));
							        }
							    ?>
							</span>
						</div>
						<div class="desc">
							Total Penjualan
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
							    <?php
							        if($_GET['date'] == "all")
							        {
							        	if($_SESSION['user_category_name'] == "Administrator")
							        	{
    							        	$item_selling = mysql_fetch_array(mysql_query("SELECT sum(order_item_selling_quantity) AS order_item_selling_quantity FROM item_selling a, order_item_selling b WHERE a.item_selling_id = b.item_selling_id AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses'"));
    							        }
    							        else
    							        {
    							        	$item_selling = mysql_fetch_array(mysql_query("SELECT sum(order_item_selling_quantity) AS order_item_selling_quantity FROM item_selling a, order_item_selling b, item c WHERE a.item_selling_id = b.item_selling_id AND b.item_id = c.item_id AND c.item_category_id = '".$_SESSION['item_category_id']."' AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses'"));
    							        }
							            echo $item_selling['order_item_selling_quantity'];
							        }
							        else if($_GET['date'] == "today")
							        {
							            $hari_ini = date("Y-m-d");

							            if($_SESSION['user_category_name'] == "Administrator")
							        	{
							            	$item_selling = mysql_fetch_array(mysql_query("SELECT sum(order_item_selling_quantity) AS order_item_selling_quantity FROM item_selling a, order_item_selling b WHERE a.item_selling_date = '".$hari_ini."' AND a.item_selling_id = b.item_selling_id AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses'"));
							            }
							            else
							            {
							            	$item_selling = mysql_fetch_array(mysql_query("SELECT sum(order_item_selling_quantity) AS order_item_selling_quantity FROM item_selling a, order_item_selling b, item c WHERE a.item_selling_date = '".$hari_ini."' AND a.item_selling_id = b.item_selling_id AND a.item_selling_active = '1' AND b.item_id = c.item_id AND c.item_category_id = '".$_SESSION['item_category_id']."' AND a.item_selling_status = 'Sudah Diproses'"));
							            }
							            echo $item_selling['order_item_selling_quantity'];
							        }
							        else
							        {
										$bulan_ini = date("m");

										if($_SESSION['user_category_name'] == "Administrator")
							        	{
							            	$item_selling = mysql_fetch_array(mysql_query("SELECT sum(order_item_selling_quantity) AS order_item_selling_quantity FROM item_selling a, order_item_selling b WHERE MONTH(a.item_selling_date) = '".$bulan_ini."' AND a.item_selling_id = b.item_selling_id AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses'"));
							            }
							            else
							            {
							            	$item_selling = mysql_fetch_array(mysql_query("SELECT sum(order_item_selling_quantity) AS order_item_selling_quantity FROM item_selling a, order_item_selling b, item c WHERE MONTH(a.item_selling_date) = '".$bulan_ini."' AND a.item_selling_id = b.item_selling_id AND b.item_id = c.item_id AND c.item_category_id = '".$_SESSION['item_category_id']."' AND a.item_selling_active = '1' AND a.item_selling_status = 'Sudah Diproses'"));
							            }
							            echo $item_selling['order_item_selling_quantity'];
							            
							        }
							    ?>
							</span>
							Pcs
						</div>
						<div class="desc">
							Barang Terjual
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
										
										$item_selling_query = mysql_query("SELECT * FROM item_selling a, reseller b WHERE a.reseller_id = b.reseller_id AND a.item_selling_status = 'Sudah Diproses' AND a.item_selling_active = '1'");
        								$jml_item_selling_query = mysql_num_rows($item_selling_query);
        								while ($item_selling_fetch_array = mysql_fetch_array($item_selling_query))
        								{
        								    if($_SESSION['user_category_name'] == "Administrator")
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
										    else
										    {
										    	$order_item_selling = mysql_query("SELECT * FROM order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling_fetch_array['item_selling_id']."' AND a.order_item_selling_active = '1' AND b.item_category_id = '".$_SESSION['item_category_id']."'");
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
        								    
        								}
        								echo currency_format($komisi);
							        }
							        else if($_GET['date'] == "today")
							        {
							            
							           $hari_ini = date("Y-m-d");
							            $item_selling_query = mysql_query("SELECT * FROM item_selling a, reseller b WHERE a.reseller_id = b.reseller_id AND a.item_selling_status = 'Sudah Diproses' AND a.item_selling_active = '1' AND a.item_selling_date = '".$hari_ini."'");
        								$jml_item_selling_query = mysql_num_rows($item_selling_query);
        								while ($item_selling_fetch_array = mysql_fetch_array($item_selling_query))
        								{
        								    if($_SESSION['user_category_name'] == "Administrator")
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
										    else
										    {
										    	$order_item_selling = mysql_query("SELECT * FROM order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling_fetch_array['item_selling_id']."' AND a.order_item_selling_active = '1' AND b.item_category_id = '".$_SESSION['item_category_id']."'");
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
        								    
        								}
        								echo currency_format($komisi);
							        }
							        else
							        {
							            
										
										$bulan_ini = date("m");
										$item_selling_query = mysql_query("SELECT * FROM item_selling a, reseller b WHERE MONTH(a.item_selling_date) = '".$bulan_ini."' AND a.reseller_id = b.reseller_id AND a.item_selling_status = 'Sudah Diproses' AND a.item_selling_active = '1'");
        								$jml_item_selling_query = mysql_num_rows($item_selling_query);
        								while ($item_selling_fetch_array = mysql_fetch_array($item_selling_query))
        								{
        								    if($_SESSION['user_category_name'] == "Administrator")
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
										    else
										    {
										    	$order_item_selling = mysql_query("SELECT * FROM order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling_fetch_array['item_selling_id']."' AND a.order_item_selling_active = '1' AND b.item_category_id = '".$_SESSION['item_category_id']."'");
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
        								    
        								}
        								echo currency_format($komisi);
							            
							        }
							    ?>
							</span>
						</div>
						<div class="desc">
							Komisi Agen
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
		</div>
		<div class="row">
                            <div class="col-lg-12 col-xs-12 col-sm-12">
                                <div class="portlet light ">
                                    <div class="portlet-title">
                                        <div class="caption caption-md">
                                            <i class="icon-bar-chart font-dark hide"></i>
                                            <span class="caption-subject font-dark bold uppercase">Penjualan Agen</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="table-scrollable table-scrollable-borderless">
                                            <table class="table table-hover table-light">
                                                <thead>
                                                    <tr class="uppercase">
                                                        <th colspan="2"> Agen </th>
														<?php

														if($_SESSION['user_category_name'] == "Administrator")
							        					{
															$item = mysql_query("SELECT * FROM item WHERE item_active = '1'");
														}
														else
														{
															$item = mysql_query("SELECT * FROM item WHERE item_active = '1' AND item_category_id = '".$_SESSION['item_category_id']."'");
														}
															while($data_item = mysql_fetch_array($item))
															{
														?>
															<th> <?php echo $data_item['item_name'] ?> </th>
														<?php
															}
														?>
                                                    </tr>
                                                </thead>
												<?php
												if($_SESSION['user_category_name'] == "Administrator")
							        			{
													$reseller = mysql_query("SELECT * FROM reseller a, user b, user_category c WHERE a.user_id = b.user_id AND b.user_category_id = c.user_category_id AND c.user_category_name = 'Agen' AND a.reseller_active = '1'");
												}
												else
												{
													$reseller = mysql_query("SELECT * FROM reseller a, user b WHERE a.reseller_active = '1' AND a.user_id = b.user_id AND b.item_category_id = '".$_SESSION['item_category_id']."'");
												}
													while($data_reseller = mysql_fetch_array($reseller))
													{
												?>
                                                <tr>
                                                    <td class="fit">
                                                        <img class="user-pic rounded" src="../assets/pages/media/users/avatar.jpg"> 
													</td>
												
                                                    <td>
                                                        <a href="javascript:;" class="primary-link"><?php echo $data_reseller['reseller_name'] ?></a>
                                                    </td>
													<?php
															$item = mysql_query("SELECT * FROM item WHERE item_active = '1'");
															while($data_item = mysql_fetch_array($item))
															{
																$order_item_sell = mysql_fetch_array(mysql_query("SELECT SUM(b.order_item_selling_quantity) as order_item_selling_quantity FROM item_selling a, order_item_selling b WHERE a.item_selling_id = b.item_selling_id AND a.reseller_id = '".$data_reseller['reseller_id']."' AND b.item_id = '".$data_item['item_id']."' AND a.item_selling_status = 'Sudah Diproses'"));
														?>
															<td> <?php echo $order_item_sell['order_item_selling_quantity'] ?> </td>
														<?php
															}
														?>
                                                </tr>
												<?php
													}
												?>
                                                
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="row">
						<div class="col-lg-12 col-xs-12 col-sm-12">
                                <div class="portlet light ">
                                    <div class="portlet-title">
                                        <div class="caption caption-md">
                                            <i class="icon-bar-chart font-dark hide"></i>
                                            <span class="caption-subject font-dark bold uppercase">Stok Barang</span>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
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
												$item_purchase = mysql_fetch_array(mysql_query("SELECT SUM(order_item_purchase_quantity) as order_item_purchase_quantity FROM order_item_purchase WHERE item_id = '".$data_item['item_id']."' AND order_item_purchase_active = '1'"));
									
												$item_selling = mysql_fetch_array(mysql_query("SELECT SUM(order_item_selling_quantity) as order_item_selling_quantity FROM order_item_selling WHERE item_id = '".$data_item['item_id']."' AND order_item_selling_active = '1'"));
												
												$penyesuaian_stok = 0;
												$penyesuaian_stok_plus = mysql_fetch_array(mysql_query("SELECT SUM(penyesuaian_stok_quantity) as penyesuaian_stok_quantity FROM penyesuaian_stok WHERE item_id = '".$data_item['item_id']."' AND penyesuaian_stok_operation = 'tambah' AND penyesuaian_stok_active = '1'"));
															
												$penyesuaian_stok_minus = mysql_fetch_array(mysql_query("SELECT SUM(penyesuaian_stok_quantity) as penyesuaian_stok_quantity FROM penyesuaian_stok WHERE item_id = '".$data_item['item_id']."' AND penyesuaian_stok_operation = 'kurangi' AND penyesuaian_stok_active = '1'"));
															
												$penyesuaian_stok = $penyesuaian_stok_plus['penyesuaian_stok_quantity'] - $penyesuaian_stok_minus['penyesuaian_stok_quantity'];
												
												$barang_keluar = mysql_fetch_array(mysql_query("SELECT SUM(barang_keluar_quantity) as barang_keluar_quantity FROM barang_keluar WHERE item_id = '".$data_item['item_id']."' AND barang_keluar_active = '1'"));
												
												$stock = $item_purchase['order_item_purchase_quantity'] - ($item_selling['order_item_selling_quantity'] + $barang_keluar['barang_keluar_quantity']) + $penyesuaian_stok;
												
												$persen = ($stock*100)/$item_purchase['order_item_purchase_quantity'];
										?>
                                            <div class="col-md-4">
                                                <h4><?php echo $data_item['item_name'] ?></h4>
                                                <div class="progress progress-striped active">
													<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $stock ?>" aria-valuemin="0" aria-valuemax="<?php echo $item_purchase['order_item_purchase_quantity'] ?>" style="width: <?php echo $persen ?>%">
														<span class="sr-only"> 40% Complete (success) </span>
													</div>
												</div> 
											</div>
										<?php
											}
										?>
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