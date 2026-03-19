<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once("../config/database.php");
require_once("../models/Donor.php");

$database = new Database();
$db = $database->connect();

$donor = new Donor($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    // =========================
    // CREATE DONOR (POST)
    // =========================
    case 'POST':

        $data = json_decode(file_get_contents("php://input"), true);

        // Validation
        if (
            empty($data['name']) ||
            empty($data['blood_type']) ||
            empty($data['city']) ||
            empty($data['phone']) ||
            empty($data['last_donation_date'])
        ) {
            echo json_encode([
                "status" => "error",
                "message" => "All fields are required"
            ]);
            exit;
        }

        if ($donor->create($data)) {
            echo json_encode([
                "status" => "success",
                "message" => "Donor added successfully"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Failed to add donor"
            ]);
        }
        break;

    // =========================
    // GET / SEARCH (GET)
    // =========================
    case 'GET':

        $request = $_SERVER['REQUEST_URI'];

        // Detect search endpoint
        if (strpos($request, '/donors/search') !== false) {

            $blood_type = $_GET['blood_type'] ?? null;
            $city = $_GET['city'] ?? null;
            $name = $_GET['name'] ?? null;

            $data = $donor->search($blood_type, $city, $name);
        } else {

            $data = $donor->getAll();
        }

        echo json_encode([
            "status" => "success",
            "count" => count($data),
            "data" => $data
        ]);

        break;

    // =========================
    // DELETE (PROTECTED)
    // =========================
    case 'DELETE':

        // Get headers
        $headers = getallheaders();
        $token = $headers['Authorization'] ?? null;

        // Check token exists
        if (!$token) {
            echo json_encode([
                "status" => "error",
                "message" => "Unauthorized: Token required"
            ]);
            exit;
        }

        // Decode token
        $decoded = base64_decode($token);

        if ($decoded !== "admin") {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid token"
            ]);
            exit;
        }

        // Get ID from URL
        parse_str($_SERVER['QUERY_STRING'], $params);

        if (empty($params['id'])) {
            echo json_encode([
                "status" => "error",
                "message" => "Donor ID is required"
            ]);
            exit;
        }

        if ($donor->delete($params['id'])) {
            echo json_encode([
                "status" => "success",
                "message" => "Donor deleted successfully"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Failed to delete donor"
            ]);
        }

        break;
    // =========================
    // UPDATE DONOR (PUT)
    // =========================
    case 'PUT':

        // Authentication (same as DELETE)
        $headers = getallheaders();
        $token = $headers['Authorization'] ?? null;

        if (!$token) {
            echo json_encode([
                "status" => "error",
                "message" => "Unauthorized"
            ]);
            exit;
        }

        if (base64_decode($token) !== "admin") {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid token"
            ]);
            exit;
        }

        // Get ID from URL
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo json_encode([
                "status" => "error",
                "message" => "ID is required"
            ]);
            exit;
        }

        if (!is_numeric($id)) {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid donor ID"
            ]);
            exit;
        }

        // Get input data
        $data = json_decode(file_get_contents("php://input"), true);

        if ($donor->update($id, $data)) {
            echo json_encode([
                "status" => "success",
                "message" => "Donor updated successfully"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Update failed"
            ]);
        }

        break;

    // =========================
    // INVALID METHOD
    // =========================
    default:
        echo json_encode([
            "status" => "error",
            "message" => "Invalid request method"
        ]);
        break;
}
