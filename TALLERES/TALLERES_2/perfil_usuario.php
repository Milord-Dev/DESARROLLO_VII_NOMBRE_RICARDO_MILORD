<?php 
// varibles 
$nombre_completo = "Ricardo Milord";
$edad = 23;
$correo = "ricardo.milord@utp.ac.pa";
$telefono = 67735986;
// variables de mensaje 
$mensaje1 = " 
    Enunciado:
    Crea un nuevo archivo llamado perfil_usuario.php en la carpeta TALLER_2.
    Define las siguientes variables:
    nombre_completo ($nombre_completo)
    edad ($edad)
    correo ($correo)
    telefono ($telefono)
";
$mensaje2 = "
    Define una constante llamada OCUPACION con tu ocupación actual (por ejemplo, Estudiante).
    Crea un párrafo que incluya toda esta información utilizando diferentes métodos de concatenación e impresión que hemos aprendido (echo, print, printf).
    Al final, utiliza var_dump para mostrar el tipo y valor de cada variable y la constante.
    Asegúrate de que cada pieza de información se muestre en una nueva línea en el navegador.
    Guarda el archivo, visualízalo en el navegador y haz un commit con el mensaje Ejercicio de perfil de usuario completado.
";
$mensaje3 = "Hola mundo!!!";

//definicion de una constante 
define("OCUPACION"," Soy estudiante");

//impresiones 
echo $mensaje1 . "<br>";
echo $mensaje2 . "<br>";
print($mensaje3 . "<br>");
printf("Hola mundo tine %d años de existir (es mentira)" , $edad , "<br>");
var_dump($nombre_completo);
echo "<br>";
var_dump($edad);
echo "<br>";
var_dump($correo);
echo "<br>";
var_dump($telefono);
echo "<br>";
var_dump($mensaje1);
echo "<br>";
var_dump($mensaje2);
echo "<br>";
var_dump($mensaje3);
echo "<br>";
var_dump(OCUPACION);

?>