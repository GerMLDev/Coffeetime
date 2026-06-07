<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos por Profesor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/general.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <h2 class="text-center titulo-pagina-azul-oscuro">Alumnos por Profesor</h2>
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
        @if (auth()->user()->hasRole('admin'))
            <div class="container mt-5 d-flex justify-content-center">
                <canvas id="dashboard" class="d-flex justify-content-center w-50 h-50" data-panel='@json($datos)'></canvas>
            </div>
            <script src="{{ asset('js/dashboardProfe.js') }}"></script>
        @elseif (auth()->user()->hasRole('profesor'))

        <h4 class="mb-3 text-secondary">Mis Alumnos Asignados</h4>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>DNI</th>
                        <th class="text-center">ID Nivel</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($misAlumnos as $alumno)
                        <tr>
                            <td>{{ $alumno->nombre }} {{ $alumno->apellidos }}</td>
                            <td>{{ $alumno->email }}</td>
                            <td>{{ $alumno->dni }}</td>
                            <td class="text-center">{{ $alumno->idnivel }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No tienes alumnos asignados actualmente.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @endif
    </div>


    <script>
     var datos = @json($datos);

        new Chart(document.getElementById('dashboard'), {
            type: 'bar',
            data: {
                labels: datos.map(row => `Profesor: ${row.PROFESOR}`),
                datasets: [{
                    label: 'Cantidad de Alumnos',
                    data: datos.map(row => row.cantidad),
                    backgroundColor: ['red', 'blue', 'green', 'yellow']
                }]
            }
        });
    </script>

</body>

</html>
