<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Infórmate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/general.css') }}">
    <script>
        const urlContacto = "{{ route('contacto.enviar') }}";
    </script>
    <script src="{{ asset('js/informate.js') }}"></script>
    <script src="{{ asset('js/hamburguesa.js') }}"></script>
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
            <div id="formulario-contacto">
                <h2>Infórmate</h2>
                <h6 class="mt-2 mb-4 text-center">¿Tienes alguna pregunta? Escríbenos</h6>

                <form id="form-informa">
                    @csrf
                    <!-- Fecha y hora regsitrados ocultos-->
                    <input type="hidden" id="fecha_envio" name="fecha_envio">
                    <input type="hidden" id="hora_envio" name="hora_envio">
                    <div class="row mb-2 mt-2">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                placeholder="Tu nombre">
                        </div>
                        <div class="col-md-6">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos"
                                placeholder="Tus apellidos">

                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email"
                            placeholder="ejemplo@correo.com">

                    </div>

                    <div class="mb-2">
                        <label for="mensaje" class="form-label">¿Qué te interesa saber?</label>
                        <textarea class="form-control" id="mensaje" name="mensaje"
                            placeholder="Escribe tu consulta aquí (máx. 300 caracteres)"></textarea>

                    </div>

                    <div class="mt-1 text-center">
                        <button type="submit" id="btn-enviar" class="btn btn-success px-5">Enviar</button>
                    </div>

                </form>

                <div id="errormsg"></div>

            </div>
        </main>
    </div>

  <footer class="footer">
        <div class="footer-container">
            <div class="footer-row">
                <div class=" footer-telf">
                    <p class="footer-contact-text">Si quieres hacerlo a la vieja usanza, llámanos al: <a href="tel:+34615246092" class="footer-link">+34 615 246 092</a></p>
                </div>

                <div class=" footer-rrss">
                    <div class="footer-iconos">
                        <a href="#" class="footer-rrss-links"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="footer-rrss-links"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="footer-rrss-links"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class=" footer-email">
                    <div class="caja-email">
                        <i class="bi bi-envelope-fill footer-email-icon"></i>
                        <a href="{{ route('informate') }}" class="footer-email-link"><span
                                class="footer-email-text">coffeetimes@gmail.com</span></a>
                    </div>
                </div>

            </div>
        </div>
    </footer>

</body>

</html>
