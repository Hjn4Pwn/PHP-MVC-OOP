<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/brand.php'; ?>
<?php include '../classes/category.php'; ?>
<?php include '../classes/product.php'; ?>

<?php
$product = new product();

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
    $insertProduct = $product->insert_product($_POST, $_FILES);
}
?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Add New Product</h2>
        <div class="block">
            <form action="productadd.php" method="post" enctype="multipart/form-data">
                <?php
                if (isset($insertProduct)) {
                    echo $insertProduct;
                }
                ?>
                <table class="form">

                    <tr>
                        <td>
                            <label>Name</label>
                        </td>
                        <td>
                            <input type="text" name="productName" placeholder="Enter Product Name..." class="medium" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Category</label>
                        </td>
                        <td>
                            <select id="select" name="productCategory">
                                <option>Select Category</option>
                                <?php
                                $cat = new category();
                                $show_cat = $cat->show_category();
                                if ($show_cat) {
                                    while ($result = $show_cat->fetch_assoc()) {
                                ?>
                                        <option value="<?php echo $result['catId']; ?>"><?php echo $result['catName']; ?></option>
                                <?php
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
                            <select id="select" name="productBrand">
                                <option>Select Brand</option>
                                <?php
                                $brand = new brand();
                                $show_brand = $brand->show_brand();
                                if ($show_brand) {
                                    while ($result = $show_brand->fetch_assoc()) {
                                ?>
                                        <option value="<?php echo $result['brandId']; ?>"><?php echo $result['brandName']; ?></option>
                                <?php
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
                            <textarea style="height:50px; width: 285px;" name="productDesc"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Price</label>
                        </td>
                        <td>
                            <input type="text" name="productPrice" placeholder="Enter Price..." class="medium" />
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>Upload Image</label>
                        </td>
                        <td>
                            <input type="file" name="productImage" />
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label>Product Type</label>
                        </td>
                        <td>
                            <select id="select" name="productType">
                                <option>Select Type</option>
                                <option value="1">Featured</option>
                                <option value="2">Non-Featured</option>
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