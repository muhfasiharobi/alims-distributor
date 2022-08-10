<?php
	include "../config/connection.php";
	
	function sequence($table, $key)
	{
		$query = mysql_query("SELECT MAX(".$key.") + 1 AS number FROM ".$table);
		$fetch_array = mysql_fetch_array($query);
		
		if ($fetch_array['number'] == null)
		{
			$new_id = 1;
		} 
		else
		{
			$new_id = $fetch_array['number'];
		}
		return $new_id;
	}	
?>