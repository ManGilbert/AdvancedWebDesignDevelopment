<?php

$message = "";

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $file = "users.txt";

    $data = $username . "," . $password . "\n";

    file_put_contents($file, $data, FILE_APPEND);

    $message = "Account Created Successfully!";
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Signup</title>

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
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            width: 300px;
            border-radius: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
        }
    </style>

</head>

<body>

    <div class="main">

        <div class="form-box">

            <h2>Create Account</h2>

            <form method="post">

                <input type="text" name="username" placeholder="Enter Username" required>

                <input type="password" name="password" placeholder="Enter Password" required>

                <button type="submit">Sign Up</button>

            </form>

            <p><?php echo $message; ?></p>

            <p>Already have account?
                <a href="login.php">Login</a>
            </p>

        </div>

    </div>

</body>

</html>