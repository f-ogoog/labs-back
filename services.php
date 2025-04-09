<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "Autosdb";

$connection = mysqli_connect($servername, $username, $password, $database);

if (!$connection) {
    die("Помилка підключення: " . mysqli_connect_error());
}

$car_id = $_GET['id'];

$sql = "SELECT 
            date,
            description,
        FROM services
        WHERE car_id = $car_id";

$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>
            <tr>
                <th>Дата виконання роботи</th>
                <th>Опис</th>
                <th>Створено</th>
            </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['date']}</td>
                <td>{$row['description']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Немає даних для відображення.";
}

mysqli_close($connection);
?>
