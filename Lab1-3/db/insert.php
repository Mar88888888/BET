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
$query = "INSERT INTO Issuances (employee_id, item_id, issue_date) VALUES
(1, 1, '2024-02-01'),
(2, 3, '2024-02-02'),
(3, 5, '2024-02-03'),
(4, 7, '2024-02-04'),
(5, 2, '2024-02-05'),
(6, 8, '2024-02-06'),
(7, 4, '2024-02-07'),
(8, 6, '2024-02-08'),
(9, 9, '2024-02-09'),
(10, 10, '2024-02-10');";

//Реалізація запиту
$create_tbl = mysqli_query($link, $query);
if ($create_tbl) {
  echo "Дані успішно введені", "<br>";
} else {
  echo "Дані не введені";
}

?>