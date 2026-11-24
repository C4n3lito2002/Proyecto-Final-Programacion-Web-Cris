// Validación del formulario de registro (register.php).
// Mejora la experiencia: avisa los errores antes de enviar. El servidor (register.php)
// vuelve a validar todo, porque el JS del navegador se puede saltar.
// Usa las funciones de validacion.js (patronEmail, mostrarError, mostrarValido y
// activarValidacion), que se carga antes en register.php.

// Elementos del DOM (cada uno tiene un id único en register.php)
const formulario = document.getElementById('formRegistro');
const campoNombre = document.getElementById('nombre');
const campoEmail = document.getElementById('email');
const campoPassword = document.getElementById('password');
const campoConfirmar = document.getElementById('confirmar');

// Cada función devuelve true si el campo es válido y false si no.
function validarNombre() {
    const nombre = campoNombre.value.trim();

    if (nombre === '') {
        mostrarError(campoNombre, 'El nombre es obligatorio.');
        return false;
    }
    if (nombre.length > 100) {
        mostrarError(campoNombre, 'El nombre debe tener máximo 100 caracteres.');
        return false;
    }

    mostrarValido(campoNombre);
    return true;
}

function validarEmail() {
    const email = campoEmail.value.trim();

    if (email === '') {
        mostrarError(campoEmail, 'El correo electrónico es obligatorio.');
        return false;
    }
    if (!patronEmail.test(email) || email.length > 254) {
        mostrarError(campoEmail, 'Ingresa un correo válido, por ejemplo nombre@correo.com.');
        return false;
    }

    mostrarValido(campoEmail);
    return true;
}

function validarPassword() {
    const password = campoPassword.value;

    if (password.length < 8) {
        mostrarError(campoPassword, 'La contraseña debe tener al menos 8 caracteres.');
        return false;
    }

    mostrarValido(campoPassword);
    return true;
}

function validarConfirmar() {
    const confirmar = campoConfirmar.value;

    if (confirmar === '') {
        mostrarError(campoConfirmar, 'Confirma tu contraseña.');
        return false;
    }
    if (confirmar !== campoPassword.value) {
        mostrarError(campoConfirmar, 'Las contraseñas no coinciden.');
        return false;
    }

    mostrarValido(campoConfirmar);
    return true;
}

activarValidacion(campoNombre, validarNombre);
activarValidacion(campoEmail, validarEmail);
activarValidacion(campoPassword, validarPassword);
activarValidacion(campoConfirmar, validarConfirmar);

// Si se cambia la contraseña después de haber escrito la confirmación,
// la confirmación se revisa de nuevo.
campoPassword.addEventListener('input', () => {
    if (campoConfirmar.value !== '') {
        validarConfirmar();
    }
});

// Al enviar: se revisan todos los campos (para mostrar todos los errores a la vez).
// Si alguno falla, no se envía el formulario y el cursor va al primer campo con error.
formulario.addEventListener('submit', (evento) => {
    const nombreOk = validarNombre();
    const emailOk = validarEmail();
    const passwordOk = validarPassword();
    const confirmarOk = validarConfirmar();

    if (!(nombreOk && emailOk && passwordOk && confirmarOk)) {
        evento.preventDefault();
        document.querySelector('.is-invalid').focus();
    }
});
