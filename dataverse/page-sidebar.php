
<div class="page-sidebar navbar-collapse collapse">

	<?php
		if($_SESSION['user_category_name'] == "Agen")
		{
	?>	
			<ul class="page-sidebar-menu page-header-fixed" data-auto-scroll="true" data-keep-expanded="false" data-slide-speed="200" style="padding-top: 20px">
				
				<li class="sidebar-toggler-wrapper hide">
					<div class="sidebar-toggler">
						<span></span>
					</div>
				</li>
				
				<li class="sidebar-search-wrapper"></li>
				<li class="nav-item start <?php if ($_GET['connect'] == "infographic-selling") { ?> active <?php } ?>">
					<a class="nav-link nav-toggle" href="?connect=infographic-selling-agent">
						<i class="icon-bar-chart"></i>
						<span class="title">
							Beranda
						</span>
					</a>
				</li>
				<li class="heading">
					<h3 class="uppercase">
						Transaksi
					</h3>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "item-selling") { ?> active <?php } ?>">
					<a class="nav-link nav-toggle" href="?connect=item-selling-agen">
						<i class="icon-basket"></i>
						<span class="title">
							Penjualan Barang
						</span>
					</a>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "item-selling") { ?> active <?php } ?>">
					<a class="nav-link nav-toggle" href="?connect=customer">
						<i class="icon-user"></i>
						<span class="title">
							Pelanggan
						</span>
					</a>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "komisi-agen") { ?> active <?php } ?>">
					<a class="nav-link nav-toggle" href="?connect=komisi-agen">
						<i class="icon-diamond"></i>
						<span class="title">
							Komisi
						</span>
					</a>
				</li>
				<li class="heading">
					<h3 class="uppercase">
						Laporan
					</h3>
				</li>
				<li class="nav-item">
					<a class="nav-link nav-toggle" href="javascript:;">
						<i class="icon-bar-chart"> </i>
						<span class="title">
							Laporan Agen
						</span>
						<span class="arrow"> </span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item">
							<a class="nav-link" href="?connect=selling-report-agen">
								<span class="title">
									Laporan Penjualan
								</span>
							</a>
						</li>
						<li class="nav-item">
				,			<a class="nav-link" href="?connect=commission-report-agen">
								<span class="title">
									Laporan Komisi
								</span>
							</a>
						</li>
					</ul>
				</li>
				
			</ul>
	<?php
		}
		else if($_SESSION['user_category_name'] == "Admin Penjualan")
		{
	?>
			<ul class="page-sidebar-menu page-header-fixed" data-auto-scroll="true" data-keep-expanded="false" data-slide-speed="200" style="padding-top: 20px">
				
				<li class="sidebar-toggler-wrapper hide">
					<div class="sidebar-toggler">
						<span></span>
					</div>
				</li>
				
				<li class="sidebar-search-wrapper"></li>
				<li class="nav-item start <?php if ($_GET['connect'] == "infographic-selling") { ?> active <?php } ?>">
					<a class="nav-link nav-toggle" href="?connect=infographic-selling">
						<i class="icon-bar-chart"></i>
						<span class="title">
							Beranda
						</span>
					</a>
				</li>
				<li class="heading">
					<h3 class="uppercase">
						PENJUALAN
					</h3>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "item-selling") { ?> active <?php } ?>">
					<a class="nav-link nav-toggle" href="?connect=item-selling">
						<i class="icon-basket"></i>
						<span class="title">
							Penjualan
						</span>
					</a>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "reseller") { ?> active <?php } ?>">
					<a href="?connect=reseller">
						<i class="icon-users"></i>
						<span class="title">
							Agen
						</span>
					</a>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "reseller-item-sell") { ?> active <?php } ?>">
					<a href="?connect=reseller-item-sell">
						<i class="icon-wrench"></i>
						<span class="title">
							Produk Jual Agen
						</span>
					</a>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "customer") { ?> active <?php } ?>">
					<a class="nav-link nav-toggle" href="?connect=customer">
						<i class="icon-user"></i>
						<span class="title">
							Pelanggan
						</span>
					</a>
				</li>
				<li class="heading">
					<h3 class="uppercase">
						MASTER
					</h3>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "item" || $_GET['connect'] == "item-category" || $_GET['connect'] == "stock-item") { ?> active <?php } ?>">
					<a class="nav-link nav-toggle" href="javascript:;">
						<i class="icon-basket"></i>
						<span class="title">
							Barang
						</span>
						<span class="arrow <?php if ($_GET['connect'] == "item") { ?> open <?php } ?>"></span>
						<span class="<?php if ($_GET['connect'] == "item") { ?> selected <?php } ?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item <?php if ($_GET['connect'] == "item-stock") { ?> active <?php } ?>">
							<a class="nav-link" href="?connect=item-stock">
								<span class="title">
									Stok Barang
								</span>
							</a>
						</li>
						<li class="nav-item <?php if ($_GET['connect'] == "barang-keluar") { ?> active <?php } ?>">
							<a class="nav-link" href="?connect=barang-keluar">
								<span class="title">
									Free Produk
								</span>
							</a>
						</li>
						<li class="nav-item <?php if ($_GET['connect'] == "penyesuaian-stok") { ?> active <?php } ?>">
							<a class="nav-link" href="?connect=penyesuaian-stok">
								<span class="title">
									Penyesuaian Stok
								</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="heading">
					<h3 class="uppercase">
						Laporan
					</h3>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "user") { ?> active <?php } ?>">
					<a class="nav-link nav-toggle" href="javascript:;">
						<i class="icon-bar-chart"></i>
						<span class="title">
							Laporan
						</span>
						<span class="arrow <?php if ($_GET['connect'] == "user") { ?> open <?php } ?>"></span>
						<span class="<?php if ($_GET['connect'] == "user") { ?> selected <?php } ?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item">
							<a class="nav-link nav-toggle" href="?connect=selling-report">
								<i class="icon-check"></i>
								<span class="title">
									Laporan Penjualan
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link nav-toggle" href="?connect=commission-report">
								<i class="icon-check"></i>
								<span class="title">
									Laporan Komisi
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link nav-toggle" href="?connect=customer-report">
								<i class="icon-user"></i>
								<span class="title">
									Laporan Pelanggan
								</span>
							</a>
						</li>
					</ul>
				</li>
			</ul>	
	<?php
		}
		else if($_SESSION['user_category_name'] == "Finance")
		{
	?>
			<ul class="page-sidebar-menu page-header-fixed" data-auto-scroll="true" data-keep-expanded="false" data-slide-speed="200" style="padding-top: 20px">
				
				<li class="sidebar-toggler-wrapper hide">
					<div class="sidebar-toggler">
						<span></span>
					</div>
				</li>
				
				<li class="sidebar-search-wrapper"></li>
				<li class="heading">
					<h3 class="uppercase">
						PENJUALAN
					</h3>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "komisi") { ?> active <?php } ?>">
					<a class="nav-link nav-toggle" href="?connect=komisi">
						<i class="icon-diamond"></i>
						<span class="title">
							Komisi
						</span>
					</a>
				</li>
				<li class="heading">
					<h3 class="uppercase">
						PEMBELIAN
					</h3>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "item-purchase") { ?> active <?php } ?>">
					<a class="nav-link nav-toggle" href="?connect=item-purchase">
						<i class="icon-wallet"></i>
						<span class="title">
							Pembelian
						</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="?connect=supplier">
						<i class="icon-social-dropbox"></i>
						<span class="title">
							Pemasok
						</span>
					</a>
				</li>
				<li class="heading">
					<h3 class="uppercase">
						MASTER
					</h3>
				</li>
				
				<li class="heading">
					<h3 class="uppercase">
						Laporan
					</h3>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "user") { ?> active <?php } ?>">
					<a class="nav-link nav-toggle" href="javascript:;">
						<i class="icon-bar-chart"></i>
						<span class="title">
							Laporan
						</span>
						<span class="arrow <?php if ($_GET['connect'] == "user") { ?> open <?php } ?>"></span>
						<span class="<?php if ($_GET['connect'] == "user") { ?> selected <?php } ?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item">
							<a class="nav-link nav-toggle" href="?connect=purchase-report">
								<i class="icon-bar-chart"></i>
								<span class="title">
									Laporan Pembelian
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link nav-toggle" href="?connect=commission-report">
								<i class="icon-bar-chart"></i>
								<span class="title">
									Laporan Komisi
								</span>
							</a>
						</li>
					</ul>
				</li>
			</ul>
	<?php
		}
		else
		{
	?>
	
			<ul class="page-sidebar-menu page-header-fixed" data-auto-scroll="true" data-keep-expanded="false" data-slide-speed="200" style="padding-top: 20px">
				
				<li class="sidebar-toggler-wrapper hide">
					<div class="sidebar-toggler">
						<span></span>
					</div>
				</li>
				
				<li class="sidebar-search-wrapper"></li>
				<li class="nav-item start <?php if ($_GET['connect'] == "infographic-selling") { ?> active <?php } ?>">
					<a class="nav-link nav-toggle" href="?connect=infographic-selling">
						<i class="icon-bar-chart"></i>
						<span class="title">
							Beranda
						</span>
					</a>
				</li>
				<li class="heading">
					<h3 class="uppercase">
						PENJUALAN
					</h3>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "item-selling") { ?> active <?php } ?>">
					<a class="nav-link nav-toggle" href="?connect=item-selling">
						<i class="icon-basket"></i>
						<span class="title">
							Penjualan
						</span>
					</a>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "komisi") { ?> active <?php } ?>">
					<a class="nav-link nav-toggle" href="?connect=komisi">
						<i class="icon-diamond"></i>
						<span class="title">
							Komisi
						</span>
					</a>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "reseller") { ?> active <?php } ?>">
					<a href="?connect=reseller">
						<i class="icon-users"></i>
						<span class="title">
							Agen
						</span>
					</a>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "reseller-item-sell") { ?> active <?php } ?>">
					<a href="?connect=reseller-item-sell">
						<i class="icon-layers"></i>
						<span class="title">
							Produk Jual Agen
						</span>
					</a>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "customer") { ?> active <?php } ?>">
					<a class="nav-link nav-toggle" href="?connect=customer">
						<i class="icon-user"></i>
						<span class="title">
							Pelanggan
						</span>
					</a>
				</li>
				<li class="heading">
					<h3 class="uppercase">
						PEMBELIAN
					</h3>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "item-purchase") { ?> active <?php } ?>">
					<a class="nav-link nav-toggle" href="?connect=item-purchase">
						<i class="icon-wallet"></i>
						<span class="title">
							Pembelian
						</span>
					</a>
				</li>
				<li class="nav-item">
					<a href="?connect=supplier">
						<i class="icon-social-dropbox"></i>
						<span class="title">
							Pemasok
						</span>
					</a>
				</li>
				<li class="heading">
					<h3 class="uppercase">
						MASTER
					</h3>
				</li>
			<!--
				<li class="nav-item <php if ($_GET['connect'] == "company") { ?> active <php } ?>">
					<a href="?connect=company">
						<i class="icon-home"></i>
						<span class="title">
							Profil Perusahaan
						</span>
					</a>
				</li>
				-->
				<li class="nav-item <?php if ($_GET['connect'] == "item" || $_GET['connect'] == "item-category" || $_GET['connect'] == "stock-item") { ?> active <?php } ?>">
					<a class="nav-link nav-toggle" href="javascript:;">
						<i class="icon-basket"></i>
						<span class="title">
							Barang
						</span>
						<span class="arrow <?php if ($_GET['connect'] == "item") { ?> open <?php } ?>"></span>
						<span class="<?php if ($_GET['connect'] == "item") { ?> selected <?php } ?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item <?php if ($_GET['connect'] == "item") { ?> active <?php } ?>">
							<a class="nav-link" href="?connect=item">
								<span class="title">
									Data Barang
								</span>
							</a>
						</li>
						<li class="nav-item <?php if ($_GET['connect'] == "item-category") { ?> active <?php } ?>">
							<a class="nav-link" href="?connect=item-category">
								<span class="title">
									Kategori Barang
								</span>
							</a>
						</li>
						<li class="nav-item <?php if ($_GET['connect'] == "item-stock") { ?> active <?php } ?>">
							<a class="nav-link" href="?connect=item-stock">
								<span class="title">
									Stok Barang
								</span>
							</a>
						</li>
						<li class="nav-item <?php if ($_GET['connect'] == "barang-keluar") { ?> active <?php } ?>">
							<a class="nav-link" href="?connect=barang-keluar">
								<span class="title">
									Free Produk
								</span>
							</a>
						</li>
						<li class="nav-item <?php if ($_GET['connect'] == "penyesuaian-stok") { ?> active <?php } ?>">
							<a class="nav-link" href="?connect=penyesuaian-stok">
								<span class="title">
									Penyesuaian Stok
								</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "user" || $_GET['connect'] == "user-category") { ?> active <?php } ?>">
					<a class="nav-link nav-toggle" href="javascript:;">
						<i class="icon-user"></i>
						<span class="title">
							Pengguna
						</span>
						<span class="arrow <?php if ($_GET['connect'] == "user") { ?> open <?php } ?>"></span>
						<span class="<?php if ($_GET['connect'] == "user") { ?> selected <?php } ?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item <?php if ($_GET['connect'] == "user") { ?> active <?php } ?>">
							<a class="nav-link" href="?connect=user">
								<span class="title">
									Data Pengguna
								</span>
							</a>
						</li>

						
					</ul>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "reward") { ?> active <?php } ?>">
					<a href="?connect=reward">
						<i class="icon-present"></i>
						<span class="title">
							Reward
						</span>
					</a>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "promo") { ?> active <?php } ?>">
					<a href="?connect=promo">
						<i class="icon-bag"></i>
						<span class="title">
							Promo
						</span>
					</a>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "delivery-service") { ?> active <?php } ?>">
					<a href="?connect=delivery-service">
						<i class="icon-bag"></i>
						<span class="title">
							Jasa Pengiriman
						</span>
					</a>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "marketplace") { ?> active <?php } ?>">
					<a href="?connect=marketplace">
						<i class="icon-bag"></i>
						<span class="title">
							Marketplace
						</span>
					</a>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "bank") { ?> active <?php } ?>">
					<a href="?connect=bank">
						<i class="icon-bag"></i>
						<span class="title">
							Bank
						</span>
					</a>
				</li>
				
				<li class="heading">
					<h3 class="uppercase">
						Laporan
					</h3>
				</li>
				<li class="nav-item <?php if ($_GET['connect'] == "user") { ?> active <?php } ?>">
					<a class="nav-link nav-toggle" href="javascript:;">
						<i class="icon-bar-chart"></i>
						<span class="title">
							Laporan
						</span>
						<span class="arrow <?php if ($_GET['connect'] == "user") { ?> open <?php } ?>"></span>
						<span class="<?php if ($_GET['connect'] == "user") { ?> selected <?php } ?>"></span>
					</a>
					<ul class="sub-menu">
						<li class="nav-item">
							<a class="nav-link nav-toggle" href="?connect=purchase-report">
								<i class="icon-check"></i>
								<span class="title">
									Laporan Pembelian
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link nav-toggle" href="?connect=selling-report">
								<i class="icon-check"></i>
								<span class="title">
									Laporan Penjualan
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link nav-toggle" href="?connect=commission-report">
								<i class="icon-check"></i>
								<span class="title">
									Laporan Komisi
								</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link nav-toggle" href="?connect=customer-report">
								<i class="icon-check"></i>
								<span class="title">
									Laporan Pelanggan
								</span>
							</a>
						</li>
					</ul>
				</li>
			</ul>
	
	<?php
		}
	?>	
	
</div>