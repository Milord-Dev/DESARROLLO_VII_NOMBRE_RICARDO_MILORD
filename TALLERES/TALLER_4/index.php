<?php
require_once 'Gerente.php';
require_once 'Desarrollador.php';
require_once 'Empresa.php';

// Crear objetos de empleados
$gerente = new Gerente("Juan Perez", 1, 5000, "Ventas");
$gerente->asignarBono(1000);

$desarrollador = new Desarrollador("Maria Lopez", 2, 3000, "PHP", "Senior");

// Crear objeto de empresa y agregar empleados
$empresa = new Empresa();
$empresa->agregarEmpleado($gerente);
$empresa->agregarEmpleado($desarrollador);

// Listar empleados
echo "Lista de empleados:<br>";
$empresa->listarEmpleados();

// Calcular nómina total
echo "<br>Nómina total: " . $empresa->calcularNominaTotal() . "<br>";

// Evaluar desempeño de empleados
echo "<br>Evaluación de desempeño:<br>";
$empresa->evaluarDesempenioEmpleados();
?>
