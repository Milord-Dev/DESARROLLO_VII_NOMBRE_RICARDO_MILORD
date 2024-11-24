<?php
session_start();
include 'layout/headerLog.php'; // Header para usuarios autenticados
include 'config.php';

// Verificar si se está editando un paquete
if (isset($_GET['index'])) {
    $index = $_GET['index'];
    $package = getPackageById($index); // Obtener paquete desde la base de datos
    $is_edit = true;
} else {
    $package = ['title' => '', 'location' => '', 'image' => '', 'date' => '', 'price' => ''];
    $is_edit = false;
}

// Función para obtener el paquete por ID
function getPackageById($id) {
    global $conn;
    $query = "SELECT * FROM paquetes WHERE idpaquete = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Procesar el formulario si se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_package'])) {
    // Recuperar los datos del formulario
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $image = htmlspecialchars($_POST['image']);
    $date = htmlspecialchars($_POST['date']);
    $price = htmlspecialchars($_POST['price']);

    // Si estamos editando, actualizamos el paquete
    if ($is_edit) {
        $query = "UPDATE paquetes SET lugar = ?, descripcion = ?, urlimagen = ?, fecha = ?, precio = ? WHERE idpaquete = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssdi", $name, $description, $image, $date, $price, $index);
        $stmt->execute();
    } else {
        // Si es nuevo, insertamos el paquete
        $query = "INSERT INTO paquetes (lugar, descripcion, urlimagen, fecha, precio) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssd", $name, $description, $image, $date, $price);
        $stmt->execute();
    }

    // Redirigir a la página de administración
    header('Location: admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $is_edit ? 'Editar Paquete' : 'Agregar Paquete'; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Contenido principal -->
    <main class="container">
        <h2><?php echo $is_edit ? 'Editar Paquete' : 'Agregar Paquete'; ?></h2>
        <p class="subtitle"><a href="#">Encuentra un viaje que se adapte a un estilo de vida</a></p>
        <div class="line"></div>

        <!-- Formulario de agregar o editar paquete -->
        <form method="POST" action="agregar_paquete.php<?php echo $is_edit ? '?index=' . $index : ''; ?>" class="add-package-form">
            <!-- Información del paquete -->
            <div class="form-group">
                <label for="name">Nombre del Paquete</label>
                <input type="text" id="name" name="name" placeholder="Nombre del paquete" value="<?php echo htmlspecialchars($package['title']); ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Información del paquete</label>
                <textarea id="description" name="description" rows="5" placeholder="Descripción del paquete" required><?php echo htmlspecialchars($package['location']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="image">URL de la imagen</label>
                <input type="text" id="image" name="image" placeholder="URL de la imagen" value="<?php echo htmlspecialchars($package['image']); ?>" required>
            </div>

            <div class="form-group">
                <label for="date">Fecha del Paquete</label>
                <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($package['date']); ?>" required>
            </div>

            <div class="form-group">
                <label for="price">Precio del Paquete (USD)</label>
                <input type="number" id="price" name="price" placeholder="Precio del paquete" step="0.01" value="<?php echo htmlspecialchars($package['price']); ?>" required>
            </div>

            <!-- Botón para agregar o guardar -->
            <div class="add-package-btn">
                <button type="submit" name="create_package" class="create-button"><?php echo $is_edit ? 'Guardar Cambios' : 'Crear Paquete'; ?></button>
            </div>
        </form>
    </main>

    <!-- Pie de página -->
    <footer class="footer">
        <p>Conoce más de 30 destinos diferentes junto a Soma, tu agencia de confianza.</p>
        <div class="footer-links">
            <div>
                <h4>Soma</h4>
                <a href="#">Support</a>
            </div>
            <div>
                <h4>Support</h4>
                <a href="#">Contact us</a>
            </div>
        </div>
    </footer>
</body>
</html>
