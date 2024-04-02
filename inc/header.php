<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/web_php/shop/" . "lib/session.php";
Session::init();
?>

<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/web_php/shop/" . "lib/database.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/web_php/shop/" . "helpers/format.php";
?>

<?php

spl_autoload_register(function ($className) {
    include_once "classes/" . $className . ".php";
});

$db = new Database();
$cart = new cart();
$user = new user();
$fm = new Format();
$cat = new category();
$brand = new brand();
$product = new product();
$customer = new customer()

?>

<?php

if (isset($_GET['customerId'])) {
    Session::destroy();
}
?>

<?php

?>


<!DOCTYPE HTML>

<head>
    <title>Store Website</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <script src="js/jquerymain.js"></script>
    <script src="js/script.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="js/nav.js"></script>
    <script type="text/javascript" src="js/move-top.js"></script>
    <script type="text/javascript" src="js/easing.js"></script>
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link href="css/menu.css" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript" src="js/nav-hover.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
    <script type="text/javascript">
        $(document).ready(function($) {
            $('#dc_mega-menu-orange').dcMegaMenu({
                rowItems: '4',
                speed: 'fast',
                effect: 'fade'
            });
        });
    </script>
</head>

<body>
    <div class="wrap">
        <div class="header_top">
            <div class="logo">
                <a href="index.php"><img src="images/logo.png" alt="" /></a>
            </div>
            <div class="header_top_right">
                <div class="search_box">
                    <form>
                        <input type="text" value="Search for Products" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search for Products';}"><input type="submit" value="SEARCH">
                    </form>
                </div>
                <div class="shopping_cart" style="width: 155px; margin-left:60px;">
                    <div class="cart" style="padding: 0; ">
                        <a style="text-decoration: none; text-align:center;" href="cart.php" title="View my shopping cart" rel="nofollow">
                            <div class="cartTitle">Cart</div>
                            <!-- empty -->
                            <!-- <span class="no_product"></span> -->
                        </a>
                    </div>
                </div>
                <div class="login"><a href="login.php">
                        <?php
                        if (Session::get('customerLogin')) {
                            echo '<a href="?customerId=' . Session::get('customerId') . '">Logout</a>';
                        } else {
                            echo "<a href='login.php'>Login</a>";
                        }
                        ?>
                    </a></div>
                <div style="
                    height: 36px;
                    font-size: 16px;
                    text-align: center;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    color: #a86ddd;
                    font-weight: 600;
                ">
                    <?php
                    if (Session::get('customerLogin')) {
                        $res = $customer->getCustomerInfo(Session::get('customerId'))->fetch_assoc();
                        echo $res['name'];
                    } else {
                        echo "";
                    }
                    ?>
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="menu">
            <ul id="dc_mega-menu-orange" class="dc_mm-orange">
                <li><a href="index.php">Home</a></li>
                <li><a href="products.php">Products</a> </li>
                <li><a href="topbrands.php">Top Brands</a></li>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="oderDetails.php">Order Details</a></li>
                <li><a href="contact.php">Contact</a> </li>
                <div class="clear"></div>
            </ul>
        </div>