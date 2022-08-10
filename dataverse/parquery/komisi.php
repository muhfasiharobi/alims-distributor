<?php
	switch($_GET['execute'])
	{
		default:
			default_komisi_platform();
		break;
		
		case "add-komisi-platform":
			add_komisi_platform();
		break;

		case "invoice-platform":
			invoice_platform();
		break;

		case "list-month-komisi-platform":
			list_month_komisi_platform();
		break;

		case "add-komisi-transfer-platform":
			add_komisi_transfer_platform();
		break;
		
		case "add-transfer-komisi":
			$invoice_transfer_id = sequence("invoice_transfer", "invoice_transfer_id");
			$invoice_id = sequence("invoice", "invoice_id");

			$total_quantity = 0;
			$total_komisi = 0;
			$komisi = 0;
			$reward = 0;

			$reward_fetch_array = mysql_fetch_array(mysql_query("SELECT * FROM reward WHERE reward_active = '1'"));

			$item_selling_query = mysql_query("SELECT * FROM item_selling a, reseller b WHERE a.reseller_id = b.reseller_id AND a.reseller_id = '".$_POST['reseller_id']."' AND a.invoice_status = 'Belum Cair' AND a.item_selling_active = '1' AND month(a.item_selling_date) = '".$_POST['month']."'");
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

					mysql_query("INSERT INTO `invoice`(`invoice_id`, `invoice_date`, `no_invoice`, `reseller_id`,`month`, `selling_date_from`, `selling_date_to`, `selling_quantity`, `commission`, `reward`,`invoice_status`, `invoice_datetime`, `invoice_active`) VALUES ('".$invoice_id."','".$tgl_skrg."','".$invoice_no."','".$item_selling_fetch_array['reseller_id']."','".$_POST['month']."','".$item_selling_fetch_array['item_selling_date']."','".$item_selling_fetch_array['item_selling_date']."','".$total_quantity."','".$komisi."','".$reward."','Pending','".$today."','1')");	

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


			$reseller = mysql_fetch_array(mysql_query("SELECT * FROM reseller a, bank b WHERE a.bank_id = b.bank_id AND a.reseller_id = '".$_POST['reseller_id']."'"));

			mysql_query("UPDATE invoice SET reseller_code = '".$reseller['reseller_code']."', reseller_name = '".$reseller['reseller_name']."',reseller_address = '".$reseller['reseller_address']."',reseller_village = '".$reseller['reseller_village']."',reseller_districts = '".$reseller['reseller_districts']."',reseller_city = '".$reseller['reseller_city']."',reseller_phone = '".$reseller['reseller_phone']."',reseller_bank_name = '".$reseller['bank_name']."',reseller_account_number = '".$reseller['reseller_account_number']."', reseller_account_name = '".$reseller['reseller_account_name']."', invoice_status = 'Done' WHERE invoice_id = '".$invoice_id."'");

			$invoice_transfer_date = explode("-", $_POST['invoice_transfer_date']);
			$date = $invoice_transfer_date[0];
			$month = $invoice_transfer_date[1];
			$year = $invoice_transfer_date[2];
			$invoice_transfer_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));

			// ambil data file
                $namaFile = $invoice_transfer_id.'-'.$_FILES['bukti_transfer']['name'];
                $namaSementara = $_FILES['bukti_transfer']['tmp_name'];
                
                // tentukan lokasi file akan dipindahkan
                $dirUpload = "pencairan/";
                
                // pindahkan file
                $terupload = move_uploaded_file($namaSementara, $dirUpload.$namaFile);

			mysql_query("INSERT INTO `invoice_transfer`(`invoice_transfer_id`, `invoice_id`, `transfer_date`, `bank_id`, `account_number`, `account_name`, `transfer_value`, `transfer_photo`, `invoice_transfer_datetime`, `invoice_transfer_active`) VALUES ('".$invoice_transfer_id."','".$invoice_id."','".$invoice_transfer_date."','".$_POST['bank_id']."','".$_POST['no_rekening']."','".$_POST['rekening_name']."','".$_POST['jumlah_transfer']."','".$namaFile."','".$today."','1')");


			$item_selling = mysql_query("SELECT * FROM item_selling a, invoice_detail b WHERE a.item_selling_id = b.item_selling_id AND b.invoice_id = '".$invoice_id."'");
			while($data_item_selling = mysql_fetch_array($item_selling))
			{
				mysql_query("UPDATE item_selling SET invoice_status = 'Cair' WHERE item_selling_id = '".$data_item_selling['item_selling_id']."'");
			}

			header("location:../dataverse/home.php?connect=komisi");
		break;

		case "add-item-komisi-platform":
			add_item_komisi_platform();
		break;
		
		case "delete-komisi":
		
			mysql_query("UPDATE invoice SET  invoice_active = '0' WHERE invoice_id = '".$_GET['invoice_id']."'");
			
			header("location:../dataverse/home.php?connect=komisi");
		break;
	}
?>