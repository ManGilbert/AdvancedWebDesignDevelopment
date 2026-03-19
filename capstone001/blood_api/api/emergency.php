<?php
header("Content-Type: application/json");

require_once("../config/database.php");

$database = new Database();
$db = $database->connect();

$query = "
SELECT * FROM donors 
WHERE last_donation_date <= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
";

$stmt = $db->prepare($query);
$stmt->execute();

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "status" => "success",
    "data" => $data
]);
?>