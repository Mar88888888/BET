<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Виведення даних</title>
    <!-- Підключаємо файл стилів -->
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <div class="navbar">
        <a href="employees.php">Співробітники</a>
        <a href="items.php">МЦ</a>
        <a href="issuances.php">Видачі</a>
    </div>
<?php
require_once("../connections/MySiteDB.php");
echo "<div class='container'>"; 
$query = "SELECT Issuances.id, Employees.first_name, Employees.last_name, Items.name, Issuances.issue_date 
          FROM Issuances
          JOIN Employees ON Issuances.employee_id = Employees.id
          JOIN Items ON Issuances.item_id = Items.id";
$result = mysqli_query($connection, $query);
echo "<h2>Видачі матеріальних цінностей</h2>";
echo "<table border='1'>
        <tr>
            <th>ID Видачі</th>
            <th>Співробітник</th>
            <th>Отриманий виріб</th>
            <th>Дата видачі</th>
        </tr>";
while ($issue = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $issue['id'] . "</td>";
    echo "<td>" . $issue['first_name'] . " " . $issue['last_name'] . "</td>";
    echo "<td>" . $issue['name'] . "</td>";
    echo "<td>" . $issue['issue_date'] . "</td>";
    echo "</tr>";
}
echo "</table><br>";
echo "</div>";
?>
</body>
</html>