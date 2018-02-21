<?php
	$query = "REMOVE"
	
	session_start();

	$error = "";

	if (array_key_exists("logout", $_GET)) {
		
		unset($_SESSION);
		setcookie("no", "", time() - 60*60);
		$_COOKIE["no"] = "";

	}/* else if ((array_key_exists("no", $_SESSION) AND $_SESSION['no']) OR (array_key_exists("no", $_COOKIE) AND $_COOKIE['no'])) {
		
		header("Location: welcome.php");

	}*/

	if (array_key_exists("submit", $_POST)) {


		if (!$_POST['email']) {
			
			$error .= "An email address is required";

		}

		if (!$_POST['password']) {
			
			$error .= "Password is required";

		}

		if ($error != "") {

			$error = "There were error(s) in your form:<br>" . $error;

		} else {

				include("connection.php");

				// if the user is trying to sign up do this
				if ($_POST['signUp'] == '1') {
					# code...
				

					$query = "SELECT `no` FROM `users` WHERE email = '" . mysqli_real_escape_string($link, $_POST['email']) . "'";

					$result = mysqli_query($link, $query);

					//Check to see if the query produces a instance
					if (mysqli_num_rows($result) > 0) {
					
						$error = "<p>This email address already exists</p>";

					} else {

						$hash = password_hash(mysqli_real_escape_string($link, $_POST['password']), PASSWORD_DEFAULT);

						$query = "INSERT INTO `users` (`email`, `password`) VALUES ('" . mysqli_real_escape_string($link, $_POST['email']) . "', '" . mysqli_real_escape_string($link, $_POST['password']) . "')";

						if (mysqli_query($link, $query)) {

							$hash = password_hash(mysqli_real_escape_string($link, $_POST['password']), PASSWORD_DEFAULT);
						
							$query = "UPDATE `users` SET password = '" . $hash . "' WHERE no = " . mysqli_insert_id($link);

							mysqli_query($link, $query);

							$_SESSION['no'] = mysqli_insert_id($link);

							if ($_POST['stayLogged'] == '1') {
							
								setcookie("no", mysqli_insert_id($link), time() + 60 * 60 * 24 * 365);
							}

							header("Location: welcome.php");

						


						} else {

							echo "<p>There was a problem signing you up. try again later.</p>";
						}

					}

				} else {	// if the user is trying to log in


					$query = "SELECT * FROM `users` WHERE email = '" . mysqli_real_escape_string($link, $_POST['email']) . "'";

					$result = mysqli_query($link, $query);

					$row = mysqli_fetch_array($result);

					if (isset($row)) {
						
						$hashPass = password_hash(mysqli_real_escape_string($link, $_POST['password']), PASSWORD_DEFAULT);

						if (password_verify(mysqli_real_escape_string($link, $_POST['password']), $row['password'])) {
							$_SESSION['no'] = $row['no'];

							if ($_POST['stayLogged'] == '1') {

								setcookie("no", $row['no'], time() * 60 * 60 * 24 * 365);

							}

							header("Location: welcome.php");

						} else {

							$error = "That email/password combination is wrong";

						}

					} else {

						$error = "That email/password combination is wrong";

					}

				}

		}
	}
?>


		<?php include("header.php");?>
    <div class="container" id="welcomeContainer">
    	<h1>Secret Diary</h1>

    	<p><strong>Store your thoughts permanently and securely.</strong></p>

    	<div id="error"><?php if ($error != "") {
    		echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
    	} ?></div>

			<form method="post" id="signUpForm">
				<p>Interested? Sign up now</p>
				<fieldset class="form-group">
					<input type="email" class="form-control" name="email" id="email" placeholder="Your Email">
				</fieldset>
				<fieldset class="form-group">
					<input type="password" class="form-control" name="password" id="password" placeholder="Password">
				</fieldset>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="stayLogged" value="1"> Stay logged in
					</label>
				</div>
				<input type="hidden" name="signUp" value="1">
				<fieldset class="form-group">
					<input type="submit" class="btn btn-success" name="submit" value="Sign Up">
				</fieldset>
				<p><a href="" class="toggleForms">Log in</a></p>
			</form>
			

			<form method="post" id="logInForm">
				<p>Log in using your email and password</p>
				<fieldset class="form-group">
					<input type="email" class="form-control" name="email" id="email" placeholder="Yourujiyiyu Email">
				</fieldset>
				<fieldset class="form-group">
					<input type="password" class="form-control" name="password" id="password" placeholder="Password">
				</fieldset>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="stayLogged" value="1"> Stay logged in
					</label>
				</div>
				<input type="hidden" name="signUp" value="0">
				<fieldset class="form-group">
					<input type="submit" class="btn btn-success" name="submit" value="Log In">
				</fieldset>
				<p><a href="" class="toggleForms">Sign Up</a></p>
			</form>
		</div>

		<?php include("footer.php");?>

