<?php
include "./inc/header.php";
include "./inc/slider.php";
?>

<?php
if (!isset($_GET['catId']) || $_GET['catId'] == NULL) {
	echo "<script>window.location='./notfound/404.html';</script>";
} else {
	$id = $_GET['catId'];
	$showProductbyCatId = $product->showProductbyCatId($id);
}
?>

<div class="main">
	<div class="content">
		<div class="content_top">
			<div class="heading">
				<h3>Category: <?php echo $cat->getCatbyId($id)->fetch_assoc()['catName']; ?></h3>
			</div>
			<div class="clear"></div>
		</div>
		<div class="section group">
			<?php
			if ($showProductbyCatId) {
				while ($res = $showProductbyCatId->fetch_assoc()) {
			?>
					<div class="grid_1_of_4 images_1_of_4">
						<a href="preview-3.php"><img src="./admin/uploads/<?php echo $res['productImage']; ?>" alt="" /></a>
						<h2><?php echo $res['productName'] ?></h2>
						<p><?php echo $fm->textShorten($res['productDesc'], 70) ?></p>
						<p><span class=" price"><?php echo $res['productPrice'] . " VND"; ?></span></p>
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