<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_delivery_cost();
		break;
		
		case "form-add-delivery-cost":
			form_add_delivery_cost();
		break;
	
		case "add-delivery-cost":
			$delivery_cost_id = idbaru("delivery_cost","delivery_cost_id");
			
			mysql_query("INSERT INTO delivery_cost(delivery_cost_id, customer_city_id, delivery_cost_price, delivery_cost_datetime, user_id) VALUES ('".$delivery_cost_id."', '".$_POST['customer_city_id']."', '".$_POST['delivery_cost_price']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
	
			header("location:../system/page_home.php?alimms=delivery-cost");	
		break;
	
		case "form-edit-delivery-cost":
			form_edit_delivery_cost();
		break;
		
		case "edit-delivery-cost":
			mysql_query("UPDATE delivery_cost SET customer_city_id = '".$_POST['customer_city_id']."', delivery_cost_price = '".$_POST['delivery_cost_price']."', delivery_cost_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE delivery_cost_id = '".$_POST['delivery_cost_id']."'");
		
			header("location:../system/page_home.php?alimms=delivery-cost");	
		break;
	
		case "delete-delivery-cost":
			mysql_query("UPDATE delivery_cost SET delivery_cost_datetime = '".$waktu_sekarang."', delivery_cost_active = '0', user_id = '".$_SESSION['user_id']."' WHERE delivery_cost_id = '".$_GET['delivery_cost_id']."'");
			
			header("location:../system/page_home.php?alimms=delivery-cost");	
		break;
		
		case "active-delivery-cost":
			mysql_query("UPDATE delivery_cost SET delivery_cost_datetime = '".$waktu_sekarang."', delivery_cost_active = '1', user_id = '".$_SESSION['user_id']."' WHERE delivery_cost_id = '".$_GET['delivery_cost_id']."'");
			
			header("location:../system/page_home.php?alimms=delivery-cost");	
		break;
	}
?>