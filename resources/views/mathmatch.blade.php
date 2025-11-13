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
        <div id="menuScreen" class="menu-screen">
            <h1><img src="{{ asset('img/MathMatch.png') }}" alt="MathMatch"></h1>
            <p style="color: white;">¡Bienvenido a MathMatch! Encuentra las parejas correctas y demuestra tus habilidades matemáticas.</p>
            <p style="color: white;">Resuelve operaciones formando pares antes de que se acabe el tiempo.</p>
            <button id="playBtn" class="btn">Jugar</button>

            <div class="instructions">
                <p>📝 Usa el ratón para seleccionar la opcion correcta hasta marcar GOL.</p>
                <p>🎯 Descompon el numero que aparezca en pantalla.</p>
            </div>
        </div>
    </div>

    <!-- Pantalla de juego (inicialmente oculta) -->
    <div id="gameScreen" class="game-screen hidden">
        <div class="full-field"></div>
        <button id="backBtn" class="btn" style="position: absolute; top: 18px; left: 18px;">Volver</button>

        <div class="game-area" id="gameArea" aria-live="polite">
            <div class="game-header">
                <div class="stats">
                    <div class="operation-display">Numero: <span id="currentNumber">--</span></div>
                    <div class="operation-display">Pasos restantes: <span id="stepsLeft">--</span></div>
                </div>
                <div class="logo-container">
                    <!-- optional small logo or scoreboard -->
                </div>
            </div>

            <div class="instructions" style="margin-top:8px; text-align:center;">
                <p style="margin-bottom:8px;">A medida que avances por el campo verás opciones aparecer en cada sector (6 zonas). Selecciona la opción correcta en la zona en la que te encuentres para seguir avanzando.</p>
            </div>

            <!-- Field split into 6 interactive zones; options will appear in the zone as the ball enters it -->
            <div id="zones" class="zones" aria-hidden="false">
                <div class="zone" data-index="0"><div class="zone-buttons"></div></div>
                <div class="zone" data-index="1"><div class="zone-buttons"></div></div>
                <div class="zone" data-index="2"><div class="zone-buttons"></div></div>
                <div class="zone" data-index="3"><div class="zone-buttons"></div></div>
                <div class="zone" data-index="4"><div class="zone-buttons"></div></div>
                <div class="zone" data-index="5"><div class="zone-buttons"></div></div>
            </div>

            <!-- ball that will move from left to right across the field -->
            <div id="ball" class="ball" role="img" aria-label="pelota"></div>

            <!-- hidden modal when goal is scored -->
            <div id="goalModal" class="game-over-modal hidden">
                <div class="modal-content">
                    <h2>¡GOL! 🎉</h2>
                    <p>Has descompuesto correctamente el número.</p>
                    <button id="playAgainBtn" class="btn" style="margin-top:12px;">Jugar otra vez</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('JS/mathmatch.js') }}"></script>
</body>
</html>
