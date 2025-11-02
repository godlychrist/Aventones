<?php
session_start();

// 1. OBTENER LAS VARIABLES DE LA URL
$vehicle_id = $_GET['id'] ?? null;
$plateNum   = $_GET['plateNum'] ?? '';
$brand      = $_GET['brand'] ?? '';
$model      = $_GET['model'] ?? '';
$year       = $_GET['year'] ?? '';
$color      = $_GET['color'] ?? '';
$capacity   = $_GET['capacity'] ?? '';
$image      = $_GET['image'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aventones | Editar Vehículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/logIn.css" />
</head>

<body>
    <main class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
        <div class="login-wrapper shadow border border-primary rounded p-4 p-md-5 text-center d-flex flex-column align-items-center gap-3"
            style="max-width: 700px; width:100%;">
            <h1 class="brand-title fw-bold text-primary m-0">AVENTONES</h1>
            <h2 class="h5 text-secondary m-0">Editar Vehículo</h2>

            <form action="/functions/editvehicle.php" method="post" enctype="multipart/form-data"
                class="formulario-login text-start w-100 mt-3" style="max-width: 560px;">
                <input type="hidden" name="vehicle_id" value="<?= htmlspecialchars((string)($vehicle_id ?? '')) ?>">

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="plateNum" class="form-label fw-bold text-dark">Número de placa</label>
                        <input type="text" id="plateNum" name="plateNum" class="form-control"
                            value="<?= htmlspecialchars($plateNum) ?>" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="color" class="form-label fw-bold text-dark">Color</label>
                        <input type="text" id="color" name="color" class="form-control"
                            value="<?= htmlspecialchars($color) ?>" required>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-12 col-md-6">
                        <label for="brand" class="form-label fw-bold text-dark">Marca</label>
                        <input type="text" id="brand" name="brand" class="form-control"
                            value="<?= htmlspecialchars($brand) ?>" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="model" class="form-label fw-bold text-dark">Modelo</label>
                        <input type="text" id="model" name="model" class="form-control"
                            value="<?= htmlspecialchars($model) ?>" required>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-12 col-md-6">
                        <label for="year" class="form-label fw-bold text-dark">Año</label>
                        <input type="number" id="year" name="year" class="form-control"
                            value="<?= htmlspecialchars(trim($year)) ?>" min="1900" max="2100" required>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="capacity" class="form-label fw-bold text-dark">Capacidad de asientos</label>
                        <input type="number" id="capacity" name="capacity" class="form-control"
                            value="<?= htmlspecialchars(trim($capacity)) ?>" min="1" max="4" required>
                        <small class="text-muted">De 1 a 4 asientos.</small>
                    </div>
                </div>

                <div class="mt-3">
                    <label for="image" class="form-label fw-bold text-dark">Fotografía del automotor</label>
                    <?php if (!empty($image)): ?>
                    <div class="mb-2">
                        <small class="text-muted">Foto actual:</small><br>
                        <img src="<?= htmlspecialchars($image) ?>" alt="Foto vehículo actual"
                            style="max-width: 150px; height: auto; border-radius: 4px;">
                        <input type="hidden" name="current_image" value="<?= htmlspecialchars($image) ?>">
                    </div>
                    <?php endif; ?>
                    <input type="file" id="image" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">Deja vacío si no deseas cambiar la foto.</small>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" class="login-btn btn btn-primary">Guardar Cambios</button>
                </div>

                <p class="register-text text-center mt-3">
                    <a href="/functions/showvehicle.php">Volver a mis vehículos</a>
                </p>
            </form>
        </div>
    </main>

    <!-- ✅ Reutiliza el mismo limitador que en "crear" -->
    <script src="/js/vehicle_form.js"></script>
</body>

</html>