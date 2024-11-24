<?php

// Crear una conexión a la base de datos
$connection = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Verificar si la conexión fue exitosa
if ($connection->connect_error) {
    die("Error en la conexión a la base de datos: " . $connection->connect_error);
}
// Si se envió el formulario para agregar un nuevo paquete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_package'])) {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $image = htmlspecialchars($_POST['image']);
    $price = htmlspecialchars($_POST['price']);
    $date = htmlspecialchars($_POST['date']);

    // Insertar el paquete en la base de datos
    $stmt = $connection->prepare("INSERT INTO paquetes (lugar, descripcion, urlimagen, fecha, precio) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssd", $name, $description, $image, $date, $price);
    $stmt->execute();

    // Redirigir para actualizar la página
    header("Location: admin.php");
    exit();
}
?>