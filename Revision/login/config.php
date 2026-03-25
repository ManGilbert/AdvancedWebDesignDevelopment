<?php
$conn = mysqli_connect("localhost", "root", "", "revision");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
