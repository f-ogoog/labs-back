<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "Autosdb";

$connection = mysqli_connect($servername, $username, $password, $database);

if (!$connection) {
    die("Помилка підключення: " . mysqli_connect_error());
}

$sql = "SELECT 
            id, 
            number_plate, 
            year_of_manufacture, 
            brand, 
            color, 
            auto_condition, 
            owner_lastname, 
            address 
        FROM autos;";

$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>
            <tr>
                <th>Серійний номер</th>
                <th>Рік</th>
                <th>Марка</th>
                <th>Колір</th>
                <th>Стан</th>
                <th>Прізвище власника</th>
                <th>Адреса</th>
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
              </tr>";
    }
    echo "</table>";
} else {
    echo "Немає даних для відображення.";
}

mysqli_close($connection);
?>
