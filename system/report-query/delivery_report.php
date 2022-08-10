<?php
	switch($_GET['tib'])
	{
		case "form-search-by-vehicle-in-time-delivery-report":
			form_search_by_vehicle_in_time_delivery_report();
		break;
	
		case "form-result-by-vehicle-in-time-delivery-report":
			form_result_by_vehicle_in_time_delivery_report();
		break;
	
		case "form-search-by-vehicle-in-quantity-delivery-report":
			form_search_by_vehicle_in_quantity_delivery_report();
		break;
	
		case "form-result-by-vehicle-in-quantity-delivery-report":
			form_result_by_vehicle_in_quantity_delivery_report();
		break;
	}
?>