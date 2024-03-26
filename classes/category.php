<?php
// include_once "../lib/session.php";
include_once "../lib/database.php";
include_once "../helpers/format.php";

?>

<?php

class category
{
    private $db;
    private $fm; //format
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function insert_category($catName)
    {
        $catName = $this->fm->validation($catName);
        $catName = mysqli_real_escape_string($this->db->conn, $catName);

        if (empty($catName)) {
            $alert = "<span class='error'>Category name must be not empty</span>";
            return $alert;
        } else {
            $query = "INSERT INTO tbl_category (catName) VALUES (?) ";
            $params = array($catName);
            $types = 's';

            $result = $this->db->executeQuery($query, $params, $types);

            if ($result) {
                $alert = "<span class='success'>Insert Category Successfully</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Insert Category Failed</span>";
                return $alert;
            }
        }
    }

    public function show_category()
    {
        $query = "SELECT * FROM tbl_category ORDER BY catId DESC";
        $result = $this->db->executeSelect($query, array());
        return $result;
    }

    public function update_category($catName, $catId)
    {
        $catName = $this->fm->validation($catName);
        $catId = $this->fm->validation($catId);

        $catName = mysqli_real_escape_string($this->db->conn, $catName);
        $catId = mysqli_real_escape_string($this->db->conn, $catId);


        if (empty($catName)) {
            $alert = "<span class='error'>Category name must be not empty</span>";
            return $alert;
        } else {
            $query = "UPDATE tbl_category SET catName = ? WHERE catId = ? ";
            $params = array($catName, $catId);
            $types = 'si';

            $result = $this->db->executeQuery($query, $params, $types);

            if ($result) {
                $alert = "<span class='success'>Update Category Successfully</span>";
                return $alert;
            } else {
                $alert = "<span class='error'>Update Category Failed</span>";
                return $alert;
            }
        }
    }

    public function getCatbyId($id)
    {
        $query = "SELECT * FROM tbl_category WHERE catId = ? ";
        $params = array($id);
        $types = 'i';
        $result = $this->db->executeSelect($query, $params, $types);
        return $result;
    }

    public function delete_category($id)
    {
        $query = "DELETE FROM tbl_category WHERE catId =?";
        $params = array($id);
        $types = 'i';
        $result = $this->db->executeQuery($query, $params, $types);
        return $result;
    }
}
