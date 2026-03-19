<?php
class Admin {
    private $conn;
    private $table = "admins";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($username, $password) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE username = :username AND password = :password";

        $stmt = $this->conn->prepare($query);

        $stmt->execute([
            "username" => $username,
            "password" => md5($password)
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getInfo($username){
    $query = "SELECT username, full_name, email, phone FROM " . $this->table . " WHERE username = :username";
    $stmt = $this->conn->prepare($query);
    $stmt->execute(['username' => $username]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}
?>