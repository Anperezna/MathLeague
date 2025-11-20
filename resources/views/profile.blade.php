@extends('plantilla.plantilla')

@push('styles')
    <link rel="stylesheet" href="CSS/profile.css">
@endpush

@section('content')
    <div class="profile-container">
        <div class="profile-header">
            <h2 class="username">{{ session('username', 'Usuario') }}</h2>
        </div>
        
        <h1 class="stats-title">Estadísticas</h1>
        
        <div class="games-grid">
            <!-- Juego 1: Autobús -->
            <div class="game-card">
                <div class="game-image">
                    <img src="{{ asset('img/MathBus.png') }}" alt="Math Bus">
                </div>
                <div class="game-info">
                    <h3 class="game-name">El Autobús</h3>
                    <div class="game-stats">
                        <div class="stat-item">
                            <span class="stat-label">Partidas:</span>
                            <span class="stat-value">0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Mejor tiempo:</span>
                            <span class="stat-value">--:--</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Aciertos:</span>
                            <span class="stat-value">0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Errores:</span>
                            <span class="stat-value">0</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Juego 2: Paco y la Cortacésped -->
            <div class="game-card">
                <div class="game-image">
                    <img src="{{ asset('img/Manolo_Cortacesped.png') }}" alt="Paco Cortacésped">
                </div>
                <div class="game-info">
                    <h3 class="game-name">Paco y la Cortacésped</h3>
                    <div class="game-stats">
                        <div class="stat-item">
                            <span class="stat-label">Partidas:</span>
                            <span class="stat-value">0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Mejor tiempo:</span>
                            <span class="stat-value">--:--</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Aciertos:</span>
                            <span class="stat-value">0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Errores:</span>
                            <span class="stat-value">0</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Juego 3: Partido de Fútbol -->
            <div class="game-card">
                <div class="game-image">
                    <img src="{{ asset('img/MathMatch.png') }}" alt="Math Match">
                </div>
                <div class="game-info">
                    <h3 class="game-name">Partido de Fútbol</h3>
                    <div class="game-stats">
                        <div class="stat-item">
                            <span class="stat-label">Partidas:</span>
                            <span class="stat-value">0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Mejor tiempo:</span>
                            <span class="stat-value">--:--</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Aciertos:</span>
                            <span class="stat-value">0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Errores:</span>
                            <span class="stat-value">0</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Juego 4: Entrevista Postpartido -->
            <div class="game-card">
                <div class="game-image">
                    <img src="{{ asset('img/MathEntrevista.png') }}" alt="Entrevista">
                </div>
                <div class="game-info">
                    <h3 class="game-name">Entrevista Postpartido</h3>
                    <div class="game-stats">
                        <div class="stat-item">
                            <span class="stat-label">Partidas:</span>
                            <span class="stat-value">0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Mejor tiempo:</span>
                            <span class="stat-value">--:--</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Aciertos:</span>
                            <span class="stat-value">0</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">Errores:</span>
                            <span class="stat-value">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
