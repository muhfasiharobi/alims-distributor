<?php
	switch($_GET['tib'])
	{
		case "form-search-customer-city-by-customer-category-request-report":
			form_search_customer_city_by_customer_category_request_report();
		break;
	
		case "form-view-customer-city-by-customer-category-request-report":
			form_view_customer_city_by_customer_category_request_report();
		break;
	
		case "form-search-salesman-by-order-method-request-report":
			form_search_salesman_by_order_method_request_report();
		break;
	
		case "form-view-salesman-by-order-method-request-report":
			form_view_salesman_by_order_method_request_report();
		break;
	}
?>