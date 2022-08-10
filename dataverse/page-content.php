<?php
	include "formidable/infographic-selling.php";
	include "formidable/infographic-selling-agent.php";
	include "formidable/infographic-purchase.php";
	include "formidable/item.php";
	include "formidable/item-category.php";
	include "formidable/item-commission.php";
	include "formidable/item-price.php";
	include "formidable/item-purchase.php";
	include "formidable/item-selling.php";
	include "formidable/item-selling-agen.php";
	include "formidable/reseller.php";
	include "formidable/supplier.php";
	include "formidable/user.php";
	include "formidable/user-category.php";
	include "formidable/selling-commission.php";
	include "formidable/report-agent.php";
	include "formidable/company.php";
	include "formidable/invoice.php";
	include "formidable/purchase-report.php";
	include "formidable/selling-report.php";
	include "formidable/retur-item-purchase.php";
	include "formidable/retur-item-selling.php";
	include "formidable/user-profile.php";
	include "formidable/customer.php";
	include "formidable/reseller-item-sell.php";
	include "formidable/item-stock.php";
	include "formidable/reward.php";
	include "formidable/commission-report.php";
	include "formidable/commission-report-agen.php";
	include "formidable/selling-report-agen.php";
	include "formidable/penyesuaian-stok.php";
	include "formidable/promo.php";
	include "formidable/komisi.php";
	include "formidable/komisi-agen.php";
	include "formidable/customer-report.php";
	include "formidable/barang-keluar.php";
	include "formidable/delivery-service.php";
	include "formidable/marketplace.php";
	include "formidable/bank.php";
	
	if ($_GET['connect'] == "dashboard")
	{
		if($_SESSION['user_category_name'] == "Agen")
		{
			include "parquery/infographic-selling-agent.php";
		}
		else
		{
			include "parquery/infographic-selling.php";
		}

	}
	elseif ($_GET['connect'] == "infographic-selling")
	{
		include "parquery/infographic-selling.php";
	}
	elseif ($_GET['connect'] == "infographic-selling-agent")
	{
		include "parquery/infographic-selling-agent.php";
	}
	elseif ($_GET['connect'] == "infographic-purchase")
	{
		include "parquery/infographic-purchase.php";
	}
	elseif ($_GET['connect'] == "item")
	{
		include "parquery/item.php";
	}
	elseif ($_GET['connect'] == "item-category")
	{
		include "parquery/item-category.php";
	}
	elseif ($_GET['connect'] == "item-commission")
	{
		include "parquery/item-commission.php";
	}
	elseif ($_GET['connect'] == "item-price")
	{
		include "parquery/item-price.php";
	}
	elseif ($_GET['connect'] == "item-purchase")
	{
		include "parquery/item-purchase.php";
	}
	elseif ($_GET['connect'] == "item-selling")
	{
		include "parquery/item-selling.php";
	}
	elseif ($_GET['connect'] == "item-selling-agen")
	{
		include "parquery/item-selling-agen.php";
	}
	elseif ($_GET['connect'] == "reseller")
	{
		include "parquery/reseller.php";
	}
	elseif ($_GET['connect'] == "supplier")
	{
		include "parquery/supplier.php";
	}
	elseif ($_GET['connect'] == "user")
	{
		include "parquery/user.php";
	}
	elseif ($_GET['connect'] == "user-category")
	{
		include "parquery/user-category.php";
	}
	elseif ($_GET['connect'] == "selling-commission")
	{
		include "parquery/selling-commission.php";
	}
	elseif ($_GET['connect'] == "report-agent")
	{
		include "parquery/report-agent.php";
	}
	elseif ($_GET['connect'] == "company")
	{
		include "parquery/company.php";
	}
	elseif ($_GET['connect'] == "invoice")
	{
		include "parquery/invoice.php";
	}
	elseif ($_GET['connect'] == "purchase-report")
	{
		include "parquery/purchase-report.php";
	}
	elseif ($_GET['connect'] == "selling-report")
	{
		include "parquery/selling-report.php";
	}
	elseif ($_GET['connect'] == "retur-item-purchase")
	{
		include "parquery/retur-item-purchase.php";
	}
	elseif ($_GET['connect'] == "retur-item-selling")
	{
		include "parquery/retur-item-selling.php";
	}
	elseif ($_GET['connect'] == "user-profile")
	{
		include "parquery/user-profile.php";
	}
	elseif ($_GET['connect'] == "customer")
	{
		include "parquery/customer.php";
	}
	elseif ($_GET['connect'] == "reseller-item-sell")
	{
		include "parquery/reseller-item-sell.php";
	}
	elseif ($_GET['connect'] == "item-stock")
	{
		include "parquery/item-stock.php";
	}
	elseif ($_GET['connect'] == "reward")
	{
		include "parquery/reward.php";
	}
	elseif ($_GET['connect'] == "commission-report")
	{
		include "parquery/commission-report.php";
	}
	elseif ($_GET['connect'] == "commission-report-agen")
	{
		include "parquery/commission-report-agen.php";
	}
	elseif ($_GET['connect'] == "selling-report-agen")
	{
		include "parquery/selling-report-agen.php";
	}
	elseif ($_GET['connect'] == "penyesuaian-stok")
	{
		include "parquery/penyesuaian-stok.php";
	}
	elseif ($_GET['connect'] == "barang-keluar")
	{
		include "parquery/barang-keluar.php";
	}
	elseif ($_GET['connect'] == "promo")
	{
		include "parquery/promo.php";
	}
	elseif ($_GET['connect'] == "komisi")
	{
		include "parquery/komisi.php";
	}
	elseif ($_GET['connect'] == "komisi-agen")
	{
		include "parquery/komisi-agen.php";
	}
	elseif ($_GET['connect'] == "customer-report")
	{
		include "parquery/customer-report.php";
	}
	elseif ($_GET['connect'] == "delivery-service")
	{
		include "parquery/delivery-service.php";
	}
	elseif ($_GET['connect'] == "marketplace")
	{
		include "parquery/marketplace.php";
	}
	elseif ($_GET['connect'] == "bank")
	{
		include "parquery/bank.php";
	}
	else
	{
		header("location:../index.php");
	}
?>