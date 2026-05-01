<div>
    <!-- Be present above all else. - Naval Ravikant -->
</div>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos por Profesor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-dark">
    <div class="container mt-5 bg-light p-4 rounded shadow" width="70%">
        <h2 class="text-center" style="color: white; background-color: rgb(61, 0, 94); padding: 10px;">Alumnos por Profesor</h2>
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
        <div class="container mt-5 d-flex justify-content-center">
            <canvas id="dashboard" class="d-flex justify-content-center w-50 h-50"></canvas>

                <script>
                    var datos = {!! json_encode($datos) !!};

                    new Chart(document.getElementById('dashboard'), {
                        type: 'doughnut',
                        data: {
                            labels: datos.map(row => `Profesor ${row.PROFESOR}`),
                            datasets: [{
                                label: 'Cantidad de Alumnos',
                                data: datos.map(row => row.cantidad),
                                backgroundColor: ['red', 'blue', 'green', 'yellow']
                            }]
                        }
                    });
                </script>

        </div>
    </div>



   
</body>
</html>
