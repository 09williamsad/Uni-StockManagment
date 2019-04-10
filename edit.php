<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Basic Page Needs-->
		<meta charset="utf-8">
		<title>Admin Edit</title>
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
			$message = "Failed to connect to MySQL: " . mysqli_connect_error();
			} else {
				
				if (!filter_var($_GET["edit_ID"], FILTER_VALIDATE_INT)) {
					$edit_ID = mysqli_real_escape_string($connection, $_POST["ID"]);
				} else {
					$edit_ID = mysqli_real_escape_string($connection, $_GET["edit_ID"]);
				}
				
				require 'exists.php';
				
				if (empty($edit_ID)) {
					$message = "Please enter a valid ID to edit";
				} else if (!filter_var($edit_ID, FILTER_VALIDATE_INT)) {
					$message = "The ID must be a whole number.";
				} else if (ID_Exists($edit_ID) == 0) {
					$message = "The ID " .$edit_ID. " does not exist in the database.";
				
				} else if (isset($_POST['editButton'])) {
					$edit_ID = mysqli_real_escape_string($connection, $_POST["ID"]);
					$edit_Name = mysqli_real_escape_string($connection, $_POST["Name"]);
					$edit_Description = mysqli_real_escape_string($connection, $_POST["Description"]);
					$edit_Stock = mysqli_real_escape_string($connection, $_POST["Stock"]);
					$edit_Type = mysqli_real_escape_string($connection, $_POST["Type"]);
					$edit_Style = mysqli_real_escape_string($connection, $_POST["Style"]);
					$edit_Size = mysqli_real_escape_string($connection, $_POST["Size"]);
					$edit_Price = mysqli_real_escape_string($connection, round($_POST["Price"], 2));
					
					if (empty($edit_Name) || empty($edit_Description) || empty($edit_Stock) || empty($edit_Type) || empty($edit_Style) || empty($edit_Size) || empty($edit_Price)) {
						$message = "All fields must have a valid value.";
					} else if ((!is_numeric($edit_Price)) || !filter_var($edit_Stock, FILTER_VALIDATE_INT)) {
						$message = "Price and stock must be numbers with stock being a whole number.";
					} else if ($edit_Price < 0 || $edit_Stock < 0) {
						$message = "Numbers cannot be negative.";
					} else if (!mysqli_query($connection, "
					UPDATE Items SET 
					Item_Name = '$edit_Name', Item_Description = '$edit_Description', Item_Stock = '$edit_Stock', Item_Type = '$edit_Type',
					Item_Style = '$edit_Style', Item_Size = '$edit_Size', Item_Price = '$edit_Price' 
					WHERE Item_ID LIKE '$edit_ID';")) {
						$message = "Error: " . mysqli_error($connection);
					} else {
						$message = "Edited record with ID ".$edit_ID. " to have the values shown above.";
					}
					
				} else {
					$get_Result = mysqli_query($connection, "SELECT * FROM Items WHERE Item_ID LIKE '$edit_ID';");
					$row_Data = mysqli_fetch_assoc($get_Result);
					$edit_Name = $row_Data["Item_Name"];	
					$edit_Price = $row_Data["Item_Price"];	
					$edit_Size = $row_Data["Item_Size"];	
					$edit_Type = $row_Data["Item_Type"];	
					$edit_Stock = $row_Data["Item_Stock"];	
					$edit_Style = $row_Data["Item_Style"];	
					$edit_Description = $row_Data["Item_Description"];	
				}
			}
		?>
		
		<div class ="row">
			<div class="four columns">
				<a class="button" style="display: block; width: 100%;" href="home.php">Home</a>
			</div>
			<div class="four columns">
				<a class="button" style="display: block; width: 100%;" href="add.php">Add</a>
			</div>
			<div class="four columns">
				<a class="button" style="display: block; width: 100%;" href="search.php">Search</a>
			</div>
		</div>
	
		<div class="container">
			<br>
			<h2 align="center">Edit Page</h2>
			<h5_5>Edit the record then click the "Submit" button to submit the changes.</h5_5><br><br>
			<?php echo "<h5_5>" .$message. "</h5_5>"; ?>
		</div>
		
		<form action="edit.php?edit_ID=$edit_ID" method="post">
			<br>
			<div class="container">
				<div class="two columns">
					<label>ID</label>
					<input class="u-full-width" type="text" name="ID" value="<?php echo $edit_ID ?>" readonly>
				</div>
			</div>
			
			<div class="container">
				<div class="four columns">		
					<label>Name</label>
					<input class="u-full-width" type="text" name="Name" value="<?php echo $edit_Name ?>">

					<label>Type</label>
					<input class="u-full-width" type="text" name="Type" value="<?php echo $edit_Type ?>">
				</div>
				
				<div class="four columns">
					<label>Price</label>
					<input class="u-full-width" type="text" name="Price" value="<?php echo $edit_Price ?>">

					<label>Stock</label>
					<input class="u-full-width" type="text" name="Stock" value="<?php echo $edit_Stock ?>">
				</div>
				
				<div class="four columns">
					<label>Size</label>
					<input class="u-full-width" type="text" name="Size" value="<?php echo $edit_Size ?>">
					
					<label>Style</label>
					<input class="u-full-width" type="text" name="Style" value="<?php echo $edit_Style ?>">
				</div>
				
				<label>Description</label>
				<input class="u-full-width" type="text" name="Description" value="<?php echo $edit_Description ?>">
				
				<button class="button-primary" type="submit" name="editButton" value="editButton">Submit</button>
			</div>
		</form>
		
		<div class="container">
			<form action="edit.php" method="get">
				<br><h5_5>To edit another record enter an ID then click "Edit", changes to current record will not be saved unless you click "Submit".</h5_5><br>
				<input type="text" name="edit_ID">
				<button class="button-primary" type="submit">Edit</button>
			</form>
		</div>
		<?php  mysqli_close($connection);?>
	</body>
</html>