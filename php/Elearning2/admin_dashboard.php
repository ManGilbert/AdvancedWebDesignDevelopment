<?php
session_start();
require 'db.php';

// Only allow admin users
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    $_SESSION['error'] = "Access denied!";
    header("Location: index.php");
    exit();
}

$admin_name = $_SESSION['full_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CourseHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: Segoe UI; }
        .sidebar { height: 100vh; background: #343a40; color: white; padding-top: 20px; }
        .sidebar a { color: white; display: block; padding: 10px 20px; text-decoration: none; }
        .sidebar a:hover { background: #495057; }
        .content { padding: 20px; }
    </style>
</head>
<body>

<div class="d-flex">

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center">CourseHub Admin</h4>
        <a href="admin_dashboard.php">Home</a>
        <a href="manage_courses.php">Courses Manage</a>
        <a href="manage_users.php">User Manage</a>
        <a href="logout.php">Logout (<?= htmlspecialchars($admin_name) ?>)</a>
    </div>

    <!-- Main Content -->
    <div class="content flex-fill">
        <div class="container-fluid">
            <h2>Welcome, <?= htmlspecialchars($admin_name) ?>!</h2>
            <p>This is your admin dashboard.</p>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Courses</h5>
                            <p class="card-text">Manage all courses here.</p>
                            <a href="manage_courses.php" class="btn btn-primary">Manage Courses</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Users</h5>
                            <p class="card-text">Manage all registered users.</p>
                            <a href="manage_users.php" class="btn btn-primary">Manage Users</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>