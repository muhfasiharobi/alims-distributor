<ul class="nav navbar-nav pull-right">
	<!-- BEGIN NOTIFICATION DROPDOWN -->
	<!-- DOC: Apply "dropdown-dark" class after "dropdown-extended" to change the dropdown styte -->
	<!-- DOC: Apply "dropdown-hoverable" class after below "dropdown" and remove data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to enable hover dropdown mode -->
	<!-- DOC: Remove "dropdown-hoverable" and add data-toggle="dropdown" data-hover="dropdown" data-close-others="true" attributes to the below A element with dropdown-toggle class -->
	
	
	<?php
	    $user = mysql_fetch_array(mysql_query("SELECT * FROM user a, user_category b WHERE a.user_category_id = b.user_category_id AND a.user_id = '".$_SESSION['user_id']."'"));
	?>
	
	<!-- BEGIN USER LOGIN DROPDOWN -->
	<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
	<li class="dropdown dropdown-user">
		<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
			<img alt="" class="img-circle" src="../assets/global/img/<?php echo $user['user_photo'] ?>" />
			<span class="username username-hide-on-mobile"> <?php echo $_SESSION['user_name'] ?> </span>
			<i class="fa fa-angle-down"></i>
		</a>
		<ul class="dropdown-menu dropdown-menu-default">
			<li>
				<a href="?connect=user-profile">
					<i class="icon-user"></i> Profilku </a>
			</li>
			<li class="divider"> </li>
			<li>
				<a href="../config/logout.php">
					<i class="icon-key"></i>Keluar</a>
			</li>
		</ul>
	</li>
	<!-- END USER LOGIN DROPDOWN -->
</ul>