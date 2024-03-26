<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/brand.php';
?>

<?php
// CHECK LOGIN ADMIN
$brand = new brand();

if (!isset($_GET['brandId']) || $_GET['brandId'] == NULL) {
    echo "<script>window.lobrandion='brandlist.php';</script>";
} else {
    $id = $_GET['brandId'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $brandName = $_POST["brandName"];
    $updateBrand = $brand->update_brand($brandName, $id);
}

?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Edit Brand</h2>
        <div class="block copyblock">
            <!-- Bỏ action=brandedit.php vì nếu thêm vào nó sẽ không mang theo cái Id => lỗi -->
            <form action="" method="post">
                <?php
                if (isset($updateBrand)) {
                    echo $updateBrand;
                }
                ?>

                <?php
                $getbrandeName = $brand->getbrandbyId($id);
                if ($getbrandeName) {
                    $result = $getbrandeName->fetch_assoc();
                ?>
                    <table class="form">
                        <tr>
                            <td>
                                <input type="text" value=<?php echo $result['brandName']; ?> name="brandName" placeholder="Edit brand Name..." class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="submit" name="submit" Value="Edit" />
                            </td>
                        </tr>
                    </table>

                <?php
                } else {
                    echo "<script>window.location='brandlist.php';</script>"; // id none exist
                }
                ?>
            </form>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>