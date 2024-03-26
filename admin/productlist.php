<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/brand.php'; ?>
<?php include '../classes/category.php'; ?>
<?php include '../classes/product.php'; ?>
<?php include_once '../helpers/format.php'; ?>

<?php
$product = new product();

if (isset($_GET['deleteProductId']) && $_GET['deleteProductId'] != NULL) {
	$deleteProductId = $_GET['deleteProductId'];
	$deleteProduct = $product->delete_product($deleteProductId);
}
?>

<div class="grid_10">
	<div class="box round first grid">
		<h2>Post List</h2>
		<div class="block">
			<table class="data display datatable" id="example">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Category</th>
						<th>Brand</th>
						<th>Description</th>
						<th>Type</th>
						<th>Image</th>
						<th>Price</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$product = new product();
					$fm = new Format();
					$category = new category();
					$brand = new brand();

					$listProduct = $product->show_product();
					if ($listProduct) {
						$i = 0;
						while ($result = $listProduct->fetch_assoc()) {
							$i++;

					?>
							<tr class="odd gradeX">
								<td><?php echo $i; ?></td>
								<td><?php echo $result['productName']; ?></td>
								<td><?php echo $category->getCatbyId($result['productCategory'])->fetch_assoc()['catName']; ?></td>
								<td><?php echo $brand->getBrandbyId($result['productBrand'])->fetch_assoc()['brandName']; ?></td>
								<td><?php echo $fm->textShorten($result['productDesc'], 50); ?></td>
								<td><?php echo ($result['productType'] == 1) ? "Featured" : "Non-Featured"; ?></td>
								<td style="text-align:center;"><img style="height: 60px; padding-top:10px" src="uploads/<?php echo $result['productImage']; ?>" alt="productImage"></td>
								<td class="center"> <?php echo $result['productPrice']; ?></td>
								<td><a href="productedit.php?productId=<?php echo $result['productId'] ?>">Edit</a> || <a onclick="confirmDelete(<?php echo $result['productId'] ?>)" href="#">Delete</a></td>
							</tr>

					<?php
						}
					}
					?>

				</tbody>
			</table>

		</div>
	</div>
</div>
<script>
	function confirmDelete(productId) {
		var confirmDelete = confirm("Are you serious?");
		if (confirmDelete) {
			// Nếu người dùng nhấp vào OK, thực hiện hành động xóa
			window.location.href = "?deleteProductId=" + productId;
		} else {
			//    
		}
	}
</script>
<script type="text/javascript">
	$(document).ready(function() {
		setupLeftMenu();
		$('.datatable').dataTable();
		setSidebarHeight();
	});
</script>
<?php include 'inc/footer.php'; ?>