<?php

use App\Models\Juegos;
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

Route::get('/games', function () {
    $juegos = Juegos::orderBy('orden')->get();
    $first = $juegos->first();
    $unlocked = $first ? [$first->getKey()] : [];

    return view('games', compact('juegos', 'unlocked'));
})->name('games');

// Página simple para /infrx
Route::get('/infrx', function () {
    return view('infrx');
})->name('infrx');
