
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="{{ asset('js/validargeneral.js') }}"></script>


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
        <h2 class="text-center mb-4 bg-success text-white p-2 rounded">Registrando nuevo alumno</h2>
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
      <form id="alumno-crear-form" action="{{route('registroalumno')}}" method="post" class="bg-light p-2 rounded shadow-sm">
    @csrf
    <div class="row">
        <!-- Nombre -->
        <div class="col-12 col-md-6">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control">
        </div>

        <!-- Apellidos -->
        <div class="col-12 col-md-6">
            <label for="apellidos" class="form-label">Apellidos:</label>
            <input type="text" name="apellidos" class="form-control">
        </div>

        <!-- Email -->
        <div class="col-12 col-md-6">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" class="form-control">
        </div>

        <!-- DNI -->
        <div class="col-12 col-md-6">
            <label for="dni" class="form-label">DNI:</label>
            <input type="text" name="dni" class="form-control">
        </div>

        <!-- Usuario -->
        <div class="col-12 col-md-6">
            <label for="usuario" class="form-label">Usuario:</label>
            <input type="text" name="usuario" class="form-control">
        </div>

        <!-- Contraseña -->
        <div class="col-12 col-md-6">
            <label for="contraseña" class="form-label">Contraseña:</label>
            <input type="password" name="contraseña" class="form-control">
        </div>

        <!-- Profesor -->
        <div class="col-12 col-md-6">
            <label for="idprofesor" class="form-label">Profesor:</label>
            <select name="idprofesor" id="idprofesor" class="form-select">
                @foreach ($profesores as $profesor)
                    <option value="{{ $profesor->id }}">
                        {{ $profesor->nombre_profesor . " " . $profesor->apellidos_profesor }}
                    </option>
                @endforeach
                @if ($profesores->isEmpty())
                    <option value="">No hay profesores disponibles</option>
                @endif
            </select>
        </div>

        <!-- Nivel -->
        <div class="col-12 col-md-6">
            <label for="idnivel" class="form-label">Nivel:</label>
            <select name="idnivel" id="idnivel" class="form-select">
                @foreach ($niveles as $nivel)
                    <option value="{{ $nivel->id }}">{{ $nivel->nivel }}</option>
                @endforeach
                @if ($niveles->isEmpty())
                    <option value="">No hay niveles disponibles</option>
                @endif
            </select>
        </div>
    </div>
    <button type="submit" name="boton" class="btn btn-success mt-3">Registrar datos</button>
</form>

    </div>
</body>

</html>
