<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Basic Page Needs-->
		<meta charset="utf-8">
		<title>Admin Home</title>
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Mobile Specific Metas-->
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- FONT-->
		<link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

		<!-- CSS-->
		<link rel="stylesheet" href="css/normalize.css">
		<link rel="stylesheet" href="css/skeleton.css">
	</head>
	<body>
		<?php
			$username = "";
			$password = "";
			$host = "127.0.0.1";
			$db = $username; 
			$connection = mysqli_connect($host, $username, $password, $db);
			if (mysqli_connect_error()){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
			} else {
				require 'exists.php';
				
				if (isset($_POST["Delete"])) {
					foreach ($_POST["Delete"] as $delete_ID) {
						if (empty($delete_ID)) {
							$message = "Please enter an ID to delete";
						} else if (!filter_var($delete_ID, FILTER_VALIDATE_INT)) {
							$message = "The ID must be a whole number.";
						} else if (ID_Exists($delete_ID) == 0) {
							$message = "No record with the ID " .$delete_ID. " exists in the database";
						} else {
							require 'delete.php';
						}
					}
				} else if (isset($_POST["edit_ID"])) {
					$edit_ID = $_POST["edit_ID"];
					if (empty($edit_ID)) {
						$edit_Message = "Please enter an ID to edit";
					} else if (!filter_var($edit_ID, FILTER_VALIDATE_INT)) {
						$edit_Message = "The ID must be a whole number.";
					} else if (ID_Exists($edit_ID) == 0) {
						$edit_Message = "No record with the ID " .$edit_ID. " exists in the database";
					} else {						
						header("Location: edit.php?edit_ID=".$edit_ID);
					}
				}
			}
		?>
		<div class="container">
			<div class="row">
				<h2 align="center" style="margin-top: 4%">Home Page</h2>
			</div>
  
			<div class="row">
				<div class="one-half column" style="margin-top: 10%" align="center">
					<a class="button" href="search.php">Search records</a>
				</div>
				<div class="one-half column" style="margin-top: 10%" align="center">
					<a class="button" href="add.php">Add record</a>
				</div>
			</div>
			
			<div class="row">
				<div class="one-half column" style="margin-top: 10%" align="center">
					<form action="home.php" method="post">
						<h5_5>Enter the ID of the record you want to delete below then press the button.<br>
						If you do not know the ID then you can select delete when you search for it.</h5_5><br>
						<input type="text" name="Delete[]">
						<button class="button-primary" type="submit" name="deleteButton">Delete</button>
					</form>		
					<?php echo $message; ?>
				</div>
				
				<div class="one-half column" style="margin-top: 10%" align="center">
					<form action="home.php" method="post">
						<h5_5>Enter the ID of the record you want to edit below then press the button.<br>
						If you do not know the ID then you can select edit when you search for it.</h5_5><br>
						<input type="text" name="edit_ID">
						<button class="button-primary" type="submit">Edit</button>
					</form>
					<?php echo $edit_Message; ?>
				</div>
			</div>
		</div>
	</body>
</html>