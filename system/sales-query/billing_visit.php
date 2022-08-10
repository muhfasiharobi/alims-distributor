<?php
	switch($_GET['tib'])
	{
		default:
			form_initial_billing_visit();
		break;
		
		case "form-view-billing-visit":
			form_view_billing_visit();
		break;
		
		case "form-edit-billing-visit":
			form_edit_billing_visit();
		break;
		
		case "edit-billing-visit":
			
			mysql_query("UPDATE billing_visit a, billing_visit_detail b SET a.billing_visit_status = '".$_POST['payment_order_detail_payment_status']."', b.billing_visit_detail_nominal = '".$_POST['billing_visit_detail_payment_nominal']."', b.billing_visit_detail_description = '".$_POST['payment_order_detail_payment_description']."' WHERE a.billing_visit_id = b.billing_visit_id AND a.billing_visit_id = '".$_POST['billing_visit_id']."'");
			
			header("location:../system/page_home.php?alimms=billing-visit");
		break;
	}
?>