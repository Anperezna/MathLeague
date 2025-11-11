<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MathMatch - Math League</title>
    <link rel="stylesheet" href="{{ asset('CSS/mathmatch.css') }}">
</head>
<body>
    <div class="match-container">
        <!-- Pantalla de Menú (pre-juego) adaptada y autónoma, mantiene el estilo de la plantilla -->
        <div id="menuScreen" class="menu-screen">
            <h1><img src="{{ asset('img/MathMatch.png') }}" alt="MathMatch"></h1>
            <p>¡Bienvenido a MathMatch! Encuentra las parejas correctas y demuestra tus habilidades matemáticas.</p>
            <p>Resuelve operaciones formando pares antes de que se acabe el tiempo.</p>
            <!-- Usamos un enlace para evitar depender de la lógica JS del juego aquí -->
            <a href="{{ route('games') }}" class="btn">Ir a Juegos</a>

            <div class="instructions">
                <p>📝 Usa el ratón o el teclado para seleccionar parejas.</p>
                <p>🎯 Resuelve tantas parejas correctas como puedas.</p>
            </div>
        </div>
    </div>

    <!-- No cargamos mathbus.js aquí (evitamos lógica de juego). Mantener solo estilo. -->
</body>
</html>
