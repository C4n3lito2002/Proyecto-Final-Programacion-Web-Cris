<?php
// Guardia del panel de administración.
// Se incluye al inicio de cada archivo de admin/, justo después de conexion.php
// (que es quien inicia la sesión). Solo deja pasar a un usuario con rol 'admin'.
if (!isset($_SESSION['usuario_id'])) {
    // Sin sesión iniciada: al inicio de sesión.
    header('Location: ../login.php');
    exit;
}

if (($_SESSION['usuario_rol'] ?? '') !== 'admin') {
    // Con sesión pero sin permiso: de regreso al Inicio.
    header('Location: ../index.php');
    exit;
}
