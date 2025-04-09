<?php
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
        echo "Авто не знайдене.";
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $sql = "DELETE FROM autos WHERE id = $auto_id";

        if (mysqli_query($connection, $sql)) {
            echo "Авто успішно видалене!";
            header("Location: autos.php");
            exit();
        } else {
            echo "Помилка при видаленні авто: " . mysqli_error($connection);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Видалити авто</title>
</head>
<body>
      <form action="delete_auto.php?id=<?= $auto_id ?>" method="POST">
          <p>Ви дійсно хочете видалити це авто?</p>
          <input type="submit" value="Видалити авто">
      </form>
      <br>
      <a href="autos.php"><button>Перейти до списку авто</button></a>
</body>
</html>

<?php
mysqli_close($connection);
?>