<?php

use Illuminate\Support\Facades\Route;
use App\Models\Juegos;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/index', function () {
    return view('index');
})->name('index');


Route::get('/games', function () {
    $juegos = Juegos::orderBy('orden')->get();

    // Demo: desbloquear solo el primer juego. Reemplaza por la lógica real de tu app.
    $first = $juegos->first();
    $unlocked = $first ? [$first->getKey()] : [];

    return view('games', compact('juegos', 'unlocked'));
})->name('games');
