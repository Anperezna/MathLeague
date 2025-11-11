<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('CSS/mathbus.css') }}">
    <title>@yield('title', 'MathBus - Math League')</title>
    @yield('styles')
</head>
<body>
    <div class="game-container">
        <!-- Pantalla de Menú -->
        <div id="menuScreen" class="menu-screen">
            <h1><img src="{{ asset('img/MathBus.png') }}" alt="Bus Matemático"></h1>
            <p>¡Mueve el bus con las flechas ← → para recoger las respuestas correctas!</p>
            <p>Resuelve las operaciones matemáticas y recoge el número correcto.</p>
            <button class="btn" onclick="game.start()">Iniciar Juego</button>
            <div class="instructions">
                <p>📝 Usa las teclas ← y → para mover el bus</p>
                <p>🎯 Recoge la respuesta correcta de la operación mostrada</p>
                <p>❌ El juego termina después de 3 fallos</p>
                <p>❌ Si dejas caer respuesta correcta, también cuenta como fallo</p>
            </div>
        </div>

        @yield('content')
    </div>
    
    @yield('scripts')
</body>
</html>