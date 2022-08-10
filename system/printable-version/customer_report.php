<?php
	error_reporting(0);
	ob_start();
	session_start();
	
	include "../../conn.php";
	include "../../library/datetime.php";
	include "../../library/number.php";
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<html>
<head>
<meta charset="utf-8"/>
<title>Alimms | Art of Business Process Management</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<style type="text/css">
	#header-table
	{
		font: 15px Verdana, Arial, Sans-Serif;
		color: #666;
		width: 100%;
	}
	
	#content-table
	{
		border-collapse: collapse;
		font: 12px Verdana, Arial, Sans-Serif;
		color: #666;
		width: 100%;
	}
	
	#content-table th
	{
		background: #418AA4;
		color: #fff;
		font-weight: bold;
	}
	
	#content-table tr
	{
		background: #fafafa;
	}
	  
	#content-table th, #content-table td
	{
		vertical-align: middle;
		padding: 5px 10px;
		border: 1px solid #fff;
	}
	  
	#content-table tr:nth-child(even)
	{
		background: #f5f5f5;
	}
</style>
<link rel="shortcut icon" href="../../favicon.ico"/>
</head>
<body onload="window.print(); history.back();">
<?php
	$tgl_sekarang = date("Y-m-d");
	$tgl_sekarang_indo = tanggal_indo($tgl_sekarang);
	
	if ($_GET['tib'] == "form-print-by-customer-city-customer-report")
	{
		if ($_GET['customer_city_id'] == '0')
		{
?>
			<table id="header-table">
				<tbody>
					<tr>
						<td style="width: 50%;" rowspan="4"><img src="../../assets/admin/pages/media/invoice/walmart3.png"/></td>
					</tr>
					<tr>
						<td style="text-align: right;">LAPORAN PELANGGAN</td>
					</tr>
					<tr>
						<td style="text-align: right;">BY KOTA/ KABUPATEN</td>
					</tr>
					<tr>
						<td style="font-size: 11px; text-align: right;">Periode <?php echo $tgl_sekarang_indo ?></td>
					</tr>
				</tbody>
			</table>
			<br />
			<table id="content-table">
				<thead>
					<tr>
						<th>
							No
						</th>
						<th>
							Kota/ Kabupaten
						</th>
						<th>
							Kecamatan
						</th>
						<th>
							Kategori
						</th>
						<th>
							Kelas
						</th>
						<th>
							Jenis
						</th>
						<th>
							Kode
						</th>
						<th>
							Nama
						</th>
						<th>
							Alamat
						</th>
						<th>
							Batasan Harga
						</th>
					</tr>
				</thead>
				<tbody>
			<?php
				$no = 1;
				$tbl_customer = mysql_query("SELECT a.customer_id, a.customer_code, a.customer_name, a.customer_address, b.customer_category_name, c.customer_class_name, c.customer_class_price_limit, d.customer_type_name, e.customer_districts_name, f.customer_city_name FROM customer a, customer_category b, customer_class c, customer_type d, customer_districts e, customer_city f WHERE a.customer_active = '1' AND b.customer_category_active = '1' AND c.customer_class_active = '1' AND d.customer_type_active = '1' AND e.customer_districts_active = '1' AND f.customer_city_active = '1' AND a.customer_category_id = b.customer_category_id AND a.customer_class_id = c.customer_class_id AND a.customer_type_id = d.customer_type_id AND a.customer_districts_id = e.customer_districts_id AND e.customer_city_id = f.customer_city_id ORDER BY e.customer_districts_name, f.customer_city_name, b.customer_category_name, d.customer_type_name, a.customer_code");
				while ($data_tbl_customer = mysql_fetch_array($tbl_customer))
				{
					$customer_class_price_limit = format_angka($data_tbl_customer['customer_class_price_limit']);
			?>
					<tr>
						<td style="width: 3%; text-align: center;">
							<?php echo $no ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_city_name'] ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_districts_name'] ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_category_name'] ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_class_name'] ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_type_name'] ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_code'] ?>
						</td>
						<td style="text-align: left;">
							<?php echo $data_tbl_customer['customer_name'] ?>
						</td>
						<td style="text-align: left;">
							<?php echo $data_tbl_customer['customer_address'] ?>
						</td>
						<td style="text-align: right;">
							<?php echo $customer_class_price_limit ?>
						</td>
					</tr>
			<?php
				$no++;
				}
			?>
				</tbody>
			</table>
			<br />
			<table id="content-table">
				<thead>
					<tr>
				<?php
					$tbl_customer_category = mysql_query("SELECT b.customer_category_name FROM customer a, customer_category b WHERE a.customer_active = '1' AND b.customer_category_active = '1' AND a.customer_category_id = b.customer_category_id GROUP BY b.customer_category_id");
					while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
					{
				?>
						<th colspan="3">
							<?php echo $data_tbl_customer_category['customer_category_name'] ?>
						</th>
				<?php
					}
				?>
					</tr>
					<tr>
			<?php
				$tbl_customer_category = mysql_query("SELECT b.customer_category_name FROM customer a, customer_category b WHERE a.customer_active = '1' AND b.customer_category_active = '1' AND a.customer_category_id = b.customer_category_id GROUP BY b.customer_category_id");
				while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
				{
					$tbl_customer_type = mysql_query("SELECT b.customer_type_name FROM customer a, customer_type b WHERE a.customer_active = '1' AND b.customer_type_active = '1' AND a.customer_type_id = b.customer_type_id GROUP BY b.customer_type_id");
					while($data_tbl_customer_type = mysql_fetch_array($tbl_customer_type))
					{
			?>
						<th>
							<?php echo $data_tbl_customer_type['customer_type_name'] ?>
						</th>
			<?php
					}
				}
			?>
					</tr>
				</thead>
				<tbody>
					<tr>
			<?php
				$tbl_customer_category = mysql_query("SELECT b.customer_category_id FROM customer a, customer_category b WHERE a.customer_active = '1' AND b.customer_category_active = '1' AND a.customer_category_id = b.customer_category_id GROUP BY b.customer_category_id");
				while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
				{
					
					$tbl_customer_type = mysql_query("SELECT b.customer_type_id FROM customer a, customer_type b WHERE a.customer_active = '1' AND b.customer_type_active = '1' AND a.customer_type_id = b.customer_type_id GROUP BY b.customer_type_id");
					while($data_tbl_customer_type = mysql_fetch_array($tbl_customer_type))
					{
						$tbl_customer = mysql_query("SELECT COUNT(customer_id) AS total_quantity FROM customer WHERE customer_active = '1' AND customer_category_id = '".$data_tbl_customer_category['customer_category_id']."' AND customer_type_id = '".$data_tbl_customer_type['customer_type_id']."'");
						$data_tbl_customer = mysql_fetch_array($tbl_customer);
			?>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['total_quantity'] ?>
						</td>
			<?php
					}
				}
			?>
					</tr>
				</tbody>
			</table>
