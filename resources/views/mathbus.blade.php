@extends('plantilla.previous')

@section('title', 'MathBus - Math League')

@section('content')
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
                        <a href="{{ route('games') }}" class="boton-volver-link">
                            <img src="{{ asset('img/back.png') }}" class="boton-volver" alt="Volver">
                        </a>
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
@endsection

@section('scripts')
    <script src="{{ asset('JS/mathbus.js') }}"></script>
@endsection
