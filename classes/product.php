<?php
// include_once $_SERVER['DOCUMENT_ROOT'] . "/web_php/shop/" . "lib/session.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/web_php/shop/" . "lib/database.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/web_php/shop/" . "helpers/format.php";

?>

<?php

class product
{
    private $db;
    private $fm; //format
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function insert_product($data, $files)
    {
        // var_dump($data);
        $productName = mysqli_real_escape_string($this->db->conn, $data['productName']);
        $productCategory = mysqli_real_escape_string($this->db->conn, $data['productCategory']);
        $productBrand = mysqli_real_escape_string($this->db->conn, $data['productBrand']);
        $productDesc = mysqli_real_escape_string($this->db->conn, $data['productDesc']);
        $productPrice = mysqli_real_escape_string($this->db->conn, $data['productPrice']);
        $productType = mysqli_real_escape_string($this->db->conn, $data['productType']);

        // xử lý ảnh, đổi tên thành hash sha256 + ext
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $imageName = $files['productImage']['name'];
        $imageSize = $files['productImage']['size'];
        $imageTemp = $files['productImage']['tmp_name'];

        $div = explode('.', $imageName);
        $imageExtension = strtolower(end($div));
        // $uniqueImage = substr(hash('sha256', time()), 0, 10) . '.' . $imageExtension;
        $uniqueImage = substr(hash('sha256', time()), 0, 10) . '.' . $imageExtension;
        $uploadImage = "uploads/" . $uniqueImage;

        move_uploaded_file($imageTemp, $uploadImage);

        if (empty($productName) || empty($productCategory) || empty($productBrand) || empty($productDesc) || empty($productPrice) || empty($productType) || empty($imageName)) {
            $alert = "<span class='error'>Fields must be not empty</span>";
            return $alert;
        } else {
            // về sau sẽ update lên PDO hoặc prepare query
            $query = "INSERT INTO tbl_product (productName, productCategory, productBrand, productDesc, productType, productPrice, productImage) 
                      VALUES (?, ?, ?, ?, ?, ?, ?) ";
            $params = array($productName, $productCategory, $productBrand, $productDesc, $productType, $productPrice, $uniqueImage);
            $types = 'siisiss';

            $result = $this->db->executeQuery($query, $params, $types);

            if ($result) {
                $alert = "<span class='success'>Insert Product Successfully</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Insert Product Failed</span>";
                return $alert;
            }
        }
    }

    public function show_product()
    {
        $query = "SELECT * FROM tbl_product ORDER BY productId DESC";
        $result = $this->db->executeSelect($query, array());
        return $result;
    }


    public function update_product($data, $files, $id)
    {
        // return var_dump($data);
        $productId = mysqli_real_escape_string($this->db->conn, $id);
        $productName = mysqli_real_escape_string($this->db->conn, $data['productName']);
        $productCategory = mysqli_real_escape_string($this->db->conn, $data['productCategory']);
        $productBrand = mysqli_real_escape_string($this->db->conn, $data['productBrand']);
        $productDesc = mysqli_real_escape_string($this->db->conn, $data['productDesc']);
        $productPrice = mysqli_real_escape_string($this->db->conn, $data['productPrice']);
        $productType = mysqli_real_escape_string($this->db->conn, $data['productType']);

        // xử lý ảnh, đổi tên thành hash sha256 + ext
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $imageName = $files['productImage']['name'];
        $imageSize = $files['productImage']['size'];
        $imageTemp = $files['productImage']['tmp_name'];

        $div = explode('.', $imageName);
        $imageExtension = strtolower(end($div));
        // $uniqueImage = substr(hash('sha256', time()), 0, 10) . '.' . $imageExtension;
        $uniqueImage = substr(hash('sha256', time()), 0, 10) . '.' . $imageExtension;
        $uploadImage = "uploads/" . $uniqueImage;

        move_uploaded_file($imageTemp, $uploadImage);

        if (empty($productName) || empty($productCategory) || empty($productBrand) || empty($productDesc) || empty($productPrice) || empty($productType) || empty($imageName)) {
            $alert = "<span class='error'>Fields must be not empty</span>";
            return $alert;
        } else {
            // về sau sẽ update lên PDO hoặc prepare query
            $query = "UPDATE tbl_product SET productName=?, productCategory=?, productBrand=?, productDesc=?, productType=?, productPrice=?, productImage=? 
                      WHERE productId=? ";
            $params = array($productName, $productCategory, $productBrand, $productDesc, $productType, $productPrice, $uniqueImage, $productId);
            $types = 'siisissi';

            $result = $this->db->executeQuery($query, $params, $types);

            if ($result) {
                $alert = "<span class='success'>Insert Product Successfully</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Insert Product Failed</span>";
                return $alert;
            }
        }
    }


    public function getproductbyId($id)
    {
        $query = "SELECT * FROM tbl_product WHERE productId=?";
        $params = array($id);
        $types = 'i';
        $result = $this->db->executeSelect($query, $params, $types);
        return $result;
    }

    public function getproductType($type)
    {
        $query = "SELECT * FROM tbl_product WHERE productType=?";
        $params = array($type);
        $types = 'i';
        $result = $this->db->executeSelect($query, $params, $types);
        return $result;
    }

    public function getNewProduct()
    {
        $query = "SELECT * FROM tbl_product ORDER BY productId DESC LIMIT 4";
        $result = $this->db->executeSelect($query, array());
        return $result;
    }

    public function delete_product($id)
    {
        $query = "DELETE FROM tbl_product WHERE productId=?";
        $params = array($id);
        $types = 'i';
        $result = $this->db->executeQuery($query, $params, $types);
        return $result;
    }

    public function getProductDetails($id)
    {
        $query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName 
                  FROM tbl_product 
                  INNER JOIN tbl_category ON tbl_product.productCategory = tbl_category.catId 
                  INNER JOIN tbl_brand ON tbl_product.productBrand = tbl_brand.brandId
                  WHERE tbl_product.productId = ?";
        $params = array($id);
        $type = "i";
        $result = $this->db->executeSelect($query, $params, $type);
        return $result;
    }

    public function showProductbyCatId($productCategory)
    {
        $query = "SELECT * FROM tbl_product WHERE productCategory = ? ORDER BY productId DESC";
        $params = array($productCategory);
        $types = 'i';
        $result = $this->db->executeSelect($query, $params, $types);
        return $result;
    }
}
