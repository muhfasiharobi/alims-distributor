<?php
	switch($_GET['execute'])
	{
		default:
			default_selling_report();
		break;
		
		case "form-report-selling":
		    form_report_selling();
		break;
	}
?>