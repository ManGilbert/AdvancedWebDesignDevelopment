<?php
header("Content-Type: application/json");

// Example data
$data = [
    [
        "id" => 1,
        "name" => "John",
        "email" => "john@example.com"
    ],
    [
        "id" => 2,
        "name" => "Sarah",
        "email" => "sarah@example.com"
    ],
    [
        "id" => 3,
        "name" => "Mike",
        "email" => "mike@example.com"
    ]
];

// Return JSON
echo json_encode($data);
?>