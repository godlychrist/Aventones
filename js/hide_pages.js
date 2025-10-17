document.addEventListener('DOMContentLoaded', function() {

    const tipoUsuario = session_data.userType; // Obtener el tipo de usuario desde los datos de sesión

    const botonConductor = document.getElementById('botonConductor');
    const botonConductor2 = document.getElementById('botonConductor2');
    const botonPasajero = document.getElementById('botonPasajero');

    if (tipoUsuario === 'driver') {
        // Mostrar botones para conductores
        if (botonConductor) botonConductor.style.display = 'inline-block';
        if (botonConductor2) botonConductor2.style.display = 'inline-block';
    } else if (tipoUsuario === 'user') {
        // Mostrar botón para pasajeros
        if (botonConductor) botonConductor.style.display = 'none';
        if (botonConductor2) botonConductor2.style.display = 'none';
    }
});
