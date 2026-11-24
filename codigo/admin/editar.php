<?php
// Muestra el formulario con los datos actuales del concierto (molde: editar.php de crud_estudiantes).
require '../conexion.php';
require 'proteger.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    exit('ID inválido.');
}

$consulta = $conexion->prepare('SELECT * FROM conciertos WHERE id = ?');
$consulta->execute([$id]);
$concierto = $consulta->fetch(PDO::FETCH_ASSOC);

if (!$concierto) {
    exit('Concierto no encontrado.');
}

// Variables para el encabezado compartido ($base corrige las rutas desde admin/).
$titulo = 'Editar concierto · Conservatorio de las Artes';
$base = '../';
require '../encabezado.php';
?>
<main class="container py-5" style="max-width: 650px;">
    <h1 class="mb-4">Editar concierto</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="actualizar.php" method="POST" id="formConcierto" novalidate>
                <input type="hidden" name="id" value="<?= $concierto['id'] ?>">
                <div class="mb-3">
                    <label class="form-label" for="titulo">Título</label>
                    <input class="form-control" id="titulo" type="text" name="titulo" required maxlength="100" value="<?= htmlspecialchars($concierto['titulo'], ENT_QUOTES, 'UTF-8') ?>">
                    <div class="invalid-feedback" id="error-titulo"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="agrupacion">Agrupación</label>
                    <input class="form-control" id="agrupacion" type="text" name="agrupacion" required maxlength="100" value="<?= htmlspecialchars($concierto['agrupacion'], ENT_QUOTES, 'UTF-8') ?>">
                    <div class="invalid-feedback" id="error-agrupacion"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="fecha">Fecha</label>
                    <input class="form-control" id="fecha" type="date" name="fecha" required value="<?= htmlspecialchars($concierto['fecha'], ENT_QUOTES, 'UTF-8') ?>">
                    <div class="invalid-feedback" id="error-fecha"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="hora">Hora</label>
                    <input class="form-control" id="hora" type="text" name="hora" required maxlength="30" placeholder="19:00 o Por confirmar" value="<?= htmlspecialchars($concierto['hora'], ENT_QUOTES, 'UTF-8') ?>">
                    <div class="invalid-feedback" id="error-hora"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="sede">Sede</label>
                    <input class="form-control" id="sede" type="text" name="sede" required maxlength="100" value="<?= htmlspecialchars($concierto['sede'], ENT_QUOTES, 'UTF-8') ?>">
                    <div class="invalid-feedback" id="error-sede"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="descripcion">Descripción (opcional)</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" maxlength="1000"><?= htmlspecialchars($concierto['descripcion'], ENT_QUOTES, 'UTF-8') ?></textarea>
                    <div class="form-text text-end" id="contador-descripcion">0 / 1000</div>
                </div>
                <button class="btn btn-primary" type="submit">Guardar cambios</button>
                <a class="btn btn-secondary" href="index.php">Cancelar</a>
            </form>
        </div>
    </div>
</main>
<?php
// Scripts propios de esta página (los imprime pie.php después de Bootstrap).
// El orden importa: validacion.js define funciones que usa validar-concierto.js.
$scripts = ['validacion.js', 'validar-concierto.js'];
require '../pie.php';
?>
