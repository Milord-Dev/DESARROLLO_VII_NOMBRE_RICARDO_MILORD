<?php
// Función para calcular el descuento
function calcular_descuento($total_compra) {
    if ($total_compra < 100) {
        return 0;
    } elseif ($total_compra >= 100 && $total_compra <= 500) {
        return $total_compra * 0.05;
    } elseif ($total_compra > 500 && $total_compra <= 1000) {
        return $total_compra * 0.10;
    } else {
        return $total_compra * 0.15;
    }
}

// Función para aplicar el impuesto
function aplicar_impuesto($subtotal) {
    return $subtotal * 0.07;
}

// Función para calcular el total a pagar
function calcular_total($subtotal, $descuento, $impuesto) {
    return $subtotal - $descuento + $impuesto;
}
?>