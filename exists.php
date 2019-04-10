<?php
	function ID_Exists($exists_ID) {
		$username = "";
		$password = "";
		$host = "127.0.0.1";
		$db = $username; 
		$connection = mysqli_connect($host, $username, $password, $db);
			
		$exists_Value = mysqli_real_escape_string($connection, $exists_ID);
		$exists_Results = mysqli_query($connection, "SELECT * FROM Items WHERE Item_ID LIKE '$exists_Value';");
		return mysqli_num_rows($exists_Results);
	}
?>