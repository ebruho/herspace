<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SessionsController;
use App\Http\Controllers\Auth\LoginController;




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

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    Route::delete('/logout', [\App\Http\Controllers\Auth\SessionsController::class, 'destroy'])
    ->name('logout');
});





Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/cities/search', [CityController::class, 'search'])->name('cities.search');