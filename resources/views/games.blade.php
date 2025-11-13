@extends('plantilla.plantilla')

@section('content')
<link rel="stylesheet" href="{{ asset('CSS/games.css') }}">

<div class="stadium-wrap">
	<div class="stadium">
		{{-- campo central --}}
		<div class="field">
					{{-- Game slots positioned to match mockup --}}
					<div class="game-slot slot-a">
						<a href="{{ route('mathbus') }}" class="game-card">
							<div class="game-thumb">
								<img src="{{ asset('img/MathBus.png') }}" alt="Math Bus">
							</div>
						</a>
					</div>

					<div class="game-slot slot-b">
						<div class="game-card">
							<div class="game-thumb">
								<img src="{{ asset('img/Manolo_Cortacesped.png') }}" alt="Manolo Cortacesped">
							</div>
							<div class="lock-large" title="Bloqueado">
								<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 17a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm6-7h-1V7a5 5 0 0 0-10 0v3H6a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2zM8 7a4 4 0 0 1 8 0v3H8V7z"/></svg>
							</div>
						</div>
					</div>

					<div class="game-slot slot-c">
						<div class="game-card">
							<div class="game-thumb">
								<img src="{{ asset('img/MathMatch.png') }}" alt="Math Match">
							</div>
							<div class="lock-large" title="Bloqueado">
								<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 17a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm6-7h-1V7a5 5 0 0 0-10 0v3H6a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2zM8 7a4 4 0 0 1 8 0v3H8V7z"/></svg>
							</div>
						</div>
					</div>

					<div class="game-slot slot-d">
						<div class="game-card">
							<div class="game-thumb">
								<img src="{{ asset('img/MathEntrevista.png') }}" alt="Math Entrevista">
							</div>
							<div class="lock-large" title="Bloqueado">
								<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 17a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zm6-7h-1V7a5 5 0 0 0-10 0v3H6a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2zM8 7a4 4 0 0 1 8 0v3H8V7z"/></svg>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
@endsection
