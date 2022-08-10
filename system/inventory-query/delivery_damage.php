<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_delivery_damage();
		break;
		
		case "form-handling-delivery-damage":
			form_handling_delivery_damage();
		break;
	
		case "handling-delivery-damage":
			$jumlah_delivery_damage_handling = count($_POST['delivery_damage_handling']);
			
			mysql_query("UPDATE delivery_damage SET delivery_damage_status = 'Closed', delivery_damage_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE delivery_cheque_id = '".$_POST['delivery_cheque_id']."'");
			
			for($i=0; $i<$jumlah_delivery_damage_handling; $i++)
			{
				mysql_query("UPDATE delivery_damage SET delivery_damage_handling = '".$_POST['delivery_damage_handling'][$i]."' WHERE delivery_cheque_id = '".$_POST['delivery_cheque_id']."' AND product_sell_id = '".$_POST['product_sell_id'][$i]."'");
			}
			
			header("location:../system/home.php?alimms=delivery-damage");
		break;
	
		case "form-edit-delivery-damage":
			form_edit_delivery_damage();
		break;
		
		case "edit-delivery-damage":
			$jumlah_delivery_damage_handling = count($_POST['delivery_damage_handling']);
			
			mysql_query("UPDATE delivery_damage SET delivery_damage_status = 'Loading', delivery_damage_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE delivery_cheque_id = '".$_POST['delivery_cheque_id']."'");
			
			for($i=0; $i<$jumlah_delivery_damage_handling; $i++)
			{
				mysql_query("UPDATE delivery_damage SET delivery_damage_handling = '".$_POST['delivery_damage_handling'][$i]."' WHERE delivery_cheque_id = '".$_POST['delivery_cheque_id']."' AND product_sell_id = '".$_POST['product_sell_id'][$i]."'");
			}
			
			header("location:../system/home.php?alimms=delivery-damage");	
		break;
	}
?>