<?php
		}
		else
		{
?>
			<table id="header-table">
				<tbody>
					<tr>
						<td style="width: 50%;" rowspan="4"><img src="../../assets/admin/pages/media/invoice/walmart3.png"/></td>
					</tr>
					<tr>
						<td style="text-align: right;">LAPORAN PELANGGAN</td>
					</tr>
					<tr>
						<td style="text-align: right;">BY KOTA/ KABUPATEN</td>
					</tr>
					<tr>
						<td style="font-size: 11px; text-align: right;">Periode <?php echo $tgl_sekarang_indo ?></td>
					</tr>
				</tbody>
			</table>
			<br />
			<table id="content-table">
				<thead>
					<tr>
						<th>
							No
						</th>
						<th>
							Kota/ Kabupaten
						</th>
						<th>
							Kecamatan
						</th>
						<th>
							Kategori
						</th>
						<th>
							Kelas
						</th>
						<th>
							Jenis
						</th>
						<th>
							Kode
						</th>
						<th>
							Nama
						</th>
						<th>
							Alamat
						</th>
						<th>
							Batasan Harga
						</th>
					</tr>
				</thead>
				<tbody>
			<?php
				$no = 1;
				$tbl_customer = mysql_query("SELECT a.customer_id, a.customer_code, a.customer_name, a.customer_address, b.customer_category_name, c.customer_class_name, c.customer_class_price_limit, d.customer_type_name, e.customer_districts_name, f.customer_city_name FROM customer a, customer_category b, customer_class c, customer_type d, customer_districts e, customer_city f WHERE a.customer_active = '1' AND b.customer_category_active = '1' AND c.customer_class_active = '1' AND d.customer_type_active = '1' AND e.customer_districts_active = '1' AND f.customer_city_active = '1' AND e.customer_city_id = '".$_GET['customer_city_id']."' AND a.customer_category_id = b.customer_category_id AND a.customer_class_id = c.customer_class_id AND a.customer_type_id = d.customer_type_id AND a.customer_districts_id = e.customer_districts_id AND e.customer_city_id = f.customer_city_id ORDER BY e.customer_districts_name, f.customer_city_name, b.customer_category_name, d.customer_type_name, a.customer_code");
				while ($data_tbl_customer = mysql_fetch_array($tbl_customer))
				{
					$customer_class_price_limit = format_angka($data_tbl_customer['customer_class_price_limit']);
			?>
					<tr>
						<td style="width: 3%; text-align: center;">
							<?php echo $no ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_city_name'] ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_districts_name'] ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_category_name'] ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_class_name'] ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_type_name'] ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_code'] ?>
						</td>
						<td style="text-align: left;">
							<?php echo $data_tbl_customer['customer_name'] ?>
						</td>
						<td style="text-align: left;">
							<?php echo $data_tbl_customer['customer_address'] ?>
						</td>
						<td style="text-align: right;">
							<?php echo $customer_class_price_limit ?>
						</td>
					</tr>
			<?php
				$no++;
				}
			?>
				</tbody>
			</table>
			<br />
			<table id="content-table">
				<thead>
					<tr>
				<?php
					$tbl_customer_category = mysql_query("SELECT b.customer_category_name FROM customer a, customer_category b, customer_districts c WHERE a.customer_active = '1' AND b.customer_category_active = '1' AND c.customer_districts_active = '1' AND c.customer_city_id = '".$_GET['customer_city_id']."' AND a.customer_category_id = b.customer_category_id AND a.customer_districts_id = c.customer_districts_id GROUP BY b.customer_category_id");
					$jumlah_tbl_customer_category = mysql_num_rows($tbl_customer_category);
					while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
					{
				?>
						<th colspan="<?php echo $jumlah_tbl_customer_category ?>">
							<?php echo $data_tbl_customer_category['customer_category_name'] ?>
						</th>
				<?php
					}
				?>
					</tr>
					<tr>
			<?php
				$tbl_customer_category = mysql_query("SELECT b.customer_category_name FROM customer a, customer_category b, customer_districts c WHERE a.customer_active = '1' AND b.customer_category_active = '1' AND c.customer_districts_active = '1' AND c.customer_city_id = '".$_GET['customer_city_id']."' AND a.customer_category_id = b.customer_category_id AND a.customer_districts_id = c.customer_districts_id GROUP BY b.customer_category_id");
					while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
				{
					$tbl_customer_type = mysql_query("SELECT b.customer_type_name FROM customer a, customer_type b, customer_districts c WHERE a.customer_active = '1' AND b.customer_type_active = '1' AND c.customer_districts_active = '1' AND c.customer_city_id = '".$_GET['customer_city_id']."' AND a.customer_type_id = b.customer_type_id AND a.customer_districts_id = c.customer_districts_id GROUP BY b.customer_type_id");
					while($data_tbl_customer_type = mysql_fetch_array($tbl_customer_type))
					{
			?>
						<th>
							<?php echo $data_tbl_customer_type['customer_type_name'] ?>
						</th>
			<?php
					}
				}
			?>
					</tr>
				</thead>
				<tbody>
					<tr>
			<?php
				$tbl_customer_category = mysql_query("SELECT b.customer_category_id FROM customer a, customer_category b, customer_districts c WHERE a.customer_active = '1' AND b.customer_category_active = '1' AND c.customer_districts_active = '1' AND c.customer_city_id = '".$_GET['customer_city_id']."' AND a.customer_category_id = b.customer_category_id AND a.customer_districts_id = c.customer_districts_id GROUP BY b.customer_category_id");
				while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
				{
					
					$tbl_customer_type = mysql_query("SELECT b.customer_type_id FROM customer a, customer_type b, customer_districts c WHERE a.customer_active = '1' AND b.customer_type_active = '1' AND c.customer_districts_active = '1' AND c.customer_city_id = '".$_GET['customer_city_id']."' AND a.customer_type_id = b.customer_type_id AND a.customer_districts_id = c.customer_districts_id GROUP BY b.customer_type_id");
					while($data_tbl_customer_type = mysql_fetch_array($tbl_customer_type))
					{
						$tbl_customer = mysql_query("SELECT COUNT(a.customer_id) AS total_quantity FROM customer a, customer_districts b WHERE a.customer_active = '1' AND b.customer_districts_active = '1' AND b.customer_city_id = '".$_GET['customer_city_id']."' AND a.customer_category_id = '".$data_tbl_customer_category['customer_category_id']."' AND a.customer_type_id = '".$data_tbl_customer_type['customer_type_id']."' AND a.customer_districts_id = b.customer_districts_id");
						$data_tbl_customer = mysql_fetch_array($tbl_customer);
			?>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['total_quantity'] ?>
						</td>
			<?php
					}
				}
			?>
					</tr>
				</tbody>
			</table>
