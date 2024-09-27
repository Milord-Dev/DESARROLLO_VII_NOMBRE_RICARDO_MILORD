<?php
interface Prestable{
    public function obtenerDetallesPrestamo():string;
}

abstract class RecursoBiblioteca implements Prestable{
    public $id;
    public $titulo;
    public $autor;
    public $anioPublicacion;
    public $estado;
    public $fechaAdquisicion;
    public $tipo;
    public $estadosLegibles = [
        'disponible' => 'DISPONIBLE',
        'prestado' => 'PRESTADO',
        'en_reparacion' => 'EN REPARACION'
    ];

    public function __construct($datos) {
        foreach ($datos as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}

// Implementar las clases Libro, Revista y DVD aquí
class libro extends RecursoBiblioteca implements Prestable{
    public $isbn;
    public function obtenerDetallesPrestamo(): string
    {
        return "Numero Isbn: ". $this->$isbn;
    }
};

class Revista extends RecursoBiblioteca implements Prestable{
    public $numeroEdicion;
    public function obtenerDetallesPrestamo(): string
    {
        return "Numero de Edicion: ". $this->$numeroEdicion;
    }
};

class DVD extends RecursoBiblioteca implements Prestable{
    public $duracion;
    public function obtenerDetallesPrestamo(): string
    {
        return "Duracion: ". $this->$duracion;
    }
};

class GestorBiblioteca {
    private $recursos = [];

    public function cargarRecursos() {
        $json = file_get_contents('biblioteca.json');
        $data = json_decode($json, true);
        
        foreach ($data as $recursoData) {
            $recurso = new RecursoBiblioteca($recursoData);
            $this->recursos[] = $recurso;
        }
        
        return $this->recursos;
    }

    // Implementar los demás métodos aquí
}
