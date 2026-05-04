<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recursos</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/general.css') }}">
</head>

<body>
    <header>    

    </header>
    <div id="contenedor">
        <nav id="barranav">
            <ul >
                <li><a href="{{route('home')}}">Portada</a></li>
                <li><a href="{{route('eventos')}}">Eventos</a></li>
                <li><a href="{{route('recursos')}}">Recursos</a></li>
                <li><a href="{{route('informate')}}">Infórmate</a></li>
            </ul>
            <div>
                <ul>
                    <li><a href="{{route('login')}}">Inicio Sesión</a></li>
                    <li><a href="{{ route('loginalumno') }}">Registrarse</a></li>
                </ul>
            </div>
        </nav>
        <main>
            <h1>Recursos</h1>
            
        </main>
    </div>

    <footer>
        <div>
            <p>
                Este es el footer</p>
        </div>
    </footer>
</body>

</html>
