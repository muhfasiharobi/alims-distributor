<?php
	switch($_GET['execute'])
	{
		default:
			default_selling_commission_platform();
		break;
		
		case "add-selling-commission-platform":
			add_selling_commission_platform();
		break;
		
		case "add-selling-commission":
			$selling_commission_id = sequence("selling_commission", "selling_commission_id");

			mysql_query("INSERT INTO `selling_commission`(`selling_commission_id`, `minimal_selling`, `maximal_selling`, `selling_commission_value`, `selling_commission_datetime`, `selling_commission_active`) VALUES ('".$selling_commission_id."','".$_POST['minimal_selling']."','".$_POST['maximal_selling']."','".$_POST['selling_commission_value']."','".$today."','1')");
			
			header("location:../dataverse/home.php?connect=selling-commission");
		break;

		case "history-selling-commission-platform":
			history_selling_commission_platform();
		break;

		case "edit-selling-commission-platform":
			edit_selling_commission_platform();
		break;
		
		case "edit-selling-commission":

			mysql_query("UPDATE selling_commission SET selling_commission_value = '".$_POST['selling_commission_value']."', minimal_selling = '".$_POST['minimal_selling']."', maximal_selling = '".$_POST['maximal_selling']."' ,selling_commission_datetime = '".$today."' WHERE selling_commission_id = '".$_POST['selling_commission_id']."'");
			
			header("location:../dataverse/home.php?connect=selling-commission");
		break;
		
		case "delete-selling-commission":
			mysql_query("UPDATE selling_commission SET selling_commission_datetime = '".$today."', selling_commission_active = '0' WHERE selling_commission_id = '".$_GET['selling_commission_id']."'");
			
			header("location:../dataverse/home.php?connect=selling-commission");
		break;
	}
?>