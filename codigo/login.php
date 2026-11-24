<?php
// Inicio de sesión (molde: sis_login/login.php del profesor, versión con rol).
require 'conexion.php';

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Completa el correo y la contraseña.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Correo o contraseña incorrectos.';
    } else {
        $consulta = $conexion->prepare('SELECT id, nombre, email, password, rol FROM usuarios WHERE email = ? LIMIT 1');
        $consulta->execute([$email]);
        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($password, $usuario['password'])) {
            session_regenerate_id(true);

            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_rol'] = $usuario['rol'];

            // El administrador entra al panel; el usuario normal, al Inicio.
            if ($usuario['rol'] === 'admin') {
                header('Location: admin/index.php');
            } else {
                header('Location: index.php');
            }
            exit;
        }

        $error = 'Correo o contraseña incorrectos.';
    }
}

// Variables para el encabezado compartido.
$titulo = 'Iniciar sesión · Conservatorio de las Artes';
require 'encabezado.php';
?>
<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body p-4 p-md-5">
                    <h1 class="h3 text-center mb-2">Bienvenido</h1>
                    <p class="text-secondary text-center mb-4">Inicia sesión en tu cuenta</p>

                    <?php if (isset($_GET['registro']) && $_GET['registro'] === 'ok'): ?>
                        <div class="alert alert-success" role="status">
                            Registro completado. Ya puedes iniciar sesión.
                        </div>
                    <?php endif; ?>

                    <?php if ($error !== ''): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="login.php" id="formLogin" novalidate>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required autocomplete="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>">
                            <div class="invalid-feedback" id="error-email"></div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required autocomplete="current-password">
                            <div class="invalid-feedback" id="error-password"></div>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="verPassword">
                            <label class="form-check-label" for="verPassword">Mostrar contraseña</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
                    </form>

                    <p class="text-center mt-4 mb-0">
                        ¿No tienes una cuenta? <a href="register.php">Regístrate</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
// Scripts propios de esta página (los imprime pie.php después de Bootstrap).
// El orden importa: validacion.js define funciones que usa validar-login.js.
$scripts = ['validacion.js', 'validar-login.js', 'mostrar-password.js'];
require 'pie.php';
?>
