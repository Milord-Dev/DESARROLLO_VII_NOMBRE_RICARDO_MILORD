<?php
interface Detalle {
    public function obtenerDetallesEspecificos(): string;
}

 abstract class Entrada {
    public $id;
    public $fecha_creacion;
    public $tipo;
    public $titulo;
    public $descripcion;

    public function __construct($datos = []) {
        foreach ($datos as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}

class EntradaUnaColumna extends Entrada implements Detalle {
    public $titulo;
    public $descripcion;

    public function obtenerDetallesEspecificos(): string{
       return "Entrada de una columna: [titulo]";
    }

}

class EntradaDosColumnas extends Entrada implements Detalle{
    public $titulo1;
    public $descripcion;
    public $titulo2;
    public $descripcion2;
    
    public function obtenerDetallesEspecificos(): string{
        return "Entrada de 2 columna: [titulo1] | [titulo2]";
    }

}

class EntradaTresColumnas extends Entrada implements Detalle{
    public $titulo1;
    public $descripcion;
    public $titulo2;
    public $descripcion2;
    public $titulo3;
    public $descripcion3;

    public function obtenerDetallesEspecificos(): string{
        return "Entrada de 3 columna: [titulo1] | [titulo2] | [titulo3]";
    }

}

class GestorBlog {
    private $entradas = [];

    public function cargarEntradas() {
        if (file_exists('blog.json')) {
            $json = file_get_contents('blog.json');
            $data = json_decode($json, true);
            foreach ($data as $entradaData) {
                $this->entradas[] = new EntradaUnaColumna($entradaData);
            }
        }
    }

    public function guardarEntradas() {
        $data = array_map(function($entrada) {
            return get_object_vars($entrada);
        }, $this->entradas);
        file_put_contents('blog.json', json_encode($data, JSON_PRETTY_PRINT));
    }

    public function obtenerEntradas() {
        return $this->entradas;
    }

    public function agregarEntrada($entrada) {
        $this->entradas[] = $entrada;
        $this->guardarEntradas();
    }

    public function editarEntrada(Entrada $entrada) {
        foreach ($this->entradas as &$e) {
            if ($e->id === $entrada->id) {
                $e = $entrada;
                break;
            }
        }
        $this->guardarEntradas();
    }

    public function eliminarEntrada($id) {
        $this->entradas = array_filter($this->entradas, function($entrada) use ($id) {
            return $entrada->id !== $id;
        });
        $this->guardarEntradas();
    }

    public function obtenerEntrada($id) {
        foreach ($this->entradas as $entrada) {
            if ($entrada->id === $id) {
                return $entrada;
            }
        }
        return null;
    }

    public function moverEntrada($id, $direccion) {
        $index = null;
        foreach ($this->entradas as $i => $entrada) {
            if ($entrada->id === $id) {
                $index = $i;
                break;
            }
        }

        if ($index !== null) {
            if ($direccion === 'arriba' && $index > 0) {
                $temp = $this->entradas[$index - 1];
                $this->entradas[$index - 1] = $this->entradas[$index];
                $this->entradas[$index] = $temp;
            } elseif ($direccion === 'abajo' && $index < count($this->entradas) - 1) {
                $temp = $this->entradas[$index + 1];
                $this->entradas[$index + 1] = $this->entradas[$index];
                $this->entradas[$index] = $temp;
            }
            $this->guardarEntradas();
        }
    }
}

// Uso del sistema de gestión de blog
$gestorBlog = new GestorBlog();
$gestorBlog->cargarEntradas();

$nuevaEntrada = new EntradaUnaColumna([
    'id' => uniqid(),
    'fecha_creacion' => date('Y-m-d H:i:s'),
    'tipo' => 'Artículo',
    'titulo' => 'Mi nueva entrada',
    'descripcion' => 'Esta es la descripción de mi nueva entrada.'
]);
$gestorBlog->agregarEntrada($nuevaEntrada);

// Editar una entrada existente
$entradaEditada = new EntradaUnaColumna([
    'id' => $nuevaEntrada->id,
    'fecha_creacion' => $nuevaEntrada->fecha_creacion,
    'tipo' => 'Artículo',
    'titulo' => 'Entrada editada',
    'descripcion' => 'Esta es la descripción de la entrada editada.'
]);
$gestorBlog->editarEntrada($entradaEditada);

$entradaObtenida = $gestorBlog->obtenerEntrada($nuevaEntrada->id);

$gestorBlog->moverEntrada($nuevaEntrada->id, 'arriba');

$gestorBlog->eliminarEntrada($nuevaEntrada->id);

/*
public function cargarInfoBlog() {
    $json = file_get_contents('blog.json');
    $data = json_decode($json, true);
    foreach ($data as $BlogData) {
        switch ($BlogData['tipo']) {
            case 'COLUMNA1':
                $Blog = new TareaDesarrollo($BlogData);
                break;
            
*/
?>