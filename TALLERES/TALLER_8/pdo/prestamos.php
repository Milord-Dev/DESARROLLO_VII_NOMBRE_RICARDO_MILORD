<?php
require_once 'config.php';

// Registrar un préstamo de libro
function registerLoan($usuario_id, $libro_id) {
    global $pdo;
    $pdo->beginTransaction();

    try {
        // Verificar disponibilidad del libro
        $sql = "SELECT cantidad_disponible FROM libros WHERE id = :libro_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':libro_id' => $libro_id]);
        $libro = $stmt->fetch();

        if ($libro['cantidad_disponible'] > 0) {
            // Registrar préstamo
            $sql = "INSERT INTO prestamos (usuario_id, libro_id, fecha_prestamo) VALUES (:usuario_id, :libro_id, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':usuario_id' => $usuario_id, ':libro_id' => $libro_id]);

            // Actualizar cantidad disponible del libro
            $sql = "UPDATE libros SET cantidad_disponible = cantidad_disponible - 1 WHERE id = :libro_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':libro_id' => $libro_id]);

            $pdo->commit();
        } else {
            throw new Exception("No hay libros disponibles.");
        }
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}

// Registrar devolución de libro
function returnBook($prestamo_id) {
    global $pdo;
    $pdo->beginTransaction();

    try {
        // Obtener información del préstamo
        $sql = "SELECT libro_id FROM prestamos WHERE id = :prestamo_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':prestamo_id' => $prestamo_id]);
        $prestamo = $stmt->fetch();

        // Registrar devolución
        $sql = "UPDATE prestamos SET fecha_devolucion = NOW() WHERE id = :prestamo_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':prestamo_id' => $prestamo_id]);

        // Incrementar la cantidad disponible del libro
        $sql = "UPDATE libros SET cantidad_disponible = cantidad_disponible + 1 WHERE id = :libro_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':libro_id' => $prestamo['libro_id']]);

        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}

// Mostrar historial de préstamos por usuario
function getLoanHistory($usuario_id) {
    global $pdo;
    $sql = "SELECT l.titulo, p.fecha_prestamo, p.fecha_devolucion 
            FROM prestamos p 
            JOIN libros l ON p.libro_id = l.id 
            WHERE p.usuario_id = :usuario_id 
            ORDER BY p.fecha_prestamo DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':usuario_id' => $usuario_id]);
    return $stmt->fetchAll();
}
?>
