<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['titulo']) && isset($_POST['fecha_limite'])) {
    $titulo = $_POST['titulo'];
    $fecha_limite = $_POST['fecha_limite'];

    if (!empty($titulo) && strtotime($fecha_limite) > time()) {
        $_SESSION['tareas'][] = ['titulo' => $titulo, 'fecha_limite' => $fecha_limite];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Datos inválidos. Verifica que todos los campos estén completos y que la fecha sea futura.";
    }
} else {
    $error = "Por favor completa todos los campos.";
}

if (isset($error)) {
    echo "<p style='color:red;'>$error</p>";
    echo "<a href='dashboard.php'>Volver</a>";
}
?>
