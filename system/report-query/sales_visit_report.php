<?php
	switch($_GET['tib'])
	{
		case "form-search-salesman-by-count-visit-sales-visit-report":
			form_search_salesman_by_count_visit_sales_visit_report();
		break;
	
		case "form-view-salesman-by-count-visit-sales-visit-report":
			form_view_salesman_by_count_visit_sales_visit_report();
		break;
		
		case "form-search-salesman-by-time-visit-sales-visit-report":
			form_search_salesman_by_time_visit_sales_visit_report();
		break;
	
		case "form-view-salesman-by-time-visit-sales-visit-report":
			form_view_salesman_by_time_visit_sales_visit_report();
		break;
		
		case "form-search-call-book-salesman":
			form_search_call_book_salesman();
		break;
		
		case "form-result-call-book-salesman":
			form_result_call_book_salesman();
		break;
	}
?>