<?php
		}
	}
	elseif ($_GET['tib'] == "form-print-by-customer-districts-customer-report")
	{
		if ($_GET['customer_districts_id'] == '0')
		{
?>
			<table id="header-table">
				<tbody>
					<tr>
						<td style="width: 50%;" rowspan="4"><img src="../../assets/admin/pages/media/invoice/walmart3.png"/></td>
					</tr>
					<tr>
						<td style="text-align: right;">LAPORAN PELANGGAN</td>
					</tr>
					<tr>
						<td style="text-align: right;">BY KECAMATAN</td>
					</tr>
					<tr>
						<td style="font-size: 11px; text-align: right;">Periode <?php echo $tgl_sekarang_indo ?></td>
					</tr>
				</tbody>
			</table>
			<br />
			<table id="content-table">
				<thead>
					<tr>
						<th>
							No
						</th>
						<th>
							Kota/ Kabupaten
						</th>
						<th>
							Kecamatan
						</th>
						<th>
							Kategori
						</th>
						<th>
							Kelas
						</th>
						<th>
							Jenis
						</th>
						<th>
							Kode
						</th>
						<th>
							Nama
						</th>
						<th>
							Alamat
						</th>
						<th>
							Batasan Harga
						</th>
					</tr>
				</thead>
				<tbody>
			<?php
				$no = 1;
				$tbl_customer = mysql_query("SELECT a.customer_id, a.customer_code, a.customer_name, a.customer_address, b.customer_category_name, c.customer_class_name, c.customer_class_price_limit, d.customer_type_name, e.customer_districts_name, f.customer_city_name FROM customer a, customer_category b, customer_class c, customer_type d, customer_districts e, customer_city f WHERE a.customer_active = '1' AND b.customer_category_active = '1' AND c.customer_class_active = '1' AND d.customer_type_active = '1' AND e.customer_districts_active = '1' AND f.customer_city_active = '1' AND a.customer_category_id = b.customer_category_id AND a.customer_class_id = c.customer_class_id AND a.customer_type_id = d.customer_type_id AND a.customer_districts_id = e.customer_districts_id AND e.customer_city_id = f.customer_city_id ORDER BY e.customer_districts_name, f.customer_city_name, b.customer_category_name, d.customer_type_name, a.customer_code");
				while ($data_tbl_customer = mysql_fetch_array($tbl_customer))
				{
					$customer_class_price_limit = format_angka($data_tbl_customer['customer_class_price_limit']);
			?>
					<tr>
						<td style="width: 3%; text-align: right;">
							<?php echo $no ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_city_name'] ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_districts_name'] ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_category_name'] ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_class_name'] ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_type_name'] ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_code'] ?>
						</td>
						<td style="text-align: left;">
							<?php echo $data_tbl_customer['customer_name'] ?>
						</td>
						<td style="text-align: left;">
							<?php echo $data_tbl_customer['customer_address'] ?>
						</td>
						<td style="text-align: right;">
							<?php echo $customer_class_price_limit ?>
						</td>
					</tr>
			<?php
				$no++;
				}
			?>
				</tbody>
			</table>
			<br />
			<table id="content-table">
				<thead>
					<tr>
				<?php
					$tbl_customer_category = mysql_query("SELECT b.customer_category_name FROM customer a, customer_category b WHERE a.customer_active = '1' AND b.customer_category_active = '1' AND a.customer_category_id = b.customer_category_id GROUP BY b.customer_category_id");
					$jumlah_tbl_customer_category = mysql_num_rows($tbl_customer_category);
					while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
					{
				?>
						<th colspan="<?php echo $jumlah_tbl_customer_category ?>">
							<?php echo $data_tbl_customer_category['customer_category_name'] ?>
						</th>
				<?php
					}
				?>
					</tr>
			<?php
				$tbl_customer_category = mysql_query("SELECT b.customer_category_name FROM customer a, customer_category b WHERE a.customer_active = '1' AND b.customer_category_active = '1' AND a.customer_category_id = b.customer_category_id GROUP BY b.customer_category_id");
				while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
				{
					$tbl_customer_type = mysql_query("SELECT b.customer_type_name FROM customer a, customer_type b WHERE a.customer_active = '1' AND b.customer_type_active = '1' AND a.customer_type_id = b.customer_type_id GROUP BY b.customer_type_id");
					while($data_tbl_customer_type = mysql_fetch_array($tbl_customer_type))
					{
			?>
						<th>
							<?php echo $data_tbl_customer_type['customer_type_name'] ?>
						</th>
			<?php
					}
				}
			?>
					</tr>
				</thead>
				<tbody>
					<tr>
			<?php
				$tbl_customer_category = mysql_query("SELECT b.customer_category_id FROM customer a, customer_category b WHERE a.customer_active = '1' AND b.customer_category_active = '1' AND a.customer_category_id = b.customer_category_id GROUP BY b.customer_category_id");
				while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
				{
					
					$tbl_customer_type = mysql_query("SELECT b.customer_type_id FROM customer a, customer_type b WHERE a.customer_active = '1' AND b.customer_type_active = '1' AND a.customer_type_id = b.customer_type_id GROUP BY b.customer_type_id");
					while($data_tbl_customer_type = mysql_fetch_array($tbl_customer_type))
					{
						$tbl_customer = mysql_query("SELECT COUNT(customer_id) AS total_quantity FROM customer WHERE customer_active = '1' AND customer_category_id = '".$data_tbl_customer_category['customer_category_id']."' AND customer_type_id = '".$data_tbl_customer_type['customer_type_id']."'");
						$data_tbl_customer = mysql_fetch_array($tbl_customer);
			?>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['total_quantity'] ?>
						</td>
			<?php
					}
				}
			?>
					</tr>
				</tbody>
			</table>
