<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_delivery_distribution();
		break;
	
		case "form-buffer-delivery-distribution":
			form_buffer_delivery_distribution();
		break;
	
		case "buffer-delivery-distribution":
			$delivery_cheque_id = idbaru("delivery_cheque","delivery_cheque_id");
			$jumlah_delivery_buffer_stock = count($_POST['delivery_buffer_stock']);
			
			mysql_query("UPDATE delivery_distribution SET delivery_distribution_status = 'Loading', delivery_distribution_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE delivery_distribution_id = '".$_POST['delivery_distribution_id']."'");
			
			for($i=0; $i<$jumlah_delivery_buffer_stock; $i++)
			{
				mysql_query("INSERT INTO delivery_buffer(delivery_distribution_id, product_sell_id, delivery_buffer_stock) VALUES('".$_POST['delivery_distribution_id']."', '".$_POST['product_sell_id'][$i]."', '".$_POST['delivery_buffer_stock'][$i]."')");	
			}
			
			mysql_query("INSERT INTO delivery_cheque(delivery_cheque_id, delivery_distribution_id) VALUES('".$delivery_cheque_id."', '".$_POST['delivery_distribution_id']."')");
			
			header("location:../system/home.php?alimms=delivery-distribution");
		break;
		
		case "form-edit-delivery-distribution":
			form_edit_delivery_distribution();
		break;
		
		case "edit-delivery-distribution":
			$jumlah_delivery_buffer_stock = count($_POST['delivery_buffer_stock']);
			
			mysql_query("UPDATE delivery_distribution SET delivery_distribution_status = 'Loading', delivery_distribution_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE delivery_distribution_id = '".$_POST['delivery_distribution_id']."'");
			
			for($i=0; $i<$jumlah_delivery_buffer_stock; $i++)
			{
				mysql_query("UPDATE delivery_buffer SET delivery_buffer_stock = '".$_POST['delivery_buffer_stock'][$i]."' WHERE delivery_distribution_id = '".$_POST['delivery_distribution_id']."' AND product_sell_id = '".$_POST['product_sell_id'][$i]."'");
			}
			
			header("location:../system/home.php?alimms=delivery-distribution");	
		break;
	
		case "form-view-delivery-distribution":
			form_view_delivery_distribution();
		break;
	}
?>