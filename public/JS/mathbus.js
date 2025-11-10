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
        
        document.getElementById('menuScreen').classList.add('hidden');
        document.getElementById('gameScreen').classList.remove('hidden');
        
        this.updateScore();
        this.loadOperation();
        this.setupControls();
        this.startGameLoop();
        this.startItemGenerator();
    },

    // Reiniciar juego
    reset() {
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
            const response = await fetch('/api/game/operation');
            const data = await response.json();
            
            if (data.success) {
                this.currentOperation = data.operacion;
                document.getElementById('operationDisplay').textContent = 
                    `${data.operacion.operacion} = ?`;
            }
        } catch (error) {
            console.error('Error cargando operación:', error);
        }
    },

    // Configurar controles del teclado
    setupControls() {
        document.addEventListener('keydown', (e) => {
            if (!this.started || this.over) return;

            if (e.key === 'ArrowLeft') {
                this.moveBus(-5);
            } else if (e.key === 'ArrowRight') {
                this.moveBus(5);
            }
        });
    },

    // Mover el bus
    moveBus(direction) {
        this.busPosition = Math.max(0, Math.min(90, this.busPosition + direction));
        const bus = document.getElementById('bus');
        bus.style.left = `${this.busPosition}%`;
    },

    // Iniciar el loop principal del juego
    startGameLoop() {
        this.gameLoop = setInterval(() => {
            this.updateFallingItems();
            this.checkCollisions();
        }, 50);
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
        this.itemGenerator = setInterval(() => {
            this.createFallingItem();
        }, 2000);
    },

    // Crear un nuevo item cayendo
    createFallingItem() {
        const item = {
            id: Date.now(),
            value: Math.floor(Math.random() * 20) + 1,
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
            item.top += 2;
            
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

        const busLeft = this.busPosition;
        const busRight = this.busPosition + 10;

        this.fallingItems.forEach(item => {
            const itemLeft = item.position;
            const itemRight = item.position + 8;

            // Verificar si el item está en el rango vertical del bus
            if (item.top >= 75 && item.top <= 85) {
                // Verificar colisión horizontal
                if (itemRight >= busLeft && itemLeft <= busRight) {
                    this.handleCollision(item);
                }
            }
        });
    },

    // Manejar colisión con un item
    async handleCollision(item) {
        if (!this.currentOperation) return;

        // Verificar si la respuesta es correcta
        if (item.value === this.currentOperation.respuesta) {
            this.score += 10;
            this.updateScore();
            
            // Eliminar el item
            if (item.element) {
                item.element.remove();
            }
            this.fallingItems = this.fallingItems.filter(i => i.id !== item.id);
            
            // Cargar nueva operación
            await this.loadOperation();
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
        
        // Guardar puntuación
        await this.saveScore();
    },

    // Guardar puntuación en la base de datos
    async saveScore() {
        try {
            await fetch('/api/game/save-score', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.csrfToken
                },
                body: JSON.stringify({
                    jugador: 'Jugador',
                    puntos: this.score
                })
            });
        } catch (error) {
            console.error('Error guardando puntuación:', error);
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