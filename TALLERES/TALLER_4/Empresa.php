<?php
class Empresa {
    private $empleados = [];

    public function agregarEmpleado($empleado) {
        $this->empleados[] = $empleado;
    }

    public function listarEmpleados() {
        foreach ($this->empleados as $empleado) {
            echo "Nombre: " . $empleado->getNombre() . ", ID: " . $empleado->getIdEmpleado() . "<br>";
        }
    }

    public function calcularNominaTotal() {
        $total = 0;
        foreach ($this->empleados as $empleado) {
            if (method_exists($empleado, 'getSalarioTotal')) {
                $total += $empleado->getSalarioTotal();
            } else {
                $total += $empleado->getSalarioBase();
            }
        }
        return $total;
    }

    public function evaluarDesempenioEmpleados() {
        foreach ($this->empleados as $empleado) {
            if ($empleado instanceof Evaluable) {
                echo $empleado->evaluarDesempenio() . "<br>";
            } else {
                echo "El empleado " . $empleado->getNombre() . " no es evaluable.<br>";
            }
        }
    }
}
?>
