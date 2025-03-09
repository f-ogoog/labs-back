<body>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$link = mysqli_connect("localhost", "admin", "admin"); 

$db = "Autosdb";
$select = mysqli_select_db($link, $db);

if ($select) {
  echo "Database selected <br>";
} else {
  echo "Database not selected <br>";
}

$querry = "CREATE TABLE IF NOT EXISTS autos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  number_plate VARCHAR(20) NOT NULL UNIQUE,
  year_of_manufacture YEAR NOT NULL,
  brand VARCHAR(50) NOT NULL,
  color VARCHAR(30) NOT NULL,
  auto_condition ENUM('new', 'used', 'damaged') NOT NULL,
  owner_lastname VARCHAR(50) NOT NULL,
  address VARCHAR(100) NOT NULL
)";


$table_creation = mysqli_query($link, $querry); 

if($table_creation){
  echo "Table created! <br>";
} else{
  echo "Table not created" . mysqli_error($link) . "<br>";
}

?>

</body>
