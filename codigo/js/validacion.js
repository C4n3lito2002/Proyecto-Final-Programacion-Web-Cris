// Funciones compartidas por las validaciones de formularios (registro, inicio de sesión
// y conciertos). Cada página las usa junto con su propio archivo.
// IMPORTANTE: este archivo se carga ANTES que el de la página. El navegador ejecuta los
// scripts en el orden en que aparecen, y si uno usa algo del otro antes de que cargue,
// marca error en la consola.

// Correo con forma algo@dominio.ext, sin espacios (equivalente a filter_var de PHP)
const patronEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

// Marca el campo en rojo y escribe el mensaje en su div "error-<id>"
function mostrarError(campo, mensaje) {
    campo.classList.remove('is-valid');
    campo.classList.add('is-invalid');
    document.getElementById('error-' + campo.id).textContent = mensaje;
}

// Marca el campo en verde
function mostrarValido(campo) {
    campo.classList.remove('is-invalid');
    campo.classList.add('is-valid');
}

// Valida al salir del campo (blur). Después de la primera revisión, vuelve a validar
// mientras se escribe (input), para que el mensaje desaparezca en cuanto se corrige.
function activarValidacion(campo, funcionValidar) {
    campo.addEventListener('blur', funcionValidar);
    campo.addEventListener('input', () => {
        if (campo.classList.contains('is-invalid') || campo.classList.contains('is-valid')) {
            funcionValidar();
        }
    });
}
