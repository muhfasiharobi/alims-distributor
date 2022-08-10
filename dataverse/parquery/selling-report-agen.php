<?php
	switch($_GET['execute'])
	{
		default:
			default_selling_report_agen();
		break;
		
		case "form-report-selling-agen":
		    form_report_selling_agen();
		break;
	}
?>