<?php
require_once 'Empleado.php';
require_once 'Evaluable.php';

class Gerente extends Empleado implements Evaluable {
    private $departamento;
    private $bono;

    public function __construct($nombre, $idEmpleado, $salarioBase, $departamento) {
        parent::__construct($nombre, $idEmpleado, $salarioBase);
        $this->departamento = $departamento;
        $this->bono = 0;
    }

    public function getDepartamento() {
        return $this->departamento;
    }

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    public function asignarBono($bono) {
        $this->bono = $bono;
    }

    public function getSalarioTotal() {
        return $this->getSalarioBase() + $this->bono;
    }

    public function evaluarDesempenio() {
        // Lógica para evaluar el desempeño de un gerente
        return "El desempeño del gerente ha sido evaluado.";
    }
}
?>
