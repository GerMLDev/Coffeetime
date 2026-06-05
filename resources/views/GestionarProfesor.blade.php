<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Profesor para Editar o Eliminar</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
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
    <div class="container mt-5 bg-light p-4 rounded shadow contenedor-formulario">
        <h1 class="text-center titulo-pagina-amarillo">Gestionar Profesor</h1>
        <div class="d-flex justify-content-between align-items-center mb-3">

            <a href="{{ route('gestor') }}" class="btn btn-outline-secondary">
                Volver al gestor
            </a>

            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-outline-danger">
                    Cerrar Sesión
                </button>
            </form>

        </div>
        <hr>

        <div class="container mt-5">
            <h3 class="display-4 text-center text-dark py-3 border-bottom border-top border-dark">
                Selecciona el profesor </h3>
            <table id="tablaProfesor" class="table table-striped" data-niveles='@json($niveles)'
                data-listar="{{ route('profesor.recargar') }}" data-editar="{{ route('profesor.editar', ':id') }}"
                data-actualizar="{{ route('profesor.actualizar', ':id') }}"
                data-eliminar="{{ route('profesor.eliminar', ':id') }}" data-csrf="{{ csrf_token() }}">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>DNI</th>
                        <th>Email</th>
                        <th>Nivel</th>

                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            @if (auth()->user()->hasRole('admin'))
                <!-- Modal para editar -->
                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Editar profesor</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="profesor-edit-form" method="POST" action="#">
                                    <div class="row">
                                        <div class="col-lg">
                                            <label>ID</label>
                                            <input type="text" id="edit-id" name="id" class="form-control"
                                                readonly>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg">
                                            <label>Nombre</label>
                                            <input type="text" id="nombre_profesor" name="nombre_profesor"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg">
                                            <label>Apellidos</label>
                                            <input type="text" id="apellidos_profesor" name="apellidos_profesor"
                                                class="form-control">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg">
                                            <label>DNI</label>
                                            <input type="text" id="dni_profesor" name="dni_profesor"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg">
                                            <label>Email</label>
                                            <input type="text" id="email_profesor" name="email_profesor"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg">
                                            <label>Nivel</label>
                                            <select name="nivel" id="nivel" class="form-control"></select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg">
                                            <label>Usuario</label>
                                            <input type="text" id="usuario_prof" name="usuario_prof"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg">
                                            <label>Contraseña</label>
                                            <input type="password" id="contrasena_prof" name="contrasena_prof"
                                                class="form-control">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success"
                                    form="profesor-edit-form">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <script src="{{ asset('js/gestionarProfesor.js') }}"></script>
</body>

</html>
