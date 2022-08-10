<?php
	switch($_GET['execute'])
	{
		default:
			default_item_selling_agen_platform();
		break;
		
		case "add-item-selling-agen-platform":
			add_item_selling_agen_platform();
		break;
		
		case "add-delivery-agen-platform":
			add_delivery_agen_platform();
		break;
		
		case "add-item-selling-agen":
			$item_selling_id = sequence("item_selling", "item_selling_id");
			$item_selling_delivery_id = sequence("item_selling_delivery", "item_selling_delivery_id");
			
			$item_selling_date = explode("-", $_POST['item_selling_date']);
			$date = $item_selling_date[0];
			$month = $item_selling_date[1];
			$year = $item_selling_date[2];
			$item_selling_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));

			$reseller = mysql_fetch_array(mysql_query("SELECT * FROM reseller WHERE user_id = '".$_SESSION['user_id']."'"));
				
			$reseller_id = $reseller['reseller_id'];

			$bulan = date('m');
			$tahun = date('y');

			$promo = mysql_fetch_array(mysql_query("SELECT * FROM promo WHERE promo_id = '".$_POST['promo_id']."'"));

			$selling_code = "INV".''.$item_selling_id.''.$bulan.''.$tahun;

			mysql_query("INSERT INTO item_selling(item_selling_id, item_selling_code, item_selling_date, reseller_id, customer_id, order_via_id, item_selling_delivery_id,promo_id, kategori_promo,promo_value,item_selling_status, item_selling_create, item_selling_update, user_activity_id, item_selling_active) VALUES ('".$item_selling_id."', '".$selling_code."','".$item_selling_date."', '".$reseller_id."', '".$_POST['customer_id']."','".$_POST['order_via_id']."', '', '".$_POST['promo_id']."','".$promo['kategori_promo']."','','Belum Diproses', '".$today."', '".$today."', '".$_SESSION['user_id']."', '0')");
			
			header("location:../dataverse/home.php?connect=item-selling-agen&execute=add-delivery-agen-platform&item_selling_id=".$item_selling_id);
		break;
		
		case "add-delivery-selling-agen":
			$item_selling_delivery_id = sequence("item_selling_delivery", "item_selling_delivery_id");
			
			// ambil data file
                $namaFile = $item_selling_delivery_id.'-'.$_FILES['payment']['name'];
                $namaSementara = $_FILES['payment']['tmp_name'];
                
                // tentukan lokasi file akan dipindahkan
                $dirUpload = "transfer/";
                
                // pindahkan file
                $terupload = move_uploaded_file($namaSementara, $dirUpload.$namaFile);
			
			mysql_query("INSERT INTO `item_selling_delivery`(`item_selling_delivery_id`, `item_selling_id`,`item_selling_delivery_date`, `delivery_service_id`, `no_resi`, `delivery_cost`, `delivery_address`,`payment`, `item_selling_delivery_update`, `user_activity_id`, `item_selling_delivery_active`) VALUES ('".$item_selling_delivery_id."','".$_POST['item_selling_id']."','0000-00-00','".$_POST['delivery_service_id']."','".$_POST['no_resi']."','".$_POST['delivery_cost']."','".$_POST['delivery_address']."','".$namaFile."','".$today."','".$_SESSION['user_id']."','1')");
			
			mysql_query("UPDATE item_selling SET item_selling_delivery_id = '".$item_selling_delivery_id."' WHERE item_selling_id = '".$_POST['item_selling_id']."'");
			
			header("location:../dataverse/home.php?connect=item-selling-agen&execute=order-item-selling-agen-platform&item_selling_id=".$_POST['item_selling_id']);
		break;

		case "order-item-selling-agen-platform":
			order_item_selling_agen_platform();
		break;

		case "order-item-selling-agen":
			$order_item_selling_id = sequence("order_item_selling", "order_item_selling_id");
			
			$reseller_query = mysql_query("SELECT * FROM reseller WHERE user_id = '".$_SESSION['user_id']."'");
			$reseller_fetch_array = mysql_fetch_array($reseller_query);
			
			$reseller_item_sell = mysql_fetch_array(mysql_query("SELECT * FROM reseller_item_sell WHERE reseller_id = '".$reseller_fetch_array['reseller_id']."' AND item_id = '".$_POST['item_id']."' AND reseller_item_sell_active = '1'"));

			mysql_query("INSERT INTO order_item_selling(order_item_selling_id, item_selling_id, item_id, order_item_selling_quantity, item_price_id, item_commission_id, order_item_selling_create, order_item_selling_update, user_activity_id, order_item_selling_active) VALUES ('".$order_item_selling_id."', '".$_POST['item_selling_id']."', '".$_POST['item_id']."', '".$_POST['order_item_selling_quantity']."', '".$reseller_item_sell['item_price_id']."', '".$reseller_item_sell['item_commission_id']."', '".$today."', '".$today."', '".$_SESSION['user_id']."', '1')");
			
			mysql_query("UPDATE item_selling SET item_selling_active = '1' WHERE item_selling_id = '".$_POST['item_selling_id']."'");
			
			header("location:../dataverse/home.php?connect=item-selling-agen&execute=order-item-selling-agen-platform&item_selling_id=".$_POST['item_selling_id']);
		break;

		case "cancel-order-item-selling-agen":
			mysql_query("UPDATE item_selling SET item_selling_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', item_selling_active = '0' WHERE item_selling_id = '".$_GET['item_selling_id']."'");
			
			mysql_query("UPDATE order_item_selling SET order_item_selling_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', order_item_selling_active = '0' WHERE item_selling_id = '".$_GET['item_selling_id']."'");
			
			header("location:../dataverse/home.php?connect=item-selling-agen");
		break;
		
		case "delete-order-item-selling-agen":
			mysql_query("UPDATE order_item_selling SET order_item_selling_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', order_item_selling_active = '0' WHERE order_item_selling_id = '".$_GET['order_item_selling_id']."'");
			
			header("location:../dataverse/home.php?connect=item-selling-agen&execute=order-item-selling-agen-platform&item_selling_id=".$_GET['item_selling_id']);
		break;

		case "edit-item-selling-agen-platform":
			edit_item_selling_agen_platform();
		break;

		case "edit-delivery-agen-platform":
			edit_delivery_agen_platform();
		break;
		
		case "edit-item-selling-agen":
			$item_selling_date = explode("-", $_POST['item_selling_date']);
			$date = $item_selling_date[0];
			$month = $item_selling_date[1];
			$year = $item_selling_date[2];
			$item_selling_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
			
				$reseller = mysql_fetch_array(mysql_query("SELECT * FROM reseller WHERE user_id = '".$_SESSION['user_id']."'"));
				
				$reseller_id = $reseller['reseller_id'];


			mysql_query("UPDATE item_selling SET item_selling_date = '".$item_selling_date."', customer_id = '".$_POST['customer_id']."', order_via_id = '".$_POST['order_via_id']."', promo_id = '".$_POST['promo_id']."', item_selling_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."' WHERE item_selling_id = '".$_POST['item_selling_id']."'");
			
			header("location:../dataverse/home.php?connect=item-selling-agen&execute=edit-delivery-agen-platform&item_selling_id=".$_POST['item_selling_id']);
		break;

		case "edit-delivery-agen":

			mysql_query("UPDATE item_selling_delivery SET delivery_address = '".$_POST['delivery_address']."', delivery_service_id = '".$_POST['delivery_service_id']."', no_resi = '".$_POST['no_resi']."', delivery_cost = '".$_POST['delivery_cost']."' WHERE item_selling_delivery_id = '".$_POST['item_selling_delivery_id']."'");

			header("location:../dataverse/home.php?connect=item-selling-agen&execute=order-item-selling-agen-platform&item_selling_id=".$_POST['item_selling_id']);
		break;
		
		case "delete-item-selling-agen":
			mysql_query("UPDATE item_selling SET item_selling_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', item_selling_active = '0' WHERE item_selling_id = '".$_GET['item_selling_id']."'");

			mysql_query("UPDATE order_item_selling SET order_item_selling_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', order_item_selling_active = '0' WHERE item_selling_id = '".$_GET['item_selling_id']."'");
			
			header("location:../dataverse/home.php?connect=item-selling-agen");
		break;
		
		case "delivery-label-agen-platform":
		    delivery_label_agen_platform();
		break;
	}
?>