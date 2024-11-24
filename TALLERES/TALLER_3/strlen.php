<?php 
// Ejemplo de uso de strlen()
$nombre = "Juan Pérez";
$longitud = strlen($nombre);

echo "El nomvbre '$nombre' tiene $longitud caracteres";

//Ejercicio: Crea una variable con tu nombre completo y usa strlen() para mostrar su longitud
$miNombre = "Ricardo Milord"; // Reemplaza esto con tu nombre completo
$longitudMiNombre = strlen($miNombre);

echo "<br> Mi nombre completo $miNombre tiene $longitudMiNombre caracteres. <br>";

// Bonus: Crea una función que tome un string como parámetro y devuelva si es "corto" (menos de 5 caracteres), "medio" (entre 5 y 10 caracteres) o "largo" (más de 10 caracteres)
function categorizarLongitud($miNombre) {
    $longitud = strlen($miNombre);
    if ($longitud < 5) {
        return "corto";
    } elseif ($longitud <= 10) {
        return "medio";
    } else {
        return "largo";
    }
}

$categoria = categorizarLongitud($miNombre);
echo "</br>Mi nombre es considerado $categoria.";
?>