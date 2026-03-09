<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? ''; // plain text password

    // Check if any field is empty
    if ($full_name === '' || $email === '' || $password === '') {
        $_SESSION['error'] = "Please fill in all fields!";
        header("Location: index.php");
        exit();
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        $_SESSION['error'] = "Email already registered!";
        header("Location: index.php");
        exit();
    }
    $stmt->close();

    // Insert new user with plain text password
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, 'student')");
    $stmt->bind_param("sss", $full_name, $email, $password);
    $stmt->execute();
    $stmt->close();

    $_SESSION['success'] = "Signup successful! Please login.";
    header("Location: index.php");
    exit();
}