<?php
session_start(); // Iniciar sesión
include 'layout/headerlog.php'; 

// Asegúrate de que el usuario esté autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirigir si el usuario no está autenticado
    exit();
}

// Conectar a la base de datos
require_once 'conexion.php'; // Asegúrate de incluir tu archivo de conexión

// Verificar si se pasó un ID de paquete en la URL
if (isset($_GET['id'])) {
    $paquete_id = $_GET['id'];
    
    // Obtener los detalles del paquete desde la base de datos
    $query = "SELECT * FROM paquetes WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $paquete_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $paquete = $result->fetch_assoc();
    
    if ($paquete) {
        $user_id = $_SESSION['user_id']; // Obtener el ID del usuario desde la sesión
        
        // Verificar si el paquete ya ha sido reservado por el usuario
        $check_query = "SELECT * FROM reservas WHERE user_id = ? AND paquete_id = ?";
        $check_stmt = $conn->prepare($check_query);
        $check_stmt->bind_param("ii", $user_id, $paquete_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows == 0) {
            // El paquete no ha sido reservado, agregarlo a las reservas
            $insert_query = "INSERT INTO reservas (user_id, paquete_id) VALUES (?, ?)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("ii", $user_id, $paquete_id);
            $insert_stmt->execute();
            
            // Redirigir a misReservas.php con un mensaje de éxito
            header('Location: misReservas.php?success=1');
            exit();
        } else {
            // El paquete ya está reservado
            header('Location: misReservas.php?error=already_reserved');
            exit();
        }
    } else {
        // El paquete no existe
        header('Location: misReservas.php?error=not_found');
        exit();
    }
}
?>
