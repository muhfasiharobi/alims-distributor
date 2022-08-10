<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_delivery_document();
		break;
	
		case "form-buffer-delivery-document":
			form_buffer_delivery_document();
		break;
	
		case "buffer-delivery-document":
			$delivery_document_id = idbaru("delivery_document","delivery_document_id");
			
			$tbl_user = mysql_query("SELECT c.user_department_code FROM user a, user_category b, user_department c WHERE a.user_id = '".$_SESSION['user_id']."' AND a.user_category_id = b.user_category_id AND b.user_department_id = c.user_department_id");
			$data_tbl_user = mysql_fetch_array($tbl_user);
			
			$unique_code = $data_tbl_user['user_department_code'] . "/" . "DD" . "-" . $thn_sekarang . "/" . $bln_sekarang . "/";

			$tbl_delivery_document = mysql_query("SELECT max(delivery_document_no) as maxID FROM delivery_document WHERE delivery_document_no LIKE '$unique_code%'");
			$data_tbl_delivery_document = mysql_fetch_array($tbl_delivery_document);
			
			$idMax = $data_tbl_delivery_document['maxID'];
				
			$noUrut = (int) substr($idMax, 15, 4);
					
			$noUrut++;
			
			$delivery_document_no = $unique_code . sprintf("%04s", $noUrut);
			
			mysql_query("INSERT INTO delivery_document(delivery_document_id, delivery_document_no, delivery_document_date, delivery_document_buffer_in, delivery_document_datetime, user_id) VALUES ('".$delivery_document_id."', '".$delivery_document_no."', '".$tgl_sekarang."', '".$_POST['delivery_document_buffer_in']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
			
			mysql_query("UPDATE delivery_distribution SET delivery_document_id = '".$delivery_document_id."' WHERE delivery_schedule_id = '".$_POST['delivery_schedule_id']."'");
			
			header("location:../system/home.php?alimms=delivery-document");
		break;
		
		case "form-edit-delivery-document":
			form_edit_delivery_document();
		break;
		
		case "edit-delivery-document":
			mysql_query("UPDATE delivery_document SET delivery_schedule_id = '".$_POST['delivery_schedule_id']."', delivery_document_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE delivery_document_id = '".$_POST['delivery_document_id']."'");
		
			header("location:../system/home.php?alimms=delivery-document");	
		break;
	
		case "form-print-delivery-document":
			form_print_delivery_document();
		break;
	}
?>