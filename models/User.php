<?php
require_once "Database.php";

class User {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getUserByUsername($username) {
        $stmt = $this->conn->prepare("SELECT * FROM user WHERE name = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function checkUsername($username) {
        $stmt = $this->conn->prepare("SELECT id FROM user WHERE name = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

    public function createUser($username, $password) {
        $stmt = $this->conn->prepare("INSERT INTO user (name, password, admin) VALUES (?, ?, 0)");
        $stmt->bind_param("ss", $username, $password);
        return $stmt->execute();
    }
}

?>