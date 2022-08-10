<?php
	switch($_GET['execute'])
	{
		default:
			default_paket_produk_platform();
		break;
		
		case "add-paket-produk-platform":
			add_paket_produk_platform();
		break;
		
		case "add-paket-produk":
			$id_paket_produk = sequence("paket_produk", "id_paket_produk");
			
			mysql_query("INSERT INTO `paket_produk`(`id_paket_produk`, `item_category_id`, `nama_paket_produk`, `harga_paket_produk`, `paket_produk_active`) VALUES ('".$id_paket_produk."','".$_POST['item_category_id']."','".$_POST['nama_paket']."','','1')");
			
			header("location:../dataverse/home.php?connect=paket-produk&execute=add-item-paket-produk-platform&id_paket_produk=".$id_paket_produk);
		break;
		
		case "add-item-paket-produk-platform":
			add_item_paket_produk_platform();
		break;
		
		case "add-item-paket-produk":
			$paket_produk_detail_id = sequence("paket_produk_detail", "paket_produk_detail_id");
			
			mysql_query("INSERT INTO `paket_produk_detail`(`id_paket_produk_detail`, `id_paket_produk`, `item_id`, `item_quantity`) VALUES ('".$id_paket_produk_detail."','".$_POST['id_paket_produk']."','".$_POST['item_id']."','".$_POST['jumlah']."')");
			
			header("location:../dataverse/home.php?connect=paket-produk&execute=add-item-paket-produk-platform&id_paket_produk=".$_POST['id_paket_produk']);
		break;
		
		case "edit-paket-produk-platform":
			edit_paket_produk_platform();
		break;
		
		case "edit-paket-produk":
			mysql_query("UPDATE item_category SET item_category_name = '".$_POST['item_category_name']."', id_label = '".$_POST['id_label']."',item_category_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."' WHERE item_category_id = '".$_POST['item_category_id']."'");
			
			header("location:../dataverse/home.php?connect=paket-produk");
		break;
		
		case "delete-paket-produk":
			mysql_query("UPDATE item_category SET item_category_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', item_category_active = '0' WHERE item_category_id = '".$_GET['item_category_id']."'");
			
			header("location:../dataverse/home.php?connect=paket-produk");
		break;
		
		case "hapus-paket-produk-detail":
		
			mysql_query("DELETE FROM paket_produk_detail WHERE id_paket_produk_detail = '".$_GET['id_paket_produk_detail']."'");
			
			header("location:../dataverse/home.php?connect=paket-produk");
		break;
	}
?>