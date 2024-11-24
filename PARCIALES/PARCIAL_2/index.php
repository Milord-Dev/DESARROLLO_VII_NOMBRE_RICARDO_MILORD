<?php
require_once 'clases.php';

$gestorBlog = new GestorBlog();
$gestorBlog->cargarEntradas();

$action = $_GET['action'] ?? 'list';
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipoEntrada = $_POST['tipoEntrada'] ?? 'una';

    $id = $_POST['id'] ?? uniqid();
    $fecha_creacion = $_POST['fecha_creacion'] ?? date('Y-m-d H:i:s');
    $titulo1 = $_POST['titulo1'] ?? '';
    $descripcion1 = $_POST['descripcion1'] ?? '';
    $titulo2 = $_POST['titulo2'] ?? '';
    $descripcion2 = $_POST['descripcion2'] ?? '';
    $titulo3 = $_POST['titulo3'] ?? '';
    $descripcion3 = $_POST['descripcion3'] ?? '';

    if ($tipoEntrada == 'una') {
        $entrada = new EntradaUnaColumna([
            'id' => $id,
            'fecha_creacion' => $fecha_creacion,
            'titulo' => $titulo1,
            'descripcion' => $descripcion1
        ]);
    } elseif ($tipoEntrada == 'dos') {
        $entrada = new EntradaDosColumnas([
            'id' => $id,
            'fecha_creacion' => $fecha_creacion,
            'titulo1' => $titulo1,
            'descripcion1' => $descripcion1,
            'titulo2' => $titulo2,
            'descripcion2' => $descripcion2
        ]);
    } else {
        $entrada = new EntradaTresColumnas([
            'id' => $id,
            'fecha_creacion' => $fecha_creacion,
            'titulo1' => $titulo1,
            'descripcion1' => $descripcion1,
            'titulo2' => $titulo2,
            'descripcion2' => $descripcion2,
            'titulo3' => $titulo3,
            'descripcion3' => $descripcion3
        ]);
    }

    if ($_POST['action'] === 'add') {
        $gestorBlog->agregarEntrada($entrada);
        $mensaje = "Entrada agregada con éxito.";
    } elseif ($_POST['action'] === 'edit') {
        $gestorBlog->editarEntrada($entrada);
        $mensaje = "Entrada actualizada con éxito.";
    }

    $action = 'list';
}

if ($action === 'delete' && isset($_GET['id'])) {
    $gestorBlog->eliminarEntrada($_GET['id']);
    $mensaje = "Entrada eliminada con éxito.";
    $action = 'list';
}

if ($action === 'move' && isset($_GET['id']) && isset($_GET['direction'])) {
    $gestorBlog->moverEntrada($_GET['id'], $_GET['direction']);
    $mensaje = "Entrada movida con éxito.";
    $action = 'list';
}

