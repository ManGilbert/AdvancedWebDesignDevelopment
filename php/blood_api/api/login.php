<?php
header("Content-Type: application/json");

require_once("../config/database.php");
require_once("../models/Admin.php");

$database = new Database();
$db = $database->connect();

$admin = new Admin($db);

$data = json_decode(file_get_contents("php://input"), true);

$user = $admin->login($data['username'], $data['password']);

if ($user) {
    echo json_encode([
        "status" => "success",
        "message" => "Login successful",
        "token" => base64_encode($user['username']) // simple token
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid credentials"
    ]);
}
?>