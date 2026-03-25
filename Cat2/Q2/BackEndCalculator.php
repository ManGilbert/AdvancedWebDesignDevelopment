<?php
session_start();

if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}

$result = "Result will appear here";

if (isset($_POST['clear'])) {
    $_SESSION['history'] = [];
}

if (isset($_POST['calculate'])) {

    $num1 = $_POST['num1'] ?? "";
    $num2 = $_POST['num2'] ?? "";
    $operation = $_POST['operation'] ?? "";

    if ($operation == "") {
        $result = "Please select an operation";
    } else {
        switch ($operation) {
            case 'add':
                $result = $num1 + $num2;
                $symbol = '+';
                break;
            case 'subtract':
                $result = $num1 - $num2;
                $symbol = '-';
                break;
            case 'multiply':
                $result = $num1 * $num2;
                $symbol = '*';
                break;
            case 'divide':
                if ($num2 != 0) {
                    $result = $num1 / $num2;
                    $symbol = '/';
                } else {
                    $result = "Cannot divide by zero";
                    $symbol = '/';
                }
                break;
            default:
                $result = "Invalid operation";
        }

        if (is_numeric($result)) {
            $_SESSION['history'][] = "$num1 $symbol $num2 = $result";
        }
    }
}

?>