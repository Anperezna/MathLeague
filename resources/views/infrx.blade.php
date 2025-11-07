@extends('plantilla.plantilla')

@section('content')
    <div class="infrx-container">
        <h1 class="infrx-title">Página Infrx</h1>
        <p>Esta es la página <strong>Infrx</strong>. Puedes volver al inicio:</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Volver al inicio</a>
    </div>
@endsection
