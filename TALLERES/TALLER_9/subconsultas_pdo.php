<?php 
require_once "config_pdo.php";

try {
    // 1. Productos que nunca se han vendido
    $sql = "SELECT p.nombre 
            FROM productos p 
            LEFT JOIN detalles_venta dv ON p.id = dv.producto_id 
            WHERE dv.producto_id IS NULL";

    $stmt = $pdo->query($sql);
    echo "<h3>Productos que nunca se han vendido:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Producto: {$row['nombre']}<br>";
    }

    // 2. Listar categorías con el número de productos y el valor total del inventario
    $sql = "SELECT c.nombre AS categoria, COUNT(p.id) AS num_productos, SUM(p.precio * p.stock) AS valor_total_inventario 
            FROM categorias c
            LEFT JOIN productos p ON c.id = p.categoria_id
            GROUP BY c.id";

    $stmt = $pdo->query($sql);
    echo "<h3>Categorías con número de productos y valor total del inventario:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Categoría: {$row['categoria']}, Número de productos: {$row['num_productos']}, Valor total del inventario: $" . "{$row['valor_total_inventario']}<br>";
    }

    // 3. Encontrar los clientes que han comprado todos los productos de una categoría específica
    $categoria_id = 1; // ID de la categoría a analizar (puede ser dinámico)
    $sql = "SELECT DISTINCT c.nombre 
            FROM clientes c
            JOIN ventas v ON c.id = v.cliente_id
            JOIN detalles_venta dv ON v.id = dv.venta_id
            JOIN productos p ON dv.producto_id = p.id
            WHERE p.categoria_id = :categoria_id
            GROUP BY c.id
            HAVING COUNT(DISTINCT p.id) = (
                SELECT COUNT(*) 
                FROM productos 
                WHERE categoria_id = :categoria_id
            )";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['categoria_id' => $categoria_id]);
    echo "<h3>Clientes que han comprado todos los productos de la categoría ID {$categoria_id}:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Cliente: {$row['nombre']}<br>";
    }

    // 4. Calcular el porcentaje de ventas de cada producto respecto al total de ventas
    $sql = "SELECT p.nombre, 
                   SUM(dv.cantidad * dv.precio_unitario) AS total_ventas_producto,
                   (SUM(dv.cantidad * dv.precio_unitario) / (SELECT SUM(dv2.cantidad * dv2.precio_unitario) FROM detalles_venta dv2)) * 100 AS porcentaje_ventas
            FROM productos p
            JOIN detalles_venta dv ON p.id = dv.producto_id
            GROUP BY p.id";

    $stmt = $pdo->query($sql);
    echo "<h3>Porcentaje de ventas de cada producto respecto al total de ventas:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Producto: {$row['nombre']}, Total ventas: $" . "{$row['total_ventas_producto']}, Porcentaje: " . round($row['porcentaje_ventas'], 2) . "%<br>";
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;
?>
