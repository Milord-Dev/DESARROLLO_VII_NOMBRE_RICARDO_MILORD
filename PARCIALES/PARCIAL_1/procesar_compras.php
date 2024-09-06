<?php
// Incluir el archivo de funciones
include('funciones_tienda.php');

// Definir los productos y sus precios
$productos = [
    'camisa' => 50,
    'pantalon' => 70,
    'zapatos' => 80,
    'calcetines' => 10,
    'gorra' => 25
];

// Definir el carrito de compras
$carrito = [
    'camisa' => 2,
    'pantalon' => 1,
    'zapatos' => 1,
    'calcetines' => 3,
    'gorra' => 0
];

// Calcular el subtotal
$subtotal = 0;
foreach ($carrito as $producto => $cantidad) {
    $subtotal += $productos[$producto] * $cantidad;
}

// Calcular el descuento
$descuento = calcular_descuento($subtotal);

// Calcular el impuesto
$impuesto = aplicar_impuesto($subtotal);

// Calcular el total
$total = calcular_total($subtotal, $descuento, $impuesto);

// Mostrar un resumen de la compra en HTML
echo "<h2>Resumen de la compra</h2>";
echo "<table border='1'>";
echo "<tr><th>Producto</th><th>Cantidad</th><th>Precio</th></tr>";
foreach ($carrito as $producto => $cantidad) {
    if ($cantidad > 0) {
        echo "<tr>";
        echo "<td>$producto</td>";
        echo "<td>$cantidad</td>";
        echo "<td>" . $productos[$producto] . "</td>";
        echo "</tr>";
    }
}
echo "<tr><td>Subtotal</td><td colspan='2'>$subtotal</td></tr>";
echo "<tr><td>Descuento</td><td colspan='2'>-$descuento</td></tr>";
echo "<tr><td>Impuesto</td><td colspan='2'>$impuesto</td></tr>";
echo "<tr><td>Total a pagar</td><td colspan='2'>$total</td></tr>";
echo "</table>";
?>