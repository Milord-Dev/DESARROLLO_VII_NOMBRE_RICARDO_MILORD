<?php
require_once 'config.php';

// Funciones de gestión de préstamos
function registerLoan($usuario_id, $libro_id) {
    global $conn;

    mysqli_begin_transaction($conn);
    try {
        // Registrar préstamo
        $sql = "INSERT INTO prestamos (usuario_id, libro_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $usuario_id, $libro_id);
        mysqli_stmt_execute($stmt);

        // Actualizar cantidad disponible
        $sql = "UPDATE libros SET cantidad_disponible = cantidad_disponible - 1 WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $libro_id);
        mysqli_stmt_execute($stmt);

        mysqli_commit($conn);
        return true;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        return false;
    }
}

function listLoans($offset = 0, $limit = 10) {
    global $conn;

    $sql = "SELECT p.*, u.nombre as usuario, l.titulo as libro 
            FROM prestamos p 
            JOIN usuarios u ON p.usuario_id = u.id 
            JOIN libros l ON p.libro_id = l.id 
            LIMIT ?, ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $offset, $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    return $result;
}

function returnBook($prestamo_id) {
    global $conn;

    mysqli_begin_transaction($conn);
    try {
        // Obtener libro ID
        $sql = "SELECT libro_id FROM prestamos WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $prestamo_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $libro_id = $row['libro_id'];

        // Eliminar préstamo
        $sql = "DELETE FROM prestamos WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $prestamo_id);
        mysqli_stmt_execute($stmt);

        // Actualizar cantidad disponible
        $sql = "UPDATE libros SET cantidad_disponible = cantidad_disponible + 1 WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $libro_id);
        mysqli_stmt_execute($stmt);

        mysqli_commit($conn);
        return true;
    } catch (Exception $e) {
        mysqli_rollback($conn);
        return false;
    }
}

function loanHistory($usuario_id) {
    global $conn;

    $sql = "SELECT p.*, l.titulo as libro 
            FROM prestamos p 
            JOIN libros l ON p.libro_id = l.id 
            WHERE p.usuario_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $usuario_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    return $result;
}
?>
