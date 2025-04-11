<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$database = "Autosdb";

$connection = mysqli_connect($servername, $username, $password, $database);

if (!$connection) {
    die("Помилка підключення: " . mysqli_connect_error());
}

$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : 'id';
$order_dir = isset($_GET['order_dir']) ? $_GET['order_dir'] : 'ASC';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$min_year = isset($_GET['min_year']) ? $_GET['min_year'] : 0;
$max_year = isset($_GET['max_year']) ? $_GET['max_year'] : 2025;

$sql = "SELECT 
            id, 
            number_plate, 
            year_of_manufacture, 
            brand, 
            color, 
            auto_condition, 
            owner_lastname, 
            address,
            created
        FROM autos
        WHERE number_plate LIKE '%$search%' AND year_of_manufacture BETWEEN $min_year AND $max_year
        ORDER BY $order_by $order_dir;";

$result = mysqli_query($connection, $sql);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пошук авто</title>
</head>
<body>
    <h2>Пошук авто</h2>
	<br>
    <a href="info.php"><button>Інфо сторінка</button></a><br><br>
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Пошук за серійним номером..." value="<?= htmlspecialchars($search) ?>">
        <input type="number" name="min_year" placeholder="Мін. рік випуску" value="<?= htmlspecialchars($min_year) ?>">
        <input type="number" name="max_year" placeholder="Макс. рік випуску" value="<?= htmlspecialchars($max_year) ?>">
        <button type="submit">Пошук</button>
    </form><br>
    <?php
    if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>
                <tr>
                    <th><a href='?order_by=number_plate&order_dir=" . (($order_by == 'number_plate' && $order_dir == 'ASC') ? 'DESC' : 'ASC') . "'>Серійний номер</a></th>
                    <th><a href='?order_by=year_of_manufacture&order_dir=" . (($order_by == 'year_of_manufacture' && $order_dir == 'ASC') ? 'DESC' : 'ASC') . "'>Рік</a></th>
                    <th><a href='?order_by=brand&order_dir=" . (($order_by == 'brand' && $order_dir == 'ASC') ? 'DESC' : 'ASC') . "'>Марка</a></th>
                    <th><a href='?order_by=color&order_dir=" . (($order_by == 'color' && $order_dir == 'ASC') ? 'DESC' : 'ASC') . "'>Колір</a></th>
                    <th><a href='?order_by=auto_condition&order_dir=" . (($order_by == 'auto_condition' && $order_dir == 'ASC') ? 'DESC' : 'ASC') . "'>Стан</a></th>
                    <th><a href='?order_by=owner_lastname&order_dir=" . (($order_by == 'owner_lastname' && $order_dir == 'ASC') ? 'DESC' : 'ASC') . "'>Прізвище власника</a></th>
                    <th><a href='?order_by=address&order_dir=" . (($order_by == 'address' && $order_dir == 'ASC') ? 'DESC' : 'ASC') . "'>Адреса</a></th>
                    <th><a href='?order_by=created&order_dir=" . (($order_by == 'created' && $order_dir == 'ASC') ? 'DESC' : 'ASC') . "'>Створено</a></th>
                    <th>Дії</th>
                </tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td><a href='services.php?id={$row['id']}'>{$row['number_plate']}</a></td>
                    <td>{$row['year_of_manufacture']}</td>
                    <td>{$row['brand']}</td>
                    <td>{$row['color']}</td>
                    <td>{$row['auto_condition']}</td>
                    <td>{$row['owner_lastname']}</td>
                    <td>{$row['address']}</td>
                    <td>{$row['created']}</td>
                     <td>
                        <a href='edit_auto.php?id={$row['id']}'>Редагувати</a> | 
                        <a href='delete_auto.php?id={$row['id']}'>Видалити</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "Немає даних для відображення.";
    }

    mysqli_close($connection);
    ?><br><br>
    <a href='create_auto.php'><button>Створити нове авто</button></a>
</body>
</html>