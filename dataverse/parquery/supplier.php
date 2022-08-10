<?php
	switch($_GET['execute'])
	{
		default:
			default_supplier_platform();
		break;
		
		case "add-supplier-platform":
			add_supplier_platform();
		break;
		
		case "add-supplier":
			$supplier_id = sequence("supplier", "supplier_id");
			
			mysql_query("INSERT INTO supplier(supplier_id, supplier_name, supplier_create, supplier_update, user_activity_id, supplier_active) VALUES ('".$supplier_id."', '".$_POST['supplier_name']."', '".$today."', '".$today."', '".$_SESSION['user_id']."', '1')");
			
			header("location:../dataverse/home.php?connect=supplier");
		break;
		
		case "edit-supplier-platform":
			edit_supplier_platform();
		break;
		
		case "edit-supplier":
			mysql_query("UPDATE supplier SET supplier_name = '".$_POST['supplier_name']."', supplier_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."' WHERE supplier_id = '".$_POST['supplier_id']."'");
			
			header("location:../dataverse/home.php?connect=supplier");
		break;
		
		case "delete-supplier":
			mysql_query("UPDATE supplier SET supplier_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', supplier_active = '0' WHERE supplier_id = '".$_GET['supplier_id']."'");
			
			header("location:../dataverse/home.php?connect=supplier");
		break;
	}
?>