<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "Autosdb";

$connection = mysqli_connect($servername, $username, $password, $database);

if (!$connection) {
    die("Помилка підключення: " . mysqli_connect_error());
}

$total_autos_query = "SELECT COUNT(*) AS total FROM autos";
$total_services_query = "SELECT COUNT(*) AS total FROM services";

$total_autos_result = mysqli_query($connection, $total_autos_query);
$total_services_result = mysqli_query($connection, $total_services_query);

$total_autos = mysqli_fetch_assoc($total_autos_result)['total'];
$total_services = mysqli_fetch_assoc($total_services_result)['total'];

$last_month = date('Y-m-d H:i:s', strtotime('-1 month'));
$recent_autos_query = "SELECT COUNT(*) AS total FROM autos WHERE created >= '$last_month'";
$recent_services_query = "SELECT COUNT(*) AS total FROM services WHERE date >= '$last_month'";

$recent_autos_result = mysqli_query($connection, $recent_autos_query);
$recent_services_result = mysqli_query($connection, $recent_services_query);

$recent_autos = mysqli_fetch_assoc($recent_autos_result)['total'];
$recent_services = mysqli_fetch_assoc($recent_services_result)['total'];

$last_auto_query = "SELECT number_plate FROM autos ORDER BY created DESC LIMIT 1";
$last_auto_result = mysqli_query($connection, $last_auto_query);
$last_auto = mysqli_fetch_assoc($last_auto_result)['number_plate'] ?? 'Немає записів';

$most_related_query = "SELECT number_plate, COUNT(s.id) AS services_count
                      FROM autos a
                      LEFT JOIN services s ON s.car_id = a.id
                      GROUP BY a.id
                      ORDER BY services_count DESC
                      LIMIT 1";

$most_related_result = mysqli_query($connection, $most_related_query);
$most_related = mysqli_fetch_assoc($most_related_result);
$most_related_number = $most_related['number_plate'] ?? 'Немає записів';
$most_related_count = $most_related['services_count'] ?? 0;

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статистика сайту</title>
</head>
<body>
    <h2>Статистика сайту</h2>
    <p>Загальна кількість записів у таблиці autos: <?= $total_autos ?></p>
    <p>Загальна кількість записів у таблиці services: <?= $total_services ?></p>
    <p>Кількість записів у таблиці autos за останній місяць: <?= $recent_autos ?></p>
    <p>Кількість записів у таблиці services за останній місяць: <?= $recent_services ?></p>
    <p>Останній доданий запис у таблиці autos: <?= $last_auto ?></p>
    <p>Авто у таблиці autos з найбільшою кількістю пов'язаних сервісів: <?= $most_related_number ?> (<?= $most_related_count ?> сервісів)</p>

    <br>
    <a href="autos.php"><button>Повернутися до списку авто</button></a>
</body>
</html>