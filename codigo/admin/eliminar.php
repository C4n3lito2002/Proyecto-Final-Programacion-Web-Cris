<?php
// DELETE de un concierto (molde: eliminar.php de crud_estudiantes).
require '../conexion.php';
require 'proteger.php';

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    exit('ID inválido.');
}

$consulta = $conexion->prepare('DELETE FROM conciertos WHERE id = ?');
$consulta->execute([$id]);

header('Location: index.php?ok=eliminado');
exit;
