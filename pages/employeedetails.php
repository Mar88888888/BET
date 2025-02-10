<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Інформація про співробітника</title>
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

$employee_id = $_GET['id']; 

$employee_query = "SELECT * FROM Employees WHERE id = $employee_id";
$employee_result = mysqli_query($connection, $employee_query);
$employee = mysqli_fetch_assoc($employee_result);

echo "<h2>Інформація про співробітника</h2>";


echo "<div class='employee-info'>
        <table>
            <tr>
                <th>Ім'я</th>
                <td>" . $employee['first_name'] . "</td>
            </tr>
            <tr>
                <th>Прізвище</th>
                <td>" . $employee['last_name'] . "</td>
            </tr>
            <tr>
                <th>Номер кімнати</th>
                <td>" . $employee['room_number'] . "</td>
            </tr>
        </table>
      </div>";

$issuances_query = "SELECT Issuances.id, Items.name, Issuances.issue_date 
                    FROM Issuances 
                    JOIN Items ON Issuances.item_id = Items.id
                    WHERE Issuances.employee_id = $employee_id";
$issuances_result = mysqli_query($connection, $issuances_query);

echo "<h3>Отримані матеріальні цінності</h3>";
echo "<table border='1'>
        <tr>
            <th>ID Видачі</th>
            <th>Виріб</th>
            <th>Дата видачі</th>
        </tr>";

while ($issue = mysqli_fetch_assoc($issuances_result)) {
    echo "<tr>";
    echo "<td>" . $issue['id'] . "</td>";
    echo "<td>" . $issue['name'] . "</td>";
    echo "<td>" . $issue['issue_date'] . "</td>";
    echo "</tr>";
}
echo "</table><br>";

?>
</body>
</html>
