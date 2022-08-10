<?php
	switch($_GET['execute'])
	{
		default:
			default_penyesuaian_stok_platform();
		break;
		
		case "add-penyesuaian-stok-platform":
			add_penyesuaian_stok_platform();
		break;
		
		case "add-penyesuaian-stok":
			$penyesuaian_stok_id = sequence("penyesuaian_stok", "penyesuaian_stok_id");
			$tgl_skrg = date('Y-m-d');
			
			$penyesuaian_stok_date = explode("-", $_POST['penyesuaian_stok_date']);
			$date = $penyesuaian_stok_date[0];
			$month = $penyesuaian_stok_date[1];
			$year = $penyesuaian_stok_date[2];
			$penyesuaian_stok_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
			
			mysql_query("INSERT INTO `penyesuaian_stok`(`penyesuaian_stok_id`, `penyesuaian_stok_date`, `item_id`, `penyesuaian_stok_operation`, `penyesuaian_stok_quantity`, `penyesuaian_stok_update`, `user_activity_id`, `penyesuaian_stok_active`) VALUES ('".$penyesuaian_stok_id."','".$penyesuaian_stok_date."','".$_POST['item_id']."','".$_POST['penyesuaian_stok_operation']."','".$_POST['penyesuaian_stok_quantity']."','".$today."','".$_SESSION['user_id']."','1')");
			
			header("location:../dataverse/home.php?connect=penyesuaian-stok");
		break;
		
		case "edit-penyesuaian-stok-platform":
			edit_penyesuaian_stok_platform();
		break;
		
		case "edit-penyesuaian-stok":
		
			$penyesuaian_stok_date = explode("-", $_POST['penyesuaian_stok_date']);
			$date = $penyesuaian_stok_date[0];
			$month = $penyesuaian_stok_date[1];
			$year = $penyesuaian_stok_date[2];
			$penyesuaian_stok_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
		
			mysql_query("UPDATE penyesuaian_stok SET item_id = '".$_POST['item_id']."', penyesuaian_stok_operation = '".$_POST['penyesuaian_stok_operation']."', penyesuaian_stok_quantity = '".$_POST['penyesuaian_stok_quantity']."', penyesuaian_stok_date = '".$penyesuaian_stok_date."' WHERE penyesuaian_stok_id = '".$_POST['penyesuaian_stok_id']."'");
			
			header("location:../dataverse/home.php?connect=penyesuaian-stok");
		break;
		
		case "delete-penyesuaian-stok":
		
			mysql_query("UPDATE penyesuaian_stok SET penyesuaian_stok_active = '0' WHERE penyesuaian_stok_id = '".$_GET['penyesuaian_stok_id']."'");
			
			header("location:../dataverse/home.php?connect=penyesuaian-stok");
		break;
	}
?>