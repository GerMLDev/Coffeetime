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
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4 p-md-5 bg-light rounded">
                        <h2 class="h4 text-center titulo-pagina-azul mb-4">Alumnos por Nivel</h2>
                        <div class="d-flex flex-column flex-sm-row justify-content-between gap-2 mb-3">
                            <a href="{{ route('gestor') }}" class="btn btn-outline-secondary flex-fill">Volver al gestor</a>
                            <form action="{{ route('logout') }}" method="POST" class="m-0 flex-fill">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100">Cerrar Sesión</button>
                            </form>
                        </div>
                        <hr class="mb-4">
                        <div class="ratio ratio-16x9">
                            <canvas id="dashboard" data-panel='@json($datos)'></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
