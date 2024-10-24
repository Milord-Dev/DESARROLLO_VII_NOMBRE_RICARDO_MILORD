<?php


?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?></h2>

    <h3>Lista de Tareas</h3>
    <ul>
        <?php foreach ($tareas as $tarea): ?>
            <li><?php echo $tarea['titulo'] . " - Fecha límite: " . $tarea['fecha_limite']; ?></li>
        <?php endforeach; ?>
    </ul>

    <h3>Agregar Nueva Tarea</h3>
    <form method="POST" action="agregar_tarea.php">
        <label>Título:</label>
        <input type="text" name="titulo" required><br>
        <label>Fecha límite:</label>
        <input type="date" name="fecha_limite" required><br>
        <button type="submit">Agregar Tarea</button>
    </form>

    <br>
    <a href="cerrar_sesion.php">Cerrar Sesión</a>
</body>
</html>
