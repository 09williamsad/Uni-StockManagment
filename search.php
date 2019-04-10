<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Basic Page Needs-->
		<meta charset="utf-8">
		<title>Admin Search</title>
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
				if (isset($_POST["Delete"])) {
					require 'delete.php';
				}
				
				$search_ID = mysqli_real_escape_string($connection, $_GET["ID"]);
				$search_Name = mysqli_real_escape_string($connection, $_GET["Name"]);
				$search_Type = mysqli_real_escape_string($connection, $_GET["Type"]);
				$search_Style = mysqli_real_escape_string($connection, $_GET["Style"]);
				$search_Size = mysqli_real_escape_string($connection, $_GET["Size"]);
				$search_Stock = mysqli_real_escape_string($connection, $_GET["Stock"]);
				$search_Price = mysqli_real_escape_string($connection, $_GET["Price"]);
				$search_sorting = mysqli_real_escape_string($connection, $_GET["sort_By"]);					
				$search_Result = mysqli_query($connection, "SELECT * FROM Items WHERE 
					(Item_ID LIKE '$search_ID' || '$search_ID' LIKE '') && (Item_Name LIKE '%$search_Name%' || '$search_Name' LIKE '') && 
					(Item_Type LIKE '$search_Type' || '$search_Type' LIKE '') && (Item_Style LIKE '$search_Style' || '$search_Style' LIKE '') && 
					(Item_Size LIKE '$search_Size' || '$search_Size' LIKE '') && (Item_Stock LIKE '$search_Stock' || '$search_Stock' LIKE '') && 
					(Item_Price LIKE '$search_Price' || '$search_Price' LIKE '') 
					ORDER BY $search_sorting ASC;");
			}
		?>
		
		<div class ="row">
			<div class="six columns">
				<a class="button" style="display: block; width: 100%;" href="home.php">Home</a>
			</div>
			<div class="six columns">
				<a class="button" style="display: block; width: 100%;" href="add.php">Add</a>
			</div>
		</div>
		
		<div class="container">
			<br>
			<h2 align="center">Search Page</h2>
			<h5_5>Enter what you want to search for then press enter on your device or click the Search button. <br>
			Alternatively press Enter or the Submit button with nothing entered to see all results.</h5_5>
		</div>
	
		<form action="search.php" method="get">
			<br>
			<div class="container"> 
				<div class="one column">
					<label>ID</label>
					<input class="u-full-width" type="text" name="ID" value="<?php echo $search_ID ?>">
				</div>
				<div class="ten-percent column">
					<label>Name</label>
					<input class="u-full-width" type="text" name="Name" value="<?php echo $search_Name ?>">
				</div>
				<div class="ten-percent column">
					<label>Type</label>
					<input class="u-full-width" type="text" name="Type" value="<?php echo $search_Type ?>">
				</div>
				<div class="ten-percent column">
					<label>Style</label>
					<input class="u-full-width" type="text" name="Style" value="<?php echo $search_Style ?>">
				</div>
				<div class="one column">
					<label>Size</label>
					<input class="u-full-width" type="text" name="Size" value="<?php echo $search_Size ?>">
				</div>
				
				<div class="one column">
					<label>Stock</label>
					<input class="u-full-width" type="text" name="Stock" value="<?php echo $search_Stock ?>">
				</div>
				<div class="six-percent column">
					<label>Price</label>
					<input class="u-full-width" type="text" name="Price" value="<?php echo $search_Price ?>">
				</div>
				
				<div class ="six-percent column">
					<label for="sort_By">Sort by:</label>
					<select class="u-full-width" name="sort_By">
						<option value="Item_ID">ID</option>
						<option value="Item_Name">Name</option>
						<option value="Item_Type">Type</option>
						<option value="Item_Style">Style</option>
						<option value="Item_Size">Size</option>
						<option value="Item_Description">Description</option>
						<option value="Item_Stock">Stock</option>
						<option value="Item_Price">Price</option>
					</select>
				</div>
				<div class="ten-percent column">
					<br>
					<input class="button-primary" type="submit" value="Search">
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
					<form action="search.php" method="post">
						<h5_5>To delete records from this page tick the checkboxes for the records to delete then click the "Delete" button</h5_5>
						<button class="button-primary" type="submit" style = "float: right">Delete</button><br><br>
						<?php
							echo "<h5_5>".$message."</h5_5>";
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