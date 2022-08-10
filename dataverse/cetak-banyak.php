<?php
require('../lib/fpdf.php');
require('../config/connection.php');
require('../library/datetime.php');
error_reporting(0);

$no = 1;
$selling_id[] = 3;
foreach($_POST['selling_id'] as $item)
{  
   $selling_id[$no] = $item;
   $no++;          
}

//===============================================================================================================================================


if($no == 2)
{

		$item_selling = mysql_fetch_array(mysql_query("SELECT * FROM item_selling WHERE item_selling_id = '".$selling_id[1]."'"));

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
		$pdf = new FPDF('L','mm','A4');
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
    		$pdf->text(89, 35, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',89,40);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',20,76,3,3);
    		$pdf->text(20,72, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(29, 79, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,82,3,3);
    		$pdf->text(29, 85, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(89, 65, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 70;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 78)
    				{
    					
    					$pdf->text(89, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(89, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}
		else if($reseller_item_sell['id_label'] == 2)
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
    		$pdf->Image('../lib/maps.png',20,44,3,3);
    		$pdf->text(29, 46, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(29, 50, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(29, 55, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,57,3,3);
    		$pdf->text(29, 60, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(92, 10, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',92,12);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',89,38,3,3);
    		$pdf->text(89,35, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(97, 41, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',89,46,3,3);
    		$pdf->text(97, 50, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
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
    		$pdf->text(20, 47, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(20, 52, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(20, 57, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(20, 62, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(20, 10, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',20,13,3,3);
    		$pdf->text(29, 15, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',20,19,3,3);
    		$pdf->text(29, 20, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(29, 25, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(29, 30, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,35,3,3);
    		$pdf->text(29, 38, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(20, 67, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',20,69);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',89,13,3,3);
    		$pdf->text(89,10, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(97, 15, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',89,20,3,3);
    		$pdf->text(97, 23, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(89, 47, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 53;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 53)
    				{
    					
    					$pdf->text(89, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(89, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}
		
		
        		
} 
else if($no == 3)
{


		$item_selling = mysql_fetch_array(mysql_query("SELECT * FROM item_selling WHERE item_selling_id = '".$selling_id[1]."'"));

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
		$pdf = new FPDF('L','mm','A4');
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
    		$pdf->text(89, 35, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',89,40);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',20,76,3,3);
    		$pdf->text(20,72, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(29, 79, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,82,3,3);
    		$pdf->text(29, 85, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(89, 65, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 70;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 78)
    				{
    					
    					$pdf->text(89, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(89, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}
		else if($reseller_item_sell['id_label'] == 2)
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
    		$pdf->Image('../lib/maps.png',20,44,3,3);
    		$pdf->text(29, 46, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(29, 50, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(29, 55, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,57,3,3);
    		$pdf->text(29, 60, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(92, 10, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',92,12);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',89,38,3,3);
    		$pdf->text(89,35, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(97, 41, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',89,46,3,3);
    		$pdf->text(97, 50, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
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
    		$pdf->text(20, 47, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(20, 52, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(20, 57, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(20, 62, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(20, 10, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',20,13,3,3);
    		$pdf->text(29, 15, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',20,19,3,3);
    		$pdf->text(29, 20, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(29, 25, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(29, 30, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,35,3,3);
    		$pdf->text(29, 38, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(20, 67, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',20,69);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',89,13,3,3);
    		$pdf->text(89,10, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(97, 15, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',89,20,3,3);
    		$pdf->text(97, 23, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(89, 47, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 53;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 53)
    				{
    					
    					$pdf->text(89, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(89, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}
		
		
		
		
		$item_selling = mysql_fetch_array(mysql_query("SELECT * FROM item_selling WHERE item_selling_id = '".$selling_id[2]."'"));

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
					
		if($reseller_item_sell['id_label'] == 1)
		{
		    $pdf->Image('../lib/bingkai.png',155,1);
    		$pdf->SetFont('Arial','',12);
    		$pdf->SetMargins(0.5,0.5,0.5,0.5);
    		$pdf->text(165, 10, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(165, 15, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(165, 20, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(165, 25, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(165, 35, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',165,38,3,3);
    		$pdf->text(174, 41, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',165,46,3,3);
    		$pdf->text(174, 49, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(174, 53, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(174, 58, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',165,61,3,3);
    		$pdf->text(174, 64, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(230, 35, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',230,40);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',165,76,3,3);
    		$pdf->text(165,72, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(174, 79, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',165,82,3,3);
    		$pdf->text(174, 85, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(230, 65, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 70;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 78)
    				{
    					
    					$pdf->text(230, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(230, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}
		else if($reseller_item_sell['id_label'] == 2)
		{
		    $pdf->Image('../lib/bingkai.png',155,1);
    		$pdf->SetFont('Arial','',12);
    		$pdf->SetMargins(0.5,0.5,0.5,0.5);
    		$pdf->text(165, 10, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(165, 15, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(165, 20, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(165, 25, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(165, 35, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',165,38,3,3);
    		$pdf->text(174, 41, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',165,44,3,3);
    		$pdf->text(174, 46, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(174, 50, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(174, 55, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',165,57,3,3);
    		$pdf->text(174, 60, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(240, 10, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',240,12);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',240,38,3,3);
    		$pdf->text(240,35, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(250, 41, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',240,45,3,3);
    		$pdf->text(250, 46, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(165, 70, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 75;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 75)
    				{
    					
    					$pdf->text(165, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(165, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}
		else
		{
		    $pdf->Image('../lib/bingkai.png',155,1);
    		$pdf->SetFont('Arial','',12);
    		$pdf->SetMargins(0.5,0.5,0.5,0.5);
    		$pdf->text(165, 45, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(165, 50, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(165, 55, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(165, 60, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(165, 10, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',165,12,3,3);
    		$pdf->text(174, 15, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',165,17,3,3);
    		$pdf->text(174, 20, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(174, 25, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(174, 30, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',165,32,3,3);
    		$pdf->text(174, 35, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(165, 65, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',165,68);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',240,12,3,3);
    		$pdf->text(240,10, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(250, 15, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',240,20,3,3);
    		$pdf->text(250, 25, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(240, 45, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 50;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 50)
    				{
    					
    					$pdf->text(240, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(240, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}
		
		

}
else if($no == 4)
{

        $item_selling = mysql_fetch_array(mysql_query("SELECT * FROM item_selling WHERE item_selling_id = '".$selling_id[1]."'"));

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
		$pdf = new FPDF('L','mm','A4');
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
    		$pdf->text(89, 35, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',89,40);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',20,76,3,3);
    		$pdf->text(20,72, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(29, 79, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,82,3,3);
    		$pdf->text(29, 85, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(89, 65, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 70;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 78)
    				{
    					
    					$pdf->text(89, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(89, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}
		else if($reseller_item_sell['id_label'] == 2)
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
    		$pdf->Image('../lib/maps.png',20,44,3,3);
    		$pdf->text(29, 46, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(29, 50, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(29, 55, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,57,3,3);
    		$pdf->text(29, 60, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(92, 10, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',92,12);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',89,38,3,3);
    		$pdf->text(89,35, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(97, 41, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',89,46,3,3);
    		$pdf->text(97, 50, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
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
    		$pdf->text(20, 47, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(20, 52, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(20, 57, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(20, 62, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(20, 10, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',20,13,3,3);
    		$pdf->text(29, 15, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',20,19,3,3);
    		$pdf->text(29, 20, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(29, 25, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(29, 30, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,35,3,3);
    		$pdf->text(29, 38, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(20, 67, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',20,69);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',89,13,3,3);
    		$pdf->text(89,10, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(97, 15, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',89,20,3,3);
    		$pdf->text(97, 23, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(89, 47, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 53;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 53)
    				{
    					
    					$pdf->text(89, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(89, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}
		
		
		
		
		$item_selling = mysql_fetch_array(mysql_query("SELECT * FROM item_selling WHERE item_selling_id = '".$selling_id[2]."'"));

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
					
		if($reseller_item_sell['id_label'] == 1)
		{
		    $pdf->Image('../lib/bingkai.png',155,1);
    		$pdf->SetFont('Arial','',12);
    		$pdf->SetMargins(0.5,0.5,0.5,0.5);
    		$pdf->text(165, 10, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(165, 15, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(165, 20, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(165, 25, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(165, 35, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',165,38,3,3);
    		$pdf->text(174, 41, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',165,46,3,3);
    		$pdf->text(174, 49, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(174, 53, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(174, 58, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',165,61,3,3);
    		$pdf->text(174, 64, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(230, 35, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',230,40);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',165,76,3,3);
    		$pdf->text(165,72, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(174, 79, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',165,82,3,3);
    		$pdf->text(174, 85, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(230, 65, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 70;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 78)
    				{
    					
    					$pdf->text(230, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(230, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}
		else if($reseller_item_sell['id_label'] == 2)
		{
		    $pdf->Image('../lib/bingkai.png',155,1);
    		$pdf->SetFont('Arial','',12);
    		$pdf->SetMargins(0.5,0.5,0.5,0.5);
    		$pdf->text(165, 10, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(165, 15, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(165, 20, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(165, 25, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(165, 35, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',165,38,3,3);
    		$pdf->text(174, 41, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',165,44,3,3);
    		$pdf->text(174, 46, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(174, 50, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(174, 55, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',165,57,3,3);
    		$pdf->text(174, 60, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(240, 10, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',240,12);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',240,38,3,3);
    		$pdf->text(240,35, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(250, 41, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',240,45,3,3);
    		$pdf->text(250, 46, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(165, 70, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 75;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 75)
    				{
    					
    					$pdf->text(165, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(165, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}
		else
		{
		    $pdf->Image('../lib/bingkai.png',155,1);
    		$pdf->SetFont('Arial','',12);
    		$pdf->SetMargins(0.5,0.5,0.5,0.5);
    		$pdf->text(165, 45, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(165, 50, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(165, 55, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(165, 60, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(165, 10, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',165,12,3,3);
    		$pdf->text(174, 15, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',165,17,3,3);
    		$pdf->text(174, 20, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(174, 25, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(174, 30, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',165,32,3,3);
    		$pdf->text(174, 35, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(165, 65, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',165,68);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',240,12,3,3);
    		$pdf->text(240,10, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(250, 15, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',240,20,3,3);
    		$pdf->text(250, 25, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(240, 45, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 50;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 50)
    				{
    					
    					$pdf->text(240, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(240, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}
		
		
		
		$item_selling = mysql_fetch_array(mysql_query("SELECT * FROM item_selling WHERE item_selling_id = '".$selling_id[3]."'"));

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
		
		if($reseller_item_sell['id_label'] == 1)
		{
		    $pdf->Image('../lib/bingkai.png',10,100);
    		$pdf->SetFont('Arial','',12);
    		$pdf->SetMargins(0.5,0.5,0.5,0.5);
    		$pdf->text(20, 110, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(20, 115, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(20, 120, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(20, 125, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(20, 135, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',20,138,3,3);
    		$pdf->text(29, 141, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',20,146,3,3);
    		$pdf->text(29, 149, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(29, 153, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(29, 158, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,161,3,3);
    		$pdf->text(29, 164, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(89, 135, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',89,140);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',20,176,3,3);
    		$pdf->text(20,172, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(29, 179, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,182,3,3);
    		$pdf->text(29, 185, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(89, 165, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 170;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 178)
    				{
    					
    					$pdf->text(89, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(89, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}
		else if($reseller_item_sell['id_label'] == 2)
		{
		    $pdf->Image('../lib/bingkai.png',10,100);
    		$pdf->SetFont('Arial','',12);
    		$pdf->SetMargins(0.5,0.5,0.5,0.5);
    		$pdf->text(20, 110, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(20, 115, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(20, 120, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(20, 125, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(20, 135, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',20,138,3,3);
    		$pdf->text(29, 141, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',20,145,3,3);
    		$pdf->text(29, 147, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(29, 152, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(29, 157, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,158,3,3);
    		$pdf->text(29, 162, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(92, 110, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',92,112);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',89,138,3,3);
    		$pdf->text(89,135, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(97, 141, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',89,145,3,3);
    		$pdf->text(97, 150, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(20, 168, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 173;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 173)
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
		    $pdf->Image('../lib/bingkai.png',10,100);
    		$pdf->SetFont('Arial','',12);
    		$pdf->SetMargins(0.5,0.5,0.5,0.5);
    		$pdf->text(20, 145, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(20, 150, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(20, 155, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(20, 160, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(20, 110, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',20,112,3,3);
    		$pdf->text(29, 115, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',20,120,3,3);
    		$pdf->text(29, 120, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(29, 125, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(29, 130, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,133,3,3);
    		$pdf->text(29, 135, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(20, 165, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',20,168);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',89,112,3,3);
    		$pdf->text(89,110, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(97, 115, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',89,120,3,3);
    		$pdf->text(97, 123, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(92, 145, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 150;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 150)
    				{
    					
    					$pdf->text(92, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(92, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}   
		}
		
		

}
else if($no == 5)
{
		$item_selling = mysql_fetch_array(mysql_query("SELECT * FROM item_selling WHERE item_selling_id = '".$selling_id[1]."'"));

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
		$pdf = new FPDF('L','mm','A4');
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
    		$pdf->text(89, 35, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',89,40);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',20,76,3,3);
    		$pdf->text(20,72, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(29, 79, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,82,3,3);
    		$pdf->text(29, 85, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(89, 65, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 70;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 78)
    				{
    					
    					$pdf->text(89, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(89, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}
		else if($reseller_item_sell['id_label'] == 2)
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
    		$pdf->Image('../lib/maps.png',20,44,3,3);
    		$pdf->text(29, 46, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(29, 50, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(29, 55, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,57,3,3);
    		$pdf->text(29, 60, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(92, 10, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',92,12);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',89,38,3,3);
    		$pdf->text(89,35, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(97, 41, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',89,46,3,3);
    		$pdf->text(97, 50, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
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
    		$pdf->text(20, 47, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(20, 52, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(20, 57, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(20, 62, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(20, 10, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',20,13,3,3);
    		$pdf->text(29, 15, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',20,19,3,3);
    		$pdf->text(29, 20, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(29, 25, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(29, 30, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,35,3,3);
    		$pdf->text(29, 38, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(20, 67, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',20,69);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',89,13,3,3);
    		$pdf->text(89,10, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(97, 15, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',89,20,3,3);
    		$pdf->text(97, 23, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(89, 47, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 53;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 53)
    				{
    					
    					$pdf->text(89, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(89, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}
		
		
		
		
		$item_selling = mysql_fetch_array(mysql_query("SELECT * FROM item_selling WHERE item_selling_id = '".$selling_id[2]."'"));

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
					
		if($reseller_item_sell['id_label'] == 1)
		{
		    $pdf->Image('../lib/bingkai.png',155,1);
    		$pdf->SetFont('Arial','',12);
    		$pdf->SetMargins(0.5,0.5,0.5,0.5);
    		$pdf->text(165, 10, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(165, 15, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(165, 20, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(165, 25, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(165, 35, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',165,38,3,3);
    		$pdf->text(174, 41, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',165,46,3,3);
    		$pdf->text(174, 49, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(174, 53, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(174, 58, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',165,61,3,3);
    		$pdf->text(174, 64, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(230, 35, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',230,40);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',165,76,3,3);
    		$pdf->text(165,72, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(174, 79, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',165,82,3,3);
    		$pdf->text(174, 85, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(230, 65, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 70;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 78)
    				{
    					
    					$pdf->text(230, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(230, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}
		else if($reseller_item_sell['id_label'] == 2)
		{
		    $pdf->Image('../lib/bingkai.png',155,1);
    		$pdf->SetFont('Arial','',12);
    		$pdf->SetMargins(0.5,0.5,0.5,0.5);
    		$pdf->text(165, 10, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(165, 15, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(165, 20, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(165, 25, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(165, 35, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',165,38,3,3);
    		$pdf->text(174, 41, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',165,44,3,3);
    		$pdf->text(174, 46, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(174, 50, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(174, 55, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',165,57,3,3);
    		$pdf->text(174, 60, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(240, 10, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',240,12);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',240,38,3,3);
    		$pdf->text(240,35, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(250, 41, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',240,45,3,3);
    		$pdf->text(250, 46, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(165, 70, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 75;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 75)
    				{
    					
    					$pdf->text(165, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(165, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}
		else
		{
		    $pdf->Image('../lib/bingkai.png',155,1);
    		$pdf->SetFont('Arial','',12);
    		$pdf->SetMargins(0.5,0.5,0.5,0.5);
    		$pdf->text(165, 45, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(165, 50, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(165, 55, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(165, 60, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(165, 10, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',165,12,3,3);
    		$pdf->text(174, 15, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',165,17,3,3);
    		$pdf->text(174, 20, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(174, 25, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(174, 30, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',165,32,3,3);
    		$pdf->text(174, 35, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(165, 65, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',165,68);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',240,12,3,3);
    		$pdf->text(240,10, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(250, 15, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',240,20,3,3);
    		$pdf->text(250, 25, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(240, 45, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 50;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 50)
    				{
    					
    					$pdf->text(240, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(240, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}
		
		
		
		$item_selling = mysql_fetch_array(mysql_query("SELECT * FROM item_selling WHERE item_selling_id = '".$selling_id[3]."'"));

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
		
		if($reseller_item_sell['id_label'] == 1)
		{
		    $pdf->Image('../lib/bingkai.png',10,100);
    		$pdf->SetFont('Arial','',12);
    		$pdf->SetMargins(0.5,0.5,0.5,0.5);
    		$pdf->text(20, 110, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(20, 115, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(20, 120, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(20, 125, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(20, 135, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',20,138,3,3);
    		$pdf->text(29, 141, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',20,146,3,3);
    		$pdf->text(29, 149, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(29, 153, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(29, 158, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,161,3,3);
    		$pdf->text(29, 164, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(89, 135, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',89,140);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',20,176,3,3);
    		$pdf->text(20,172, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(29, 179, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,182,3,3);
    		$pdf->text(29, 185, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(89, 165, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 170;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 178)
    				{
    					
    					$pdf->text(89, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(89, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}
		else if($reseller_item_sell['id_label'] == 2)
		{
		    $pdf->Image('../lib/bingkai.png',10,100);
    		$pdf->SetFont('Arial','',12);
    		$pdf->SetMargins(0.5,0.5,0.5,0.5);
    		$pdf->text(20, 110, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(20, 115, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(20, 120, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(20, 125, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(20, 135, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',20,138,3,3);
    		$pdf->text(29, 141, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',20,145,3,3);
    		$pdf->text(29, 147, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(29, 152, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(29, 157, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,158,3,3);
    		$pdf->text(29, 162, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(92, 110, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',92,112);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',89,138,3,3);
    		$pdf->text(89,135, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(97, 141, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',89,145,3,3);
    		$pdf->text(97, 150, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(20, 168, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 173;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 173)
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
		    $pdf->Image('../lib/bingkai.png',10,100);
    		$pdf->SetFont('Arial','',12);
    		$pdf->SetMargins(0.5,0.5,0.5,0.5);
    		$pdf->text(20, 145, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(20, 150, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(20, 155, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(20, 160, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(20, 110, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',20,112,3,3);
    		$pdf->text(29, 115, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',20,120,3,3);
    		$pdf->text(29, 120, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(29, 125, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(29, 130, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',20,133,3,3);
    		$pdf->text(29, 135, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(20, 165, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',20,168);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',89,112,3,3);
    		$pdf->text(89,110, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(97, 115, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',89,120,3,3);
    		$pdf->text(97, 123, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(92, 145, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 150;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 150)
    				{
    					
    					$pdf->text(92, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(92, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}   
		}
		
		
		$item_selling = mysql_fetch_array(mysql_query("SELECT * FROM item_selling WHERE item_selling_id = '".$selling_id[4]."'"));

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
					
					
		if($reseller_item_sell['id_label'] == 1)
		{
		    $pdf->Image('../lib/bingkai.png',155,100);
    		$pdf->SetFont('Arial','',12);
    		$pdf->SetMargins(0.5,0.5,0.5,0.5);
    		$pdf->text(165, 110, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(165, 115, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(165, 120, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(165, 125, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(165, 135, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',165,138,3,3);
    		$pdf->text(174, 141, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',165,146,3,3);
    		$pdf->text(174, 149, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(174, 153, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(174, 158, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',165,161,3,3);
    		$pdf->text(174, 164, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(230, 135, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',230,140);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',165,176,3,3);
    		$pdf->text(165,172, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(174, 179, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',165,182,3,3);
    		$pdf->text(174, 185, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(230, 165, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 170;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 178)
    				{
    					
    					$pdf->text(230, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(230, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}
		else if($reseller_item_sell['id_label'] == 2)
		{
		    $pdf->Image('../lib/bingkai.png',155,100);
    		$pdf->SetFont('Arial','',12);
    		$pdf->SetMargins(0.5,0.5,0.5,0.5);
    		$pdf->text(165, 110, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(165, 115, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(165, 120, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(165, 125, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(165, 135, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',165,138,3,3);
    		$pdf->text(174, 141, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',165,144,3,3);
    		$pdf->text(174, 147, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(174, 153, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(174, 158, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',165,161,3,3);
    		$pdf->text(174, 164, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(240, 110, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',240,112);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',240,138,3,3);
    		$pdf->text(240,135, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(247, 142, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',240,145,3,3);
    		$pdf->text(247, 148, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(165, 170, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 175;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 175)
    				{
    					
    					$pdf->text(165, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(165, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}
		else
		{
		    $pdf->Image('../lib/bingkai.png',155,100);
    		$pdf->SetFont('Arial','',12);
    		$pdf->SetMargins(0.5,0.5,0.5,0.5);
    		$pdf->text(165, 145, 'No : '.$item_selling['item_selling_code'], 0, 0, 'L');
    		$pdf->text(165, 150, 'Pejualan dari : '.$order_via['order_via_name'], 0, 0, 'L');
    		$pdf->text(165, 155, 'Pengiriman : '.$item_selling_delivery['delivery_service_name'], 0, 0, 'L');
    		$pdf->text(165, 160, 'Tanggal kirim : '.indonesia_date_format($item_selling_delivery['item_selling_delivery_date']), 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(165, 110, 'Penerima', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->Image('../lib/person.png',165,112,3,3);
    		$pdf->text(174, 115, ''.$item_selling['customer_name'], 0, 0, 'L');
    		$pdf->Image('../lib/maps.png',165,118,3,3);
    		$pdf->text(174, 120, ''.$item_selling['customer_address'], 0, 0, 'L');
    		$pdf->text(174, 125, ''.$item_selling['customer_village'].'-'.$item_selling['customer_districts'], 0, 0, 'L');
    		$pdf->text(174, 130, ''.$item_selling['customer_city'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',165,133,3,3);
    		$pdf->text(174, 135, ''.$item_selling['customer_phone'], 0, 0, 'L');
    		 
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(165, 165, 'No JOB : '.$item_selling_delivery['no_resi'], 0, 0, 'L');
    		$pdf->Image('img-barcode/'.$item_selling_delivery['no_resi'].'.png',165,168);
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->Image('../lib/person.png',240,112,3,3);
    		$pdf->text(240,110, 'Pengirim', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    		$pdf->text(247, 115, ''.$item_selling['reseller_name'], 0, 0, 'L');
    		$pdf->Image('../lib/phone.png',240,118,3,3);
    		$pdf->text(247, 120, ''.$item_selling['reseller_phone'], 0, 0, 'L');
    
    		$pdf->SetFont('Arial','B',12);
    		$pdf->text(240, 145, 'Item', 0, 0, 'L');
    		$pdf->SetFont('Arial','',12);
    
    			$space = 150;
    			$order_item_selling = mysql_query("select * from order_item_selling a, item b WHERE a.item_id = b.item_id AND a.item_selling_id = '".$item_selling['item_selling_id']."' AND a.order_item_selling_active = '1'");
    			while($data_order_item_selling = mysql_fetch_array($order_item_selling))
    			{
    				if($space == 150)
    				{
    					
    					$pdf->text(240, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    				
    				}
    				else
    				{
    					$pdf->text(240, ''.$space, ''.$data_order_item_selling['order_item_selling_quantity'].' x '.$data_order_item_selling['item_name'], 0, 0, 'L');
    
    				}
    
    				$space = 5+$space;
    			}
		}

}

$pdf->Output();

?>