<?php 
// creacion de la clase estudiante
class Estudiante {
    public $id;
    public $nombre;
    public $edad;
    public $carrera;
    public $materias;

    public function __construct($id, $nombre, $edad, $carrera, $materias = []) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->carrera = $carrera;
        $this->materias = $materias;
    }

    public function agregarMateria($materia, $calificacion) {
        $this->materias[$materia] = $calificacion;
    }

    public function obtenerPromedio(){
        if (count($this->materias) === 0) return 0;
        return array_sum($this->materias) / count($this->materias);
    }

    public function obtenerDetalles(){
        return[
            'id' => $this -> id,
            'nombre' => $this -> nombre,
            'edad' => $this -> edad,
            'carrera' => $this -> carrera,
            'materias' => $this -> materias,
            'promedio' => $this -> obtenerPromedio()
        ];
    }
};

//clase de getion de estudiantes
class gestionEstudiante{
    private $estudiantes;
    private $graduados;
 
    public function agregarEstudiante(Estudiante $estudiantes){
        $this->estudiantes[$estudiantes->obtenerDetalles()['id']] = $estudiantes;
    }
    
    public function obtenerEstudiante(int $id){
        return $this->estudiantes[$id] ?? null;
    }

       
    public function listarEstudiantes(){
        return $this->estudiantes;
    }

    public function calcularPromedioGeneral(){
        if (count($this->estudiantes) === 0) return 0;
        $totalPromedios = array_reduce($this->estudiantes, function($suma, $estudiante) {
            return $suma + $estudiante->obtenerPromedio();
        }, 0);
        return $totalPromedios / count($this->estudiantes);
    }

    public function obtenerEstudiantesPorCarrera(string $carrera){
        return array_filter($this->estudiantes, function($estudiante) use ($carrera) {
            return $estudiante->obtenerDetalles()['carrera'] === $carrera;
        });
    }

    public function obtenerMejorEstudiante(){
        if (count($this->estudiantes) === 0) return null;
        return array_reduce($this->estudiantes, function($mejor, $actual) {
            return ($actual->obtenerPromedio() > $mejor->obtenerPromedio()) ? $actual : $mejor;
        }, reset($this->estudiantes));
    }

    public function generarReporteRendimiento(){
        $reporte = [];
        foreach ($this->estudiantes as $estudiante) {
            foreach ($estudiante->obtenerDetalles()['materias'] as $materia => $calificacion) {
                if (!isset($reporte[$materia])) {
                    $reporte[$materia] = ['suma' => 0, 'total' => 0, 'max' => $calificacion, 'min' => $calificacion];
                }
                $reporte[$materia]['suma'] += $calificacion;
                $reporte[$materia]['total']++;
                $reporte[$materia]['max'] = max($reporte[$materia]['max'], $calificacion);
                $reporte[$materia]['min'] = min($reporte[$materia]['min'], $calificacion);
            }
        }

        foreach ($reporte as $materia => &$datos) {
            $datos['promedio'] = $datos['suma'] / $datos['total'];
            unset($datos['suma'], $datos['total']);
        }
        return $reporte;
    }
   
    public function graduarEstudiante(int $id){
        if (isset($this->estudiantes[$id])) {
            $this->graduados[] = $this->estudiantes[$id];
            unset($this->estudiantes[$id]);
            return true;
        }
        return false;
    }

    public function generarRanking(){
        usort($this->estudiantes, function($a, $b) {
            return $b->obtenerPromedio() <=> $a->obtenerPromedio();
        });
        return $this->estudiantes;
    }
};

// SECCIÓN DE PRUEBA 

// Instanciar el sistema de gestión de estudiantes
$sistema = new gestionEstudiante();

// Crear y agregar estudiantes al sistema
$estudiantes = [
    new Estudiante(1, "Ana López", 20, "Ingeniería"),
    new Estudiante(2, "Carlos Gómez", 22, "Derecho"),
    new Estudiante(3, "María Rodríguez", 19, "Medicina"),
    new Estudiante(4, "Luis Fernández", 21, "Ingeniería"),
    new Estudiante(5, "Laura Pérez", 23, "Arquitectura")
];

// Agregar materias y calificaciones a cada estudiante
$estudiantes[0]->agregarMateria("Matemáticas", 85);
$estudiantes[0]->agregarMateria("Física", 90);
$estudiantes[1]->agregarMateria("Derecho Civil", 78);
$estudiantes[1]->agregarMateria("Derecho Penal", 82);
$estudiantes[2]->agregarMateria("Anatomía", 88);
$estudiantes[2]->agregarMateria("Fisiología", 92);
$estudiantes[3]->agregarMateria("Programación", 95);
$estudiantes[3]->agregarMateria("Bases de Datos", 89);
$estudiantes[4]->agregarMateria("Diseño", 84);
$estudiantes[4]->agregarMateria("Historia del Arte", 87);

foreach ($estudiantes as $estudiante) {
    $sistema->agregarEstudiante($estudiante);
}

echo "Promedio general de los estudiantes: " . $sistema->calcularPromedioGeneral() . "\n";

$mejorEstudiante = $sistema->obtenerMejorEstudiante();
echo "Mejor estudiante: " . $mejorEstudiante . "\n";

$reporteRendimiento = $sistema->generarReporteRendimiento();
echo "Reporte de rendimiento:\n";
print_r($reporteRendimiento);

$sistema->graduarEstudiante(1);
echo "Estudiantes después de graduar a Ana López:\n";
print_r($sistema->listarEstudiantes());

echo "Ranking de estudiantes:\n";
print_r($sistema->generarRanking());

?>
