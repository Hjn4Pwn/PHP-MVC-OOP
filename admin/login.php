<?php
include_once "../classes/adminLogin.php";
?>

<?php
// CHECK LOGIN ADMIN
$adminLogin_Obj = new adminLogin();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$adminUsername = $_POST["$adminUsername"];
	$adminPassword = $_POST["$adminPassword"];

	$loginCheck = $adminLogin_Obj->admin_login($adminUsername, $adminPassword);
}
?>

<!DOCTYPE html>

<head>
	<meta charset="utf-8">
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="css/stylelogin.css" media="screen" />
</head>

<body>
	<div class="container">
		<section id="content">
			<form action="login.php" method="post">
				<h1>Admin Login</h1>
				<div>
					<input type="text" placeholder="Username" required="" name="adminUsername" />
				</div>
				<div>
					<input type="password" placeholder="Password" required="" name="adminPassword" />
				</div>
				<div>
					<input type="submit" value="Log in" />
				</div>
			</form><!-- form -->
			<div class="button">
				<a href="#">Training with live project</a>
			</div><!-- button -->
		</section><!-- content -->
	</div><!-- container -->
</body>

</html>