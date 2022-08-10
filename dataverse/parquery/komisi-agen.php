<?php
	switch($_GET['execute'])
	{
		default:
			default_komisi_agen_platform();
		break;
		
		case "add-komisi-agen-platform":
			add_komisi_agen_platform();
		break;

		case "invoice-agen-platform":
			invoice_agen_platform();
		break;
		
		case "add-komisi-agen":
			$promo_id = sequence("promo", "promo_id");
			$invoice_id = sequence("invoice", "invoice_id");

			$total_quantity = 0;
			$total_komisi = 0;
			$komisi = 0;
			$reward = 0;

			$reward_fetch_array = mysql_fetch_array(mysql_query("SELECT * FROM reward WHERE reward_active = '1'"));

			$item_selling_query = mysql_query("SELECT * FROM item_selling a, reseller b WHERE a.reseller_id = b.reseller_id AND b.user_id = '".$_SESSION['user_id']."' AND a.invoice_status = 'Belum Cair' AND a.item_selling_active = '1'");
			$jml_item_selling = mysql_num_rows($item_selling_query);
			while($item_selling_fetch_array = mysql_fetch_array($item_selling_query))
			{
			    
			    
				$order_item_selling = mysql_query("SELECT * FROM order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling_fetch_array['item_selling_id']."' AND a.order_item_selling_active = '1'");
				while($data_order_item_selling = mysql_fetch_array($order_item_selling))
				{
				    if($komisi == 0)
				    {
				        $komisi = $data_order_item_selling['order_item_selling_quantity']*$data_order_item_selling['item_commission_value'];
				    }
				    else
					{
						$komisi = $komisi+$data_order_item_selling['order_item_selling_quantity']*$data_order_item_selling['item_commission_value'];
					}
										            
					if($total_quantity == 0)
					{
						$total_quantity = $data_order_item_selling['order_item_selling_quantity'];
					}
					else
					{
						$total_quantity = $total_quantity+$data_order_item_selling['order_item_selling_quantity'];
					}
										            
			    }
			    
			    $tgl_skrg = date('Y-m-d');
				$tanggal = date('d');
				$bulan = date('m');
				$tahun = date('Y');
				$tanggalbulantahun = $tanggal.''.$bulan.''.$tahun;
			    
			    $invoice_no = INVOICE.'/'.$item_selling_fetch_array['reseller_code'].'/'.$tanggalbulantahun;
			    
			    if($jml_item_selling == 1)
				{
					if($total_quantity >= $reward_fetch_array['selling_quantity'])
                    {	
					    $reward = ($total_quantity/$reward_fetch_array['selling_quantity'])*$reward_fetch_array['reward_value'];
                    }

					mysql_query("INSERT INTO `invoice`(`invoice_id`, `invoice_date`, `no_invoice`, `reseller_id`, `selling_date_from`, `selling_date_to`, `selling_quantity`, `commission`, `reward`,`invoice_status`, `invoice_datetime`, `invoice_active`) VALUES ('".$invoice_id."','".$tgl_skrg."','".$invoice_no."','".$item_selling_fetch_array['reseller_id']."','".$item_selling_fetch_array['item_selling_date']."','".$item_selling_fetch_array['item_selling_date']."','".$total_quantity."','".$komisi."','".$reward."','Pending','".$today."','1')");	

					$invoice_detail_id = sequence("invoice_detail", "invoice_detail_id");

					mysql_query("INSERT INTO `invoice_detail`(`invoice_detail_id`, `invoice_id`, `item_selling_id`, `invoice_detail_active`) VALUES ('".$invoice_detail_id."','".$invoice_id."','".$item_selling_fetch_array['item_selling_id']."','1')");
				}
				else
				{
					mysql_query("INSERT INTO `invoice`(`invoice_id`, `invoice_date`, `no_invoice`, `reseller_id`, `selling_date_from`, `selling_date_to`, `selling_quantity`, `commission`, `reward`,`invoice_status`, `invoice_datetime`, `invoice_active`) VALUES ('".$invoice_id."','".$tgl_skrg."','".$invoice_no."','".$item_selling_fetch_array['reseller_id']."','".$item_selling_fetch_array['item_selling_date']."','".$item_selling_fetch_array['item_selling_date']."','','','','Pending','".$today."','1')");	

					$invoice_detail_id = sequence("invoice_detail", "invoice_detail_id");

					mysql_query("INSERT INTO `invoice_detail`(`invoice_detail_id`, `invoice_id`, `item_selling_id`, `invoice_detail_active`) VALUES ('".$invoice_detail_id."','".$invoice_id."','".$item_selling_fetch_array['item_selling_id']."','1')");
				}
			    
			    mysql_query("UPDATE invoice SET selling_date_to = '".$item_selling_fetch_array['item_selling_date']."' WHERE invoice_id = '".$invoice_id."'");
			   
			}
			
			if($total_quantity >= $reward_fetch_array['selling_quantity'])
            {	
			    $reward = (round($total_quantity/$reward_fetch_array['selling_quantity']))*$reward_fetch_array['reward_value'];
            }

			mysql_query("UPDATE invoice SET selling_quantity = '".$total_quantity."', commission = '".$komisi."', reward = '".$reward."' WHERE invoice_id = '".$invoice_id."'");
			
			header("location:../dataverse/home.php?connect=komisi-agen");
		break;

		case "add-item-komisi-agen-platform":
			add_item_komisi_agen_platform();
		break;
		
		case "delete-komisi-agen":
		
			mysql_query("UPDATE invoice SET  invoice_active = '0' WHERE invoice_id = '".$_GET['invoice_id']."'");
			
			header("location:../dataverse/home.php?connect=komisi-agen");
		break;
	}
?>