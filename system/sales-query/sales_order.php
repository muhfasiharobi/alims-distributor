<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_sales_order();
		break;
	
		case "form-approval-sales-order":
			form_approval_sales_order();
		break;
		
		case "approval-sales-order":
			$sales_invoice_id = idbaru("sales_invoice","sales_invoice_id");
			
			$tbl_sales_order = mysql_query("SELECT sales_order_id, sales_request_id FROM sales_order WHERE sales_order_id = '".$_POST['sales_order_id']."'");
			$data_tbl_sales_order = mysql_fetch_array($tbl_sales_order);
			
			if ($_POST['sales_order_status'] == 'Approved')
			{
				mysql_query("UPDATE sales_order SET sales_order_status = '".$_POST['sales_order_status']."', sales_order_description = 'Pesanan Disetujui', sales_order_overdue_day = '".$_POST['sales_order_overdue_day']."', sales_order_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE sales_order_id = '".$data_tbl_sales_order['sales_order_id']."'");
				
				mysql_query("UPDATE sales_request SET sales_request_status = 'Closed' WHERE sales_request_id = '".$data_tbl_sales_order['sales_request_id']."'");				

                                mysql_query("INSERT INTO `sales_invoice`(`sales_invoice_id`, `sales_order_id`, `sales_invoice_no`, `sales_invoice_date`, `sales_invoice_overdue_date`, `sales_invoice_status`, `sales_invoice_description`, `sales_invoice_datetime`, `user_id`) VALUES ('".$sales_invoice_id."', '".$data_tbl_sales_order['sales_order_id']."','','0000-00-00','0000-00-00','On Hold','','".$waktu_sekarang."','".$_SESSION['user_id']."')");

			}
			else
			{
				mysql_query("UPDATE sales_order SET sales_order_status = '".$_POST['sales_order_status']."', sales_order_description = '".$_POST['sales_order_description']."', sales_order_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE sales_order_id = '".$data_tbl_sales_order['sales_order_id']."'");
				
				mysql_query("UPDATE sales_request SET sales_request_status = 'Canceled' WHERE sales_request_id = '".$data_tbl_sales_order['sales_request_id']."'");
			}
				
			header("location:../system/page_home.php?alimms=sales-order");	
		break;
		
		case "form-edit-sales-order":
			form_edit_sales_order();
		break;
		
		case "edit-sales-order":
			$sales_invoice_id = idbaru("sales_invoice","sales_invoice_id");
			
			$tbl_sales_order = mysql_query("SELECT sales_order_id, sales_request_id FROM sales_order WHERE sales_order_id = '".$_POST['sales_order_id']."'");
			$data_tbl_sales_order = mysql_fetch_array($tbl_sales_order);
			$jumlah_tbl_sales_order = mysql_num_rows($tbl_sales_order);
			
			if ($_POST['sales_order_status'] == 'Approved')
			{
				mysql_query("UPDATE sales_order SET sales_order_status = '".$_POST['sales_order_status']."', sales_order_description = 'Pesanan Disetujui', sales_order_overdue_day = '".$_POST['sales_order_overdue_day']."', sales_order_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE sales_order_id = '".$_POST['sales_order_id']."'");
				
				mysql_query("UPDATE sales_request SET sales_request_status = 'Closed' WHERE sales_request_id = '".$data_tbl_sales_order['sales_request_id']."'");
				
				$tbl_sales_invoice = mysql_query("SELECT sales_invoice FROM sales_invoice WHERE sales_order_id = '".$_POST['sales_order_id']."'");
				$jumlah_tbl_sales_invoice = mysql_num_rows($tbl_sales_invoice);
				
				if ($jumlah_tbl_sales_invoice < 1)
				{
					mysql_query("INSERT INTO sales_invoice(sales_invoice_id, sales_order_id) VALUES ('".$sales_invoice_id."', '".$data_tbl_sales_order['sales_order_id']."')");
				}
			}
			else
			{
				mysql_query("UPDATE sales_order SET sales_order_status = '".$_POST['sales_order_status']."', sales_order_description = '".$_POST['sales_order_description']."', sales_order_overdue_day = '0', sales_order_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE sales_order_id = '".$_POST['sales_order_id']."'");
				
				mysql_query("UPDATE sales_request SET sales_request_status = 'Canceled' WHERE sales_request_id = '".$data_tbl_sales_order['sales_request_id']."'");
				
				mysql_query("DELETE FROM sales_invoice WHERE sales_order_id = '".$data_tbl_sales_order['sales_order_id']."'");
			}
				
			header("location:../system/page_home.php?alimms=sales-order");
		break;
		
		case "form-view-sales-order":
			form_view_sales_order();
		break;
	}
?>