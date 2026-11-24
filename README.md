# Conservatorio de las Artes · Escuela de Música

Proyecto final de **Web Application Development** (8vo semestre, Tecnologías de la Información, CUCEA, Universidad de Guadalajara).

- Autor: Cristopher Enrique Ramos Sanchez
- Profesor: Carlos Alberto Ridán Jardines

## Descripción

Sitio web de una escuela de música de Guadalajara. Presenta a la escuela, sus agrupaciones y su calendario de conciertos. Incluye registro e inicio de sesión de usuarios, y un panel de administración (solo para el rol `admin`) donde se pueden crear, editar y eliminar conciertos.

**Estado:** terminado. Incluye validaciones de formularios con JavaScript (registro, inicio de sesión y conciertos), confirmación al eliminar, buscador en la tabla del panel y avisos dinámicos de Bootstrap. El servidor vuelve a validar todo lo importante, porque el JavaScript del navegador se puede saltar.

## Tecnologías

- PHP 8.3 (sin frameworks)
- SQLite con PDO
- HTML5 y CSS3
- Bootstrap 5.3 (por CDN)
- JavaScript (sin librerías)

## Estructura

Todo el código del sitio está en la carpeta `codigo/`.

- `codigo/`: páginas PHP del sitio (`index.php`, `register.php`, `login.php`, `logout.php`) y archivos compartidos (`conexion.php`, `encabezado.php`, `pie.php`)
- `codigo/admin/`: panel de administración de conciertos (CRUD: `index.php`, `guardar.php`, `editar.php`, `actualizar.php`, `eliminar.php`) protegido por `proteger.php`
- `codigo/css/`: estilos propios
- `codigo/js/`: validaciones de formularios e interacciones (ver la sección siguiente)
- `codigo/assets/img/`: logotipos

## JavaScript (`codigo/js/`)

JavaScript puro, sin librerías. Cada página declara los scripts que necesita en el arreglo `$scripts` y `pie.php` los carga después de Bootstrap. El orden importa: `validacion.js` va siempre antes del archivo de la página, porque usa sus funciones.

| Archivo | Se usa en | Qué hace |
| --- | --- | --- |
| `validacion.js` | registro, login, conciertos | Funciones compartidas: `patronEmail`, `mostrarError`, `mostrarValido` y `activarValidacion` (valida al salir del campo y, después, mientras se escribe). |
| `validar-registro.js` | `register.php` | Valida nombre, correo, contraseña (mínimo 8 caracteres) y que la confirmación coincida. |
| `validar-login.js` | `login.php` | Revisa que el correo tenga forma de correo y que la contraseña no esté vacía. |
| `mostrar-password.js` | `login.php`, `register.php` | Casilla para mostrar u ocultar la contraseña. |
| `validar-concierto.js` | `admin/index.php`, `admin/editar.php` | Valida título, agrupación, fecha, hora (`HH:MM` de 24 horas o `Por confirmar`) y sede; contador de caracteres de la descripción. |
| `panel.js` | `admin/index.php` | Confirmación antes de eliminar (muestra el título del concierto) y buscador que filtra la tabla mientras se escribe. |

Los avisos de éxito (guardado, actualizado, eliminado) son alertas de Bootstrap: `guardar.php`, `actualizar.php` y `eliminar.php` redirigen a `admin/index.php?ok=...` y el panel solo muestra textos de una lista fija.

## Validación en el servidor

Las mismas reglas importantes se repiten en PHP, que es lo que realmente protege los datos: `guardar.php` y `actualizar.php` revisan campos obligatorios, el formato de la fecha y la hora; `register.php` y `login.php` validan sus datos; las consultas usan sentencias preparadas (PDO) y la salida se escapa con `htmlspecialchars`.

## Limitaciones conocidas

- El buscador de la tabla no ignora acentos (buscar "jovenes" no encuentra "Jóvenes").
- El aviso verde reaparece si se recarga la página, porque `?ok=` sigue en la URL.
- `eliminar.php` avisa "eliminado" aunque el ID no exista.
- El servidor revisa el formato de la fecha (`AAAA-MM-DD`), pero no que la fecha exista de verdad (por ejemplo 2026-02-31).
- La sesión se guarda en `$_SESSION`: si se borra a un usuario mientras tiene la sesión abierta, esa sesión sigue activa hasta que la cierre.
- En celular la tabla del panel se desplaza hacia un lado.

## Cómo ejecutarlo

1. Instalar MAMP (o cualquier servidor con PHP 8 y la extensión `pdo_sqlite`).
2. Configurar el **Document Root** del servidor apuntando a la carpeta `codigo/` de este proyecto.
3. Iniciar los servidores y abrir `http://localhost:8888` en el navegador.

La base de datos es un archivo SQLite (`conservatorio.db`) que se incluye en el repositorio.

## Usuarios y roles

- Cualquier persona puede registrarse desde `register.php`; su rol es `usuario` y no tiene acceso al panel.
- Solo el rol `admin` puede entrar a `admin/` para crear, editar y eliminar conciertos. Quien no tenga permiso es redirigido al inicio de sesión o al Inicio.

## Usuario de prueba

Cuenta de administrador para probar el CRUD de conciertos:

- Correo: `admin@conservatorio.edu.mx`
- Contraseña: `Admin2026`
