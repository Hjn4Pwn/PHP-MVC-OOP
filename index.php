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
// echo session_id();
?>

<div class="main">
	<div class="content">
		<div class="content_top">
			<div class="heading">
				<h3>Feature Products</h3>
			</div>
			<div class="clear"></div>
		</div>

		<div class="section group">
			<?php
			$productFeatured = $product->getproductType(1);
			if ($productFeatured) {
				while ($res = $productFeatured->fetch_assoc()) {
			?>
					<div class="grid_1_of_4 images_1_of_4">
						<a href="details.php"><img src="./admin/uploads/<?php echo $res['productImage']; ?>" alt="" /></a>
						<h2><?php echo $res['productName']; ?></h2>
						<p><?php echo $fm->textShorten($res['productDesc'], 70) ?></p>
						<p><span class="price"><?php echo $res['productPrice'] . " VND"; ?></span></p>
						<div class="button"><span><a href="details.php?productId=<?php echo $res['productId'] ?>" class="details">Details</a></span></div>
					</div>
			<?php
				}
			}
			?>
		</div>
		<div class="content_bottom">
			<div class="heading">
				<h3>New Products</h3>
			</div>
			<div class="clear"></div>
		</div>
		<div class="section group">
			<?php
			$productFeatured = $product->getNewProduct();
			if ($productFeatured) {
				while ($res = $productFeatured->fetch_assoc()) {
			?>
					<div class="grid_1_of_4 images_1_of_4">
						<a href="details.php"><img src="./admin/uploads/<?php echo $res['productImage']; ?>" alt="" /></a>
						<h2><?php echo $res['productName']; ?></h2>
						<p><?php echo $fm->textShorten($res['productDesc'], 70) ?></p>
						<p><span class="price"><?php echo $res['productPrice'] . " VND"; ?></span></p>
						<div class="button"><span><a href="details.php?productId=<?php echo $res['productId'] ?>" class="details">Details</a></span></div>
					</div>
			<?php
				}
			}
			?>
		</div>
	</div>
</div>

<?php
include "./inc/footer.php";
?>