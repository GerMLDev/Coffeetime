<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Usuario </title>
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
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-md-5 bg-light rounded">
                        <h1 class="text-center titulo-pagina-amarillo">Gestionar Usuario</h1>
                        <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 mb-3">

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
        <div class="table-responsive mt-4">
            <h3 class="display-4 text-center text-dark py-3 border-bottom border-top border-dark">
                Selecciona el usuario
            </h3>
            <table id="tablaUsuario" class="table table-striped" data-listar="{{ route('usuario.recargar') }}"
                data-editar="{{ route('usuario.editar', ':id') }}"
                data-actualizar="{{ route('usuario.actualizar', ':id') }}"
                data-eliminar="{{ route('usuario.eliminar', ':id') }}" data-csrf="{{ csrf_token() }}">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Roles</th>
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
                                <h5 class="modal-title" id="editModalLabel">Editar usuario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="usuario-edit-form" method="POST" action="#">
                                    <input type="hidden" id="edit-id" name="id" class="form-control" readonly>

                                    <div class="row">
                                        <div class="col-lg">
                                            <label>Usuario</label>
                                            <input type="text" id="usuario" name="usuario" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg">
                                            <label for="contraseña">Contraseña</label>
                                            <input type="password" id="contraseña" name="contraseña"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg">
                                            <label>DNI</label>
                                            <input type="text" id="dni" name="dni" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg">
                                            <label>Email</label>
                                            <input type="email" id="email" name="email" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg">
                                            <label for="rol">Rol</label>
                                            <select name="rol" id="rol" class="form-control">
                                            </select>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success" form="usuario-edit-form">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/gestionarUsuario.js') }}"></script>
</body>

</html>
