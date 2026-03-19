<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

if(isset($_POST['submit'])){

$data = [
"name"=>$_POST['name'],
"blood_type"=>$_POST['blood_type'],
"city"=>$_POST['city'],
"phone"=>$_POST['phone'],
"last_donation_date"=>$_POST['last_donation_date']
];

$options = [
"http"=>[
"method"=>"POST",
"header"=>"Content-Type: application/json",
"content"=>json_encode($data)
]
];

$context = stream_context_create($options);

file_get_contents("http://localhost/blood_api/api/donors", false, $context);

header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Donor</title>

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen flex items-center justify-center">

<div class="w-full max-w-2xl">

    <!-- CARD -->
    <div class="bg-white/70 backdrop-blur-lg shadow-xl rounded-2xl p-8">

        <!-- HEADER -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-700">
                <i class="fa-solid fa-user-plus text-red-500"></i> Add Donor
            </h2>

            <a href="index.php" 
               class="text-gray-500 hover:text-red-500 text-lg">
               <i class="fa-solid fa-arrow-left"></i>
            </a>
        </div>

        <!-- FORM -->
        <form method="POST" class="space-y-5">

            <!-- NAME -->
            <div>
                <label class="block text-gray-600 mb-1">
                    <i class="fa-solid fa-user mr-1"></i> Name
                </label>
                <input type="text" name="name" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-400 outline-none">
            </div>

            <!-- BLOOD TYPE -->
            <div>
                <label class="block text-gray-600 mb-1">
                    <i class="fa-solid fa-droplet mr-1 text-red-500"></i> Blood Type
                </label>
                <select name="blood_type"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-400 outline-none">
                    <option>O+</option>
                    <option>O-</option>
                    <option>A+</option>
                    <option>A-</option>
                    <option>B+</option>
                    <option>B-</option>
                    <option>AB+</option>
                    <option>AB-</option>
                </select>
            </div>

            <!-- CITY -->
            <div>
                <label class="block text-gray-600 mb-1">
                    <i class="fa-solid fa-city mr-1"></i> City
                </label>
                <input type="text" name="city" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-400 outline-none">
            </div>

            <!-- PHONE -->
            <div>
                <label class="block text-gray-600 mb-1">
                    <i class="fa-solid fa-phone mr-1"></i> Phone
                </label>
                <input type="text" name="phone" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-400 outline-none">
            </div>

            <!-- DATE -->
            <div>
                <label class="block text-gray-600 mb-1">
                    <i class="fa-solid fa-calendar mr-1"></i> Last Donation Date
                </label>
                <input type="date" name="last_donation_date" required
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-red-400 outline-none">
            </div>

            <!-- BUTTONS -->
            <div class="flex justify-between items-center pt-4">

                <a href="index.php"
                   class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 text-gray-700">
                   <i class="fa-solid fa-arrow-left"></i> Back
                </a>

                <button type="submit" name="submit"
                    class="bg-red-600 text-white px-6 py-2 rounded-lg shadow hover:bg-red-700">
                    <i class="fa-solid fa-save"></i> Save Donor
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>