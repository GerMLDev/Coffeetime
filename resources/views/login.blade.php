<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark">
    <!-- Cambiado width fijo por col-md-4 para que sea responsivo -->
    <div class="container my-5 bg-light p-4 rounded shadow-lg col-11 col-sm-8 col-md-5 col-lg-4">
        
        <!-- Botón Volver (mejorado con d-flex para alinearlo a la derecha) -->
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('general') }}" class="btn btn-outline-secondary btn-sm">Volver</a>
        </div>

        <h2 class="text-center mb-4">Acceso al Sistema</h2>

        <form action="" method="post">
            @csrf
            <div class="mb-3 text-start">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" name="usuario" id="usuario" class="form-control" required>
            </div>
            <div class="mb-3 text-start">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2">Iniciar Sesión</button>
        </form>

        <hr class="my-4">

        <!-- BOTONES INFERIORES: Usamos una fila con columnas para que no se desborden -->
        <div class="row g-2">
            <div class="col-12 col-sm-6">
                <a href="{{ route('loginusuario') }}" class="btn btn-success btn-sm w-100">Registrarse</a>
            </div>
            <div class="col-12 col-sm-6">
                <a href="{{ route('api') }}" class="btn btn-warning btn-sm w-100 text-white">Usuarios</a>
            </div>
        </div>
    </div>
</body>
</html>