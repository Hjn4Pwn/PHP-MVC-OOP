<?php
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/category.php';
include "../classes/cart.php";
include "../classes/product.php";
?>

<?php
$cart = new cart();
$product = new product();

if (!isset($_GET['customerId']) || $_GET['customerId'] == NULL) {
    echo "<script>window.location='inbox.php';</script>";
} else {
    $customerId = $_GET['customerId'];
}

$checkOrderStatus = $cart->checkOrderStatus($customerId);

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['ship'])) {
    $updateOrderStatus = $cart->updateOrderStatus($customerId);
} else {
    $updateOrderStatus = 0;
}

?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Order Details</h2>
        <form action="" method="post">
            <div>
                <table class="tblone">
                    <tr>
                        <th width="30%">Product Name</th>
                        <th width="15%">Image</th>
                        <th width="5%">Quantity</th>
                        <th width="20%">Price</th>
                        <th width="25%">Time</th>
                    </tr>
                    <?php
                    $getOrderDetails = $cart->getOrderDetails($_GET['customerId']);
                    $noVatTotal = 0;
                    $total = 0;
                    if ($getOrderDetails) {
                        while ($res = $getOrderDetails->fetch_assoc()) {
                            $getproductbyId = $product->getproductbyId($res['productId'])->fetch_assoc();
                    ?>
                            <tr>
                                <td style="text-align: center;"><?php echo $getproductbyId['productName'] ?></td>
                                <td style="text-align: center;"><img style="height: 30px; padding-top: 5px" src="../admin/uploads/<?php echo $getproductbyId['productImage']; ?>" alt=""></td>
                                <td style="text-align: center;"><?php echo $res['quantity']; ?> </td>
                                <td style="text-align: center;"><?php
                                                                $noVatTotal += $res['price'];
                                                                echo $res['price'] . " VND";
                                                                ?></td>
                                <td style="text-align: center;"><?php echo $res['time']; ?></td>
                            </tr>
                    <?php
                        }
                    } else {
                        //echo "<script>window.location='catlist.php';</script>"; // id none exist
                        echo "<script>window.location='../notfound/404.html';</script>";
                    }
                    ?>

                </table>

                <table style="float:right; text-align:left; margin: 20px 0; font-size: 20px; " width="700px">
                    <tr>
                        <th>Sub Total : </th>
                        <td><?php echo ($getOrderDetails) ? $noVatTotal . " VND" : "0 VND"; ?></td>
                    </tr>
                    <tr>
                        <th>VAT : </th>
                        <!-- 0.05% -->
                        <td><?php echo "5%"; ?></td>
                    </tr>
                    <tr>
                        <th>Grand Total :</th>
                        <td><?php echo ($getOrderDetails) ? $noVatTotal * 1.05 . " VND" : "0 VND"; ?></td>
                    </tr>

                    <tr>
                        <th>Status :</th>
                        <td>
                            <?php
                            if ($checkOrderStatus) {
                                echo '<div style="font-size: 30px; margin-top: 20px; color: green; font-weight:600;">Shipped</div>';
                            ?>
                        </td>
                    <?php
                            } else {
                                echo '<div style="font-size: 30px; margin-top: 20px; color: red; font-weight:600;">	Processing...</div>';
                    ?>
                        </td>
                    <?php
                            }
                    ?>
                    </tr>

                    <tr>
                        <th></th>
                        <td>
                            <input style="font-size: 20px; margin-top: 30px; cursor: pointer;
                                    width: 90px; height: 40px; font-weight: 600; color: #2E5E79;" type="submit" name="ship" value="Ship" />
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
</div>
<?php include 'inc/footer.php'; ?>