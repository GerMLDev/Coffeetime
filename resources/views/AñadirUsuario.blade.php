
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    @if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
    @endif
</head>

<body class="bg-dark" style="padding-bottom: 5%; padding-top: 2%;">
    <div class="container mt-5 bg-light p-4 rounded shadow" width="70%">
        <h2 class="text-center mb-4" style="background-color:green; color:white; padding: 10px;">Registrando nuevo Usuario</h2>
        <hr>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-300" formaction="{{ route('logout') }}">Cerrar
                Sesión</button>
        </form>
        <form action="">
            <button type="submit" class="btn btn-outline-secondary w-300" style="float: right"
                formaction="{{ route('gestor') }}">Volver</button>
        </form>
        <hr>
        <form action="{{route('registrousuario')}}" method="post" class="bg-light p-4 rounded shadow-sm" >
            @csrf

            <!-- Usuario -->
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" name="usuario" id="usuario" class="form-control" required>
            </div>

            <!-- Contraseña -->
            <div class="mb-3">
                <label for="contraseña" class="form-label">Contraseña:</label>
                <input type="password" name="contraseña" id="contraseña" class="form-control" minlength="8"  placeholder="Mínimo 8 caracteres"  required>
            </div>
            <!-- DNI -->
            <div class="mb-3">
                <label for="dni" class="form-label">DNI:</label>
                <input type="text" name="dni" id="dni" class="form-control" maxlength="9" placeholder="Máximo 9 caracteres incluida la letra"required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <!-- Rol -->
            <div class="mb-3">
                <label for="idrol" class="form-label">Rol:</label>
                <select name="idrol" class="form-control" required>
                   @foreach ($roles as $rol)
                        <option value="{{ $rol['id'] }}">
                            {{ htmlspecialchars($rol['rol']) }}
                        </option>
                    @endforeach
                </select>
            </div>


            <!-- Botón Registrar -->
            <button type="submit" name="boton" class="btn btn-success w-100">Registrar Usuario</button>
        </form>
    </div>
</body>

</html>