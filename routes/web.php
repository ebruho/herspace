<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SessionsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;



Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => view('login'))->name('login');

    Route::post('/login', [LoginController::class, 'store'])->name('login.perform');

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.perform');
});

Route::middleware('auth')->group(function () {

    // HOME FEED
    Route::get('/', [PostController::class, 'index'])->name('home');

    // POSTS
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // PROFILE
    Route::get('/profile/{username?}', [ProfileController::class, 'show'])->name('profile');

    // LOGOUT
    Route::delete('/logout', [SessionsController::class, 'destroy'])->name('logout');

    // Likes
    Route::post('/posts/{post}/like', [LikeController::class, 'togglePost'])->name('posts.like');

    // Comments
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/posts/{post}/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('/comments/{comment}/like', [LikeController::class, 'toggleComment'])->name('comments.like');


    // Single post page
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

});

Route::get('/cities/search', [CityController::class, 'search'])->name('cities.search');
Route::get('/about', fn () => view('about'))->name('about');


// Route::get('/welcome', function () {
//     return view('welcome');
// });

// Route::middleware('guest')->group(function () {
//     Route::get('/login', function () {
//         return view('login');
//     })->name('login');

//     Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'store'])
//         ->name('login.perform');

//     Route::get('/register', [RegisterController::class, 'create'])
//         ->name('register');

//     Route::post('/register', [RegisterController::class, 'store'])
//         ->name('register.perform');
// });

// Route::middleware('auth')->group(function () {
//     Route::get('/', function () {
//         return view('home');
//     })->name('home');

//     Route::post('/posts', [\App\Http\Controllers\PostController::class, 'store'])->name('posts.store');

//     Route::get('/', [PostController::class, 'index'])->name('home');

//     Route::get('/profile/{username?}', [ProfileController::class, 'show'])
//         ->name('profile');

//     Route::delete('/logout', [\App\Http\Controllers\Auth\SessionsController::class, 'destroy'])
//     ->name('logout');

//     Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
//     ->name('posts.edit');

//     Route::put('/posts/{post}', [PostController::class, 'update'])
//         ->name('posts.update');

//     Route::delete('/posts/{post}', [PostController::class, 'destroy'])
//         ->name('posts.destroy');
// });





// Route::get('/about', function () {
//     return view('about');
// })->name('about');

// Route::get('/cities/search', [CityController::class, 'search'])->name('cities.search');

?>