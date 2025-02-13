<?php
require_once("../connections/MySiteDB.php");

// Загальна кількість видач
$queryTotalIssuances = "SELECT COUNT(*) AS total FROM Issuances";
$resultTotalIssuances = mysqli_query($connection, $queryTotalIssuances);
$totalIssuances = mysqli_fetch_assoc($resultTotalIssuances)['total'];

// Загальна кількість робітників
$queryTotalEmployees = "SELECT COUNT(*) AS total FROM Employees";
$resultTotalEmployees = mysqli_query($connection, $queryTotalEmployees);
$totalEmployees = mysqli_fetch_assoc($resultTotalEmployees)['total'];

// Скільки видач було за останній місяць
$queryLastMonthIssuances = "SELECT COUNT(*) AS total FROM Issuances WHERE issue_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)";
$resultLastMonthIssuances = mysqli_query($connection, $queryLastMonthIssuances);
$lastMonthIssuances = mysqli_fetch_assoc($resultLastMonthIssuances)['total'];

// Яка видача була останньою
$queryLastIssuance = "SELECT Issuances.id, Employees.first_name, Employees.last_name, Items.name, Issuances.issue_date 
                      FROM Issuances
                      JOIN Employees ON Issuances.employee_id = Employees.id
                      JOIN Items ON Issuances.item_id = Items.id
                      ORDER BY Issuances.issue_date DESC LIMIT 1";
$resultLastIssuance = mysqli_query($connection, $queryLastIssuance);
$lastIssuance = mysqli_fetch_assoc($resultLastIssuance);

// Який робітник має найбільше видач
$queryTopEmployee = "SELECT Employees.first_name, Employees.last_name, COUNT(Issuances.id) AS total 
                      FROM Issuances 
                      JOIN Employees ON Issuances.employee_id = Employees.id 
                      GROUP BY Employees.id 
                      ORDER BY total DESC 
                      LIMIT 1";
$resultTopEmployee = mysqli_query($connection, $queryTopEmployee);
$topEmployee = mysqli_fetch_assoc($resultTopEmployee);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статистика</title>
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
        <h2>Статистика</h2>
        <p><strong>Загальна кількість видач:</strong> <?= $totalIssuances ?></p>
        <p><strong>Загальна кількість робітників:</strong> <?= $totalEmployees ?></p>
        <p><strong>Видач за останній місяць:</strong> <?= $lastMonthIssuances ?></p>
        <p><strong>Остання видача:</strong> <?= $lastIssuance ? $lastIssuance['first_name'] . " " . $lastIssuance['last_name'] . " отримав(ла) " . $lastIssuance['name'] . " " . $lastIssuance['issue_date'] : "Немає даних" ?></p>
        <p><strong>Робітник з найбільшою кількістю видач:</strong> <?= $topEmployee ? $topEmployee['first_name'] . " " . $topEmployee['last_name'] . " (" . $topEmployee['total'] . " видач)" : "Немає даних" ?></p>
    </div>
</body>
</html>
