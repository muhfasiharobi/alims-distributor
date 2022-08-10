<?php
	switch($_GET['execute'])
	{
		default:
			default_item_selling_platform();
		break;
		
		case "add-item-selling-platform":
			add_item_selling_platform();
		break;
		
		case "add-item-selling":
			$item_selling_id = sequence("item_selling", "item_selling_id");
			
			$item_selling_date = explode("-", $_POST['item_selling_date']);
			$date = $item_selling_date[0];
			$month = $item_selling_date[1];
			$year = $item_selling_date[2];
			$item_selling_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));

			$reseller_id = $_POST['reseller_id'];

			$bulan = date('m');
			$tahun = date('y');

			$selling_code = "INV".''.$item_selling_id.''.$bulan.''.$tahun;

			$promo = mysql_fetch_array(mysql_query("SELECT * FROM promo WHERE promo_id = '".$_POST['promo_id']."'"));

			mysql_query("INSERT INTO item_selling(item_selling_id, item_selling_code,item_selling_date, reseller_id, customer_id, order_via_id, item_selling_delivery_id,promo_id, kategori_promo,item_selling_status, invoice_status, item_selling_create, item_selling_update, user_activity_id, item_selling_active) VALUES ('".$item_selling_id."', '".$selling_code."','".$item_selling_date."', '".$reseller_id."', '".$_POST['customer_id']."','".$_POST['order_via_id']."', '', '".$_POST['promo_id']."','".$promo['kategori_promo']."','Belum Diproses','Belum Cair', '".$today."', '".$today."', '".$_SESSION['user_id']."', '0')");
			
			header("location:../dataverse/home.php?connect=item-selling&execute=add-delivery-platform&item_selling_id=".$item_selling_id);
		break;
		
		case "add-delivery-platform":
			add_delivery_platform();
		break;

		case "add-delivery":
			$item_selling_delivery_id = sequence("item_selling_delivery", "item_selling_delivery_id");

			// ambil data file
                $namaFile = $item_selling_delivery_id.'-'.$_FILES['payment']['name'];
                $namaSementara = $_FILES['payment']['tmp_name'];
                
                // tentukan lokasi file akan dipindahkan
                $dirUpload = "transfer/";
                
                // pindahkan file
                $terupload = move_uploaded_file($namaSementara, $dirUpload.$namaFile);

			mysql_query("INSERT INTO `item_selling_delivery`(`item_selling_delivery_id`, `item_selling_id`,`item_selling_delivery_date`, `delivery_service_id`, `no_resi`, `delivery_cost`, `delivery_address`,`payment`, `item_selling_delivery_update`, `user_activity_id`, `item_selling_delivery_active`) VALUES ('".$item_selling_delivery_id."','".$_POST['item_selling_id']."','0000-00-00','".$_POST['delivery_service_id']."','".$_POST['no_resi']."','".$_POST['delivery_cost']."','".$_POST['delivery_address']."','".$namaFile."','".$today."','".$_SESSION['user_id']."','1')");

			mysql_query("UPDATE item_selling SET item_selling_delivery_id = '".$item_selling_delivery_id."' WHERE item_selling_id = '".$_POST['item_selling_id']."'");

			header("location:../dataverse/home.php?connect=item-selling&execute=order-item-selling-platform&item_selling_id=".$_POST['item_selling_id']);
		break;

		case "add-resi-agent-platform":
			add_resi_agent_platform();
		break;
		
		case "add-resi-platform":
			add_resi_platform();
		break;
		
		case "add-resi-agent":
			$order_via = mysql_fetch_array(mysql_query("SELECT * FROM order_via a, item_selling b WHERE a.order_via_id = b.order_via_id AND b.item_selling_id = '".$_POST['item_selling_id']."'"));
			
			if($order_via['order_via_name'] == "Whatsapp")
			{
				$item_selling_delivery_id = sequence("item_selling_delivery", "item_selling_delivery_id");
				
				$item_selling_delivery_date = explode("-", $_POST['item_selling_delivery_date']);
				$date = $item_selling_delivery_date[0];
				$month = $item_selling_delivery_date[1];
				$year = $item_selling_delivery_date[2];
				$item_selling_delivery_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
				
				$item_selling = mysql_fetch_array(mysql_query("SELECT * FROM item_selling WHERE item_selling_id = '".$_POST['item_selling_id']."'"));
				$order_item_selling = mysql_query("SELECT * FROM order_item_selling WHERE item_selling_id = '".$_POST['item_selling_id']."'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
				    $item = mysql_fetch_array(mysql_query("SELECT * FROM item WHERE item_id = '".$data_order_item_selling['item_id']."'"));
    				$item_price = mysql_fetch_array(mysql_query("SELECT * FROM item_price WHERE item_price_id = '".$data_order_item_selling['item_price_id']."'"));
    				$item_commission = mysql_fetch_array(mysql_query("SELECT * FROM item_commission WHERE item_commission_id = '".$data_order_item_selling['item_commission_id']."'"));
    				

    				if($data_order_item_selling['item_price_value'] == "")
    				{
    					mysql_query("UPDATE order_item_selling SET item_name = '".$item['item_name']."', item_price_value = '".$item_price['item_price_value']."', item_commission_value = '".$item_commission['item_commission_value']."' WHERE order_item_selling_id = '".$data_order_item_selling['order_item_selling_id']."'");
    				}
    				else
    				{
    					mysql_query("UPDATE order_item_selling SET item_name = '".$item['item_name']."' WHERE order_item_selling_id = '".$data_order_item_selling['order_item_selling_id']."'");
    				}
    					
    			}	
    				$reseller = mysql_fetch_array(mysql_query("SELECT * FROM reseller WHERE reseller_id = '".$item_selling['reseller_id']."'"));
    				$customer = mysql_fetch_array(mysql_query("SELECT * FROM customer WHERE customer_id = '".$item_selling['customer_id']."'"));
    				$reseller_address = $reseller['reseller_address'].','.$reseller['reseller_village'].'-'.$reseller['reseller_districts'].'-'.$reseller['reseller_city'];

    				$total = 0;
					$order_item_selling_query = mysql_query("SELECT * FROM order_item_selling a, item b WHERE a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.item_id = b.item_id AND b.item_active = '1'");
					while($order_item_selling_fetch_array = mysql_fetch_array($order_item_selling_query))
					{
														
						if($total == 0)
						{
							$total = $order_item_selling_fetch_array['item_price_value']*$order_item_selling_fetch_array['order_item_selling_quantity'];
						}
						else
						{
							$total = $total + ($order_item_selling_fetch_array['item_price_value']*$order_item_selling_fetch_array['order_item_selling_quantity']);
						}
					}


    				$promo = 0;
					if($item_selling['promo_id'] != 0)
					{
														
    					$promo_fetch_array = mysql_fetch_array(mysql_query("SELECT * FROM promo WHERE promo_id = '".$item_selling['promo_id']."'"));
    					$promo = $promo_fetch_array['promo_value'];
    				}


    				mysql_query("UPDATE item_selling SET item_selling_status = 'Sudah Diproses', reseller_code = '".$reseller['reseller_code']."', reseller_name = '".$reseller['reseller_name']."',reseller_address = '".$reseller_address."',reseller_phone = '".$reseller['reseller_phone']."', customer_code = '".$customer['customer_code']."', customer_name = '".$customer['customer_name']."', customer_address = '".$customer['customer_address']."',customer_village = '".$customer['customer_village']."',customer_districts = '".$customer['customer_districts']."',customer_city = '".$customer['customer_city']."',customer_phone = '".$customer['customer_phone']."', promo_value = '".$promo."' WHERE item_selling_id = '".$_POST['item_selling_id']."'");

    				$delivery_service = mysql_fetch_array(mysql_query("SELECT delivery_service_name FROM delivery_service WHERE delivery_service_id = '".$_POST['delivery_service_id']."'"));
    				
    				mysql_query("UPDATE item_selling_delivery SET delivery_service_name = '".$delivery_service['delivery_service_name']."', item_selling_delivery_date = '".$item_selling_delivery_date."', delivery_service_id = '".$_POST['delivery_service_id']."', no_resi = '".$_POST['no_resi']."', delivery_cost = '".$_POST['delivery_cost']."' WHERE item_selling_delivery_id = '".$item_selling['item_selling_delivery_id']."'");
    			
			}
			else
			{
				$item_selling_delivery_id = sequence("item_selling_delivery", "item_selling_delivery_id");
				
				$item_selling_delivery_date = explode("-", $_POST['item_selling_delivery_date']);
				$date = $item_selling_delivery_date[0];
				$month = $item_selling_delivery_date[1];
				$year = $item_selling_delivery_date[2];
				$item_selling_delivery_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
				
				$item_selling = mysql_fetch_array(mysql_query("SELECT * FROM item_selling WHERE item_selling_id = '".$_POST['item_selling_id']."'"));
				$order_item_selling = mysql_query("SELECT * FROM order_item_selling WHERE item_selling_id = '".$_POST['item_selling_id']."'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
				    $item = mysql_fetch_array(mysql_query("SELECT * FROM item WHERE item_id = '".$data_order_item_selling['item_id']."'"));
    				$item_price = mysql_fetch_array(mysql_query("SELECT * FROM item_price WHERE item_price_id = '".$data_order_item_selling['item_price_id']."'"));
    				$item_commission = mysql_fetch_array(mysql_query("SELECT * FROM item_commission WHERE item_commission_id = '".$data_order_item_selling['item_commission_id']."'"));
    				

    				if($data_order_item_selling['item_price_value'] == "")
    				{
    					mysql_query("UPDATE order_item_selling SET item_name = '".$item['item_name']."', item_price_value = '".$item_price['item_price_value']."', item_commission_value = '".$item_commission['item_commission_value']."' WHERE order_item_selling_id = '".$data_order_item_selling['order_item_selling_id']."'");
    				}
    				else
    				{
    					mysql_query("UPDATE order_item_selling SET item_name = '".$item['item_name']."' WHERE order_item_selling_id = '".$data_order_item_selling['order_item_selling_id']."'");
    				}
    				
    			}    
    				$reseller = mysql_fetch_array(mysql_query("SELECT * FROM reseller WHERE reseller_id = '".$item_selling['reseller_id']."'"));
    				$customer = mysql_fetch_array(mysql_query("SELECT * FROM customer WHERE customer_id = '".$item_selling['customer_id']."'"));
    				$reseller_address = $reseller['reseller_address'].','.$reseller['reseller_village'].'-'.$reseller['reseller_districts'].'-'.$reseller['reseller_city'];

    				$total = 0;
					$order_item_selling_query = mysql_query("SELECT * FROM order_item_selling a, item b WHERE a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.item_id = b.item_id AND b.item_active = '1'");
					while($order_item_selling_fetch_array = mysql_fetch_array($order_item_selling_query))
					{
														
						if($total == 0)
						{
							$total = $order_item_selling_fetch_array['item_price_value']*$order_item_selling_fetch_array['order_item_selling_quantity'];
						}
						else
						{
							$total = $total + ($order_item_selling_fetch_array['item_price_value']*$order_item_selling_fetch_array['order_item_selling_quantity']);
						}
					}


    				$promo = 0;
					if($item_selling['promo_id'] != 0)
					{
														
    					$promo_fetch_array = mysql_fetch_array(mysql_query("SELECT * FROM promo WHERE promo_id = '".$item_selling['promo_id']."'"));
    					$promo = $promo_fetch_array['promo_value'];
    				}
    				
    				mysql_query("UPDATE item_selling SET item_selling_status = 'Sudah Diproses', reseller_code = '".$reseller['reseller_code']."', reseller_name = '".$reseller['reseller_name']."',reseller_address = '".$reseller_address."',reseller_phone = '".$reseller['reseller_phone']."', customer_code = '".$customer['customer_code']."', customer_name = '".$customer['customer_name']."', customer_address = '".$customer['customer_address']."',customer_village = '".$customer['customer_village']."',customer_districts = '".$customer['customer_districts']."',customer_city = '".$customer['customer_city']."',customer_phone = '".$customer['customer_phone']."', promo_value = '".$promo."' WHERE item_selling_id = '".$_POST['item_selling_id']."'");
    				$delivery_service = mysql_fetch_array(mysql_query("SELECT a.delivery_service_name FROM delivery_service a, item_selling_delivery b WHERE a.delivery_service_id = b.delivery_service_id AND b.item_selling_delivery_id = '".$item_selling['item_selling_delivery_id']."'"));
    				mysql_query("UPDATE item_selling_delivery SET delivery_service_name = '".$delivery_service['delivery_service_name']."', item_selling_delivery_date = '".$item_selling_delivery_date."' WHERE item_selling_delivery_id = '".$item_selling['item_selling_delivery_id']."'");
    			
			}
			
			header("location:../dataverse/home.php?connect=item-selling");
		break;
		
		case "add-resi":
		    
		    $order_via = mysql_fetch_array(mysql_query("SELECT * FROM order_via a, item_selling b WHERE a.order_via_id = b.order_via_id AND b.item_selling_id = '".$_POST['item_selling_id']."'"));
			
			if($order_via['order_via_name'] == "Whatsapp")
			{
				$item_selling_delivery_id = sequence("item_selling_delivery", "item_selling_delivery_id");
				
				$item_selling_delivery_date = explode("-", $_POST['item_selling_delivery_date']);
				$date = $item_selling_delivery_date[0];
				$month = $item_selling_delivery_date[1];
				$year = $item_selling_delivery_date[2];
				$item_selling_delivery_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
				
				$item_selling = mysql_fetch_array(mysql_query("SELECT * FROM item_selling WHERE item_selling_id = '".$_POST['item_selling_id']."'"));
				$order_item_selling = mysql_query("SELECT * FROM order_item_selling WHERE item_selling_id = '".$_POST['item_selling_id']."'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
				    $item = mysql_fetch_array(mysql_query("SELECT * FROM item WHERE item_id = '".$data_order_item_selling['item_id']."'"));
    				$item_price = mysql_fetch_array(mysql_query("SELECT * FROM item_price WHERE item_price_id = '".$data_order_item_selling['item_price_id']."'"));
    				$item_commission = mysql_fetch_array(mysql_query("SELECT * FROM item_commission WHERE item_commission_id = '".$data_order_item_selling['item_commission_id']."'"));
    				
    				mysql_query("UPDATE order_item_selling SET item_name = '".$item['item_name']."', item_price_value = '".$item_price['item_price_value']."', item_commission_value = '".$item_commission['item_commission_value']."' WHERE order_item_selling_id = '".$data_order_item_selling['order_item_selling_id']."'");
    			}	
    				$reseller = mysql_fetch_array(mysql_query("SELECT * FROM reseller WHERE reseller_id = '".$item_selling['reseller_id']."'"));
    				$customer = mysql_fetch_array(mysql_query("SELECT * FROM customer WHERE customer_id = '".$item_selling['customer_id']."'"));
    				$reseller_address = $reseller['reseller_address'].','.$reseller['reseller_village'].'-'.$reseller['reseller_districts'].'-'.$reseller['reseller_city'];

    				$total = 0;
					$order_item_selling_query = mysql_query("SELECT * FROM order_item_selling a, item b WHERE a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.item_id = b.item_id AND b.item_active = '1'");
					while($order_item_selling_fetch_array = mysql_fetch_array($order_item_selling_query))
					{
														
						if($total == 0)
						{
							$total = $order_item_selling_fetch_array['item_price_value']*$order_item_selling_fetch_array['order_item_selling_quantity'];
						}
						else
						{
							$total = $total + ($order_item_selling_fetch_array['item_price_value']*$order_item_selling_fetch_array['order_item_selling_quantity']);
						}
					}


    				$promo = 0;
					if($item_selling['promo_id'] != 0)
					{
														
    					$promo_fetch_array = mysql_fetch_array(mysql_query("SELECT * FROM promo WHERE promo_id = '".$item_selling['promo_id']."'"));
    					$promo = $promo_fetch_array['promo_value'];
    				}


    				mysql_query("UPDATE item_selling SET item_selling_status = 'Sudah Diproses', reseller_code = '".$reseller['reseller_code']."', reseller_name = '".$reseller['reseller_name']."',reseller_address = '".$reseller_address."',reseller_phone = '".$reseller['reseller_phone']."', customer_code = '".$customer['customer_code']."', customer_name = '".$customer['customer_name']."', customer_address = '".$customer['customer_address']."',customer_village = '".$customer['customer_village']."',customer_districts = '".$customer['customer_districts']."',customer_city = '".$customer['customer_city']."',customer_phone = '".$customer['customer_phone']."', promo_value = '".$promo."' WHERE item_selling_id = '".$_POST['item_selling_id']."'");

    				$delivery_service = mysql_fetch_array(mysql_query("SELECT delivery_service_name FROM delivery_service WHERE delivery_service_id = '".$_POST['delivery_service_id']."'"));
    				
    				mysql_query("UPDATE item_selling_delivery SET delivery_service_name = '".$delivery_service['delivery_service_name']."', item_selling_delivery_date = '".$item_selling_delivery_date."', delivery_service_id = '".$_POST['delivery_service_id']."', no_resi = '".$_POST['no_resi']."', delivery_cost = '".$_POST['delivery_cost']."' WHERE item_selling_delivery_id = '".$item_selling['item_selling_delivery_id']."'");
    			
			}
			else
			{
				$item_selling_delivery_id = sequence("item_selling_delivery", "item_selling_delivery_id");
				
				$item_selling_delivery_date = explode("-", $_POST['item_selling_delivery_date']);
				$date = $item_selling_delivery_date[0];
				$month = $item_selling_delivery_date[1];
				$year = $item_selling_delivery_date[2];
				$item_selling_delivery_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
				
				$item_selling = mysql_fetch_array(mysql_query("SELECT * FROM item_selling WHERE item_selling_id = '".$_POST['item_selling_id']."'"));
				$order_item_selling = mysql_query("SELECT * FROM order_item_selling WHERE item_selling_id = '".$_POST['item_selling_id']."'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
				    $item = mysql_fetch_array(mysql_query("SELECT * FROM item WHERE item_id = '".$data_order_item_selling['item_id']."'"));
    				$item_price = mysql_fetch_array(mysql_query("SELECT * FROM item_price WHERE item_price_id = '".$data_order_item_selling['item_price_id']."'"));
    				$item_commission = mysql_fetch_array(mysql_query("SELECT * FROM item_commission WHERE item_commission_id = '".$data_order_item_selling['item_commission_id']."'"));
    				
				    mysql_query("UPDATE order_item_selling SET item_name = '".$item['item_name']."', item_price_value = '".$item_price['item_price_value']."', item_commission_value = '".$item_commission['item_commission_value']."' WHERE order_item_selling_id = '".$data_order_item_selling['order_item_selling_id']."'");
    			}    
    				$reseller = mysql_fetch_array(mysql_query("SELECT * FROM reseller WHERE reseller_id = '".$item_selling['reseller_id']."'"));
    				$customer = mysql_fetch_array(mysql_query("SELECT * FROM customer WHERE customer_id = '".$item_selling['customer_id']."'"));
    				$reseller_address = $reseller['reseller_address'].','.$reseller['reseller_village'].'-'.$reseller['reseller_districts'].'-'.$reseller['reseller_city'];

    				$total = 0;
					$order_item_selling_query = mysql_query("SELECT * FROM order_item_selling a, item b WHERE a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.item_id = b.item_id AND b.item_active = '1'");
					while($order_item_selling_fetch_array = mysql_fetch_array($order_item_selling_query))
					{
														
						if($total == 0)
						{
							$total = $order_item_selling_fetch_array['item_price_value']*$order_item_selling_fetch_array['order_item_selling_quantity'];
						}
						else
						{
							$total = $total + ($order_item_selling_fetch_array['item_price_value']*$order_item_selling_fetch_array['order_item_selling_quantity']);
						}
					}


    				$promo = 0;
					if($item_selling['promo_id'] != 0)
					{
														
    					$promo_fetch_array = mysql_fetch_array(mysql_query("SELECT * FROM promo WHERE promo_id = '".$item_selling['promo_id']."'"));
    					$promo = $promo_fetch_array['promo_value'];
    				}
    				
    				mysql_query("UPDATE item_selling SET item_selling_status = 'Sudah Diproses', reseller_code = '".$reseller['reseller_code']."', reseller_name = '".$reseller['reseller_name']."',reseller_address = '".$reseller_address."',reseller_phone = '".$reseller['reseller_phone']."', customer_code = '".$customer['customer_code']."', customer_name = '".$customer['customer_name']."', customer_address = '".$customer['customer_address']."',customer_village = '".$customer['customer_village']."',customer_districts = '".$customer['customer_districts']."',customer_city = '".$customer['customer_city']."',customer_phone = '".$customer['customer_phone']."', promo_value = '".$promo."' WHERE item_selling_id = '".$_POST['item_selling_id']."'");
    				$delivery_service = mysql_fetch_array(mysql_query("SELECT a.delivery_service_name FROM delivery_service a, item_selling_delivery b WHERE a.delivery_service_id = b.delivery_service_id AND b.item_selling_delivery_id = '".$item_selling['item_selling_delivery_id']."'"));
    				mysql_query("UPDATE item_selling_delivery SET delivery_service_name = '".$delivery_service['delivery_service_name']."', item_selling_delivery_date = '".$item_selling_delivery_date."' WHERE item_selling_delivery_id = '".$item_selling['item_selling_delivery_id']."'");
    			
			}
			
		/*	
			$item_selling_delivery_date = explode("-", $_POST['item_selling_delivery_date']);
			$date = $item_selling_delivery_date[0];
			$month = $item_selling_delivery_date[1];
			$year = $item_selling_delivery_date[2];
			$item_selling_delivery_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
			
			$item_selling = mysql_fetch_array(mysql_query("SELECT * FROM item_selling WHERE item_selling_id = '".$_POST['item_selling_id']."'"));
			$order_item_selling = mysql_query("SELECT * FROM order_item_selling WHERE item_selling_id = '".$_POST['item_selling_id']."'");
			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
			{
    			
    			$item = mysql_fetch_array(mysql_query("SELECT * FROM item WHERE item_id = '".$data_order_item_selling['item_id']."'"));
    			mysql_query("UPDATE order_item_selling SET item_name = '".$item['item_name']."' WHERE order_item_selling_id = '".$data_order_item_selling['order_item_selling_id']."'");
			}
			
			$reseller = mysql_fetch_array(mysql_query("SELECT * FROM reseller WHERE reseller_id = '".$item_selling['reseller_id']."'"));
    		$customer = mysql_fetch_array(mysql_query("SELECT * FROM customer WHERE customer_id = '".$item_selling['customer_id']."'"));
    		$reseller_address = $reseller['reseller_address'].','.$reseller['reseller_village'].'-'.$reseller['reseller_districts'].'-'.$reseller['reseller_city'];

    		$promo = 0;
					if($item_selling['promo_id'] != 0)
					{
														
    					$promo_fetch_array = mysql_fetch_array(mysql_query("SELECT * FROM promo WHERE promo_id = '".$item_selling['promo_id']."'"));
    					$promo = $promo_fetch_array['promo_value'];
    				}
    			
    		mysql_query("UPDATE item_selling SET item_selling_status = 'Sudah Diproses', reseller_code = '".$reseller['reseller_code']."', reseller_name = '".$reseller['reseller_name']."',reseller_address = '".$reseller_address."',reseller_phone = '".$reseller['reseller_phone']."', customer_code = '".$customer['customer_code']."', customer_name = '".$customer['customer_name']."', customer_address = '".$customer['customer_address']."',customer_village = '".$customer['customer_village']."',customer_districts = '".$customer['customer_districts']."',customer_city = '".$customer['customer_city']."',customer_phone = '".$customer['customer_phone']."', promo_value = '".$promo."' WHERE item_selling_id = '".$_POST['item_selling_id']."'");
			
			$delivery_service = mysql_fetch_array(mysql_query("SELECT * FROM delivery_service WHERE delivery_service_id = '".$_POST['delivery_service_id']."'"));
    		mysql_query("UPDATE item_selling_delivery SET delivery_service_id = '".$_POST['delivery_service_id']."', delivery_service_name = '".$delivery_service['delivery_service_name']."', item_selling_delivery_date = '".$item_selling_delivery_date."', no_resi = '".$_POST['no_resi']."', delivery_cost = '".$_POST['delivery_cost']."' WHERE item_selling_delivery_id = '".$item_selling['item_selling_delivery_id']."'");
    	*/	
			header("location:../dataverse/home.php?connect=item-selling");		
		break;
		

		case "order-item-selling-platform":
			order_item_selling_platform();
		break;

		case "order-item-selling":
			$order_item_selling_id = sequence("order_item_selling", "order_item_selling_id");
			
			$reseller_query = mysql_query("SELECT * FROM reseller WHERE reseller_id = '".$_POST['reseller_id']."'");
			$reseller_fetch_array = mysql_fetch_array($reseller_query);
			
			$reseller_item_sell = mysql_fetch_array(mysql_query("SELECT * FROM reseller_item_sell WHERE reseller_id = '".$reseller_fetch_array['reseller_id']."'"));

			mysql_query("INSERT INTO order_item_selling(order_item_selling_id, item_selling_id, item_id, order_item_selling_quantity, item_price_id, item_price_value, item_commission_id, order_item_selling_create, order_item_selling_update, user_activity_id, order_item_selling_active) VALUES ('".$order_item_selling_id."', '".$_POST['item_selling_id']."', '".$_POST['item_id']."', '".$_POST['order_item_selling_quantity']."', '".$reseller_item_sell['item_price_id']."', '".$_POST['item_price_value']."','".$reseller_item_sell['item_commission_id']."', '".$today."', '".$today."', '".$_SESSION['user_id']."', '1')");
			
			mysql_query("UPDATE item_selling SET item_selling_active = '1' WHERE item_selling_id = '".$_POST['item_selling_id']."'");
			
			header("location:../dataverse/home.php?connect=item-selling&execute=order-item-selling-platform&item_selling_id=".$_POST['item_selling_id']);
		break;

		case "cancel-order-item-selling":
			mysql_query("UPDATE item_selling SET item_selling_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', item_selling_active = '0' WHERE item_selling_id = '".$_GET['item_selling_id']."'");
			
			mysql_query("UPDATE order_item_selling SET order_item_selling_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', order_item_selling_active = '0' WHERE item_selling_id = '".$_GET['item_selling_id']."'");
			
			header("location:../dataverse/home.php?connect=item-selling");
		break;
		
		case "delete-order-item-selling":
			mysql_query("UPDATE order_item_selling SET order_item_selling_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', order_item_selling_active = '0' WHERE order_item_selling_id = '".$_GET['order_item_selling_id']."'");
			
			header("location:../dataverse/home.php?connect=item-selling&execute=order-item-selling-platform&item_selling_id=".$_GET['item_selling_id']);
		break;

		case "edit-item-selling-platform":
			edit_item_selling_platform();
		break;
		
		case "edit-item-selling":
			$item_selling_date = explode("-", $_POST['item_selling_date']);
			$date = $item_selling_date[0];
			$month = $item_selling_date[1];
			$year = $item_selling_date[2];
			$item_selling_date = date("Y-m-d", mktime(0, 0, 0, $month, $date, $year));
			
			if($_POST['reseller_id'] == "")
			{
				$reseller = mysql_fetch_array(mysql_query("SELECT * FROM reseller WHERE user_id = '".$_SESSION['user_id']."'"));
				
				$reseller_id = $reseller['reseller_id'];
			}
			else
			{
				$reseller_id = $_POST['reseller_id'];
			}

			mysql_query("UPDATE item_selling SET item_selling_date = '".$item_selling_date."', reseller_id = '".$reseller_id."', order_via_id = '".$_POST['order_via_id']."' , item_selling_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."' WHERE item_selling_id = '".$_POST['item_selling_id']."'");
			
			header("location:../dataverse/home.php?connect=item-selling&execute=order-item-selling-platform&item_selling_id=".$_POST['item_selling_id']);
		break;
		
		case "delete-item-selling":
			mysql_query("UPDATE item_selling SET item_selling_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', item_selling_active = '0' WHERE item_selling_id = '".$_GET['item_selling_id']."'");

			mysql_query("UPDATE order_item_selling SET order_item_selling_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', order_item_selling_active = '0' WHERE item_selling_id = '".$_GET['item_selling_id']."'");
			
			header("location:../dataverse/home.php?connect=item-selling");
		break;
		
		case "cancel-item-selling-process":
			mysql_query("UPDATE item_selling SET item_selling_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', item_selling_status = 'Belum Diproses' WHERE item_selling_id = '".$_GET['item_selling_id']."'");

			//mysql_query("UPDATE item_selling_delivery SET item_selling_delivery_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', item_selling_delivery_active = '0' WHERE item_selling_id = '".$_GET['item_selling_id']."'");
			
			header("location:../dataverse/home.php?connect=item-selling");
		break;
		
		case "delivery-label-platform":
		    delivery_label_platform();
		break;
	}
?>