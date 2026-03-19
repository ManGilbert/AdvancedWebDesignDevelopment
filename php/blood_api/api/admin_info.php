<?php
header("Content-Type: application/json");

require_once("../config/database.php");
require_once("../models/Admin.php");

$database = new Database();
$db = $database->connect();
$admin = new Admin($db);

// Support GET, POST, and JSON input
$input = json_decode(file_get_contents("php://input"), true);

$username = $_GET['username'] 
          ?? $_POST['username'] 
          ?? $input['username'] 
          ?? '';

if (!empty($username)) {

    $data = $admin->getInfo($username);

    if ($data) {
        echo json_encode([
            'status' => 'success',
            'data' => $data
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Admin not found'
        ]);
    }

} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Username required'
    ]);
}
?>