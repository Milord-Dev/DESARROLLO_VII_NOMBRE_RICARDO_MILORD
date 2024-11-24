<?php
session_start(); // Asegúrate de iniciar sesión al principio de cada página
include 'layout/headerlog.php'; 

require 'config.php'; // Asegúrate de que la conexión esté correcta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    if ($password !== $confirmPassword) {
        $error = "Las contraseñas no coinciden.";
    } else {
        try {
            // Encriptar la contraseña
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Preparar y ejecutar la consulta de inserción con mysqli
            $query = "INSERT INTO usuarios (nombre, correo_electronico, contrasena, rol) VALUES (?, ?, ?, 'usuario')";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('sss', $nombre, $email, $hashedPassword); // Vinculamos los parámetros

            // Ejecutar la consulta
            if ($stmt->execute()) {
                header('Location: login.php');
                exit;
            } else {
                $error = "Error al registrar el usuario. Intenta de nuevo.";
            }
        } catch (Exception $e) {
            $error = "Error en el registro: " . $e->getMessage();
        }
    }
}
?>

<link rel="stylesheet" href="../../public/css/style.css">

<main>
<body class="fondo">
    <h1>Registro</h1>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form  class= "registro" action="registro.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>
        <br>
        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email" id="email" required>
        <br>
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <label for="confirm_password">Confirmar Contraseña:</label>
        <input type="password" name="confirm_password" id="confirm_password" required>
        <br>
        <button type="submit">Registrar</button>
    </form>
</main>
</body>

<?php include './layout/footer.php'?>
