<?php
	switch($_GET['execute'])
	{
		default:
			default_commission_report();
		break;
		
		case "form-report-commission":
		    form_report_commission();
		break;
	}
?>