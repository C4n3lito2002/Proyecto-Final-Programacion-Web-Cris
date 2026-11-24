<?php
// Página de Inicio: portada, próximo concierto (desde la base de datos) y agrupaciones.
date_default_timezone_set('America/Mexico_City');
require 'conexion.php';

// Próximo concierto: el de fecha más cercana que sea hoy o posterior.
$hoy = date('Y-m-d');
$consulta = $conexion->prepare('SELECT * FROM conciertos WHERE fecha >= ? ORDER BY fecha ASC, hora ASC LIMIT 1');
$consulta->execute([$hoy]);
$proximo = $consulta->fetch(PDO::FETCH_ASSOC);

// Fecha en español (la base la guarda como AAAA-MM-DD).
$meses = ['', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

// Agrupaciones: nombre y descripción breve.
$agrupaciones = [
    ['Orquesta Infantil', 'Interpreta repertorio como Marcha Eslava, música de Pixar y Piratas del Caribe.'],
    ['Orquesta Juvenil', 'Repertorio sinfónico y mexicano: Danza macabra, Danzón No. 8 y Huapango.'],
    ['Coro', 'Se presenta junto a las orquestas, por ejemplo en Huapango y Tlaquepaque.'],
    ['Camerata', 'Agrupación de cámara que participó en la temporada Encuentros Sonoros 2026.'],
    ['Mariachi', 'Se presentó en la temporada Encuentros Sonoros 2026.'],
    ['Big Band', 'Cerró la temporada Encuentros Sonoros 2026 el 5 de agosto.'],
];

$titulo = 'Inicio · Conservatorio de las Artes';
require 'encabezado.php';
?>
<main>
    <section class="hero py-5">
        <div class="container py-lg-4">
            <h1 class="display-5 fw-bold">Conservatorio de las Artes · Escuela de Música</h1>
            <p class="lead col-lg-8">Escuela de música de Guadalajara, Jalisco. Orquestas, coro, camerata, mariachi y big band que se presentan en teatros y centros culturales de la ciudad.</p>
            <a class="btn btn-conservatorio btn-lg" href="#proximo-concierto">Ver próximo concierto</a>
        </div>
    </section>

    <section id="proximo-concierto" class="container py-5">
        <h2 class="mb-4">Próximo concierto</h2>
        <?php if ($proximo): ?>
            <?php
            $partes = explode('-', $proximo['fecha']);
            $fecha = (int) $partes[2] . ' de ' . $meses[(int) $partes[1]] . ' de ' . $partes[0];
            $hora = $proximo['hora'] === 'Por confirmar' ? 'Hora por confirmar' : $proximo['hora'] . ' h';
            ?>
            <article class="card tarjeta-concierto shadow-sm">
                <div class="card-body p-4">
                    <p class="small fw-semibold text-secondary mb-2">
                        <?= htmlspecialchars($fecha, ENT_QUOTES, 'UTF-8') ?> · <?= htmlspecialchars($hora, ENT_QUOTES, 'UTF-8') ?>
                    </p>
                    <h3 class="card-title h4"><?= htmlspecialchars($proximo['titulo'], ENT_QUOTES, 'UTF-8') ?></h3>
                    <p class="mb-1"><strong><?= htmlspecialchars($proximo['agrupacion'], ENT_QUOTES, 'UTF-8') ?></strong></p>
                    <p class="mb-2"><?= htmlspecialchars($proximo['sede'], ENT_QUOTES, 'UTF-8') ?></p>
                    <?php if ($proximo['descripcion'] !== ''): ?>
                        <p class="mb-0"><?= htmlspecialchars($proximo['descripcion'], ENT_QUOTES, 'UTF-8') ?></p>
                    <?php endif; ?>
                </div>
            </article>
        <?php else: ?>
            <p class="text-secondary">Próximamente anunciaremos nuevas fechas.</p>
        <?php endif; ?>
    </section>

    <section class="container pb-5">
        <h2 class="mb-4">Nuestras agrupaciones</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($agrupaciones as $agrupacion): ?>
                <div class="col">
                    <article class="card tarjeta-agrupacion h-100 shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title h5"><?= htmlspecialchars($agrupacion[0], ENT_QUOTES, 'UTF-8') ?></h3>
                            <p class="card-text mb-0"><?= htmlspecialchars($agrupacion[1], ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>
<?php require 'pie.php'; ?>
