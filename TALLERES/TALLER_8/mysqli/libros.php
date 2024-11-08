<?php
require_once 'config.php';

function addBook($titulo, $autor, $isbn, $ano_publicacion, $cantidad_disponible) {
    global $conn;

    $sql = "INSERT INTO libros (titulo, autor, isbn, ano_publicacion, cantidad_disponible) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $titulo, $autor, $isbn, $ano_publicacion, $cantidad_disponible);

    if (mysqli_stmt_execute($stmt)) {
        return true;
    } else {
        return false;
    }
}

function listBooks($offset = 0, $limit = 10) {
    global $conn;

    $sql = "SELECT * FROM libros LIMIT ?, ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $offset, $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    return $result;
}

function searchBooks($searchTerm) {
    global $conn;

    $sql = "SELECT * FROM libros WHERE titulo LIKE ? OR autor LIKE ? OR isbn LIKE ?";
    $stmt = mysqli_prepare($conn, $sql);
    $param = "%$searchTerm%";
    mysqli_stmt_bind_param($stmt, "sss", $param, $param, $param);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    return $result;
}

function updateBook($id, $titulo, $autor, $isbn, $ano_publicacion, $cantidad_disponible) {
    global $conn;

    $sql = "UPDATE libros SET titulo = ?, autor = ?, isbn = ?, ano_publicacion = ?, cantidad_disponible = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssii", $titulo, $autor, $isbn, $ano_publicacion, $cantidad_disponible, $id);

    return mysqli_stmt_execute($stmt);
}

function deleteBook($id) {
    global $conn;

    $sql = "DELETE FROM libros WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    return mysqli_stmt_execute($stmt);
}
?>
