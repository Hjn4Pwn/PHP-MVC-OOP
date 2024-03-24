<?php
include "../classes/adminLogin.php";
?>

<?php
// CHECK LOGIN ADMIN
$adminLogin_Obj = new adminLogin();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$adminUsername = $_POST["adminUsername"];
	$adminPassword = hash('sha256', $_POST["adminPassword"]);

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
				<div style="color:red; padding-bottom: 12px;">
					<?php
					if (isset($loginCheck)) {
						echo $loginCheck;
					}
					?>
				</div>
				<div>
					<!-- required="" -->
					<input type="text" placeholder="Username" name="adminUsername" />
				</div>
				<div>
					<input type="password" placeholder="Password" name="adminPassword" />
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