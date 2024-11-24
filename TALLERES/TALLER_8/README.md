Instrucciones de configuración (incluyendo la estructura de la base de datos)

PHP 7.4 o superior
Servidor web (Apache/Nginx)
MySQL/MariaDB
Extensión de PHP para PDO y MySQLi
Herramientas de gestión de bases de datos como phpMyAdmin o MySQL Workbench


Breve descripción de la estructura de tu proyecto

CREATE DATABASE biblioteca;

USE biblioteca;

-- Tabla de libros
CREATE TABLE libros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(255) NOT NULL,
    isbn VARCHAR(13) UNIQUE NOT NULL,
    ano_publicacion YEAR NOT NULL,
    cantidad_disponible INT DEFAULT 1
);

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL
);

-- Tabla de préstamos
CREATE TABLE prestamos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    libro_id INT NOT NULL,
    fecha_prestamo DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_devolucion DATETIME DEFAULT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (libro_id) REFERENCES libros(id)
);

$host = 'localhost';
$db = 'biblioteca';
$user = 'tu_usuario';
$pass = 'tu_contrasena';
$charset = 'utf8mb4';


Cualquier consideración especial para ejecutar el proyecto

TALLER_8/
├── mysqli/
│   ├── config.php
│   ├── libros.php
│   ├── usuarios.php
│   ├── prestamos.php
│   └── index.php
├── pdo/
│   ├── config.php
│   ├── libros.php
│   ├── usuarios.php
│   ├── prestamos.php
│   └── index.php
└── README.md
        

Una comparación breve entre tu experiencia usando MySQLi y PDO

En este proyecto, he implementado el sistema utilizando PDO. Sin embargo, he trabajado previamente con MySQLi y aquí te comparto una breve comparación basada en mi experiencia:

Ventajas de PDO:
Compatibilidad con múltiples bases de datos: PDO soporta diferentes motores de bases de datos (MySQL, PostgreSQL, SQLite, etc.), mientras que MySQLi solo funciona con MySQL.
Consultas preparadas: Tanto MySQLi como PDO soportan consultas preparadas, pero PDO tiene una implementación más flexible y fácil de usar.
Mejor manejo de excepciones: PDO tiene un manejo de excepciones más robusto, lo que facilita capturar y manejar errores de conexión o consultas SQL.
Ventajas de MySQLi:
Interfaz basada en funciones y orientada a objetos: MySQLi permite tanto el estilo de funciones como el estilo orientado a objetos, mientras que PDO es estrictamente orientado a objetos.
Más específico para MySQL: Si solo trabajas con bases de datos MySQL y no tienes planes de cambiar a otro motor, MySQLi puede ser suficiente.