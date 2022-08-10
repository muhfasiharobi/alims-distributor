<div class="page-sidebar-wrapper">
		<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
		<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
		<div class="page-sidebar navbar-collapse collapse">
				<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
				<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
				<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
				<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
				<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
				<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
				<ul class="page-sidebar-menu page-header-fixed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
				<?php
						if ($_SESSION['user_category_name'] == "Marketing Manager" || $_SESSION['user_category_name'] == "Sales Grosir and Retail Coordinator" || $_SESSION['user_category_name'] == "Sales Horeka Coordinator")
						{
				?>
						<li class="nav-item <?php if ($_GET['alimms'] == "dashboard") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle">
										<i class="icon-home font-blue"></i>
										<span class="title">
												Beranda
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['alimms'] == "dashboard") { ?> active open <?php } ?>">
												<a href="?alimms=dashboard" class="nav-link">
														<span class="title">
																Penjualan
														</span>
												</a>
										</li>
								</ul>
						</li>
						<li class="heading">
								<h3 class="uppercase">
										Master
								</h3>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "customer" || $_GET['alimms'] == "customer-area" || $_GET['alimms'] == "customer-category" || $_GET['alimms'] == "customer-city" || $_GET['alimms'] == "customer-class" || $_GET['alimms'] == "customer-districts" || $_GET['alimms'] == "customer-request") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle">
										<i class="icon-link font-blue"></i>
										<span class="title">
												Pelanggan
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['alimms'] == "customer") { ?> active open <?php } ?>">
												<a href="?alimms=customer" class="nav-link">
														<span class="title">
																Pelanggan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "customer-area") { ?> active open <?php } ?>">
												<a href="?alimms=customer-area" class="nav-link">
														<span class="title">
																Rayon Pelanggan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "customer-category") { ?> active open <?php } ?>">
												<a href="?alimms=customer-category" class="nav-link">
													<span class="title">
														Kategori Pelanggan
													</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "customer-city") { ?> active open <?php } ?>">
												<a href="?alimms=customer-city" class="nav-link">
														<span class="title">
																Kota/ Kabupaten Pelanggan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "customer-class") { ?> active open <?php } ?>">
												<a href="?alimms=customer-class" class="nav-link">
														<span class="title">
																Kelas Pelanggan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "customer-districts") { ?> active open <?php } ?>">
												<a href="?alimms=customer-districts" class="nav-link">
														<span class="title">
																Kecamatan Pelanggan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "customer-request") { ?> active open <?php } ?>">
												<a href="?alimms=customer-request" class="nav-link">
														<span class="title">
																Permintaan Pelanggan
														</span>
												</a>
										</li>
								</ul>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "sales-plan" || $_GET['alimms'] == "sales-target")  { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle" >
										<i class="icon-basket font-blue"></i>
										<span class="title">
												Penjualan
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
                                        <li class="nav-item <?php if ($_GET['alimms'] == "sales-schedule") { ?> active open <?php } ?>">
												<a href="?alimms=sales-schedule" class="nav-link">
														<span class="title">
																Jadwal Penjualan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "sales-plan") { ?> active open <?php } ?>">
												<a href="?alimms=sales-plan" class="nav-link">
														<span class="title">
																Rencana Penjualan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "sales-target") { ?> active open <?php } ?>">
												<a href="?alimms=sales-target" class="nav-link">
														<span class="title">
																Target Penjualan
														</span>
												</a>
										</li>
										
								</ul>
						</li>											
						<li class="heading">
								<h3 class="uppercase">
										Penjualan
								</h3>
						</li>			
						<li class="nav-item <?php if ($_GET['alimms'] == "sales-request") { ?> active open <?php } ?>">
								<a href="?alimms=sales-request" class="nav-link">
										<i class="icon-note font-blue"></i>
										<span class="title">
												Permintaan Penjualan
										</span>
								</a>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "sales-request-galon") { ?> active open <?php } ?>">
								<a href="?alimms=sales-request-galon" class="nav-link">
										<i class="icon-note font-blue"></i>
										<span class="title">
												Permintaan Penjualan Galon
										</span>
								</a>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "sales-order") { ?> active open <?php } ?>">
								<a href="?alimms=sales-order" class="nav-link">
										<i class="icon-share-alt font-blue"></i>
										<span class="title">
												Pesanan Penjualan
										</span>
								</a>
						</li>
						<li class="heading">
								<h3 class="uppercase">
										Laporan
								</h3>
						</li>		
						<li class="nav-item <?php if ($_GET['alimms'] == "customer-report") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle">
										<i class="icon-link font-blue"></i>
										<span class="title">
												Pelanggan
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-customer-city-by-customer-quantity-customer-report" || $_GET['tib'] == "form-view-customer-city-by-customer-quantity-customer-report") { ?> active open <?php } ?>">
												<a href="?alimms=customer-report&tib=form-search-customer-city-by-customer-quantity-customer-report" class="nav-link">
														<span class="title">
																Per Kota/ Kabupaten<br />
																Berdasarkan Jumlah Pelanggan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-customer-districts-by-customer-quantity-customer-report" || $_GET['tib'] == "form-view-customer-districts-by-customer-quantity-customer-report") { ?> active open <?php } ?>">
												<a href="?alimms=customer-report&tib=form-search-customer-districts-by-customer-quantity-customer-report" class="nav-link">
														<span class="title">
																Per Kecamatan<br />
																Berdasarkan Jumlah Pelanggan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-salesman-by-customer-quantity-customer-report" || $_GET['tib'] == "form-view-salesman-by-customer-quantity-customer-report") { ?> active open <?php } ?>">
												<a href="?alimms=customer-report&tib=form-search-salesman-by-customer-quantity-customer-report" class="nav-link">
														<span class="title">
																Per Salesman<br />
																Berdasarkan Jumlah Pelanggan
														</span>
												</a>
										</li>
								</ul>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "request-report") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle">
										<i class="icon-doc font-blue"></i>
										<span class="title">
												Permintaan
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-customer-city-by-customer-category-request-report" || $_GET['tib'] == "form-view-customer-city-by-customer-category-request-report") { ?> active open <?php } ?>">
												<a href="?alimms=request-report&tib=form-search-customer-city-by-customer-category-request-report" class="nav-link">
														<span class="title">
																Per Kecamatan<br />
																Berdasarkan Kategori Pelanggan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-salesman-by-order-method-request-report" || $_GET['tib'] == "form-view-salesman-by-order-method-request-report") { ?> active open <?php } ?>">
												<a href="?alimms=request-report&tib=form-search-salesman-by-order-method-request-report" class="nav-link">
														<span class="title">
																Per Salesman<br />
																Berdasarkan Cara Pesanan
														</span>
												</a>
										</li>
								</ul>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "sales-report") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle">
										<i class="icon-basket-loaded font-blue"></i>
										<span class="title">
												Penjualan
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-customer-by-quantity-product-sell-sales-report" || $_GET['tib'] == "form-view-customer-by-quantity-product-sell-sales-report") { ?> active open <?php } ?>">
												<a href="?alimms=sales-report&tib=form-search-customer-by-quantity-product-sell-sales-report" class="nav-link">
														<span class="title">
																Per Pelanggan<br />
																Berdasarkan Jumlah Produk (Frekuensi Pesanan)
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-customer-city-by-sales-product-sell-sales-report" || $_GET['tib'] == "form-view-customer-city-by-sales-product-sell-sales-report") { ?> active open <?php } ?>">
												<a href="?alimms=sales-report&tib=form-search-customer-city-by-sales-product-sell-sales-report" class="nav-link">
														<span class="title">
																Per Kota/ Kabupaten<br />
																Berdasarkan Penjualan Produk
														</span>
												</a>
										</li>
										<li class="nav-item  <?php if ($_GET['tib'] == "form-search-customer-city-by-quantity-product-sell-sales-report" || $_GET['tib'] == "form-view-customer-city-by-quantity-product-sell-sales-report") { ?> active open <?php } ?>">
												<a href="?alimms=sales-report&tib=form-search-customer-city-by-quantity-product-sell-sales-report" class="nav-link">
														<span class="title">
																Per Kota/ Kabupaten<br />
																Berdasarkan Jumlah Produk
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-salesman-by-sales-invoice-sales-report" || $_GET['tib'] == "form-view-salesman-by-sales-invoice-sales-report") { ?> active open <?php } ?>">
												<a href="?alimms=sales-report&tib=form-search-salesman-by-sales-invoice-sales-report" class="nav-link">
														<span class="title">
																Per Salesman<br />
																Berdasarkan Faktur Penjualan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-salesman-by-sales-product-sell-sales-report" || $_GET['tib'] == "form-view-salesman-by-sales-product-sell-sales-report") { ?> active open <?php } ?>">
												<a href="?alimms=sales-report&tib=form-search-salesman-by-sales-product-sell-sales-report" class="nav-link">
														<span class="title">
																Per Salesman<br />
																Berdasarkan Penjualan Produk
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-salesman-by-quantity-product-sell-sales-report" || $_GET['tib'] == "form-view-salesman-by-quantity-product-sell-sales-report") { ?> active open <?php } ?>">
												<a href="?alimms=sales-report&tib=form-search-salesman-by-quantity-product-sell-sales-report" class="nav-link">
														<span class="title">
																Per Salesman<br />
																Berdasarkan Jumlah Produk
														</span>
												</a>
										</li>
								</ul>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "sales-visit-report") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle">
										<i class="icon-direction font-blue"></i>
										<span class="title">
												Kunjungan
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-salesman-by-count-visit-sales-visit-report" || $_GET['tib'] == "form-view-salesman-by-count-visit-sales-visit-report") { ?> active open <?php } ?>">
												<a href="?alimms=sales-visit-report&tib=form-search-salesman-by-count-visit-sales-visit-report" class="nav-link">
														<span class="title">
																Per Salesman<br />
																Berdasarkan Jumlah Kunjungan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-salesman-by-time-visit-sales-visit-report" || $_GET['tib'] == "form-view-salesman-by-time-visit-sales-visit-report") { ?> active open <?php } ?>">
												<a href="?alimms=sales-visit-report&tib=form-search-salesman-by-time-visit-sales-visit-report" class="nav-link">
														<span class="title">
																Per Salesman<br />
																Berdasarkan Waktu Kunjungan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-call-book-salesman") { ?> active open <?php } ?>">
												<a href="?alimms=sales-visit-report&tib=form-search-call-book-salesman" class="nav-link">
														<span class="title">
																Per Salesman<br />
																Berdasarkan Stok Toko
														</span>
												</a>
										</li>
								</ul>
						</li>
				<?php
						}
						elseif ($_SESSION['user_category_name'] == "Salesman Grosir" || $_SESSION['user_category_name'] == "Salesman Horeka" || $_SESSION['user_category_name'] == "Salesman Retail")
						{
				?>
						<li class="nav-item">
								<a href="?alimms=dashboard" class="nav-link">
										<i class="icon-home font-blue"></i>
										<span class="title">
												Beranda
										</span>
								</a>
						</li>
						<li class="heading">
								<h3 class="uppercase">
										Pelanggan
								</h3>
						</li>			
						<li class="nav-item">
								<a href="?alimms=dashboard&tib=form-view-customer-request-dashboard" class="nav-link">
										<span class="title">
												Permintaan Pelanggan
										</span>
								</a>
						</li>
                        <li class="nav-item">
								<a href="?alimms=dashboard&tib=form-view-sales-schedule-by-sales" class="nav-link">
										<span class="title">
												Rencana Kerja
										</span>
								</a>
						</li>
						<li class="nav-item">
								<a href="?alimms=dashboard&tib=form-search-call-book-salesman-dashboard" class="nav-link">
										<span class="title">
												Histori Stok Pelanggan
										</span>
								</a>
						</li>
				<?php
						}
						elseif ($_SESSION['user_category_name'] == "Billingman")
						{
				?>
						<li class="nav-item">
								<a href="?alimms=dashboard" class="nav-link">
										<i class="icon-home font-blue"></i>
										<span class="title">
												Beranda
										</span>
								</a>
						</li>
				<?php
						}
						elseif ($_SESSION['user_category_name'] == "Logistic and Delivery Manager")
						{
				?>
						<li class="nav-item <?php if ($_GET['alimms'] == "dashboard") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle">
										<i class="icon-home font-blue"></i>
										<span class="title">
												Beranda
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item">
												<a href="?alimms=dashboard" class="nav-link">
														<span class="title">
																Penjualan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "dashboard") { ?> active open <?php } ?>">
												<a href="?alimms=dashboard" class="nav-link">
														<span class="title">
																Logistik dan pengiriman
														</span>
												</a>
										</li>
										<li class="nav-item">
												<a href="javascript:;" class="nav-link">
														<span class="title">
																Produksi
														</span>
												</a>
										</li>
								</ul>
						</li>
				<?php
						}
						elseif ($_SESSION['user_category_name'] == "Accounting and Finance Manager" || $_SESSION['user_category_name'] == "Facturist")
						{
				?>
						<li class="nav-item <?php if ($_GET['alimms'] == "dashboard") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle">
										<i class="icon-home font-blue"></i>
										<span class="title">
												Beranda
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item">
												<a href="?alimms=dashboard" class="nav-link">
														<span class="title">
																Penagihan
														</span>
												</a>
										</li>
								</ul>
						</li>
						<li class="heading">
								<h3 class="uppercase">
										Master
								</h3>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "billing-plan") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle">
										<i class="icon-wallet font-blue"></i>
										<span class="title">
												Penagihan
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['alimms'] == "billing-plan") { ?> active open <?php } ?>">
												<a href="?alimms=billing-plan" class="nav-link">
														<span class="title">
																Rencana Penagihan
														</span>
												</a>
										</li>
								</ul>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "payment-category" || $_GET['alimms'] == "payment-overdue") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle" >
										<i class="icon-calendar font-blue"></i>
										<span class="title">
												Pembayaran
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['alimms'] == "payment-category") { ?> active open <?php } ?>">
												<a href="?alimms=payment-category" class="nav-link">
														<span class="title">
																Kategori Pembayaran
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "payment-overdue") { ?> active open <?php } ?>">
												<a href="?alimms=payment-overdue" class="nav-link">
														<span class="title">
																Jatuh Tempo Pembayaran
														</span>
												</a>
										</li>
								</ul>
						</li>
						<li class="heading">
								<h3 class="uppercase">
										Keuangan
								</h3>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "sales-invoice") { ?> active open <?php } ?>">
								<a href="?alimms=sales-invoice" class="nav-link">
										<i class="icon-credit-card font-blue"></i>
										<span class="title">
												Faktur Penjualan
										</span>
								</a>
						</li>
						<li class="heading">
								<h3 class="uppercase">
										Pembayaran
								</h3>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "payment-request") { ?> active open <?php } ?>">
								<a href="?alimms=payment-request" class="nav-link">
										<i class="icon-calculator font-blue"></i>
										<span class="title">
												Pesanan Pembayaran
										</span>
								</a>
						</li>
						<li class="heading">
								<h3 class="uppercase">
										Kunjungan
								</h3>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "billing-visit") { ?> active open <?php } ?>">
								<a href="?alimms=billing-visit" class="nav-link">
										<i class="icon-handbag font-blue"></i>
										<span class="title">
												Kunjungan Penagihan
										</span>
								</a>
						</li>
                                 <?php
						}
						elseif ($_SESSION['user_category_name'] == "IT Manager")
						{
				?>
							<li class="heading">
								<h3 class="uppercase">
										Master
								</h3>
							</li>
							<li class="nav-item <?php if ($_GET['alimms'] == "customer" || $_GET['alimms'] == "customer-area" || $_GET['alimms'] == "customer-category" || $_GET['alimms'] == "customer-city" || $_GET['alimms'] == "customer-class" || $_GET['alimms'] == "customer-districts" || $_GET['alimms'] == "customer-request") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle">
										<i class="icon-link font-blue"></i>
										<span class="title">
												Pelanggan
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['alimms'] == "customer") { ?> active open <?php } ?>">
												<a href="?alimms=customer" class="nav-link">
														<span class="title">
																Pelanggan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "customer-area") { ?> active open <?php } ?>">
												<a href="?alimms=customer-area" class="nav-link">
														<span class="title">
																Rayon Pelanggan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "customer-category") { ?> active open <?php } ?>">
												<a href="?alimms=customer-category" class="nav-link">
													<span class="title">
														Kategori Pelanggan
													</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "customer-city") { ?> active open <?php } ?>">
												<a href="?alimms=customer-city" class="nav-link">
														<span class="title">
																Kota/ Kabupaten Pelanggan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "customer-class") { ?> active open <?php } ?>">
												<a href="?alimms=customer-class" class="nav-link">
														<span class="title">
																Kelas Pelanggan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "customer-districts") { ?> active open <?php } ?>">
												<a href="?alimms=customer-districts" class="nav-link">
														<span class="title">
																Kecamatan Pelanggan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "customer-request") { ?> active open <?php } ?>">
												<a href="?alimms=customer-request" class="nav-link">
														<span class="title">
																Permintaan Pelanggan
														</span>
												</a>
										</li>
								</ul>
							</li>
							<li class="heading">
								<h3 class="uppercase">
										Penjualan
								</h3>
							</li>			
							<li class="nav-item <?php if ($_GET['alimms'] == "sales-request") { ?> active open <?php } ?>">
									<a href="?alimms=sales-request" class="nav-link">
											<i class="icon-note font-blue"></i>
											<span class="title">
													Permintaan Penjualan
											</span>
									</a>
							</li>
							<li class="nav-item <?php if ($_GET['alimms'] == "sales-order") { ?> active open <?php } ?>">
									<a href="?alimms=sales-order" class="nav-link">
											<i class="icon-share-alt font-blue"></i>
											<span class="title">
													Pesanan Penjualan
											</span>
									</a>
							</li>
							<li class="heading">
								<h3 class="uppercase">
										Keuangan
								</h3>
							</li>
							<li class="nav-item <?php if ($_GET['alimms'] == "sales-invoice") { ?> active open <?php } ?>">
									<a href="?alimms=sales-invoice" class="nav-link">
											<i class="icon-credit-card font-blue"></i>
											<span class="title">
													Faktur Penjualan
											</span>
									</a>
							</li>
							<li class="heading">
								<h3 class="uppercase">
										Laporan
								</h3>
							</li>
							<li class="nav-item <?php if ($_GET['alimms'] == "sales-report") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle">
										<i class="icon-basket-loaded font-blue"></i>
										<span class="title">
												Penjualan
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-salesman-by-sales-invoice-sales-report" || $_GET['tib'] == "form-view-salesman-by-sales-invoice-sales-report") { ?> active open <?php } ?>">
												<a href="?alimms=sales-report&tib=form-search-salesman-by-sales-invoice-sales-report-edit" class="nav-link">
														<span class="title">
																Per Salesman<br />
																Berdasarkan Faktur Penjualan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-salesman-by-sales-product-sell-sales-report" || $_GET['tib'] == "form-view-salesman-by-sales-product-sell-sales-report") { ?> active open <?php } ?>">
												<a href="?alimms=sales-report&tib=form-search-salesman-by-sales-product-sell-sales-report" class="nav-link">
														<span class="title">
																Per Salesman<br />
																Berdasarkan Penjualan Produk
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-salesman-by-quantity-product-sell-sales-report" || $_GET['tib'] == "form-view-salesman-by-quantity-product-sell-sales-report") { ?> active open <?php } ?>">
												<a href="?alimms=sales-report&tib=form-search-salesman-by-quantity-product-sell-sales-report" class="nav-link">
														<span class="title">
																Per Salesman<br />
																Berdasarkan Jumlah Produk
														</span>
												</a>
										</li>
								</ul>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "sales-visit-report") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle">
										<i class="icon-direction font-blue"></i>
										<span class="title">
												Kunjungan
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-call-book-salesman") { ?> active open <?php } ?>">
												<a href="?alimms=sales-visit-report&tib=form-search-call-book-salesman-edit" class="nav-link">
														<span class="title">
																Per Salesman<br />
																Berdasarkan Stok Toko
														</span>
												</a>
										</li>
								</ul>
						</li>
				<?php
						}
						else
						{
				?>
						<li class="nav-item <?php if ($_GET['alimms'] == "dashboard") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle">
										<i class="icon-home font-blue"></i>
										<span class="title">
												Beranda
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['alimms'] == "dashboard") { ?> active open <?php } ?>">
												<a href="?alimms=dashboard" class="nav-link">
														<span class="title">
																Penjualan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "dashboard") { ?> active open <?php } ?>">
												<a href="?alimms=dashboard" class="nav-link">
														<span class="title">
																Logistik dan pengiriman
														</span>
												</a>
										</li>
										<li class="nav-item">
												<a href="javascript:;" class="nav-link">
														<span class="title">
																Produksi
														</span>
												</a>
										</li>
								</ul>
						</li>
						<li class="heading">
								<h3 class="uppercase">
										Master
								</h3>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "billing-plan") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle">
										<i class="icon-wallet font-blue"></i>
										<span class="title">
												Penagihan
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['alimms'] == "billing-plan") { ?> active open <?php } ?>">
												<a href="?alimms=billing-plan" class="nav-link">
														<span class="title">
																Rencana Penagihan
														</span>
												</a>
										</li>
								</ul>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "customer" || $_GET['alimms'] == "customer-area" || $_GET['alimms'] == "customer-category" || $_GET['alimms'] == "customer-city" || $_GET['alimms'] == "customer-class" || $_GET['alimms'] == "customer-districts" || $_GET['alimms'] == "customer-request") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle">
										<i class="icon-link font-blue"></i>
										<span class="title">
												Pelanggan
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['alimms'] == "customer") { ?> active open <?php } ?>">
												<a href="?alimms=customer" class="nav-link">
														<span class="title">
																Pelanggan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "customer-area") { ?> active open <?php } ?>">
												<a href="?alimms=customer-area" class="nav-link">
														<span class="title">
																Rayon Pelanggan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "customer-category") { ?> active open <?php } ?>">
												<a href="?alimms=customer-category" class="nav-link">
													<span class="title">
														Kategori Pelanggan
													</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "customer-galon-category") { ?> active open <?php } ?>">
												<a href="?alimms=customer-galon-category" class="nav-link">
													<span class="title">
														Kategori Pelanggan Galon
													</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "customer-city") { ?> active open <?php } ?>">
												<a href="?alimms=customer-city" class="nav-link">
														<span class="title">
																Kota/ Kabupaten Pelanggan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "customer-class") { ?> active open <?php } ?>">
												<a href="?alimms=customer-class" class="nav-link">
														<span class="title">
																Kelas Pelanggan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "customer-districts") { ?> active open <?php } ?>">
												<a href="?alimms=customer-districts" class="nav-link">
														<span class="title">
																Kecamatan Pelanggan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "customer-request") { ?> active open <?php } ?>">
												<a href="?alimms=customer-request" class="nav-link">
														<span class="title">
																Permintaan Pelanggan
														</span>
												</a>
										</li>
								</ul>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "delivery-cost" || $_GET['alimms'] == "delivery-schedule" || $_GET['alimms'] == "delivery-session" || $_GET['alimms'] == "delivery-vehicle") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle" >
										<i class="icon-directions font-blue"></i>
										<span class="title">
												Pengiriman
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['alimms'] == "delivery-cost") { ?> active open <?php } ?>">
												<a href="?alimms=delivery-cost" class="nav-link">
														<span class="title">
																Biaya Pengiriman
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "delivery-schedule") { ?> active open <?php } ?>">
												<a href="?alimms=delivery-schedule" class="nav-link">
														<span class="title">
																Jadwal Pengiriman
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "delivery-session") { ?> active open <?php } ?>">
												<a href="?alimms=delivery-session" class="nav-link">
														<span class="title">
																Sesi Pengiriman
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "delivery-vehicle") { ?> active open <?php } ?>">
												<a href="?alimms=delivery-vehicle" class="nav-link">
														<span class="title">
																Kendaraan Pengiriman
														</span>
												</a>
										</li>
								</ul>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "payment-category" || $_GET['alimms'] == "payment-overdue") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle" >
										<i class="icon-calendar font-blue"></i>
										<span class="title">
												Pembayaran
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['alimms'] == "payment-category") { ?> active open <?php } ?>">
												<a href="?alimms=payment-category" class="nav-link">
														<span class="title">
																Kategori Pembayaran
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "payment-overdue") { ?> active open <?php } ?>">
												<a href="?alimms=payment-overdue" class="nav-link">
														<span class="title">
																Jatuh Tempo Pembayaran
														</span>
												</a>
										</li>
								</ul>
						</li>	
						<li class="nav-item <?php if ($_GET['alimms'] == "product-buy" || $_GET['alimms'] == "product-category" || $_GET['alimms'] == "product-promo" || $_GET['alimms'] == "product-sell" || $_GET['alimms'] == "product-sell-price" || $_GET['alimms'] == "product-unit") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle">
										<i class="icon-bulb font-blue"></i>
										<span class="title">
												Produk
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['alimms'] == "product-buy") { ?> active open <?php } ?>">
												<a href="?alimms=product-buy" class="nav-link">
														<span class="title">
																Produk Beli
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "product-category") { ?> active open <?php } ?>">
												<a href="?alimms=product-category" class="nav-link">
														<span class="title">
																Kategori Produk
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "product-promo") { ?> active open <?php } ?>">
												<a href="?alimms=product-promo" class="nav-link">
														<span class="title">
																Promo Produk
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "galon-promo") { ?> active open <?php } ?>">
												<a href="?alimms=galon-promo" class="nav-link">
														<span class="title">
																Promo Galon
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "product-sell") { ?> active open <?php } ?>">
												<a href="?alimms=product-sell" class="nav-link">
														<span class="title">
																Produk Jual
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "product-sell-price") { ?> active open <?php } ?>">
												<a href="?alimms=product-sell-price" class="nav-link">
														<span class="title">
																Harga Produk Jual
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "product-unit") { ?> active open <?php } ?>">
												<a href="?alimms=product-unit" class="nav-link">
														<span class="title">
																Satuan Produk
														</span>
												</a>
										</li>
								</ul>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "sales-plan" || $_GET['alimms'] == "sales-target") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle" >
										<i class="icon-basket font-blue"></i>
										<span class="title">
												Penjualan
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
                                                                                <li class="nav-item <?php if ($_GET['alimms'] == "sales-schedule") { ?> active open <?php } ?>">
												<a href="?alimms=sales-schedule" class="nav-link">
														<span class="title">
																Jadwal Penjualan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "sales-plan") { ?> active open <?php } ?>">
												<a href="?alimms=sales-plan" class="nav-link">
														<span class="title">
																Rencana Penjualan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "sales-target") { ?> active open <?php } ?>">
												<a href="?alimms=sales-target" class="nav-link">
														<span class="title">
																Target Penjualan
														</span>
												</a>
										</li>
								</ul>
						</li>					
						<li class="nav-item <?php if ($_GET['alimms'] == "supplier") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle" >
										<i class="icon-cloud-upload font-blue"></i>
										<span class="title">
												Pemasok
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['alimms'] == "supplier") { ?> active open <?php } ?>">
												<a href="?alimms=supplier" class="nav-link">
														<span class="title">
																Pemasok
														</span>
												</a>
										</li>
								</ul>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "user" || $_GET['alimms'] == "user-category" || $_GET['alimms'] == "user-department") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle" >
										<i class="icon-users font-blue"></i>
										<span class="title">
												Pengguna
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['alimms'] == "user") { ?> active open <?php } ?>">
												<a href="?alimms=user" class="nav-link">
														<span class="title">
																Pengguna
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "user-category") { ?> active open <?php } ?>">
												<a href="?alimms=user-category" class="nav-link">
														<span class="title">
																Kategori Pengguna
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['alimms'] == "user-department") { ?> active open <?php } ?>">
												<a href="?alimms=user-department" class="nav-link">
														<span class="title">
																Departemen Pengguna
														</span>
												</a>
										</li>
								</ul>
						</li>						
						<li class="heading">
								<h3 class="uppercase">
										Penjualan
								</h3>
						</li>			
						<li class="nav-item <?php if ($_GET['alimms'] == "sales-request") { ?> active open <?php } ?>">
								<a href="?alimms=sales-request" class="nav-link">
										<i class="icon-note font-blue"></i>
										<span class="title">
												Permintaan Penjualan
										</span>
								</a>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "sales-request-galon") { ?> active open <?php } ?>">
								<a href="?alimms=sales-request-galon" class="nav-link">
										<i class="icon-note font-blue"></i>
										<span class="title">
												Permintaan Penjualan Galon
										</span>
								</a>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "sales-order") { ?> active open <?php } ?>">
								<a href="?alimms=sales-order" class="nav-link">
										<i class="icon-share-alt font-blue"></i>
										<span class="title">
												Pesanan Penjualan
										</span>
								</a>
						</li>
						<li class="heading">
								<h3 class="uppercase">
										Keuangan
								</h3>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "sales-invoice") { ?> active open <?php } ?>">
								<a href="?alimms=sales-invoice" class="nav-link">
										<i class="icon-credit-card font-blue"></i>
										<span class="title">
												Faktur Penjualan
										</span>
								</a>
						</li>
						<li class="heading">
								<h3 class="uppercase">
										Pembayaran
								</h3>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "payment-order") { ?> active open <?php } ?>">
								<a href="?alimms=payment-order" class="nav-link">
										<i class="icon-calculator font-blue"></i>
										<span class="title">
												Pesanan Pembayaran
										</span>
								</a>
						</li>
						<li class="heading">
								<h3 class="uppercase">
										Kunjungan
								</h3>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "sales-visit") { ?> active open <?php } ?>">
								<a href="?alimms=sales-visit" class="nav-link">
										<i class="icon-direction font-blue"></i>
										<span class="title">
												Kunjungan Penjualan
										</span>
								</a>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "billing-visit") { ?> active open <?php } ?>">
								<a href="?alimms=billing-visit" class="nav-link">
										<i class="icon-handbag font-blue"></i>
										<span class="title">
												Kunjungan Penagihan
										</span>
								</a>
						</li>
						<li class="heading">
								<h3 class="uppercase">
										Laporan
								</h3>
						</li>		
						<li class="nav-item <?php if ($_GET['alimms'] == "customer-report") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle">
										<i class="icon-link font-blue"></i>
										<span class="title">
												Pelanggan
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-customer-city-by-customer-quantity-customer-report" || $_GET['tib'] == "form-view-customer-city-by-customer-quantity-customer-report") { ?> active open <?php } ?>">
												<a href="?alimms=customer-report&tib=form-search-customer-city-by-customer-quantity-customer-report" class="nav-link">
														<span class="title">
																Per Kota/ Kabupaten<br />
																Berdasarkan Jumlah Pelanggan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-customer-districts-by-customer-quantity-customer-report" || $_GET['tib'] == "form-view-customer-districts-by-customer-quantity-customer-report") { ?> active open <?php } ?>">
												<a href="?alimms=customer-report&tib=form-search-customer-districts-by-customer-quantity-customer-report" class="nav-link">
														<span class="title">
																Per Kecamatan<br />
																Berdasarkan Jumlah Pelanggan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-salesman-by-customer-quantity-customer-report" || $_GET['tib'] == "form-view-salesman-by-customer-quantity-customer-report") { ?> active open <?php } ?>">
												<a href="?alimms=customer-report&tib=form-search-salesman-by-customer-quantity-customer-report" class="nav-link">
														<span class="title">
																Per Salesman<br />
																Berdasarkan Jumlah Pelanggan
														</span>
												</a>
										</li>
								</ul>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "request-report") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle">
										<i class="icon-doc font-blue"></i>
										<span class="title">
												Permintaan
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-customer-city-by-customer-category-request-report" || $_GET['tib'] == "form-view-customer-city-by-customer-category-request-report") { ?> active open <?php } ?>">
												<a href="?alimms=request-report&tib=form-search-customer-city-by-customer-category-request-report" class="nav-link">
														<span class="title">
																Per Kecamatan<br />
																Berdasarkan Kategori Pelanggan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-salesman-by-order-method-request-report" || $_GET['tib'] == "form-view-salesman-by-order-method-request-report") { ?> active open <?php } ?>">
												<a href="?alimms=request-report&tib=form-search-salesman-by-order-method-request-report" class="nav-link">
														<span class="title">
																Per Salesman<br />
																Berdasarkan Cara Pesanan
														</span>
												</a>
										</li>
								</ul>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "sales-report") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle">
										<i class="icon-basket-loaded font-blue"></i>
										<span class="title">
												Penjualan
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-customer-by-quantity-product-sell-sales-report" || $_GET['tib'] == "form-view-customer-by-quantity-product-sell-sales-report") { ?> active open <?php } ?>">
												<a href="?alimms=sales-report&tib=form-search-customer-by-quantity-product-sell-sales-report" class="nav-link">
														<span class="title">
																Per Pelanggan<br />
																Berdasarkan Jumlah Produk (Frekuensi Pesanan)
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-customer-city-by-sales-product-sell-sales-report" || $_GET['tib'] == "form-view-customer-city-by-sales-product-sell-sales-report") { ?> active open <?php } ?>">
												<a href="?alimms=sales-report&tib=form-search-customer-city-by-sales-product-sell-sales-report" class="nav-link">
														<span class="title">
																Per Kota/ Kabupaten<br />
																Berdasarkan Penjualan Produk
														</span>
												</a>
										</li>
										<li class="nav-item  <?php if ($_GET['tib'] == "form-search-customer-city-by-quantity-product-sell-sales-report" || $_GET['tib'] == "form-view-customer-city-by-quantity-product-sell-sales-report") { ?> active open <?php } ?>">
												<a href="?alimms=sales-report&tib=form-search-customer-city-by-quantity-product-sell-sales-report" class="nav-link">
														<span class="title">
																Per Kota/ Kabupaten<br />
																Berdasarkan Jumlah Produk
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-salesman-by-sales-invoice-sales-report" || $_GET['tib'] == "form-view-salesman-by-sales-invoice-sales-report") { ?> active open <?php } ?>">
												<a href="?alimms=sales-report&tib=form-search-salesman-by-sales-invoice-sales-report" class="nav-link">
														<span class="title">
																Per Salesman<br />
																Berdasarkan Faktur Penjualan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-salesman-by-sales-product-sell-sales-report" || $_GET['tib'] == "form-view-salesman-by-sales-product-sell-sales-report") { ?> active open <?php } ?>">
												<a href="?alimms=sales-report&tib=form-search-salesman-by-sales-product-sell-sales-report" class="nav-link">
														<span class="title">
																Per Salesman<br />
																Berdasarkan Penjualan Produk
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-salesman-by-quantity-product-sell-sales-report" || $_GET['tib'] == "form-view-salesman-by-quantity-product-sell-sales-report") { ?> active open <?php } ?>">
												<a href="?alimms=sales-report&tib=form-search-salesman-by-quantity-product-sell-sales-report" class="nav-link">
														<span class="title">
																Per Salesman<br />
																Berdasarkan Jumlah Produk
														</span>
												</a>
										</li>
								</ul>
						</li>
						<li class="nav-item <?php if ($_GET['alimms'] == "sales-visit-report") { ?> active open <?php } ?>">
								<a href="javascript:;" class="nav-link nav-toggle">
										<i class="icon-direction font-blue"></i>
										<span class="title">
												Kunjungan
										</span>
										<span class="arrow"></span>
								</a>
								<ul class="sub-menu">
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-salesman-by-count-visit-sales-visit-report" || $_GET['tib'] == "form-view-salesman-by-count-visit-sales-visit-report") { ?> active open <?php } ?>">
												<a href="?alimms=sales-visit-report&tib=form-search-salesman-by-count-visit-sales-visit-report" class="nav-link">
														<span class="title">
																Per Salesman<br />
																Berdasarkan Jumlah Kunjungan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-salesman-by-time-visit-sales-visit-report" || $_GET['tib'] == "form-view-salesman-by-time-visit-sales-visit-report") { ?> active open <?php } ?>">
												<a href="?alimms=sales-visit-report&tib=form-search-salesman-by-time-visit-sales-visit-report" class="nav-link">
														<span class="title">
																Per Salesman<br />
																Berdasarkan Waktu Kunjungan
														</span>
												</a>
										</li>
										<li class="nav-item <?php if ($_GET['tib'] == "form-search-call-book-salesman") { ?> active open <?php } ?>">
												<a href="?alimms=sales-visit-report&tib=form-search-call-book-salesman" class="nav-link">
														<span class="title">
																Per Salesman<br />
																Berdasarkan Stok Toko
														</span>
												</a>
										</li>
								</ul>
						</li>
				<?php
						}
				?>
				</ul>
		</div>
</div>