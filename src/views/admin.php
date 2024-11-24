<?php
session_start();
include 'config.php'; // Conexión a la base de datos
include 'layout/headerLog.php'; // Header para usuarios autenticados
include '../controllers/leer_paquetes.php';
include '../controllers/eliminar_paquetes.php';
include '../controllers/editar_paquetes.php';
include '../controllers/crear_paquetes.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Paquetes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Contenido principal -->
    <main class="container">
        <h2>ADMINISTRAR PAQUETES</h2>
        <div class="line"></div>
        <div class="packages">
            <!-- Mostrar paquetes existentes -->
            <?php foreach ($packages as $package): ?>
                <div class="package">
                    <div class="package-info">
                        <img src="<?php echo htmlspecialchars($package['urlimagen']); ?>" alt="<?php echo htmlspecialchars($package['lugar']); ?>" width="100">
                        <h3><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                             </svg><?php echo htmlspecialchars($package['lugar']); ?></h3>
                        <p>Precio: $<?php echo htmlspecialchars($package['precio']); ?></p>
                        <p>Fecha: <?php echo htmlspecialchars($package['fecha']); ?></p>
                    </div>
                    <div class="actions">
                        <!-- Editar -->
                        <a href="agregar_paquete.php?edit=<?php echo $package['idpaquete']; ?>">
                            <button class="edit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                 <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                 <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                 </svg></button>
                        </a>
                        <!-- Eliminar -->
                        <form action="admin.php" method="POST" style="">
                            <input type="hidden" name="delete_package" value="<?php echo $package['idpaquete']; ?>">
                            <button type="" class=""><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="" >
                                                                 <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                                                 </svg></button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Botón para agregar nuevo paquete -->
            <div class="package add-package">
                <a href="agregar_paquete.php">
                    <button class="agregar_paquete">+</button>
                </a>
            </div>
        </div>
    </main>

    <!-- Pie de página -->
    <footer class="footer">
        <p>Conoce más de 30 destinos diferentes junto a Soma, tu agencia de confianza.</p>
        <div class="footer-links">
            <div>
                <h4>Support</h4>
                <a href="#">Account</a>
                <a href="#">Contact us</a>
            </div>
            <div>
                <h4>About</h4>
                <a href="#">Package</a>
                <a href="#">About Us</a>
            </div>
        </div>
    </footer>
</body>
</html>
