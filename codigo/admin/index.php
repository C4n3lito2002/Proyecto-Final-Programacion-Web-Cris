<?php
// Panel de administración de conciertos (molde: crud_estudiantes del profesor).
// Alta arriba y tabla de registros abajo, en una sola página.
require '../conexion.php';
require 'proteger.php';

$sentencia = $conexion->query('SELECT * FROM conciertos ORDER BY fecha DESC, hora DESC');
$conciertos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

// Aviso tras guardar, actualizar o eliminar (llega como ?ok=... desde esos archivos).
// Solo se muestran los textos de esta lista: nunca se imprime lo que venga en la URL.
$mensajesOk = [
    'guardado' => 'Concierto guardado correctamente.',
    'actualizado' => 'Concierto actualizado correctamente.',
    'eliminado' => 'Concierto eliminado correctamente.',
];
$claveOk = $_GET['ok'] ?? '';
$mensajeOk = is_string($claveOk) ? ($mensajesOk[$claveOk] ?? null) : null;

// Variables para el encabezado compartido ($base corrige las rutas desde admin/).
$titulo = 'Panel de conciertos · Conservatorio de las Artes';
$base = '../';
require '../encabezado.php';
?>
<main class="container py-5">
    <h1 class="mb-2">Conciertos</h1>
    <p class="text-secondary">Panel de administración del calendario de conciertos</p>

    <?php if ($mensajeOk !== null): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $mensajeOk ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">Agregar concierto</div>
        <div class="card-body">
            <form action="guardar.php" method="POST" id="formConcierto" novalidate>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="titulo">Título</label>
                        <input class="form-control" id="titulo" type="text" name="titulo" required maxlength="100">
                        <div class="invalid-feedback" id="error-titulo"></div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="agrupacion">Agrupación</label>
                        <input class="form-control" id="agrupacion" type="text" name="agrupacion" required maxlength="100">
                        <div class="invalid-feedback" id="error-agrupacion"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="fecha">Fecha</label>
                        <input class="form-control" id="fecha" type="date" name="fecha" required>
                        <div class="invalid-feedback" id="error-fecha"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="hora">Hora</label>
                        <input class="form-control" id="hora" type="text" name="hora" required maxlength="30" placeholder="19:00 o Por confirmar">
                        <div class="invalid-feedback" id="error-hora"></div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="sede">Sede</label>
                        <input class="form-control" id="sede" type="text" name="sede" required maxlength="100">
                        <div class="invalid-feedback" id="error-sede"></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="descripcion">Descripción (opcional)</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" maxlength="1000"></textarea>
                        <div class="form-text text-end" id="contador-descripcion">0 / 1000</div>
                    </div>
                </div>
                <button class="btn btn-primary mt-3" type="submit">Guardar concierto</button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <span>Conciertos registrados</span>
            <input class="form-control form-control-sm w-auto" id="buscador" type="search" placeholder="Buscar concierto" aria-label="Buscar concierto en la tabla">
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead><tr><th>ID</th><th>Título</th><th>Agrupación</th><th>Fecha</th><th>Hora</th><th>Sede</th><th>Acciones</th></tr></thead>
                <tbody>
                <?php foreach ($conciertos as $concierto): ?>
                    <tr class="fila-concierto">
                        <td><?= $concierto['id'] ?></td>
                        <td><?= htmlspecialchars($concierto['titulo'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($concierto['agrupacion'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($concierto['fecha'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($concierto['hora'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($concierto['sede'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <div class="d-flex gap-2">
                                <a class="btn btn-warning btn-sm" href="editar.php?id=<?= $concierto['id'] ?>">Editar</a>
                                <form action="eliminar.php" method="POST" class="form-eliminar" data-titulo="<?= htmlspecialchars($concierto['titulo'], ENT_QUOTES, 'UTF-8') ?>">
                                    <input type="hidden" name="id" value="<?= $concierto['id'] ?>">
                                    <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (count($conciertos) === 0): ?>
                    <tr><td colspan="7" class="text-center text-secondary">Todavía no hay conciertos registrados.</td></tr>
                <?php endif; ?>
                    <tr id="sin-resultados" class="d-none"><td colspan="7" class="text-center text-secondary">Ningún concierto coincide con la búsqueda.</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</main>
<?php
// Scripts propios de esta página (los imprime pie.php después de Bootstrap).
// El orden importa: validacion.js define funciones que usa validar-concierto.js.
$scripts = ['validacion.js', 'validar-concierto.js', 'panel.js'];
require '../pie.php';
?>
