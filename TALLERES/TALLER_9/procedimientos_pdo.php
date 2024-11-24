
<?php
require_once "config_pdo.php";

// Función para registrar una venta
function registrarVenta($pdo, $cliente_id, $producto_id, $cantidad) {
    try {
        $stmt = $pdo->prepare("CALL sp_registrar_venta(:cliente_id, :producto_id, :cantidad, @venta_id)");
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
        $stmt->execute();
        
        // Obtener el ID de la venta
        $result = $pdo->query("SELECT @venta_id as venta_id")->fetch(PDO::FETCH_ASSOC);
        
        echo "Venta registrada con éxito. ID de venta: " . $result['venta_id'];
    } catch (PDOException $e) {
        echo "Error al registrar la venta: " . $e->getMessage();
    }
}

// Función para obtener estadísticas de cliente
function obtenerEstadisticasCliente($pdo, $cliente_id) {
    try {
        $stmt = $pdo->prepare("CALL sp_estadisticas_cliente(:cliente_id)");
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $estadisticas = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Estadísticas del Cliente</h3>";
        echo "Nombre: " . $estadisticas['nombre'] . "<br>";
        echo "Membresía: " . $estadisticas['nivel_membresia'] . "<br>";
        echo "Total compras: " . $estadisticas['total_compras'] . "<br>";
        echo "Total gastado: $" . $estadisticas['total_gastado'] . "<br>";
        echo "Promedio de compra: $" . $estadisticas['promedio_compra'] . "<br>";
        echo "Últimos productos: " . $estadisticas['ultimos_productos'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Ejemplos de uso
registrarVenta($pdo, 1, 1, 2);
obtenerEstadisticasCliente($pdo, 1);


function procesarDevolucion($pdo, $venta_id, $producto_id, $cantidad_devuelta) {
    try {
        $stmt = $pdo->prepare("CALL sp_procesar_devolucion(:venta_id, :producto_id, :cantidad_devuelta)");
        $stmt->bindParam(':venta_id', $venta_id, PDO::PARAM_INT);
        $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
        $stmt->bindParam(':cantidad_devuelta', $cantidad_devuelta, PDO::PARAM_INT);
        $stmt->execute();
        echo "Devolución procesada con éxito.". "<br>";
    } catch (PDOException $e) {
        echo "Error al procesar la devolución: " . $e->getMessage(). "<br>";
    }
}

// Ejemplo de uso
procesarDevolucion($pdo, 1, 1, 1);

function aplicarDescuentoHistorial($pdo, $cliente_id) {
    try {
        $stmt = $pdo->prepare("CALL sp_aplicar_descuento_historial(:cliente_id, @descuento_aplicado)");
        $stmt->bindParam(':cliente_id', $cliente_id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $pdo->query("SELECT @descuento_aplicado AS descuento_aplicado")->fetch(PDO::FETCH_ASSOC);
        echo "Descuento aplicado: " . $result['descuento_aplicado'] . "%". "<br>";
    } catch (PDOException $e) {
        echo "Error al aplicar el descuento: " . $e->getMessage(). "<br>";
    }
}

// Ejemplo de uso
aplicarDescuentoHistorial($pdo, 1);

function reporteBajoStock($pdo, $stock_min) {
    try {
        $stmt = $pdo->prepare("CALL sp_reporte_bajo_stock(:stock_min, @resultado)");
        $stmt->bindParam(':stock_min', $stock_min, PDO::PARAM_INT);
        $stmt->execute();

        $result = $pdo->query("SELECT @resultado AS resultado")->fetch(PDO::FETCH_ASSOC);
        echo "Productos con bajo stock: " . $result['resultado']. "<br>";
    } catch (PDOException $e) {
        echo "Error al generar el reporte: " . $e->getMessage(). "<br>";
    }
}

// Ejemplo de uso
reporteBajoStock($pdo, 10);

function calcularComisiones($pdo, $vendedor_id) {
    try {
        $stmt = $pdo->prepare("CALL sp_calcular_comisiones(:vendedor_id, @comision_total)");
        $stmt->bindParam(':vendedor_id', $vendedor_id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $pdo->query("SELECT @comision_total AS comision_total")->fetch(PDO::FETCH_ASSOC);
        echo "Comisión total: $" . $result['comision_total']. "<br>";
    } catch (PDOException $e) {
        echo "Error al calcular la comisión: " . $e->getMessage(). "<br>";
    }
}

// Ejemplo de uso
calcularComisiones($pdo, 1);
$pdo = null;
?>