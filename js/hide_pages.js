document.addEventListener('DOMContentLoaded', function () {
  if (!window.session_data) return;

  const tipoUsuario = String(window.session_data.userType || '')
    .trim()
    .toLowerCase();

  const botonConductor = document.getElementById('botonConductor');
  const botonVehiculo  = document.getElementById('botoncrearvehiculo');

  if (tipoUsuario === 'driver') {
    botonConductor && botonConductor.classList.remove('d-none');
    botonVehiculo  && botonVehiculo.classList.remove('d-none');
  } else {
    botonConductor && botonConductor.classList.add('d-none');
    botonVehiculo  && botonVehiculo.classList.add('d-none');
  }
});