$entradas = $gestorBlog->obtenerEntradas();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .move-arrow {
            padding: 0.5rem; 
            cursor: pointer;
            text-align: center;
            color: #001; 
            font-size: 1.5rem; 
        }
        .move-arrow.disabled {
            color: #ccc; 
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Gestor de Blog</h1>
        
        <?php if ($mensaje): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <nav class="mb-4">
            <a href="index.php?action=list" class="btn btn-primary">Listar Entradas</a>
            <a href="index.php?action=add" class="btn btn-success">Agregar Entrada</a>
            <a href="ver_blog.php" class="btn btn-info">Ver Blog</a>
        </nav>

        <?php if ($action === 'list'): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Fecha de Creación</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                        <th>Orden</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($entradas as $index => $entrada): ?>
                        <tr>
                            <td><?php echo $entrada->id; ?></td>
                            <td><?php echo $entrada instanceof EntradaUnaColumna ? $entrada->titulo : $entrada->titulo1; ?></td>
                            <td><?php echo $entrada->fecha_creacion; ?></td>
                            <td><?php echo get_class($entrada); ?></td>
                            <td>
                                <a href="index.php?action=edit&id=<?php echo $entrada->id; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="index.php?action=delete&id=<?php echo $entrada->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta entrada?')">Eliminar</a>
                            </td>
                            <td>
                                <!-- Flechas con padding para mover hacia arriba o abajo -->
                                <span onclick="location.href='index.php?action=move&id=<?php echo $entrada->id; ?>&direction=arriba'" class="move-arrow <?php echo ($index === 0) ? 'disabled' : ''; ?>">&#x25B2;</span>
                                <span onclick="location.href='index.php?action=move&id=<?php echo $entrada->id; ?>&direction=abajo'" class="move-arrow <?php echo ($index === count($entradas) - 1) ? 'disabled' : ''; ?>">&#x25BC;</span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php elseif ($action === 'add' || $action === 'edit'): ?>
            <?php
            $entradaEditar = null;
            if ($action === 'edit' && isset($_GET['id'])) {
                $entradaEditar = $gestorBlog->obtenerEntrada($_GET['id']);
            }
            ?>
            <form action="index.php" method="post">
                <input type="hidden" name="action" value="<?php echo $action; ?>">
                <?php if ($entradaEditar): ?>
                    <input type="hidden" name="id" value="<?php echo $entradaEditar->id; ?>">
                    <input type="hidden" name="fecha_creacion" value="<?php echo $entradaEditar->fecha_creacion; ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label for="tipoEntrada" class="form-label">Tipo de Entrada</label>
                    <select class="form-control" id="tipoEntrada" name="tipoEntrada" required>
                        <option value="una" <?php echo ($entradaEditar && $entradaEditar instanceof EntradaUnaColumna) ? 'selected' : ''; ?>>Una Columna</option>
                        <option value="dos" <?php echo ($entradaEditar && $entradaEditar instanceof EntradaDosColumnas) ? 'selected' : ''; ?>>Dos Columnas</option>
                        <option value="tres" <?php echo ($entradaEditar && $entradaEditar instanceof EntradaTresColumnas) ? 'selected' : ''; ?>>Tres Columnas</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="titulo1" class="form-label">Título 1</label>
                    <input type="text" class="form-control" id="titulo1" name="titulo1" value="<?php echo $entradaEditar ? $entradaEditar->titulo1 : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion1" class="form-label">Descripción 1</label>
                    <textarea class="form-control" id="descripcion1" name="descripcion1" rows="3" required><?php echo $entradaEditar ? $entradaEditar->descripcion1 : ''; ?></textarea>
                </div>

                <div class="mb-3 d-none" id="titulo2-group">
                    <label for="titulo2" class="form-label">Título 2</label>
                    <input type="text" class="form-control" id="titulo2" name="titulo2" value="<?php echo $entradaEditar ? $entradaEditar->titulo2 : ''; ?>">
                </div>

                <div class="mb-3 d-none" id="descripcion2-group">
                    <label for="descripcion2" class="form-label">Descripción 2</label>
                    <textarea class="form-control" id="descripcion2" name="descripcion2" rows="3"><?php echo $entradaEditar ? $entradaEditar->descripcion2 : ''; ?></textarea>
                </div>

                <div class="mb-3 d-none" id="titulo3-group">
                    <label for="titulo3" class="form-label">Título 3</label>
                    <input type="text" class="form-control" id="titulo3" name="titulo3" value="<?php echo $entradaEditar ? $entradaEditar->titulo3 : ''; ?>">
                </div>

                <div class="mb-3 d-none" id="descripcion3-group">
                    <label for="descripcion3" class="form-label">Descripción 3</label>
                    <textarea class="form-control" id="descripcion3" name="descripcion3" rows="3"><?php echo $entradaEditar ? $entradaEditar->descripcion3 : ''; ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="index.php?action=list" class="btn btn-secondary">Cancelar</a>
            </form>
        <?php endif; ?>
    </div>
    <script>
        // Script para mostrar/ocultar campos según el tipo de entrada
        document.getElementById('tipoEntrada').addEventListener('change', function() {
            const tipo = this.value;
            document.getElementById('titulo2-group').classList.toggle('d-none', tipo !== 'dos' && tipo !== 'tres');
            document.getElementById('descripcion2-group').classList.toggle('d-none', tipo !== 'dos' && tipo !== 'tres');
            document.getElementById('titulo3-group').classList.toggle('d-none', tipo !== 'tres');
            document.getElementById('descripcion3-group').classList.toggle('d-none', tipo !== 'tres');
        });
    </script>
</body>
</html>