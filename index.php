<?php
	session_start();
	echo "Account: ".$_SESSION['email'];
	echo "<pre>";
	print_r($_COOKIE);
	echo "</pre>";
?>
<!DOCTYPE html>
<html>
	<head>
		<title>CRUD</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
<body>
	<button type="button" name="logout"><a href="logout.php" style="text-decoration: none;">Logout</a></button>
</body>
</html>
