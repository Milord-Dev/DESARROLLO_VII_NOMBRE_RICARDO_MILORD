<?php
class MigrationManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Ejecutar todas las migraciones
    public function run() {
        $this->migrarBaseDeDatos();
        $this->migrarDatosIniciales();
    }

    // Crear las tablas necesarias
    private function migrarBaseDeDatos() {
        // Migración de la tabla Usuarios
        $sqlUsuarios = "
        CREATE TABLE IF NOT EXISTS Usuarios (
            Id INT AUTO_INCREMENT PRIMARY KEY,
            Nombre VARCHAR(100),
            Email VARCHAR(100) UNIQUE,
            Telefono VARCHAR(20),
            Password VARCHAR(255),
            Rol ENUM('admin', 'usuario') DEFAULT 'usuario'
        );
        ";
        
        try {
            $this->conn->exec($sqlUsuarios);
            echo "Tabla 'Usuarios' migrada o ya existe.\n";
        } catch (PDOException $e) {
            echo "Error al crear la tabla 'Usuarios': " . $e->getMessage() . "\n";
        }

        // Migración de la tabla Destinos
        $sqlDestinos = "
        CREATE TABLE IF NOT EXISTS Destinos (
            IdDestino INT AUTO_INCREMENT PRIMARY KEY,
            Nombre VARCHAR(100),
            Descripcion TEXT
            
        );
        ";

        try {
            $this->conn->exec($sqlDestinos);
            echo "Tabla 'Destinos' migrada o ya existe.\n";
        } catch (PDOException $e) {
            echo "Error al crear la tabla 'Destinos': " . $e->getMessage() . "\n";
        }
    }

    // Migración de datos iniciales
    private function migrarDatosIniciales() {
        // Comprobamos si ya existe un usuario administrador
        $sql = "SELECT COUNT(*) FROM Usuarios WHERE Email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', 'admin@admin.com');
        $stmt->execute();
        $count = $stmt->fetchColumn();

        // Si no existe, creamos el usuario administrador
        if ($count == 0) {
            $sqlInsert = "
            INSERT INTO Usuarios (Nombre, Email, Telefono, Password, Rol)
            VALUES (:nombre, :email, :telefono, :password, :rol)
            ";
            $stmtInsert = $this->conn->prepare($sqlInsert);
            $stmtInsert->bindParam(':nombre', 'Administrador');
            $stmtInsert->bindParam(':email', 'admin@admin.com');
            $stmtInsert->bindParam(':telefono', '123456789');
            $stmtInsert->bindParam(':password', password_hash('admin123', PASSWORD_BCRYPT)); // Contraseña cifrada
            $stmtInsert->bindParam(':rol', 'admin');
            $stmtInsert->execute();

            echo "Usuario administrador creado exitosamente.\n";
        } else {
            echo "El usuario administrador ya existe.\n";
        }
    }
}
?>
