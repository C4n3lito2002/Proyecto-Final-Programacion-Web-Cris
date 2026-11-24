<?php
// Encabezado común de todas las páginas: <head> y barra de navegación.
// Cada página define $titulo antes de hacer require 'encabezado.php'.
// Las páginas dentro de una subcarpeta (admin/) definen además $base = '../'
// para que las rutas de CSS, imágenes y enlaces sigan funcionando.
$titulo = $titulo ?? 'Conservatorio de las Artes · Escuela de Música';
$base = $base ?? '';

// Estado de la sesión (la inicia conexion.php) y página actual, para el menú.
$sesionIniciada = isset($_SESSION['usuario_id']);
$esAdmin = $sesionIniciada && ($_SESSION['usuario_rol'] ?? '') === 'admin';
$script = $_SERVER['SCRIPT_NAME'] ?? '';
$enAdmin = str_contains($script, '/admin/');
$paginaActual = basename($script);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $base ?>css/estilos.css" rel="stylesheet">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark barra-principal">
        <div class="container">
            <a class="navbar-brand fs-6 text-wrap d-flex align-items-center gap-2" href="<?= $base ?>index.php">
                <img src="<?= $base ?>assets/img/logo-simbolo.png" alt="" width="44" height="44">
                <span>Conservatorio de las Artes</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Mostrar u ocultar el menú">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menuPrincipal">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link<?= ($paginaActual === 'index.php' && !$enAdmin) ? ' active' : '' ?>" href="<?= $base ?>index.php"<?= ($paginaActual === 'index.php' && !$enAdmin) ? ' aria-current="page"' : '' ?>>Inicio</a>
                    </li>
                    <?php if ($esAdmin): ?>
                        <li class="nav-item">
                            <a class="nav-link<?= $enAdmin ? ' active' : '' ?>" href="<?= $base ?>admin/index.php"<?= $enAdmin ? ' aria-current="page"' : '' ?>>Panel</a>
                        </li>
                    <?php endif; ?>
                    <?php if ($sesionIniciada): ?>
                        <li class="nav-item">
                            <span class="navbar-text me-lg-2">Hola, <?= htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Usuario', ENT_QUOTES, 'UTF-8') ?></span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $base ?>logout.php">Cerrar sesión</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link<?= $paginaActual === 'login.php' ? ' active' : '' ?>" href="<?= $base ?>login.php"<?= $paginaActual === 'login.php' ? ' aria-current="page"' : '' ?>>Iniciar sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link<?= $paginaActual === 'register.php' ? ' active' : '' ?>" href="<?= $base ?>register.php"<?= $paginaActual === 'register.php' ? ' aria-current="page"' : '' ?>>Registrarse</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
