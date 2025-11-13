<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Math League</title>
    <link rel="stylesheet" href="{{ asset('CSS/plantilla.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lilita+One&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Navegación -->
    <nav>
        <div class="logo-mobile">
            <img src="img/logo.png" alt="Math League">
        </div>
        
        <button class="hamburger" id="hamburger" aria-label="Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
        
        <div class="nav-links" id="navLinks">
            <a href="{{ route('learning') }}">Aprendizaje</a>
            <a href="{{ route('games') }}">Juegos</a>
            <div class="logo">
                <img src="img/logo.png" alt="Math League">
            </div>
            <a href="{{ route('about') }}">Sobre Nosotros</a>
            <a href="{{ route('profile') }}">Perfil</a>
        </div>
    </nav>
    
    <script>
        const hamburger = document.getElementById('hamburger');
        const navLinks = document.getElementById('navLinks');
        
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navLinks.classList.toggle('active');
        });
        
        // Cerrar menú al hacer clic en un enlace
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                navLinks.classList.remove('active');
            });
        });
    </script>

    <!-- Contenido principal -->
    <main>
        @if (Request::is('login') || Request::is('register') || Request::is('games') || Request::is('about'))
            <!-- Para login/register/games/about, no usar content-box -->
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
                <a href="#privacidad">Privacidad</a>
                <a href="#terminos">Términos</a>
            </div>

            <div class="footer-info">
                <p>&copy; 2025 Math League. Todos los derechos reservados.</p>
                <p>Aprende matemáticas de forma divertida e interactiva</p>
            </div>
        </div>
    </footer>
</body>

</html>
