<?php
if(isset($_POST['submit'])){
    $age = $_POST['age'];

    if($age > 20){
        echo "Congratulations! You are allowed to open an account.";
    } else {
        echo "Sorry! You must be older than 20 years to open an account.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Account Opening</title>
</head>
<body>
    <form method="post">
        Enter your age: <input type="number" name="age" required>
        <input type="submit" name="submit" value="Check Eligibility">
    </form>
</body>
</html>