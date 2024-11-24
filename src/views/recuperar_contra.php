<?php
session_start(); // Asegúrate de iniciar sesión al principio de cada página
include 'layout/headerlog.php'; 
?>

<main>
    <div class="container"> 
    <!-- Recuperar contraseña -->
    <div class="form-card">
      <h2>¿Olvidaste tu contraseña?</h2>
      <p>Tu contraseña se enviará a tu correo electrónico</p>
      <form>
        <input type="email" placeholder="Correo electrónico" required>
        <button type="submit">Enviar</button>
      </form>
      <a href="login.php" class="link">Regresar al Login</a>
    </div>
</main>
<?php include './layout/footer.php'?>