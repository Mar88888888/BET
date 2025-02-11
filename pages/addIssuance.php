<?php
require_once("../connections/MySiteDB.php");

$employees_query = "SELECT id, first_name, last_name, room_number FROM Employees";
$employees_result = mysqli_query($connection, $employees_query);

$items_query = "SELECT id, name FROM Items";
$items_result = mysqli_query($connection, $items_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $item_id = $_POST['item_id'];
    $issue_date = $_POST['issue_date'];

    $insert_query = "INSERT INTO Issuances (employee_id, item_id, issue_date) VALUES ('$employee_id', '$item_id', '$issue_date')";
    
    if (mysqli_query($connection, $insert_query)) {
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
    <title>Додати видачу</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>
<body>
    <div class="navbar">
        <a href="employees.php">Співробітники</a>
        <a href="items.php">МЦ</a>
        <a href="issuances.php">Видачі</a>
    </div>
    
    <div class="form-container">
        <h2>Додати нову видачу</h2>
        <form method="POST" action="">
            <label for="employee_id">Співробітник:</label>
            <select name="employee_id" required>
                <?php while ($employee = mysqli_fetch_assoc($employees_result)) { ?>
                    <option value="<?php echo $employee['id']; ?>">
                        <?php echo $employee['first_name'] . " " . $employee['last_name'] . " " . $employee['room_number']; ?>
                    </option>
                <?php } ?>
            </select><br><br>
            
            <label for="item_id">Матеріальна цінність:</label>
            <select name="item_id" required>
                <?php while ($item = mysqli_fetch_assoc($items_result)) { ?>
                    <option value="<?php echo $item['id']; ?>">
                        <?php echo $item['name']; ?>
                    </option>
                <?php } ?>
            </select><br><br>
            
            <label for="issue_date">Дата видачі:</label>
            <input type="date" name="issue_date" required><br><br>
            
            <button type="submit">Додати</button>
        </form>
    </div>
</body>
</html>
