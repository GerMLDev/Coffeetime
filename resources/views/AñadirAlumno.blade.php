
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    @if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
    @endif
    
</head>

<body class="bg-dark" style="padding-bottom: 5%; padding-top: 2%;" >

    <div class="container mt-5 bg-light p-4 rounded shadow" width="70%">
        <h2 class="text-center mb-4" style="background-color:green; color:white; padding: 10px;">Registrando nuevo alumno</h2>
        <hr>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-300" formaction="{{ route('logout') }}">Cerrar Sesión</button>
        </form>
        <form action="">
            <button type="submit" class="btn btn-outline-secondary w-300" style="float: right"
                formaction="{{ route('inicio') }}">Volver</button>
        </form>
        <hr>

        <form action="{{route('registroalumno')}}" method="post" class="bg-light p-4 rounded shadow-sm">
            @csrf
            <!-- Nombre -->
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <!-- Apellidos -->
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos:</label>
                <input type="text" name="apellidos" class="form-control" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <!-- DNI -->
            <div class="mb-3">
                <label for="dni" class="form-label">DNI:</label>
                <input type="text" name="dni" class="form-control" required>
            </div>

            <!-- Usuario -->
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" name="usuario" class="form-control" required>
            </div>

            <!-- Contraseña -->
            <div class="mb-3">
                <label for="contraseña" class="form-label">Contraseña:</label>
                <input type="text" name="contraseña" class="form-control" required>
            </div>

            <!-- Profesor -->
            <div class="mb-3">
                <label for="idprofesor" class="form-label">Profesor:</label>
                <select name="idprofesor" id="idprofesor" class="form-select" required>

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
            <div class="mb-3">
                <label for="idnivel" class="form-label">Nivel:</label>
                <select name="idnivel" id="idnivel" class="form-select" required>

                @foreach ($niveles as $nivel)
                    <option value="{{ $nivel->id }}">
                        {{ $nivel->nivel }}
                    </option>
                @endforeach
                @if ($niveles->isEmpty())
                    <option value="">No hay niveles disponibles</option>
                @endif
                </select>
            </div>
            <!-- Botón Enviar -->
            <button type="submit" name="boton" class="btn btn-success w-100">Registrar datos</button>


        </form>
 
    </div>


</body>

</html>