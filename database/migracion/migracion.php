<?php
// Incluir la configuración de la base de datos
include 'conexion_bd.php';

function migrarBaseDeDatos($conn) {
    // Crear la tabla 'Usuarios' si no existe
    $sql = "
    CREATE TABLE IF NOT EXISTS Usuarios (
        Id INT AUTO_INCREMENT PRIMARY KEY,
        Nombre VARCHAR(100),
        Email VARCHAR(100) UNIQUE,
        Telefono VARCHAR(20),
        Password VARCHAR(255),
        Rol ENUM('admin', 'usuario') DEFAULT 'usuario'
    );
    ";

    // Ejecutar la consulta
    try {
        $conn->exec($sql);
        echo "Tabla 'Usuarios' migrada o ya existe.\n";
    } catch (PDOException $e) {
        echo "Error al crear la tabla 'Usuarios': " . $e->getMessage() . "\n";
    }

    // Crear la tabla 'Destinos' si no existe
    $sqlDestinos = "
    CREATE TABLE IF NOT EXISTS Destinos (
        IdDestino INT AUTO_INCREMENT PRIMARY KEY,
        Nombre VARCHAR(100),
        Descripcion TEXT
    );
    ";

    // Ejecutar la consulta para la tabla de destinos
    try {
        $conn->exec($sqlDestinos);
        echo "Tabla 'Destinos' migrada o ya existe.\n";
    } catch (PDOException $e) {
        echo "Error al crear la tabla 'Destinos': " . $e->getMessage() . "\n";
    }
}

// Llamar a la función para migrar la base de datos
migrarBaseDeDatos($conn);
?>
