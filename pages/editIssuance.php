<?php
require_once("../connections/MySiteDB.php");

if (!isset($_GET['id'])) {
    die("Не передано ID видачі.");
}

$issuance_id = $_GET['id'];

$issuance_query = "SELECT * FROM Issuances WHERE id = $issuance_id";
$issuance_result = mysqli_query($connection, $issuance_query);
$issuance = mysqli_fetch_assoc($issuance_result);
if (!$issuance) {
    die("Видачу не знайдено.");
}

$employees_query = "SELECT id, first_name, last_name FROM Employees";
$employees_result = mysqli_query($connection, $employees_query);

$items_query = "SELECT id, name FROM Items";
$items_result = mysqli_query($connection, $items_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $item_id = $_POST['item_id'];
    $issue_date = $_POST['issue_date'];

    $update_query = "UPDATE Issuances SET employee_id = '$employee_id', item_id = '$item_id', issue_date = '$issue_date' WHERE id = $issuance_id";
    
    if (mysqli_query($connection, $update_query)) {
        header("Location: issuances.php");
        exit();
    } else {
        echo "<p class='error-message'>Помилка: " . mysqli_error($connection) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редагувати видачу</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <div class="navbar">
        <a href="employees.php">Співробітники</a>
        <a href="items.php">МЦ</a>
        <a href="issuances.php">Видачі</a>
    </div>
    
    <div class="container">
        <h2>Редагувати видачу</h2>
        <div class="form-container">
            <form method="POST" action="">
                <label for="employee_id">Співробітник:</label>
                <select name="employee_id" required>
                    <?php while ($employee = mysqli_fetch_assoc($employees_result)) { ?>
                        <option value="<?php echo $employee['id']; ?>" <?php if ($employee['id'] == $issuance['employee_id']) echo "selected"; ?>>
                            <?php echo $employee['first_name'] . " " . $employee['last_name']; ?>
                        </option>
                    <?php } ?>
                </select>
                
                <label for="item_id">Матеріальна цінність:</label>
                <select name="item_id" required>
                    <?php while ($item = mysqli_fetch_assoc($items_result)) { ?>
                        <option value="<?php echo $item['id']; ?>" <?php if ($item['id'] == $issuance['item_id']) echo "selected"; ?>>
                            <?php echo $item['name']; ?>
                        </option>
                    <?php } ?>
                </select>
                
                <label for="issue_date">Дата видачі:</label>
                <input type="date" name="issue_date" value="<?php echo $issuance['issue_date']; ?>" required>
                
                <button type="submit">Зберегти зміни</button>
            </form>
        </div>
    </div>
</body>
</html>
