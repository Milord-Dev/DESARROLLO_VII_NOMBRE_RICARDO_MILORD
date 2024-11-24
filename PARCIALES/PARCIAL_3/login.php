<?php
session_start();
$usuarios = [
    'usuario' => '123',
    'usuario2' => '12345'
];

// Verificar si el formulario fue enviado
if (isset($_POST['usuario']) && isset($_POST['password'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    if (isset($usuarios[$usuario]) && $usuarios[$usuario] === $password) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['tareas'] = [];  
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Credenciales incorrectas.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <label>Usuario:</label>
        <input type="text" name="usuario" required><br>
        <label>Contraseña:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Iniciar Sesión</button>
    </form>
</body>
</html>
