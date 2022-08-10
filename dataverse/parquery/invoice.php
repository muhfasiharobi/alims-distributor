<?php
	switch($_GET['execute'])
	{
		default:
			default_invoice_platform();
		break;
		
		case "process-invoice":
		    
		    mysql_query("UPDATE invoice SET invoice_status = 'done' WHERE invoice_id = '".$_GET['invoice_id']."'");
		    
		    $invoice = mysql_fetch_array(mysql_query("SELECT * FROM invoice WHERE invoice_id = '".$_GET['invoice_id']."'"));
		    
		    mysql_query("UPDATE item_selling SET item_selling_status = 'Done' WHERE item_selling_active = '1' AND reseller_id = '".$invoice['reseller_id']."' AND item_selling_date BETWEEN '".$invoice['selling_date_from']."' AND '".$invoice['selling_date_to']."'");
		    
		    header("location:../dataverse/home.php?connect=invoice");
		break;
		
		case "cetak-invoice":
		    cetak_invoice();
		break;
		
	}
	
?>