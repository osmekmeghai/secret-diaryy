<?php
	
	session_start();
	echo $_SESSION['no'] . "yes!";

	if (array_key_exists("content", $_POST)) {

		include("connection.php");

		$query = "UPDATE `users` SET diary = '" . mysqli_real_escape_string($link, $_POST['content']). "' WHERE no = '" . mysqli_real_escape_string($link, $_SESSION['no']). "' LIMIT 1";


		mysqli_query($link, $query);

		
			
	}
?>