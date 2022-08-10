<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_supplier();
		break;
		
		case "form-add-supplier":
			form_add_supplier();
		break;
	
		case "add-supplier":
			$supplier_id = idbaru("supplier","supplier_id");
			
			mysql_query("INSERT INTO supplier(supplier_id, supplier_name, supplier_address, supplier_city, supplier_contact, supplier_phone, supplier_email, supplier_datetime, user_id) VALUES ('".$supplier_id."', '".$_POST['supplier_name']."', '".$_POST['supplier_address']."', '".$_POST['supplier_city']."', '".$_POST['supplier_contact']."', '".$_POST['supplier_phone']."', '".$_POST['supplier_email']."', '".$waktu_sekarang."', '".$_SESSION['user_id']."')");
	
			header("location:../system/page_home.php?alimms=supplier");	
		break;
	
		case "form-edit-supplier":
			form_edit_supplier();
		break;
		
		case "edit-supplier":
			mysql_query("UPDATE supplier SET supplier_name = '".$_POST['supplier_name']."', supplier_address = '".$_POST['supplier_address']."', supplier_city = '".$_POST['supplier_city']."', supplier_contact = '".$_POST['supplier_contact']."', supplier_phone = '".$_POST['supplier_phone']."', supplier_email = '".$_POST['supplier_email']."', supplier_datetime = '".$waktu_sekarang."', user_id = '".$_SESSION['user_id']."' WHERE supplier_id = '".$_POST['supplier_id']."'");
		
			header("location:../system/page_home.php?alimms=supplier");	
		break;
	
		case "delete-supplier":
			mysql_query("UPDATE supplier SET supplier_datetime = '".$waktu_sekarang."', supplier_active = '0', user_id = '".$_SESSION['user_id']."' WHERE supplier_id = '".$_GET['supplier_id']."'");
			
			header("location:../system/page_home.php?alimms=supplier");	
		break;
	}
?>