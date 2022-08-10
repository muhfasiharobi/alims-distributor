<!DOCTYPE html>
<!--[if IE 8]> <html class="ie8 no-js" lang="en"> <![endif]-->
<!--[if IE 9]> <html class="ie9 no-js" lang="en"> <![endif]-->
<!--[if !IE]> <!--> <html lang="en"> <!--<![endif]-->
    <!-- BEGIN HEAD -->
    
<?php
    include "config/connection.php";
    
    $company = mysql_fetch_array(mysql_query("SELECT * FROM company WHERE company_active = '1'"));

?>

    <head>
        <?php include "head.php"; ?>
	</head>
    <!-- END HEAD -->
    <body class="login">
        <!-- BEGIN LOGIN PAGE -->
        <div class="user-login-5">
            <div class="row bs-reset">
                <div class="col-md-6 login-container bs-reset">
                    <img class="login-logo login-6" src="assets/global/img/<?php echo $company['company_logo'] ?>">
                    <div class="login-content">
                        <?php include "login-content.php"; ?>
                    </div>
                    <div class="login-footer">
                        <?php include "login-footer.php"; ?>
                    </div>
                </div>
                <div class="col-md-6 bs-reset">
                    <div class="login-bg"> </div>
                </div>
            </div>
        </div>
        <!-- END LOGIN PAGE -->
        <?php include "javascript.php"; ?>
    </body>
</html>