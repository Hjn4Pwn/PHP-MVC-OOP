<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/brand.php'; ?>


<?php
$brand = new brand();

if (isset($_GET['deleteBrandId']) && $_GET['deleteBrandId'] != NULL) {
    $deleteBrandId = $_GET['deleteBrandId'];
    $deleteBrand = $brand->delete_brand($deleteBrandId);
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Brand List</h2>
        <div class="block">
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>Serial No.</th>
                        <th>Brand Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $show_brand = $brand->show_brand();
                    if ($show_brand) {
                        $i = 0;
                        while ($result = $show_brand->fetch_assoc()) {
                            $i++;
                    ?>
                            <tr class="odd gradeX">
                                <td> <?php echo $i; ?> </td>
                                <td><?php echo $result['brandName']; ?> </td>
                                <td><a href="brandedit.php?brandId=<?php echo $result['brandId'] ?>">Edit</a> || <a onclick="confirmDelete(<?php echo $result['brandId'] ?>)" href="#">Delete</a></td>
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
    function confirmDelete(brandId) {
        var confirmDelete = confirm("Are you serious?");
        if (confirmDelete) {
            // Nếu người dùng nhấp vào OK, thực hiện hành động xóa
            window.location.href = "?deleteBrandId=" + brandId;
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