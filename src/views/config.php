
<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'SEMESTRAL');

$dbHost = 'localhost'; // o el host de tu base de datos
$dbUser = 'root'; // tu usuario de MySQL
$dbPass = ''; // tu contraseña de MySQL
$dbName = 'SEMESTRAL'; // nombre de la base de datos


$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($conn === false){
    die("ERROR: No se pudo conectar. " . mysqli_connect_error());
}
?>