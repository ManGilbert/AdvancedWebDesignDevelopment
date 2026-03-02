<?php
$name = "Gilbert";
$country = "Rwanda";
$profession = "Developer";

$price = 45.75;
$weight = 60.5;
$percentage = 89.5;

$age = 28;
$year = 2026;
$students = 12;

$isLoggedIn = true;
$isAdmin = false;
$isRegistered = true;
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP Variables Exercise</title>
</head>
<body>

    <h1>PHP Variables Output</h1>

    <h2>String Variables</h2>
    <?php
        echo "Name: " . $name . "<br>";
        echo "Country: " . $country . "<br>";
        echo "Profession: " . $profession . "<br>";
    ?>

    <h2>Float Variables</h2>
    <?php
        echo "Price: " . $price . "<br>";
        echo "Weight: " . $weight . "<br>";
        echo "Percentage: " . $percentage . "<br>";
    ?>

    <h2>Integer Variables</h2>
    <?php
        echo "Age: " . $age . "<br>";
        echo "Year: " . $year . "<br>";
        echo "Number of Students: " . $students . "<br>";
    ?>

    <h2>Boolean Variables</h2>
    <?php
        echo "Is Logged In: ";
        var_dump($isLoggedIn);
        echo "<br>";

        echo "Is Admin: ";
        var_dump($isAdmin);
        echo "<br>";

        echo "Is Registered: ";
        var_dump($isRegistered);
    ?>

</body>
</html>