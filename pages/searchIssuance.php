<?php
require_once("../connections/MySiteDB.php");

$searchItem = isset($_GET['search_item']) ? mysqli_real_escape_string($connection, $_GET['search_item']) : '';
$searchName = isset($_GET['search_name']) ? mysqli_real_escape_string($connection, $_GET['search_name']) : '';
$dateFrom = isset($_GET['date_from']) ? $_GET['date_from'] : '';
$dateTo = isset($_GET['date_to']) ? $_GET['date_to'] : '';

$query = "SELECT Issuances.id, Employees.first_name, Employees.last_name, Items.name, Issuances.issue_date 
          FROM Issuances
          JOIN Employees ON Issuances.employee_id = Employees.id
          JOIN Items ON Issuances.item_id = Items.id
          WHERE 1=1";

if (!empty($searchItem)) {
    $query .= " AND Items.name LIKE '%$searchItem%'";
}
if (!empty($searchName)) {
    $query .= " AND Employees.first_name LIKE '%$searchName%' OR Employees.last_name LIKE '%$searchName%'";
}
if (!empty($dateFrom) && !empty($dateTo)) {
    $query .= " AND Issuances.issue_date BETWEEN '$dateFrom' AND '$dateTo'";
}

$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пошук видач</title>
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
        <h2>Пошук видач</h2>
        <form method="GET" action="">
            <label for="search_item">Пошук за ключовим словом МЦ:</label>
            <input type="text" name="search_item" id="search_item" value="<?= htmlspecialchars($searchItem) ?>">

            <label for="search_name">Пошук за шаблоном імені:</label>
            <input type="text" name="search_name" id="search_name" value="<?= htmlspecialchars($searchName) ?>">

            <label for="date_from">Дата від:</label>
            <input type="date" name="date_from" id="date_from" value="<?= htmlspecialchars($dateFrom) ?>">

            <label for="date_to">Дата до:</label>
            <input type="date" name="date_to" id="date_to" value="<?= htmlspecialchars($dateTo) ?>">

            <button type="submit">Шукати</button>
        </form>
        <h3>Результати пошуку</h3>
        <table border='1'>
            <tr>
                <th>ID Видачі</th>
                <th>Співробітник</th>
                <th>МЦ</th>
                <th>Дата видачі</th>
            </tr>
            <?php while ($issue = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= $issue['id'] ?></td>
                    <td><?= $issue['first_name'] . " " . $issue['last_name'] ?></td>
                    <td><?= $issue['name'] ?></td>
                    <td><?= $issue['issue_date'] ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
