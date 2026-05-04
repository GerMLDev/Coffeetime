<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/general.css') }}">
</head>

<body>
    <header></header>
    <div id="contenedor">
        <nav id="barranav">
            <ul>
                <li><a href="{{ route('home') }}">Portada</a></li>
                <li><a href="{{ route('eventos') }}">Eventos</a></li>
                <li><a href="{{ route('recursos') }}">Recursos</a></li>
                <li><a href="{{ route('informate') }}">Infórmate</a></li>
            </ul>
            <div>
                <ul>
                    @auth
                        <li><a href="#">{{ auth()->user()->usuario }}</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="display:inline">
                                @csrf
                                <button type="submit"
                                    style="background:none;border:none;color:#fff6e7;cursor:pointer;font-size:14pt;padding:6%">Cerrar
                                    Sesión</button>
                            </form>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}">Inicio Sesión</a></li>
                        <li><a href="{{ route('loginalumno') }}">Registrarse</a></li>
                    @endauth
                </ul>
            </div>
        </nav>
        <main>
            <div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Eventos</h2>
                    @if (auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('profesor')))
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#crearModal">
                            + Subir Evento
                        </button>
                    @endif
                </div>

                <table id="tablaEventos" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Nivel</th>
                            <th>Fecha y Hora</th>
                            <th>Subido por</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>

            @if (auth()->check() && (auth()->user()->idrol == 1 || auth()->user()->idrol == 2))
                <!-- Modal Crear Evento -->
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
                                            <input type="text" id="titulo" name="titulo" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg">
                                            <label>Fecha</label>
                                            <input type="date" id="fecha" name="fecha" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg">
                                            <label>Hora</label>
                                            <input type="time" id="hora" name="hora" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg">
                                            <label>Enlace (Meet/Zoom/Teams)</label>
                                            <input type="text" id="enlace" name="enlace" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg">
                                            <label>Nivel</label>
                                            <select id="idnivel" name="idnivel" class="form-control" required>
                                                @foreach ($niveles as $nivel)
                                                    <option value="{{ $nivel->id }}">{{ $nivel->nivel }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @if (auth()->check() && auth()->user()->idrol == 1)
                                        <div class="row mb-2">
                                            <div class="col-lg">
                                                <label>Profesor</label>
                                                <select id="idprofesor" name="idprofesor" class="form-control" required>
                                                    @foreach ($profesores as $profesor)
                                                        <option value="{{ $profesor->id }}">
                                                            {{ $profesor->nombre_profesor }}
                                                            {{ $profesor->apellidos_profesor }}
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
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success" form="evento-crear-form">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </main>
    </div>
    <footer>
        <div>
            <p>Este es el footer</p>
        </div>
    </footer>

    <script>
        $(document).ready(function() {
            var tabla = new DataTable('#tablaEventos', {
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json'
                },
                ajax: {
                    url: "{{ route('evento.recargar') }}",
                    type: "GET",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataSrc: function(response) {
                        return response.status === 200 ? response.eventos : [];
                    }
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'titulo'
                    },
                    {
                        data: 'nivel'
                    },
                    {
                        data: null,
                        render: function(data) {
                            return data.fecha + ' ' + data.hora;
                        }
                    },
                    {
                        data: 'nombre_profesor'
                    },
                    {
                        data: null,
                        render: function(data) {
                            var buttons = '<a href="' + data.enlace + '" target="_blank" class="btn btn-sm btn-primary">Unirse</a> ';
                            
                            @if (auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('profesor')))
                                buttons += '<a href="#" class="btn btn-sm btn-danger delete-btn" data-id="' + data.id + '">Borrar</a>';
                            @elseif (auth()->check() && auth()->user()->hasRole('alumno'))
                                if (data.inscrito) {
                                    buttons += '<button class="btn btn-sm btn-warning cancelar-inscripcion-btn" data-id="' + data.id + '">Cancelar Inscripción</button>';
                                } else {
                                    buttons += '<button class="btn btn-sm btn-success inscribir-btn" data-id="' + data.id + '">Inscribirse</button>';
                                }
                            @endif
                            
                            return buttons;
                        }
                    }
                ]
            });

            // Crear evento
            $('#evento-crear-form').submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    url: "{{ route('evento.registrar') }}",
                    method: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.status === 200) {
                            alert(response.message);
                            $('#evento-crear-form')[0].reset();
                            $('#crearModal').modal('hide');
                            $('#tablaEventos').DataTable().ajax.reload();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            });

            // Eliminar evento
            $(document).on('click', '.delete-btn', function() {
                var id = $(this).data('id');
                var row = $(this).closest('tr');

                if (confirm('¿Estás seguro de que deseas eliminar este evento?')) {
                    $.ajax({
                        url: '{{ route('evento.eliminar', ':id') }}'.replace(':id', id),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === 200) {
                                tabla.row(row).remove().draw();
                            }
                            alert(response.mensaje);
                        },
                        error: function(xhr, status, error) {
                            alert('Error: ' + error);
                        }
                    });
                }
            });

            // Inscribirse en evento
            $(document).on('click', '.inscribir-btn', function() {
                var id = $(this).data('id');
                var btn = $(this);

                $.ajax({
                    url: '{{ route('evento.inscribir', ':id') }}'.replace(':id', id),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#tablaEventos').DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        var response = xhr.responseJSON;
                        alert(response.message || 'Error: ' + error);
                    }
                });
            });

            // Cancelar inscripción
            $(document).on('click', '.cancelar-inscripcion-btn', function() {
                var id = $(this).data('id');

                if (confirm('¿Estás seguro de que deseas cancelar tu inscripción?')) {
                    $.ajax({
                        url: '{{ route('evento.cancelar-inscripcion', ':id') }}'.replace(':id', id),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            alert(response.message);
                            $('#tablaEventos').DataTable().ajax.reload();
                        },
                        error: function(xhr, status, error) {
                            var response = xhr.responseJSON;
                            alert(response.message || 'Error: ' + error);
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
