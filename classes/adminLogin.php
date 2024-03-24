<?php
include_once "../lib/session.php";
include_once "../lib/database.php";
include_once "../helpers/format.php";

?>

<?php

class adminLogin
{
    private $db;
    private $fm; //format
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }

    public function admin_login($adminUsername, $adminPassword)
    {
        $adminUsername = $this->fm->validation($adminUsername);
        $adminPassword = $this->fm->validation($adminPassword);

        $adminUsername = mysqli_real_escape_string($this->db->conn, $adminUsername);
        $adminPassword = mysqli_real_escape_string($this->db->conn, $adminPassword);

        if (empty($adminUsername) ||  empty($adminPassword)) {
            $alert = "Username and Password must be not empty";
            return $alert;
        } else {
            // đừng quên hash
            $query = "SELECT * FROM tbl_admin  WHERE adminUsername = '$adminUsername' AND adminPassword = '$adminPassword'";
            $result = $this->db->select($query);
            if ($result) {
                $value = $result->fetch_assoc();
                session_start(); //
                Session::set('adminLogin', true);
                Session::set('adminId', $value['adminId']);
                Session::set('adminUsername', $value['adminUsername']);
                Session::set('adminName', $value['adminName']);
                Session::checkLogin();
            } else {
                $alert = "Username or Password is incorrect";
                return $alert;
            }
        }
    }
}
