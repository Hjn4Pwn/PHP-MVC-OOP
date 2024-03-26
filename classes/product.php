<?php
// include_once "../lib/session.php";
include_once "../lib/database.php";
include_once "../helpers/format.php";

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

    public function update_product($productName, $productId)
    {
        $productName = $this->fm->validation($productName);
        $productId = $this->fm->validation($productId);

        $productName = mysqli_real_escape_string($this->db->conn, $productName);
        $productId = mysqli_real_escape_string($this->db->conn, $productId);


        if (empty($productName)) {
            $alert = "<span class='error'>Product name must be not empty</span>";
            return $alert;
        } else {
            $query = "UPDATE tbl_product SET productName=? WHERE productId=? ";
            $params = array($productName, $productId);
            $types = 'si';

            $result = $this->db->executeQuery($query, $params, $types);

            if ($result) {
                $alert = "<span class='success'>Update Product Successfully</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Update Product Failed</span>";
                return $alert;
            }
        }
    }


    public function update_product_($data, $files, $id)
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

    public function delete_product($id)
    {
        $query = "DELETE FROM tbl_product WHERE productId=?";
        $params = array($id);
        $types = 'i';
        $result = $this->db->executeQuery($query, $params, $types);
        return $result;
    }
}
