<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'store'])
    ->name('login.perform');

Route::get('/register', function () {
    return view('register');
})->name('register');

// Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'store'])
//     ->name('register.perform');

Route::get('/profile', function () {
    return view('profile');
})->middleware('auth');

// Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'destroy'])
//     ->name('logout');

Route::get('/about', function () {
    return view('about');
})->name('about');