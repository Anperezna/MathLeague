<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="game-container">
        <!-- Pantalla de Menú -->
        <div id="menuScreen" class="menu-screen">
            <h1><img src="{{ asset('img/MathMatch.png') }}" alt="MathMatch"></h1>
            <p>Selecciona los resultados correctos y avanza hasta marcar un GOL!</p>
            <button class="btn" onclick="game.start()">Iniciar Juego</button>
            <div class="instructions">
                <p>📝 Selecciona la opcion correcta</p>
                <p>🎯 Recoge la respuesta correcta de la operación mostrada</p>
                <p>❌ El juego termina después de hacer un fallo</p>
            </div>
        </div>
</body>
</html>