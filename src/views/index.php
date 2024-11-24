<?php
session_start(); // Asegúrate de iniciar sesión al principio de cada página
include 'layout/headerlog.php'; 
include 'config.php';
include '../controllers/leer_paquetes.php';
?>

<main>
    <!-- Sección principal -->
    <section class="hero">
        <div class="hero-content">
            <h1>Descubre tu siguiente aventura con Soma</h1>
            <p>Mira más de todas las promociones y paquetes que disponemos para ti y tengas una aventura inolvidable</p>
            <a href="paquetes.php" class="btn">Paquetes</a>
        </div>
    </section>
    
    <!-- Paquetes Populares -->
    <section class="popular-packages">
        <h2>Paquetes Populares</h2>
        <p>Disfrutemos de este cielo en la tierra</p>
        <div class="packages">
            <!-- Mostrar paquetes existentes -->
            <?php foreach ($packages as $package): ?>
                <a href="detallePaquete.php?package=<?php echo $package['idpaquete']; ?>" class="package-link">
                    <div class="package">
                        <div class="package-info">
                            <img src="<?php echo htmlspecialchars($package['urlimagen']); ?>" alt="<?php echo htmlspecialchars($package['lugar']); ?>" width="100">
                            <h3>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                                </svg>
                                <?php echo htmlspecialchars($package['lugar']); ?>
                            </h3>
                            <p>Precio: $<?php echo htmlspecialchars($package['precio']); ?></p>
                            <p>Fecha: <?php echo htmlspecialchars($package['fecha']); ?></p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <a href="paquetes.php" class="view-more">Ver más paquetes</a>
    </section>
</main>

<?php include './layout/footer.php'; ?>
