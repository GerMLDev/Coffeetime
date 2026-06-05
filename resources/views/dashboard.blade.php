<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos por Nivel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <h2 class="text-center titulo-pagina-azul">Alumnos por Nivel</h2>
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
        <div class="container mt-5 d-flex justify-content-center">
            <canvas id="dashboard" class="d-flex justify-content-center w-50 h-50" data-panel='@json($datos)'></canvas>
            <script src="{{ asset('js/dashboard.js') }}"></script>
        </div>
    </div>




</body>
</html>
