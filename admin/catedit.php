<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/category.php';
?>

<?php
$cat = new category();

if (!isset($_GET['catId']) || $_GET['catId'] == NULL) {
    echo "<script>window.location='catlist.php';</script>";
} else {
    $id = $_GET['catId'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $catName = $_POST["catName"];
    $updateCat = $cat->update_category($catName, $id);
}

?>

<div class="grid_10">
    <div class="box round first grid">
        <h2>Edit Category</h2>
        <div class="block copyblock">
            <!-- Bỏ action=catedit.php vì nếu thêm vào nó sẽ không mang theo cái Id => lỗi -->
            <form action="" method="post">
                <?php
                if (isset($updateCat)) {
                    echo $updateCat;
                }
                ?>

                <?php
                $getCateName = $cat->getCatbyId($id);
                if ($getCateName) {
                    $result = $getCateName->fetch_assoc();
                ?>
                    <table class="form">
                        <tr>
                            <td>
                                <input type="text" value=<?php echo $result['catName']; ?> name="catName" placeholder="Edit Category Name..." class="medium" />
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
                    //echo "<script>window.location='catlist.php';</script>"; // id none exist
                    echo "<script>window.location='../notfound/404.html';</script>";
                }
                ?>
            </form>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>