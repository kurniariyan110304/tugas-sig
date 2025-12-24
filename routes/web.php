<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FacilityController;

Route::get('/', [FacilityController::class, 'index'])->name('home');

Route::resource('facilities', FacilityController::class);

Route::get('/api/facilities', [FacilityController::class, 'getFacilitiesJson']);
Route::get('/api/facilities/{type}', [FacilityController::class, 'getFacilitiesByType']);