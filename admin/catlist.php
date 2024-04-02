<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/category.php'; ?>


<?php
$cat = new category();

if (isset($_GET['deleteCatId']) && $_GET['deleteCatId'] != NULL) {
	$deleteCatId = $_GET['deleteCatId'];
	$deleteCat = $cat->delete_category($deleteCatId);
}
?>

<div class="grid_10">
	<div class="box round first grid">
		<h2>Category List</h2>
		<div class="block">
			<table class="data display datatable" id="example">
				<thead>
					<tr>
						<th>Serial No.</th>
						<th>Category Name</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>

					<?php
					$showCat = $cat->show_category();
					if ($showCat) {
						$i = 0;
						while ($result = $showCat->fetch_assoc()) {
							$i++;
					?>
							<tr class="odd gradeX">
								<td> <?php echo $i; ?> </td>
								<td><?php echo $result['catName']; ?> </td>
								<td><a href="catedit.php?catId=<?php echo $result['catId']; ?>">Edit</a> || <a onclick="confirmDelete(<?php echo $result['catId']; ?>)" href="#">Delete</a></td>
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
	function confirmDelete(catId) {
		var confirmDelete = confirm("Are you serious?");
		if (confirmDelete) {
			// Nếu người dùng nhấp vào OK, thực hiện hành động xóa
			window.location.href = "?deleteCatId=" + catId;
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