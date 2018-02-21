<?php

	session_start();

	$diaryContent = "";

	if (array_key_exists("no", $_COOKIE)) {

		$_SESSION['no'] = $_COOKIE['no'];

	}

	if (array_key_exists("no", $_SESSION)) {

		
		include("connection.php");

		$query = "SELECT diary FROM `users` WHERE no = '" . mysqli_real_escape_string($link, $_SESSION['no']). "' LIMIT 1";

		$result = mysqli_query($link, $query);

		$row = mysqli_fetch_array($result);

		$diaryContent = $row['diary'];

	} else {

		header("Location: index.php");

	}


	include("header.php");
?>


<nav class="navbar navbar-light bg-faded navbar-fixed-top">
  <a class="navbar-brand" href="#"><strong>Secret Diary<strong></a>


    <div class="pull-xs-right">
      <a href='index.php?logout=1'><button class="btn btn-outline-success" type="submit">Logout</button></a>
    </div>
</nav>

	<div class="container-fluid" id="containerLoggedInPage">
		<textarea id="diary" style="width: 100%; height: 100vh; outline: none"  class="form-control"><?php echo $diaryContent ?></textarea>
	</div>

<?php

	include("footer.php");

?>