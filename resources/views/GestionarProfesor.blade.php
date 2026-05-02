<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Profesor para Editar o Eliminar</title>
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
            Profesor</h1>
        <hr>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger w-300" formaction="{{ route('logout') }}">Cerrar
                Sesión</button>
        </form>
        <form action="">
            <button type="submit" class="btn btn-outline-secondary w-300" style="float: right"
                formaction="{{ route('gestor') }}">Volver</button>
        </form>
        <hr>

        <div class="container mt-5">
            <h3 class="display-4 text-center text-dark py-3 border-bottom border-top border-dark">
                Selecciona el profesor </h3>
            <table id="tablaProfesor" class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Email</th>
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
                                <h5 class="modal-title" id="editModalLabel">Editar profesor</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="profesor-edit-form" method="POST" action="#">
                                    <div class="row">
                                        <div class="col-lg">
                                            <label>ID</label>
                                            <input type="text" id="edit-id" name="id" class="form-control" readonly>
                                               
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
                                            <label>Email</label>
                                            <input type="text" id="email_profesor" name="email_profesor"
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
                                            <label>Usuario</label>
                                            <input type="text" id="usuario_prof" name="usuario_prof"
                                                class="form-control">
                                        </div>
                                    </div> <div class="row">
                                        <div class="col-lg">
                                            <label>Contraseña</label>
                                            <input type="password" id="contraseña_prof" name="contraseña_prof"
                                                class="form-control">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success"
                                    form="profesor-edit-form">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif


            <script>
                $(document).ready(function() {
                    var tabla = new DataTable('#tablaProfesor', {
                        language: {
                            url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json'
                        },

                        "ajax": {
                            "url": "{{ route('profesor.recargar') }}",
                            "type": "GET",
                            "dataType": "json",
                            "headers": {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            "dataSrc": function(response) {
                                if (response.status === 200) {
                                    return response.profesor;
                                } else {
                                    return [];
                                }
                            }
                        },
                        "columns": [{
                            
                                "data": "id"
                            },
                             {   "data": "dni_profesor"
                            },
                            {
                                "data": "nombre_profesor"
                            },
                            {
                                "data": "apellidos_profesor"
                            },

                            {
                                "data": "email_profesor"
                            },

                            {
                                "data": null,
                                "render": function(data, type, row) {
                                    return '<a href="#" class="btn btn-sm btn-success edit-btn" data-id="'+data.id+'" data-dni_profesor="'+data.dni_profesor+'" data-nombre_profesor="'+data.nombre_profesor+'" data-apellidos_profesor="'+ data.apellidos_profesor+'" data-email_profesor="'+data.email_profesor+'" data-usuario_prof="'+data.usuario_prof+'" data-contraseña_prof="'+data.contraseña_prof+'">Editar</a> ' +'<a href="#" class="btn btn-sm btn-danger delete-btn" data-id="' +data.id + '">Borrar</a>';
                                }
                            }
                        ]
                    });
                    $('#tablaProfesor tbody').on('click', '.edit-btn', function() {
                        var id = $(this).data('id');
                        var dni_profesor = $(this).data('dni_profesor');
                        var nombre_profesor = $(this).data('nombre_profesor');
                        var apellidos_profesor = $(this).data('apellidos_profesor');
                        var email_profesor = $(this).data('email_profesor');
                        var usuario_prof = $(this).data('usuario_prof');
                        var contraseña_prof = $(this).data('contraseña_prof');

                        $('#edit-id').val(id); 
                        $('#dni_profesor').val(dni_profesor);
                        $('#nombre_profesor').val(nombre_profesor);
                        $('#apellidos_profesor').val(apellidos_profesor);
                        $('#email_profesor').val(email_profesor);
                        $('#usuario_prof').val(usuario_prof);
                        $('#contraseña_prof').val(contraseña_prof);
                        $('#editModal').modal('show');
                    });
                });
                $('#profesor-edit-form').submit(function(e) {
                    e.preventDefault();
                    const profesor = new FormData(this);

                    $.ajax({
                        url: '{{ route('profesor.editar', ":id") }}'.replace(':id',profesor.get("id")),
                        method: 'POST',
                        data: profesor,
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
                                $('#profesor-edit-form')[0].reset();
                                $('#editModal').modal('hide');
                                $('#tablaProfesor').DataTable().ajax.reload();
                            } else {
                                alert(response.message);
                            }
                        }
                    });
                });

                $(document).on('click', '.delete-btn', function() {
                    var id = $(this).data('id');
                    var row = $(this).closest('tr');

                    if (confirm('¿Estás seguro de que desea eliminar este profesor?')) {
                        $.ajax({
                            url: '{{ route('profesor.eliminar', ":id") }}'.replace(':id', id),
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
