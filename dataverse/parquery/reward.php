<?php
	switch($_GET['execute'])
	{
		default:
			default_reward_platform();
		break;
		
		case "add-reward-platform":
			add_reward_platform();
		break;
		
		case "add-reward":
			$reward_id = sequence("reward", "reward_id");

			mysql_query("INSERT INTO `reward`(`reward_id`, `selling_quantity`, `reward_value`, `reward_update`, `user_activity_id`, `reward_active`) VALUES ('".$reward_id."','".$_POST['selling_quantity']."','".$_POST['reward_value']."','".$today."','".$_SESSION['user_id']."','1')");
			
			header("location:../dataverse/home.php?connect=reward");
		break;

		case "history-reward-platform":
			history_reward_platform();
		break;

		case "edit-reward-platform":
			edit_reward_platform();
		break;
		
		case "edit-reward":

			mysql_query("UPDATE reward SET selling_quantity = '".$_POST['selling_quantity']."', reward_value = '".$_POST['reward_value']."' WHERE reward_id = '".$_POST['reward_id']."'");
			
			header("location:../dataverse/home.php?connect=reward");
		break;
		
		case "delete-reward":
		
			mysql_query("UPDATE reward SET reward_update = '".$today."', user_activity_id = '".$_SESSION['user_id']."', reward_active = '0' WHERE reward_id = '".$_GET['reward_id']."'");
			
			header("location:../dataverse/home.php?connect=reward");
		break;
	}
?>