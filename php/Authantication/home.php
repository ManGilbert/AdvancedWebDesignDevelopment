<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Home</title>

    <style>
        body {
            font-family: Arial;
            margin: 0;
        }

        .menu {
            background: #333;
            padding: 15px;
        }

        .menu a {
            color: white;
            margin: 15px;
            text-decoration: none;
            font-weight: bold;
        }

        .menu a:hover {
            color: yellow;
        }

        .content {
            padding: 40px;
        }
    </style>

</head>

<body>

    <div class="menu">

        <a href="home.php">Home</a>
        <a href="#">Signup</a>
        <a href="logout.php">Logout</a>

    </div>

    <div class="content">

        <h2>Welcome <?php echo $_SESSION['username']; ?></h2>

        <p>This is the home page.</p>

    </div>

</body>

</html>
