<?php
require_once("../connections/MySiteDB.php");

$sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'issue_date';
$sort_order = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC';

$valid_columns = ['first_name', 'name', 'issue_date'];
if (!in_array($sort_column, $valid_columns)) {
    $sort_column = 'issue_date';
}

$query = "SELECT Issuances.id, Employees.first_name, Employees.last_name, Items.name, Issuances.issue_date 
          FROM Issuances
          JOIN Employees ON Issuances.employee_id = Employees.id
          JOIN Items ON Issuances.item_id = Items.id
          ORDER BY $sort_column $sort_order";
$result = mysqli_query($connection, $query);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Видачі матеріальних цінностей</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <div class="navbar">
        <a href="employees.php">Співробітники</a>
        <a href="items.php">МЦ</a>
        <a href="issuances.php">Видачі</a>
        <a href="statistics.php">Статистика</a>
    </div>
    <div class='container'>
        <h2>Видачі матеріальних цінностей</h2>
        <table border='1'>
            <tr>
                <th>ID Видачі</th>
                <th><a href="?sort=first_name&order=<?= ($sort_order === 'ASC' ? 'desc' : 'asc') ?>">Співробітник</a></th>
                <th><a href="?sort=name&order=<?= ($sort_order === 'ASC' ? 'desc' : 'asc') ?>">МЦ</a></th>
                <th><a href="?sort=issue_date&order=<?= ($sort_order === 'ASC' ? 'desc' : 'asc') ?>">Дата видачі</a></th>
                <th>Дії</th>
            </tr>
            <?php
            while ($issue = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $issue['id'] . "</td>";
                echo "<td>" . $issue['first_name'] . " " . $issue['last_name'] . "</td>";
                echo "<td>" . $issue['name'] . "</td>";
                echo "<td>" . $issue['issue_date'] . "</td>";
                echo "<td><a href='editIssuance.php?id=" . $issue['id'] . "'>Редагувати</a></td>";
                echo "</tr>";
            }
            ?>
        </table><br>
        <div class="button-container">
            <button onclick="window.location.href='addIssuance.php'">Додати видачу</button>
            <button onclick="window.location.href='searchIssuance.php'">Пошук</button>
            <button onclick="window.location.href='deleteIssuance.php'">Видалення видач</button>
        </div>
    </div>
</body>
</html>