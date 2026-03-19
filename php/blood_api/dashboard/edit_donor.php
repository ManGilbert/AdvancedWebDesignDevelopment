<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

// Fetch donor data
$response = file_get_contents("http://localhost/blood_api/api/donors");
$data = json_decode($response, true);

$donorData = null;

foreach($data['data'] as $d){
    if($d['id'] == $id){
        $donorData = $d;
    }
}

// Update logic
if(isset($_POST['update'])){

$updateData = [
"name"=>$_POST['name'],
"blood_type"=>$_POST['blood_type'],
"city"=>$_POST['city'],
"phone"=>$_POST['phone'],
"last_donation_date"=>$_POST['last_donation_date']
];

$options = [
    "http" => [
        "method"  => "PUT",
        "header"  => "Content-Type: application/json\r\n" .
                     "Authorization: " . $_SESSION['token'] . "\r\n",
        "content" => json_encode($updateData),
        "ignore_errors" => true
    ]
];

$context = stream_context_create($options);

$response = file_get_contents("http://localhost/blood_api/api/donors/$id", false, $context);

// DEBUG (optional)
$result = json_decode($response, true);

if(isset($result['status']) && $result['status'] == "success"){
    header("Location:index.php");
    exit;
}else{
    echo "<pre>";
    print_r($response);
    echo "</pre>";
    exit;
}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Donor</title>

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
                <i class="fa-solid fa-pen-to-square text-blue-500"></i> Edit Donor
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
                <input type="text" name="name"
                    value="<?= htmlspecialchars($donorData['name'] ?? '') ?>"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
            </div>

            <!-- BLOOD TYPE -->
            <div>
                <label class="block text-gray-600 mb-1">
                    <i class="fa-solid fa-droplet text-red-500 mr-1"></i> Blood Type
                </label>
                <select name="blood_type"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">

                    <?php 
                    $types = ["O+","O-","A+","A-","B+","B-","AB+","AB-"];
                    foreach($types as $type):
                    ?>
                        <option value="<?= $type ?>" 
                        <?= ($donorData['blood_type'] == $type) ? 'selected' : '' ?>>
                        <?= $type ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <!-- CITY -->
            <div>
                <label class="block text-gray-600 mb-1">
                    <i class="fa-solid fa-city mr-1"></i> City
                </label>
                <input type="text" name="city"
                    value="<?= htmlspecialchars($donorData['city'] ?? '') ?>"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
            </div>

            <!-- PHONE -->
            <div>
                <label class="block text-gray-600 mb-1">
                    <i class="fa-solid fa-phone mr-1"></i> Phone
                </label>
                <input type="text" name="phone"
                    value="<?= htmlspecialchars($donorData['phone'] ?? '') ?>"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
            </div>

            <!-- DATE -->
            <div>
                <label class="block text-gray-600 mb-1">
                    <i class="fa-solid fa-calendar mr-1"></i> Last Donation Date
                </label>
                <input type="date" name="last_donation_date"
                    value="<?= htmlspecialchars($donorData['last_donation_date'] ?? '') ?>"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400 outline-none">
            </div>

            <!-- BUTTONS -->
            <div class="flex justify-between items-center pt-4">

                <a href="index.php"
                   class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 text-gray-700">
                   <i class="fa-solid fa-arrow-left"></i> Back
                </a>

                <button type="submit" name="update"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700">
                    <i class="fa-solid fa-save"></i> Update
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>