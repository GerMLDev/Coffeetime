<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/general.css') }}">
    <script src="{{ asset('js/hamburguesa.js') }}"></script>
    <script src="{{ asset('js/login.js') }}"></script>

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
                            {{-- Si es admin o profesorr --}}
                            @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('profesor'))
                                <li><a href="{{ route('perfil') }}"><i class="bi bi-person-vcard-fill me-2"></i>Mi
                                        perfil</a></li>
                                <li><a href="{{ route('gestor') }}"><i class="bi bi-database-fill-gear me-2"></i>Gestor de
                                        datos</a></li>
                                {{-- Si es alumno --}}
                            @elseif (auth()->user()->hasRole('alumno'))
                                <li><a href="{{ route('perfil') }}"><i class="bi bi-person-vcard-fill me-2"></i>Mi
                                        perfil</a></li>
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
            <div class="container bg-light p-2 rounded col-12 col-sm-12 col-md-12 col-lg-6">

                <h2 class="text-center mb-2">Inicia sesión</h2>


                <form action="" method="post" id="formulario" class="mb-2">
                    @csrf
                    <div class="mb-4 text-start">

                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" name="usuario" id="usuario" class="form-control">
                    </div>
                    <div class="mb-2 text-start">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="mt-1 text-center">
                        <button type="submit" class="btn btn-primary text-center px-5">Iniciar Sesión</button>
                    </div>

                </form>
                <div class="mt-4 small text-center">
                    <p class="m-0 text-black">Si has olvidado tu contraseña,</p>
                    <a href="mailto:admin@coffeetime.com?subject=Recuperar%20Contraseña" class="text-blue">
                        <p><strong>mándanos un correo con tu usuario y DNI</strong>.</p>
                    </a>
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
                            <a href="{{ route('informate') }}" class="text-decoration-none"><span
                                    class="small font-monospace fw-semibold">coffeetimes@gmail.com</span></a>
                        </div>
                    </div>

                </div>
            </div>
        </footer>

</body>

</html>
