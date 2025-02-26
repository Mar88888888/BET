<?php

$link = mysqli_connect ("localhost", "admin", "admin"); 

//Вибір БД
$db = "IssuanceDB";
$select=mysqli_select_db($link, $db); 
if ($select) {
  echo "Базу успішно вибрано", "<br>";
} else {
  echo "База не вибрана";
}

//Створення таблиці
// Формування запиту
$query = "CREATE TABLE Employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    age INT NOT NULL
);";

//Реалізація запиту
$create_tbl = mysqli_query($link, $query);
if ($create_tbl) {
  echo "Таблиця успішно створена", "<br>";
} else {
  echo "Таблиця не створена";
}

?>