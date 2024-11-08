<?php
require_once 'libros.php';
require_once 'usuarios.php';
require_once 'prestamos.php';


?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Libros</title>
</head>
<body>
    <h1>Gestión de Libros</h1>

    <!-- Formulario para añadir libros -->
    <h3>Añadir Libro</h3>
    <form action="libros.php" method="post">
        <input type="hidden" name="action" value="add">
        <label for="titulo">Título:</label>
        <input type="text" name="titulo" required><br>

        <label for="autor">Autor:</label>
        <input type="text" name="autor" required><br>

        <label for="isbn">ISBN:</label>
        <input type="text" name="isbn" required><br>

        <label for="ano_publicacion">Año de Publicación:</label>
        <input type="number" name="ano_publicacion" required><br>

        <label for="cantidad_disponible">Cantidad Disponible:</label>
        <input type="number" name="cantidad_disponible" required><br>

        <input type="submit" value="Añadir Libro">
    </form>

    <!-- Formulario para buscar libros -->
    <h3>Buscar Libro</h3>
    <form action="libros.php" method="get">
        <input type="hidden" name="action" value="search">
        <label for="searchTerm">Buscar por título, autor o ISBN:</label>
        <input type="text" name="searchTerm" required><br>
        <input type="submit" value="Buscar">
    </form>

    <!-- Formulario para actualizar libros -->
    <h3>Actualizar Libro</h3>
    <form action="libros.php" method="post">
        <input type="hidden" name="action" value="update">
        <label for="id">ID del Libro:</label>
        <input type="number" name="id" required><br>

        <label for="titulo">Nuevo Título:</label>
        <input type="text" name="titulo"><br>

        <label for="autor">Nuevo Autor:</label>
        <input type="text" name="autor"><br>

        <label for="isbn">Nuevo ISBN:</label>
        <input type="text" name="isbn"><br>

        <label for="ano_publicacion">Nuevo Año de Publicación:</label>
        <input type="number" name="ano_publicacion"><br>

        <label for="cantidad_disponible">Nueva Cantidad Disponible:</label>
        <input type="number" name="cantidad_disponible"><br>

        <input type="submit" value="Actualizar Libro">
    </form>

    <!-- Formulario para eliminar libros -->
    <h3>Eliminar Libro</h3>
    <form action="libros.php" method="post">
        <input type="hidden" name="action" value="delete">
        <label for="id">ID del Libro a Eliminar:</label>
        <input type="number" name="id" required><br>
        <input type="submit" value="Eliminar Libro">
    </form>
</body>
</html>
