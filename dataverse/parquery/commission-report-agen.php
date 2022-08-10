<?php
	switch($_GET['execute'])
	{
		default:
			default_commission_report_agen();
		break;
		
		case "form-report-commission-agen":
		    form_report_commission_agen();
		break;
	}
?>