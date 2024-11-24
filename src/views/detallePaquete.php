<?php
session_start(); // Asegúrate de iniciar sesión al principio de cada página
include 'config.php'; // Conexión a la base de datos
include 'layout/headerlog.php'; 

// Crear conexión a la base de datos
$connection = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Verificar conexión
if ($connection->connect_error) {
    die("Error en la conexión a la base de datos: " . $connection->connect_error);
}

// Obtener el paquete seleccionado desde la URL
if (isset($_GET['package']) && is_numeric($_GET['package'])) {
    $paquete_id = intval($_GET['package']); // Asegurarse de que sea un entero para evitar inyecciones SQL

    // Consultar el paquete en la base de datos
    $query = "SELECT * FROM paquetes WHERE idpaquete = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $paquete_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $paquete = $result->fetch_assoc();
        $titulo = $paquete['lugar'];
        $descripcion = $paquete['descripcion'];
        $imagen = $paquete['urlimagen'];
        $precio = $paquete['precio'];
    } else {
        // Si no se encuentra el paquete, mostrar un mensaje de error
        $titulo = "Paquete no encontrado";
        $descripcion = "Lo sentimos, el paquete seleccionado no existe.";
        $imagen = "";
        $precio = 0.00;
    }
} else {
    // Si no se envía un parámetro válido, mostrar error
    $titulo = "Paquete no especificado";
    $descripcion = "No se proporcionó un paquete válido para mostrar.";
    $imagen = "";
    $precio = 0.00;
}

// Procesar la reserva
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reservar_paquete'])) {
    // Asegúrate de que el usuario esté autenticado
    if (!isset($_SESSION['user_id'])) {
        die("Debe iniciar sesión para reservar un paquete.");
    }

    $user_id = intval($_SESSION['user_id']); // Obtener el ID del usuario desde la sesión

    // Insertar la reserva en la base de datos
    $query = "INSERT INTO reservas (idusuario, idpaquete) VALUES (?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ii", $user_id, $paquete_id);

    if ($stmt->execute()) {
        // Redirigir o mostrar mensaje de éxito
        header("Location: misReservas.php?success=1");
        exit();
    } else {
        echo "Error al reservar el paquete: " . $connection->error;
    }
}
?>

<main class="package-detail">
    <h1><?php echo htmlspecialchars($titulo); ?></h1>
    <?php if (!empty($imagen)): ?>
        <img src="<?php echo htmlspecialchars($imagen); ?>" alt="<?php echo htmlspecialchars($titulo); ?>">
    <?php endif; ?>
    <p><?php echo htmlspecialchars($descripcion); ?></p>
    <p class="price">Precio: $<?php echo number_format($precio, 2); ?></p> 

    <!-- Formulario para reservar el paquete -->
    <?php if (!empty($paquete_id)): ?>
        <form method="POST" action="">
            <input type="hidden" name="reservar_paquete" value="1">
            <button type="submit" class="button">Reservar Paquete</button>
        </form>
    <?php endif; ?>
    <div class="espacios"></div>
</main>
</body>
</html>
<?php include './layout/footer.php'; ?>
