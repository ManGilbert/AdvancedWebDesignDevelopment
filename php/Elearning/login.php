<?php
session_start();

$error = "";

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $file = "users.txt";

    if (file_exists($file)) {

        $users = file($file);

        foreach ($users as $user) {

            list($stored_user, $stored_pass) = explode(",", trim($user));

            if ($username == $stored_user && $password == $stored_pass) {

                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit();
            }
        }

        $error = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Form</title>

    <style>
        body {
            font-family: Arial;
            background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb');
            background-size: cover;
            margin: 0;
        }

        .main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-box {
            background: rgba(255, 255, 255, 0.85);
            padding: 30px;
            width: 300px;
            border-radius: 10px;
        }

        .result-box {
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 30px;
            width: 300px;
            border-radius: 10px;
            margin-left: 30px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="main">

        <div class="form-box">

            <h2>Login</h2>

            <form method="post">

                <input type="text" name="username" placeholder="Username" required>

                <input type="password" name="password" placeholder="Password" required>

                <button type="submit">Login</button>

            </form>

        </div>

        <div class="result-box">

            <h2>Login Result</h2>

            <?php
            if ($error != "") {
                echo $error;
            } else {
                echo "Please login to continue.";
            }
            ?>

            <p>Don't have an account?
                <a style="color:yellow" href="signup.php">Create Account</a>
            </p>

        </div>

    </div>

</body>

</html>