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

$query = "SELECT * FROM Items";
$result = mysqli_query($connection, $query);
echo "<h2>Матеріальні цінності</h2>";
echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Назва</th>
            <th>Вага (кг)</th>
            <th>Матеріал</th>
        </tr>";
while ($item = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $item['id'] . "</td>";
    echo "<td>" . $item['name'] . "</td>";
    echo "<td>" . $item['weight'] . "</td>";
    echo "<td>" . $item['material'] . "</td>";
    echo "</tr>";
}
echo "</table><br>";
echo "</div>";
?>
</body>
</html>