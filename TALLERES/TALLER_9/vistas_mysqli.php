<?php 
require_once "config_mysqli.php";

// Función para mostrar los productos que nunca se han vendido
function productosNuncaVendidos($conn) {
    $sql = "SELECT p.id, p.nombre, p.precio, p.stock 
            FROM productos p 
            LEFT JOIN detalles_venta dv ON p.id = dv.producto_id 
            WHERE dv.producto_id IS NULL";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Productos Nunca Vendidos:</h3>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Stock</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>{$row['id']}</td><td>{$row['nombre']}</td><td>{$row['precio']}</td><td>{$row['stock']}</td></tr>";
    }
    echo "</table>";

    mysqli_free_result($result);
}

// Función para mostrar el resumen de inventario por categoría
function resumenInventarioCategorias($conn) {
    $sql = "SELECT c.nombre AS categoria, COUNT(p.id) AS total_productos, 
                   SUM(p.precio * p.stock) AS valor_inventario 
            FROM categorias c 
            LEFT JOIN productos p ON c.id = p.categoria_id 
            GROUP BY c.id, c.nombre";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Resumen de Inventario por Categoría:</h3>";
    echo "<table border='1'>";
    echo "<tr><th>Categoría</th><th>Total Productos</th><th>Valor Total del Inventario</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>{$row['categoria']}</td><td>{$row['total_productos']}</td><td>$" . "{$row['valor_inventario']}</td></tr>";
    }
    echo "</table>";

    mysqli_free_result($result);
}

// Función para mostrar clientes que han comprado todos los productos de una categoría específica
function clientesComprasCompletasCategoria($conn, $categoria_id) {
    $sql = "SELECT c.id, c.nombre, c.email 
            FROM clientes c
            WHERE NOT EXISTS (
                SELECT 1
                FROM productos p
                WHERE p.categoria_id = $categoria_id
                AND NOT EXISTS (
                    SELECT 1
                    FROM detalles_venta dv
                    JOIN ventas v ON dv.venta_id = v.id
                    WHERE v.cliente_id = c.id
                    AND dv.producto_id = p.id
                )
            )";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Clientes que han comprado todos los productos de la categoría $categoria_id:</h3>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Email</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>{$row['id']}</td><td>{$row['nombre']}</td><td>{$row['email']}</td></tr>";
    }
    echo "</table>";

    mysqli_free_result($result);
}

// Función para mostrar el porcentaje de ventas por producto
function porcentajeVentasProducto($conn) {
    $sql = "SELECT p.nombre, 
                   SUM(dv.subtotal) AS ingresos_producto,
                   (SUM(dv.subtotal) / (SELECT SUM(subtotal) FROM detalles_venta) * 100) AS porcentaje_ventas
            FROM productos p
            JOIN detalles_venta dv ON p.id = dv.producto_id
            GROUP BY p.id, p.nombre";
    $result = mysqli_query($conn, $sql);

    echo "<h3>Porcentaje de Ventas por Producto:</h3>";
    echo "<table border='1'>";
    echo "<tr><th>Producto</th><th>Ingresos del Producto</th><th>Porcentaje de Ventas</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>{$row['nombre']}</td><td>$" . "{$row['ingresos_producto']}</td><td>" . number_format($row['porcentaje_ventas'], 2) . "%</td></tr>";
    }
    echo "</table>";

    mysqli_free_result($result);
}

// Llamar a las funciones
productosNuncaVendidos($conn);
resumenInventarioCategorias($conn);
clientesComprasCompletasCategoria($conn, 1); // Reemplazar '1' con el ID de la categoría que desees analizar
porcentajeVentasProducto($conn);

mysqli_close($conn);
?>
