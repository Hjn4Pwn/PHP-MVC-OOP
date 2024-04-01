<?php
include "./inc/header.php";
// include "./inc/slider.php";
?>

<?php
if (!Session::get('customerLogin')) {
	header('Location:login.php');
}
?>

<?php
if (isset($_GET['deleteCartId']) && $_GET['deleteCartId'] != NULL) {
	$deleteCartId = $_GET['deleteCartId'];
	$deleteCartId = $cart->deleteProductCart($deleteCartId);
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
	$cartIdUpdate = $_POST['cartIdUpdate'];
	$cartQuantity = $_POST['cartQuantity'];
	$updateQuantity = $cart->updateQuantity($cartIdUpdate, $cartQuantity);
}

?>

<div class="main">
	<div class="content">
		<div class="cartoption">
			<div class="cartpage">
				<h2>Your Cart</h2>
				<table class="tblone">
					<tr>
						<th width="20%">Product Name</th>
						<th width="10%">Image</th>
						<th width="15%">Price</th>
						<th width="25%">Quantity</th>
						<th width="20%">Total Price</th>
						<th width="10%">Action</th>
					</tr>
					<?php
					$getProductCart = $cart->getProductCart(Session::get('customerId'));
					if ($getProductCart) {
						$total = 0;
						while ($res = $getProductCart->fetch_assoc()) {
					?>
							<tr>
								<td><?php echo $res['cartProductName'] ?></td>
								<td><img src="admin/uploads/<?php echo $res['cartProductImage'] ?>" alt="" /></td>
								<td><?php echo $res['cartPrice'] . " VND" ?></td>
								<td>
									<form action="" method="post">
										<input type="hidden" name="cartIdUpdate" value="<?php echo $res['cartId'] ?>" />
										<input type="number" name="cartQuantity" value="<?php echo $res['cartQuantity'] ?>" min="0" />
										<input type="submit" name="submit" value="Update" />
									</form>
								</td>
								<td><?php $totalPerProduct = $res['cartPrice'] * $res['cartQuantity'];
									$total += $totalPerProduct;
									echo $totalPerProduct . " VND"; ?></td>
								<td><a onclick="confirmDelete(<?php echo $res['cartId'] ?>)" href="#">Delete</a></td>
								<!-- delete product in cart -->
								<script>
									function confirmDelete(deleteCartId) {
										var confirmDelete = confirm("Are you serious?");
										if (confirmDelete) {
											// Nếu người dùng nhấp vào OK, thực hiện hành động xóa
											window.location.href = "?deleteCartId=" + deleteCartId;
										} else {
											//    
										}
									}
								</script>
							</tr>
					<?php
						}
					}
					?>


				</table>
				<table style="float:right;text-align:left;" width="40%">
					<tr>
						<th>Sub Total : </th>
						<td><?php echo ($getProductCart) ? $total . " VND" : "0 VND"; ?></td>
					</tr>
					<tr>
						<th>VAT : </th>
						<!-- 0.05% -->
						<td><?php echo ($getProductCart) ? $total * 0.005 . " VND" : "0 VND"; ?></td>
					</tr>
					<tr>
						<th>Grand Total :</th>
						<td><?php echo ($getProductCart) ? $total * 1.005 . " VND" : "0 VND"; ?></td>
					</tr>
				</table>
			</div>
			<div class="shopping">
				<div class="shopleft">
					<a href="index.php"> <img src="images/shop.png" alt="" /></a>
				</div>
				<div class="shopright">
					<a href="login.php"> <img src="images/check.png" alt="" /></a>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<?php
include "./inc/footer.php";
?>