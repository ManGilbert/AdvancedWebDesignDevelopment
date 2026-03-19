<?php
session_start();

if(isset($_POST['login'])){

$username = $_POST['username'];
$password = $_POST['password'];

$data = [
"username"=>$username,
"password"=>$password
];

$options = [
"http"=>[
"method"=>"POST",
"header"=>"Content-Type: application/json",
"content"=>json_encode($data)
]
];

$context = stream_context_create($options);

$response = file_get_contents("http://localhost/blood_api/api/login", false, $context);

$result = json_decode($response, true);

if($result['status'] == "success"){
    
    $_SESSION['admin'] = $username;
    $_SESSION['token'] = $result['token'];

    header("Location:index.php");
}else{
    $error = "Invalid login!";
}

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body class="bg-gradient-to-br from-red-500 to-red-700 min-h-screen flex items-center justify-center">

<!-- LOGIN CARD -->
<div class="bg-white/80 backdrop-blur-lg p-8 rounded-2xl shadow-2xl w-full max-w-sm">

    <!-- TITLE -->
    <div class="text-center mb-6">
        <i class="fa-solid fa-droplet text-red-600 text-4xl mb-2"></i>
        <h2 class="text-2xl font-bold text-gray-700">Blood Admin</h2>
        <p class="text-gray-500 text-sm">Login to your dashboard</p>
    </div>

    <!-- ERROR -->
    <?php if(isset($error)): ?>
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4 text-sm">
            <i class="fa-solid fa-triangle-exclamation"></i> <?= $error ?>
        </div>
    <?php endif; ?>

    <!-- FORM -->
    <form method="POST" class="space-y-4">

        <!-- USERNAME -->
        <div>
            <label class="text-gray-600 text-sm">
                <i class="fa-solid fa-user"></i> Username
            </label>
            <input type="text" name="username" required
                class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring-2 focus:ring-red-400 outline-none">
        </div>

        <!-- PASSWORD -->
        <div>
            <label class="text-gray-600 text-sm">
                <i class="fa-solid fa-lock"></i> Password
            </label>
            <input type="password" name="password" required
                class="w-full px-4 py-2 mt-1 border rounded-lg focus:ring-2 focus:ring-red-400 outline-none">
        </div>

        <!-- BUTTON -->
        <button type="submit" name="login"
            class="w-full bg-red-600 text-white py-2 rounded-lg shadow hover:bg-red-700 transition">
            <i class="fa-solid fa-right-to-bracket"></i> Login
        </button>

    </form>

</div>

</body>
</html>