<?php
$conn = mysqli_connect("localhost", "root", "", "Imanishimwe");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
