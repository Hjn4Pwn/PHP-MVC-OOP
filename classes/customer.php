<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/web_php/shop/" . "lib/database.php";
include_once $_SERVER['DOCUMENT_ROOT'] . "/web_php/shop/" . "helpers/format.php";
?>

<?php

class customer
{
    private $db;
    private $fm; //format
    public function __construct()
    {
        $this->db = new Database();
        $this->fm = new Format();
    }


    public function insert_customer($data)
    {
        $username = $this->fm->validation($data['username']);
        $name = $this->fm->validation($data['name']);
        $password = $this->fm->validation($data['password']);
        $email = $this->fm->validation($data['email']);
        $phone = $this->fm->validation($data['phone']);

        // var_dump($data);
        $username = mysqli_real_escape_string($this->db->conn, $username);
        $name = mysqli_real_escape_string($this->db->conn, $name);
        $password = mysqli_real_escape_string($this->db->conn, $password);
        $email = mysqli_real_escape_string($this->db->conn, $email);
        $phone = mysqli_real_escape_string($this->db->conn, $phone);


        if (empty($username) || empty($name) || empty($password) || empty($email) || empty($phone)) {
            $alert = "<span class='error'>Fields must be not empty</span>";
            return $alert;
        } else {

            /**
             * check valid fields
             * https://regexr.com/
             */
            $patternPasswordCheck = '/^(?=.*[a-z])(?=.*[0-9])(?=.*[A-Z])(?=.*[#$@!%&*?^()]).{8,20}$/';
            if (!preg_match($patternPasswordCheck, $password)) {
                $alert = "<span class='error'>Password must be 8-20 characters long and contain at least one lowercase letter, one uppercase letter, one digit and one special character.</span>";
                return $alert;
            }

            $patternNameCheck = '/^[a-zA-Z]{6,10}$/';
            if (!preg_match($patternNameCheck, $name)) {
                $alert = "<span class='error'>Name must be 6-10 characters long and only contain lowercase and uppercase letters</span>";
                return $alert;
            }

            $patternUsernameCheck = '/^[a-zA-Z0-9]{8,20}$/';
            if (!preg_match($patternUsernameCheck, $username)) {
                $alert = "<span class='error'>Username must be 8-20 characters long and just contain lowercase letter, uppercase letter, digit</span>";
                return $alert;
            }

            $patternEmailCheck = '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/';
            if (!preg_match($patternEmailCheck, $email)) {
                $alert = "<span class='error'>Email is not valid</span>";
                return $alert;
            }

            // ^[+]*[(]{0,1}[0-9]{10,13}[-\s./0-9]{0,3}$
            $patternPhoneCheck = '/^[0-9]{10,13}$/';
            if (!preg_match($patternPhoneCheck, $phone)) {
                $alert = "<span class='error'>Phone is not valid</span>";
                return $alert;
            }

            $password = hash('sha256', $password);

            // về sau sẽ update lên PDO
            $query = "INSERT INTO tbl_customer (name, username, password, email, phone) 
                        VALUES (?, ?, ?, ?, ?) ";
            $params = array($name, $username, $password, $email, $phone);
            $types = 'sssss';

            try {
                $result = $this->db->executeQuery($query, $params, $types);
                $alert = "<span class='success'>Registry Successfully</span>";
                return $alert;
            } catch (Exception $e) {
                if ($e->getCode() == 1062) { // MySQL error code for duplicate entry
                    $alert = "<span class='error'>Username or email or phone already exists</span>";
                    return $alert;
                } else {
                    $alert = "<span class='error'>Insert Product Failed</span>";
                    return $alert;
                }
            }
        }
    }

    public function checkLogin_customer($data)
    {
        $username = $this->fm->validation($data['username']);
        $password = $this->fm->validation($data['password']);

        $username = mysqli_real_escape_string($this->db->conn, $username);
        $password = mysqli_real_escape_string($this->db->conn, $password);

        if (empty($username) || empty($password)) {
            $alert = "<span class='error'>Fields must be not empty</span>";
            return $alert;
        } else {

            /**
             * check valid fields
             * https://regexr.com/
             */
            $patternUsernameCheck = '/^[a-zA-Z0-9]{8,20}$/';
            if (!preg_match($patternUsernameCheck, $username)) {
                $alert = "<span class='error'>Username is incorrect</span>";
                return $alert;
            }

            $patternPasswordCheck = '/^(?=.*[a-z])(?=.*[0-9])(?=.*[A-Z])(?=.*[#$@!%&*?^()]).{8,20}$/';
            if (!preg_match($patternPasswordCheck, $password)) {
                $alert = "<span class='error'>Password is incorrect</span>";
                return $alert;
            }

            $password = hash('sha256', $password);

            // về sau sẽ update lên PDO
            $query = "SELECT * FROM tbl_customer  WHERE username = ? AND password = ?";

            $params = array($username, $password);
            $types = 'ss';

            $result = $this->db->executeSelect($query, $params, $types);

            if ($result) {
                $getInfo = $result->fetch_assoc();
                Session::set('customerLogin', true);
                Session::set('customerId', $getInfo['id']);
                Session::set('customerUsername', $getInfo['username']);
                header('Location:index.php');
            } else {
                $alert = "<span class='error'>Username or Password is incorrect</span>";
                return $alert;
            }
        }
    }

    public function getName($customerId)
    {
        $query = "SELECT name FROM tbl_customer WHERE id = ?";
        $params = array($customerId);
        $types = "i";
        $result = $this->db->executeSelect($query, $params, $types);
        return $result;
    }
}
