@extends('plantilla.plantilla')
<link rel="stylesheet" href="{{ asset('CSS/about.css') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

@section('content')
<div id="container">
    <div class="profiles">
        <div class="profile-card">
            <img src="{{ asset('img/albert.jpg') }}" alt="Albert Canovas">
            <h3>Albert Canovas</h3>
            <p>Desarrollador Frontend</p>
            <p>Apasionada por el diseño y la innovación, lidera cada proyecto con una visión única que combina estética y funcionalidad.</p>
        </div>
    </div>

    <div class="profiles">
        <div class="profile-card">
            <img src="{{ asset('img/angel.png') }}" alt="Ángel Pérez">
            <h3>Ángel Pérez</h3>
            <p>Desarrollador Frontend</p>
            <p>Apasionado por el diseño y la innovación, lidera cada proyecto con una visión única que combina estética y funcionalidad.</p>
        </div>
    </div>

    <div class="profiles">
        <div class="profile-card">
            <img src="{{ asset('img/dani.jpg') }}" alt="Dani Barrufet">
            <h3>Dani Barrufet</h3>
            <p>Desarrollador Frontend</p>
            <p>Especialista en tecnología y programación, convierte ideas en experiencias digitales eficientes y atractivas.</p>
        </div>
    </div>

    <div class="profiles">
        <div class="profile-card">
            <img src="{{ asset('img/ivory.jpg') }}" alt="Ivory Dipasupil">
            <h3>Ivory Dipasupil</h3>
            <p>Desarrolladora Frontend</p>
            <p>Experta en comunicación y marca, crea estrategias que conectan a las personas con los valores de la empresa.</p>
        </div>
    </div>
</div>
@endsection