<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_sales_invoice();
		break;
	
		case "form-invoicing-sales-invoice":
			form_invoicing_sales_invoice();
		break;
	
		case "invoicing-sales-invoice":
			$payment_order_id = idbaru("payment_order","payment_order_id");
			$delivery_plan_id = idbaru("delivery_plan","delivery_plan_id");
			
			$unique_code = "TIB" . "/" . "PO" . "-" . $thn_sekarang . "/" . $bln_sekarang . "/";
			$tbl_sales_invoice = mysql_query("SELECT max(sales_invoice_no) as maxID FROM sales_invoice WHERE sales_invoice_no LIKE '$unique_code%'");
			$data_tbl_sales_invoice = mysql_fetch_array($tbl_sales_invoice);
			$idMax = $data_tbl_sales_invoice['maxID'];
			$noUrut = (int) substr($idMax, 15, 4);
			$noUrut++;
			$sales_invoice_no = $unique_code . sprintf("%04s", $noUrut);
			
			$sales_invoice_date = explode("-", $_POST['sales_invoice_date']);
			$date_sales_invoice = $sales_invoice_date[0];
			$month_sales_invoice = $sales_invoice_date[1];
			$year_sales_invoice = $sales_invoice_date[2];
			$sales_invoice_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_invoice, $date_sales_invoice, $year_sales_invoice));

			$sales_invoice_overdue_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_invoice, $date_sales_invoice + $_POST['sales_order_overdue_day'], $year_sales_invoice));

			if ($_POST['sales_invoice_status'] == 'Posted')
			{
				mysql_query("UPDATE sales_invoice SET sales_invoice_no = '".$sales_invoice_no."', sales_invoice_date = '".$sales_invoice_date."', sales_invoice_overdue_date = '".$sales_invoice_overdue_date."', sales_invoice_status = '".$_POST['sales_invoice_status']."', sales_invoice_description = 'Pesanan Difakturkan', sales_invoice_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE sales_invoice_id = '".$_POST['sales_invoice_id']."'");
				
				mysql_query("INSERT INTO `payment_order`(`payment_order_id`, `sales_invoice_id`, `payment_order_status`, `payment_order_datetime`, `user_id`) VALUES ('".$payment_order_id."','".$_POST['sales_invoice_id']."','Call','".$waktu_sekarang."','".$_SESSION['user_id']."')");
				
				
				mysql_query("INSERT INTO delivery_plan(delivery_plan_id, sales_invoice_id) VALUES ('".$delivery_plan_id."', '".$_POST['sales_invoice_id']."')");
			}
			else
			{
				mysql_query("UPDATE sales_invoice SET sales_invoice_status = '".$_POST['sales_invoice_status']."', sales_invoice_description = '".$_POST['sales_invoice_description']."', sales_invoice_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE sales_invoice_id = '".$_POST['sales_invoice_id']."'");
			}
			
			header("location:../system/page_home.php?alimms=sales-invoice");
		break;
		
		case "form-edit-sales-invoice":
			form_edit_sales_invoice();
		break;
		
		case "edit-sales-invoice";
			$payment_order_id = idbaru("payment_order","payment_order_id");
			$delivery_plan_id = idbaru("delivery_plan","delivery_plan_id");
			
			$unique_code = "TIB" . "/" . "PO" . "-" . $thn_sekarang . "/" . $bln_sekarang . "/";
			$tbl_sales_invoice = mysql_query("SELECT max(sales_invoice_no) as maxID FROM sales_invoice WHERE sales_invoice_no LIKE '$unique_code%'");
			$data_tbl_sales_invoice = mysql_fetch_array($tbl_sales_invoice);
			$idMax = $data_tbl_sales_invoice['maxID'];
			$noUrut = (int) substr($idMax, 15, 4);
			$noUrut++;
			$sales_invoice_no = $unique_code . sprintf("%04s", $noUrut);
			
			$sales_invoice_date = explode("-", $_POST['sales_invoice_date']);
			$date_sales_invoice = $sales_invoice_date[0];
			$month_sales_invoice = $sales_invoice_date[1];
			$year_sales_invoice = $sales_invoice_date[2];
			$sales_invoice_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_invoice, $date_sales_invoice, $year_sales_invoice));
			
			$sales_invoice_overdue_date = date("Y-m-d", mktime(0, 0, 0, $month_sales_invoice, $date_sales_invoice + $_POST['sales_order_overdue_day'], $year_sales_invoice));
			
			$tbl_sales_invoice = mysql_query("SELECT sales_invoice_no FROM sales_invoice WHERE sales_invoice_id = '".$_POST['sales_invoice_id']."'");
			$data_tbl_sales_invoice = mysql_fetch_array($tbl_sales_invoice);
				
			if ($_POST['sales_invoice_status'] == 'Posted')
			{
				if ($data_tbl_sales_invoice['sales_invoice_no'] != "")
				{
					mysql_query("UPDATE sales_invoice SET sales_invoice_status = '".$_POST['sales_invoice_status']."', sales_invoice_description = 'Pesanan Difakturkan', sales_invoice_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE sales_invoice_id = '".$_POST['sales_invoice_id']."'");
					
					mysql_query("INSERT INTO payment_order(payment_order_id, sales_invoice_id) VALUES ('".$payment_order_id."', '".$_POST['sales_invoice_id']."')");
					
					mysql_query("INSERT INTO delivery_plan(delivery_plan_id, sales_invoice_id) VALUES ('".$delivery_plan_id."', '".$_POST['sales_invoice_id']."')");
				}
				else
				{
					mysql_query("UPDATE sales_invoice SET sales_invoice_no = '".$sales_invoice_no."', sales_invoice_date = '".$sales_invoice_date."', sales_invoice_overdue_date = '".$sales_invoice_overdue_date."', sales_invoice_status = '".$_POST['sales_invoice_status']."', sales_invoice_description = 'Pesanan Difakturkan', sales_invoice_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE sales_invoice_id = '".$_POST['sales_invoice_id']."'");
					
					mysql_query("INSERT INTO payment_order(payment_order_id, sales_invoice_id) VALUES ('".$payment_order_id."', '".$_POST['sales_invoice_id']."')");
					
					mysql_query("INSERT INTO delivery_plan(delivery_plan_id, sales_invoice_id) VALUES ('".$delivery_plan_id."', '".$_POST['sales_invoice_id']."')");
				}
			}
			else
			{
				if ($data_tbl_sales_invoice['sales_invoice_no'] != "")
				{
					mysql_query("UPDATE sales_invoice SET sales_invoice_status = '".$_POST['sales_invoice_status']."', sales_invoice_description = '".$_POST['sales_invoice_description']."', sales_invoice_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE sales_invoice_id = '".$_POST['sales_invoice_id']."'");
					
					mysql_query("DELETE FROM payment_order WHERE sales_invoice_id = '".$_POST['sales_invoice_id']."'");
					
					mysql_query("DELETE FROM delivery_plan WHERE sales_invoice_id = '".$_POST['sales_invoice_id']."'");
				}
				else
				{
					mysql_query("UPDATE sales_invoice SET sales_invoice_status = '".$_POST['sales_invoice_status']."', sales_invoice_description = '".$_POST['sales_invoice_description']."', sales_invoice_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE sales_invoice_id = '".$_POST['sales_invoice_id']."'");
					
					mysql_query("DELETE FROM payment_order WHERE sales_invoice_id = '".$_POST['sales_invoice_id']."'");
					
					mysql_query("DELETE FROM delivery_plan WHERE sales_invoice_id = '".$_POST['sales_invoice_id']."'");
				}
			}
			
			header("location:../system/page_home.php?alimms=sales-invoice");
		break;
	
		case "form-print-sales-invoice":
			form_print_sales_invoice();
		break;
	
		case "form-view-sales-invoice":
			form_view_sales_invoice();
		break;
	}
?>