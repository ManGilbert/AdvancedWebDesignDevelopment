<?php
header("Content-Type: application/json");

$file = "students.json";

// Read JSON file
$data = json_decode(file_get_contents($file), true);

// Get request method
$method = $_SERVER['REQUEST_METHOD'];

// ================== GET ==================
if ($method == "GET") {

    // Search by ID
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $found = null;

        foreach ($data as $student) {
            if ($student['id'] == $id) {
                $found = $student;
                break;
            }
        }

        if ($found) {
            echo json_encode($found);
        } else {
            echo json_encode(["message" => "Student not found"]);
        }
    } else {
        // Get all students
        echo json_encode($data);
    }
}

// ================== POST ==================
elseif ($method == "POST") {

    $input = json_decode(file_get_contents("php://input"), true);

    $newStudent = [
        "id" => count($data) + 1,
        "firstname" => $input['firstname'],
        "lastname" => $input['lastname'],
        "rollnumber" => $input['rollnumber'],
        "age" => $input['age'],
        "department" => $input['department']
    ];

    $data[] = $newStudent;

    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

    echo json_encode(["message" => "Student added"]);
}

// ================== PUT ==================
elseif ($method == "PUT") {

    $input = json_decode(file_get_contents("php://input"), true);

    if (!isset($input['id'])) {
        echo json_encode(["message" => "ID is required"]);
        exit;
    }

    $updated = false;

    foreach ($data as &$student) {
        if ($student['id'] == $input['id']) {
            $student['firstname'] = $input['firstname'];
            $student['lastname'] = $input['lastname'];
            $student['rollnumber'] = $input['rollnumber'];
            $student['age'] = $input['age'];
            $student['department'] = $input['department'];
            $updated = true;
            break;
        }
    }

    if ($updated) {
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
        echo json_encode(["message" => "Student updated"]);
    } else {
        echo json_encode(["message" => "Student not found"]);
    }
}

// ================== DELETE ==================
elseif ($method == "DELETE") {

    $input = json_decode(file_get_contents("php://input"), true);

    if (!isset($input['id'])) {
        echo json_encode(["message" => "ID is required"]);
        exit;
    }

    $newData = [];
    $deleted = false;

    foreach ($data as $student) {
        if ($student['id'] == $input['id']) {
            $deleted = true;
            continue;
        }
        $newData[] = $student;
    }

    if ($deleted) {
        file_put_contents($file, json_encode(array_values($newData), JSON_PRETTY_PRINT));
        echo json_encode(["message" => "Student deleted"]);
    } else {
        echo json_encode(["message" => "Student not found"]);
    }
}

// ================== INVALID ==================
else {
    echo json_encode(["message" => "Invalid request"]);
}
