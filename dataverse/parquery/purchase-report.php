<?php
	switch($_GET['execute'])
	{
		default:
			default_purchase_report();
		break;
		
		case "form-report-purchase":
		    form_report_purchase();
		break;
	}
?>