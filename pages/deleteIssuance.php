<?php
require_once("../connections/MySiteDB.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])){ 
    if (!empty($_POST["issuance_ids"])) {
        $ids = implode(",", array_map('intval', $_POST["issuance_ids"]));
        $deleteQuery = "DELETE FROM Issuances WHERE id IN ($ids)";
        mysqli_query($connection, $deleteQuery);
    }
    header("Location: deleteIssuance.php");
    exit();
}

$query = "SELECT Issuances.id, Employees.first_name, Employees.last_name, Items.name, Issuances.issue_date 
          FROM Issuances
          JOIN Employees ON Issuances.employee_id = Employees.id
          JOIN Items ON Issuances.item_id = Items.id";
$result = mysqli_query($connection, $query);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Видалення видач</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
      <div class="navbar">
        <a href="employees.php">Співробітники</a>
        <a href="items.php">МЦ</a>
        <a href="issuances.php">Видачі</a>
    </div>

    <div class="container">
        <h2>Видалення видач</h2>
        <form method="POST" action="">
            <table border='1'>
                <tr>
                    <th>Вибрати</th>
                    <th>ID Видачі</th>
                    <th>Співробітник</th>
                    <th>Отриманий виріб</th>
                    <th>Дата видачі</th>
                </tr>
                <?php while ($issue = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><input type="checkbox" name="issuance_ids[]" value="<?php echo $issue['id']; ?>"></td>
                        <td><?php echo $issue['id']; ?></td>
                        <td><?php echo $issue['first_name'] . " " . $issue['last_name']; ?></td>
                        <td><?php echo $issue['name']; ?></td>
                        <td><?php echo $issue['issue_date']; ?></td>
                    </tr>
                <?php } ?>
            </table>
            <br>
            <div class="button-container">
              <button type="submit" name="delete">Видалити вибрані</button>
            </div>
          </form>
        <br>
    </div>
</body>
</html>
