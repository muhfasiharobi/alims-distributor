<?php
	switch($_GET['tib'])
	{
		case "form-search-customer-by-quantity-product-sell-sales-report":
			form_search_customer_by_quantity_product_sell_sales_report();
		break;
	
		case "form-view-customer-by-quantity-product-sell-sales-report":
			form_view_customer_by_quantity_product_sell_sales_report();
		break;
		
		case "form-search-customer-city-by-sales-product-sell-sales-report":
			form_search_customer_city_by_sales_product_sell_sales_report();
		break;
	
		case "form-view-customer-city-by-sales-product-sell-sales-report":
			form_view_customer_city_by_sales_product_sell_sales_report();
		break;
	
		case "form-search-customer-city-by-quantity-product-sell-sales-report":
			form_search_customer_city_by_quantity_product_sell_sales_report();
		break;
	
		case "form-view-customer-city-by-quantity-product-sell-sales-report":
			form_view_customer_city_by_quantity_product_sell_sales_report();
		break;
		
		case "form-search-salesman-by-sales-invoice-sales-report":
			form_search_salesman_by_sales_invoice_sales_report();
		break;
	
		case "form-view-salesman-by-sales-invoice-sales-report":
			form_view_salesman_by_sales_invoice_sales_report();
		break;
	
		case "form-search-salesman-by-sales-product-sell-sales-report":
			form_search_salesman_by_sales_product_sell_sales_report();
		break;
	
		case "form-view-salesman-by-sales-product-sell-sales-report":
			form_view_salesman_by_sales_product_sell_sales_report();
		break;
	
		case "form-search-salesman-by-quantity-product-sell-sales-report":
			form_search_salesman_by_quantity_product_sell_sales_report();
		break;
	
		case "form-view-salesman-by-quantity-product-sell-sales-report":
			form_view_salesman_by_quantity_product_sell_sales_report();
		break;

                case "form-search-salesman-by-sales-invoice-sales-report-edit":
			form_search_salesman_by_sales_invoice_sales_report_edit();
		break;
	
		case "form-view-salesman-by-sales-invoice-sales-report-edit":
			form_view_salesman_by_sales_invoice_sales_report_edit();
		break;
		
		case "edit-sales-invoice-sales-report":
			
			$s = $_POST['sales_invoice_id'];

			$tbl_sales_order = mysql_query("SELECT b.sales_order_id, c.sales_request_id FROM sales_invoice a, sales_order b, sales_request c WHERE a.sales_invoice_id = '".$_POST['sales_invoice_id']."' AND a.sales_order_id = b.sales_order_id AND b.sales_request_id = c.sales_request_id");
			$data_tbl_sales_order = mysql_fetch_array($tbl_sales_order);
			
			
			for($i=1; $i <4; $i++){
				
				mysql_query("UPDATE sales_order_detail SET sales_order_detail_product_sell_quantity = '".$_POST['sales_order_detail_product_sell_quantity'][$s][$i]."', sales_order_detail_product_sell_price = '".$_POST['sales_order_detail_product_sell_price'][$s][$i]."', sales_order_detail_piece_discount = '".$_POST['sales_order_detail_piece_discount'][$s][$i]."' WHERE sales_order_id = '".$data_tbl_sales_order['sales_order_id']."' AND product_sell_id = '".$_POST['product_sell_id'][$i]."'");
				
				mysql_query("UPDATE sales_request_detail SET sales_request_detail_product_sell_quantity = '".$_POST['sales_order_detail_product_sell_quantity'][$s][$i]."', sales_request_detail_product_sell_price = '".$_POST['sales_order_detail_product_sell_price'][$s][$i]."', sales_request_detail_piece_discount = '".$_POST['sales_order_detail_piece_discount'][$s][$i]."' WHERE sales_request_id = '".$data_tbl_sales_order['sales_request_id']."' AND product_sell_id = '".$_POST['product_sell_id'][$i]."'");
			}
			
			header("location:../system/page_home.php?alimms=sales-report&tib=form-search-salesman-by-sales-invoice-sales-report-edit"); 
		break;
	}
?>