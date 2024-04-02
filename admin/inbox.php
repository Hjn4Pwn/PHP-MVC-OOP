<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>

<?php
include "../classes/cart.php";
include "../classes/product.php";

?>

<?php
$cart = new cart();

if (isset($_GET['deleteCustomerOrder']) && $_GET['deleteCustomerOrder'] != NULL) {
	// var_dump($_GET['deleteCustomerOrder']);
	$cart->deleteCustomerOrder($_GET['deleteCustomerOrder']);
}
?>

<div class="grid_10">
	<div class="box round first grid">
		<h2>Inbox</h2>
		<div class="block">
			<table class="data display datatable" id="example">
				<thead>
					<tr>
						<th>Serial No.</th>
						<th>Customer Name</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$cart = new cart();
					$getNameCustomerCart = $cart->getCustomerName();
					$i = 0;
					if ($getNameCustomerCart) {
						while ($res = $getNameCustomerCart->fetch_assoc()) {
					?>
							<tr class="odd gradeX">
								<td><?php echo ++$i; ?></td>
								<td><?php echo $res['customerName'] ?></td>
								<td>
									<a href="orderView.php?customerId=<?php echo $res['customerId']; ?>">View</a>
									||
									<a onclick="confirmDelete(<?php echo $res['customerId']; ?>)" href="#">Delete</a>
								</td>
								<!-- dùng href= # -->
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
	function confirmDelete($customerId) {
		var confirmDelete = confirm("Are you serious?");
		if (confirmDelete) {
			// Nếu người dùng nhấp vào OK, thực hiện hành động xóa
			window.location.href = "?deleteCustomerOrder=" + $customerId;
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