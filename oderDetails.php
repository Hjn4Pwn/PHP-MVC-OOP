<?php
include "./inc/header.php";
// include "./inc/slider.php";
?>

<?php
if (!Session::get('customerLogin')) {
    header('Location:login.php');
}
?>

<?php

if (isset($_GET['orderId']) and $_GET['orderId'] == "order") {
    $customerId = Session::get("customerId");

    if (!$cart->checkEmpty($customerId)) {
        echo '<center style="font-size: 30px; margin-top: 20px; color: red; font-weight:600;">Empty cart!!!</center>';
    } else {

        $insertOrder = $cart->insertOrder($customerId);
        $cart->deleteCart($customerId);
        header("Location:successOrder.html");
    }
}
?>

<style>
    .box_left {
        width: 100%;
        border: 1px solid #666;
    }
</style>



<div class="main">
    <div class="content">
        <div class="content_top">
            <div class="heading">
                <h3>Order Details</h3>
            </div>
            <div class="clear"></div>
        </div>
        <div class="section group" style="margin-top: 30px;">
            <div class="box_left">
                <div class="cartoption">
                    <div>
                        <h2 style="font-size: 25px; margin: 8px 8px; ">Your orders</h2>
                        <table class="tblone">
                            <tr>
                                <th width="25%">Product Name</th>
                                <th width="25%">Image</th>
                                <th width="5%">Quantity</th>
                                <th width="20%">Price</th>
                                <th width="25%">Time</th>
                            </tr>
                            <?php
                            $getOrderDetails = $cart->getOrderDetails(Session::get('customerId'));

                            $noVatTotal = 0;
                            $total = 0;
                            if ($getOrderDetails) {
                                while ($res = $getOrderDetails->fetch_assoc()) {
                                    $getproductbyId = $product->getproductbyId($res['productId'])->fetch_assoc();
                            ?>
                                    <tr>
                                        <td><?php echo $getproductbyId['productName'] ?></td>
                                        <td><img style="height: 30px; padding-top: 5px" src="admin/uploads/<?php echo $getproductbyId['productImage']; ?>" alt=""></td>
                                        <td><?php echo $res['quantity']; ?> </td>
                                        <td><?php
                                            $noVatTotal += $res['price'];
                                            echo $res['price'] . " VND";
                                            ?></td>
                                        <td><?php echo $res['time']; ?></td>
                                    </tr>
                            <?php
                                }
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
                                    $checkOrderStatus = $cart->checkOrderStatus(Session::get('customerId'));
                                    // var_dump($checkOrderStatus);
                                    if ($checkOrderStatus) {
                                        echo '<div style="font-size: 30px; margin-top: 20px; color: green; font-weight:600;">Shipped</div>';
                                    ?>
                                </td>
                            <?php
                                    } else {
                                        echo '<div style="font-size: 30px; margin-top: 20px; color: red; font-weight:600;">Processing...</div>';
                            ?>
                                </td>
                            <?php
                                    }
                            ?>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <?php
        include "./inc/footer.php";
        ?>