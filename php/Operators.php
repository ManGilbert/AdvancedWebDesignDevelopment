<?php
$a = 20;
$b = 5;
$x = 10;
$y = 3;

$text1 = "Hello";
$text2 = "World";

?>

<!DOCTYPE html>
<html>
<head>
    <title>All PHP Operators</title>
</head>
<body>

<h2>1. Arithmetic Operators</h2>
<?php
echo "Addition: " . ($a + $b) . "<br>";
echo "Subtraction: " . ($a - $b) . "<br>";
echo "Multiplication: " . ($a * $b) . "<br>";
echo "Division: " . ($a / $b) . "<br>";
echo "Modulus: " . ($a % $b) . "<br>";
?>

<hr>

<h2>2. Assignment Operators</h2>
<?php
$assign = 10;
echo "Original value: " . $assign . "<br>";

$assign += 5;
echo "After += 5: " . $assign . "<br>";

$assign -= 3;
echo "After -= 3: " . $assign . "<br>";
?>

<hr>

<h2>3. Comparison Operators</h2>
<?php
var_dump($a == $b);
echo "<br>";

var_dump($a != $b);
echo "<br>";

var_dump($a > $b);
echo "<br>";

var_dump($a < $b);
?>

<hr>

<h2>4. Logical Operators</h2>
<?php
var_dump($a > 10 && $b < 10);
echo "<br>";

var_dump($a < 10 || $b == 5);
echo "<br>";

var_dump(!($a < 10));
?>

<hr>

<h2>5. Increment and Decrement</h2>
<?php
$num = 5;
echo "Original: " . $num . "<br>";

$num++;
echo "After Increment: " . $num . "<br>";

$num--;
echo "After Decrement: " . $num . "<br>";
?>

<hr>

<h2>6. String Operators</h2>
<?php
echo $text1 . " " . $text2 . "<br>";

$text1 .= " PHP";
echo $text1;
?>
<hr>
<h2>PHP Math Functions</h2>
<?php
// PHP Math Functions

$number = 25;
$decimal = 5.7;
$negative = -10;

?>

<?php
echo "<b>pi()</b> - Value of PI: " . pi() . "<br><br>";

echo "<b>abs()</b> - Absolute value: " . abs($negative) . "<br><br>";

echo "<b>sqrt()</b> - Square root of 25: " . sqrt($number) . "<br><br>";

echo "<b>pow()</b> - 5 power 2: " . pow(5, 2) . "<br><br>";

echo "<b>max()</b> - Maximum of (10, 20, 30): " . max(10, 20, 30) . "<br><br>";

echo "<b>min()</b> - Minimum of (10, 20, 30): " . min(10, 20, 30) . "<br><br>";

echo "<b>round()</b> - Round 5.7: " . round($decimal) . "<br><br>";

echo "<b>ceil()</b> - Round up 5.7: " . ceil($decimal) . "<br><br>";

echo "<b>floor()</b> - Round down 5.7: " . floor($decimal) . "<br><br>";

echo "<b>rand()</b> - Random number: " . rand(1, 100) . "<br><br>";
?>

</body>
</html>