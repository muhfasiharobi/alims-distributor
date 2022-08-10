<?php 
	error_reporting(0);
	ob_start();
	session_start();
	
	include "../config/connection.php";
	include "../library/currency.php";
	include "../library/datetime.php";
	include "../library/sequence.php";
	
	if (empty($_SESSION['user_username']) AND empty($_SESSION['user_password']))
	{
		header('location:../index.php');
	}
	else
	{
?>
		<!DOCTYPE html>
		<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
		<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
		<!--[if !IE]> <!--> <html lang="en"> <!--<![endif]-->
			<!-- BEGIN HEAD -->
			
<?php
    
    $company = mysql_fetch_array(mysql_query("SELECT * FROM company WHERE company_active = '1'"));

?>
			<head>
				<?php include "head.php"; ?>
			</head>
			<!-- END HEAD -->
			<body class="page-header-fixed page-sidebar-closed-hide-logo page-sidebar-fixed">
				<div class="page-wrapper">
					<!-- BEGIN HEADER -->
					<div class="page-header navbar navbar-fixed-top">
						<!-- BEGIN HEADER INNER -->
						<div class="page-header-inner">
							<!-- BEGIN LOGO -->
							<div class="page-logo">
								<div class="menu-toggler sidebar-toggler">
									<span> </span>
								</div>
								<!--
								<a href="?connect=dashboard">
									<img alt="logo" class="logo-default" src="../assets/global/img/<?php echo $company['company_logo'] ?>" >
								</a>
								-->
							</div>
							<!-- END LOGO -->
							<!-- BEGIN RESPONSIVE MENU TOGGLER -->
							<a class="menu-toggler responsive-toggler" href="javascript:;" data-target=".navbar-collapse" data-toggle="collapse">
								<span> </span>
							</a>
							<!-- END RESPONSIVE MENU TOGGLER -->
							<!-- BEGIN TOP NAVIGATION MENU -->
							<div class="top-menu">
								<?php include "top-menu.php"; ?>
							</div>
							<!-- END TOP NAVIGATION MENU -->
						</div>
						<!-- END HEADER INNER -->
					</div>
					<!-- END HEADER -->
					<!-- BEGIN HEADER & CONTENT DIVIDER -->
					<div class="clearfix"> </div>
					<!-- END HEADER & CONTENT DIVIDER -->
					<!-- BEGIN CONTAINER -->
					<div class="page-container">
						<!-- BEGIN SIDEBAR -->
						<div class="page-sidebar-wrapper">
							<?php include "page-sidebar.php"; ?>
						</div>
						<!-- END SIDEBAR -->
						<!-- BEGIN CONTENT -->
						<div class="page-content-wrapper">
							<!-- BEGIN CONTENT BODY -->
							<div class="page-content">
								<?php include "page-header.php"; ?>
								<?php include "page-content.php"; ?>
							</div>
							<!-- END CONTENT BODY -->
						</div>
						<!-- END CONTENT -->
					</div>
					<!-- END CONTAINER -->
					<!-- BEGIN FOOTER -->
					<div class="page-footer">
						<div class="page-footer-inner">Copyright &copy; alimms 2021. All Rights Reserved.</div>
						<div class="scroll-to-top">
							<i class="icon-arrow-up"></i>
						</div>
					</div>
					<!-- END FOOTER -->
				</div>
				<?php include "javascript.php"; ?>
			</body>
		</html>
<?php
	}
?>