<?php

$link = mysqli_connect ("localhost", "root", ""); 
if ($link) {
  echo "З'єднання з сервером встановлено", "<br>";
} else {
  echo "Немає з'єднання з сервером";
}


$db = "IssuanceDB";
$query = "CREATE DATABASE $db";


$create_db = mysqli_query($link, $query); 
if ($create_db) { 
  echo "База даних $db успішно створена";
} else {
  echo "База не створена";
}
?>
