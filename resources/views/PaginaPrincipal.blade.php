<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bienvenido a CoffeeTime</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/general.css') }}">
</head>

<body>
    <header>    
    </header>
    <div id="contenedor">
        <nav>
            <ul id="barranav">
                <li><a href="{{route('general')}}">Inicio</a></li>
                {{-- <li><a href="{{route('eventos')}}">Eventos</a></li>
                <li><a href="{{route('recursos')}}">Recursos</a></li>
                <li><a href="{{route('informate')}}">Infórmate</a></li> --}}
            </ul>
            <div>
                <ul>
                    <li><a href="{{route('login')}}">Inicio Sesión</a></li>
                    <li><a href="{{ route('loginalumno') }}">Registrarse</a></li>
                </ul>
            </div>
        </nav>
        <main>
            
            <div>
                <p><strong>DIV 1:</strong>In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet.  </p>
            </div>
            <div>
                <p><strong>DIV 2:</strong> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. </p>
            </div>
            <div>
                <p><strong>DIV 3:</strong> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. </p>
            </div>
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
