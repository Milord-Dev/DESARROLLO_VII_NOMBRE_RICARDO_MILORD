<?php
require_once "config_pdo.php";

class OrderProcessor {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function processOrder($cliente_id, $items) {
        try {
            $this->pdo->beginTransaction();

            // Insertar la orden en la tabla 'pedidos'
            $stmt = $this->pdo->prepare("INSERT INTO pedidos (cliente_id, total) VALUES (?, 0)");
            $stmt->execute([$cliente_id]);
            $pedido_id = $this->pdo->lastInsertId();

            $this->pdo->exec("SAVEPOINT pedido_creado");

            $total_pedido = 0;
            $items_procesados = 0;

            foreach ($items as $item) {
                try {
                    // Consultar stock y precio
                    $stmt = $this->pdo->prepare("SELECT stock, precio FROM productos WHERE id = ? FOR UPDATE");
                    $stmt->execute([$item['producto_id']]);
                    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($producto['stock'] < $item['cantidad']) {
                        throw new Exception("Stock insuficiente para el producto {$item['producto_id']}");
                    }

                    // Crear savepoint para cada item
                    $this->pdo->exec("SAVEPOINT item_" . $items_procesados);

                    // Actualizar stock
                    $stmt = $this->pdo->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
                    $stmt->execute([$item['cantidad'], $item['producto_id']]);

                    // Insertar detalle del pedido
                    $subtotal = $producto['precio'] * $item['cantidad'];
                    $stmt = $this->pdo->prepare("INSERT INTO detalles_pedido (pedido_id, producto_id, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$pedido_id, $item['producto_id'], $item['cantidad'], $producto['precio'], $subtotal]);

                    $total_pedido += $subtotal;
                    $items_procesados++;

                } catch (Exception $e) {
                    $this->pdo->exec("ROLLBACK TO SAVEPOINT item_" . ($items_procesados - 1));
                    echo "Error procesando item: " . $e->getMessage() . "<br>";
                    continue;
                }
            }

            // Actualizar el total de la orden
            $stmt = $this->pdo->prepare("UPDATE pedidos SET total = ? WHERE id = ?");
            $stmt->execute([$total_pedido, $pedido_id]);

            $this->pdo->commit();
            echo "Pedido procesado exitosamente<br>";

        } catch (Exception $e) {
            $this->pdo->rollBack();
            echo "Error en el procesamiento del pedido: " . $e->getMessage();
        }
    }
}

// Ejemplo de uso
$orderProcessor = new OrderProcessor($pdo);
$items = [
    ['producto_id' => 1, 'cantidad' => 2],
    ['producto_id' => 2, 'cantidad' => 3],
    ['producto_id' => 3, 'cantidad' => 1]
];
$orderProcessor->processOrder(1, $items);




class InventoryManager {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function updateInventory($producto_id, $cantidad) {
        try {
            $this->pdo->beginTransaction();

            // Bloquear la fila del producto para prevenir actualizaciones concurrentes
            $stmt = $this->pdo->prepare("SELECT stock FROM productos WHERE id = ? FOR UPDATE");
            $stmt->execute([$producto_id]);
            $stock_actual = $stmt->fetchColumn();

            if ($stock_actual < $cantidad) {
                throw new Exception("Stock insuficiente para completar la venta.");
            }

            // Actualizar el stock
            $stmt = $this->pdo->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
            $stmt->execute([$cantidad, $producto_id]);

            $this->pdo->commit();
            echo "Inventario actualizado exitosamente<br>";

        } catch (Exception $e) {
            $this->pdo->rollBack();
            echo "Error en la actualización del inventario: " . $e->getMessage();
        }
    }
}

// Ejemplo de uso
$inventoryManager = new InventoryManager($pdo);
$inventoryManager->updateInventory(1, 5);



class DistributedTransactionManager {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function processDistributedOrder($cliente_id, $items) {
        try {
            $this->pdo->beginTransaction();

            // Registrar pedido en 'pedidos'
            $stmt = $this->pdo->prepare("INSERT INTO pedidos (cliente_id, total) VALUES (?, 0)");
            $stmt->execute([$cliente_id]);
            $pedido_id = $this->pdo->lastInsertId();

            $total_pedido = 0;

            foreach ($items as $item) {
                // Registrar detalle en 'detalles_pedido' y actualizar 'productos'
                $stmt = $this->pdo->prepare("SELECT stock, precio FROM productos WHERE id = ? FOR UPDATE");
                $stmt->execute([$item['producto_id']]);
                $producto = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($producto['stock'] < $item['cantidad']) {
                    throw new Exception("Stock insuficiente para el producto {$item['producto_id']}");
                }

                // Actualizar el inventario
                $stmt = $this->pdo->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
                $stmt->execute([$item['cantidad'], $item['producto_id']]);

                // Insertar detalle del pedido
                $subtotal = $producto['precio'] * $item['cantidad'];
                $stmt = $this->pdo->prepare("INSERT INTO detalles_pedido (pedido_id, producto_id, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$pedido_id, $item['producto_id'], $item['cantidad'], $producto['precio'], $subtotal]);

                $total_pedido += $subtotal;

                // Registrar auditoría en 'inventario_audit'
                $stmt = $this->pdo->prepare("INSERT INTO inventario_audit (producto_id, cantidad, accion) VALUES (?, ?, 'Venta')");
                $stmt->execute([$item['producto_id'], $item['cantidad']]);
            }

            // Actualizar el total del pedido
            $stmt = $this->pdo->prepare("UPDATE pedidos SET total = ? WHERE id = ?");
            $stmt->execute([$total_pedido, $pedido_id]);

            $this->pdo->commit();
            echo "Pedido y auditoría procesados exitosamente<br>";

        } catch (Exception $e) {
            $this->pdo->rollBack();
            echo "Error en la transacción distribuida: " . $e->getMessage();
        }
    }
}

// Ejemplo de uso
$dtm = new DistributedTransactionManager($pdo);
$items = [
    ['producto_id' => 1, 'cantidad' => 2],
    ['producto_id' => 2, 'cantidad' => 1],
    ['producto_id' => 3, 'cantidad' => 3]
];
$dtm->processDistributedOrder(1, $items);



class AuditLogger {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function logFailedTransaction($message) {
        $stmt = $this->pdo->prepare("INSERT INTO auditoria_transacciones (fecha, mensaje) VALUES (NOW(), ?)");
        $stmt->execute([$message]);
    }

    public function processOrderWithAudit($cliente_id, $items) {
        try {
            $this->pdo->beginTransaction();

            // Código de transacción (similar a los ejemplos anteriores)

            $this->pdo->commit();
            echo "Transacción procesada correctamente<br>";

        } catch (Exception $e) {
            $this->pdo->rollBack();
            $this->logFailedTransaction($e->getMessage());
            echo "Error en la transacción: " . $e->getMessage();
        }
    }
}

// Ejemplo de uso
$auditLogger = new AuditLogger($pdo);
$auditLogger->processOrderWithAudit(1, $items);
?>
