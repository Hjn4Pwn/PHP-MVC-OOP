<?php
include "./inc/header.php";
// include "./inc/slider.php";
?>

<?php
if (!isset($_GET['productId']) || $_GET['productId'] == NULL) {
	echo "<script>window.location='./notfound/404.html';</script>";
} else {
	$productId = $_GET['productId'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
	$quantity = $_POST['quantity'];
	$customerId = Session::get('customerId');
	// var_dump($customerId);
	$addToCart = $cart->addToCart($productId, $quantity, $customerId);
}

?>

<div class="main">
	<div class="content">
		<div class="section group">
			<?php
			$getProductDetails = $product->getProductDetails($productId);
			if ($getProductDetails) {
				while ($res = $getProductDetails->fetch_assoc()) {

			?>
					<div class="cont-desc span_1_of_2">
						<div class="grid images_3_of_2">
							<img src="./admin/uploads/<?php echo $res['productImage']; ?>" alt="" />
						</div>
						<div class="desc span_3_of_2">
							<h2><?php echo $res['productName']; ?> </h2>
							<p><?php echo $fm->textShorten($res['productDesc'], 100); ?> </p>
							<div class="price">
								<p>Price: <span><?php echo $res['productPrice'] . " VND"; ?> </span></p>
								<p>Category: <span><?php echo $cat->getCatbyId($res['productCategory'])->fetch_assoc()['catName']; ?></span></p>
								<p>Brand:<span><?php echo $brand->getBrandbyId($res['productBrand'])->fetch_assoc()['brandName']; ?></span></p>
							</div>
							<div class="add-cart">
								<form action="" method="post">
									<input type="number" class="buyfield" name="quantity" value="1" min="1" />
									<input type="submit" class="buysubmit" name="submit" value="Buy Now" />
								</form>
							</div>
						</div>
						<div class="product-desc">
							<h2>Product Details</h2>
							<p><?php echo $res['productDesc']; ?> </p>
						</div>

					</div>

			<?php
				}
			} else {
				//echo "<script>window.location='catlist.php';</script>"; // id none exist
				echo "<script>window.location='./notfound/404.html';</script>";
			}
			?>

			<div class="rightsidebar span_3_of_1">
				<h2>CATEGORIES</h2>
				<ul>
					<?php $showCategory = $cat->show_category();
					if ($showCategory) {
						while ($res = $showCategory->fetch_assoc()) { ?>
							<li><a href="productbycat.php?catId=<?php echo $res['catId'] ?>"><?php echo $res['catName'] ?></a></li>
					<?php
						}
					} ?>

				</ul>

			</div>

		</div>
	</div>
	<?php
	include "./inc/footer.php";
	?>