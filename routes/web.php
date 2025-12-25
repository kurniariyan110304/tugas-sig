<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacilityController;

Route::get('/', [FacilityController::class, 'index'])->name('home');
Route::get('/dashboard', [FacilityController::class, 'dashboard'])->name('dashboard');

Route::resource('facilities', FacilityController::class);
