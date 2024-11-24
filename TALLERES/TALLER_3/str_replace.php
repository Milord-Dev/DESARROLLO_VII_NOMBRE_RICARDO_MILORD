
<?php
// Ejemplo de uso de str_replace()
$frase = "El gato negro saltó sobre el perro negro";
$fraseModificada = str_replace("negro", "blanco", $frase);

echo "Frase original: $frase</br>";
echo "Frase modificada: $fraseModificada</br>";

// Ejercicio: Crea una variable con una frase que contenga al menos tres veces la palabra "PHP"
// y usa str_replace() para cambiar "PHP" por "JavaScript"
$miFrase = "Este es laboratorio de PHP donde el profesor nos enseña PHP y nos gusta PHP"; // Reemplaza esto con tu frase
$miFraseModificada = str_replace("PHP", "JavaScript", $miFrase);

echo "</br>Mi frase original: $miFrase</br>";
echo "Mi frase modificada: $miFraseModificada</br>";

// Bonus: Usa str_replace() para reemplazar múltiples palabras a la vez
$texto = "Me gusta Elden Ring y Skyrim. los mejores juego que pueden excistir Elden Ring Skyrim";
$buscar = ["Elden Ring", "Skyrimn"];
$reemplazar = ["Patapon", "Socom"];
$textoModificado = str_replace($buscar, $reemplazar, $texto);

echo "</br>Texto original: $texto</br>";
echo "Texto modificado: $textoModificado</br>";
?>
          
