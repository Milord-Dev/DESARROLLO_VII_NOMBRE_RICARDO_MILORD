<?php
require_once "config_pdo.php";

try {
    // Iniciar la transacción
    $pdo->beginTransaction();

    // Preparar e insertar un nuevo usuario
    $sql = "INSERT INTO usuarios (nombre, email) VALUES (:nombre, :email)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':nombre' => 'Nuevo Usuario', ':email' => 'nuevo@example.com']);
    
    // Verificar errores de ejecución
    if ($stmt->errorCode() !== '00000') {
        throw new Exception("Error al insertar usuario: " . $stmt->errorInfo()[2]);
    }
    
    // Obtener el ID del usuario insertado
    $usuario_id = $pdo->lastInsertId();

    // Preparar e insertar una publicación para el usuario recién creado
    $sql = "INSERT INTO publicaciones (usuario_id, titulo, contenido) VALUES (:usuario_id, :titulo, :contenido)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':usuario_id' => $usuario_id,
        ':titulo' => 'Nueva Publicación',
        ':contenido' => 'Contenido de la nueva publicación'
    ]);
    
    // Verificar errores de ejecución
    if ($stmt->errorCode() !== '00000') {
        throw new Exception("Error al insertar publicación: " . $stmt->errorInfo()[2]);
    }

    // Confirmar la transacción
    $pdo->commit();
    echo "Transacción completada con éxito.";

} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $pdo->rollBack();
    echo "Error en la transacción: " . $e->getMessage();
}
