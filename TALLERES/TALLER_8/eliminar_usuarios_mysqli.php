<?php
require_once "config_mysqli.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Consulta SQL para eliminar el usuario con el email proporcionado
    $sql = "DELETE FROM usuarios WHERE email = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $email);  // Sólo necesitamos el email
        
        if(mysqli_stmt_execute($stmt)){
            echo "Usuario eliminado con éxito.";
        } else{
            echo "ERROR: No se pudo ejecutar $sql. " . mysqli_error($conn);
        }
    }
    
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div><label>Email</label><input type="email" name="email" required></div>
    <input type="submit" value="Eliminar Usuario">
</form>
