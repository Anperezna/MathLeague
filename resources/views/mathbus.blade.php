<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MathBus - Math League</title>
    <link rel="stylesheet" href="{{ asset('CSS/mathbus.css') }}">
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

        <!-- Pantalla de Juego -->
        <div id="gameScreen" class="game-screen hidden">
            <div class="game-header">
                <h1><img src="{{ asset('img/MathBus.png') }}" alt=""></h1>
                <div class="operation-display" id="operationDisplay">
                    Cargando...
                </div>
                <div class="stats">
                    <div>Puntos: <span class="score" id="score">0</span></div>
                    <div>Fallos: <span class="missed" id="missed">0</span>/3</div>
                </div>
            </div>

            <div class="game-area" id="gameArea">
                <div class="bus" id="bus">
                    <div class="bus-body">
                        <img src="{{ asset('img/mathbus_game.png') }}" alt="Bus">
                    </div>
                </div>
                <div class="road"></div>
            </div>
        </div>

        <!-- Modal de Game Over -->
        <div id="gameOverModal" class="game-over-modal">
            <div class="modal-content">
                <h2>¡Fin del Juego!</h2>
                <p style="font-size: 1.5em; margin: 20px 0;">
                    Puntuación final: <span style="color: #2563eb; font-weight: bold;" id="finalScore">0</span>
                </p>
                <button class="btn" onclick="game.reset()">Volver al Menú</button>
            </div>
        </div>
    </div>
    <script src="{{ asset('JS/mathbus.js') }}"></script>
</body>

</html>
