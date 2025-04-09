<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$servername = "localhost";
$username = "root";
$password = "";
$database = "Autosdb";

$connection = mysqli_connect($servername, $username, $password, $database);

if (!$connection) {
    die("Помилка підключення: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
  $auto_id = $_GET['id'];

  $auto_query = "SELECT * FROM autos WHERE id = $auto_id";
  $auto_result = mysqli_query($connection, $auto_query);

  if (mysqli_num_rows($auto_result) > 0) {
      $auto = mysqli_fetch_assoc($auto_result);
  } else {
      echo "Авто не знайдне.";
      exit;
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $number_plate = $_POST['number_plate'];
    $year_of_manufacture = $_POST['year_of_manufacture'];
    $brand = $_POST['brand'];
    $color = $_POST['color'];
    $auto_condition = $_POST['auto_condition'];
    $owner_lastname = $_POST['owner_lastname'];
    $address = $_POST['address'];

    $sql = "UPDATE autos SET number_plate = '$number_plate', year_of_manufacture = $year_of_manufacture, brand = '$brand', color = '$color', auto_condition = '$auto_condition', owner_lastname = '$owner_lastname', address = '$address' 
           WHERE id = $auto_id";

    if (mysqli_query($connection, $sql)) {
        echo "Авто успішно оновлено!";
    } else {
        echo "Помилка при оновлені авто: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оновити авто</title>
</head>
<body>
    <form action="edit_auto.php?id=<?= $auto_id; ?>" method="POST">
        <label for="number_plate">Серійний номер:</label>
        <input type="text" id="number_plate" name="number_plate" minlength="17" maxlength="17" value="<?= $auto['number_plate']; ?>" required /><br><br>

        <label for="year_of_manufacture">Рік випуску:</label>
        <input type="text" id="year_of_manufacture" name="year_of_manufacture" value="<?= $auto['year_of_manufacture']; ?>"  required /><br><br>

        <label for="brand">Марка:</label>
        <input type="text" id="brand" name="brand" value="<?= $auto['brand']; ?>" required /><br><br>
        
        <label for="color">Колір:</label>
        <input type="text" id="color" name="color" value="<?= $auto['color']; ?>" required /><br><br>

        <label for="auto_condition">Стан авто:</label>
        <select id="auto_condition" name="auto_condition" required>
          <option value="new" <?= $auto['auto_condition'] == 'new' ? 'selected' : '' ?>>Нове</option>
          <option value="used" <?= $auto['auto_condition'] == 'used' ? 'selected' : '' ?>>Вживане</option>
          <option value="damaged" <?= $auto['auto_condition'] == 'damaged' ? 'selected' : '' ?>>Пошкоджене</option>
        </select><br><br>

        <label for="owner_lastname">Прізвище власника:</label>
        <input type="text" id="owner_lastname" name="owner_lastname" value="<?= $auto['owner_lastname']; ?>" required /><br><br>

        <label for="address">Адреса:</label>
        <input type="text" id="address" name="address" value="<?= $auto['address']; ?>" required /><br><br>

        <input type="submit" value="Оновити авто">
    </form>

    <br>
    <a href="autos.php"><button>Перейти до списку авто</button></a>

</body>
</html>

<?php
mysqli_close($connection);
?>