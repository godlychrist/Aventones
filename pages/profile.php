<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <title>Aventones | Mi Perfil</title>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>

 
  <link rel="stylesheet" href="/css/logIn.css"/>
</head>
<body>
  <main class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
    <div class="login-wrapper shadow border border-primary rounded p-4 p-md-5 text-center d-flex flex-column align-items-center gap-3" style="max-width: 720px; width:100%;">
      <h1 class="brand-title fw-bold text-primary m-0">AVENTONES</h1>
      <h2 class="h5 text-secondary m-0">Mi Perfil</h2>

     
      <form action="/functions/profile_update.php" method="post" enctype="multipart/form-data" class="formulario-login text-start w-100 mt-3" style="max-width: 600px;">

       
        <div class="d-flex align-items-center gap-3 mb-3">
          <div class="rounded-circle overflow-hidden" style="width: 80px; height: 80px; border:1px solid #0d6efd;">
          
            <img src="/images/avatar_placeholder.png" alt="Foto de perfil" style="width:100%; height:100%; object-fit:cover;">
          </div>
          <div>
            <label for="image" class="form-label fw-bold text-dark mb-1">Cambiar fotografía</label>
            <input type="file" id="image" name="image" class="form-control" accept="image/*">
            <small class="text-muted">Deja vacío si no deseas cambiarla.</small>
          </div>
        </div>

   
        <div class="row g-3">
          <div class="col-12 col-md-6">
            <label for="name" class="form-label fw-bold text-dark">Nombre</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Juan" value="" required>
            <!-- value="<?php // echo htmlspecialchars($user['name'] ?? ''); ?>" -->
          </div>
          <div class="col-12 col-md-6">
            <label for="lastname" class="form-label fw-bold text-dark">Apellidos</label>
            <input type="text" id="lastname" name="lastname" class="form-control" placeholder="Pérez Solano" value="" required>
            <!-- value="<?php // echo htmlspecialchars($user['lastname'] ?? ''); ?>" -->
          </div>
        </div>

        <!-- Cédula (solo lectura) / Fecha Nacimiento -->
        <div class="row g-3 mt-1">
          <div class="col-12 col-md-6">
            <label for="cedula" class="form-label fw-bold text-dark">Cédula</label>
            <input type="text" id="cedula" name="cedula" class="form-control" value="" readonly>
            <!-- value="<?php // echo htmlspecialchars($user['cedula'] ?? ''); ?>" -->
          </div>
          <div class="col-12 col-md-6">
            <label for="birthDate" class="form-label fw-bold text-dark">Fecha de nacimiento</label>
            <input type="date" id="birthDate" name="birthDate" class="form-control" value="">
            <!-- value="<?php // echo htmlspecialchars($user['birthDate'] ?? ''); ?>" -->
          </div>
        </div>

        <!-- Correo / Teléfono -->
        <div class="row g-3 mt-1">
          <div class="col-12 col-md-6">
            <label for="mail" class="form-label fw-bold text-dark">Correo</label>
            <input type="email" id="mail" name="mail" class="form-control" placeholder="tu@correo.com" value="" required>
            <!-- value="<?php // echo htmlspecialchars($user['mail'] ?? ''); ?>" -->
          </div>
          <div class="col-12 col-md-6">
            <label for="phoneNum" class="form-label fw-bold text-dark">Teléfono</label>
            <input type="tel" id="phoneNum" name="phoneNum" class="form-control" placeholder="8888-8888" value="" required>
            <!-- value="<?php // echo htmlspecialchars($user['phoneNum'] ?? ''); ?>" -->
          </div>
        </div>

        <!-- Cambiar contraseña (opcional) -->
        <div class="row g-3 mt-1">
          <div class="col-12 col-md-6">
            <label for="password" class="form-label fw-bold text-dark">Nueva contraseña</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="********">
          </div>
          <div class="col-12 col-md-6">
            <label for="password_confirm" class="form-label fw-bold text-dark">Confirmar contraseña</label>
            <input type="password" id="password_confirm" name="password_confirm" class="form-control" placeholder="********">
          </div>
        </div>

        <!-- Estado / Tipo (solo lectura para mostrar) -->
        <div class="row g-3 mt-1">
          <div class="col-12 col-md-6">
            <label class="form-label fw-bold text-dark">Estado de cuenta</label>
            <input type="text" class="form-control" value="activa" readonly>
            <!-- value="<?php // echo htmlspecialchars($user['state'] ?? ''); ?>" -->
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label fw-bold text-dark">Tipo de usuario</label>
            <input type="text" class="form-control" value="chofer" readonly>
            <!-- value="<?php // echo htmlspecialchars($user['userType'] ?? ''); ?>" -->
          </div>
        </div>

        <!-- Botón -->
        <div class="d-flex justify-content-center mt-4">
          <button type="submit" class="login-btn btn btn-primary">Guardar cambios</button>
        </div>

        <!-- Link -->
        <p class="register-text text-center mt-3">
          <a href="/pages/main.php">Volver al panel</a>
        </p>
      </form>
    </div>
  </main>

  <footer class="footer text-center mt-4">
    <nav class="footer-nav mb-2">
      <a href="/pages/public_rides.php">Rides</a> |
      <a href="/index.php">Login</a> |
      <a href="/pages/registration_passenger.php">Registro Pasajero</a> |
      <a href="/pages/registration_driver.php">Registro Conductor</a>
    </nav>
    <p class="footer-copy">© Aventones.com</p>
  </footer>
</body>
</html>
