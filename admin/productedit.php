<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/brand.php'; ?>
<?php include '../classes/category.php'; ?>
<?php include '../classes/product.php'; ?>

<?php
$product = new product();
$category = new category();
$brand = new brand();

if (!isset($_GET['productId']) || $_GET['productId'] == NULL) {
    echo "<script>window.location='productlist.php';</script>";
} else {
    $id = $_GET['productId'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
    $updateProduct = $product->update_product($_POST, $_FILES, $id);
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Add New Product</h2>
        <div class="block">
            <form action="" method="post" enctype="multipart/form-data">
                <?php
                if (isset($updateProduct)) {
                    echo $updateProduct;
                }
                ?>
                <table class="form">
                    <?php
                    $getProduct = $product->getProductbyId($id);
                    if ($getProduct) {
                        $result = $getProduct->fetch_assoc();
                    ?>
                        <tr>
                            <td>
                                <label>Name</label>
                            </td>
                            <td>
                                <input type="text" value="<?php echo $result['productName']; ?>" name="productName" placeholder="Enter Product Name..." class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Category</label>
                            </td>
                            <td>
                                <select id="select" value="" name="productCategory">
                                    <option value="<?php echo $result['productCategory']; ?>" selected><?php echo $category->getCatbyId($result['productCategory'])->fetch_assoc()['catName']; ?></option>
                                    <?php
                                    $show_cat = $category->show_category();
                                    if ($show_cat) {
                                        while ($resultCategory = $show_cat->fetch_assoc()) {
                                            // nếu trùng id với cái đã chọn trc thì k in ra, tránh bị lặp
                                            if ($resultCategory['catId'] != $result['productCategory']) {
                                    ?>
                                                <option value="<?php echo $resultCategory['catId']; ?>"><?php echo $resultCategory['catName']; ?></option>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Brand</label>
                            </td>
                            <td>
                                <select id="select" value="" name="productBrand">
                                    <option value="<?php echo $result['productBrand']; ?>" selected><?php echo $brand->getBrandbyId($result['productBrand'])->fetch_assoc()['brandName']; ?></option>
                                    <?php
                                    $show_brand = $brand->show_brand();
                                    if ($show_brand) {
                                        while ($resultBrand = $show_brand->fetch_assoc()) {
                                            // nếu trùng id với cái đã chọn trc thì k in ra, tránh bị lặp
                                            if ($resultBrand['brandId'] != $result['productBrand']) {
                                    ?>
                                                <option value="<?php echo $resultBrand['brandId']; ?>"><?php echo $resultBrand['brandName']; ?></option>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td style="vertical-align: top; padding-top: 9px;">
                                <label>Description</label>
                            </td>
                            <td>
                                <!-- class="tinymce" -->
                                <textarea style="height:50px; width: 285px;" value="" name="productDesc"><?php echo $result['productDesc']; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Price</label>
                            </td>
                            <td>
                                <input type="text" value="<?php echo $result['productPrice']; ?>" name="productPrice" placeholder="Enter Price..." class="medium" />
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label>Upload Image</label>
                            </td>
                            <td>
                                <input type="file" value="" name="productImage" />
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label>Product Type</label>
                            </td>
                            <td>
                                <select id="select" value="" name="productType">
                                    <option value="<?php echo $result['productType'] ?>" selected><?php echo ($result['productType'] == 1) ? "Featured" : "Non-Featured"; ?></option>
                                    <?php
                                    if ($result['productType'] == 1) {
                                    ?>
                                        <option value="2">Non-Featured</option>
                                    <?php
                                    } else {
                                    ?>
                                        <option value="1">Featured</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <input type="submit" name="submit" Value="Save" />
                            </td>
                        </tr>
                </table>
            <?php
                    } else {
                        //echo "<script>window.location='catlist.php';</script>"; // id none exist
                        echo "<script>window.location='../notfound/404.html';</script>";
                    }
            ?>
            </form>
        </div>
    </div>
</div>
<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        setupTinyMCE();
        setDatePicker('date-picker');
        $('input[type="checkbox"]').fancybutton();
        $('input[type="radio"]').fancybutton();
    });
</script>
<!-- Load TinyMCE -->
<?php include 'inc/footer.php'; ?>