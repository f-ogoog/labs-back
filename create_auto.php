<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "Autosdb";

$connection = mysqli_connect($servername, $username, $password, $database);

if (!$connection) {
    die("Помилка підключення: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $number_plate = $_POST['number_plate'];
    $year_of_manufacture = $_POST['year_of_manufacture'];
    $brand = $_POST['brand'];
    $color = $_POST['color'];
    $auto_condition = $_POST['auto_condition'];
    $owner_lastname = $_POST['owner_lastname'];
    $address = $_POST['address'];

    $sql = "INSERT INTO autos (number_plate, year_of_manufacture, brand, color, auto_condition, owner_lastname, address) 
            VALUES ('$number_plate', $year_of_manufacture, '$brand', '$color', '$auto_condition', '$owner_lastname', '$address')";

    if (mysqli_query($connection, $sql)) {
        echo "Авто успішно додане!";
    } else {
        echo "Помилка при додаванні авто: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додати авто</title>
</head>
<body>
    <form action="create_auto.php" method="POST">
        <label for="number_plate">Серійний номер:</label>
        <input type="text" id="number_plate" name="number_plate" minlength="17" maxlength="17" required /><br><br>

        <label for="year_of_manufacture">Рік випуску:</label>
        <input type="text" id="year_of_manufacture" name="year_of_manufacture" required /><br><br>

        <label for="brand">Марка:</label>
        <input type="text" id="brand" name="brand" required /><br><br>
        
        <label for="color">Колір:</label>
        <input type="text" id="color" name="color" required /><br><br>

        <label for="auto_condition">Стан авто:</label>
        <select id="auto_condition" name="auto_condition" required>
          <option value="new">Нове</option>
          <option value="used">Вживане</option>
          <option value="damaged">Пошкоджене</option>
        </select><br><br>

        <label for="owner_lastname">Прізвище власника:</label>
        <input type="text" id="owner_lastname" name="owner_lastname" required /><br><br>

        <label for="address">Адреса:</label>
        <input type="text" id="address" name="address" required /><br><br>

        <input type="submit" value="Додати авто">
    </form>

    <br>
    <a href="autos.php"><button>Перейти до списку авто</button></a>

</body>
</html>

<?php
mysqli_close($connection);
?>