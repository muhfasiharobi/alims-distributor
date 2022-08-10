<?php
require('../lib/fpdf.php');
require('../config/connection.php');
require('../library/datetime.php');
error_reporting(0);


		$item_selling = mysql_fetch_array(mysql_query("SELECT * FROM item_selling WHERE item_selling_id = '".$_GET['item_selling_id']."'"));
		
		$reseller_item_sell = mysql_fetch_array(mysql_query("SELECT * FROM reseller_item_sell a, item b, item_category c WHERE a.reseller_id = '".$item_selling['reseller_id']."' AND a.item_id = b.item_id AND b.item_category_id = c.item_category_id"));

		$item_selling_delivery = mysql_fetch_array(mysql_query("SELECT * FROM item_selling_delivery a, delivery_service b WHERE a.delivery_service_id = b.delivery_service_id AND a.item_selling_id = '".$item_selling['item_selling_id']."'"));

		$order_via = mysql_fetch_array(mysql_query("SELECT * FROM order_via WHERE order_via_id = '".$item_selling['order_via_id']."'"));

			//buat folder untuk simpan file image
					$tempdir	="img-barcode/";
					if (!file_exists($tempdir))
					mkdir($tempdir, 0755);
				   
					$target_path	=$tempdir . $item_selling_delivery['no_resi'] . ".png";
				   
					//cek apakah server menggunakan http atau https
					$protocol	=stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';
				   
					//url file image barcode 
					$fileImage	=$protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/php-barcode/barcode.php?text=" . $item_selling_delivery['no_resi'] . "&codetype=code128&print=true&size=55";
				   
					//ambil gambar barcode dari url diatas
					$content	=file_get_contents($fileImage);
				   
					//simpan gambar ke folder
					file_put_contents($target_path, $content);


		//$pdf = new FPDF('L','mm',array(105,148));
		$pdf = new FPDF('P','mm','A4');
		$pdf->AddPage();
		
		if($reseller_item_sell['id_label'] == 1)
		{
		    $pdf->Image('../lib/bingkai.png',10,1);
    		$pdf->SetFont('Arial','',12);
    		$pdf->SetMargins(0.5,0.5,0.5,0.5);
    		$pdf->text(20, 10, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(20, 15, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(20, 20, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(20, 25, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(20, 35, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',20,38,3,3);
    		$pdf->text(29, 41, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',20,46,3,3);
    		$pdf->text(29, 49, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(29, 53, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(29, 58, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,61,3,3);
    		$pdf->text(29, 64, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(99, 35, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',99,40);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',20,76,3,3);
    		$pdf->text(20,72, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(29, 79, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,82,3,3);
    		$pdf->text(29, 85, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(99, 65, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 70;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 78)
    				{
    					
    					$pdf->text(99, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(99, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		} 
		else if($reseller_item_sell['id_label'] == 2)
		{
		    $pdf = new FPDF('P','mm','A4');
    		$pdf->AddPage();
    		$pdf->Image('../lib/bingkai.png',10,1);
    		$pdf->SetFont('Arial','',12);
    		$pdf->SetMargins(0.5,0.5,0.5,0.5);
    		$pdf->text(20, 10, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(20, 15, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(20, 20, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(20, 25, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(20, 35, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',20,38,3,3);
    		$pdf->text(29, 41, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',20,43,3,3);
    		$pdf->text(29, 46, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(29, 50, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(29, 54, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,57,3,3);
    		$pdf->text(29, 60, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(92, 10, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',92,11);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(90,37, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',90,40,3,3);
    		$pdf->text(98, 43, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',90,45,3,3);
    		$pdf->text(98, 48, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(20, 68, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 73;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 73)
    				{
    					
    					$pdf->text(20, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(20, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}
		else
		{
		    $pdf->Image('../lib/bingkai.png',10,1);
        		$pdf->SetFont('Arial','',12);
        		$pdf->SetMargins(0.5,0.5,0.5,0.5);
        		$pdf->text(20, 45, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
        		$pdf->text(20, 50, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
        		$pdf->text(20, 55, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
        		$pdf->text(20, 60, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
        
        		$pdf->SetFont('Arial','B',12);
        		$pdf->text(20, 10, 'Penerima', 0, 0, 'L');
        		$pdf->SetFont('Arial','',12);
        		$pdf->Image('../lib/person.png',20,13,3,3);
        		$pdf->text(29, 16, ''.$item_selling['customer_name'], 0, 0, 'L');
        		$pdf->Image('../lib/maps.png',20,19,3,3);
        		$pdf->text(29, 21, ''.$item_selling['customer_address'], 0, 0, 'L');
        		$pdf->text(29, 25, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
        		$pdf->text(29, 29, ''.$item_selling['customer_city'], 0, 0, 'L');
        		$pdf->Image('../lib/phone.png',20,32,3,3);
        		$pdf->text(29, 35, ''.$item_selling['customer_phone'], 0, 0, 'L');
        		 
        
        		$pdf->SetFont('Arial','B',12);
        		$pdf->text(90,10, 'Pengirim', 0, 0, 'L');
        		$pdf->SetFont('Arial','',12);
        		$pdf->Image('../lib/person.png',90,13,3,3);
        		$pdf->text(98, 16, ''.$item_selling['reseller_name'], 0, 0, 'L');
        		$pdf->Image('../lib/phone.png',90,19,3,3);
        		$pdf->text(98, 21, ''.$item_selling['reseller_phone'], 0, 0, 'L');
        		
        		$pdf->SetFont('Arial','B',12);
        		$pdf->text(20, 65, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
        		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',20,68);
        
        		$pdf->SetFont('Arial','B',12);
        		$pdf->text(90, 40, 'Item', 0, 0, 'L');
        		$pdf->SetFont('Arial','',12);
        
        			$space = 45;
        			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
        			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
        			{
        				if($space == 45)
        				{
        					
        					$pdf->text(90, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
        				
        				}
        				else
        				{
        					$pdf->text(90, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
        
        				}
        
        				$space = 5+$space;
        			}
		}
        		




$pdf->Output();



?>