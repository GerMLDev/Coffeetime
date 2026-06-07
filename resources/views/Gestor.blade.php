<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de datos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/general.css') }}">
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

<body class="bg-dark">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-md-5 bg-light rounded">
                        <h1 class="display-4 text-center text-dark py-3 border-bottom border-top border-dark mb-4">
                            SISTEMA GESTOR DE DATOS
                        </h1>

                        @auth
                            <div class="text-center mb-4">
                                <h2 class="fs-5 text-secondary">Bienvenido, <strong
                                        class="text-dark">{{ auth()->user()->usuario }}</strong>.</h2>
                            </div>
                        @endauth

                        <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 mb-3">

                            <a href="{{ route('home') }}" class="btn btn-outline-secondary flex-fill">
                                Volver a la portada
                            </a>

                            <form action="{{ route('logout') }}" method="POST" class="m-0 flex-fill">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    Cerrar Sesión
                                </button>
                            </form>

                        </div>
                        <div class="row justify-content-center mt-5 g-4">
                            <!-- Registro de Profesores -->
                            <div class="col-md-6 mb-4">
                                <div class="card shadow-sm p-4">
                                    <h3 class="text-center mb-4">Registro de Profesores</h3>
                                    <div class="d-grid gap-2 col-6 mx-auto">

                                        @if (auth()->user()->hasRole('admin'))
                                            <form action="{{ route('agregarprofe') }}">
                                                <button type="submit" class="btn btn-success w-100 mb-2">Añadir
                                                    Profesor</button>
                                            </form>
                                            <form action="{{ route('gestionarprofe') }}">
                                                <button type="submit"
                                                    class="btn btn-warning w-100 text-white mb-2">Gestionar
                                                    Profesores</button>
                                            </form>
                                        @endif

                                        @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('profesor'))
                                            <form action="{{ route('dashboardProfesor') }}">
                                                <button type="submit" class="btn btn-primary w-100 text-white">Alumnos
                                                    registrados por
                                                    Profesor</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if (auth()->user()->hasRole('admin'))
                                <!-- Registro de Usuarios -->
                                <div class="col-md-6 mb-4">
                                    <div class="card shadow-sm p-4">
                                        <h3 class="text-center mb-4">Registro de Usuarios</h3>
                                        <div class="d-grid gap-2 col-6 mx-auto">
                                            <form action="{{ route('api') }}">
                                                <button type="submit" class="btn btn-info w-100 text-white">API -
                                                    Listado
                                                    de usuarios</button>
                                            </form>

                                            <form action="{{ route('agregarusuario') }}">
                                                <button type="submit" class="btn btn-success w-100">Añadir
                                                    usuario</button>
                                            </form>
                                            <form action="{{ route('gestionarusuario') }}">
                                                <button type="submit"
                                                    class="btn btn-warning w-100 text-white">Gestionar
                                                    Usuarios</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Registro de Alumnos -->
                                <div class="col-md-6 mb-4">
                                    <div class="card shadow-sm p-4">
                                        <h3 class="text-center mb-4">Registro de Alumnos</h3>
                                        <div class="d-grid gap-2 col-6 mx-auto">


                                            <form action="{{ route('agregaralumno') }}">
                                                <button type="submit" class="btn btn-success w-100">Añadir
                                                    Alumno</button>
                                            </form>
                                            <form action="{{ route('gestionaralumno') }}">
                                                <button type="submit"
                                                    class="btn btn-warning w-100 text-white">Gestionar
                                                    Alumnos</button>
                                            </form>
                                            <form action="{{ route('dashboardNivel') }}">
                                                <button type="submit" class="btn btn-primary w-100 text-white">Alumnos
                                                    registrados
                                                    por
                                                    Nivel</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
</body>

</html>
