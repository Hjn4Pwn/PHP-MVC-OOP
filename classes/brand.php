<?php
// include_once $_SERVER['DOCUMENT_ROOT'] . "/web_php/shop/" . "lib/session.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/web_php/shop/" . "lib/database.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/web_php/shop/" . "helpers/format.php";

?>

<?php

class brand
{
    private $db;
    private $fm; //format
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function insert_brand($brandName)
    {
        $brandName = $this->fm->validation($brandName);
        $brandName = mysqli_real_escape_string($this->db->conn, $brandName);

        if (empty($brandName)) {
            $alert = "<span class='error'>Brand name must be not empty</span>";
            return $alert;
        } else {
            $query = "INSERT INTO tbl_brand (brandName) VALUES (?) ";
            $params = array($brandName);
            $types = 's';

            $result = $this->db->executeQuery($query, $params, $types);

            if ($result) {
                $alert = "<span class='success'>Insert Brand Successfully</span>";
                // $alert = $brandName;
                return $alert;
            } else {
                $alert = "<span class='error'>Insert Brand Failed</span>";
                return $alert;
            }
        }
    }

    public function show_brand()
    {
        $query = "SELECT * FROM tbl_brand ORDER BY brandId DESC";
        $result = $this->db->executeSelect($query, array());
        return $result;
    }

    public function update_brand($brandName, $brandId)
    {
        $brandName = $this->fm->validation($brandName);
        $brandId = $this->fm->validation($brandId);

        $brandName = mysqli_real_escape_string($this->db->conn, $brandName);
        $brandId = mysqli_real_escape_string($this->db->conn, $brandId);


        if (empty($brandName)) {
            $alert = "<span class='error'>Brand name must be not empty</span>";
            return $alert;
        } else {
            $query = "UPDATE tbl_brand SET brandName = ? WHERE brandId = ? ";
            $params = array($brandName, $brandId);
            $types = 'si';

            $result = $this->db->executeQuery($query, $params, $types);

            if ($result) {
                $alert = "<span class='success'>Update Brand Successfully</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Update Brand Failed</span>";
                return $alert;
            }
        }
    }

    public function getBrandbyId($id)
    {
        $query = "SELECT * FROM tbl_brand WHERE brandId=?";
        $params = array($id);
        $types = 'i';
        $result = $this->db->executeSelect($query, $params, $types);
        return $result;
    }

    public function delete_brand($id)
    {
        $query = "DELETE FROM tbl_brand WHERE brandId=?";
        $params = array($id);
        $types = 'i';
        $result = $this->db->executeQuery($query, $params, $types);
        return $result;
    }
}
