<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/brand.php';
?>

<?php
$brand = new brand();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $brandName = $_POST["brandName"];
    $insertBrand = $brand->insert_brand($brandName);
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Add New Brand</h2>
        <div class="block copyblock">
            <form action="brandadd.php" method="post">
                <?php
                if (isset($insertBrand)) {
                    echo $insertBrand;
                }
                ?>
                <table class="form">
                    <tr>
                        <td>
                            <input type="text" name="brandName" placeholder="Enter Brand Name..." class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" name="submit" Value="Save" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>