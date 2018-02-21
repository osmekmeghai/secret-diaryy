<?php

	// either exist creat a connection to database
				$server = 'localhost';
				$username = 'root';
				$password = 'mother94';
				$database = 'users';

				$link = mysqli_connect($server, $username, $password, $database);

				if (mysqli_connect_error()) {
			
					die("There was an error connecting to database");
				}

?>