<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/web_php/shop/" . "config/config.php";
?>
 
<?php
class Database
{
    public $host   = DB_HOST;
    public $user   = DB_USER;
    public $password   = DB_PASS;
    public $dbname = DB_NAME;

    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // support: UPDATE, DELETE, INSERT
    public function executeQuery($query, $params, $types = '')
    {
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Query preparation failed: " . $this->conn->error);
        }

        if (!empty($params)) {
            if (empty($types)) {
                $types = str_repeat('s', count($params));
            }
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();

        if ($stmt->errno) {
            die("Query execution failed: " . $stmt->error);
        }

        return $stmt;
    }

    // support: SELECT 
    public function executeSelect($query, $params, $types = '')
    {
        $stmt = $this->executeQuery($query, $params, $types);
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result;
        }
        return false;
    }

    public function closeConnection()
    {
        $this->conn->close();
    }
}
