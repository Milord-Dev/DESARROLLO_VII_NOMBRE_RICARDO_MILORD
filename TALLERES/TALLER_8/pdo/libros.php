<?php
require_once 'config.php';

// Añadir un nuevo libro
function addBook($titulo, $autor, $isbn, $ano_publicacion, $cantidad_disponible) {
    global $pdo;
    $sql = "INSERT INTO libros (titulo, autor, isbn, ano_publicacion, cantidad_disponible) 
            VALUES (:titulo, :autor, :isbn, :ano_publicacion, :cantidad_disponible)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':titulo' => $titulo,
        ':autor' => $autor,
        ':isbn' => $isbn,
        ':ano_publicacion' => $ano_publicacion,
        ':cantidad_disponible' => $cantidad_disponible
    ]);
}

// Listar todos los libros
function listBooks($limit, $offset) {
    global $pdo;
    $sql = "SELECT * FROM libros LIMIT :limit OFFSET :offset";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Buscar libros por título, autor o ISBN
function searchBooks($term) {
    global $pdo;
    $sql = "SELECT * FROM libros WHERE titulo LIKE :term OR autor LIKE :term OR isbn LIKE :term";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':term' => "%$term%"]);
    return $stmt->fetchAll();
}

// Actualizar información de libros
function updateBook($id, $titulo, $autor, $isbn, $ano_publicacion, $cantidad_disponible) {
    global $pdo;
    $sql = "UPDATE libros SET titulo = :titulo, autor = :autor, isbn = :isbn, ano_publicacion = :ano_publicacion, cantidad_disponible = :cantidad_disponible WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':titulo' => $titulo,
        ':autor' => $autor,
        ':isbn' => $isbn,
        ':ano_publicacion' => $ano_publicacion,
        ':cantidad_disponible' => $cantidad_disponible,
        ':id' => $id
    ]);
}

// Eliminar libros
function deleteBook($id) {
    global $pdo;
    $sql = "DELETE FROM libros WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
}
?>
