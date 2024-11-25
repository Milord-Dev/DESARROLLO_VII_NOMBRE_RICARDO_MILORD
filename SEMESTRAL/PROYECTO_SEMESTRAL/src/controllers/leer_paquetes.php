<?php

// Crear una conexión a la base de datos
$connection = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Verificar si la conexión fue exitosa
if ($connection->connect_error) {
    die("Error en la conexión a la base de datos: " . $connection->connect_error);
}
// Leer los paquetes de la base de datos
$query = "SELECT * FROM paquetes";
$result = $connection->query($query);

$packages = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $packages[] = $row;
    }
}
?>