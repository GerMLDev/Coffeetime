<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de datos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
    @endif
    
</head>
<body class="bg-dark">
   
    <div class="container my-5 bg-light p-4 rounded shadow" >
        <h1 class="display-4 text-center text-dark py-3 border-bottom border-top border-dark">
            SISTEMA GESTOR DE DATOS
        </h1> 
        <hr>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            @auth
            <h2>Bienvenido, {{auth()->user()->usuario}}.</h2>
        @endauth
        <br>
            <button type="submit" class="btn btn-outline-danger w-300">Cerrar Sesión</button>
        </form>
        <hr>
        <div class="row justify-content-center mt-5">
            <!-- Registro de Profesores -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm p-4">
                    <h3 class="text-center mb-4">Registro de Profesores</h3>
                    <div class="d-grid gap-2 col-6 mx-auto">


                        <form action="{{route('agregarprofe')}}">
                            <button type="submit" class="btn btn-success w-100">Añadir Profesor</button>
                        </form>
                        <form action="{{route('gestionarprofe')}}">
                            <button type="submit" class="btn btn-warning w-100 text-white">Gestionar Profesores</button>
                        </form>
                        <form action="{{route('dashboardProfesor')}}">
                            <button type="submit" class="btn btn-primary w-100 text-white">Alumnos registrados por Profesor</button>
                        </form>
                    
                    </div>
                </div>
            </div>
            @if (auth()->user()->hasRole('admin'))

            <!-- Registro de Usuarios -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm p-4">
                    <h3 class="text-center mb-4">Registro de Usuarios</h3>
                    <div class="d-grid gap-2 col-6 mx-auto">


                        <form action="{{route('agregarusuario')}}">
                            <button type="submit" class="btn btn-success w-100">Añadir usuario</button>
                        </form>
                        <form action="{{route('gestionarusuario')}}">
                            <button type="submit" class="btn btn-warning w-100 text-white">Gestionar Usuarios</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <!-- Registro de Alumnos -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm p-4">
                    <h3 class="text-center mb-4">Registro de Alumnos</h3>
                    <div class="d-grid gap-2 col-6 mx-auto">


                        <form action="{{route('agregaralumno')}}">
                            <button type="submit" class="btn btn-success w-100">Añadir Alumno</button>
                        </form>
                        <form action="{{route('gestionaralumno')}}">
                            <button type="submit" class="btn btn-warning w-100 text-white">Gestionar Alumnos</button>
                        </form>
                        <form action="{{route('dashboardNivel')}}">
                            <button type="submit" class="btn btn-primary w-100 text-white">Alumnos registrados por Nivel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>