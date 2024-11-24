<?php

// Crear una conexión a la base de datos
$connection = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Verificar si la conexión fue exitosa
if ($connection->connect_error) {
    die("Error en la conexión a la base de datos: " . $connection->connect_error);
}

// Procesar la solicitud de eliminación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_package'])) {
    $indexToDelete = $_POST['delete_package']; // Obtener el ID del paquete a eliminar

    // Verificar si el índice es válido y eliminar el paquete de la base de datos
    $stmt = $connection->prepare("DELETE FROM paquetes WHERE idpaquete = ?");
    $stmt->bind_param("i", $indexToDelete);
    $stmt->execute();

    // Redirigir a la misma página para actualizar la vista
    header("Location: admin.php");
    exit();
}
?>