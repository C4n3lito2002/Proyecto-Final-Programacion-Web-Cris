// Validación del formulario de conciertos: sirve para el alta (admin/index.php)
// y para la edición (admin/editar.php), que usan los mismos ids de campos.
// El servidor (guardar.php y actualizar.php) vuelve a validar todo, porque el JS del
// navegador se puede saltar. Usa las funciones de validacion.js, que se carga antes.

// Elementos del DOM
const formulario = document.getElementById('formConcierto');
const campoTitulo = document.getElementById('titulo');
const campoAgrupacion = document.getElementById('agrupacion');
const campoFecha = document.getElementById('fecha');
const campoHora = document.getElementById('hora');
const campoSede = document.getElementById('sede');
const campoDescripcion = document.getElementById('descripcion');
const contador = document.getElementById('contador-descripcion');

const LIMITE_DESCRIPCION = 1000;

// Hora en formato de 24 horas HH:MM (de 00:00 a 23:59)
const patronHora = /^([01]\d|2[0-3]):[0-5]\d$/;

// Revisión común para los campos de texto obligatorios (título, agrupación y sede).
// "nombre" completa el mensaje: "Escribe el título.", "Escribe la sede.", etc.
function validarTexto(campo, nombre, maximo) {
    const texto = campo.value.trim();

    if (texto === '') {
        mostrarError(campo, 'Escribe ' + nombre + '.');
        return false;
    }
    if (texto.length > maximo) {
        mostrarError(campo, 'Máximo ' + maximo + ' caracteres.');
        return false;
    }

    mostrarValido(campo);
    return true;
}

function validarTitulo() {
    return validarTexto(campoTitulo, 'el título', 100);
}

function validarAgrupacion() {
    return validarTexto(campoAgrupacion, 'la agrupación', 100);
}

function validarSede() {
    return validarTexto(campoSede, 'la sede', 100);
}

// Un input type="date" entrega AAAA-MM-DD, o texto vacío si la fecha está incompleta.
// No se bloquean fechas pasadas: el calendario guarda también conciertos ya realizados.
function validarFecha() {
    if (campoFecha.value === '') {
        mostrarError(campoFecha, 'Selecciona una fecha completa.');
        return false;
    }

    mostrarValido(campoFecha);
    return true;
}

// La hora es HH:MM (por ejemplo 19:00) o exactamente "Por confirmar".
function validarHora() {
    const hora = campoHora.value.trim();

    if (hora === '') {
        mostrarError(campoHora, 'Escribe la hora.');
        return false;
    }
    if (hora !== 'Por confirmar' && !patronHora.test(hora)) {
        mostrarError(campoHora, 'Usa el formato HH:MM de 24 horas (por ejemplo 19:00) o escribe "Por confirmar".');
        return false;
    }

    mostrarValido(campoHora);
    return true;
}

activarValidacion(campoTitulo, validarTitulo);
activarValidacion(campoAgrupacion, validarAgrupacion);
activarValidacion(campoFecha, validarFecha);
activarValidacion(campoHora, validarHora);
activarValidacion(campoSede, validarSede);

// El input type="date" avisa con el evento "change" cuando se elige la fecha.
campoFecha.addEventListener('change', validarFecha);

// Contador de caracteres de la descripción (opcional). Se pone en rojo cerca del límite.
function actualizarContador() {
    const largo = campoDescripcion.value.length;

    contador.textContent = largo + ' / ' + LIMITE_DESCRIPCION;

    if (largo >= 900) {
        contador.classList.add('text-danger');
    } else {
        contador.classList.remove('text-danger');
    }
}

campoDescripcion.addEventListener('input', actualizarContador);
actualizarContador();   // al cargar: en editar.php el campo ya trae texto

// Al enviar: se revisan todos los campos obligatorios (para mostrar todos los errores
// a la vez). Si alguno falla, no se envía y el cursor va al primer campo con error.
formulario.addEventListener('submit', (evento) => {
    const tituloOk = validarTitulo();
    const agrupacionOk = validarAgrupacion();
    const fechaOk = validarFecha();
    const horaOk = validarHora();
    const sedeOk = validarSede();

    if (!(tituloOk && agrupacionOk && fechaOk && horaOk && sedeOk)) {
        evento.preventDefault();
        document.querySelector('.is-invalid').focus();
    }
});
