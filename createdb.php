<body>

<?php

$connectiontoserver = mysqli_connect("localhost", "admin", "admin"); 

if($connectiontoserver) {
  echo "Connection established <br>";
} else {
  echo "Connection not established";
}

$dbname = "Autosdb";

$querry = "CREATE DATABASE IF NOT EXISTS $dbname";

$db_creation = mysqli_query($connectiontoserver, $querry); 


if($db_creation){
  echo "DataBase created! <br>";
} else{
  echo "DataBase not created :-( <br>";
}

?>

</body>
