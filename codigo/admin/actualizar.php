<?php
// UPDATE de un concierto existente (molde: actualizar.php de crud_estudiantes).
require '../conexion.php';
require 'proteger.php';

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$titulo = trim($_POST['titulo'] ?? '');
$agrupacion = trim($_POST['agrupacion'] ?? '');
$fecha = trim($_POST['fecha'] ?? '');
$hora = trim($_POST['hora'] ?? '');
$sede = trim($_POST['sede'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');

// La hora debe ser HH:MM de 24 horas (por ejemplo 19:00) o exactamente "Por confirmar".
// Es la misma regla que valida el JS del formulario, pero aquí no se puede saltar.
$horaValida = $hora === 'Por confirmar' || preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $hora) === 1;

// La descripción es opcional; los demás campos son obligatorios.
// La fecha debe venir como AAAA-MM-DD (el formato de type="date").
if (!$id || $titulo === '' || $agrupacion === '' || !$horaValida || $sede === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
    exit('Datos inválidos. Regresa al formulario.');
}

$consulta = $conexion->prepare('UPDATE conciertos SET titulo = ?, agrupacion = ?, fecha = ?, hora = ?, sede = ?, descripcion = ? WHERE id = ?');
$consulta->execute([$titulo, $agrupacion, $fecha, $hora, $sede, $descripcion, $id]);

header('Location: index.php?ok=actualizado');
exit;
