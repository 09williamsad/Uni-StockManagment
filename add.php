<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Basic Page Needs-->
		<meta charset="utf-8">
		<title>Admin Add</title>
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

				if (isset($_POST['Delete'])) {
					require 'delete.php';
				}
				
				if (isset($_POST["Add"])) {
					
					$add_Name = mysqli_real_escape_string($connection, $_POST["Name"]);
					$add_Description = mysqli_real_escape_string($connection, $_POST["Description"]);
					$add_Stock = mysqli_real_escape_string($connection, $_POST["Stock"]);
					$add_Type = mysqli_real_escape_string($connection, $_POST["Type"]);
					$add_Style = mysqli_real_escape_string($connection, $_POST["Style"]);
					$add_Size = mysqli_real_escape_string($connection, $_POST["Size"]);
					$add_Price = mysqli_real_escape_string($connection, round($_POST["Price"], 2));
					
					if (empty($add_Name) || empty($add_Description) || empty($add_Stock) || empty($add_Type) || empty($add_Style) || empty($add_Size) || empty($add_Price)) {
						$message = "All fields must have a valid value.";
					} else if ((!is_numeric($add_Price)) || !filter_var($add_Stock, FILTER_VALIDATE_INT)) {
						$message = "Price and stock must be numbers with stock being a whole number.";
					} else if ($add_Price < 0 || $add_Stock < 0) {
						$message = "Numbers cannot be negative.";
					} else {
						if (!mysqli_query($connection, "
							INSERT INTO Items (`Item_Name`, `Item_ID`, `Item_Description`, `Item_Stock`, `Item_Type`, `Item_Style`, `Item_Size`, `Item_Price`) 
							VALUES ('$add_Name', NULL, '$add_Description', '$add_Stock', '$add_Type', '$add_Style', '$add_Size', '$add_Price')")) {
							$message =("Error: " . mysqli_error($connection));
						} else {
							$message = "Added the details as a new record, see new record and bottom of table.";
						}
					}
				}
				$search_Result = mysqli_query($connection, "SELECT * FROM Items ORDER BY Item_ID ASC;");
			}
		?>
		
		<div class ="row">
			<div class="six columns">
				<a class="button" style="display: block; width: 100%;" href="home.php">Home</a>
			</div>
			<div class="six columns">
				<a class="button" style="display: block; width: 100%;" href="search.php">Search</a>
			</div>
		</div>
		
		<div class="container">
			<br>
			<h2 align="center">Add Page</h2>
			<h5_5>Enter the details of the record you want to add then click the "Add" button, the record will not be added unless the "Add" button is clicked.</h5_5>
		</div>
	
		<form action="add.php" method="post">
			<br>
				<div class="container">
					<div class="two columns">
						<label>Name</label>
						<input class="u-full-width" type="text" name="Name">
					</div>
					<div class="three columns">
						<label>Description</label>
						<input class="u-full-width" type="text" name="Description">
					</div>
					<div class="five-percent column">
						<label>Stock</label>
						<input class="u-full-width" type="text" name="Stock">
					</div>
					<div class="six-percent column">
						<label>Type</label>
						<input class="u-full-width" type="text" name="Type">
					</div>
					<div class="six-percent column">
						<label>Style</label>
						<input class="u-full-width" type="text" name="Style">
					</div>
					<div class="one column">
						<label>Size</label>
						<input class="u-full-width" type="text" name="Size">
					</div>
					<div class="six-percent column">
						<label>Price</label>
						<input class="u-full-width" type="text" name="Price">
					</div>
					<div class="one column">
						<br>
						<input class="button-primary" type="submit" value="Add" name="Add">
					</div>
				</div>
		</form>
			
		<div class="container">
			<table class="u-full-width">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Description</th>
						<th>Stock</th>
						<th>Type</th>
						<th>Style</th>
						<th>Size</th>
						<th>Price</th>
						<th>Option</th>
					</tr>
				</thead>
				<tbody>
					<form action="add.php" method="post">
						<h5_5>You can also delete records from this page by ticking the records to delete then clicking the "Delete" button.</h5_5>
						<button class="button-primary" type="submit" style = "float: right">Delete</button><br><br>
						<?php
							echo "<h5_5>" .$message. "</h5_5>";
							while ($row = mysqli_fetch_assoc($search_Result)) {
								echo 
								"<tr>
									<td>{$row["Item_ID"]}</td>
									<td>{$row["Item_Name"]}</td>
									<td>{$row["Item_Description"]}</td>
									<td>{$row["Item_Stock"]}</td>
									<td>{$row["Item_Type"]}</td>
									<td>{$row["Item_Style"]}</td> 
									<td>{$row["Item_Size"]}</td>
									<td>{$row["Item_Price"]}</td>
									<td width='9%'>"
						?>
										<a href="edit.php?edit_ID=<?php echo $row["Item_ID"] ?>">Edit</a><br>
										Delete <input type="checkbox" name="Delete[]" value="<?php echo $row["Item_ID"] ?>">
									</td>
						<?php echo 
								"</tr>\n";
							}
						?>
					</form>
				</tbody>
			</table>
			<?php  mysqli_close($connection);?>
		</div>
	</body>
</html>