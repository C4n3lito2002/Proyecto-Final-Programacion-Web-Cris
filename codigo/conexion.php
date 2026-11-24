<?php
// Sesión: se inicia aquí para que todas las páginas que cargan la conexión
// puedan leer $_SESSION (inicio de sesión, rol y protección del panel).
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Conexión a la base de datos SQLite del sitio.
// El archivo conservatorio.db se crea automáticamente si no existe.
$conexion = new PDO('sqlite:' . __DIR__ . '/conservatorio.db');
$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Tabla de usuarios: registro, inicio de sesión y rol ('usuario' por defecto).
$conexion->exec("CREATE TABLE IF NOT EXISTS usuarios (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    rol TEXT NOT NULL DEFAULT 'usuario',
    creado_en TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
)");

// Tabla de conciertos: es la que el administrador crea, edita y elimina.
$conexion->exec("CREATE TABLE IF NOT EXISTS conciertos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    titulo TEXT NOT NULL,
    agrupacion TEXT NOT NULL,
    fecha TEXT NOT NULL,
    hora TEXT NOT NULL,
    sede TEXT NOT NULL,
    descripcion TEXT NOT NULL DEFAULT '',
    creado_en TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
)");
