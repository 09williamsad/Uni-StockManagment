<?php
	$message = "Deleted the following record/s:";
	foreach ($_POST['Delete'] as $delete_Raw) {
		if (empty($delete_Raw)) {
			$message = "Please enter an ID to delete";

		} else if (!filter_var(($delete_Raw), FILTER_VALIDATE_INT)) {
			$message = "The ID must be a whole number.";

		} else {
			$delete_ID = mysqli_real_escape_string($connection, $delete_Raw);
			if (!mysqli_query($connection, "DELETE FROM Items WHERE Item_ID = '$delete_ID';")) {
					$message = ("Error: " . mysqli_error($connection));
			} else {
					$message = $message ." ".$delete_ID;
			}
		}
	}
?>