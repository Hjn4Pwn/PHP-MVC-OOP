<?php
include "./inc/header.php";
// include "./inc/slider.php";
?>

<?php
if (Session::get('customerLogin')) {
	header('Location:index.php');
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['registry'])) {
	$insertCustomer = $customer->insert_customer($_POST);
	// var_dump($_POST);
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login'])) {
	$checkLogin_customer = $customer->checkLogin_customer($_POST);
}
?>


<div class="main">
	<div class="content">
		<div class="login_panel">
			<h3>Existing Customers</h3>
			<div style="padding: 5px 0;">
				<?php
				if (isset($checkLogin_customer)) {
					echo $checkLogin_customer;
				}
				?>
			</div>
			<!-- <p>Sign in with the form below.</p> -->
			<form action="" method="post">
				<input type="text" name="username" class="field" placeholder="Enter your username">
				<input type="password" name="password" class="field" placeholder="Enter your password">
				<div class="search">
					<input style="position: relative; right: -154px;
								height: 40px; width: 90px; cursor: pointer;
								color: white; background-color:black;
								font-weight:700; font-size: 16px;
								border-radius: 4px; margin-top: 10px;" type="submit" name="login" value="Login">
				</div>
			</form>
			<!-- <p class="note">If you forgot your passoword just enter your email and click <a href="#">here</a></p> -->
			<!-- <div class="buttons">
				<div style="position: relative; right: -163px;"><button class="grey">Sign In</button></div>
			</div> -->
		</div>

		<div class="register_account" style="text-align: center; margin-bottom: 20px;">
			<h3>Register New Account</h3>
			<div style="padding: 5px 0;">
				<?php
				if (isset($insertCustomer)) {
					echo $insertCustomer;
				}
				?>
			</div>
			<form action="" method="post">
				<div class="">
					<input type="text" name="username" placeholder="Enter your username">
				</div>
				<div class="">
					<input type="text" name="name" placeholder="Enter your name">
				</div>
				<div>
					<input type="email" name="email" placeholder="Enter your email">
				</div>
				<div>
					<input type="tel" name="phone" placeholder="Enter your phone number">
				</div>
				<div>
					<input type="password" name="password" placeholder="Enter your password">
				</div>
				<div class="search">
					<input style="position: relative; right: -446px;
								height: 40px; width: 90px; cursor: pointer;
								color: white; background-color:black;
								font-weight:700; font-size: 16px;
								border-radius: 4px; margin-top: 10px;" type="submit" name="registry" value="Registry">
				</div>
				<!-- <p class="terms">By clicking 'Create Account' you agree to the <a href="#">Terms &amp; Conditions</a>.</p> -->
				<div class="clear"></div>
			</form>
		</div>
		<div class="clear"></div>
	</div>
</div>
<?php
include "./inc/footer.php";
?>