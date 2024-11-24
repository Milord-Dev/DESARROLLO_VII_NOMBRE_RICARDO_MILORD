<?php

for ($i = 1; $i <= 5; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo "*";
    }
    echo "<br>";
}

echo "<br>";

echo "Números impares del 1 al 20:<br>";
$numero = 1;
while ($numero <= 20) {
    if ($numero % 2 != 0) {
        echo $numero . "<br>";
    }
    $numero++;
}

echo "<br>";

echo "Contador regresivo desde 10 hasta 1, saltando el número 5:<br>";
$contador = 10;
do {
    if ($contador == 5) {
        $contador--;
        continue; // Saltar el número 5
    }
    echo $contador . "<br>";
    $contador--;
} while ($contador >= 1);

?>
