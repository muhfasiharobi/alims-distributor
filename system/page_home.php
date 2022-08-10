<?php 
	error_reporting(0);
	ob_start();
	session_start();
	
	include "../script_conn.php";
	
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
		<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
		<?php include "page_head.php"; ?>
		<body class="">
			<?php include "page_header.php"; ?>
			<div class="container-fluid">		
				<div class="page-content page-content-popup">
					<?php include "page_content_fixed_header.php"; ?>
					<?php include "page_sidebar_wrapper.php"; ?>
					<?php include "page_fixed_main_content.php"; ?>
					<?php include "page_footer.php"; ?>
				</div>
			</div>
			<?php include "page_quick_sidebar.php"; ?>
			<?php include "page_javascript.php"; ?>
		</body>
		</html>
<?php
	}
?>