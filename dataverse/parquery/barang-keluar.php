<?php
	switch($_GET['execute'])
	{
		default:
			default_barang_keluar_platform();
		break;
		
		case "add-barang-keluar-platform":
			add_barang_keluar_platform();
		break;
		
		case "add-barang-keluar":
			$barang_keluar_id = sequence("barang_keluar", "barang_keluar_id");
			
			$barang_keluar_date = explode("-", $_POST['barang_keluar_date']);
			$date = $barang_keluar_date[0];
			$month = $barang_keluar_date[1];
			$year = $barang_keluar_date[2];
			$barang_keluar_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
			
			mysql_query("INSERT INTO `barang_keluar`(`barang_keluar_id`,`barang_keluar_date`, `item_id`, `barang_keluar_quantity`, `barang_keluar_description`, `barang_keluar_datetime`, `user_activity_id`, `barang_keluar_active`) VALUES ('".$barang_keluar_id."','".$barang_keluar_date."','".$_POST['item_id']."','".$_POST['barang_keluar_quantity']."','".$_POST['barang_keluar_description']."','".$today."','".$_SESSION['user_id']."','1')");
			
			header("location:../dataverse/home.php?connect=barang-keluar");
		break;
		
		case "edit-barang-keluar-platform":
			edit_barang_keluar_platform();
		break;
		
		case "edit-barang-keluar":
		
			mysql_query("UPDATE barang_keluar SET item_id = '".$_POST['item_id']."', barang_keluar_quantity = '".$_POST['barang_keluar_quantity']."', barang_keluar_description = '".$_POST['barang_keluar_description']."' WHERE barang_keluar_id = '".$_POST['barang_keluar_id']."'");
			
			header("location:../dataverse/home.php?connect=barang-keluar");
		break;
		
		case "delete-barang-keluar":
		
			mysql_query("UPDATE barang_keluar SET barang_keluar_active = '0' WHERE barang_keluar_id = '".$_GET['barang_keluar_id']."'");
			
			header("location:../dataverse/home.php?connect=barang-keluar");
		break;
	}
?>