<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/web_php/shop/" . "lib/database.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/web_php/shop/" . "helpers/format.php";
?>

<?php

class cart
{
    private $db;
    private $fm; //format
    private $product;
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
        $this->product = new product();
    }

    public function addToCart($cartProductId, $cartQuantity, $customerId)
    {
        $cartQuantity = $this->fm->validation($cartQuantity);
        $cartQuantity = mysqli_real_escape_string($this->db->conn, $cartQuantity);
        $cartProductId = mysqli_real_escape_string($this->db->conn, $cartProductId);

        $getProduct = $this->product->getProductbyId($cartProductId);
        if ($getProduct) {
            $productDetails = $getProduct->fetch_assoc();
        }
        // print_r($productDetails);
        $cartProductName = $productDetails['productName'];
        $cartPrice = $productDetails['productPrice'];
        $cartProductImage = $productDetails['productImage'];

        // check exist product in user's cart
        $query = "SELECT * FROM tbl_cart WHERE customerId = ? AND cartProductId=?";
        $params = array($customerId, $cartProductId);
        $types = "ii";
        $check = $this->db->executeSelect($query, $params, $types);

        if ($check) {
            $checkResult = $check->fetch_assoc();

            $existQuantity = $checkResult['cartQuantity'];
            $updateQuantity = $existQuantity + $cartQuantity;

            $query = "UPDATE tbl_cart SET cartQuantity=? WHERE customerId = ? AND cartProductId=?";
            $params = array($updateQuantity, $customerId, $cartProductId);
            $types = "iii";

            $result = $this->db->executeQuery($query, $params, $types);
        }
        // 
        else {

            $query = "INSERT INTO tbl_cart (cartProductId, customerId, cartProductName, cartPrice, cartQuantity, cartProductImage) 
            VALUES (?, ?, ?, ?, ?, ?) ";
            $params = array($cartProductId, $customerId, $cartProductName, $cartPrice, $cartQuantity, $cartProductImage);
            $types = 'iisiis';

            $result = $this->db->executeQuery($query, $params, $types);
        }

        if ($result) {
            header('Location:cart.php');
        } else {
            header('Location:notfound/404.html');
        }
    }
    public function getProductCart($customerId)
    {
        $query = "SELECT * FROM tbl_cart WHERE customerId = ?";
        $params = array($customerId);
        $types = "i";
        $result = $this->db->executeSelect($query, $params, $types);
        return $result;
    }

    public function updateQuantity($cartIdUpdate, $cartQuantity)
    {
        if ($cartQuantity == 0) {
            return $this->deleteProductCart($cartIdUpdate);
        }
        $query = "UPDATE tbl_cart SET cartQuantity=? WHERE cartId=?";
        $params = array($cartQuantity, $cartIdUpdate);
        $types = "ii";
        $result = $this->db->executeQuery($query, $params, $types);
        return $result;
    }
    public function deleteProductCart($deleteCartId)
    {
        $query = "DELETE FROM tbl_cart WHERE cartId=?";
        $params = array($deleteCartId);
        $types = 'i';
        $result = $this->db->executeQuery($query, $params, $types);
        return $result;
    }

    public function deleteAllSession()
    {
    }
}
