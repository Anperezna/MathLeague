<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Math League</title>
    <link rel="stylesheet" href="CSS/plantilla.css">
</head>

<body>
    <!-- Navegación -->
    <nav>
        <div class="nav-links">
            <a href="#aprendizaje">Aprendizaje</a>
            <a href="#juegos">Juegos</a>
            <div class="logo">
                <img src="img/logo.png" alt="Math League">
            </div>
            <a href="#sobre-nosotros">Sobre Nosotros</a>
            <a href="#perfil">Perfil</a>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main>
        @if(Request::is('login') || Request::is('register'))
            <!-- Para login/register, no usar content-box -->
            @yield('content')
        @else
            <!-- Para otras páginas, usar content-box -->
            <div class="content-box">
                @yield('content')
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-links">
                <a href="#aprendizaje">Aprendizaje</a>
                <a href="#juegos">Juegos</a>
                <a href="#sobre-nosotros">Sobre Nosotros</a>
                <a href="#perfil">Perfil</a>
                <a href="#contacto">Contacto</a>
                <a href="#privacidad">Privacidad</a>
                <a href="#terminos">Términos</a>
            </div>

            <div class="footer-social">
                <div class="social-icon">f</div>
                <div class="social-icon">t</div>
                <div class="social-icon">i</div>
                <div class="social-icon">y</div>
            </div>

            <div class="footer-info">
                <p>&copy; 2025 Math League. Todos los derechos reservados.</p>
                <p>Aprende matemáticas de forma divertida e interactiva</p>
            </div>
        </div>
    </footer>
</body>

</html>