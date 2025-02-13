<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Виведення даних</title>

    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <div class="navbar">
        <a href="employees.php">Співробітники</a>
        <a href="items.php">МЦ</a>
        <a href="issuances.php">Видачі</a>
        <a href="statistics.php">Статистика</a>
    </div>
<?php
require_once("../connections/MySiteDB.php");

echo "<div class='container'>"; 
// Виведення всіх співробітників у таблиці
$query = "SELECT * FROM Employees";
$result = mysqli_query($connection, $query);
echo "<h2>Співробітники</h2>";
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Ім'я</th>
            <th>Прізвище</th>
            <th>Номер кімнати</th>
            <th></th>
        </tr>";
while ($employee = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $employee['id'] . "</td>";
    echo "<td>" . $employee['first_name'] . "</td>";
    echo "<td>" . $employee['last_name'] . "</td>";
    echo "<td>" . $employee['room_number'] . "</td>";
    echo "<td><a href='EmployeeDetails.php?id=" . $employee['id'] . "'>Переглянути</a></td>";
    echo "</tr>";
}
echo "</table><br>";
echo "</div>";
?>
</body>
</html>