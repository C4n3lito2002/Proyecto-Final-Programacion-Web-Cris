# Conservatorio de las Artes · Escuela de Música

Proyecto final de **Web Application Development**
8vo semestre, Tecnologías de la Información, CUCEA, Universidad de Guadalajara.

- **Autor:** Cristopher Enrique Ramos Sanchez
- **Profesor:** Carlos Alberto Ridán Jardines

## ¿Qué es?

Sitio web de una escuela de música de Guadalajara. Muestra la escuela, sus agrupaciones y su calendario de conciertos.

## ¿Qué puede hacer?

- Registrarse e iniciar sesión.
- Ver los conciertos.
- Si eres administrador: **crear, editar y eliminar conciertos** desde un panel.

## Cómo ejecutarlo

1. Instala MAMP (Para Mac) o WAMP (Para Windows)
2. Pon el **Document Root** del servidor en la carpeta `codigo/` de este proyecto.
3. Inicia los servidores y abre `http://localhost:8888` en el navegador.

La base de datos (`conservatorio.db`) ya viene incluida en el repositorio.

## Usuario de prueba (administrador)

- Correo: `admin@conservatorio.edu.mx`
- Contraseña: `Admin2026`

Cualquier persona puede registrarse desde `register.php` como usuario normal, pero solo el administrador entra al panel.

## Tecnologías

PHP 8.3 · SQLite (PDO) · HTML5 · CSS3 · Bootstrap 5.3 · JavaScript

## Estructura

- `codigo/`: páginas del sitio y archivos compartidos.
- `codigo/admin/`: panel de administración de conciertos (protegido).
- `codigo/css/`, `codigo/js/`, `codigo/assets/img/`: estilos, validaciones y logotipos.

## Validaciones

- **En el navegador (JavaScript):** revisa los formularios de registro, login y conciertos, pide confirmación antes de eliminar y tiene un buscador en la tabla.
- **En el servidor (PHP):** repite las validaciones importantes, usa consultas preparadas y escapa la salida con `htmlspecialchars`.

## Limitaciones conocidas

- El buscador no ignora acentos.
- El aviso verde reaparece si recargas la página.
- No valida que una fecha exista de verdad (por ejemplo, 2026-02-31).
- En celular, la tabla del panel se desplaza hacia un lado.
