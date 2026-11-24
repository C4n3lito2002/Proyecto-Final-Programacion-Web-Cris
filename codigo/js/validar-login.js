// Validación del formulario de inicio de sesión (login.php).
// Solo revisa que los campos no estén vacíos y que el correo tenga forma de correo.
// No revisa el largo de la contraseña: eso lo decide el servidor al comparar con la base
// de datos. Usa las funciones de validacion.js, que se carga antes en login.php.

// Elementos del DOM (cada uno tiene un id único en login.php)
const formulario = document.getElementById('formLogin');
const campoEmail = document.getElementById('email');
const campoPassword = document.getElementById('password');

// Cada función devuelve true si el campo es válido y false si no.
function validarEmail() {
    const email = campoEmail.value.trim();

    if (email === '') {
        mostrarError(campoEmail, 'Ingresa tu correo electrónico.');
        return false;
    }
    if (!patronEmail.test(email)) {
        mostrarError(campoEmail, 'Ingresa un correo válido, por ejemplo nombre@correo.com.');
        return false;
    }

    mostrarValido(campoEmail);
    return true;
}

function validarPassword() {
    if (campoPassword.value === '') {
        mostrarError(campoPassword, 'Ingresa tu contraseña.');
        return false;
    }

    mostrarValido(campoPassword);
    return true;
}

activarValidacion(campoEmail, validarEmail);
activarValidacion(campoPassword, validarPassword);

// Al enviar: se revisan los dos campos. Si alguno falla, no se envía el formulario
// y el cursor va al primer campo con error.
formulario.addEventListener('submit', (evento) => {
    const emailOk = validarEmail();
    const passwordOk = validarPassword();

    if (!(emailOk && passwordOk)) {
        evento.preventDefault();
        document.querySelector('.is-invalid').focus();
    }
});
