<?php
require_once "config_mysqli.php";

// Función para registrar una venta
function registrarVenta($conn, $cliente_id, $producto_id, $cantidad) {
    $query = "CALL sp_registrar_venta(?, ?, ?, @venta_id)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iii", $cliente_id, $producto_id, $cantidad);
    
    try {
        mysqli_stmt_execute($stmt);
        
        // Obtener el ID de la venta
        $result = mysqli_query($conn, "SELECT @venta_id as venta_id");
        $row = mysqli_fetch_assoc($result);
        
        echo "Venta registrada con éxito. ID de venta: " . $row['venta_id'];
    } catch (Exception $e) {
        echo "Error al registrar la venta: " . $e->getMessage();
    }
    
    mysqli_stmt_close($stmt);
}

// Función para obtener estadísticas de cliente
function obtenerEstadisticasCliente($conn, $cliente_id) {
    $query = "CALL sp_estadisticas_cliente(?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $cliente_id);
    
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        $estadisticas = mysqli_fetch_assoc($result);
        
        echo "<h3>Estadísticas del Cliente</h3>";
        echo "Nombre: " . $estadisticas['nombre'] . "<br>";
        echo "Membresía: " . $estadisticas['nivel_membresia'] . "<br>";
        echo "Total compras: " . $estadisticas['total_compras'] . "<br>";
        echo "Total gastado: $" . $estadisticas['total_gastado'] . "<br>";
        echo "Promedio de compra: $" . $estadisticas['promedio_compra'] . "<br>";
        echo "Últimos productos: " . $estadisticas['ultimos_productos'] . "<br>";
    }
    
    mysqli_stmt_close($stmt);
}

// Ejemplos de uso
registrarVenta($conn, 1, 1, 2);
obtenerEstadisticasCliente($conn, 1);


function procesarDevolucion($conn, $venta_id, $producto_id, $cantidad_devuelta) {
    $query = "CALL sp_procesar_devolucion(?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "iii", $venta_id, $producto_id, $cantidad_devuelta);

    try {
        mysqli_stmt_execute($stmt);
        echo "Devolución procesada con éxito.". "<br>";
    } catch (Exception $e) {
        echo "Error al procesar la devolución: " . $e->getMessage(). "<br>";
    }

    mysqli_stmt_close($stmt);
}

// Ejemplo de uso
procesarDevolucion($conn, 1, 1, 1);



function aplicarDescuentoHistorial($conn, $cliente_id) {
    $query = "CALL sp_aplicar_descuento_historial(?, @descuento_aplicado)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $cliente_id);

    try {
        mysqli_stmt_execute($stmt);
        $result = mysqli_query($conn, "SELECT @descuento_aplicado AS descuento_aplicado");
        $row = mysqli_fetch_assoc($result);
        echo "Descuento aplicado: " . $row['descuento_aplicado'] . "%". "<br>";
    } catch (Exception $e) {
        echo "Error al aplicar el descuento: " . $e->getMessage(). "<br>";
    }

    mysqli_stmt_close($stmt);
}

// Ejemplo de uso
aplicarDescuentoHistorial($conn, 1);

function reporteBajoStock($conn, $stock_min) {
    $query = "CALL sp_reporte_bajo_stock(?, @resultado)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $stock_min);

    try {
        mysqli_stmt_execute($stmt);
        $result = mysqli_query($conn, "SELECT @resultado AS resultado");
        $row = mysqli_fetch_assoc($result);
        echo "Productos con bajo stock: " . $row['resultado']. "<br>";
    } catch (Exception $e) {
        echo "Error al generar el reporte: " . $e->getMessage(). "<br>";
    }

    mysqli_stmt_close($stmt);
}

// Ejemplo de uso
reporteBajoStock($conn, 10);

function calcularComisiones($conn, $vendedor_id) {
    $query = "CALL sp_calcular_comisiones(?, @comision_total)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $vendedor_id);

    try {
        mysqli_stmt_execute($stmt);
        $result = mysqli_query($conn, "SELECT @comision_total AS comision_total");
        $row = mysqli_fetch_assoc($result);
        echo "Comisión total: $" . $row['comision_total']. "<br>";
    } catch (Exception $e) {
        echo "Error al calcular la comisión: " . $e->getMessage(). "<br>";
    }

    mysqli_stmt_close($stmt);
}

// Ejemplo de uso
calcularComisiones($conn, 1);
mysqli_close($conn);
?>