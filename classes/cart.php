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

    public function addToCart($cartProductId, $cartQuantity)
    {
        $cartQuantity = $this->fm->validation($cartQuantity);
        $cartQuantity = mysqli_real_escape_string($this->db->conn, $cartQuantity);
        $cartProductId = mysqli_real_escape_string($this->db->conn, $cartProductId);
        $sId = session_id();

        $getProduct = $this->product->getProductbyId($cartProductId);
        if ($getProduct) {
            $productDetails = $getProduct->fetch_assoc();
        }
        // print_r($productDetails);
        $cartProductName = $productDetails['productName'];
        $cartPrice = $productDetails['productPrice'];
        $cartProductImage = $productDetails['productImage'];

        // check exist product in user's cart
        $query = "SELECT * FROM tbl_cart WHERE sId = ? AND cartProductId=?";
        $params = array($sId, $cartProductId);
        $types = "si";
        $check = $this->db->executeSelect($query, $params, $types);

        if ($check) {
            $checkResult = $check->fetch_assoc();

            $existQuantity = $checkResult['cartQuantity'];
            $updateQuantity = $existQuantity + $cartQuantity;

            $query = "UPDATE tbl_cart SET cartQuantity=? WHERE sId = ? AND cartProductId=?";
            $params = array($updateQuantity, $sId, $cartProductId);
            $types = "isi";

            $result = $this->db->executeQuery($query, $params, $types);
        }
        // 
        else {

            $query = "INSERT INTO tbl_cart (cartProductId, sId, cartProductName, cartPrice, cartQuantity, cartProductImage) 
            VALUES (?, ?, ?, ?, ?, ?) ";
            $params = array($cartProductId, $sId, $cartProductName, $cartPrice, $cartQuantity, $cartProductImage);
            $types = 'issiis';

            $result = $this->db->executeQuery($query, $params, $types);
        }

        if ($result) {
            header('Location:cart.php');
        } else {
            header('Location:notfound/404.html');
        }
    }
    public function getProductCart()
    {
        $sId = session_id();
        $query = "SELECT * FROM tbl_cart WHERE sId = ?";
        $params = array($sId);
        $types = "s";
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
}
