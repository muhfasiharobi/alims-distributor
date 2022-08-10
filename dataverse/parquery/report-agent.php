<?php
	switch($_GET['execute'])
	{
		default:
			default_report_agent_by_product_platform();
		break;
		
		case "form-report-selling-agent":
			form_report_selling_agent();
		break;
		
		case "insert-invoice-report-agent-by-product":
			$invoice_id = sequence("invoice", "invoice_id");
			
			$tgl = date('d');
    		$bulan = date('m');
    		$tahun= substr(date('Y'),2,2);
    		$tgl_skrg = date('Y-m-d');
    		
    		$no_invoice = $_GET['reseller'].''.$tgl.''.$bulan.''.$tahun;
    		
    		$from_date = explode("-", $_GET['from']);
			$date = $from_date[0];
			$month = $from_date[1];
			$year = $from_date[2];
			$from_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
			
			$to_date = explode("-", $_GET['to']);
			$date = $to_date[0];
			$month = $to_date[1];
			$year = $to_date[2];
			$to_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
			
			$tgl_skrg = date('Y-m-d');
			
			mysql_query("INSERT INTO `invoice`(`invoice_id`,`invoice_date`, `no_invoice`, `reseller_id`, `selling_date_from`, `selling_date_to`, `selling_quantity`, `selling_total`, `commission`,`invoice_status`,`invoice_category`, `invoice_datetime`, `invoice_active`) VALUES ('".$invoice_id."','".$tgl_skrg."','".$no_invoice."','".$_GET['reseller']."','".$from_date."','".$to_date."','".$_GET['qty']."','','".$_GET['komisi']."','Pending','quantity','".$today."','1')");
			
			mysql_query("UPDATE item_selling SET item_selling_status = 'Process' WHERE item_selling_active = '1' AND reseller_id = '".$_GET['reseller']."' AND item_selling_date BETWEEN '".$from_date."' AND '".$to_date."'");
			
			header("location:../dataverse/home.php?connect=report-agent&execute=invoice-report-agent-by-product&from=".$_GET['from']."&to=".$_GET['to']."&reseller=".$_GET['reseller']);
		break;
		
		case "invoice-report-agent-by-product":
			invoice_report_agent_by_product();
		break;
		
		case "report-agent-sum-selling":
			report_agent_sum_selling();
		break;
		
		case "form-report-sum-selling":
			form_report_sum_selling();
		break;
		
		case "insert-invoice-report-agent-by-sum-selling":
		    $invoice_id = sequence("invoice", "invoice_id");
			
			$tgl = date('d');
    		$bulan = date('m');
    		$tahun= substr(date('Y'),2,2);
    		$tgl_skrg = date('Y-m-d');
    		
    		$no_invoice = $_GET['reseller'].''.$tgl.''.$bulan.''.$tahun;
    		
    		$from_date = explode("-", $_GET['from']);
			$date = $from_date[0];
			$month = $from_date[1];
			$year = $from_date[2];
			$from_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
			
			$to_date = explode("-", $_GET['to']);
			$date = $to_date[0];
			$month = $to_date[1];
			$year = $to_date[2];
			$to_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
			
			$tgl_skrg = date('Y-m-d');
			
			mysql_query("INSERT INTO `invoice`(`invoice_id`,`invoice_date`, `no_invoice`, `reseller_id`, `selling_date_from`, `selling_date_to`, `selling_quantity`, `selling_total`, `commission`,`invoice_status`,`invoice_category`, `invoice_datetime`, `invoice_active`) VALUES ('".$invoice_id."','".$tgl_skrg."','".$no_invoice."','".$_GET['reseller']."','".$from_date."','".$to_date."','','".$_GET['total']."','".$_GET['komisi']."','Pending','selling','".$today."','1')");
			
			mysql_query("UPDATE item_selling SET item_selling_status = 'Process' WHERE item_selling_active = '1' AND reseller_id = '".$_GET['reseller']."' AND item_selling_date BETWEEN '".$from_date."' AND '".$to_date."'");
			
			header("location:../dataverse/home.php?connect=report-agent&execute=invoice-report-agent-by-sum-selling&from=".$_GET['from']."&to=".$_GET['to']."&reseller=".$_GET['reseller']);
		break;
		
		case "invoice-report-agent-by-sum-selling":
			invoice_report_agent_by_sum_selling();
		break;
	}
?>