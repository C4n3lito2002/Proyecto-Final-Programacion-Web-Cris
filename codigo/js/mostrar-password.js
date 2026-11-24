// Casilla "Mostrar contraseña": cambia el type de los campos de contraseña
// entre "password" (puntos) y "text" (se ve lo escrito).
// Se usa en login.php (un campo) y en register.php (dos campos).

const casillaVer = document.getElementById('verPassword');
const camposPassword = [
    document.getElementById('password'),
    document.getElementById('confirmar')   // en login.php este campo no existe (null)
];

casillaVer.addEventListener('change', () => {
    const tipo = casillaVer.checked ? 'text' : 'password';

    for (const campo of camposPassword) {
        if (campo !== null) {
            campo.type = tipo;
        }
    }
});
