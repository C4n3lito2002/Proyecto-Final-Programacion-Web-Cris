<?php
// Registro de usuarios (molde: sis_login/register.php del profesor).
// El rol no se pide en el formulario: la tabla lo asigna como 'usuario' por defecto.
require 'conexion.php';

$errores = [];
$nombre = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmar = $_POST['confirmar'] ?? '';

    if ($nombre === '' || strlen($nombre) > 100) {
        $errores[] = 'El nombre es obligatorio y debe tener máximo 100 caracteres.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 254) {
        $errores[] = 'Ingresa un correo electrónico válido.';
    }

    if (strlen($password) < 8) {
        $errores[] = 'La contraseña debe tener al menos 8 caracteres.';
    }

    if ($password !== $confirmar) {
        $errores[] = 'Las contraseñas no coinciden.';
    }

    if (!$errores) {
        try {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $consulta = $conexion->prepare('INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)');
            $consulta->execute([$nombre, $email, $hash]);

            header('Location: login.php?registro=ok');
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                $errores[] = 'Este correo ya está registrado.';
            } else {
                error_log($e->getMessage());
                $errores[] = 'No se pudo completar el registro.';
            }
        }
    }
}

// Variables para el encabezado compartido.
$titulo = 'Crear cuenta · Conservatorio de las Artes';
require 'encabezado.php';
?>
<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <h1 class="h3 text-center mb-2">Crear cuenta</h1>
                    <p class="text-secondary text-center mb-4">Regístrate para comenzar</p>

                    <?php if ($errores): ?>
                        <div class="alert alert-danger" role="alert">
                            <ul class="mb-0">
                                <?php foreach ($errores as $error): ?>
                                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="register.php" id="formRegistro" novalidate>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" maxlength="100" required autocomplete="name" value="<?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?>">
                            <div class="invalid-feedback" id="error-nombre"></div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" maxlength="254" required autocomplete="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>">
                            <div class="invalid-feedback" id="error-email"></div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" minlength="8" required autocomplete="new-password">
                            <div class="invalid-feedback" id="error-password"></div>
                            <div class="form-text">Mínimo 8 caracteres.</div>
                        </div>

                        <div class="mb-3">
                            <label for="confirmar" class="form-label">Confirmar contraseña</label>
                            <input type="password" class="form-control" id="confirmar" name="confirmar" minlength="8" required autocomplete="new-password">
                            <div class="invalid-feedback" id="error-confirmar"></div>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="verPassword">
                            <label class="form-check-label" for="verPassword">Mostrar contraseñas</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Registrarme</button>
                    </form>

                    <p class="text-center mt-4 mb-0">
                        ¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
// Scripts propios de esta página (los imprime pie.php después de Bootstrap).
// El orden importa: validacion.js define funciones que usa validar-registro.js.
$scripts = ['validacion.js', 'validar-registro.js', 'mostrar-password.js'];
require 'pie.php';
?>
