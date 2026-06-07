<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mi perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
                    <div id="invitadodesktop">
                        <a href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-1"></i>Iniciar sesión</a>
                        <a href="{{ route('anadiralumno') }}"><i class="bi bi-person-plus-fill me-1"></i>Registrarse</a>
                    </div>
                    <button type="button" id="hamburguesaInvitado">
                        <i class="bi bi-person me-1"></i> Acceder ▾
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
            <div class="container mt-4">
                <h2><i class="bi bi-person-vcard-fill me-2"></i>Mi perfil</h2>
                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"><strong>Datos actuales</strong></div>
                            <div class="card-body">

                                @if (!$perfil)
                                    <div class="alert alert-warning">
                                        No se encontró el perfil asociado a este usuario.
                                    </div>
                                @elseif(auth()->user()->hasRole('alumno'))
                                    <p><i class="bi bi-person me-2"></i><strong>Nombre:</strong> {{ $perfil->nombre }}
                                        {{ $perfil->apellidos }}</p>
                                    <p><i class="bi bi-envelope me-2"></i><strong>Email:</strong> {{ $perfil->email }}
                                    </p>
                                    <p><i class="bi bi-card-text me-2"></i><strong>DNI:</strong> {{ $perfil->dni }}
                                    </p>
                                    <p><i class="bi bi-person-badge me-2"></i><strong>Usuario:</strong>
                                        {{ $perfil->usuario }}</p>
                                    <p><i class="bi bi-bar-chart-steps me-2"></i><strong>Nivel:</strong>
                                        {{ $perfil->nivel->nivel ?? '—' }}</p>
                                    <p><i class="bi bi-person-workspace me-2"></i><strong>Profesor:</strong>
                                        {{ $perfil->profe->nombre_profesor ?? '' }}
                                        {{ $perfil->profe->apellidos_profesor ?? '—' }}
                                    </p>
                                @elseif(auth()->user()->hasRole('profesor'))
                                    <p><i class="bi bi-person me-2"></i><strong>Nombre:</strong>
                                        {{ $perfil->nombre_profesor }} {{ $perfil->apellidos_profesor }}</p>
                                    <p><i class="bi bi-envelope me-2"></i><strong>Email:</strong>
                                        {{ $perfil->email_profesor }}</p>
                                    <p><i class="bi bi-card-text me-2"></i><strong>DNI:</strong>
                                        {{ $perfil->dni_profesor }}</p>
                                    <p><i class="bi bi-person-badge me-2"></i><strong>Usuario:</strong>
                                        {{ $perfil->usuario_prof }}</p>
                                    <p><i class="bi bi-bar-chart-steps me-2"></i><strong>Nivel:</strong>
                                        {{ $perfil->nivel->nivel ?? '—' }}</p>
                                @endif

                            </div>
                            <div class="card-footer d-flex justify-content-center">
                                <button class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="bi bi-pencil-fill me-1"></i> Editar mis datos
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal para editar perfiles    --}}
                <div class="modal fade" id="editModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title"><i class="bi bi-pencil-fill me-2"></i>Editar mis datos</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <form id="perfil-edit-form" data-guardar="{{ route('perfil.actualizar') }}">
                                    @csrf
                                    {{-- ALUMNO --}}
                                    @if (auth()->user()->hasRole('alumno'))
                                        <div class="row mb-2">
                                            <div class="col-lg">
                                                <label>Nombre</label>
                                                <input type="text" name="nombre" class="form-control"
                                                    value="{{ $perfil->nombre }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-lg">
                                                <label>Apellidos</label>
                                                <input type="text" name="apellidos" class="form-control"
                                                    value="{{ $perfil->apellidos }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-lg">
                                                <label>Email</label>
                                                <input type="email" name="email" class="form-control"
                                                    value="{{ $perfil->email }}">
                                            </div>
                                        </div>

                                        {{-- PROFESOR --}}
                                    @elseif(auth()->user()->hasRole('profesor'))
                                        <div class="row mb-2">
                                            <div class="col-lg">
                                                <label>Nombre</label>
                                                <input type="text" name="nombre_profesor" class="form-control"
                                                    value="{{ $perfil->nombre_profesor }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-lg">
                                                <label>Apellidos</label>
                                                <input type="text" name="apellidos_profesor" class="form-control"
                                                    value="{{ $perfil->apellidos_profesor }}">
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-lg">
                                                <label>Email</label>
                                                <input type="email" name="email" class="form-control"
                                                    value="{{ $perfil->email_profesor }}">
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Contraseña --}}
                                    <div class="row mb-2">
                                        <div class="col-lg">
                                            <label>Nueva contraseña</label>
                                            <input type="password" name="contraseña" class="form-control"
                                                placeholder="Dejar en blanco para no cambiarla">
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success" form="perfil-edit-form">
                                    <i class="bi bi-floppy-fill me-1"></i> Guardar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

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
    <script src="{{ asset('js/perfil.js') }}"></script>

</body>

</html>
