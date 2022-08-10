<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_delivery_cheque();
		break;
		
		case "form-faulty-loading-delivery-cheque":
			form_faulty_loading_delivery_cheque();
		break;
	
		case "faulty-loading-delivery-cheque":
			$jumlah_delivery_damage_loading = count($_POST['delivery_damage_loading']);
			
			mysql_query("UPDATE delivery_cheque SET delivery_cheque_status = 'Handling', delivery_cheque_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE delivery_cheque_id = '".$_POST['delivery_cheque_id']."'");
			
			for($i=0; $i<$jumlah_delivery_damage_loading; $i++)
			{
				mysql_query("INSERT INTO delivery_damage(delivery_cheque_id, product_sell_id, delivery_damage_loading) VALUES('".$_POST['delivery_cheque_id']."', '".$_POST['product_sell_id'][$i]."', '".$_POST['delivery_damage_loading'][$i]."')");	
			}
			
			mysql_query("UPDATE delivery_distribution SET delivery_distribution_status = 'Handling' WHERE delivery_distribution_id = '".$_POST['delivery_distribution_id']."'");
			
			$tbl_delivery_cheque = mysql_query("SELECT c.delivery_plan_id FROM delivery_cheque a, delivery_distribution b, delivery_plan c WHERE a.delivery_cheque_id = '".$_POST['delivery_cheque_id']."' AND a.delivery_distribution_id = b.delivery_distribution_id AND b.delivery_schedule_id = c.delivery_schedule_id AND b.delivery_session_id = c.delivery_session_id");
			$jumlah_tbl_delivery_cheque = mysql_num_rows($tbl_delivery_cheque);
			
			for($i=0; $i<$jumlah_tbl_delivery_cheque; $i++)
			{
				while($data_tbl_delivery_cheque = mysql_fetch_array($tbl_delivery_cheque))
				{
					mysql_query("INSERT INTO delivery_visit(delivery_plan_id) VALUES('".$data_tbl_delivery_cheque['delivery_plan_id']."')");	
				}
			}
			
			header("location:../system/home.php?alimms=delivery-cheque");
		break;
	}
?>