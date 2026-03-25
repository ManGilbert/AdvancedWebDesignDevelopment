<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #f4f6f9;
        }

        .navbar {
            background: #2a5298;
            padding: 15px;
            color: white;
            display: flex;
            justify-content: space-between;
        }

        .container {
            padding: 30px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            max-width: 400px;
        }

        .logout {
            text-decoration: none;
            color: white;
            background: red;
            padding: 8px 12px;
            border-radius: 5px;
        }

        .logout:hover {
            background: darkred;
        }
    </style>
</head>
<body>

<div class="navbar">
    <div>Dashboard</div>
    <div>
        <a class="logout" href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <div class="card">
        <h2>Hello, <?php echo $_SESSION['name']; ?></h2>
        <p>You are logged in using:</p>
        <b><?php echo $_SESSION['login_method']; ?></b>
    </div>
</div>

</body>
</html>