<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @if (session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @elseif (session('error'))
        <script>
            alert("{{ session('error') }}");
        </script>
    @endif
</head>

<body class="bg-dark espacio-pagina">
    <div class="container mt-5 bg-light p-4 rounded shadow contenedor-formulario">
        <h2 class="text-center mb-4 bg-success text-white p-2 rounded">Registrando nuevo Usuario</h2>
        <div class="d-flex justify-content-between align-items-center mb-3">

            <a href="{{ route('gestor') }}" class="btn btn-outline-secondary">
                Volver al gestor
            </a>

            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-outline-danger">
                    Cerrar Sesión
                </button>
            </form>

        </div>
        <hr>
        <form id="usuario-crear-form" action="{{ route('registrousuario') }}" method="post" class="bg-light p-2 rounded shadow-sm">
    @csrf
    <div class="row">
        <div class="col-12 col-md-6">
            <label for="usuario" class="form-label">Usuario:</label>
            <input type="text" name="usuario" id="usuario" class="form-control">
        </div>
        <div class="col-12 col-md-6">
            <label for="contraseña" class="form-label">Contraseña:</label>
            <input type="password" name="contraseña" id="contraseña" class="form-control" minlength="8"
                placeholder="Mínimo 8 caracteres">
        </div>
        <div class="col-12 col-md-6">
            <label for="dni" class="form-label">DNI:</label>
            <input type="text" name="dni" id="dni" class="form-control" maxlength="9"
                placeholder="Máximo 9 caracteres incluida la letra">
        </div>
        <div class="col-12 col-md-6">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="col-12 col-md-6">
            <label for="idrol" class="form-label">Rol:</label>
            <select name="idrol" class="form-select">
                @foreach ($roles as $rol)
                    <option value="{{ $rol['id'] }}">{{ htmlspecialchars($rol['rol']) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <button type="submit" name="boton" class="btn btn-success mt-3">Registrar Usuario</button>
</form>
    </div>
    <script src="{{ asset('js/validargeneral.js') }}"></script>
</body>

</html>
