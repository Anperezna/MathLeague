@extends('plantilla.plantilla')

@push('styles')
    <link rel="stylesheet" href="CSS/index.css">
@endpush

@section('content')
    <div class="home-container">
        <h1 class="home-title">Bienvenido a Math League</h1>
        
        <div class="home-actions">
            <a href="{{ url('/login') }}" class="btn btn-play">Jugar</a>
        </div>
    </div>
@endsection