<?php
		}
		else
		{
?>
			<table id="header-table">
				<tbody>
					<tr>
						<td style="width: 50%;" rowspan="4"><img src="../../assets/admin/pages/media/invoice/walmart3.png"/></td>
					</tr>
					<tr>
						<td style="text-align: right;">LAPORAN PELANGGAN</td>
					</tr>
					<tr>
						<td style="text-align: right;">BY KECAMATAN</td>
					</tr>
					<tr>
						<td style="font-size: 11px; text-align: right;">Periode <?php echo $tgl_sekarang_indo ?></td>
					</tr>
				</tbody>
			</table>
			<br />
			<table id="content-table">
				<thead>
					<tr>
						<th>
							No
						</th>
						<th>
							Kota/ Kabupaten
						</th>
						<th>
							Kecamatan
						</th>
						<th>
							Kategori
						</th>
						<th>
							Kelas
						</th>
						<th>
							Jenis
						</th>
						<th>
							Kode
						</th>
						<th>
							Nama
						</th>
						<th>
							Alamat
						</th>
						<th>
							Batas Tertinggi
						</th>
					</tr>
				</thead>
				<tbody>
			<?php
				$no = 1;
				$tbl_customer = mysql_query("SELECT a.customer_id, a.customer_code, a.customer_name, a.customer_address, b.customer_category_name, c.customer_class_name, c.customer_class_price_limit, d.customer_type_name, e.customer_districts_name, f.customer_city_name FROM customer a, customer_category b, customer_class c, customer_type d, customer_districts e, customer_city f WHERE a.customer_active = '1' AND b.customer_category_active = '1' AND c.customer_class_active = '1' AND d.customer_type_active = '1' AND e.customer_districts_active = '1' AND f.customer_city_active = '1' AND a.customer_districts_id = '".$_GET['customer_districts_id']."' AND a.customer_category_id = b.customer_category_id AND a.customer_class_id = c.customer_class_id AND a.customer_type_id = d.customer_type_id AND a.customer_districts_id = e.customer_districts_id AND e.customer_city_id = f.customer_city_id ORDER BY e.customer_districts_name, f.customer_city_name, b.customer_category_name, d.customer_type_name, a.customer_code");
				while ($data_tbl_customer = mysql_fetch_array($tbl_customer))
				{
					$customer_class_price_limit = format_angka($data_tbl_customer['customer_class_price_limit']);
			?>
					<tr>
						<td style="width: 3%; text-align: right;">
							<?php echo $no ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_city_name'] ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_districts_name'] ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_category_name'] ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_class_name'] ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_type_name'] ?>
						</td>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['customer_code'] ?>
						</td>
						<td style="text-align: left;">
							<?php echo $data_tbl_customer['customer_name'] ?>
						</td>
						<td style="text-align: left;">
							<?php echo $data_tbl_customer['customer_address'] ?>
						</td>
						<td style="text-align: right;">
							<?php echo $customer_class_price_limit ?>
						</td>
					</tr>
			<?php
				$no++;
				}
			?>
				</tbody>
			</table>
			<br />
			<table id="content-table">
				<thead>
					<tr>
				<?php
					$tbl_customer_category = mysql_query("SELECT b.customer_category_name FROM customer a, customer_category b WHERE a.customer_active = '1' AND b.customer_category_active = '1' AND a.customer_districts_id = '".$_GET['customer_districts_id']."' AND a.customer_category_id = b.customer_category_id GROUP BY b.customer_category_id");
					$jumlah_tbl_customer_category = mysql_num_rows($tbl_customer_category);
					while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
					{
				?>
						<th colspan="<?php echo $jumlah_tbl_customer_category ?>">
							<?php echo $data_tbl_customer_category['customer_category_name'] ?>
						</th>
				<?php
					}
				?>
					</tr>
			<?php
				$tbl_customer_category = mysql_query("SELECT b.customer_category_name FROM customer a, customer_category b WHERE a.customer_active = '1' AND b.customer_category_active = '1' AND a.customer_districts_id = '".$_GET['customer_districts_id']."' AND a.customer_category_id = b.customer_category_id GROUP BY b.customer_category_id");
				while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
				{
					$tbl_customer_type = mysql_query("SELECT b.customer_type_name FROM customer a, customer_type b WHERE a.customer_active = '1' AND b.customer_type_active = '1' AND a.customer_districts_id = '".$_GET['customer_districts_id']."' AND a.customer_type_id = b.customer_type_id GROUP BY b.customer_type_id");
					while($data_tbl_customer_type = mysql_fetch_array($tbl_customer_type))
					{
			?>
						<th>
							<?php echo $data_tbl_customer_type['customer_type_name'] ?>
						</th>
			<?php
					}
				}
			?>
					</tr>
				</thead>
				<tbody>
					<tr>
			<?php
				$tbl_customer_category = mysql_query("SELECT b.customer_category_id FROM customer a, customer_category b WHERE a.customer_active = '1' AND b.customer_category_active = '1' AND a.customer_districts_id = '".$_GET['customer_districts_id']."' AND a.customer_category_id = b.customer_category_id GROUP BY b.customer_category_id");
				while($data_tbl_customer_category = mysql_fetch_array($tbl_customer_category))
				{
					
					$tbl_customer_type = mysql_query("SELECT b.customer_type_id FROM customer a, customer_type b WHERE a.customer_active = '1' AND b.customer_type_active = '1' AND a.customer_districts_id = '".$_GET['customer_districts_id']."' AND a.customer_type_id = b.customer_type_id GROUP BY b.customer_type_id");
					while($data_tbl_customer_type = mysql_fetch_array($tbl_customer_type))
					{
						$tbl_customer = mysql_query("SELECT COUNT(customer_id) AS total_quantity FROM customer WHERE customer_active = '1' AND customer_districts_id = '".$_GET['customer_districts_id']."' AND customer_category_id = '".$data_tbl_customer_category['customer_category_id']."' AND customer_type_id = '".$data_tbl_customer_type['customer_type_id']."'");
						$data_tbl_customer = mysql_fetch_array($tbl_customer);
			?>
						<td style="text-align: center;">
							<?php echo $data_tbl_customer['total_quantity'] ?>
						</td>
			<?php
					}
				}
			?>
					</tr>
				</tbody>
			</table>
<?php
		}
	}
?>
	<small><i>Di Cetak Oleh : <?php echo $_SESSION['user_name'] ?> | <?php echo date("d-m-Y H:i:s") ?></i></small>
</body>
</html>