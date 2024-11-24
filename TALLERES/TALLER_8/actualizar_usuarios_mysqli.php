<?php
require_once "config_mysqli.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Consulta SQL para actualizar el usuario
    $sql = "UPDATE usuarios SET nombre = ? WHERE email = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "ss", $nombre, $email);
        
        if(mysqli_stmt_execute($stmt)){
            echo "Usuario actualizado con éxito.";
        } else{
            echo "ERROR: No se pudo ejecutar $sql. " . mysqli_error($conn);
        }
    }
    
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div><label>Nombre</label><input type="text" name="nombre" required></div>
    <div><label>Email</label><input type="email" name="email" required></div>
    <input type="submit" value="Actualizar Usuario">
</form>
