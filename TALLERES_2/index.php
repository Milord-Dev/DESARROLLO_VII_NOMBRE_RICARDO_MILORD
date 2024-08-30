<?php
// Tu código PHP irá aquí
$nombre = "Juan";
$edad = 25;
$altura = 1.75;
$esEstudiante = true;

//concatenacion usando operador.
$presentacion1 = "Hola, mi nombre es " . $nombre . " y tengo de edad " . $edad . " años";

//concatenacion dentro de comillas dobles 
$presentacion2 = "Hola, mi nombre es $nombre y tengo $edad años";

//definicion de una constante 
define ("SALUDO" , "¡Bienvenido!");

//concatenacion con constante 
$mensaje = SALUDO . " " . $nombre;

//impresiones
echo "Nombre: $nombre <br>";
echo "Edad: $edad <br>";
echo "Altura: $altura <br>";
echo "Es estudiante? ". ($esEstudiante ? "si " : " no " . "<br>");
echo $presentacion1 . "<br>";
echo $presentacion2 . "<br>";
echo $mensaje . "<br>";

?>