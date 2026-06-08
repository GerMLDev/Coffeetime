<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    <script src="{{ asset('js/hamburguesa.js') }}"></script>
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

<body>
    <header></header>
    <div id="contenedor">
        <nav id="barranav">
            <button type="button" id="hamburguesa">&#9776;</button>

            <ul id="principal">
                <li><a href="{{ route('home') }}"><i class="bi bi-house-door-fill me-2"></i>Portada</a></li>
                <li><a class="seleccionada" href="{{ route('eventos') }}"><i class="bi bi-calendar-event-fill me-2"></i>Eventos</a></li>
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
                                </< /li>
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
            <div>
                @guest
                    <div class="alert alert-warning text-center mt-4">
                        Los eventos son solo para usuarios registrados.
                        <a href="{{ route('anadiralumno') }}" class="alert-link">¡Regístrate ahora!</a>
                    </div>
                @else
                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h2>Eventos</h2>
                        @if (auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('profesor')))
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearModal">
                                + Subir Evento
                            </button>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table id="tablaEventos" class="table table-striped" data-listar="{{ route('evento.recargar') }}"
                            data-crear="{{ route('evento.registrar') }}"
                            data-eliminar="{{ route('evento.eliminar', ':id') }}"
                            data-inscritos="{{ route('evento.inscripciones', ':id') }}"
                            data-inscribir="{{ route('evento.inscribir', ':id') }}"
                            data-cancelar="{{ route('evento.cancelar-inscripcion', ':id') }}"
                            data-csrf="{{ csrf_token() }}"
                            data-role="{{ auth()->check() && auth()->user()->role ? auth()->user()->role->rol : '' }}">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Título</th>
                                    <th>Nivel</th>
                                    <th>Estado</th>
                                    <th>Fecha y Hora</th>
                                    <th>Subido por</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    @if (auth()->check() && (auth()->user()->idrol == 1 || auth()->user()->idrol == 2))
                        <div class="modal fade" id="crearModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Subir Evento</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="evento-crear-form" method="POST" action="#">
                                            <div class="row mb-2">
                                                <div class="col-lg">
                                                    <label>Título</label>
                                                    <input type="text" id="titulo" name="titulo"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-lg">
                                                    <label>Fecha</label>
                                                    <input type="date" id="fecha" name="fecha"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-lg">
                                                    <label>Hora</label>
                                                    <input type="time" id="hora" name="hora"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-lg">
                                                    <label>Enlace (Meet/Zoom/Teams)</label>
                                                    <input type="text" id="enlace" name="enlace"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-lg">
                                                    <label>Nivel</label>
                                                    <select id="idnivel" name="idnivel" class="form-control">
                                                        @foreach ($niveles as $nivel)
                                                            <option value="{{ $nivel->id }}">{{ $nivel->nivel }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            @if (auth()->check() && auth()->user()->idrol == 1)
                                                <div class="row mb-2">
                                                    <div class="col-lg">
                                                        <label>Profesor</label>
                                                        <select id="idprofesor" name="idprofesor" class="form-control">
                                                            @foreach ($profesores as $profesor)
                                                                <option value="{{ $profesor->id }}">
                                                                    {{ $profesor->nombre_profesor }} {{ $profesor->apellidos_profesor }}
                                                                    - {{($profesor->nivel)->nivel}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="row mb-2">
                                                    <div class="col-lg">
                                                        <label>Profesor</label>
                                                        <input type="text" class="form-control"
                                                            value="{{ auth()->user()->usuario }}" readonly>
                                                    </div>
                                                </div>
                                            @endif
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-success"
                                            form="evento-crear-form">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (auth()->check() && (auth()->user()->idrol == 1 || auth()->user()->idrol == 2))
                        <div class="modal fade" id="inscritosModal" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Alumnos inscritos</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body" id="inscritosModalContent">
                                        <p>Cargando...</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endguest
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
        <script src="{{ asset('js/eventos.js') }}"></script>

</body>

</html>
