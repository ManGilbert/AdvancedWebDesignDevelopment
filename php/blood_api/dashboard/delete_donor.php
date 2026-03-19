<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

$options = [
    "http" => [
        "method" => "DELETE",
        "header" => "Authorization: " . $_SESSION['token'] . "\r\n",
        "ignore_errors" => true
    ]
];

$context = stream_context_create($options);

$response = file_get_contents("http://localhost/blood_api/api/donors/$id", false, $context);

// DEBUG
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
?>