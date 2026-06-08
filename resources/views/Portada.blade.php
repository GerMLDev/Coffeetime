<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bienvenido a CoffeeTime</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/general.css') }}">
    <script src="{{ asset('js/hamburguesa.js') }}"></script>
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

<body>
    <header></header>
    <div id="contenedor">
        <nav id="barranav">
            <button type="button" id="hamburguesa">&#9776;</button>

            <ul id="principal">
                <li><a class="seleccionada" href="{{ route('home') }}"><i class=" bi bi-house-door-fill me-2"></i>Portada</a></li>
                <li><a href="{{ route('eventos') }}"><i class="bi bi-calendar-event-fill me-2"></i>Eventos</a></li>
                <li><a href="{{ route('recursos') }}"><i class="bi bi-folder-fill me-2"></i>Recursos</a></li>
                <li><a href="{{ route('informate') }}"><i class="bi bi-info-circle-fill me-2"></i>Infórmate</a></li>
            </ul>

            <div class="contenedor-desplegable">
                {{-- Si está logueado --}}
                @auth
                    <button type="button" class="btn-toggle-menu" id="hamburguesaUsuario">
                        <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->usuario }} ▾
                    </button>
                    <div id="menuUsuario" class="menu-desplegable-submenu">
                        <ul>
                            @if (auth()->user()->hasRole('admin'))
                                <li><a href="{{ route('gestor') }}"><i class="bi bi-database-fill-gear me-2"></i>Gestor de
                                        datos</a></li>
                            @elseif (auth()->user()->hasRole('profesor'))
                                <li><a href="{{ route('perfil') }}"><i class="bi bi-person-vcard-fill me-2"></i>Mi
                                        perfil</a>
                                </li>
                            @elseif (auth()->user()->hasRole('alumno'))
                                <li><a href="{{ route('perfil') }}"><i class="bi bi-person-vcard-fill me-2"></i>Mi
                                        perfil</a>
                                </li>
                                <li><a href="{{ route('eventos') }}"><i class="bi bi-calendar-check-fill me-2"></i>Mis
                                        eventos</a></li>
                            @endif
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    {{-- Si es invitado --}}
                    <div id="invitadodesktop">
                        <a href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-2"></i>Iniciar sesión</a>
                        <a href="{{ route('anadiralumno') }}"><i class="bi bi-person-plus-fill me-2"></i>Registrarse</a>
                    </div>
                    <button type="button" id="hamburguesaInvitado">
                        <i class="bi bi-person me-2"></i> Acceder
                    </button>
                    <div id="menuInvitado">
                        <ul>
                            <li><a href="{{ route('login') }}"><i class="bi bi-box-arrow-in-right me-2"></i>Iniciar
                                    sesión</a></li>
                            <li><a href="{{ route('anadiralumno') }}"><i
                                        class="bi bi-person-plus-fill me-2"></i>Registrarse</a></li>
                        </ul>
                    </div>
                @endauth
            </div>
        </nav>
        {{-- CONTENIDO PORTADA --}}
        <main>
            <div class="seccion">
                <div id="imagenportada">
                    <img src="{{ asset('images/cabecerocoffeetiime.png') }}" alt="CoffeeTime banner" class="imagen-responsive">
                </div>
                <h2>¿Quiénes somos?</h2>
                <p><strong>CoffeeTime: Let's talk! </strong>nació con una idea sencilla: practicar un idioma
                    debería ser tan natural como tomarse un café con alguien. Somos una plataforma de conversación en
                    línea donde alumnos de todos los niveles se reúnen en pequeños grupos para practicar inglés o
                    español en un ambiente relajado y sin presión. Nada de exámenes.
                </p>
                <p>Nada de deberes obligatorios. Solo
                    conversación real, guiada por un profesor-moderador que facilita el intercambio, resuelve dudas y
                    hace que cada sesión sea fluida y entretenida. Creemos que el mejor aprendizaje ocurre cuando te
                    olvidas de que estás aprendiendo. Por eso nuestros coffeetimes no son clases al uso: son encuentros
                    virtuales donde el idioma es el vehículo, y la curiosidad, el motor.</p>
            </div>
            <div class="seccion">
                <h5>Frase del día</h5>
                <div class="" id="frase-del-dia">
                    Cargando frase del día...
                </div>
            </div>
            <div class="seccion">
                <div class="imagen-portada2">
                    <img src="{{ asset('images/videollamada.webp') }}" alt="CoffeeTime logo" class="imagen-responsive">
                </div>
                <h2>¿Cómo funciona?</h2>
                <p>Participar en CoffeeTime es muy fácil. Sigue estos pasos:
                <ol>
                    <li>
                        <strong>Regístrate y completa tu perfil</strong>
                        <p>Crea tu cuenta y dinos cuál es tu nivel de idioma. Así podremos asignarte a los profesores
                            que mejor se adapten a ti.</p>
                    </li>
                    <li>
                        <strong>Explora los próximos coffeetimes</strong>
                        <p>En la sección Mis Eventos encontrarás todas las sesiones programadas para tu nivel. Cada
                            evento indica el tema de conversación, el aforo disponible y el horario.</p>
                    </li>
                    <li>
                        <strong>Reserva tu plaza</strong>
                        <p>Con un solo clic reservas tu sitio. Recibirás automáticamente un correo de confirmación con
                            todos los detalles y el enlace a la videollamada <strong>(Zoom o Google Meet)</strong>.</p>
                    </li>
                    <li>
                        <strong>Conéctate y conversa</strong>
                        <p>A la hora indicada, accede al enlace y únete al grupo. Tu profesor-moderador ya estará allí
                            esperándote para arrancar la sesión.</p>
                    </li>
                    <li>
                        <strong>Sigue practicando en casa</strong>
                        <p>En la sección Recursos encontrarás enlaces a ejercicios, fichas y vídeos adaptados a tu nivel
                            para seguir mejorando entre sesión y sesión, a tu ritmo y sin ninguna obligación.</p>
                    </li>
                </ol>
            </div>
            <div class="seccion">
                <h2>Consejos para tus inicios como <i>Coffeetimer</i></h2>
                <p>
                    Saltar a una conversación en otro idioma puede dar vértigo al principio. Estos consejos te ayudarán
                    a ganar confianza:
                <ul id="listaportada">
                    <li><i class="bi bi-chat-dots-fill icono1"></i> No busques la perfección, busca la comunicación. Los
                        errores
                        son parte del proceso. Lo importante es que el mensaje llegue, no que la gramática sea
                        impecable.</li>

                    <li><i class="bi bi-lightbulb-fill icono2"></i> Piensa en el idioma, no lo traduzcas. Intenta
                        construir las
                        frases directamente en inglés o español en lugar de traducir mentalmente desde tu lengua
                        materna. Al
                        principio cuesta, pero con la práctica se vuelve automático.</li>

                    <li><i class="bi bi-pause-circle-fill icono3"></i> Usa estrategias cuando te quedas en blanco.
                        Frases como
                        "How
                        do you say...?", "What I mean is..." o "Let me think for a moment" son herramientas válidas y
                        naturales que los hablantes nativos también usan.</li>

                    <li><i class="bi bi-ear-fill icono4"></i> Escucha activamente. Antes de responder, asegúrate de
                        haber
                        entendido
                        bien. No dudes en pedir que repitan o expliquen algo: "Could you say that again, please?" es
                        siempre
                        bienvenido.</li>

                    <li><i class="bi bi-emoji-smile-fill icono5"></i> Relájate y disfruta. La tensión bloquea. En un
                        coffeetime
                        estás entre personas con tu mismo objetivo y un moderador que te apoya. Es un espacio seguro
                        para
                        equivocarse y aprender.</li>

                    <li><i class="bi bi-calendar-check-fill icono6"></i> La constancia es la clave. Una sesión semanal
                        sostenida en
                        el tiempo vale más que una maratón de práctica puntual. ¡Reserva tu próximo coffeetime y
                        mantenlo
                        como una cita fija!</li>
                </ul>

                </p>
            </div>
        </main>
    </div>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-row">

                <div class="footer-telf">
                    <p class="footer-contact-text">Si quieres hacerlo a la vieja usanza, llámanos al: <a href="tel:+34615246092" class="footer-link">+34 615 246 092</a></p>
                </div>

                <div class="footer-rrss">
                    <div class="footer-iconos">
                        <a href="#" class="footer-rrss-links"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="footer-rrss-links"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="footer-rrss-links"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="footer-email">
                    <div class="caja-email">
                        <i class="bi bi-envelope-fill footer-email-icon"></i>
                        <a href="{{ route('informate') }}" class="footer-email-link"><span
                                class="footer-email-text">coffeetimes@gmail.com</span></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="{{ asset('js/portada.js') }}"></script>

</body>

</html>
