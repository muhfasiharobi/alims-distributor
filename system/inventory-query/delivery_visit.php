<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_delivery_visit();
		break;
	
		case "form-question-delivery-visit":
			mysql_query("UPDATE delivery_visit SET delivery_visit_time_in = '".$waktu."' WHERE delivery_visit_id = '".$_GET['delivery_visit_id']."'");
			
			form_question_delivery_visit();
		break;
	
		case "question-delivery-visit":
			$jumlah_delivery_display_photo = count($_FILES['delivery_display_photo']['name']);
			
			$tbl_delivery_distribution = mysql_query("SELECT c.delivery_distribution_id FROM delivery_visit a, delivery_plan b, delivery_distribution c WHERE a.delivery_visit_id = '".$_POST['delivery_visit_id']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.delivery_schedule_id = c.delivery_schedule_id AND b.delivery_session_id = c.delivery_session_id");
			$data_tbl_delivery_distribution = mysql_fetch_array($tbl_delivery_distribution);
			
			$tbl_delivery_cheque = mysql_query("SELECT delivery_cheque_id FROM delivery_cheque WHERE delivery_distribution_id = '".$data_tbl_delivery_distribution['delivery_distribution_id']."'");
			$data_tbl_delivery_cheque = mysql_fetch_array($tbl_delivery_cheque);
			
			$tbl_delivery_visit = mysql_query("SELECT b.sales_invoice_id FROM delivery_visit a, delivery_plan b WHERE a.delivery_visit_id = '".$_POST['delivery_visit_id']."' AND a.delivery_plan_id = b.delivery_plan_id");
			$data_tbl_delivery_visit = mysql_fetch_array($tbl_delivery_visit);
			
			$tbl_customer = mysql_query("SELECT f.customer_code FROM delivery_visit a, delivery_plan b, sales_invoice c, sales_order d, sales_request e, customer f WHERE a.delivery_visit_id = '".$_POST['delivery_visit_id']."' AND a.delivery_plan_id = b.delivery_plan_id AND b.sales_invoice_id = c.sales_invoice_id AND c.sales_order_id = d.sales_order_id AND d.sales_request_id = e.sales_request_id AND e.customer_id = f.customer_id");
			$data_tbl_customer = mysql_fetch_array($tbl_customer);
							
			for ($i = 0; $i < $jumlah_delivery_display_photo; $i++)
			{
				$tmp_file = $_FILES['delivery_display_photo']['tmp_name'][$i];
				$filename = $_FILES['delivery_display_photo']['name'][$i];
				$destination = '../../alimms/img-delivery/';
				$random = rand(1, 50);
				$filename = $data_tbl_customer['customer_code'].'-'.$tgl_sekarang_indo.'-'.$random.'.jpg';
				$upload = $destination . $filename;
				
				if (move_uploaded_file($tmp_file, $upload))
				{
					mysql_query("INSERT INTO delivery_display(delivery_visit_id, delivery_display_photo) VALUES('".$_POST['delivery_visit_id']."', '".$filename."')");	
				}
			}
			
			if ($_POST['delivery_visit_status'] == 'Delivered')
			{
				mysql_query("UPDATE delivery_visit SET delivery_visit_time_out = '".$waktu."', delivery_visit_description = 'Pelanggan Terkirim', delivery_visit_status = '".$_POST['delivery_visit_status']."', delivery_visit_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE delivery_visit_id = '".$_POST['delivery_visit_id']."'");
				
				// mysql_query("UPDATE sales_invoice SET sales_invoice_status = 'Delivered' WHERE sales_invoice_id = '".$data_tbl_delivery_visit['sales_invoice_id']."'");
				
				mysql_query("UPDATE delivery_distribution SET delivery_distribution_status = 'On Site' WHERE delivery_distribution_id = '".$data_tbl_delivery_distribution['delivery_distribution_id']."'");
				
				mysql_query("UPDATE delivery_cheque SET delivery_cheque_status = 'On Site' WHERE delivery_cheque_id = '".$data_tbl_delivery_cheque['delivery_cheque_id']."'");
			}
			else
			{
				mysql_query("UPDATE delivery_visit SET delivery_visit_time_out = '".$waktu."', delivery_visit_description = '".$_POST['delivery_visit_description']."', delivery_visit_status = '".$_POST['delivery_visit_status']."', delivery_visit_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE delivery_visit_id = '".$_POST['delivery_visit_id']."'");
										
				// mysql_query("UPDATE sales_invoice SET sales_invoice_status = 'Posted Pending' WHERE sales_invoice_id = '".$data_tbl_delivery_visit['sales_invoice_id']."'");
				
				mysql_query("UPDATE delivery_distribution SET delivery_distribution_status = 'On Site' WHERE delivery_distribution_id = '".$data_tbl_delivery_distribution['delivery_distribution_id']."'");
				
				mysql_query("UPDATE delivery_cheque SET delivery_cheque_status = 'On Site' WHERE delivery_cheque_id = '".$data_tbl_delivery_cheque['delivery_cheque_id']."'");
			}
				
			header("location:../system/home.php?alimms=delivery-visit");
		break;
		
		case "form-view-delivery-visit":
			form_view_delivery_visit();
		break;
	}
?>