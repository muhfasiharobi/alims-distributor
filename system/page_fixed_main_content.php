<?php
	include "../library/auto_increment.php";
	include "../library/currency.php";
	include "../library/datetime.php";
	include "../library/thumbnail.php";
	
	 
	include "dashboard-form/sales_dashboard.php";
	include "dashboard-form/visit_dashboard.php";
	include "dashboard-form/logisticanddelivery_dashboard.php";
	include "dashboard-form/finance_dashboard.php";
	include "dashboard-form/billingman_dashboard.php";
	
	include "finance-form/payment_order.php";
	include "finance-form/payment_request.php";
	include "finance-form/sales_invoice.php";

	include "master-form/billing_plan.php";
	include "master-form/customer.php";
	include "master-form/customer_area.php";
	include "master-form/customer_category.php";
	include "master-form/customer_galon_category.php";
	include "master-form/customer_city.php";
	include "master-form/customer_class.php";
	include "master-form/customer_districts.php";
	include "master-form/customer_request.php";
	include "master-form/delivery_cost.php";
	include "master-form/delivery_schedule.php";
	include "master-form/delivery_session.php";
	include "master-form/delivery_vehicle.php";
	include "master-form/payment_category.php";
	include "master-form/payment_overdue.php";
	include "master-form/product_buy.php";
	include "master-form/product_category.php";
	include "master-form/product_promo.php";
	include "master-form/galon_promo.php";
	include "master-form/product_sell.php";
	include "master-form/product_sell_price.php";
	include "master-form/product_unit.php";
	include "master-form/sales_plan.php";
	include "master-form/sales_target.php";
    include "master-form/sales_schedule.php";
	include "master-form/supplier.php";
	include "master-form/user.php";
	include "master-form/user_category.php";
	include "master-form/user_department.php";
	
	include "report-form/customer_report.php";
	include "report-form/request_report.php";
	include "report-form/sales_report.php";
	include "report-form/sales_visit_report.php";
	
	include "sales-form/sales_order.php";
	include "sales-form/sales_request.php";
	include "sales-form/sales_request_galon.php";
	include "sales-form/sales_visit.php";
    include "sales-form/billing_visit.php";
	
	if ($_GET['alimms'] == "dashboard")
	{
		if ($_SESSION['user_category_name'] == "Salesman Grosir" || $_SESSION['user_category_name'] == "Salesman Horeka" || $_SESSION['user_category_name'] == "Salesman Retail")
		{
			include "dashboard-query/visit_dashboard.php";
                }
		elseif($_SESSION['user_category_name'] == "Logistic and Delivery Manager")
		{
			include "dashboard-query/logisticanddelivery_dashboard.php";
		}
                elseif($_SESSION['user_category_name'] == "Facturist")
		{
			include "dashboard-query/finance_dashboard.php";
		}
		 elseif($_SESSION['user_category_name'] == "Billingman")
		{
			include "dashboard-query/billingman_dashboard.php";
		}
		else
		{
			include "dashboard-query/sales_dashboard.php";
		}
	}
	elseif ($_GET['alimms'] == "payment-order")
	{
		include "finance-query/payment_order.php"; 
	}
	elseif ($_GET['alimms'] == "payment-request")
	{
		include "finance-query/payment_request.php"; 
	}
	elseif ($_GET['alimms'] == "sales-invoice")
	{
		include "finance-query/sales_invoice.php"; 
	}
	elseif ($_GET['alimms'] == "billing-plan")
	{
		include "master-query/billing_plan.php"; 
	}
        elseif ($_GET['alimms'] == "billing-visit")
	{
		include "sales-query/billing_visit.php"; 
	}
	elseif ($_GET['alimms'] == "customer")
	{
		include "master-query/customer.php"; 
	}
	elseif ($_GET['alimms'] == "customer-area")
	{
		include "master-query/customer_area.php"; 
	}
	elseif ($_GET['alimms'] == "customer-category")
	{
		include "master-query/customer_category.php"; 
	}
	elseif ($_GET['alimms'] == "customer-galon-category")
	{
		include "master-query/customer_galon_category.php"; 
	}
	elseif ($_GET['alimms'] == "customer-city")
	{
		include "master-query/customer_city.php"; 
	}
	elseif ($_GET['alimms'] == "customer-class")
	{
		include "master-query/customer_class.php"; 
	}
	elseif ($_GET['alimms'] == "customer-districts")
	{
		include "master-query/customer_districts.php"; 
	}
	elseif ($_GET['alimms'] == "customer-request")
	{
		include "master-query/customer_request.php"; 
	}
	elseif ($_GET['alimms'] == "delivery-cost")
	{
		include "master-query/delivery_cost.php"; 
	}
	elseif ($_GET['alimms'] == "delivery-schedule")
	{
		include "master-query/delivery_schedule.php"; 
	}
	elseif ($_GET['alimms'] == "delivery-session")
	{
		include "master-query/delivery_session.php"; 
	}
	elseif ($_GET['alimms'] == "delivery-vehicle")
	{
		include "master-query/delivery_vehicle.php"; 
	}
	elseif ($_GET['alimms'] == "payment-category")
	{
		include "master-query/payment_category.php"; 
	}
	elseif ($_GET['alimms'] == "payment-overdue")
	{
		include "master-query/payment_overdue.php"; 
	}
	elseif ($_GET['alimms'] == "product-buy")
	{
		include "master-query/product_buy.php"; 
	}
	elseif ($_GET['alimms'] == "product-category")
	{
		include "master-query/product_category.php"; 
	}
	elseif ($_GET['alimms'] == "product-promo")
	{
		include "master-query/product_promo.php"; 
	}
	elseif ($_GET['alimms'] == "galon-promo")
	{
		include "master-query/galon_promo.php"; 
	}
	elseif ($_GET['alimms'] == "product-sell")
	{
		include "master-query/product_sell.php"; 
	}
	elseif ($_GET['alimms'] == "product-sell-price")
	{
		include "master-query/product_sell_price.php"; 
	}
	elseif ($_GET['alimms'] == "product-unit")
	{
		include "master-query/product_unit.php"; 
	}
	elseif ($_GET['alimms'] == "sales-plan")
	{
		include "master-query/sales_plan.php"; 
	}
	elseif ($_GET['alimms'] == "sales-target")
	{
		include "master-query/sales_target.php"; 
	}
	elseif ($_GET['alimms'] == "supplier")
	{
		include "master-query/supplier.php"; 
	}
	elseif ($_GET['alimms'] == "user")
	{
		include "master-query/user.php"; 
	}
	elseif ($_GET['alimms'] == "user-category")
	{
		include "master-query/user_category.php"; 
	}
	elseif ($_GET['alimms'] == "user-department")
	{
		include "master-query/user_department.php"; 
	}
	elseif ($_GET['alimms'] == "customer-report")
	{
		include "report-query/customer_report.php"; 
	}
	elseif ($_GET['alimms'] == "request-report")
	{
		include "report-query/request_report.php"; 
	}
	elseif ($_GET['alimms'] == "sales-report")
	{
		include "report-query/sales_report.php"; 
	}
	elseif ($_GET['alimms'] == "sales-visit-report")
	{
		include "report-query/sales_visit_report.php"; 
	}
	elseif ($_GET['alimms'] == "sales-order")
	{
		include "sales-query/sales_order.php"; 
	}
	elseif ($_GET['alimms'] == "sales-request")
	{
		include "sales-query/sales_request.php"; 
	}
	elseif ($_GET['alimms'] == "sales-request-galon")
	{
		include "sales-query/sales_request_galon.php"; 
	}
	elseif ($_GET['alimms'] == "sales-visit")
	{
		include "sales-query/sales_visit.php"; 
	}
        elseif ($_GET['alimms'] == "sales-schedule")
	{
		include "master-query/sales_schedule.php"; 
	}
	else
	{
		header("location:../index.php");
	}
?>