<?php
session_start(); // Asegúrate de iniciar sesión al principio de cada página

include 'layout/headerlog.php'; 
include "config.php"; // Asegúrate de que la conexión esté correcta

// Verificar si se ha enviado el formulario de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo']);
    $contraseña = trim($_POST['contraseña']);

    // Preparar y ejecutar la consulta para verificar el usuario
    $query = "SELECT id, contrasena FROM usuarios WHERE correo_electronico = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $correo); // Vincula el parámetro 'correo' como string

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // El correo existe, verificar la contraseña
        $user = $result->fetch_assoc();
        if (password_verify($contraseña, $user['contrasena'])) {
            // Contraseña correcta, iniciar sesión
            $_SESSION['user_id'] = $user['id']; // Guardar el ID del usuario en la sesión
            header('Location: index.php'); // Redirigir al home después del login
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Correo no encontrado.";
    }
}
?>


<main>
<body class="fondo">
    <div class="login-container">
        <h1 class="title">Login</h1>
        <?php if (!empty($error)): ?>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form class="login-form" method="POST" action="login.php">
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <input type="password" name="contraseña" placeholder="Contraseña" required>
            <button type="submit" class="login-button">Iniciar sesión</button>
            <p class="forgot-password"><a href="recuperar_contra.php">¿Olvidaste tu contraseña?</a></p>
        </form>
    </div>
</body>
</main>

<?php include './layout/footer.php'?>
