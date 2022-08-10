<?php
	switch($_GET['tib'])
	{
		case "form-search-customer-city-by-customer-quantity-customer-report":
			form_search_customer_city_by_customer_quantity_customer_report();
		break;
	
		case "form-view-customer-city-by-customer-quantity-customer-report":
			form_view_customer_city_by_customer_quantity_customer_report();
		break;
	
		case "form-search-customer-districts-by-customer-quantity-customer-report":
			form_search_customer_districts_by_customer_quantity_customer_report();
		break;
	
		case "form-view-customer-districts-by-customer-quantity-customer-report":
			form_view_customer_districts_by_customer_quantity_customer_report();
		break;
	
		case "form-search-salesman-by-customer-quantity-customer-report":
			form_search_salesman_by_customer_quantity_customer_report();
		break;
	
		case "form-view-salesman-by-customer-quantity-customer-report":
			form_view_salesman_by_customer_quantity_customer_report();
		break;
	}
?>