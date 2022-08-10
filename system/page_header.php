<header class="page-header">
	<nav class="navbar" role="navigation">
		<div class="container-fluid">
			<div class="havbar-header">
				<a id="index" class="navbar-brand" href="?alimms=dashboard">
					<img src="../assets/layouts/layout6/img/logo.png" alt="Logo">
				</a>
				<div class="topbar-actions">
					<!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
					
					<div class="btn-group-notification btn-group" id="header_notification_bar">
						<button type="button" class="btn">
							<span class="badge">
								<?php echo $_SESSION['user_name'] ?><br />
								(<?php echo $_SESSION['user_category_name'] ?>)
							</span>
						</button>
					</div>
					<div class="btn-group-img btn-group">
						<button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
							<img src="../assets/layouts/layout5/img/avatar1.jpg" alt="">
						</button>
						<ul class="dropdown-menu-v2" role="menu">
							<li>
								<a href="#">
								<i class="icon-user"></i> My Profile<span class="badge badge-danger">1</span></a>
							</li>
							<li>
								<a href="#">
								<i class="icon-calendar"></i> My Calendar</a>
							</li>
							<li>
								<a href="#">
								<i class="icon-envelope-open"></i> My Inbox<span class="badge badge-danger">
								3 </span>
								</a>
							</li>
							<li>
								<a href="#">
								<i class="icon-rocket"></i> My Tasks<span class="badge badge-success">
								7 </span>
								</a>
							</li>
							<li class="divider">
							</li>
							<li>
								<a href="#">
								<i class="icon-lock"></i> Lock Screen</a>
							</li>
							<li>
								<a href="script_logout.php">
								<i class="icon-key"></i> Logout</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</nav>
</header>