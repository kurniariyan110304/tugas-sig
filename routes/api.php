<?php

use App\Http\Controllers\FacilityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/facilities', [FacilityController::class, 'getFacilitiesByType']);
