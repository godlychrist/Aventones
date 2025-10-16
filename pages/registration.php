<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register</title>
</head>

<body>
    <h1>Register</h1>
    <form action="/functions/insertUser.php" method="post" enctype="multipart/form-data" class="registration-form">

<br>
        <div class="form-grouper">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required><br><br>

            <label for="lastName">Apellidos:</label>
            <input type="text" id="lastName" name="lastName" required><br><br>

            <label for="cedula">Cedula:</label>
            <input type="text" id="cedula" name="cedula" required><br><br>

            <label for="fecha_nac">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nac" name="fecha_nac" required><br><br>
        </div>
        
        <div class="one-grouper">
            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" required><br><br>
        </div>

        <div class="form-grouper">        
            <label for="telefono">Telefono:</label>
            <input type="text" id="telefono" name="telefono" required><br><br>
            
            <label for="foto">Fotografía Personal:</label>
            <input type="file" id="foto" name="foto" required><br><br>
        
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <label for="password">Repeat Password:</label>
            <input type="password" id="password" name="password" required><br><br>
        </div>
        <button type="submit">Register</button>
    </form>
</body>

</html>