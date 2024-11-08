<?php
require_once 'config.php';

// Registrar un nuevo usuario
function registerUser($nombre, $email, $contrasena) {
    global $pdo;
    $hash = password_hash($contrasena, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (nombre, email, contrasena) VALUES (:nombre, :email, :contrasena)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':nombre' => $nombre, ':email' => $email, ':contrasena' => $hash]);
}

// Listar todos los usuarios
function listUsers($limit, $offset) {
    global $pdo;
    $sql = "SELECT * FROM usuarios LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Buscar usuarios por nombre o email
function searchUsers($term) {
    global $pdo;
    $sql = "SELECT * FROM usuarios WHERE nombre LIKE :term OR email LIKE :term";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':term' => "%$term%"]);
    return $stmt->fetchAll();
}

// Actualizar información de usuarios
function updateUser($id, $nombre, $email) {
    global $pdo;
    $sql = "UPDATE usuarios SET nombre = :nombre, email = :email WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':nombre' => $nombre, ':email' => $email, ':id' => $id]);
}

// Eliminar usuarios
function deleteUser($id) {
    global $pdo;
    $sql = "DELETE FROM usuarios WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
}
?>
