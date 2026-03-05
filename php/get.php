<!DOCTYPE html>
<html>

<head>
    <title>Login Form</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb');
            background-size: cover;
            background-position: center;
            margin: 0;
        }

        .main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* form box */
        .form-box {
            background: rgba(255, 255, 255, 0.85);
            padding: 30px;
            width: 300px;
            border-radius: 10px;
        }

        /* result box */
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
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .error {
            color: red;
            font-size: 14px;
        }
    </style>

    <script>
        function validateForm() {

            var username = document.forms["loginForm"]["username"].value;
            var password = document.forms["loginForm"]["password"].value;

            if (username == "") {
                alert("Username is required");
                return false;
            }

            if (password == "") {
                alert("Password is required");
                return false;
            }

            return true;
        }
    </script>

</head>

<body>

    <div class="main">

        <div class="form-box">
            <h2>Login (GET)</h2>

            <form name="loginForm" method="get" onsubmit="return validateForm()">

                <input type="text" name="username" placeholder="Enter Username">

                <input type="password" name="password" placeholder="Enter Password">

                <button type="submit">Login</button>

            </form>
        </div>

        <div class="result-box">
            <h2>Login Result</h2>

            <?php
            if (isset($_GET['username']) && isset($_GET['password'])) {

                $username = $_GET['username'];
                $password = $_GET['password'];

                echo "Username: " . $username . "<br><br>";
                echo "Password: " . $password;
            } else {
                echo "No data submitted yet.";
            }
            ?>

        </div>

    </div>

</body>

</html>