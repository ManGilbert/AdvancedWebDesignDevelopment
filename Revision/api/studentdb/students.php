<?php
header("Content-Type: application/json");
include "config.php";

$method = $_SERVER['REQUEST_METHOD'];

// ================= GET =================
if($method == "GET"){

    // GET by ID
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $result = mysqli_query($conn, "SELECT * FROM students WHERE id=$id");

        if(mysqli_num_rows($result) > 0){
            echo json_encode(mysqli_fetch_assoc($result));
        } else {
            echo json_encode(["message" => "Student not found"]);
        }

    } else {
        // GET all
        $result = mysqli_query($conn, "SELECT * FROM students");

        $students = [];
        while($row = mysqli_fetch_assoc($result)){
            $students[] = $row;
        }

        echo json_encode($students);
    }
}

// ================= POST =================
elseif($method == "POST"){

    $input = json_decode(file_get_contents("php://input"), true);

    $firstname = $input['firstname'];
    $lastname = $input['lastname'];
    $rollnumber = $input['rollnumber'];
    $age = $input['age'];
    $department = $input['department'];

    $query = "INSERT INTO students (firstname, lastname, rollnumber, age, department)
              VALUES ('$firstname', '$lastname', '$rollnumber', $age, '$department')";

    if(mysqli_query($conn, $query)){
        echo json_encode(["message" => "Student added"]);
    } else {
        echo json_encode(["message" => "Error adding student"]);
    }
}

// ================= PUT =================
elseif($method == "PUT"){

    $input = json_decode(file_get_contents("php://input"), true);

    $id = $input['id'];
    $firstname = $input['firstname'];
    $lastname = $input['lastname'];
    $rollnumber = $input['rollnumber'];
    $age = $input['age'];
    $department = $input['department'];

    $query = "UPDATE students SET 
              firstname='$firstname',
              lastname='$lastname',
              rollnumber='$rollnumber',
              age=$age,
              department='$department'
              WHERE id=$id";

    if(mysqli_query($conn, $query)){
        echo json_encode(["message" => "Student updated"]);
    } else {
        echo json_encode(["message" => "Error updating student"]);
    }
}

// ================= DELETE =================
elseif($method == "DELETE"){

    $input = json_decode(file_get_contents("php://input"), true);

    $id = $input['id'];

    $query = "DELETE FROM students WHERE id=$id";

    if(mysqli_query($conn, $query)){
        echo json_encode(["message" => "Student deleted"]);
    } else {
        echo json_encode(["message" => "Error deleting student"]);
    }
}

// ================= INVALID =================
else {
    echo json_encode(["message" => "Invalid request"]);
}
?>