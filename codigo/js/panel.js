// Interacciones de la tabla de conciertos (admin/index.php):
//   1) confirmación antes de eliminar, mostrando el título del concierto;
//   2) buscador que filtra las filas de la tabla mientras se escribe.
// Esta página también carga validar-concierto.js. Todos los scripts comparten las mismas
// variables globales, así que aquí se evitan nombres que ya usa ese archivo
// (formulario, contador, patronHora, etc.); repetir un const marcaría error.

// ---------- 1) Confirmar antes de eliminar ----------
// Cada formulario de eliminar guarda el título en su atributo data-titulo.
const formulariosEliminar = document.querySelectorAll('.form-eliminar');

for (const formEliminar of formulariosEliminar) {
    formEliminar.addEventListener('submit', (evento) => {
        const tituloConcierto = formEliminar.dataset.titulo;

        // Si la persona cancela, se detiene el envío y el concierto no se elimina.
        if (!confirm('¿Eliminar el concierto "' + tituloConcierto + '"?')) {
            evento.preventDefault();
        }
    });
}

// ---------- 2) Buscador de la tabla ----------
const buscador = document.getElementById('buscador');
const filasConcierto = document.querySelectorAll('.fila-concierto');
const filaSinResultados = document.getElementById('sin-resultados');

// Junta el texto de las columnas 1 a 5 (título, agrupación, fecha, hora y sede).
// Se omiten el ID y la columna de botones para que, por ejemplo, "editar" no coincida
// con todas las filas por el texto de los botones.
function textoDeFila(fila) {
    let texto = '';

    for (let i = 1; i <= 5; i++) {
        texto += ' ' + fila.cells[i].textContent;
    }

    return texto.toLowerCase();
}

function filtrarFilas() {
    const busqueda = buscador.value.trim().toLowerCase();
    let visibles = 0;

    for (const fila of filasConcierto) {
        if (textoDeFila(fila).includes(busqueda)) {
            fila.classList.remove('d-none');
            visibles++;
        } else {
            fila.classList.add('d-none');
        }
    }

    // Avisa "sin resultados" solo si hay conciertos y ninguno coincide.
    if (filasConcierto.length > 0 && visibles === 0) {
        filaSinResultados.classList.remove('d-none');
    } else {
        filaSinResultados.classList.add('d-none');
    }
}

buscador.addEventListener('input', filtrarFilas);
filtrarFilas();   // al cargar: por si el navegador conserva el texto escrito al volver atrás
