<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soma || Agencia de Viajes</title>
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/style.css"> 
</head>
<body>
    <!-- Encabezado de la pagina -->
    <header>
        <nav>
            <ul>
            <?php
                    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 4) { 
                         echo '<li><a href="index.php">Soma</a></li>';
                        echo ' <li><a href="admin.php">Administrar Paquetes</a></li>';
                         echo '<li><a href="gestion_usuarios.php">Gestion de Usuario</a></li>';
                        echo ' <li><a href="logout.php">LogOut</a></li>';
                    } else {
                        
                    
                ?>
                <li><a href="index.php">Soma</a></li>
                <li><a href="paquetes.php">Paquetes</a></li>
                <li><a href="misReservas.php">Mis Reservas</a></li>
                <?php
                    if (isset($_SESSION['user_id'])) { // Si el usuario está autenticado
                        echo '<li><a href="logout.php" class="signup">LogOut</a></li>';
                    } else {
                        echo '<li><a href="login.php" class="signup">Iniciar sesión</a></li>';
                        echo '<li><a href="registro.php" class="signup">Registrase</a></li>';
                    }
                }
                ?>
            </ul>
        </nav>
    </header>
</body>
</html>
