<?php
header('Content-Type: application/json');

$filename = 'student.json';
if (!file_exists($filename)) {
    file_put_contents($filename, json_encode([])); // Create file if it doesn't exist
}

$students = json_decode(file_get_contents($filename), true);

$method = $_SERVER['REQUEST_METHOD'];

$data = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $student = getStudentById($_GET['id'], $students);
            if ($student) {
                echo json_encode($student);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Student not found']);
            }
        } else {
            echo json_encode($students);
        }
        break;

    case 'POST':
        $newStudent = [
            'id' => uniqid(),
            'name' => $data['name'],
            'age' => $data['age'],
            'course' => $data['course'],
            'enrolDate' => $data['enrolDate'],
            'status' => $data['status']
        ];
        $students[] = $newStudent;
        file_put_contents($filename, json_encode($students));
        echo json_encode($newStudent);
        break;

    case 'PUT':
        if (isset($data['id'])) {
            $studentIndex = getStudentIndexById($data['id'], $students);
            if ($studentIndex !== -1) {
                $students[$studentIndex] = [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'age' => $data['age'],
                    'course' => $data['course'],
                    'enrolDate' => $data['enrolDate'],
                    'status' => $data['status']
                ];
                file_put_contents($filename, json_encode($students));
                echo json_encode($students[$studentIndex]);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Student not found']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID is required for updating']);
        }
        break;

    case 'PATCH':
        if (isset($data['id'])) {
            $studentIndex = getStudentIndexById($data['id'], $students);
            if ($studentIndex !== -1) {
                if (isset($data['name'])) {
                    $students[$studentIndex]['name'] = $data['name'];
                }
                if (isset($data['age'])) {
                    $students[$studentIndex]['age'] = $data['age'];
                }
                if (isset($data['course'])) {
                    $students[$studentIndex]['course'] = $data['course'];
                }
                if (isset($data['enrolDate'])) {
                    $students[$studentIndex]['enrolDate'] = $data['enrolDate'];
                }
                if (isset($data['status'])) {
                    $students[$studentIndex]['status'] = $data['status'];
                }
                // Save the updated students data back to the JSON file
                file_put_contents($filename, json_encode($students));
                echo json_encode($students[$studentIndex]);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Student not found']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID is required for updating']);
        }
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $studentIndex = getStudentIndexById($_GET['id'], $students);
            if ($studentIndex !== -1) {
                unset($students[$studentIndex]);
                $students = array_values($students);
                file_put_contents($filename, json_encode($students));
                echo json_encode(['message' => 'Student deleted']);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Student not found']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'ID is required for deletion']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method Not Allowed']);
        break;
}

function getStudentById($id, $students) {
    foreach ($students as $student) {
        if ($student['id'] == $id) {
            return $student;
        }
    }
    return null;
}

function getStudentIndexById($id, $students) {
    foreach ($students as $index => $student) {
        if ($student['id'] == $id) {
            return $index;
        }
    }
    return -1;
}
?>