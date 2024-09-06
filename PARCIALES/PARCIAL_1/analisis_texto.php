<?php 
include 'utilidades_texto.php';
//varibles 
$frases = ["Esta sera una frase para el ejemplo del parcial tiene: ",
"Esta es otra frase para que pueda evaluar las funciones tiene: ",
"El cielo es azul, las estrellas no tiene: "];

//impresiones 
echo "<table border='1'>";
echo "<tr><th>Frase</th><th>Palabras</th><th>Vocales</th><th>Invertido</th></tr>";

echo "</table>";

foreach ($frases as $frase) {
    $num_palabras = contar_palabras($frase);
    $num_vocales = contar_vocales($frase);
    $frase_invertida = invertir_palabras($frase);
    
    echo "<tr>";
    echo "<td>$frase</td>";
    echo "<td>$num_palabras</td> <br>";
    echo "<td>$num_vocales</td> <br>";
    echo "<td>$frase_invertida</td> <br>";
    echo "</tr>";
}

?>