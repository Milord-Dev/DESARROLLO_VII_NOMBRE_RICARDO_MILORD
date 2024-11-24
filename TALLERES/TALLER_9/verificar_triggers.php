
<?php
require_once "config_pdo.php"; // O usar mysqli según prefieras

function verificarCambiosPrecio($pdo, $producto_id, $nuevo_precio) {
    try {
        // Actualizar precio
        $stmt = $pdo->prepare("UPDATE productos SET precio = ? WHERE id = ?");
        $stmt->execute([$nuevo_precio, $producto_id]);
        
        // Verificar log de cambios
        $stmt = $pdo->prepare("SELECT * FROM historial_precios WHERE producto_id = ? ORDER BY fecha_cambio DESC LIMIT 1");
        $stmt->execute([$producto_id]);
        $log = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Cambio de Precio Registrado:</h3>";
        echo "Precio anterior: $" . $log['precio_anterior'] . "<br>";
        echo "Precio nuevo: $" . $log['precio_nuevo'] . "<br>";
        echo "Fecha del cambio: " . $log['fecha_cambio'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function verificarMovimientoInventario($pdo, $producto_id, $nueva_cantidad) {
    try {
        // Actualizar stock
        $stmt = $pdo->prepare("UPDATE productos SET stock = ? WHERE id = ?");
        $stmt->execute([$nueva_cantidad, $producto_id]);
        
        // Verificar movimientos de inventario
        $stmt = $pdo->prepare("
            SELECT * FROM movimientos_inventario 
            WHERE producto_id = ? 
            ORDER BY fecha_movimiento DESC LIMIT 1
        ");
        $stmt->execute([$producto_id]);
        $movimiento = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<h3>Movimiento de Inventario Registrado:</h3>";
        echo "Tipo de movimiento: " . $movimiento['tipo_movimiento'] . "<br>";
        echo "Cantidad: " . $movimiento['cantidad'] . "<br>";
        echo "Stock anterior: " . $movimiento['stock_anterior'] . "<br>";
        echo "Stock nuevo: " . $movimiento['stock_nuevo'] . "<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Probar los triggers
verificarCambiosPrecio($pdo, 1, 999.99);
verificarMovimientoInventario($pdo, 1, 15);

function verificarActualizacionMembresia($pdo, $cliente_id) {
    try {
        // Simular una nueva venta
        $stmt = $pdo->prepare("INSERT INTO detalles_venta (cliente_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)");
        $stmt->execute([$cliente_id, 1, 1, 500.00]); // Ejemplo de una venta
        echo "Se ha registrado una nueva venta para el cliente con ID: $cliente_id.<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function verificarEstadisticasCategoria($pdo, $categoria_id) {
    try {
        // Simular una nueva venta
        $stmt = $pdo->prepare("INSERT INTO detalles_venta (categoria_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)");
        $stmt->execute([$categoria_id, 1, 1, 250.00]); // Ejemplo de una venta
        echo "Se ha registrado una nueva venta en la categoría con ID: $categoria_id.<br>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function verificarAlertaStockCritico($pdo, $producto_id, $nuevo_stock) {
    try {
        // Actualizar stock a un nivel crítico
        $stmt = $pdo->prepare("UPDATE productos SET stock = ? WHERE id = ?");
        $stmt->execute([$nuevo_stock, $producto_id]);
        
        // Verificar alertas de stock
        $stmt = $pdo->prepare("SELECT * FROM alertas_stock WHERE producto_id = ? ORDER BY fecha_alerta DESC LIMIT 1");
        $stmt->execute([$producto_id]);
        $alerta = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($alerta) {
            echo "Alerta de stock crítico para el producto ID: " . $alerta['producto_id'] . " - " . $alerta['mensaje'] . "<br>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function verificarHistorialEstadoClientes($pdo, $cliente_id, $nuevo_estado) {
    try {
        // Actualizar el estado del cliente
        $stmt = $pdo->prepare("UPDATE clientes SET estado = ? WHERE id = ?");
        $stmt->execute([$nuevo_estado, $cliente_id]);
        
        // Verificar log de cambios de estado
        $stmt = $pdo->prepare("SELECT * FROM log_clientes WHERE cliente_id = ? ORDER BY fecha_cambio DESC LIMIT 1");
        $stmt->execute([$cliente_id]);
        $log = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($log) {
            echo "Historial de estado del cliente ID: " . $log['cliente_id'] . " - Estado anterior: " . $log['estado_anterior'] . ", Nuevo estado: " . $log['estado_nuevo'] . "<br>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Probar los triggers
verificarActualizacionMembresia($pdo, 1);
verificarEstadisticasCategoria($pdo, 1);
verificarAlertaStockCritico($pdo, 1, 3); 
verificarHistorialEstadoClientes($pdo, 1, 'inactivo');

$pdo = null;
?>