<?php
	session_start();

	if(isset($_SESSION['email'])){
		header("Location: index.php");
	}
	require "config/connect.php";

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(isset($_POST['email'])){
			$email = $_POST['email'];
		} else {
			$email = "";
		}
		if(isset($_POST['password'])){
			$password = $_POST['password'];
		} else {
			$password = "";
		}

		if ($_POST['remember-me'] == "remember-me") {
			setcookie('email', $email, time() + 3600, "/");
		} else if (!isset($_POST['remember-me'])){
			setcookie('email', $email, time() - 3600, "/");
		}
		
		$sql = "select * from tb_account where email = '".$email."' and password = '".md5($password)."'";
		$result = mysqli_query($conn, $sql);

	//Debug
		// echo "Email: ".$email."<br>";
		// echo "Password: ".$password."<br>";
		// echo "Sql query: ".$sql."<br>";
	}
?>

<!DOCTYPE html>
<html lang="vn">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" href="login-plugin/images/icons/login_icon.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login-plugin/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login-plugin/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login-plugin/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login-plugin/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="login-plugin/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login-plugin/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login-plugin/vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="login-plugin/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login-plugin/css/util.css">
	<link rel="stylesheet" type="text/css" href="login-plugin/css/main.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login-plugin/vendor/toastr/toastr.min.css">
</head>
<body style="background-color: #666666;">
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="post">
					<span class="login100-form-title p-b-43" style="font-family: Montserrat;">
						LOGIN
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Example: ex@abc.xyz">
						<input class="input100" type="text" name="email" id="email" <?php if (isset($_COOKIE['email'])) {
							echo "value='".$_COOKIE['email']."' autofocus";
						} ?>>
						<span class="focus-input100"></span>
						<span class="label-input100">Email</span>
					</div>
					
					<div class="wrap-input100 validate-input" data-validate="Fill this field">
						<input class="input100" type="password" name="password" id="password">
						<span class="focus-input100"></span>
						<span class="label-input100">Password</span>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me" value="remember-me" <?php if (isset($_COOKIE['email'])) {
								echo "checked";
							} ?>>
							<label class="label-checkbox100" for="ckb1">
								Remember Me
							</label>
						</div>
					</div>
			

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">
							Login
						</button>
					</div>
				</form>

				<div class="login100-more" style="background-image: url('login-plugin/images/background.jpg');">
				</div>
			</div>
		</div>
	</div>
	
<!--===============================================================================================-->
	<script src="login-plugin/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="login-plugin/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="login-plugin/vendor/bootstrap/js/popper.js"></script>
	<script src="login-plugin/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="login-plugin/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="login-plugin/vendor/daterangepicker/moment.min.js"></script>
	<script src="login-plugin/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="login-plugin/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="login-plugin/js/main.js"></script>
<!--===============================================================================================-->
	<script src="login-plugin/vendor/toastr/toastr.min.js"></script>
	<?php
	if(isset($result)){
		if (mysqli_num_rows($result) < 1){
			echo "<script>
					toastr.options = {
						'closeButton': false,
						'debug': false,
						'newestOnTop': false,
						'progressBar': true,
						'positionClass': 'toast-top-right',
						'preventDuplicates': false,
						'onclick': null,
						'showDuration': '300',
						'hideDuration': '1000',
						'timeOut': '7000',
						'extendedTimeOut': '1000',
						'showEasing': 'swing',
						'hideEasing': 'linear',
						'showMethod': 'fadeIn',
						'hideMethod': 'fadeOut'
					}
	
					toastr['warning']('Email or Password is incorrect ❌', 'LOGIN FAIL')
				</script>";
		} else {
			$row = mysqli_fetch_assoc($result);
			$_SESSION['email'] = $row['email'];
			$_SESSION['id-account'] = $row['id'];
			// echo "<pre>";
			// print_r($_SESSION);
			// echo "</pre>";
			echo "<script> window.location.href = 'index.php'; </script>";
		}
	}
	?>
</body>
</html>
