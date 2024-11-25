<?php
session_start(); // Asegúrate de iniciar sesión al principio de cada página
require_once 'config.php'; // Archivo de conexión a la base de datos
include 'layout/headerlog.php'; // Header para usuarios autenticados

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    die("Debes iniciar sesión para ver tus reservas.");
}

// Obtener el ID del usuario desde la sesión
$user_id = intval($_SESSION['user_id']);

// Crear conexión a la base de datos
$connection = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Verificar conexión
if ($connection->connect_error) {
    die("Error en la conexión a la base de datos: " . $connection->connect_error);
}

// Consultar las reservas del usuario autenticado
$query = "SELECT r.idreserva, r.fecha_reserva, p.lugar, p.descripcion, p.precio, p.urlimagen 
          FROM reservas r 
          INNER JOIN paquetes p ON r.idpaquete = p.idpaquete 
          WHERE r.idusuario = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservas</title>
    <style>
        .reservation {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .reservation img {
            max-width: 200px;
            height: auto;
            margin-bottom: 10px;
        }
        .reservation h3 {
            margin: 0;
            color: #333;
        }
        .reservation p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <h1>Mis Reservas</h1>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="reservation">
                <img src="<?php echo htmlspecialchars($row['urlimagen']); ?>" alt="Imagen del paquete">
                <h3><?php echo htmlspecialchars($row['lugar']); ?></h3>
                <p><?php echo htmlspecialchars($row['descripcion']); ?></p>
                <p><strong>Precio:</strong> $<?php echo number_format($row['precio'], 2); ?></p>
                <p><strong>Fecha de reserva:</strong> <?php echo date("d-m-Y H:i:s", strtotime($row['fecha_reserva'])); ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No tienes reservas registradas.</p>
    <?php endif; ?>

<?php $stmt->close(); $connection->close(); ?> <!-- Cerrar conexión -->
</body>
</html>
<?php include './layout/footer.php'; ?>
