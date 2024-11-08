<?php
require_once 'config.php';

// Funciones de gestión de usuarios
function registerUser($nombre, $email, $contrasena) {
    global $conn;

    $hashed_password = password_hash($contrasena, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios (nombre, email, contrasena) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $nombre, $email, $hashed_password);

    return mysqli_stmt_execute($stmt);
}

function listUsers($offset = 0, $limit = 10) {
    global $conn;

    $sql = "SELECT * FROM usuarios LIMIT ?, ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $offset, $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    return $result;
}

function searchUsers($searchTerm) {
    global $conn;

    $sql = "SELECT * FROM usuarios WHERE nombre LIKE ? OR email LIKE ?";
    $stmt = mysqli_prepare($conn, $sql);
    $param = "%$searchTerm%";
    mysqli_stmt_bind_param($stmt, "ss", $param, $param);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    return $result;
}

function updateUser($id, $nombre, $email) {
    global $conn;

    $sql = "UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $nombre, $email, $id);

    return mysqli_stmt_execute($stmt);
}

function deleteUser($id) {
    global $conn;

    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    return mysqli_stmt_execute($stmt);
}
?>
