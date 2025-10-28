(function () {
  const form = document.getElementById('loginForm');
  const alertBox = document.getElementById('alertBox');

  function showAlert(msg, type = 'info') {
    alertBox.classList.remove('d-none', 'alert-info', 'alert-danger', 'alert-success');
    alertBox.classList.add('alert', `alert-${type}`);
    alertBox.innerHTML = msg;
  }
  function hideAlert() {
    alertBox.classList.add('d-none');
    alertBox.innerHTML = '';
  }

  // Detecta el prefijo/base de la app:
  // - Si estás en /pages/login.php => "" (raíz)
  // - Si estás en /Aventones/pages/login.php => "/Aventones"
  // - Si estás en /algo/mas/pages/login.php => "/algo/mas"
  function getBase() {
    const path = location.pathname;            // p.ej. "/pages/login.php" o "/Aventones/pages/login.php"
    const m = path.match(/^(.*?)(\/pages\/|\/functions\/|\/js\/)/);
    return m ? m[1] : '';                      // prefijo antes de /pages|/functions|/js
  }

  if (!form) return;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    hideAlert();

    const cedula = document.getElementById('cedula').value.trim();
    const password = document.getElementById('password').value.trim();

    if (!cedula || !password) {
      showAlert('Cédula o contraseña vacíos.', 'danger');
      return;
    }

    const BASE = getBase();                    // "" o "/Aventones"
    const url  = `${BASE}/functions/login.php`;

    try {
      const resp = await fetch(url, {
        method: 'POST',
        headers: {
          'X-Requested-With': 'fetch',
          'Accept': 'application/json'
        },
        body: new URLSearchParams({ cedula, password })
      });

      const ct = resp.headers.get('content-type') || '';
      let data = null;

      if (ct.includes('application/json')) {
        data = await resp.json();
      } else {
        // Por si el server devolvió HTML (404/500), no rompas el flujo.
        const txt = await resp.text();
        console.warn('Respuesta no-JSON:', resp.status, txt);
        showAlert('Error de red o servidor. Intenta de nuevo.', 'danger');
        return;
      }

      if (resp.ok && data && data.ok) {
        window.location.href = data.redirect || `${BASE}/pages/main.php`;
        return;
      }

      // Manejo de errores del backend
      switch (data && data.error) {
        case 'nouser':
          showAlert(
            `❌ Usuario no existente. <a href="${BASE}/pages/registration_passenger.php">Regístrate aquí</a> o <a href="${BASE}/pages/registration_driver.php">como conductor</a>.`,
            'danger'
          );
          break;
        case 'pendiente':
          showAlert('Tu cuenta está <strong>Pendiente</strong>. Revisa tu correo y activa la cuenta.', 'info');
          break;
        case 'inactivo':
          showAlert('Tu cuenta está <strong>Inactiva</strong>. Contacta al administrador.', 'info');
          break;
        case 'cred':
        default:
          showAlert('Cédula o contraseña incorrectos.', 'danger');
          break;
      }
    } catch (err) {
      console.error('Fetch error:', err);
      showAlert('Error de red o servidor. Intenta de nuevo.', 'danger');
    }
  });
})();
