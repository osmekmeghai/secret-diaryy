<?php
	
	session_start();

	if ($_SESSION['email']) {

		echo "Weclome to the future ". $_SESSION['email'];

	} else {

		header('Location: index.php');

	}
?>