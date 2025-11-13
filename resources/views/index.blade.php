@extends('plantilla.plantilla')

@push('styles')
    <link rel="stylesheet" href="CSS/index.css">
@endpush

@section('content')
    <div class="index-container">
        <div class="story-wrapper">
            <div class="story-text">
                <h1>Math League</h1>
                <p>
                    Bienvenido a Math League, donde las matemáticas y el fútbol se unen en una experiencia única. 
                    Como entrenador, vivirás un día de partido completo resolviendo operaciones matemáticas en cada etapa.
                </p>
                <p>
                    Recogerás a tus jugadores en el autobús identificando sus números de camiseta mediante cálculos. 
                    Ayudarás a Paco a preparar el campo con la cortacésped siguiendo patrones matemáticos. 
                    Jugarás el partido donde cada jugada depende de resolver operaciones bajo presión. 
                    Y finalmente, responderás a la prensa analizando las estadísticas del encuentro.
                </p>
                <p>
                    ¿Estás listo para liderar al Math League? La liga donde los números ganan partidos te espera.
                </p>
                <a href="{{ route('games') }}" class="play-button">¡Comenzar!</a>
            </div>
            <div class="logo-container">
                <img src="{{ asset('img/logo.png') }}" alt="Math League Logo" class="logo">
            </div>
        </div>
    </div>
@endsection