<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'store'])
        ->name('login.perform');

    Route::get('/register', [RegisterController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisterController::class, 'store'])
        ->name('register.perform');
});

Route::get('/profile', function () {
    return view('profile');
})->middleware('auth');

// Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'destroy'])
//     ->name('logout');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/cities/search', [CityController::class, 'search']);