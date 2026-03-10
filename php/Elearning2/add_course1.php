<?php
require 'db.php';
session_start();

// Only admin can add courses
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $youtube_link = $_POST['youtube_link'];
    $created_by = $_SESSION['user_id'];

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . "." . $ext;
        $destination = "uploads/" . $filename;
        move_uploaded_file($_FILES['image']['tmp_name'], $destination);
    } else {
        $filename = "default.png"; // fallback
    }

    $stmt = $conn->prepare("INSERT INTO courses (name, description, category, youtube_link, image_url, created_by) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $name, $description, $category, $youtube_link, $filename, $created_by);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Add Course</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Course Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Category</label>
            <input type="text" name="category" class="form-control">
        </div>
        <div class="mb-3">
            <label>YouTube Link</label>
            <input type="text" name="youtube_link" class="form-control">
        </div>
        <div class="mb-3">
            <label>Upload Image</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>
        <button class="btn btn-success">Add Course</button>
    </form>
</div>
</body>
</html>