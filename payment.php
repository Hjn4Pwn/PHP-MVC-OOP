<?php
include "./inc/header.php";
// include "./inc/slider.php";
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
        width: 50%;
        border: 1px solid #666;
        float: left
    }

    .box_right {
        width: 45%;
        border: 1px solid #666;
        float: right
    }
</style>



<div class="main">
    <div class="content">
        <div class="content_top">
            <div class="heading">
                <h3>Payment</h3>
            </div>
            <div class="clear"></div>
        </div>
        <div class="section group" style="margin-top: 30px;">
            <div class="box_left">
                <div class="cartoption">
                    <div>
                        <h2 style="font-size: 25px; margin: 8px 8px; ">Your cart</h2>
                        <table class="tblone">
                            <tr>
                                <th width="30%">Product Name</th>
                                <th width="15%">Image</th>
                                <th width="20%">Price</th>
                                <th width="5%">Quantity</th>
                                <th width="20%">Total Price</th>
                            </tr>
                            <?php
                            $getProductCart = $cart->getProductCart(Session::get('customerId'));
                            if ($getProductCart) {
                                $total = 0;
                                while ($res = $getProductCart->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <td><?php echo $res['cartProductName'] ?></td>
                                        <td><img style="height: 30px; padding-top: 5px" src="admin/uploads/<?php echo $res['cartProductImage'] ?>" alt="" /></td>
                                        <td><?php echo $res['cartPrice'] . " VND" ?></td>
                                        <td><?php echo $res['cartQuantity'] ?> </td>
                                        <td><?php $totalPerProduct = $res['cartPrice'] * $res['cartQuantity'];
                                            $total += $totalPerProduct;
                                            echo $totalPerProduct . " VND"; ?></td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>


                        </table>
                        <table style="float:right;text-align:left;" width="40%">
                            <tr>
                                <th>Sub Total : </th>
                                <td><?php echo ($getProductCart) ? $total . " VND" : "0 VND"; ?></td>
                            </tr>
                            <tr>
                                <th>VAT : </th>
                                <!-- 0.5% -->
                                <td><?php echo ($getProductCart) ? $total * 0.005 . " VND" : "0 VND"; ?></td>
                            </tr>
                            <tr>
                                <th>Grand Total :</th>
                                <td><?php echo ($getProductCart) ? $total * 1.005 . " VND" : "0 VND"; ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="box_right">
                <div class="cartoption">
                    <div>
                        <h2 style="font-size: 25px; margin: 8px 8px; ">Your information</h2>
                        <table class="tblone">
                            <tr>
                                <th width="30%"></th>
                                <th width="70%"></th>
                            </tr>
                            <?php
                            $getCustomerInfo = $customer->getCustomerInfo(Session::get('customerId'));
                            if ($getCustomerInfo) {
                                while ($res = $getCustomerInfo->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <td>Name</td>
                                        <td><?php echo $res['name']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td><?php echo $res['email']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td><?php echo $res['phone']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Address</td>
                                        <td><?php echo $res['address']; ?></td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>


                        </table>
                    </div>
                </div>
                <center>
                    <div class="shopping">
                        <div class="shopright">
                            <a href="?orderId=order"> <img src="images/order.png" alt="" /></a>
                        </div>
                    </div>
                </center>
            </div>
        </div>
    </div>
</div>

<?php
include "./inc/footer.php";
?>