<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Usuario </title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>

    @if (session('success'))
        <script>
            alert("{{ session('success') }}");
        </script>
    @endif
</head>

<body class="bg-dark">
    <div class="container mt-5 bg-light p-4 rounded shadow" width="70%">
        <h1 class="text-center" style="color: white; background-color: rgb(195, 146, 0); padding: 10px;">Gestionar
            Usuario</h1>
        <hr>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-300" formaction="{{ route('logout') }}">Cerrar
                Sesión</button>
        </form>
        <form action="">
            <button type="submit" class="btn btn-outline-secondary w-300" style="float: right"
                formaction="{{ route('inicio') }}">Volver</button>
        </form>
        <hr>
        <div class="container mt-5">
            <h3 class="display-4 text-center text-dark py-3 border-bottom border-top border-dark">
                Selecciona el usuario
            </h3>
            <table id="tablaUsuario" class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
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

            <script>
                $(document).ready(function() {
                    var tabla = new DataTable('#tablaUsuario', {
                        language: {
                            url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json'
                        },

                        "ajax": {
                            "url": "{{ route('usuario.recargar') }}",
                            "type": "GET",
                            "dataType": "json",
                            "headers": {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            "dataSrc": function(response) {
                                if (response.status === 200) {
                                    return response.usuario;
                                } else {
                                    return [];
                                }
                            }
                        },
                        "columns": [{
                                "data": "id"
                            },
                            {
                                "data": "usuario"
                            },
                            {
                                "data": "email"
                            },
                            {
                                "data": "role.rol"
                            },
                            {
                                "data": null,
                                "render": function(data, type, row) {
                                    return '<a href="#" class="btn btn-sm btn-success edit-btn" data-id="'+data.id+'" data-email = "'+data.email+'"data-usuario = "' +data.usuario+'" data-contraseña = "'+data.contraseña+'" data-dni="'+data.dni+'" data-role.rol="'+data.role.rol+'">Edit</a> ' +
                                        '<a href="#" class="btn btn-sm btn-danger delete-btn" data-id="' +
                                        data.id + '">Delete</a>';
                                }
                            }
                        ]
                    });
                });
                $('#tablaUsuario').on('click', '.edit-btn', function() {
                    var id = $(this).data('id');

                    $.ajax({
                        url: '{{ route('usuario.editar', ':id') }}'.replace(':id', id),
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 200) {

                                var usuario = response.usuario;
                                var roles = response.roles;

                                $('#edit-id').val(usuario.id);
                                $('#usuario').val(usuario.usuario);
                                $('#contraseña').val(usuario.contraseña);
                                $('#email').val(usuario.email);
                                $('#dni').val(usuario.dni);


                                $('#rol').empty();
                                roles.forEach(function(rol) {
                                    $('#rol').append(new Option(rol.rol,rol.id));
                                });
                                $('#rol').val(usuario.idrol);


                                $('#editModal').modal('show');
                            } else {
                                alert(response.message);
                            }
                        }
                    });
                });
                $('#usuario-edit-form').submit(function(e) {
                    e.preventDefault();
                    var id = $('#edit-id').val();
                    const usuario = new FormData(this);
                    $.ajax({
                        url: '{{ route('usuario.actualizar', ':id') }}'.replace(':id', id),
                        method: 'POST',
                        data: usuario,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status === 200) {
                                alert(response.message);
                                $('#usuario-edit-form')[0].reset();
                                $('#editModal').modal('hide');
                                $('#tablaUsuario').DataTable().ajax.reload();
                            } else {
                                alert(response.message);
                            }
                        }
                    });
                });

                $(document).on('click', '.delete-btn', function() {
                    var id = $(this).data('id');
                    var row = $(this).closest('tr');

                    if (confirm('¿Estás seguro de que desea eliminar este usuario?')) {
                        $.ajax({
                            url: '{{ route('usuario.eliminar', ':id') }}'.replace(':id', id),
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.status === 200) {
                                    row.remove().draw(); // Reload the table data
                                }

                                alert(response.mensaje); // Show success message
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr); // Debugging: log the error
                                alert('Error: ' + error); // Show generic error message
                            }
                        });
                    }
                });
            </script>

        </div>
    </div>

</body>

</html>
