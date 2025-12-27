<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [FacilityController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.process');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [FacilityController::class, 'dashboard'])
        ->name('dashboard');
    Route::resource('facilities', FacilityController::class);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
