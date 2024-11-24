<?php

// Crear una conexión a la base de datos
$connection = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Verificar si la conexión fue exitosa
if ($connection->connect_error) {
    die("Error en la conexión a la base de datos: " . $connection->connect_error);
}

// Procesar la solicitud de edición de paquete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_package'])) {
    $index = $_POST['index'];
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $image = htmlspecialchars($_POST['image']);
    $price = htmlspecialchars($_POST['price']);
    $date = htmlspecialchars($_POST['date']);

    // Actualizar el paquete en la base de datos
    $stmt = $connection->prepare("UPDATE paquetes SET lugar = ?, descripcion = ?, urlimagen = ?, fecha = ?, precio = ? WHERE idpaquete = ?");
    $stmt->bind_param("ssssdi", $name, $description, $image, $date, $price, $index);
    $stmt->execute();

    // Redirigir a la página principal
    header("Location: admin.php");
    exit();
}
?>