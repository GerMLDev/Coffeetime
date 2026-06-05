<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nuevo Alumno</title>
    <script src="{{ asset('js/hamburguesa.js') }}"></script>
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

<body>
    <header></header>

    <div id="contenedor">
       <nav id="barranav">
            <button type="button" id="hamburguesa">&#9776;</button>

            <ul id="principal">
                <li><a href="{{ route('home') }}"><i class="bi bi-house-door-fill me-2"></i>Portada</a></li>
                <li><a href="{{ route('eventos') }}"><i class="bi bi-calendar-event-fill me-2"></i>Eventos</a></li>
                <li><a href="{{ route('recursos') }}"><i class="bi bi-folder-fill me-2"></i>Recursos</a></li>
                <li><a href="{{ route('informate') }}"><i class="bi bi-info-circle-fill me-2"></i>Infórmate</a></li>
            </ul>

            <div class="contenedor-desplegable">
                {{-- Si está logueado --}}
                @auth
                    <button type="button" class="btn-toggle-menu" id="hamburguesaUsuario">
                        <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->usuario }} ▾
                    </button>
                    <div id="menuUsuario" class="menu-desplegable-submenu">
                       <ul>
                            @if (auth()->user()->hasRole('admin'))
                                <li><a href="{{ route('gestor') }}"><i class="bi bi-database-fill-gear me-2"></i>Gestor de
                                        datos</a></li>
                            @elseif (auth()->user()->hasRole('profesor'))
                                <li><a href="{{ route('perfil') }}"><i class="bi bi-person-vcard-fill me-2"></i>Mi
                                        perfil</a>
                                </li>
                            @elseif (auth()->user()->hasRole('alumno'))
                                <li><a href="{{ route('perfil') }}"><i class="bi bi-person-vcard-fill me-2"></i>Mi
                                        perfil</a>
                                </li>
                                <li><a href="{{ route('eventos') }}"><i class="bi bi-calendar-check-fill me-2"></i>Mis
                                        eventos</a></li>
                            @endif
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                {{-- Si es invitado --}}
                    <div id="invitadodesktop">
                        <a href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-1"></i>Iniciar sesión</a>
                        <a href="{{ route('anadiralumno') }}"><i class="bi bi-person-plus-fill me-1"></i>Registrarse</a>
                    </div>
                    <button type="button" id="hamburguesaInvitado">
                        <i class="bi bi-person me-1"></i> Acceder
                    </button>
                    <div id="menuInvitado">
                        <ul>
                            <li><a href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-2"></i>Iniciar
                                    sesión</a></li>
                            <li><a href="{{ route('anadiralumno') }}"><i
                                        class="bi bi-person-plus-fill me-2"></i>Registrarse</a></li>
                        </ul>
                    </div>
                @endauth
            </div>
        </nav>
        <main>
            <div class="container mt-2 bg-light p-2 rounded shadow contenedor-formulario-alumno">
                <h2 class="text-center mb-4 bg-primary text-white p-2 rounded">Registrar alumno</h2>
                <hr>

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form id="web-alumno-crear-form" action="{{ route('registroalumnoweb') }}" method="post" class="bg-light p-2 rounded shadow-sm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" name="nombre" class="form-control">
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="apellidos" class="form-label">Apellidos:</label>
                            <input type="text" name="apellidos" class="form-control">
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="dni" class="form-label">DNI:</label>
                            <input type="text" name="dni" class="form-control">
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="usuario" class="form-label">Usuario:</label>
                            <input type="text" name="usuario" class="form-control">
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="contraseña" class="form-label">Contraseña:</label>
                            <input type="password" name="contraseña" class="form-control">
                        </div>

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
                <div class='m-2 p-2'>
                    <a href="{{ route('informate') }}">¿Quieres registrarte como profesor? Contáctanos.</a>
                </div>
            </div>
        </main>
      <footer class="py-4">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-12 col-md-4 text-center text-md-start mb-3 mb-md-0">
                <ul class="mb-0 footer-enlaces">
                    <li class="mb-2">
                        <a href="#" class="text-decoration-none fw-bold">Términos y Condiciones</a>
                    </li>
                    <li>
                        <a href="#" class="text-decoration-none fw-bold">Política de cookies</a>
                    </li>
                </ul>
            </div>

            <div class="col-12 col-md-4 text-center mb-3 mb-md-0">
                <div class="footer-iconos d-flex justify-content-center gap-3">
                    <a href="#" class="text-decoration-none"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="text-decoration-none"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-decoration-none"><i class="bi bi-linkedin"></i></a>
                    <a href="#" class="text-decoration-none"><i class="bi bi-telephone-fill"></i></a>
                </div>
            </div>

            <div class="col-12 col-md-4 d-flex justify-content-center justify-content-md-end">
                <div class="caja-email d-flex align-items-center p-2 px-3 rounded bg-light text-dark">
                    <i class="bi bi-envelope-fill me-2 fs-4"></i>
                    <a href="{{route('informate')}}" class="text-decoration-none"><span class="small font-monospace fw-semibold">coffeetimes@gmail.com</span></a>
                </div>
            </div>

        </div>
    </div>
</footer>
    <script src="{{ asset('js/validargeneral.js') }}"></script>
</body>

</html>
