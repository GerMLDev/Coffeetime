<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Profesor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
    @endif
</head>

<body class="bg-dark"
    style="padding-bottom: 5%; padding-top: 2%;">

    <div class="container mt-5 bg-light p-4 rounded shadow" width="70%">
        <h2 class="text-center mb-4" style="background-color:green; color:white; padding: 10px;">Registrando nuevo profesor</h2>
        <hr>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-300" formaction="{{ route('logout') }}">Cerrar
                Sesión</button>
        </form>
        <form action="">
            <button type="submit" class="btn btn-outline-secondary w-300" style="float: right"
                formaction="{{ route('inicio') }}">Volver</button>
        </form>
        <hr>
        <form action="{{route('registroprofe')}}" method="post" class="bg-light p-4 rounded shadow-sm">
            @csrf

            <!-- Campos del formulario de registro -->
            <div class="mb-3">
                <label for="nombre_profesor" class="form-label">Nombre:</label>
                <input type="text" name="nombre_profesor" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="apellidos_profesor" class="form-label">Apellidos:</label>
                <input type="text" name="apellidos_profesor" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email_profesor" class="form-label">Email:</label>
                <input type="email" name="email_profesor" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="dni_profesor" class="form-label">DNI:</label>
                <input type="text" name="dni_profesor" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="usuario_prof" class="form-label">Usuario:</label>
                <input type="text" name="usuario_prof" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="contraseña_prof" class="form-label">Contraseña:</label>
                <input type="text" name="contraseña_prof" class="form-control" required>
            </div>
            <button type="submit" name="boton" class="btn btn-success w-100">Registrar datos</button>


        </form>


    </div>

</body>

</html>