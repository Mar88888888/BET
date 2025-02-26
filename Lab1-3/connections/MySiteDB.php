<?php
$host = "localhost";
$user = "admin";
$password = "admin"; 
$database = "IssuanceDB";

$connection = mysqli_connect($host, $user, $password, $database);

if (!$connection) {
    die("Помилка підключення: " . mysqli_connect_error());
}
?>
