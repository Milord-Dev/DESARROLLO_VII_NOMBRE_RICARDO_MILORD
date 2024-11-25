<?php
session_start(); // Asegúrate de iniciar sesión al principio de cada página
include 'layout/headerLog.php'; 
include 'config.php'; // Asegúrate de que la conexión esté correcta

// Consultar todos los usuarios
$sql = "SELECT id, nombre, correo_electronico, contrasena FROM usuarios";
$result = $conn->query($sql);
?>

<main>
    <h2>Gestión de Usuarios</h2>

    <!-- Tabla de usuarios -->
    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Contraseña</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Mostrar cada fila de usuario
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["nombre"] . "</td>";
                    echo "<td>" . $row["correo_electronico"] . "</td>";
                    echo "<td>" . $row["contrasena"] . "</td>";
                    echo "<td><a href='gestion_usuarios.php?id=" . $row["id"] . "' class='delete-btn'>Eliminar</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay usuarios disponibles</td></tr>";
            }
            ?>
        </tbody>
    </table>
</main>

<?php
// Verificar si se pasó el id por GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar el usuario con el id especificado
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirigir a la página de gestión de usuarios después de eliminar
        header("Location: gestion_usuarios.php?mensaje=Usuario eliminado correctamente.");
        exit(); // Asegurarse de que la ejecución se detiene aquí después de redirigir
    } else {
        echo "Error al eliminar el usuario: " . $conn->error;
    }

    // Cerrar la conexión
    $stmt->close();
} else {
    echo "No se ha proporcionado un id válido.";
}

$conn->close();
?>

<?php include './layout/footer.php'; ?>
