const game = {
    started: false,
    over: false,
    score: 0,
    missed: 0,
    busPosition: 50,
    fallingItems: [],
    currentOperation: null,
    gameLoop: null,
    itemGenerator: null,
    csrfToken: null,
    scoreSaved: false, // Nueva bandera para evitar guardar dos veces
    // Nuevas propiedades para controles suaves
    keysPressed: {},
    busSpeed: 0.8, // Velocidad del bus (ajustable)

    // Inicializar token CSRF
    init() {
        const metaToken = document.querySelector('meta[name="csrf-token"]');
        this.csrfToken = metaToken ? metaToken.getAttribute('content') : '';
    },

    // Iniciar juego
    start() {
        console.log('Iniciando juego MathBus...');
        this.started = true;
        this.over = false;
        this.score = 0;
        this.missed = 0;
        this.busPosition = 50;
        this.fallingItems = [];
        this.keysPressed = {}; // Resetear teclas
        this.scoreSaved = false; // Resetear bandera de guardado
        
        document.getElementById('menuScreen').classList.add('hidden');
        document.getElementById('gameScreen').classList.remove('hidden');
        
        this.updateScore();
        this.loadOperation();
        this.setupControls();
        this.startGameLoop();
        this.startItemGenerator();
    },

    // Reiniciar juego
    async reset() {
        // Guardar puntuación si el juego terminó y no se ha guardado aún
        if (this.over && !this.scoreSaved && (this.score > 0 || this.missed > 0)) {
            await this.saveScore();
        }
        
        this.started = false;
        this.over = false;
        this.stopGameLoop();
        this.clearFallingItems();
        
        document.getElementById('gameOverModal').style.display = 'none';
        document.getElementById('gameScreen').classList.add('hidden');
        document.getElementById('menuScreen').classList.remove('hidden');
    },

    // Cargar operación desde la base de datos
    async loadOperation() {
        try {
            console.log('Cargando operación...');
            const response = await fetch('/api/game/operation');
            const data = await response.json();
            
            console.log('Respuesta del servidor:', data);
            
            if (data.success) {
                this.currentOperation = data.operacion;
                const displayText = `${data.operacion.operacion} = ?`;
                document.getElementById('operationDisplay').textContent = displayText;
                console.log('Operación cargada:', displayText, 'Respuesta correcta:', data.operacion.respuesta);
            } else {
                console.error('Error en respuesta:', data.message);
                document.getElementById('operationDisplay').textContent = 'Error cargando pregunta';
            }
        } catch (error) {
            console.error('Error cargando operación:', error);
            document.getElementById('operationDisplay').textContent = 'Error de conexión';
        }
    },

    // Configurar controles del teclado
    setupControls() {
        // Detectar cuando se presiona una tecla
        document.addEventListener('keydown', (e) => {
            if (!this.started || this.over) return;

            if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
                e.preventDefault(); // Evitar scroll de la página
                this.keysPressed[e.key] = true;
            }
        });

        // Detectar cuando se suelta una tecla
        document.addEventListener('keyup', (e) => {
            if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
                this.keysPressed[e.key] = false;
            }
        });
    },

    // Actualizar posición del bus basado en teclas presionadas
    updateBusPosition() {
        if (this.keysPressed['ArrowLeft']) {
            this.busPosition -= this.busSpeed;
        }
        if (this.keysPressed['ArrowRight']) {
            this.busPosition += this.busSpeed;
        }

        // Limitar posición del bus
        this.busPosition = Math.max(0, Math.min(90, this.busPosition));
        
        const bus = document.getElementById('bus');
        if (bus) {
            bus.style.left = `${this.busPosition}%`;
        }
    },

    // Mover el bus (método antiguo - ya no se usa directamente)
    moveBus(direction) {
        this.busPosition = Math.max(0, Math.min(90, this.busPosition + direction));
        const bus = document.getElementById('bus');
        bus.style.left = `${this.busPosition}%`;
    },

    // Iniciar el loop principal del juego
    startGameLoop() {
        this.gameLoop = setInterval(() => {
            this.updateBusPosition(); // Actualizar posición del bus continuamente
            this.updateFallingItems();
            this.checkCollisions();
        }, 16); // ~60 FPS (1000ms / 60 ≈ 16ms)
    },

    // Detener el loop del juego
    stopGameLoop() {
        if (this.gameLoop) {
            clearInterval(this.gameLoop);
            this.gameLoop = null;
        }
        if (this.itemGenerator) {
            clearInterval(this.itemGenerator);
            this.itemGenerator = null;
        }
    },

    // Generar números cayendo
    startItemGenerator() {
        // Crear 3 items iniciales
        for (let i = 0; i < 3; i++) {
            setTimeout(() => {
                this.createFallingItem();
            }, i * 1000); // Crear cada item con 1 segundo de diferencia
        }
        
        // Continuar generando items cuando sea necesario
        this.itemGenerator = setInterval(() => {
            // Solo crear un nuevo item si hay menos de 3 en pantalla
            if (this.fallingItems.length < 3) {
                this.createFallingItem();
            }
        }, 500); // Revisar cada 500ms si necesitamos crear un nuevo item
    },

    // Crear un nuevo item cayendo
    createFallingItem() {
        // Determinar el rango de números basado en la respuesta correcta
        let minValue = 1;
        let maxValue = 20;
        let value;
        
        if (this.currentOperation && this.currentOperation.respuesta) {
            const respuesta = this.currentOperation.respuesta;
            
            // 40% de probabilidad de que caiga la respuesta correcta
            if (Math.random() < 0.4) {
                value = respuesta;
            } else {
                // Si la respuesta es mayor a 20, ajustar el rango
                if (respuesta > 20) {
                    minValue = Math.max(1, respuesta - 10);
                    maxValue = respuesta + 10;
                } else {
                    minValue = 1;
                    maxValue = Math.max(20, respuesta + 10);
                }
                
                // Generar número aleatorio diferente a la respuesta
                do {
                    value = Math.floor(Math.random() * (maxValue - minValue + 1)) + minValue;
                } while (value === respuesta && Math.random() < 0.8); // 80% de evitar duplicar la respuesta
            }
        } else {
            // Si no hay operación aún, número aleatorio normal
            value = Math.floor(Math.random() * 20) + 1;
        }
        
        const item = {
            id: Date.now() + Math.random(), // Asegurar ID único
            value: value,
            position: Math.random() * 85,
            top: 0,
            element: null
        };

        const div = document.createElement('div');
        div.className = 'falling-item';
        div.textContent = item.value;
        div.style.left = `${item.position}%`;
        div.style.top = '0%';
        
        document.getElementById('gameArea').appendChild(div);
        item.element = div;
        
        this.fallingItems.push(item);
    },

    // Actualizar posición de items cayendo
    updateFallingItems() {
        this.fallingItems = this.fallingItems.filter(item => {
            item.top += 0.5; // Reducido de 2 a 0.5 para caer más lento
            
            if (item.element) {
                item.element.style.top = `${item.top}%`;
            }

            // Eliminar items que salieron de la pantalla
            if (item.top > 95) {
                // Si era la respuesta correcta y no se recogió
                if (this.currentOperation && item.value === this.currentOperation.respuesta) {
                    this.missed++;
                    this.updateScore();
                    
                    if (this.missed >= 3) {
                        this.gameOver();
                    }
                }
                
                if (item.element) {
                    item.element.remove();
                }
                return false;
            }
            
            return true;
        });
    },

    // Verificar colisiones
    checkCollisions() {
        if (!this.currentOperation) return;

        const busLeft = this.busPosition + 2; // Reducir hitbox desde la izquierda
        const busRight = this.busPosition + 10; // Reducir hitbox desde la derecha

        this.fallingItems.forEach(item => {
            const itemLeft = item.position + 1; // Ajustar centro de la pelota
            const itemRight = item.position + 7; // Ajustar centro de la pelota

            // Verificar si el item está en el rango vertical del bus
            if (item.top >= 78 && item.top <= 82) { // Rango vertical más estrecho
                // Verificar colisión horizontal
                if (itemRight >= busLeft && itemLeft <= busRight) {
                    this.handleCollision(item);
                }
            }
        });
    },

    // Manejar colisión con un item
    async handleCollision(item) {
        if (!this.currentOperation) {
            console.log('No hay operación actual');
            return;
        }

        console.log(`Colisión detectada! Pelota: ${item.value}, Respuesta correcta: ${this.currentOperation.respuesta}`);

        // Eliminar el item primero
        if (item.element) {
            item.element.remove();
        }
        this.fallingItems = this.fallingItems.filter(i => i.id !== item.id);

        // Verificar si la respuesta es correcta
        if (item.value === this.currentOperation.respuesta) {
            // Respuesta correcta
            console.log('¡Correcto! +10 puntos');
            this.score += 10;
            this.updateScore();
            
            // Cargar nueva operación
            await this.loadOperation();
        } else {
            // Respuesta incorrecta
            console.log('¡Incorrecto! +1 error');
            this.missed++;
            this.updateScore();
            
            if (this.missed >= 3) {
                console.log('Game Over - 3 errores');
                this.gameOver();
            }
        }
    },

    // Actualizar puntuación en pantalla
    updateScore() {
        document.getElementById('score').textContent = this.score;
        document.getElementById('missed').textContent = this.missed;
    },

    // Limpiar todos los items cayendo
    clearFallingItems() {
        this.fallingItems.forEach(item => {
            if (item.element) {
                item.element.remove();
            }
        });
        this.fallingItems = [];
    },

    // Game Over
    async gameOver() {
        this.over = true;
        this.stopGameLoop();
        
        document.getElementById('finalScore').textContent = this.score;
        document.getElementById('gameOverModal').style.display = 'flex';
        
        // Guardar puntuación solo si no se ha guardado antes
        if (!this.scoreSaved) {
            await this.saveScore();
        }
    },

    // Guardar puntuación en la base de datos
    async saveScore() {
        try {
            console.log('=== INICIANDO GUARDADO DE PUNTUACIÓN ===');
            console.log('Puntos:', this.score);
            console.log('Errores:', this.missed);
            console.log('CSRF Token:', this.csrfToken);
            
            const response = await fetch('/api/game/save-score', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                },
                body: JSON.stringify({
                    puntos: this.score,
                    errores: this.missed
                })
            });
            
            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);
            
            const data = await response.json();
            console.log('Response data:', data);
            
            if (data.success) {
                console.log('✅ Puntuación guardada exitosamente');
                console.log('ID Sesión:', data.id_sesion);
                this.scoreSaved = true; // Marcar como guardado
                alert('¡Puntuación guardada correctamente! ID Sesión: ' + data.id_sesion);
            } else {
                console.error('❌ Error al guardar:', data.message);
                alert('Error al guardar: ' + data.message);
            }
        } catch (error) {
            console.error('❌ Error crítico guardando puntuación:', error);
            alert('Error crítico: ' + error.message);
        }
    }
};

// Inicializar el juego al cargar la página
window.addEventListener('DOMContentLoaded', () => {
    console.log('Inicializando MathBus...');
    
    // Inicializar el token CSRF
    game.init();
    
    // Posicionar el bus
    const bus = document.getElementById('bus');
    if (bus) {
        bus.style.left = '50%';
    }
    
    console.log('MathBus listo para jugar!');
});