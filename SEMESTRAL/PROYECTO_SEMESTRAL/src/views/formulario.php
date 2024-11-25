<?php
session_start(); // Asegúrate de iniciar sesión al principio de cada página
include 'layout/headerlog.php'; 
include 'config.php';
?>
<main>
    <div class="contact-form">
  <h2>Contact us</h2>
  <label for="nombre">Formulario de contacto</label>
  <input type="text" id="nombre" name="nombre" placeholder="Nombre">
  <input type="email" id="correo" name="correo" placeholder="Correo electrónico">
  <textarea id="consulta" name="consulta" placeholder="Consulta"></textarea>
  <p>Nuestros operadores se comunicarán con usted para atender su consulta vía correo electrónico</p>
  <button type="submit" class="submit-btn">Enviar</button>
</div>
</main>
<?php include './layout/footer.php'?>