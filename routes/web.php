<?php

use App\Models\Juegos;
use App\Http\Controllers\JuegosController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/index', function () {
    return view('index');
})->name('index');

Route::get('/register', function () {
    return view('login'); // Redirige a la misma vista de login
})->name('register');

Route::get('/learning', function () {
    return view('learning');
})->name('learning');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/mathbus', function () {
    return view('mathbus');
})->name('mathbus');

Route::get('/mathmatch', function () {
    return view('mathmatch');
})->name('mathmatch');

// Rutas API para el juego MathBus
Route::prefix('api/game')->group(function () {
    Route::get('/operation', [JuegosController::class, 'getOperation']);
    Route::post('/check-answer', [JuegosController::class, 'checkAnswer']);
    Route::post('/save-score', [JuegosController::class, 'saveScore']);
    Route::get('/high-scores', [JuegosController::class, 'getHighScores']);
});

Route::get('/games', function () {
    $juegos = Juegos::orderBy('orden')->get();
    $first = $juegos->first();
    $unlocked = $first ? [$first->getKey()] : [];

    return view('games', compact('juegos', 'unlocked'));
})->name('games');

